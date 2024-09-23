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
        <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-70px">P Number</th>
                            <th class="min-w-70px">Date</th>
                            <th class="min-w-120px">Type</th>
                            <th class="min-w-100px">Details</th>
                            <th class="min-w-50px">Team</td>
                            <th class="min-w-50px">Coef</td>
                            <th class="min-w-50px">Complete</td>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
               
                    <?php
                    foreach ($outputs as $output) {
                      ?>
                      <tr>
                        <td class=" align-middle"><?= $output['pnumber']?>'</td>
                        <td class=" align-middle"><?= $output['date']?></td>
                        <td class=" align-middle"><?= $output['type']?></td>
                        <td class=" align-middle"><?= $output['details']?></td>
                        <td class=" align-middle"><?= $output['team']?></td>
                        <td class=" align-middle"><?= $output['coef']?></td>

                        <td class="align-middle">
                          <form action="<?=url_to('Design::completeModification')?>" method="POST">
                            <input type="hidden" name="productId" value="<?= $output['product_id']?>"/>
                            <input type="hidden" name="id" value="<?= $output['id']?>"/>
                            <button type="submit" class="btn btn-primary fw-semibold px-6">Complete</button>
                          </form>
                        </td>
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