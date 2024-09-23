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
                <th>Date</th>
                <th>Team</th>
                <th>Output</th>
                <th>Total Progress</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $runningProgress = 0;

                  $Title = $PNumber;

                  foreach ($outputs as $output) {
                      if($Title != $output['pnumber'] AND $department_id == "Split") { ?>
                        <tr>
                          <td colspan="4">
                            <?php 
                            echo $output['pnumber'];
                            $Title = $output['pnumber'];
                            ?>
                          </td>
                        </tr>
                      <?php } 
                      $date = $output['date']; 
                      $team = $output['team'];
                      $coef = $output['coefficent'];
                      $runningProgress += $coef;
                      $Percent = round(($runningProgress/ $ProductCoef) *100)."% (". $runningProgress.")";

                      ?>
                      <tr>
                          <td class="align-middle"><?php echo $date ?> 
                            <?php if (auth()->user()->can('production.super')) { ?>
                              <a href="<?= url_to('Production::editProductProgress').'?p='.$output['unique_key']; ?>">
                                <span class="icon text-white" title="Edit">
                                  <i class="bi bi-pencil-square"></i>
                                </span>
                              </a>
                            <?php } ?>
                          </td>
                          <td class="align-middle"><?php echo $team ?></td>
                          <td class="align-middle"><?php echo $coef ?></td>
                          <td class="align-middle"><?php echo $Percent ?></td>
                      </tr>
                      <?php } 
                    $Progress = round(($runningProgress/ $ProductCoef) *100);
                    ?>
                    <tr>
                        <td colspan="3">Total</td>
                        <td><?php echo "$runningProgress($ProductCoef) ($Progress%)"; ?> </td>
                    </tr>
                    <tr><td colspan="4"></td></tr>
                        
                    <tr>
                        <td colspan="3">Modifications</td>
                        <td>Reason</td>
                    </tr>
                    <?php
                    #Modifications Output
                    $ModCeof = NULL;
                    if(!empty($modifciations)) {
                        foreach ($modifciations as $row) { 
                        $ModCeof += $row['coef'];
                        ?>
                                <tr>
                                    <td class="align-middle"><?php echo $row['date']; ?> 
                                      <?php if (auth()->user()->can('production.super')) { ?>
                                        <a href="<?=url_to('Production::editProductModification').'?m='.$row['id']; ?>">Edit</a>
                                      <?php } ?>
                                    </td>
                                    <td class="align-middle"><?php echo $row['team']; ?></td>
                                    <td class="align-middle"><?php echo $row['coef']; ?></td>
                                    <td class="align-middle"><?php echo $row['type'].' Details - '.$row['details']; ?></td>
                                </tr>
                        <?php 
                        }
                    } else {
                        echo "<tr><td colspan='5' class='align-middle'>No Modifications Found</td></tr>";
                    }
                    ?>
                    <tr>
                        <td colspan="3">Total inc modifications</td>
                        <td><?php echo $ModCeof + $runningProgress;?> </td>
                    </tr>            </tbody>
          </table>

          <?php 
            foreach($eventLog as $event) {
              $date = $event['Date'];
              $type = $event['EventType'];
              $details = $event['EventDetails'];
              $user = $event['User'];

              echo "Date: $date User: $user Details: $details<br/>";
            }
          ?>

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
