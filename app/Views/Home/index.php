<?php 
# Call in main template
echo $this->extend('layouts/default');
# title Section 
echo $this->section('heading');
echo $title;
// echo '<pre>';
// print_r(auth()->user());
// echo '</pre>';
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
                <div class="card-title" style="display:none;">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <form method="post">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4 pt-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-12" name="search" placeholder="Search" />
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
                <?php /* 
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-70px">Employees</th>
                            <th class="min-w-70px">Check In</th>
                            <th class="min-w-70px">Check Out</th>
                            <th class="min-w-70px">Working Hours</th>
                            <!--<th class="min-w-100px">Actions</th>-->
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <?php
                    $i = 1;
                    foreach ($products as $product) {
                    ?>
                      <tr>
                      <td class=" align-middle"><?= $product['first_name']; ?> <?= $product['last_name']; ?></td>
                        <td class=" align-middle"><?= $product['start_time']; ?></td>
                        <td class=" align-middle"><?= $product['end_time']; ?></td>
                        <td class=" align-middle"><?= $product['total_time']; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                */ ?>
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