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
                <h3>View Employees Leave</h3>
                  <input type="hidden" class="form-control form-control-lg" name="id" id="id" value="<?php echo $result['id']; ?>">
                  <label for="q" class="col-form-label-lg">Employees : </label>
                          <?php
                          if($employees){
                              foreach($employees as $employees_val){
                                  $selected = "";
                                  if($result['employee_id'] == $employees_val['id']){
                                      echo $employees_val['first_name']." ".$employees_val['last_name'];
                                  }
                              }
                          }
                          ?>
                </div>
                <div class="form-group">
                  <label for="q" class="col-form-label-lg">Leave Type : </label>
                      <?php
                        echo $result['leave_type']
                      ?>
                </div>
                <div class="form-group">
                  <label for="q" class="col-form-label-lg">Start Date : </label>
                  <?php echo $result['start_date'];?>
                </div>
                <div class="form-group">
                  <label for="q" class="col-form-label-lg">End Date : </label>
                  <?php echo $result['end_date'];?>
                </div>
                <div class="form-group">
                  <label for="q" class="col-form-label-lg">Remark : </label>
                  <?php echo $result['remark'];?>
                </div>
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