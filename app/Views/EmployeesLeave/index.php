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
                    <form method="post">
                      <div class="d-flex align-items-center position-relative my-1">
                          <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4 pt-4">
                              <span class="path1"></span><span class="path2"></span>
                          </i>
                          <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-12" name="search" placeholder="Search" value="<?php echo $search;?>" />
                          &nbsp;&nbsp;<button id="saveButton" type="submit" class="btn btn-success">Search</button>
                          &nbsp;&nbsp;<a href="<?= url_to('EmployeesLeave::list') ?>"  class="btn btn-danger"><span class="text">Reset</span></a>
                      </div>
                    </form>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
                <?php  if (auth()->user()->can('production.super')) { ?>
                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <!--begin::Add product-->
                    <a href="<?= url_to('EmployeesLeave::addEmployeesLeave');?>" class="btn btn-primary">
                    <span class="icon text-white-600">
                      <i class="fas fa-plus-circle"></i>
                    </span>
                    <span class="text">Add Employees Leave</span>
                  </a>
                    <!--end::Add product-->
                </div>
                <!--end::Card toolbar-->
                <?php } ?>
            </div>
            <!--end::Card header-->
        <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-70px">Employees</th>
                            <th class="min-w-100px"></th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">

                    <?php
                    $i = 1;
                    foreach ($products as $product) {
                      ?>
                      <tr>
                        <td class=" align-middle"><?= srting_decrypt($product['first_name']); ?> <?= srting_decrypt($product['last_name']); ?></td>
                        <td class="align-middle">
                          <a href="<?= url_to('EmployeesLeave::ViewEmployeesLeavehistory')?>?p=<?= $product['employee_id']; ?>">
                            <span class="icon text-white" title="History ">
                              <i class="bi bi-clock-history"></i>
                            </span>
                          </a>
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