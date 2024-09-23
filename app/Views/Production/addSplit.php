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
        <input type="hidden" name="ParentID" id="ParentID" value="<?php echo $prod_id;?>" readonly>
        <input type="hidden" name="SplitQty" id="SplitQty" value="<?php echo $qty;?>"  readonly>
        <input type="hidden" step="0.001" name="TotalStitchingCoef" id="TotalStitchingCoef" value="<?php echo $ProductCoef;?>" readonly>
        <h2>IMPORTANT!!! - ANY PROGRESS ALREADY DONE WILL BE AUTOMATICALLY APPLIED TO SPLIT 1</h2>
    <?php 
    for($i=0; $i<$qty; $i++) { 
        ?>
        <div class="card rounded-0">
         <h5 class="card-header">Split <?php echo $i+1; ?></h5>
            <div class="card-body">

                <div class="form-group">
                    <label for="SplitName" class="col-form-label-lg">Part Name</label>
                    <input type="text" class="form-control form-control-lg" name="SplitName[]" id="SplitName" required>
                </div>

                <div class="form-group">
                    <label for="SplitStitchCoef" class="col-form-label-lg">Part Stitching Co-efficent</label>
                    <input type="number" step="any" min="0.001" max="<?php echo $ProductCoef;?>" class="form-control form-control-lg" name="SplitStitchCoef[]" id="SplitStitchCoef" value="0" onkeyup="ChangeCoef(this.value)" required>
                </div>

                <div class="form-group">
                    <label for="SplitTeam" class="col-form-label-lg">Part Team</label>
                    <!-- Use $department_id to set the input field value -->
                    <select class="form-control form-control-lg" name="SplitTeam[]" id="SplitTeam" required>
                    <?php
                    $query = $this->db->query("SELECT `id` FROM `8yxzdepartment` WHERE `departmentId` = 1 ORDER BY LENGTH(`id`), `id`")->getResultArray();
                    foreach ($query as $row) {
                        $Team = $row['id'];
                        $selected = ($Team == $ParentTeam) ? "selected" : NULL;
                        echo "<option value='$Team' $selected>$Team</option>";
                    }
                    ?>
                    </select>
                </div>
            </div>
      </div>
      <br />
    <?php } ?>
        <div>
            <span id="TotaledCoef">Stitching Coef Allowance: <?php echo $ProductCoef;?> Total Allocated: 0 Unallocated: <?php echo $ProductCoef;?></span><br />
            <span id="TotaledCoefMessage"></span>
            <br/>
            <br/>
        </div>
        <button id="saveButton" type="submit" class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0" style="display: none;">
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
<script>


function ChangeCoef() {
var $StichCoef = document.getElementsByName('SplitStitchCoef[]');
var $max = document.getElementById('TotalStitchingCoef').value;
$max = parseFloat($max);
console.log('Max:'+$max);
  var $sum = 0;
  
    for (var i = 0; i < $StichCoef.length; i++) {
        $x = parseFloat($StichCoef[i].value);
        $sum += $x;
        console.log('Value'+i+': '+$x);
    }
  
  var $sum = $sum.toFixed(3);
  console.log('Total: '+$sum);
  var $unallocated = (parseFloat($max) - parseFloat($sum)).toFixed(3);

  document.getElementById('TotaledCoef').innerHTML = "Stitching Coef Allowance: " + $max + " Total Allocated: " + $sum + " Unallocated: " + $unallocated;
  if ( $max == $sum) {
    $message = "Good to go";
    document.getElementById('saveButton').style = "display: inline;"
  } else if ($sum < $max) {
    $message = "Assigned Coef too low";
    document.getElementById('saveButton').style = "display: none;"
  } else if ($sum > $max) {
    $message = "Coef Exceeds Parent";
    document.getElementById('saveButton').style = "display: none;"
  }
  document.getElementById('TotaledCoefMessage').innerHTML = $message;
}

</script>


<?php 

echo $this->endSection();