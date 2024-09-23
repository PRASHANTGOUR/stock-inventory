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
<style>
    button#saveButton {
    border: 0;
    outline: 0;
    background: transparent;
}
</style>
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
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
                <?php  if (auth()->user()->can('production.super')) { ?>
                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <!--begin::Add product-->
                    <a href="<?= url_to('EmployeesLeave::addEmployeesLeaveTotal');?>" class="btn btn-primary">
                    <span class="icon text-white-600">
                      <i class="fas fa-plus-circle"></i>
                    </span>
                    <span class="text">Add Leave Total</span>
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
                            <th class="min-w-70px">Year</th>
                            <th class="min-w-100px">Month</th>
                            <th class="min-w-100px">Hours</th>
                            <th class="min-w-100px">Mintus</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <?php
                    $i = 1;
                    foreach ($products as $product) {
                      ?>
                      <tr>
                        <td class=" align-middle"><?= $product['year']; ?></td>
                        <td class=" align-middle">
                            <?php 
                            $mag_month_date = date('Y').'-'.$product['month'].'-1';
                            echo $mag_month = date('F',strtotime($mag_month_date));
                            ?>
                          </td>
                        <td class=" align-middle"><?= $product['selected_hours']; ?></td>
                        <td class=" align-middle"><?= $product['selected_mintus']; ?></td>
                        <td class="align-middle">
                        <?php if (auth()->user()->can('production.super')) { ?>
                            <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                                <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="<?= url_to('EmployeesLeave::addEmployeesLeaveTotal')?>?year=<?= $product['year']; ?>&month=<?= $product['month']; ?>" class="menu-link px-3">Edit</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <form method="post" onsubmit="return fun_frm_submit();" action="<?= url_to('EmployeesLeave::deleteEmployeesLeaveTotal'); ?>" class="col-lg-5 col-md-6 col-sm-12  p-0">
                                          <input type="hidden" name="leave_total_id" value="<?php echo $product['id']; ?>">
                                          <button id="saveButton" type="submit" class="">Delete</button>
                                        </form>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                        <?php } ?>
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
<script>

function fun_frm_submit(){
  if(confirm('Are you sure you want to delete this?')){
    return true;
	}else{
		return false;
	}
}
</script>
<?php 
echo $this->endSection();