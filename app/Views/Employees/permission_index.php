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
td {
    border: 1px solid black !important;
    padding: 5px !important;
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

                    <form method="post">

                      <div class="d-flex align-items-center position-relative my-1">

                          <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4 pt-4">

                              <span class="path1"></span><span class="path2"></span>

                          </i>

                          <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-12" name="search" placeholder="Search" value="<?php echo $search;?>" />

                          &nbsp;&nbsp;<button id="saveButton1" type="submit" class="btn btn-success">Search</button>

                          &nbsp;&nbsp;<a href="<?= url_to('Employees::permission_list') ?>"  class="btn btn-danger"><span class="text">Reset</span></a>

                      </div>

                    </form>

                    <!--end::Search-->

                </div>

                <!--end::Card title-->
            </div>

            <!--end::Card header-->

        <!--begin::Card body-->

            <div class="card-body pt-0">

                <!--begin::Table-->

                <table class="table border align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">

                    <thead>

                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <td class="min-w-70px">Employees</td>
                            <td colspan="2" style="text-align: center;" class="min-w-100px">Admin</td>
                            <td colspan="2" style="text-align: center;" class="min-w-100px">Design</td>
                            <td colspan="2" style="text-align: center;" class="min-w-100px">Products</td>
                            <td colspan="2" style="text-align: center;" class="min-w-100px">Production</td>
                            <td colspan="2" style="text-align: center;" class="min-w-100px">Staff</td>
                            <td colspan="2" style="text-align: center;" class="min-w-100px">Departments</td>
                            <td colspan="2" style="text-align: center;" class="min-w-100px">Employees</td>
                            <td colspan="2" style="text-align: center;" class="min-w-100px">Leave</td>
                            <!-- <td colspan="2" style="text-align: center;" class="min-w-100px">Task</td> -->
                            <td style="text-align: center;" class="min-w-100px">ALL</td>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <tr class="" style="font-size: 10px;">
                        <td class="min-w-70px"></td>
                        <td>View Only</td>
                        <td>Edit</td>
                        <td>View Only</td>
                        <td>Edit</td>
                        <td>View Only</td>
                        <td>Edit</td>
                        <td>View Only</td>
                        <td>Edit</td>
                        <td>View Only</td>
                        <td>Edit</td>
                        <td>View Only</td>
                        <td>Edit</td>
                        <td>View Only</td>
                        <td>Edit</td>
                        <td>View Only</td>
                        <td>Edit</td>
                        <td></td>
                    </tr>
                    <?php
                    $i = 1;
                    foreach ($products as $product) {
                      $users_id = $product['users_id'];
                      ?>
                      <tr>
                        <td class=" align-middle">
                          <b><?= $product['department']; ?></b>&nbsp;&nbsp;
                          <?= srting_decrypt($product['first_name']); ?>&nbsp;<?= srting_decrypt($product['last_name']); ?><br>
                          <?= srting_decrypt($product['email']); ?>
                        </td>
                        <?php
                          $admin_view = UserPermissionCHeck($users_id, 'admin_view');
                          $admin_edit = UserPermissionCHeck($users_id, 'admin_edit');
                          ?>
                          <td class="align-middle" style="text-align: center;">
                            <input type="checkbox" name="chk_admin_view" id="chk_admin_view_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','admin_view')" <?php if($admin_view == 1){ echo 'checked';}?>>
                          </td>
                          <td class="align-middle" style="text-align: center;">  
                            <input type="checkbox" name="chk_admin_edit" id="chk_admin_edit_<?php echo $users_id;?>" value="1"onchange="fun_user_permission_change('<?php echo $users_id;?>','admin_edit')" <?php if($admin_edit == 1){ echo 'checked';}?>>
                          </td>  
                          <?php 
                          $design_view = UserPermissionCHeck($users_id, 'design_view');
                          $design_edit = UserPermissionCHeck($users_id, 'design_edit');
                          ?>
                          <td class="align-middle" style="text-align: center;">  
                            <input type="checkbox" name="chk_design_view" id="chk_design_view_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','design_view')" <?php if($design_view == 1){ echo 'checked';}?>>
                          </td>
                          <td class="align-middle" style="text-align: center;">    
                            <input type="checkbox" name="chk_design_edit" id="chk_design_edit_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','design_edit')" <?php if($design_edit == 1){ echo 'checked';}?>>
                          </td>  
                          <?php 
                          $products_view = UserPermissionCHeck($users_id, 'products_view');
                          $products_edit = UserPermissionCHeck($users_id, 'products_edit');
                          ?>
                          <td class="align-middle" style="text-align: center;">  
                            <input type="checkbox" name="chk_products_view" id="chk_products_view_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','products_view')" <?php if($products_view == 1){ echo 'checked';}?>>
                          </td>
                          <td class="align-middle" style="text-align: center;">    
                            <input type="checkbox" name="chk_products_edit" id="chk_products_edit_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','products_edit')" <?php if($products_edit == 1){ echo 'checked';}?>>
                          </td>  
                        <?php
                          $production_view = UserPermissionCHeck($users_id, 'production_view');
                          $production_edit = UserPermissionCHeck($users_id, 'production_edit');
                          ?>
                          <td class="align-middle" style="text-align: center;">  
                            <input type="checkbox" name="chk_production_view" id="chk_production_view_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','production_view')" <?php if($production_view == 1){ echo 'checked';}?>>
                          </td>
                          <td class="align-middle" style="text-align: center;">    
                            <input type="checkbox" name="chk_production_edit" id="chk_production_edit_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','production_edit')" <?php if($production_edit == 1){ echo 'checked';}?>>
                          </td>  
                        <?php
                          $staff_view = UserPermissionCHeck($users_id, 'staff_view');
                          $staff_edit = UserPermissionCHeck($users_id, 'staff_edit');
                          ?>
                          <td class="align-middle" style="text-align: center;">  
                            <input type="checkbox" name="chk_staff_view" id="chk_staff_view_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','staff_view')" <?php if($staff_view == 1){ echo 'checked';}?>>
                          </td>
                          <td class="align-middle" style="text-align: center;">    
                            <input type="checkbox" name="chk_staff_edit" id="chk_staff_edit_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','staff_edit')" <?php if($staff_edit == 1){ echo 'checked';}?>>
                          </td>  
                          <?php
                          $departments_view = UserPermissionCHeck($users_id, 'departments_view');
                          $departments_edit = UserPermissionCHeck($users_id, 'departments_edit');
                          ?>
                          <td class="align-middle" style="text-align: center;">  
                            <input type="checkbox" name="chk_departments_view" id="chk_departments_view_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','departments_view')" <?php if($departments_view == 1){ echo 'checked';}?>>
                          </td>
                          <td class="align-middle" style="text-align: center;">    
                            <input type="checkbox" name="chk_departments_edit" id="chk_departments_edit_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','departments_edit')" <?php if($departments_edit == 1){ echo 'checked';}?>>
                          </td> 
                          <?php
                          $employees_view = UserPermissionCHeck($users_id, 'employees_view');
                          $employees_edit = UserPermissionCHeck($users_id, 'employees_edit');
                          ?>
                          <td class="align-middle" style="text-align: center;">  
                            <input type="checkbox" name="chk_employees_view" id="chk_employees_view_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','employees_view')" <?php if($employees_view == 1){ echo 'checked';}?>>
                          </td>
                          <td class="align-middle" style="text-align: center;">    
                            <input type="checkbox" name="chk_employees_edit" id="chk_employees_edit_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','employees_edit')" <?php if($employees_edit == 1){ echo 'checked';}?>>
                          </td> 
                          <?php
                          $leave_view = UserPermissionCHeck($users_id, 'leave_view');
                          $leave_edit = UserPermissionCHeck($users_id, 'leave_edit');
                          ?>
                          <td class="align-middle" style="text-align: center;">  
                            <input type="checkbox" name="chk_leave_view" id="chk_leave_view_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','leave_view')" <?php if($leave_view == 1){ echo 'checked';}?>>
                          </td>
                          <td class="align-middle" style="text-align: center;">    
                            <input type="checkbox" name="chk_leave_edit" id="chk_leave_edit_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change('<?php echo $users_id;?>','leave_edit')" <?php if($leave_edit == 1){ echo 'checked';}?>>
                          </td> 
                          <?php 
                          $all_chk = 0;
                          if($admin_view == 1 && $admin_edit == 1 && $design_view == 1 && $design_edit == 1 && $products_view == 1 && $products_edit == 1 && $production_view == 1 && $production_edit == 1 && $staff_view == 1 && $staff_edit == 1 && $departments_view == 1 && $departments_edit == 1 && $employees_view == 1 && $employees_edit == 1 && $leave_view == 1 && $leave_edit == 1){
                            $all_chk = 1;    
                          }
                          ?>
                          <td class="align-middle" style="text-align: center;">    
                            <input type="checkbox" name="chk_leave_edit" id="chk_all_<?php echo $users_id;?>" value="1" onchange="fun_user_permission_change_all('<?php echo $users_id;?>')" <?php if($all_chk == 1){ echo 'checked';}?>>
                          </td> 
                          <?php } ?>
                      </tr>
                  </tbody>
                </table>
                
              <?php 
               echo log_Permission_list();
              ?>
              
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
function fun_user_permission_change_all(user_id){
    chk_all = $('#chk_all_'+user_id).val();
    if($('#chk_all_'+user_id).prop('checked') == true){
        fun_user_permission_change(user_id,'all_check');
        $('#chk_admin_view_'+user_id).attr('checked', true);
        $('#chk_admin_edit_'+user_id).attr('checked', true);
        $('#chk_design_view_'+user_id).attr('checked', true);
        $('#chk_design_edit_'+user_id).attr('checked', true);
        $('#chk_products_view_'+user_id).attr('checked', true);
        $('#chk_products_edit_'+user_id).attr('checked', true);
        $('#chk_production_view_'+user_id).attr('checked', true);
        $('#chk_production_edit_'+user_id).attr('checked', true);
        $('#chk_staff_view_'+user_id).attr('checked', true);
        $('#chk_staff_edit_'+user_id).attr('checked', true);
        $('#chk_departments_view_'+user_id).attr('checked', true);
        $('#chk_departments_edit_'+user_id).attr('checked', true);
        $('#chk_employees_view_'+user_id).attr('checked', true);
        $('#chk_employees_edit_'+user_id).attr('checked', true);
        $('#chk_leave_view_'+user_id).attr('checked', true);
        $('#chk_leave_edit_'+user_id).attr('checked', true);
    }else{
        fun_user_permission_change(user_id,'all_uncheck');
        $('#chk_admin_view_'+user_id).attr('checked', false);
        $('#chk_admin_edit_'+user_id).attr('checked', false);
        $('#chk_design_view_'+user_id).attr('checked', false);
        $('#chk_design_edit_'+user_id).attr('checked', false);
        $('#chk_products_view_'+user_id).attr('checked', false);
        $('#chk_products_edit_'+user_id).attr('checked', false);
        $('#chk_production_view_'+user_id).attr('checked', false);
        $('#chk_production_edit_'+user_id).attr('checked', false);
        $('#chk_staff_view_'+user_id).attr('checked', false);
        $('#chk_staff_edit_'+user_id).attr('checked', false);
        $('#chk_departments_view_'+user_id).attr('checked', false);
        $('#chk_departments_edit_'+user_id).attr('checked', false);
        $('#chk_employees_view_'+user_id).attr('checked', false);
        $('#chk_employees_edit_'+user_id).attr('checked', false);
        $('#chk_leave_view_'+user_id).attr('checked', false);
        $('#chk_leave_edit_'+user_id).attr('checked', false);
    }
}
function fun_user_permission_change(user_id,permission_flage){
  var base_url = '<?php echo url_to('Employees::checkEmployeespermission');?>';
    $.ajax({
	 	type: "POST",
	 	url: base_url,
	  	dataType: 'json',
	  	data: {'user_id':user_id,'permission_flage':permission_flage},
	  	success: function(responce){
	   	 	
	  	}
	});
}
</script>
<?php 
echo $this->endSection();