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
<Style>
.filter_select{
  padding: 5px 0px 5px 10px;
    margin: 0px 20px 0px 0px;
    width: 121px;
    min-height: 11px !important;
}  
</Style>
<!--begin::Post-->
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div class="container-xxl">
        <!--begin::Products-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <!--begin::Card title-->
                <form method="" action="">
                  <input type="hidden" id="p" name="p" value="<?= $id; ?>">
                  <div class="card-title" style="">
                      <!--begin::Search-->
                      <?php 
                      if(count($exit_month) > 0){
                      ?>
                      <div class="d-flex align-items-center position-relative my-1">
                          <select class="form-control form-control filter_select" name="selected_month" id="selected_month">
                            <!-- <option value="all">All Month</option> -->
                              <?php 
                              foreach($exit_month as $key=>$exit_month_val){
                                $selected = '';
                                if($selected_month == $key){
                                  $selected = 'selected';
                                }
                              ?>
                                <option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $exit_month_val;?></option>
                              <?php } ?>
                          </select>
                      </div>
                      <?php } ?>
                      <?php 
                      if(count($exit_year) > 0){
                      ?>
                      <div class="d-flex align-items-center position-relative my-1">
                          <select class="form-control form-control filter_select" name="selected_year" id="selected_year">
                          <!-- <option value="all">All Year</option> -->
                              <?php 
                              foreach($exit_year as $key=>$exit_year_val){
                                $selected = '';
                                if($selected_year == $key){
                                  $selected = 'selected';
                                }
                              ?>
                                <option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $exit_year_val;?></option>
                              <?php } ?>
                          </select>
                      </div>
                      <?php } ?>
                      <div class="d-flex align-items-center position-relative my-1">
                      <button id="saveButton" type="submit" class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split float-right rounded-0">
                          <span class="icon text-white">
                            <i class="fas fa-search"></i>
                          </span>
                          <span class="text">Filter</span>
                          </button>
                      </div>
                      <div class="d-flex align-items-center position-relative my-1" style="margin-left: 20px;">
                        <select class="form-control" id="select_emp" style="width: 270px;" onchange="fun_change_emp(this.value)">
                        <?php 
                        $pdf_url = url_to('Employees::viewattendances').'?p=all&selected_year='.$selected_year.'&selected_month='.$selected_month.'&view_type=';
                        ?>
                        <option value="<?php echo $pdf_url;?>"> All Employees</option>
                          <?php 
                          if($Output_employees){
                            foreach($Output_employees as $key=>$Output_employees_val){
                              $selected = '';
                              if($id == $Output_employees_val['id']){
                                $selected = 'selected';
                              }
                              ?>
                              <?php 
                              $pdf_url = url_to('Employees::viewattendances').'?p='.$Output_employees_val['id'].'&selected_year='.$selected_year.'&selected_month='.$selected_month.'&view_type=';
                              ?>
                              <option value="<?php echo $pdf_url;?>" <?php echo $selected;?>><?php echo srting_decrypt($Output_employees_val['first_name']);?> <?php echo srting_decrypt($Output_employees_val['last_name']);?></option>
                            <?php } 
                            }?>
                        </select>
                      </div>
                      <div class="d-flex align-items-center position-relative my-1">
                        &nbsp;
                        <button id="saveButton"  onclick="fun_all_view('month_all_employees_all');" type="button" class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split float-right rounded-0">
                          <span class="text">All View</span>
                          </button>
                      </div>
                      <!--end::Search-->
                  </div>
                </form>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                    <!--begin::Add product-->
                    <select class="form-control" id="report_type" style="width: 270px;">
                    <option value="all_month_all_employees_pdf">All Month All Employees Pdf Report</option>
                    <option value="all_month_all_employees_exel">All Month All Employees Excel Report</option>
                      <option value="month_all_employees_pdf">Month All Employees Pdf Report</option>
                      <option value="month_all_employees_exel">Month All Employees Excel Report</option>
                      <option value="Filter_Wise_Pdf">Filter Wise Pdf</option>
                      <option value="Filter_Wise_Excel_Report">Filter Wise Excel Report</option>
                      <option value="All_Month_Pdf_Report">All Month Pdf Report</option>
                      <option value="All_Month_Excel_Report">All Month Excel Report</option>
                    </select>
                    <a style="padding: 10px 8px 10px 5px;" href="javascript:;" class="btn btn-primary" onclick="fun_download_report();">
                    <span class="icon text-white-600">
                      <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    </span>
                    <span class="text">Download Report</span>
                    </a>
                   <span style="display:none;">
                   <?php 
                    $pdf_url = url_to('Employees::viewattendances').'?p=all&selected_year=all&selected_month=all&view_type=pdf';
                    ?>
                    <a style="padding: 10px 8px 10px 5px;" id="all_month_all_employees_pdf" target="_blank" href="<?php echo $pdf_url; ?>" class="btn btn-primary">
                    <span class="icon text-white-600">
                      <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    </span>
                    <span class="text">All Month All Employees pdf Report</span>
                    </a>
                    <?php 
                    $pdf_url = url_to('Employees::viewattendances').'?p=all&selected_year=all&selected_month=all&view_type=exel';
                    ?>
                    <a style="padding: 10px 8px 10px 5px;" id="all_month_all_employees_exel" target="_blank" href="<?php echo $pdf_url; ?>" class="btn btn-primary">
                    <span class="icon text-white-600">
                      <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    </span>
                    <span class="text">All Month All Employees Excel Report</span>
                    </a>
                   <?php 
                    $pdf_url = url_to('Employees::viewattendances').'?p=all&selected_year=all&selected_month=all&view_type=';
                    ?>
                    <a style="padding: 10px 8px 10px 5px;" id="month_all_employees_all" target="_blank" href="<?php echo $pdf_url; ?>" class="btn btn-primary">
                    <span class="icon text-white-600">
                      <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    </span>
                    <span class="text">Month All Employees All</span>
                    </a>
                   <?php 
                    $pdf_url = url_to('Employees::viewattendances').'?p=all&selected_year='.$selected_year.'&selected_month='.$selected_month.'&view_type=pdf';
                    ?>
                    <a style="padding: 10px 8px 10px 5px;" id="month_all_employees_pdf" target="_blank" href="<?php echo $pdf_url; ?>" class="btn btn-primary">
                    <span class="icon text-white-600">
                      <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    </span>
                    <span class="text">Month All Employees pdf Report</span>
                    </a>
                    <?php 
                    $pdf_url = url_to('Employees::viewattendances').'?p=all&selected_year='.$selected_year.'&selected_month='.$selected_month.'&view_type=exel';
                    ?>
                    <a style="padding: 10px 8px 10px 5px;" id="month_all_employees_exel" target="_blank" href="<?php echo $pdf_url; ?>" class="btn btn-primary">
                    <span class="icon text-white-600">
                      <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    </span>
                    <span class="text">Month All Employees Excel Report</span>
                    </a>
                    <?php 
                    $pdf_url = url_to('Employees::viewattendances').'?p='.$id.'&selected_year='.$selected_year.'&selected_month='.$selected_month.'&view_type=pdf';
                    ?>
                    <a style="padding: 10px 8px 10px 5px;" id="Filter_Wise_Pdf" target="_blank" href="<?php echo $pdf_url; ?>" class="btn btn-primary">
                    <span class="icon text-white-600">
                      <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    </span>
                    <span class="text">Filter Wise Pdf Report</span>
                    </a>
                    <?php 
                    $pdf_url = url_to('Employees::viewattendances').'?p='.$id.'&selected_year='.$selected_year.'&selected_month='.$selected_month.'&view_type=exel';
                    ?>
                    <a style="padding: 10px 8px 10px 5px;" id="Filter_Wise_Excel_Report" target="_blank" href="<?php echo $pdf_url; ?>" class="btn btn-primary">
                    <span class="icon text-white-600">
                      <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    </span>
                    <span class="text">Filter Wise Excel Report</span>
                    </a>
                    <!--------------------------- -->
                    <?php 
                    $pdf_url = url_to('Employees::viewattendances').'?p='.$id.'&selected_year=all&selected_month=all&view_type=pdf';
                    ?>
                    <a style="padding: 10px 8px 10px 5px;" id="All_Month_Pdf_Report" target="_blank" href="<?php echo $pdf_url; ?>" class="btn btn-primary">
                    <span class="icon text-white-600">
                      <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    </span>
                    <span class="text">All Month Pdf Report</span>
                    </a>
                    <?php 
                    $pdf_url = url_to('Employees::viewattendances').'?p='.$id.'&selected_year=all&selected_month=all&view_type=exel';
                    ?>
                    <a style="padding: 10px 8px 10px 5px;" id="All_Month_Excel_Report" target="_blank" href="<?php echo $pdf_url; ?>" class="btn btn-primary">
                    <span class="icon text-white-600">
                      <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    </span>
                    <span class="text">All Month Excel Report</span>
                    </a>
                    </span>
                    <!--end::Add product-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                 <h3>Month Wise</h3>
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-70px">Month</th>
                            <th class="min-w-70px">Total Hours</th>
                            <th class="min-w-70px">Working Hours</th>
                            <th class="min-w-70px">Extra Hours</th>
                            <?php
                            foreach($leave_type as $leave_type_val){
                              echo '<th class="" style="min-w-70px">'.$leave_type_val['name']."</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <?php
                    $i = 1;
                    foreach ($month_timesheet as $product) {
                    ?>
                      <tr>
                        <td class=" align-middle"><?= $product['month_name']; ?></td>
                        <td class=" align-middle"><?= $product['final_total_hours']; ?></td>
                        <td class=" align-middle"><?= $product['total_hours']; ?></td>
                        <td class=" align-middle"><?= $product['final_extra_hours']; ?></td>
                        <?php
                            foreach($leave_type as $leave_type_val){
                              $query = $this->db->query("SELECT * FROM 8yxzleave WHERE ((employee_id = '$id') OR (employee_id = 0 AND all_employee = 1)) AND ((DATE_FORMAT(start_date,'%c') = '".$product['current_month']."' AND DATE_FORMAT(start_date,'%Y') = '".$product['current_year']."') OR (DATE_FORMAT(end_date,'%c') = '".$product['current_month']."' AND DATE_FORMAT(end_date,'%Y') = '".$product['current_year']."')) AND leave_type = '".$leave_type_val['name']."'")->getResultArray();
                              $leave_day = 0;
                              if($query){
                                foreach ($query as $key => $query_value) {
                                  $start=date_create($query_value['start_date']);
                                  $end=date_create($query_value['end_date']);
                                  $diff=date_diff($start,$end);
                                  $end->modify('+1 day');
                                  $interval = $end->diff($start);
                                  $inner_leave_day = $interval->days;
                                  $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);
                                  // echo '<pre>';
                                  // print_r($period);
                                  // echo '</pre>';
                                  if(strlen($selected_year) == 1){
                                    $selected_year = '0'.$selected_year;
                                  }  
                                  if(strlen($selected_month) == 1){
                                    $selected_month = '0'.$selected_month;
                                  }
                                  //echo '<br>--match_selected->';
                                  $match_selected = $selected_month.$selected_year;
                                  //echo '<hr><hr>';
                                  
                                  foreach($period as $dt) {
                                    $curr = $dt->format('D');
                                    $inner_year = $dt->format('Y');
                                    if(strlen($inner_year) == 1){
                                      $inner_year = '0'.$inner_year;
                                    }  
                                    $inner_month = $dt->format('m');
                                    if(strlen($inner_month) == 1){
                                      $inner_month = '0'.$inner_month;
                                    }
                                    //echo '<br>--match_selected->';
                                    $match_inner = $inner_month.$inner_year;
                                    if($selected_month == 'all' || $selected_year == 'all'){
                                      if ($curr == 'Sat' || $curr == 'Sun') {
                                          $inner_leave_day--;
                                      }
                                    }else{
                                      if($match_selected == $match_inner){
                                        //echo 'innnnnnnnnnnnn';
                                        if ($curr == 'Sat' || $curr == 'Sun') {
                                            $inner_leave_day--;
                                        }
                                      }else{
                                        $inner_leave_day--;
                                      }  
                                    }
                                  }
                                  $leave_day = $leave_day + $inner_leave_day;
                                }
                              }
                              echo '<td class="">'.$leave_day."</td>";
    
                            }
                            ?>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <!--end::Table-->
            </div>
            <div class="card-body pt-0">
                <h3>Attendances List</h3>
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-70px">Check In</th>
                            <th class="min-w-70px">Check Out</th>
                            <th class="min-w-70px">Working Hours</th>
                            <th class="min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <?php
                    $i = 1;
                    foreach ($products as $product) {
                    ?>
                      <tr>
                        <td class=" align-middle">
                          <?php 
                          $start_time = $product['start_time'];
                          if($start_time != ''){
                            echo date('d-m-Y h:i A',strtotime($start_time));
                          }
                          ?>
                          <a href="javascript;" class="" data-bs-toggle="modal" data-bs-target="#checkin_update_<?= $product['id']; ?>">
                          <span class="icon text-white-600">
                          <i class="fas fa-edit" style="color: #c99c9c;margin-left: 5px;"></i>
                          </span>
                          </a>
                            <div class="modal fade" id="checkin_update_<?= $product['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" style="">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">CHECK IN TIME</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form action="<?php echo url_to('Employees::viewattendances');?>" method="POST">
                                    <input type="hidden" id="db_id" name="db_id" value="<?= $product['id']; ?>">
                                    <input type="hidden" id="p" name="p" value="<?php echo $id;?>">
                                    <input type="hidden" id="update_type" name="update_type" value="checkin">
                                    <input type="hidden" id="selected_year" name="selected_year" value="<?php echo $selected_year;?>">
                                    <input type="hidden" id="selected_month" name="selected_month" value="<?php echo $selected_month;?>">
                                    <div class="modal-body">
                                      <input type="datetime-local" name="new_time" value="<?= $product['start_time']; ?>" required>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                        </td>
                        <td class=" align-middle">
                          <?php
                          $end_time = $product['end_time'];
                            if($end_time != '' && $end_time != '-'){
                              echo date('d-m-Y h:i A',strtotime($end_time));
                            }
                          ?>
                          <a href="javascript;" class="" data-bs-toggle="modal" data-bs-target="#checkout_update_<?= $product['id']; ?>">
                          <span class="icon text-white-600">
                          <i class="fas fa-edit" style="color: #c99c9c;margin-left: 5px;"></i>
                          </span>
                          </a>
                            <div class="modal fade" id="checkout_update_<?= $product['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" style="">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">CHECK OUT TIME</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form action="<?php echo url_to('Employees::viewattendances');?>" method="POST">
                                    <input type="hidden" id="db_id" name="db_id" value="<?= $product['id']; ?>">
                                    <input type="hidden" id="p" name="p" value="<?php echo $id;?>">
                                    <input type="hidden" id="update_type" name="update_type" value="checkout">
                                    <input type="hidden" id="selected_year" name="selected_year" value="<?php echo $selected_year;?>">
                                    <input type="hidden" id="selected_month" name="selected_month" value="<?php echo $selected_month;?>">
                                    <div class="modal-body">
                                      <input type="datetime-local" name="new_time" value="<?= $product['end_time']; ?>" required>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                        </td>
                        <td class=" align-middle"><?= $product['total_time']; ?></td>
                        <td>
                        <form method="post" onsubmit="return fun_frm_submit();" action="<?= url_to('Employees::delete_attendances'); ?>" class="col-lg-5 col-md-6 col-sm-12  p-0">

                          <input type="hidden" name="employee_id" value="<?php echo $id; ?>">
                          <input type="hidden" name="main_id" value="<?php echo $product['id']; ?>">
                          <input type="hidden" name="selected_year" value="<?php echo $selected_year; ?>">
                          <input type="hidden" name="selected_month" value="<?php echo $selected_month; ?>">
                          <button id="saveButton" type="submit" class="">
                            <span class="icon text-white" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                          </span>
                          </button>
                          </form>
                       

                        

                        
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <h3>Leave List</h3>
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-70px">Start Date</th>
                            <th class="min-w-70px">End Date</th>
                            <th class="min-w-70px">Remark</th>
                            <th class="min-w-70px">Leave Type</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <?php
                    $i = 1;
                    foreach ($products_leave as $product_leave) {
                      ?>
                      <tr>
                      <td class=" align-middle"><?= $product_leave['start_date']; ?></td>
                          <td class=" align-middle"><?= $product_leave['end_date']; ?></td>
                         <td class=" align-middle"><?= $product_leave['remark']; ?></td>
                         <td class=" align-middle"><?= $product_leave['leave_type']; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <!--end::Table-->
            </div>
            <div class="card-body pt-0">
            <?php 
            $filter_date = $selected_year.'-'.$selected_month.'-01';
              echo log_attendances_list($filter_date,$id);
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
function fun_download_report(){
  report_type = $('#report_type').val();
  report_type_url = $('#'+report_type).attr('href');
  window.open(report_type_url,'_blank');
}  
function fun_change_emp(report_type_url){
  //window.open(report_type_url,'');
  window.location.href = report_type_url;
} 
function fun_all_view(report_type){
  report_type_url = $('#'+report_type).attr('href');
  window.location.href = report_type_url;
}
</script>
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