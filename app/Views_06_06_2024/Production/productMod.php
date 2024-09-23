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

          <a href="<?= base_url('master/daily'); ?>" class="btn btn-sm btn-default bg-gradient-light border rouned-0 btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>
        <div class="row justify-content-center">
        <form action="" method="POST" class="col-lg-5 col-md-6 col-sm-12  p-0">
    <?php 
      if(isset($modification_id)) {
        $Readonly = "readonly";
        echo "<input type='hidden' name='mod_id' id='mod_id' value='$modification_id' readonly>";
      } else {
        $Readonly = NULL;
      }
    ?>
    <div class="card rounded-0">
      <h5 class="card-header">Submit Product Modification - <?php echo $PNo;?></h5>
      <div class="card-body">
        <h5 class="card-title">Add New Product Modification</h5>

        <div class="form-group">
            <label for="product_id" class="col-form-label-lg">Product ID</label>
            <input type="text" class="form-control form-control-lg" name="product_id" id="product_id" value="<?php echo $productId;?>" required readonly>
        </div>

        <?php if(!isset($date)) {
          $date = date('Y-m-d');
        } 
        ?>
        <div class="form-group">
            <label for="date" class="col-form-label-lg">Date</label>
            <input type="date" class="form-control form-control-lg" name="date" id="date" value="<?php echo $date; ?>"required <?php /* echo $Readonly; */ ?>>
        </div>

        <div class="form-group">
            <label for="hours" class="col-form-label-lg">Hours</label>
            <input type="number" step="any" class="form-control form-control-lg" name="hours" id="hours" value="<?php if(isset($Coef)){echo $Coef / ($Norm / 8);}?>" required>
            <label for="hours" class="col-form-label-lg">Coefficent</label>
            <input type="number" step="0.001" name="coef" class="form-control form-control-lg" id="coef" value="<?php if(isset($Coef)){echo $Coef;}?>" required>
        </div>

        <div class="form-group">
            <label for="type" class="col-form-label-lg">Type</label>
            <select id="type" name="type" class="form-control form-control-lg" required>
              <option selected disabled>Select Reason</option>
              <?php
                  $Reasons = array(
                    "Admin",
                    "Cutting",
                    "Design",
                    "Printing",
                    'Testing',
                    'Warehouse',
                    'Other'
                  );

                  foreach($Reasons as $Select) {
                    $Selected = NULL;
                    if(isset($Type)){
                      if($Select == $Type){
                        $Selected = "selected";
                      }
                    }
                    echo "<option value='$Select' $Selected>$Select</option>";
                  }
              ?>
            </select>
            <?php /*<textarea min="0" id="reason" name="reason" class="form-control form-control-lg" placeholder="Please specifiy reason for change" rows="4" cols="50" required></textarea>*/ ?>
        </div>

        <div class="form-group">
            <label for="details" class="col-form-label-lg">Details</label>
            <textarea class="form-control form-control-lg" name="details" id="details" minlength="5" required><?php if(isset($Details)){echo $Details;}?></textarea>
        </div>
    
        <div class="form-group">
            <label for="team" class="col-form-label-lg">Team</label>
            <select class="form-control form-control-lg" name="team" id="team" required <?php echo $Readonly; ?>>
              <?php

              if(isset($CurrentTeam)) {
                $department = $CurrentTeam;
              } else {
                $department = $team;
              }
              $query = $this->db->query("SELECT `id` FROM `8yxzdepartment`WHERE `departmentId` = 1 ORDER BY LENGTH(`id`), `id`")->getResultArray();
              foreach ($query as $row) {
                $Team = $row['id'];
                $selected = ($Team == $department) ? "selected" : NULL;
                echo "<option value='$Team' $selected>$Team</option>";
              }
              ?>
            </select>
        </div>

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
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
                    </div>

<script>
<?php 
$row = $this->db->query("SELECT `norm` FROM `8yxznorm` WHERE `type` = 'Stitching';")->getRowArray(); 
$norm = $row['norm'];
?>

document.getElementById("hours").onchange = function() {ChangeCoef()};  

function ChangeCoef() {
  var $hours =  document.getElementById("hours").value;
  var $norm = <?php echo $norm; ?>;
  var $coef = (($hours * $norm) / 8).toFixed(3);
  console.log("Hours Entered " + hours + " Coef: " + $coef);
  document.getElementById("coef").value = $coef;
}

</script>

<?php 

echo $this->endSection();