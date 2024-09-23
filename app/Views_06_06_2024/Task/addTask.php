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
                <h3>Add Task</h3>
                </div>
                <div class="form-group">
                  <label for="q" class="col-form-label-lg">Remark</label>
                  <textarea class="form-control form-control-lg" name="remark" id="remark" value="" required></textarea>
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