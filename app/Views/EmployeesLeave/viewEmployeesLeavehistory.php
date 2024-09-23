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

.td_border_bold{

  font-weight: bold !important;

  border:1px solid !important;

  border-bottom:1px solid !important;

}

  </style>

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

                <!--end::Card title-->

            </div>

            <!--end::Card header-->

        <!--begin::Card body-->

            <div class="card-body pt-0">

                <!--begin::Table-->

                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">

                    <thead>

                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">

                        <th class="min-w-70px">Start Date</th>

                            <th class="min-w-70px">End Date</th>

                            <th class="min-w-70px">Remark</th>

                            <th class="min-w-70px">Leave Type</th>

                            <th class="min-w-100px">Total days Off</th>

                            <th></th>

                        </tr>

                    </thead>

                    <tbody class="fw-semibold text-gray-600">



                    <?php

                    $i = 1;

                    foreach ($products as $product) {

                      ?>

                      <tr>

                      <td class=" align-middle"><?= $product['start_date']; ?></td>

                          <td class=" align-middle"><?= $product['end_date']; ?></td>

                         <td class=" align-middle"><?= $product['remark']; ?></td>

                         <td class=" align-middle"><?= $product['leave_type']; ?></td>

                         <td class=" align-middle"><?= $product['leave_day']; ?></td>

                            <td>

                                <?php if (auth()->user()->can('production.super')) { ?>

                          <a href="">

                            <span class="icon text-white" title="Edit">

                              

                            </span>

                          </a>

                            

                            

                            <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 

                                <i class="ki-duotone ki-down fs-5 ms-1"></i></a>

                                <!--begin::Menu-->

                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">

                                    <!--begin::Menu item-->

                                    <div class="menu-item px-3">

                                        <a href="<?= url_to('EmployeesLeave::editEmployeesLeave')?>?p=<?= $product['id']; ?>" class="menu-link px-3">Edit</a>

                                    </div>

                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->

                                    <div class="menu-item px-3">

                                        <form method="post" onsubmit="return fun_frm_submit();" action="<?= url_to('EmployeesLeave::deleteEmployeesLeave'); ?>" class="col-lg-5 col-md-6 col-sm-12  p-0">

                                         <input type="hidden" name="leave_id" value="<?php echo $product['id']; ?>">

                                          <input type="hidden" name="employee_id" value="<?php echo $id; ?>">

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

                <h1>Summary</h1>
                <?php $past_year = date('Y', strtotime('-365 days'));?>

                <table class="table align-middle table-row-dashed fs-6 gy-5 " style="text-align:center;font-weight: 700;" id="kt_ecommerce_products_table">

                <?php

                if($leave_type){

                    ?>

                    <tr>

                      <td class=""></td>

                      <?php

                        foreach($leave_type as $leave_type_val){

                            echo '<th class="">'.$leave_type_val['name']."</th>";

                        }

                      ?>

                    </tr>

                    <tr>

                      <td style="color:red;">Total Allowed</td>

                      <?php

                        foreach($leave_type as $leave_type_val){

                          if($leave_type_val['name'] == 'Holiday'){
                            $how_many_holidays = employees_how_many($id, $past_year,$leave_type_val['id']);
                            // echo '<th class="" style="color:red;">'.$leave_type_val['allow_leave']."</th>";
                            echo '<th class="" style="color:red;">'.$how_many_holidays."</th>";

                          }else{

                            echo '<th class=""></th>';

                          }  

                        }

                      ?>

                    </tr>

                    <tr>

                      <td class="td_border_bold">Total <?php echo $past_year;?> Used up</td>

                      <?php

                        foreach($leave_type as $leave_type_val){

                          $query = $this->db->query("SELECT * FROM 8yxzleave WHERE ((employee_id = '$id') OR (employee_id = 0 AND all_employee = 1)) AND  DATE_FORMAT(start_date,'%Y') = '".$past_year."' AND leave_type = '".$leave_type_val['name']."'")->getResultArray();

                          $leave_day = 0;

                          if($query){

                            foreach ($query as $key => $query_value) {

                              $start=date_create($query_value['start_date']);

                              $end=date_create($query_value['end_date']);

                              $diff=date_diff($start,$end);

                              //$leave_day = $diff->format("%R%a");

                              //$leave_day = $leave_day + 1;

                              $end->modify('+1 day');

                              $interval = $end->diff($start);

                              $inner_leave_day = $interval->days;

                              $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

                              foreach($period as $dt) {

                                $curr = $dt->format('D');

                                // substract if Saturday or Sunday

                                if ($curr == 'Sat' || $curr == 'Sun') {

                                    $inner_leave_day--;

                                }

                              }

                              $leave_day = $leave_day + $inner_leave_day;

                            }

                           

                          }

                            echo '<th class="td_border_bold" style="background-color: yellow;">'.$leave_day."</th>";

                        }

                      ?>

                    </tr>

                    <tr>

                      <td style="color:red;">Remaining <?php echo $past_year;?></td>

                      <?php

                        foreach($leave_type as $leave_type_val){

                          if($leave_type_val['name'] == 'Holiday'){

                            $query = $this->db->query("SELECT * FROM 8yxzleave WHERE ((employee_id = '$id') OR (employee_id = 0 AND all_employee = 1)) AND  DATE_FORMAT(start_date,'%Y') = '".$past_year."' AND leave_type = '".$leave_type_val['name']."'")->getResultArray();

                            $leave_day = 0;

                            if($query){

                              foreach ($query as $key => $query_value) {

                                $start=date_create($query_value['start_date']);

                                $end=date_create($query_value['end_date']);

                                $diff=date_diff($start,$end);

                                //$leave_day = $diff->format("%R%a");

                                //$leave_day = $leave_day + 1;

                                $end->modify('+1 day');

                                $interval = $end->diff($start);

                                $inner_leave_day = $interval->days;

                                $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

                                foreach($period as $dt) {

                                  $curr = $dt->format('D');

                                  // substract if Saturday or Sunday

                                  if ($curr == 'Sat' || $curr == 'Sun') {

                                      $inner_leave_day--;

                                  }

                                }

                                $leave_day = $leave_day + $inner_leave_day;

                              }

                              

                            }
                            $how_many_holidays = employees_how_many($id, $past_year,$leave_type_val['id']);
                            // if($leave_type_val['allow_leave'] > 0){
                            if($how_many_holidays > 0){

                              echo '<th class="" style="color:red;">'.($how_many_holidays - $leave_day)."</th>";

                            }else{

                              echo '<th class="" style="color:red;">'.$leave_day."</th>";

                            }

                          }else{

                            echo '<th class=""></th>';

                          } 

                        }

                      ?>

                    </tr>

                    <?php 

                }

                ?>

                </table>
                <br>                  
                <?php $current_year = Date('Y');?>

                <table class="table align-middle table-row-dashed fs-6 gy-5 " style="text-align:center;font-weight: 700;" id="kt_ecommerce_products_table" >

                <?php

                if($leave_type){

                    ?>

                    <tr>

                      <td class=""></td>

                      <?php

                        foreach($leave_type as $leave_type_val){

                            echo '<th class="">'.$leave_type_val['name']."</th>";

                        }

                      ?>

                    </tr>

                    <tr>

                      <td class="" style="color:red;">Total Allowed</td>

                      <?php

                        foreach($leave_type as $leave_type_val){

                          if($leave_type_val['name'] == 'Holiday'){
                              $how_many_holidays = employees_how_many($id, $current_year,$leave_type_val['id']);
                              // echo '<th class="" style="color:red;">'.$leave_type_val['allow_leave']."</th>";
                              echo '<th class="" style="color:red;">'.$how_many_holidays."</th>";

                          }else{

                            echo '<th class=""></th>';

                          }    

                        }

                      ?>

                    </tr>

                    <tr>

                      <td style="" class="td_border_bold">Total <?php echo $current_year;?> Used up</td>

                      <?php

                        foreach($leave_type as $leave_type_val){

                          $query = $this->db->query("SELECT * FROM 8yxzleave WHERE ((employee_id = '$id') OR (employee_id = 0 AND all_employee = 1)) AND  DATE_FORMAT(start_date,'%Y') = '".$current_year."' AND leave_type = '".$leave_type_val['name']."'")->getResultArray();

                          $leave_day = 0;

                          if($query){

                            foreach ($query as $key => $query_value) {

                              $start=date_create($query_value['start_date']);

                              $end=date_create($query_value['end_date']);

                              $diff=date_diff($start,$end);

                              //$leave_day = $diff->format("%R%a");

                              //$leave_day = $leave_day + 1;

                              $end->modify('+1 day');

                              $interval = $end->diff($start);

                              $inner_leave_day = $interval->days;

                              $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

                              foreach($period as $dt) {

                                $curr = $dt->format('D');

                                // substract if Saturday or Sunday

                                if ($curr == 'Sat' || $curr == 'Sun') {

                                    $inner_leave_day--;

                                }

                              }

                              $leave_day = $leave_day + $inner_leave_day;

                            }

                            

                          }

                            echo '<th class="td_border_bold" style="background-color: yellow;">'.$leave_day."</th>";

                        }

                      ?>

                    </tr>

                    <tr>

                      <td class="" style="color:red;">Remaining <?php echo $current_year;?></td>

                      <?php

                        foreach($leave_type as $leave_type_val){

                          if($leave_type_val['name'] == 'Holiday'){

                            $query = $this->db->query("SELECT * FROM 8yxzleave WHERE ((employee_id = '$id') OR (employee_id = 0 AND all_employee = 1)) AND  DATE_FORMAT(start_date,'%Y') = '".$current_year."' AND leave_type = '".$leave_type_val['name']."'")->getResultArray();

                            $leave_day = 0;

                            if($query){

                              foreach ($query as $key => $query_value) {

                                $start=date_create($query_value['start_date']);

                                $end=date_create($query_value['end_date']);

                                $diff=date_diff($start,$end);

                                //$leave_day = $diff->format("%R%a");

                                //$leave_day = $leave_day + 1;

                                $end->modify('+1 day');

                                $interval = $end->diff($start);

                                $inner_leave_day = $interval->days;

                                $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

                                foreach($period as $dt) {

                                  $curr = $dt->format('D');

                                  // substract if Saturday or Sunday

                                  if ($curr == 'Sat' || $curr == 'Sun') {

                                      $inner_leave_day--;

                                  }

                                }

                                $leave_day = $leave_day + $inner_leave_day;

                              }

                              

                            }
                            $how_many_holidays = employees_how_many($id, $current_year,$leave_type_val['id']);
                            // if($leave_type_val['allow_leave'] > 0){
                            if($how_many_holidays > 0){

                              echo '<th class="" style="color:red;">'.($how_many_holidays - $leave_day)."</th>";

                            }else{

                              echo '<th class="" style="color:red;">'.$leave_day."</th>";

                            }

                          }else{

                            echo '<th class=""></th>';

                          }  

                          

                        }

                      ?>

                    </tr>

                    <?php 

                }

                ?>

                </table>

                <br>

                <?php $next_year = date('Y', strtotime('+365 days'));?>

                <table class="table align-middle table-row-dashed fs-6 gy-5 " style="text-align:center;font-weight: 700;" id="kt_ecommerce_products_table">

                <?php

                if($leave_type){

                    ?>

                    <tr>

                      <td class=""></td>

                      <?php

                        foreach($leave_type as $leave_type_val){

                            echo '<th class="">'.$leave_type_val['name']."</th>";

                        }

                      ?>

                    </tr>

                    <tr>

                      <td style="color:red;">Total Allowed</td>

                      <?php

                        foreach($leave_type as $leave_type_val){

                          if($leave_type_val['name'] == 'Holiday'){
                            $how_many_holidays = employees_how_many($id, $next_year,$leave_type_val['id']);
                            // echo '<th class="" style="color:red;">'.$leave_type_val['allow_leave']."</th>";
                            echo '<th class="" style="color:red;">'.$how_many_holidays."</th>";

                          }else{

                            echo '<th class=""></th>';

                          }  

                        }

                      ?>

                    </tr>

                    <tr>

                      <td class="td_border_bold">Total <?php echo $next_year;?> Used up</td>

                      <?php

                        foreach($leave_type as $leave_type_val){

                          $query = $this->db->query("SELECT * FROM 8yxzleave WHERE ((employee_id = '$id') OR (employee_id = 0 AND all_employee = 1)) AND  DATE_FORMAT(start_date,'%Y') = '".$next_year."' AND leave_type = '".$leave_type_val['name']."'")->getResultArray();

                          $leave_day = 0;

                          if($query){

                            foreach ($query as $key => $query_value) {

                              $start=date_create($query_value['start_date']);

                              $end=date_create($query_value['end_date']);

                              $diff=date_diff($start,$end);

                              //$leave_day = $diff->format("%R%a");

                              //$leave_day = $leave_day + 1;

                              $end->modify('+1 day');

                              $interval = $end->diff($start);

                              $inner_leave_day = $interval->days;

                              $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

                              foreach($period as $dt) {

                                $curr = $dt->format('D');

                                // substract if Saturday or Sunday

                                if ($curr == 'Sat' || $curr == 'Sun') {

                                    $inner_leave_day--;

                                }

                              }

                              $leave_day = $leave_day + $inner_leave_day;

                            }

                           

                          }

                            echo '<th class="td_border_bold" style="background-color: yellow;">'.$leave_day."</th>";

                        }

                      ?>

                    </tr>

                    <tr>

                      <td style="color:red;">Remaining <?php echo $next_year;?></td>

                      <?php

                        foreach($leave_type as $leave_type_val){

                          if($leave_type_val['name'] == 'Holiday'){

                            $query = $this->db->query("SELECT * FROM 8yxzleave WHERE ((employee_id = '$id') OR (employee_id = 0 AND all_employee = 1)) AND  DATE_FORMAT(start_date,'%Y') = '".$next_year."' AND leave_type = '".$leave_type_val['name']."'")->getResultArray();

                            $leave_day = 0;

                            if($query){

                              foreach ($query as $key => $query_value) {

                                $start=date_create($query_value['start_date']);

                                $end=date_create($query_value['end_date']);

                                $diff=date_diff($start,$end);

                                //$leave_day = $diff->format("%R%a");

                                //$leave_day = $leave_day + 1;

                                $end->modify('+1 day');

                                $interval = $end->diff($start);

                                $inner_leave_day = $interval->days;

                                $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

                                foreach($period as $dt) {

                                  $curr = $dt->format('D');

                                  // substract if Saturday or Sunday

                                  if ($curr == 'Sat' || $curr == 'Sun') {

                                      $inner_leave_day--;

                                  }

                                }

                                $leave_day = $leave_day + $inner_leave_day;

                              }

                              

                            }
                            $how_many_holidays = employees_how_many($id, $next_year,$leave_type_val['id']);
                            // if($leave_type_val['allow_leave'] > 0){
                            if($how_many_holidays > 0){

                              echo '<th class="" style="color:red;">'.($how_many_holidays - $leave_day)."</th>";

                            }else{

                              echo '<th class="" style="color:red;">'.$leave_day."</th>";

                            }

                          }else{

                            echo '<th class=""></th>';

                          } 

                        }

                      ?>

                    </tr>

                    <?php 

                }

                ?>

                </table>

                <!--end::Table-->
               
              <?php 
              $filter_date = '';
                echo log_leave_list($filter_date,$id);
              ?>
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