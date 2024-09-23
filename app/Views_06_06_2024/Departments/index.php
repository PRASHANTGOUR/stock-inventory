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

    .color_td{

    color: black !important;

    font-weight: bold !important;

}

</style>
<style>

    button#saveButton {

    border: 0;

    outline: 0;

    background: transparent;

}

</style
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

                          &nbsp;&nbsp;<a href="<?= url_to('Department::list') ?>"  class="btn btn-danger"><span class="text">Reset</span></a>

                      </div>

                    </form>

                    <!--end::Search-->

                </div>

                <!--end::Card title-->

                <?php  if (auth()->user()->can('production.super')) { ?>

                <!--begin::Card toolbar-->

                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                    <!--begin::Add product-->

                    <a href="<?= url_to('Department::addDepartment');?>" class="btn btn-primary">

                    <span class="icon text-white-600">

                      <i class="fas fa-plus-circle"></i>

                    </span>

                    <span class="text">Add Department</span>

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

                            <th class="min-w-70px">Department</th>

                            <th class="min-w-100px">Actions</th>

                        </tr>

                    </thead>

                    <tbody class="fw-semibold text-gray-600">



                    <?php

                    /*foreach ($department as $dpt) :

                    ?>

                      <tr>

                        <td class="align-middle"><?= $dpt['id']; ?></td>

                        <td class="align-middle"><?= $dpt['name']; ?></td>

                        <td class="align-middle"><a href="<?php echo base_url('master/view_team_output/') . $dpt['id'];?>">Output</a></td>

                        <td class="align-middle text-center">

                          <a href="<?= base_url('master/e_dept/') . $dpt['id'] ?>">

                            <span class="icon text-white" title="Edit">

                              <i class="fas fa-edit"></i>

                            </span>

                          </a> |

                          <a href="<?= base_url('master/d_dept/') . $dpt['id'] ?>" onclick="return confirm('Deleted Department will lost forever. Still want to delete?')">

                            <span class="icon text-white" title="Delete">

                              <i class="fas fa-trash-alt"></i>

                            </span>

                          </a>

                        </td>

                      </tr>

                    <?php endforeach; */?>



               

                    <?php

                    $i = 1;

                    foreach ($products as $product) {

                      ?>

                      <tr>

                        <td class=" align-middle color_td" style="background-color:<?= $product['color_code']; ?>"><?= $product['department']; ?></td>

                        <td class="align-middle">

                        <?php if (auth()->user()->can('production.super')) { ?>
                          <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                                <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="<?= url_to('Department::editDepartment')?>?p=<?= $product['id']; ?>" class="menu-link px-3">Edit</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <form method="post" onsubmit="return fun_frm_submit();" action="<?= url_to('Department::deleteDepartment'); ?>" class="col-lg-5 col-md-6 col-sm-12  p-0">
                                          <input type="hidden" name="department_id" value="<?php echo $product['id']; ?>">
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