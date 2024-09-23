<?php 
# Call in main template
echo $this->extend('layouts/default');

# Meta title Section 
echo $this->section('heading');
echo $title;
echo $this->endSection();

echo $this->section('sidebar'); 

echo $this->endSection();

# Main Content
echo $this->section('content'); 

$this->db = db_connect();
?>

<!--begin::Post-->
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div class="container-xxl">
        <!--begin::Products-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                      <form method="post" action="">
                        <input type="hidden" name="t" value="<?php echo $Team; ?>">
                        <input type="date" name="s" value="<?php echo $startDate; ?>"required>
                        <input type="date" name="e"value="<?php echo $endDate; ?>"required>
                        <button type="submit">View</button>                         
                      </form>
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
        <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th>Date</th>
                        <th>Expected</th>
                        <th>Output</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <?php

                    #Identify day of week
                    function isWeekend($date) {
                        return (date('N', strtotime($date)) >= 6);
                    }

                    #Running Total;
                    $Total = 0;

                    foreach ($outputs as $output) {

                    $Date = $output['date'];
                    $Weekend = isWeekend($Date);
                    $Colour = NULL;
                    $OverTime = NULL;
                    
                    if($Weekend == '1') {
                        $Colour = 'style="background-color: #edf2fa;"';
                        $OverTime = " - Weekend";
                    } 
                    
                    $Total += $output['daily_output']; 
                    
                    /* Attempt to output list of usints worked on but cant get to work at this time.
                    #Get list of products
                    $query = $this->db->query("SELECT p_number FROM progress WHERE date = '$Date' AND Team ='Team' ORDER BY unique_key DESC");
                    $row = $query->row();
                    $UnitsWorked = $row->p_number : null;
                    print_r($UnitsWorked);
                    */ 

                    ?>
                      <tr <?php echo $Colour;?>>
                        <td class="align-middle"><a href="<?= url_to('Production::viewTeamDailyOutput')."/?t=".$output['team']."&d=".$output['date'];?>"><?php echo $output['date'];?></td>
                        <td class="align-middle"><?= $output['expected']; ?></td>
                        <td class="align-middle"><?= $output['daily_output']; ?></td>
                      </tr>
                    <?php } ?>

                    <tr>
                        <td colspan="2">Average <?php echo count($outputs);?> Days</td>
                        <td><?php 
                        if($Total > 0) {
                          echo $Total / count($outputs);
                        }
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Total For Period</td>
                        <td><?php echo $Total;?></td>
                    </tr>
                  </tbody>
                </table>

                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Products-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->



<?php 

echo $this->endSection();