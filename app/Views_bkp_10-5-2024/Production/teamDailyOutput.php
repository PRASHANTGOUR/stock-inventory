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
    <!--begin::Products-->
    <div class="card card-flush">

      <!--begin::Card body-->
      <div class="card-body pt-0">
          <!--begin::Table-->
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>P Number</th>
                <th>Name</th>
                <th>Date</th>
                <th>Output</th>
                <th>Total Progress</th>
              </tr>
            </thead>
            <tbody>
              <?php
               $runningProgress = 0;

               foreach ($outputs as $output) {
                   $SN = $output['pnumber']; 
                   $Name = $output['productname'];
                   $coef = $output['coefficent'];
                   $runningProgress += $coef;

                   ?>
                   <tr>
                       <td class="align-middle"><?php echo $SN ?>
                          <a href="<?= url_to('Production::viewUnitProgressHistory')?>?p=<?= $output['product_id']; ?>">
                            <span class="icon text-white" title="History">
                              <i class="bi bi-clock-history"></i>
                            </span>
                          </a>
                        </td>
                       <td class="align-middle"><?php echo $Name ?></td>
                       <td class="align-middle"><?php echo $date ?></td>
                       <td class="align-middle"><?php echo $coef ?></td>
                       <td class="align-middle"><?php echo $runningProgress ?></td>
                   </tr>
                <?php } ?>
                <tr>
                    <td colspan="4">Total</td>
                    <td><?php echo $runningProgress; ?> </td>
                </tr>
                <tr><td colspan="5"></td></tr>
                    
                <tr>
                    <td colspan="4">Modifications</td>
                    <td>Reason</td>
                </tr>
                <?php
                #Modifications Output
                $query = $this->db->query("SELECT `pnumber`, `8yxzproduct_modification`.`coef`, `date`, `type`, `details` FROM `8yxzproduct_modification` INNER JOIN `8yxzproducts` ON `8yxzproduct_modification`.`product_id` = `8yxzproducts`.`product_id` WHERE team = '$team' AND `date` = '$date' ");
                $results = $query->getResultArray();

                $ModCeof = NULL;
                if(!empty($results)) {
                    foreach ($results as $row) { 
                        $ModCeof += $row['coef'];
                        ?>
                            <tr>
                                <td class="align-middle"><?php echo $row['pnumber']; ?></td>
                                <td class="align-middle"><?php echo $row['date']; ?></td>
                                <td class="align-middle"><?php echo $row['coef']; ?></td>
                                <td class="align-middle"><?php echo $row['type'].' Details: '.$row['details']; ?></td>
                            </tr>
                        <?php 
                    }
                } else {
                    echo "<tr><td colspan='4' class='align-middle'>No Modifications Found</td></tr>";
                }

                $Total = $ModCeof + $runningProgress;
                if(!empty($expected)) {
                  $TotalPercent = number_format(($Total / $expected) * 100, 2)."% ";
                  $Expected = " / ".$expected;
                } else {
                  $TotalPercent = NULL;
                  $Expected = NULL;
                }


                ?>

             <tr>
                 <td colspan="4">Total inc modifications</td>
                 <td><?php echo $TotalPercent.$Total.$Expected;?> </td>
             </tr>
            </tbody>
          </table>
          <?php if (auth()->user()->can('production.super')) { ?>
            <div class="row">
                <div class="col-lg-12">
                  <h2>Set Expected Output</h2>
                   <form method="POST" action="<?= url_to('Production::setExpected'); ?>">
                      <input type="hidden" name="team" value="<?php echo $team;?>">
                      <input type="hidden" name="date" value="<?php echo $_GET['d'];?>" placeholder="Date">
                      <input type="number" name="expected" step="any" value="<?php echo $expected;?>" placeholder="Expected Coef">
                      <?php /*<input type="number" name="manual" step="any" value="" placeholder="Maual Coef Entry">*/ ?>
                      <button type="submit">Set Expected</button>
                    </form>
                  </div>
              </div>
            <?php } ?>

        </form> <!--end::Table-->
      </div>
      <!--end::Card body-->

    </div>
    <!--end::Products-->
  </div>
  <!--end::Container-->
</div>
<!--end::Post-->

<script>
  // Wait for the document to be fully loaded
  document.addEventListener('DOMContentLoaded', function() {
    // Get all the dropdowns with the name "d_progress"
    const dropdowns = document.querySelectorAll('select[name="d_progress"]');

    // Loop through each dropdown and add an event listener for "change" event
    dropdowns.forEach(function(dropdown) {
      dropdown.addEventListener('change', function() {
        // Get the original progress value from the "data-progress" attribute
        const originalProgress = parseInt(dropdown.getAttribute('data-progress'));

        // Get the selected value from the dropdown
        const selectedValue = parseInt(dropdown.value);

        // If the selected value is less than the original progress value,
        // revert the selection back to the original progress value
        if (selectedValue < originalProgress) {
          dropdown.value = originalProgress;
        }
      });
    });
  });

  // Wait for the document to be fully loaded
  document.addEventListener('DOMContentLoaded', function() {
    // Get the hidden input field
    const todayDateInput = document.getElementById('today_date');

    // Get the current date in "YYYY-MM-DD" format
    const currentDate = new Date().toISOString().split('T')[0];

    // Set the current date as the value of the hidden input field
    todayDateInput.value = currentDate;
  });

  //Basic JS to set hidden prgoress value from select if changed
  function update($value, $id) {
    document.getElementById("NewProgress" + $id).value = $value
  }
</script>

<?php

echo $this->endSection();
