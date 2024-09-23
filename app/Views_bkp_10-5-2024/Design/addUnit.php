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
            <form action="" method="GET">
            <div class="form-group">
                <h3>Add Products</h3>
                  <label for="q" class="col-form-label-lg">Qty</label>
                  <!-- Use $department_id to set the input field value -->
                  <select class="form-control form-control-lg" name="q" id="q" required>
                          <?php
                          for($i=1; $i<11; $i++) {
                            echo "<option value='$i'>$i</option>";
                          }
                          ?>
                  </select>
                </div>
                <button id="saveButton" type="submit" class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0">
                  <span class="icon text-white">
                    <i class="fas fa-plus-circle"></i>
                  </span>
                  <span class="text">Next</span>
                </button>
            </form>
          </div>
        </div>
      </div>
      <?php }

      if(isset($Count)) { ?>



      <!-- Begin Page Content -->
      <!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->

        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <a href="javascript:window.history.go(-1);" class="btn btn-sm btn-default bg-gradient-light border rouned-0 btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>
        <div class="row justify-content-center">
          <form action="" method="POST" class="col-lg-5 col-md-6 col-sm-12  p-0">
            <?php 
              $i = 0;
              for($i; $i < $Count; $i++) { ?>
                <div class="card rounded-0">
                  <h5 class="card-header">Product <?php echo $i+1;?></h5>
                  <div class="card-body">
                    <h5 class="card-title">Add new work</h5>
                    <p class="card-text">Form to add new work for teams</p>

                    <div class="form-group">
                      <label for="d_pnumber[<?php echo $i;?>]" class="col-form-label-lg">P number *</label>
                      <input type="text" class="form-control form-control-lg" name="d_pnumber[<?php echo $i;?>]" id="d_pnumber[<?php echo $i;?>]" required>
                    </div>

                    <div class="form-group">
                      <label for="deadline[<?php echo $i;?>]" class="col-form-label-lg">Deadline *</label>
                      <input type="date" class="form-control form-control-lg" name="deadline[<?php echo $i;?>]" id="deadline[<?php echo $i;?>]" required>
                    </div>

                    <div class="form-group">
                      <label for="d_aqcode"[<?php echo $i;?>] class="col-form-label-lg">AQ Code *</label>
                      <input type="text" class="form-control form-control-lg" name="d_aqcode[<?php echo $i;?>]" id="d_aqcode[<?php echo $i;?>]" required>
                    </div>

                    <div class="form-group">
                      <label for="d_productname[<?php echo $i;?>]" class="col-form-label-lg">Product Name *</label>
                      <input type="text" class="form-control form-control-lg" name="d_productname[<?php echo $i;?>]" id="d_productname[<?php echo $i;?>]" required>
                    </div>

                    <div class="form-group">
                        <label for="Notes[<?php echo $i;?>]" class="col-form-label-lg">Notes (Optional)</label>
                        <textarea class="form-control form-control-lg" name="Notes[<?php echo $i;?>]" id="Notes[<?php echo $i;?>]" minlength="5"></textarea>
                    </div>


                    <div class="form-group">
                        <label for="d_statu[<?php echo $i;?>]s" class="col-form-label-lg">Status *</label>
                        <select class="form-control form-control-lg" name="d_status[<?php echo $i;?>]" id="d_status[<?php echo $i;?>]" required>
                            <option disabled>Select Status</option>
                            <option value="Admin">Admin</option>
                            <option value="Cutting">Cutting</option>
                            <option value="Design" selected>Design</option>
                            <option value="Production">Production</option>
                        </select>
                    </div>

                    <div class="form-group">
                    <?php 
                      if($Count == 1) {
                        if (auth()->user()->can('production.super')) { ?>}
                          <label for="Bulk" class="col-form-label-lg">Bulk Add</label>
                          <input type="checkbox" name="Bulk" id="Bulk" value="Yes"><br />
                          <label for="BulkQty" class="col-form-label-lg">How many</label>
                          <input type="number" name="BulkQty" id="BulkQty" step="1"><br />
                          <input type="hidden" name="BulkUnallocate" id="BulkUnallocate" value="Yes">
                      <?php 
                        }
                      } 
                    ?>
                    </div>
                  </div>
                </div>
              <?php } ?>

              <button id="saveButton" type="submit" class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0">
                <span class="icon text-white">
                <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Save</span>
              </button>
            
          </form>
          </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <?php } ?>
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
                    </div>


<?php 

echo $this->endSection();