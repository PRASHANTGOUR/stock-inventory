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
                          <label for="StartDate">Start Date: </label>
                          <input type="date" name="StartDate" value="<?php echo $StartDate;?>" required><br />
                          <label for="EndDate">End Date: </label>
                          <input type="date" name="EndDate" value="<?php echo $EndDate;?>" required><br />
                          <label for="EndDate">Type: </label>
                          <select name="eventType">
                              <option value="">All</options>
                              <?php
                                  $Types = array(
                                    "Admin",
                                    "Cutting",
                                    "Design",
                                    "Testing",
                                    "Warehouse"
                                  );

                                  foreach($Types as $Type) {
                                    $Selected = NULL;
                                    if($Type == $EventType) {
                                      $Selected = " selected";
                                    }
                                      echo "<option value='$Type' $Selected>$Type</option>";
                                  }
                              ?>
                          </select>
                          <button type="submit">View</button> &nbsp;   
                          <a href="<?= url_to('Production::viewModifications'); ?>">Clear</a>
                          <?php if(!empty($EventType)) { ?>
                            <a href="<?= url_to('Production::ExportModificaitonsReport').'/?Export&S='.$StartDate.'&E='.$EndDate.'&T='.$EventType;?>">Export</a>
                          <?php } ?>
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
                        <th>P No</th>
                        <th>Reason</th>
                        <th>Details</th>
                        <th>Coef</th>
                        <th>Hours</th>
                        <th>Team</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <?php
                      $Total = NULL;
                      $HoursTotal = NULL;
                      $Title = NULL;
                      foreach ($events as $event) {
                          if($Title != $event['type']) {
                              $Title = $event['type'];
                              echo "
                              <tr>
                                  <td colspan='7'><h3>$Title</h3></td>
                              </tr>
                              ";
                          }

                          $Total += $event['coef'];
                          //$event['coef'] * $Norm
                          # ($hours * $norm) / 8; 1 hours * 0.235 = 0.235 / 8 = 0.029375
                          $Hours = round($event['coef'] / ($Norm / 8));
                          $HoursTotal += $Hours;
                      ?>
                      <tr>
                        <td class="align-middle"><?php echo $event['date']; ?></td>
                        <td class="align-middle"><?php echo $event['pnumber'];?></td>
                        <td class="align-middle"><?php echo $event['type']; ?></td>
                        <td class="align-middle"><?php echo $event['details']; ?></td>
                        <td class="align-middle"><?php echo $event['coef']; ?></td>
                        <td class="align-middle"><?php echo $Hours; ?></td>
                        <td class="align-middle"><?php echo $event['team']; ?></td>
                      </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4">Total</td>
                        <td><?php echo $Total;?></td>
                        <td><?php echo $HoursTotal;?></td>
                        <td></td>
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