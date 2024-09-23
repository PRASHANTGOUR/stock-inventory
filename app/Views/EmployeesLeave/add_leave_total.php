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
    <?php 
      if(isset($Qty)) {
        $Count =  $Qty;
      } else { ?>
        <div class="row justify-content-center">
          <div class="row justify-content-center">
            <form action="" method="POST">
                <div class="form-group">
                <h3>Add Leave Total</h3>
                  <label for="q" class="col-form-label-lg">Year</label>
                  <select class="form-control form-control-lg" name="year" id="year" required>
                      <option value="">Select Year</option>
                          <?php
                          if($exit_year){
                              foreach($exit_year as $exit_year_val){
                                  $selected = '';
                                  if($selected_year == $exit_year_val){
                                    $selected = 'selected';
                                  }
                                  echo "<option value='".$exit_year_val."' ".$selected.">".$exit_year_val."</option>";
                              }
                          }
                          ?>
                  </select>
                </div>
                <div class="form-group" style="">
                  <label for="q" class="col-form-label-lg">Month</label>
                  <select class="form-control form-control-lg" name="month" id="month" required>
                      <option value="">Select Month</option>
                          <?php
                          if($exit_month){
                              foreach($exit_month as $exit_month_key=>$exit_month_val){
                                  $selected = '';
                                  if($selected_month == $exit_month_key){
                                    $selected = 'selected';
                                  }
                                  echo "<option value='".$exit_month_key."'".$selected.">".$exit_month_val."</option>";
                              }
                          }
                          ?>
                  </select>
                </div>
                <div class="form-group" style="">
                  <label for="q" class="col-form-label-lg">Hours</label>
                  <input type="number" class="form-control form-control-lg" min="0" required name="selected_hours" id="selected_hours" value="<?php echo $selected_hours;?>">
                </div>
                <div class="form-group" style="">
                  <label for="q" class="col-form-label-lg">Mintus</label>
                  <input type="number" class="form-control form-control-lg" min="0" required name="selected_mintus" id="selected_mintus" value="<?php echo $selected_mintus;?>">
                </div>
                <button id="saveButton" type="submit" class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0">
                  <span class="icon text-white">
                    <i class="fas fa-plus-circle"></i>
                  </span>
                  <span class="text">Save</span>
                </button>
            </form>
          </div>
        </div>
      </div>
      <?php }
      ?>
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
</div>
<?php 
echo $this->endSection();