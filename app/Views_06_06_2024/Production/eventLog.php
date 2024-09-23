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

if(!isset($StartDate)) {
  $StartDate = date("Y-m-d", strtotime("-1 days"));
  $EndDate = date("Y-m-d");
  $EventType = NULL;
} 
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
                        <form method="post" action="">
                          <select name="eventType">
                          <?php
                              $Types = $this->db->query("SELECT `name`, `title` FROM `8yxzEventLogType` ORDER BY `title`")->getResultArray();

                              foreach($Types as $Type) {
                                  if($Type['name'] == $EventType) {
                                    $Selected = "selected";
                                  } else {
                                    $Selected = NULL;
                                  }
                                  echo "<option value='".$Type['name']."' $Selected>".$Type['title']."</option>";
                              }
                          ?>
                          </select>

                          <input type="date" name="StartDate" value="<?php echo $StartDate;?>" required>
                          <input type="date" name="EndDate" value="<?php echo $EndDate; ?>" required>
                          <button type="submit">View</button>   
                          <a href="<?= url_to('Production::eventLog'); ?>">Clear</a>
                      </form>
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
        <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th>Date</th>
                      <th>Type</th>
                      <th>Product ID</ht>
                      <th>Details</th>
                      <th>User</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <?php
                      foreach ($events as $event) {
                      ?>
                      <tr>
                      <td class="align-middle"><?php echo $event['Date']; ?></td>
                        <td class="align-middle"><?php echo $event['EventType'];?></td>
                        <td class="align-middle"><?php echo $event['Product_Id'];?></td>
                        <td class="align-middle"><?php echo $event['EventDetails']; ?></td>
                        <td class="align-middle"><?php echo $event['User']; ?></td>

                      </tr>
                    <?php } ?>
                  </tbody>
                </table>

                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Products-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->



<?php 

echo $this->endSection();