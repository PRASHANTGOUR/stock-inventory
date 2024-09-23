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
      <!--begin::Card header-->
      <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        <!--begin::Card title-->
        <div class="card-title">
          <!--begin::Search-->
          <div class="d-flex align-items-center position-relative my-1">
            <form method="get">
              <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4 pt-4">
                <span class="path1"></span>
                <span class="path2"></span>
              </i>
              <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-12" name="s" placeholder="Search P Number" />
              <input type="hidden" name="t" value="<?php echo $Team; ?>"?>
            </form>
          </div>
          <!--end::Search-->
        </div>
        <?php if (auth()->user()->can('production.super')) {?>
        <!--end::Card title-->
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
          <form method="POST" action="<?= url_to('Production::setExpected'); ?>">
            <input type="hidden" name="team" value="<?php echo $Team; ?>">
            <input type="date" name="date" value="<?php echo date("Y-m-d"); ?>" placeholder="Date">
            <input type="number" name="expected" step="any" placeholder="Expected Coef">
          </form>
        </div>
        <?php } ?>
      </div>
      <!--end::Card header-->

      <!--begin::Card body-->
      <div class="card-body pt-0">
        <form method="post" action="<?= url_to('Production::submitProgress'); ?>">
          <input type="hidden" name="team" value="<?php echo $Team; ?>">

          <!--begin::Table-->
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>P Number</th>
                <th>AQ Code</th>
                <th>Deadline</th>
                <th>Product Name</th>
                <th>Coef</th>
                <th>Last Update</th>
                <th>Progress</th>
                <th>New Progress</th>
              </tr>
            </thead>
            <tbody>
              <?php
              //$TotalCoEff = NULL;
              function roundUpToAny($n, $x = 5)
              {
                return round(($n + $x / 2) / $x) * $x;
              }

              $p = 0;
              foreach ($products as $product) : ?>
                <?php

                // Fetch the progress and date for the closest previous day to today
                //$query = $this->db->query("SELECT coefficent, date FROM 8yxzprogress WHERE p_number = ? AND date < CURDATE() ORDER BY unique_key DESC LIMIT 1", [$product['pnumber']]);
                $query = $this->db->query("SELECT SUM(coefficent) AS total FROM 8yxzprogress WHERE product_id = ?", [$product['product_id']]);
                $row = $query->getRow();
                $previouscoef = $row ? $row->total : 0;

                #Products Co-Efficeent 
                $ProductCoEf = $product['coef'];
                #Convert Coef to percent
                $previous_progress = 0;
                if ($previouscoef > 0) {
                  $previous_progress = round(($previouscoef / $ProductCoEf) * 100);
                }
                //$product['coef']

                // Fetch the progress from the database where the date is equal to today's date
                $query = $this->db->query("SELECT date FROM 8yxzprogress WHERE product_id = ? ORDER BY date DESC LIMIT 1", [$product['product_id']]);
                //$query = $this->db->query("SELECT coefficent, total FROM 8yxzprogress WHERE p_number = ? ORDER BY unique_key DESC", [$product['pnumber']]);
                $row = $query->getRow();
                $previous_date = $row ? $row->date : null;

                $Progress = $previous_progress;

                ?>
                <tr>
                  <td class="align-middle"><?= $product['pnumber']; ?><br />
                    <?php if (auth()->user()->can('production.super')) { ?>
                      <a href="<?= url_to('Production::editUnit')."?p=". $product['product_id']; ?>"><i class="bi bi-pencil-square"></i></a>
                      <a href="<?= url_to('Production::addProductModification')?>?p=<?= $product['product_id']; ?>"><i class="bi bi-scissors"></i></a>
                    <?php } ?>
                    <a href="<?= url_to('Production::viewUnitProgressHistory')?>?p=<?= $product['product_id']; ?>"><i class="bi bi-clock-history"></i></a>

                  </td>
                  <td class="align-middle"><?= $product['aqcode']; ?></td>
                  <td class="align-middle"><?= $product['Deadline']; ?></td>
                  <td class="align-middle"><?= $product['productname']; ?></td>
                  <td class="align-middle"><?= $product['coef']; ?></td>
                  <td class="align-middle"><?= $previous_date; ?></td>
                  <td class="align-middle"><?= $previous_progress; ?>%</td>

                  <?php
                  if ($Progress < 100) { ?>
                    <input type="hidden" name="product_id[]" value="<?= $product['product_id']; ?>">
                    <input type="hidden" name="previous_date[]" value="<?= $previous_date; ?>">
                    <input type="hidden" name="co_efficent[]" value="<?= $product['coef']; ?>">
                    <input type="hidden" name="old_progress[]" value="<?= $previouscoef; ?>">
                    <input type="hidden" name="new_progress[]" id="NewProgress<?php echo $p; ?>" value="">

                  <?php }  ?>

                  <td class="align-middle text-center">
                    <?php if (intval($Progress) < 100) { ?>
                      <!-- Add the new progress dropdown for each product -->
                      <select style="max-width: 200px;" name="progress" onchange="update(this.value,<?php echo $p; ?>)">
                        <option disabled selected>No change</option>
                        <?php for ($i = roundUpToAny($Progress); $i <= 100; $i += 5) : ?>
                          <option value="<?= $ProductCoEf * ($i / 100); ?>"><?= $i; ?>%</option>
                        <?php endfor; ?>
                      </select>
                      <br />
                      Date:<br />
                      <input type="date" name="progress_date[]" value="">
                    <?php } else { ?>
                      <div style="display: flex; justify-content: center;">
                        <span class="icon" style="color: green">
                          <i class="fas fa-check"> Complete</i>
                          <?php /*<a href="<?php echo base_url('master/statustotesting') . "/?team=" . $Team . "&id=" . $product['product_id']; ?>">Move to Testing</a> */?>
                        </span>
                      </div>
                    <?php } ?>
                  </td>
                </tr>
              <?php
                $p++;
              endforeach; ?>
            </tbody>
          </table>
          <div class="row">
            <div class="col-lg-12">
              <button type="submit" class="btn btn-sm btn-primary btn-icon-split mt-4 rounded-0" style="float:right;">
                <span class="icon" style="color: white">
                  <i class="fas fa-check"></i>
                  <span class="text">Update Progress</span>
                </span>
              </button>
            </div>
          </div>
        </form> <!--end::Table-->
        <!-- Calculate the sum of Todays coef outside the table -->
        <?php
        #FROM 8yxzprogress
        $query = $this->db->query("SELECT SUM(coefficent) AS total FROM 8yxzprogress WHERE team = '$Team' AND date =CURDATE()");
        $row = $query->getRow();
        $TodayCoef = $row ? $row->total : 0;

        #From Modifications
        $query = $this->db->query("SELECT SUM(coef) AS total FROM 8yxzproduct_modification WHERE team = '$Team' AND date =CURDATE()");
        $row = $query->getRow();
        $TodayCoef += $row ? $row->total : 0;

        ?>

        <!-- Display Todays coef sum outside the table -->
        <div class="row">
          <div class="col-lg-12">
            <h4 style="float: right; color: red;">Todays Output: <?= $TodayCoef; ?></h4>
          </div>
        </div>
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
