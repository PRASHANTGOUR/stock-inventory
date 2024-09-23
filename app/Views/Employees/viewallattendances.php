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
                            <?php 
                            if($first_colum_array){
                              foreach($first_colum_array as $first_colum_array_val){
                                  ?>
                                  <th class="min-w-70px"><?php echo $first_colum_array_val;?></th>
                                  <?php
                              }
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <?php echo $month_timesheet_html;?>
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
<?php 
echo $this->endSection();
