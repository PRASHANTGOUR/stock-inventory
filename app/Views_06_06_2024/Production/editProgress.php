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
                <div class="card rounded-0">
                  <h5 class="card-header">Progress</h5>
                  <div class="card-body">
                    <h5 class="card-title">Add new work</h5>
                    <h5 class="card-title">Edit Progress Submit <?php echo $output['product_id'];?></h5>

                    <input type="hidden" name="id" value="<?php echo $output['unique_key'];?>">

                    <div class="form-group">
                      <label for="sn" class="col-form-label-lg">Product ID</label>
                      <input type="text" class="form-control form-control-lg" name="sn" id="sn" value="<?php echo $output['product_id'];?>" required readonly>
                    </div>

                    <div class="form-group">
                      <label for="date" class="col-form-label-lg">Date</label>
                      <input type="date" class="form-control form-control-lg" name="date" id="date" value="<?php echo $output['date'];?>" required>
                    </div>

                    <div class="form-group">
                      <label for="coef" class="col-form-label-lg">Realisation (Co-efficent)</label>
                      <input type="number" step='any' class="form-control form-control-lg" id="coef" name="coef" value="<?php echo $output['coefficent'];?>">          
                    </div>

                    <div class="form-group">
                      <label for="team" class="col-form-label-lg">Team *</label>
                      <!-- Use $department_id to set the input field value -->
                      <select class="form-control form-control-lg" name="team" id="team" required>
                      <?php
                        //$department = $this->input->get('team');
                        $query = $this->db->query("SELECT `id` FROM `8yxzdepartment` WHERE `departmentId` = 1 ORDER BY LENGTH(`id`), `id`");
                        foreach ($query->getResultArray() as $row) {
                          $Team = $row['id'];
                          $selected = ($Team == $output['team']) ? "selected" : NULL;
                          echo "<option value='$Team' $selected>$Team</option>";
                        }
                      ?>
                      </select>
                    </div>
                  </div>
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
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
                      </div>


<?php 

echo $this->endSection();