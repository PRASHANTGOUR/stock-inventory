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
            <h5 class="card-header">Works</h5>
            <div class="card-body">
              <h5 class="card-title">Edit Product Number <?php echo $result['pnumber']; ?></h5>


              <input type="hidden" name="product_id" value="<?php echo $result['product_id']; ?>">
              <div class="form-group">
                <label for="d_pnumber" class="col-form-label-lg"><?php echo $result['pnumber']; ?></label>
                <input type="text" class="form-control form-control-lg" name="d_pnumber" id="d_pnumber" value="<?php echo $result['pnumber']; ?>" required>
              </div>

              <div class="form-group">
                <label for="deadline" class="col-form-label-lg">Deadline</label>
                <input type="date" class="form-control form-control-lg" name="deadline" id="deadline" value="<?php echo $result['Deadline']; ?>" required>
              </div>

              <div class="form-group">
                <label for="d_aqcode" class="col-form-label-lg">(AQ Code)</label>
                <input type="text" class="form-control form-control-lg" name="d_aqcode" id="d_aqcode" value="<?php echo $result['aqcode']; ?>" required>
              </div>

              <div class="form-group">
                <label for="d_productname" class="col-form-label-lg">Product Name</label>
                <input type="text" class="form-control form-control-lg" name="d_productname" id="d_name" value="<?php echo $result['productname']; ?>" required>
              </div>

              <div class="form-group">
                <label for="Notes" class="col-form-label-lg">Notes</label>
                <textarea class="form-control form-control-lg" name="Notes" id="Notes" minlength="5"><?php echo $result['Notes']; ?></textarea>
              </div>

              <div class="form-group">
                <label class="col-form-label-lg">Realisation (Co-efficent)</label>
                <input type="number" step='any' class="form-control form-control-lg" id="OldCoef" name="OldCoef" value="<?php echo $result['coef']; ?>" readonly>

                <label for="ChangeCoef" class="col-form-label-lg">Adjust Co-efficent</label>
                <input type="checkbox" id="ChangeCoef" name="ChangeCoef">

                <div id="ChangeCoefContainer" style="display: none;">
                  <label for="d_coef" class="col-form-label-lg">Realisation (Co-efficent)</label>
                  <input type="number" step='any' class="form-control form-control-lg" name="d_coef" id="d_coef" value="<?php echo $result['coef']; ?>">
                  <br />
                  <textarea min="0" id="CoefNotes" name="CoefNotes" class="form-control form-control-lg" placeholder="Please specifiy reason for change" rows="4" cols="50"></textarea>
                </div>


              </div>

              <div class="form-group">
                <label for="d_status" class="col-form-label-lg">Status</label>
                <select class="form-control form-control-lg" name="d_status" id="d_status" required>
                  <?php
                  $StatusArray = array("Design", "Cutting", "Production",  "Testing", "Complete");
                  $CurrentStatua = $result['status'];
                  foreach ($StatusArray as $Status) {
                    if ($CurrentStatua == $Status) {
                      $Selected = "selected";
                    } else {
                      $Selected = NULL;
                    }
                    echo "<option value='$Status'$Selected>$Status</option>";
                  }
                  ?>
                </select>
              </div>

              <?php
              $department = $result['department_id'];

              if ($department != "Split") { ?>
                <div class="form-group">
                  <label for="d_department_id" class="col-form-label-lg">Team</label>
                  <!-- Use $department_id to set the input field value -->
                  <select class="form-control form-control-lg" name="d_department_id" id="d_department_id" required>
                    <?php

                    $query = $this->db->query("SELECT `id` FROM `8yxzdepartment` WHERE `departmentId` = 1 ORDER BY LENGTH(`id`), `id`")->getResultArray();
                    foreach ($query as $row) {
                      $Team = $row['id'];
                      $selected = ($Team == $department) ? "selected" : NULL;
                      echo "<option value='$Team' $selected>$Team</option>";
                    }
                    ?>
                  </select>
                </div>
              <?php } else { ?>
                <input type="hidden" name="d_department_id" id="d_department_id" value="<?= $department ?>" required>
              <?php } ?>


              <button id="saveButton" type="submit" class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0">
                <span class="icon text-white">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Save</span>
              </button>

            </div>
          </div>
        </form>
      </div>





    <?php if ($department != "Split" and empty($result['parent'])) { ?>
      <div class="row justify-content-center">
        <form action="<?= url_to('Production::splitPNo'); ?>" method="GET" class="col-lg-5 col-md-6 col-sm-12 p-0">
          <div class="card rounded-0">
            <h5 class="card-header">Split</h5>
            <div class="card-body">
                <input type="hidden" name="id" value="<?php echo $result['product_id']; ?>" >
                <div class="form-group">
                  <h3>Product can only be split 1 time</h3>
                  <label for="q" class="col-form-label-lg">Qty</label>
                  <!-- Use $department_id to set the input field value -->
                  <select class="form-control form-control-lg" name="q" id="q" required>
                    <?php
                    for ($i = 2; $i < 11; $i++) {
                      echo "<option value='$i'>$i</option>";
                    }
                    ?>
                  </select>
                </div>
                <button id="saveButton" type="submit" class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0">
                  <span class="icon text-white">
                    <i class="bi bi-signpost-split"></i>
                  </span>
                  <span class="text">Split</span>
                </button>
            </div>
          </div>
        </form>
      </div>
    <?php } ?>



  </div>
  <?php
  if ($progress <= 0 and $department != "Split" and empty($result['parent'])) { ?>
    <div class="row justify-content-center">
      <form method="post" action="<?= url_to('Production::deleteUnit'); ?>" class="col-lg-5 col-md-6 col-sm-12  p-0">
        <input type="hidden" name="product_id" value="<?php echo $result['product_id']; ?>">
        <button id="saveButton" type="submit" class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0">
                <span class="icon text-white">
                  <i class="bi bi-trash"></i>
                </span>
                <span class="text">Delete</span>
              </button>
      </form>
    </div>
  <?php } ?>

  </div>
  <!-- /.container-fluid -->

</div>




<script>
  document.getElementById("ChangeCoef").onclick = function() {
    ChangeCoef()
  };

  function ChangeCoef() {
    if (document.getElementById("ChangeCoef").checked) {
      console.log("Checked");
      document.getElementById("ChangeCoefContainer").style.display = 'block';
    } else {
      console.log("Un Checked");
      document.getElementById("ChangeCoefContainer").style.display = 'none';
      var $OldCoef = document.getElementById("OldCoef").value;
      document.getElementById("d_coef").value = $OldCoef;
      document.getElementById("CoefNotes").value = "";
    }
  }
</script>


<?php

echo $this->endSection();
