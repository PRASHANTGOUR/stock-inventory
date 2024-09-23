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
        <div class="row justify-content-center">
          <div class="row justify-content-center">
            <form action="" method="POST">
                <div class="form-group">
                <h3>Employee Holiday</h3>
                  <input type="hidden" name="id" id="id" value="<?php echo $result['id']; ?>"/>
                </div>
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-100px"><br>Year</th>
                            <?php 
                            if($leave_type){
                              foreach($leave_type as $leave_type_val){
                                echo '<th class="min-w-100px">how many <br>'.$leave_type_val['name']."</th>";
                              }
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $firstYear = 2023;
                    $currentYear = date('Y');
                    $lastYear = $currentYear + 5;
                    for($i=$firstYear;$i<=$lastYear;$i++){
                        echo '<tr>
                            <td>'.$i.'</td>';
                            if($leave_type){
                              foreach($leave_type as $leave_type_val){
                                $how_many = employees_how_many($result['id'], $i,$leave_type_val['id']);
                                echo '<td><input type="number" class="form-control form-control-lg" name="how_many['.$i.']['.$leave_type_val['id'].']" id="how_many_'.$leave_type_val['id'].'" value="'.$how_many.'"></td>';
                              }
                            }
                         echo '</tr>';
                    }
                    ?>
                  </tbody>
                </table>
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
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
</div>
<?php 
echo $this->endSection();