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

            <form action="" method="POST">

                <div class="form-group">

                <h3>Add Employee</h3>

                <input type="hidden" name="id" id="id" value="<?php echo $result['id']; ?>"/>

                  <label for="q" class="col-form-label-lg">Department</label>

                  <select class="form-control form-control-lg" name="department_id" id="department_id" required>

                      <option value="">Select Department</option>

                          <?php

                          if($departments){

                              foreach($departments as $department){

                                  $selected = "";

                                  if($result['department_id'] == $department['id']){

                                      $selected = "selected";

                                  }

                                  echo "<option ".$selected." value='".$department['id']."'>".$department['department']."</option>";

                              }

                          }

                          ?>

                  </select>

                </div>

                

                <div class="form-group">

                  <label for="q" class="col-form-label-lg">First Name</label>
                  <?php 
                  $first_name = srting_decrypt($result['first_name']);
                  ?>
                  <input type="text" class="form-control form-control-lg" name="first_name" id="first_name" value="<?php echo $first_name; ?>" required>

                </div>

                

                <div class="form-group">

                  <label for="q" class="col-form-label-lg">Last Name</label>
                  <?php 
                  $last_name = srting_decrypt($result['last_name']);
                  ?>        
                  <input type="text" class="form-control form-control-lg" name="last_name" id="last_name" value="<?php echo $last_name; ?>" required>

                </div>

                

                <div class="form-group">
                <?php 
                  $email = srting_decrypt($result['email']);
                  ?>        
                  <label for="q" class="col-form-label-lg">Email</label> : <?php echo $email; ?>

                </div>

                

                <div class="form-group">

                  <label for="q" class="col-form-label-lg">Phone</label>

                  <input type="text" class="form-control form-control-lg" name="phone_number" id="phone_number" value="<?php echo $result['phone_number']; ?>" required>

                </div>
                <div class="form-group">

                  <label for="q" class="col-form-label-lg">Badge Number</label>

                  <input type="text" class="form-control form-control-lg" name="badge_number" id="badge_number" value="<?php echo $result['badge_number']; ?>" required>

                </div>

                <div class="form-group" style="display: none;">

                  <label for="q" class="col-form-label-lg">how many holidays</label>

                  <input type="number" class="form-control form-control-lg" name="how_many_holidays" id="how_many_holidays" value="0">

                  </div>

                <div class="form-group">

                  <label for="q" class="col-form-label-lg">Address</label>

                  <textarea class="form-control form-control-lg" name="address" id="address" required><?php echo $result['address']; ?></textarea>

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
        <div class="card card-flush" style="margin-top: 20px;">
          <div class="card-body pt-0"style="margin-top: 20px;">

              <?php 
            echo log_Employees_list($result['id']);
            ?>  
          </div>
        </div>
      </div>

      <?php }



      ?>

    </div>

    <!--end::Container-->

</div>

<!--end::Post-->

                    </div>





<?php 



echo $this->endSection();