<?php
# Call in main template
echo $this->extend('layouts/default2');
# Meta title Section 
// echo $this->section('heading');
// echo $title;
// echo $this->endSection();
// echo $this->section('sidebar'); 
// echo $this->endSection();
# Main Content
echo $this->section('content');
$this->db = db_connect();
$employees_id =  isset($_GET['employees_id']) ? $_GET['employees_id'] : '';

// print_r($employees_details);
?>
<!--begin::Post-->
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div class="container-xxl">
        <?php
        if (isset($Qty)) {
            $Count =  $Qty;
        } else { ?>
            <div class="row justify-content-center">
                <div class="row justify-content-center">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="q" class="col-form-label-lg">Employees</label>
                            <select class="form-control form-control-lg" name="employees_id" id="employees_id" required onchange="fun_change_employees(this.value)">
                                <option value="">Select Employees</option>
                                <?php
                                if ($employees_list) {
                                    foreach ($employees_list as $employees_list_val) {
                                        $selected = '';
                                        if ($employees_id == $employees_list_val['id']) {
                                            $selected = 'selected';
                                        }
                                        echo "<option value='" . $employees_list_val['id'] . "' " . $selected . ">" . $employees_list_val['first_name'] . " " . $employees_list_val['last_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <!-- <button id="saveButton" type="submit" class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0">
                            <span class="icon text-white">
                                <i class="fas fa-plus-circle"></i>
                            </span>
                            <span class="text">Save</span>
                        </button> -->
                    </form>


                    <button id="modalTriggerBtn" type="button" class="d-none" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                        Launch demo modal
                    </button>

                    <div class="modal fade" tabindex="-1" id="kt_modal_1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Modal title</h3>

                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" onclick="close_function()" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                    </div>
                                    <!--end::Close-->
                                </div>

                                <div class="modal-body">
                                    <form action="" method="POST">

                                        <div class="form-group">
                                            <label for="q" class="col-form-label-lg">Pin Code</label>
                                            <input type="hidden" value="<?= $employees_id; ?>" name="employees_id" />
                                            <input type="text" class="form-control form-control-lg" name="code" id="code" value="" required="">
                                        </div>


                                        <button id="saveButton" type="submit" class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0">
                                            <span class="icon text-white">
                                                <i class="fas fa-plus-circle"></i>
                                            </span>
                                            <span class="text">Save</span>
                                        </button>
                                    </form>
                                </div>

                                <!-- <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" onclick="close_function()">Close</button>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
<?php } ?>
</div>
<!--end::Container-->
</div>
<!--end::Post-->
</div>
<script>
    function fun_change_employees(employees_id) {
        window.location.href = '<?php echo url_to('Attendances::addAttendances'); ?>?employees_id=' + employees_id;
    }

    function close_function() {
        window.location.href = '<?php echo url_to('Attendances::addAttendances'); ?>';
    }


    <?php

    if ($employees_id != '') {
    ?>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the modal trigger button by ID
            var modalTriggerBtn = document.getElementById('modalTriggerBtn');
            // If the modal trigger button exists
            if (modalTriggerBtn) {
                // Simulate a click event on the modal trigger button to open the modal
                modalTriggerBtn.click();
            }

            // Handle modal close when clicking outside the modal content
            var modalElement = document.getElementById('kt_modal_1');
            modalElement.addEventListener('click', function(event) {
                // Check if the click target is the modal backdrop (outside the modal content)
                if (event.target === modalElement) {
                    // Dismiss the modal (close it)
                    var modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                        window.location.href = '<?php echo url_to('Attendances::addAttendances'); ?>';
                    }
                }
            });
        });
    <?php } ?>
</script>
<?php
echo $this->endSection();
