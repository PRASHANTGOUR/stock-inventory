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
                <h3>Edit Leave</h3>
                  <input type="hidden" class="form-control form-control-lg" name="id" id="id" value="<?php echo $result['id']; ?>">
                </div>
                <div class="form-group">
                  <label for="q" class="col-form-label-lg">Leave Type</label>
                  <select class="form-control form-control-lg" name="leave_type" id="leave_type" required>
                      <?php
                      if($leave_type){
                          foreach($leave_type as $leave_type_val){
                              $selected = "";
                                  if($result['leave_type'] == $leave_type_val['name']){
                                      $selected = "selected";
                                  }
                              echo "<option ".$selected." value='".$leave_type_val['name']."'>".$leave_type_val['name']."</option>";
                          }
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="q" class="col-form-label-lg">Start Date</label>
                  <input type="date" class="form-control form-control-lg" name="start_date" id="start_date" value="<?php echo $result['start_date'];?>" disabled>
                </div>
                <div class="form-group">
                  <label for="q" class="col-form-label-lg">End Date</label>
                  <input type="date" class="form-control form-control-lg" name="end_date" id="end_date" value="<?php echo $result['end_date'];?>" disabled>
                </div>
                <div class="form-group">
                  <label for="q" class="col-form-label-lg">Remark</label>
                  <textarea class="form-control form-control-lg" name="remark" id="remark" value="" required><?php echo $result['remark'];?></textarea>
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