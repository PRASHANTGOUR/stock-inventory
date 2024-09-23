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
<style>
.error_msg{
    color:red;
}

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
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
                    <div class="col-md-6">
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
                                            echo "<option value='" . $employees_list_val['id'] . "' " . $selected . ">" . srting_decrypt($employees_list_val['first_name']) . " " . srting_decrypt($employees_list_val['last_name']) . "</option>";
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
                                        <h3>Attendances<?php echo $employees_name;?></h3>
                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" onclick="close_function()" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>
    
                                    <div class="modal-body">
                                        <form action="" method="POST" id="frm_add_attendances" onsubmit="return fun_frm_add_attendances_submit()">
                                            <input type="hidden" name="type" value="manually" />
                                            <div class="form-group">
                                                <label for="q" class="col-form-label-lg">Badge Number</label>
                                                <input type="hidden" value="<?= $employees_id; ?>" name="employees_id" />
                                                <input type="text" class="form-control form-control-lg" name="badge_number" id="badge_number" value="" required="">
                                                <span class="error_msg" id="error_attendance"></span>
                                            </div>
    
    
                                            <button id="saveButton" type="submit" class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0">
                                                <span class="icon text-white">
                                                    <i class="fas fa-plus-circle"></i>
                                                </span>
                                                <span class="text">Submit</span>
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

                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="q" class="col-form-label-lg"></label>
                            <input type="text" class="form-control form-control-lg" name="badge_number" id="badge_number_scan" value="" autofocus>
                        </div>
                        <span class="error_msg" id="error_attendance_scan"></span>
                        
                        <!--<div id="interactive" class="viewport"></div>-->
                        <!--<div class="mb-4">-->
                        <!--    <a class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0" id="startButton">Start time</a>-->
                            <!--<a class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0" id="resetButton">Reset</a>-->
                        <!--</div>-->
                        
                        <!--<div style="padding: 0px; width: 100%; max-height: 300px; overflow:hidden; border: 1px solid gray">-->
                        <!--    <video id="video" style="width: 100%;"></video>-->
                        <!--</div>-->
                        
                        
                        <!--<div id="sourceSelectPanel" style="display:none">-->
                        <!--    <label for="sourceSelect">Change video source:</label>-->
                        <!--    <select id="sourceSelect" style="max-width:600px">-->
                        <!--    </select>-->
                        <!--</div>-->
            
                        <!--<label style="display:none">Result:</label>-->
                        <!--<pre style="display:none"><code id="result"></code></pre>-->
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
<script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>

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
                 $('.error_msg').html('');
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
function fun_frm_add_attendances_submit(){
    $('.error_msg').html('');
    var base_url = '<?php echo url_to('Attendances::addAttendances');?>';
    $.ajax({
	 	type: "POST",
	 	url: base_url,
	  	dataType: 'json',
	  	data: $('#frm_add_attendances').serialize(),
	  	success: function(responce){
	   	 	if(responce.status == "success"){
	   	 	    alert(responce.message);
	   	 	    window.location.replace(responce.url);
	   	 	    return true;
	   	 	}else{
	   	 	    $('#error_attendance').html(responce.message);
	   	 	}
	  	}
	});
	return false;
}     
</script>
<script type="text/javascript">

    // window.addEventListener('load', function () {
    //     let selectedDeviceId;
    //     const codeReader = new ZXing.BrowserMultiFormatReader()
    //     console.log('ZXing code reader initialized')
    //     codeReader.getVideoInputDevices()
    //         .then((videoInputDevices) => {
    //             const sourceSelect = document.getElementById('sourceSelect')
    //             selectedDeviceId = videoInputDevices[0].deviceId
    //             if (videoInputDevices.length > 1) {
    //                 videoInputDevices.forEach((element) => {
    //                     const sourceOption = document.createElement('option')
    //                     sourceOption.text = element.label
    //                     sourceOption.value = element.deviceId
    //                     sourceSelect.appendChild(sourceOption)
    //                 })

    //                 sourceSelect.onchange = () => {
    //                     selectedDeviceId = sourceSelect.value;
    //                 }

    //                 const sourceSelectPanel = document.getElementById('sourceSelectPanel')
    //                 sourceSelectPanel.style.display = 'block'
    //             }

    //             document.getElementById('startButton').addEventListener('click', () => {
    //                 // alert("AAA");
    //                 codeReader.decodeOnceFromVideoDevice(selectedDeviceId, 'video').then((result) => {
    //                     // alert("BBBB");
    //                     // console.log(result);
    //                     let final_result = result.text.split("A");
    //                     document.getElementById('result').textContent = final_result[0]
    //                     if(final_result[0] != ''){
    //                         var base_url = '<?php //echo url_to('Attendances::addAttendances');?>';
    //                         $.ajax({
    //                     	 	type: "POST",
    //                     	 	url: base_url,
    //                     	  	dataType: 'json',
    //                     	  	data: {"type":"barcode","employees_id":final_result[0]},
    //                     	  	success: function(responce){
    //                     	   	 	if(responce.status == "success"){
    //                     	   	 	    alert(responce.message);
    //                     	   	 	    window.location.replace(responce.url);
    //                     	   	 	    return true;
    //                     	   	 	}else{
    //                     	   	 	    $('#error_attendance').html(responce.message);
    //                     	   	 	}
    //                     	  	}
    //                     	});
    //                     	return false;
    //                     }
    //                 }).catch((err) => {
    //                     // alert("CCCC");
    //                     // console.error(err)
    //                     // document.getElementById('result').textContent = err
    //                 })
    //                 console.log(`Started continous decode from camera with id ${selectedDeviceId}`)
    //             })

    //             document.getElementById('resetButton').addEventListener('click', () => {
    //                 document.getElementById('result').textContent = '';
    //                 codeReader.reset();
    //                 console.log('Reset.')
    //             })

    //         })
    //         .catch((err) => {
    //             console.error(err)
    //         })
    // })
var intervalID = setInterval(function() {
   
    let result = document.getElementById('badge_number_scan').value;
     console.log('heroVel2',result);
    if(result != ''){
        clearInterval(intervalID); // Stop the timer
        var base_url = '<?php echo url_to('Attendances::addAttendances');?>';
        $.ajax({
            type: "POST",
            url: base_url,
            dataType: 'json',
            data: {"type":"barcode","employees_id":"","badge_number":result},
            success: function(responce){
                if(responce.status == "success"){
                    // alert(responce.message);
                    Swal.fire({
                      title: responce.message,
                      timer: 3000, // Auto close after 3 seconds
                      timerProgressBar: true,
                      onBeforeOpen: () => {
                        Swal.showLoading();
                      },
                      allowOutsideClick: false,
                    }).then((result) => {
                      if (result.dismiss === Swal.DismissReason.timer) {
                        // Timer was fired
                        // Reload the page
                        window.location.replace(responce.url);
                        return true;
                      }
                    });
                }else{
                    // $('#error_attendance_scan').html(responce.message);
                    // alert(responce.message);
                    window.location.replace(responce.url);
                    Swal.fire({
                      title: responce.message,
                      timer: 3000, // Auto close after 3 seconds
                      timerProgressBar: true,
                      onBeforeOpen: () => {
                        Swal.showLoading();
                      },
                      allowOutsideClick: false,
                    }).then((result) => {
                      if (result.dismiss === Swal.DismissReason.timer) {
                        // Timer was fired
                        // Reload the page
                        window.location.replace(responce.url);
                        return true;
                      }
                    });
                }
            }
        });
    }
}, 1000);
</script>

<?php
echo $this->endSection();
