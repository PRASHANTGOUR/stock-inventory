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
                <form method="get" action="">
                    <input type="datetime-local" name="s" value="<?php echo $Start ?>" required>
                    <input type="datetime-local" name="f" value="<?php echo $Finish ?>" required>
                    <button type="submit">View</button>   
                    <a href="<?php echo url_to('Production::recentlyAdded'); ?>">Clear</a>
                </form>
                <!--end::Card toolbar-->
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
                          <th>AQ Code</th>
                          <th>Deadline</th>
                          <th>Name</th>
                          <th>Team</th>
                          <th>Coef</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
             
                    <?php
                    $Team = NULL;
                    foreach ($products as $product) {
                        if($Team != $product['department_id']) {
                            $Team = $product['department_id'];
                            echo "
                            <tr>
                                <td colspan='6'><h3>$Team</h3></td>
                            </tr>
                            ";
                        }

                    if(!empty($product['Notes'])) {
                      $Notes = "<span style='color: orange; font-weight: bold;'> - &#9888;".$product['Notes']."</span>";
                    } else {
                      $Notes = NULL;
                    }
                      ?>
                      <tr>
                        <td class="align-middle"><?php echo $product['DateAdded']; ?></td>
                        <td class="align-middle"><?php echo $product['pnumber'];?></td>
                        <td class="align-middle"><?php echo $product['aqcode']; ?></td>
                        <td class="align-middle"><?php echo $product['Deadline']; ?></td>
                        <td class="align-middle"><?php echo $product['productname'].$Notes; ?></td>
                        <td class="align-middle"><?php echo $product['department_id']; ?></td>
                        <td class="align-middle"><?php echo $product['coef']; ?></td>
                      </tr>
                    <?php } ?>
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