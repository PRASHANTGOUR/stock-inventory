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

<style>
    .error_msg {

        color: red;

    }
</style>

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

                    <form action="" method="POST" id="frm_employees" onsubmit="return fun_frm_employees_leave_submit()"> <!--  -->



                        <div class="form-group">

                            <h3>Edit Employees Leave</h3>


                        </div>

                        <div class="form-group">
                            <input type="hidden" class="form-control form-control-lg" name="id" id="id" value="<?php echo $result['id']; ?>">
                            <label for="q" class="col-form-label-lg">Leave Type</label>

                            <select class="form-control form-control-lg" name="leave_type" id="leave_type" required>

                                <?php

                                if ($leave_type) {

                                    foreach ($leave_type as $leave_type_val) {

                                        $selected = "";

                                        if ($result['leave_type'] == $leave_type_val['name']) {

                                            $selected = "selected";
                                        }

                                        echo "<option " . $selected . " value='" . $leave_type_val['name'] . "'>" . $leave_type_val['name'] . "</option>";
                                    }
                                }

                                ?>

                            </select>

                        </div>

                        <div class="form-group">

                            <label for="q" class="col-form-label-lg">Start Date</label>

                            <input type="date" class="form-control form-control-lg" name="start_date" id="start_date" value="<?php echo $result['start_date']; ?>">

                            <span class="error_msg" id="start_date_error"></span>

                        </div>

                        <div class="form-group">

                            <label for="q" class="col-form-label-lg">End Date</label>

                            <input type="date" class="form-control form-control-lg" name="end_date" id="end_date" value="<?php echo $result['end_date']; ?>">

                            <span class="error_msg" id="end_date_error"></span>

                        </div>

                        <div class="form-group">

                            <label for="q" class="col-form-label-lg">Remark</label>

                            <textarea class="form-control form-control-lg" name="remark" id="remark" value="" required><?php echo $result['remark']; ?></textarea>

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

    </div>

<?php }



?>

</div>

<!--end::Container-->

</div>

<!--end::Post-->

</div>

<Script>
    function all_employee_changed(element) {
        if ($(element).prop('checked') == true) {
            $('#employee_id').removeAttr('required');
        } else {
            $('#employee_id').attr("required", true);
        }
    }

    function fun_frm_employees_leave_submit() {

        $('.error_msg').html('');

        var base_url = '<?php echo url_to('EmployeesLeave::checkEmployeesLeave'); ?>';

        $.ajax({

            type: "POST",

            url: base_url,

            dataType: 'json',

            data: $('#frm_employees').serialize(),

            success: function(responce) {

                if (responce.status == "success") {

                    window.location.replace(responce.url);

                    return true;

                } else {

                    $('#' + responce.field).html(responce.message);

                }

            }

        });

        return false;

    }
</Script>



<?php



echo $this->endSection();
