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

$encrypter = \Config\Services::encrypter();

$designersArray = array_column($designers, 'name', 'id');

$phases = array_column($phases, 'title', 'id');

if (!empty($getDesigner)) {

  $getDesigner = $getDesigner;

} else {

  $getDesigner = NULL;

}



if (!empty($getPhase)) {

  $getPhase = $getPhase;

} else {

  $getPhase = NULL;

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

                        <form method="post" action="<?= url_to('Design::searchUnits')?>">

                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4 pt-4">

                            <span class="path1"></span>

                            <span class="path2"></span>

                        </i>

                        <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-12" name="search" placeholder="Search P Number" />

                        </form>

                    </div>

                    <!--end::Search-->

                </div>

                <!--end::Card title-->

                <?php  //if (auth()->user()->can('design.super')) { ?>

                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                  <form action="<?=url_to('Design::filterDesignersUnits')?>">

                    <select name="designer" class="form-select form-select-solid">

                      <?php

                          foreach($designers as $designer) {

                            $selected = NULL;

                            if($getDesigner == $designer['id']) {

                              $selected = "selected";

                            }

                            echo "<option value='".$designer['id']."' $selected>".$encrypter->decrypt(base64_decode($designer['name']))."</option>";

                          }

                      ?>

                    </select>

                    <button type="submit" class="btn btn-primary">Filter Designers</button>

                  </form>

                  <form action="<?=url_to('Design::filterPhaseUnits')?>" method="GET">

                    <select name="phase" class="form-select form-select-solid">

                      <?php

                          foreach($phases as $id => $title) {

                            $selected = NULL;

                            if($getPhase == $id) {

                              $selected = "selected";

                            }

                            echo "<option value='".$id."' $selected>".$title."</option>";

                            #$name = $encrypter->decrypt(base64_decode($designer['name']));

                            #echo "<option value='".$designer['aqId']."'></option>";

                          }

                      ?>

                    </select>

                    <button type="submit" class="btn btn-primary">Filter Status</button>

                  </form>

                  <a href="<?= url_to('Design::unallocatedUnits');?>" class="btn btn-primary">

                    <span class="text">Unallocated</span>

                  </a>

                  <a href="<?= url_to('Design::units');?>" class="btn btn-primary">

                    <span class="text">All</span>

                  </a>

                </div>

                <?php //} ?>

            </div>

            <!--end::Card header-->

        <!--begin::Card body-->

            <div class="card-body pt-0">

                <!--begin::Table-->

                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">

                    <thead>

                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">

                            <th class="max-w-125px">P Number</th>

                            <th class="max-w-125px">AQ Code</th>

                            <th class="max-w-125px">Product Name</th>

                            <th class="max-w-125px">Phase</th>

                            <th class="max-w-125px">Designer</th>

                            <th class="max-w-125px">Status</th>

                            <th class="max-w-125px">Complete</td>

                        </tr>

                    </thead>

                    <tbody class="fw-semibold text-gray-600">

               

                    <?php

                    foreach ($products as $product) {

                      $id = $product['product_id'];

                      $PN = $product['pnumber'];

                      $aqCode = $product['aqcode'];

                      $productName = $product['productname'];

                      $designer = $product['designerId'] ? $product['designerId'] : NULL;



                      $modifications = $this->db->table('product_modification')->select('sku')->where('sku', $aqCode)->where('resolvedDate', NULL)->countAllResults();

                      



                      ?>

                      <tr>

                        <td class=" align-middle"><?= $PN ?></td>

                        <td class=" align-middle"><?= $aqCode ?></td>

                        <td class=" align-middle"><?= $productName ?> <?= (!empty($modifications)) ? '<a href="'.url_to('Design::lookupModifications').'?sku='.$aqCode.'" target="_blank"><i class="bi bi-exclamation-triangle text-danger"></i>'.$modifications : NULL;?></td>

                        <?php

                          if(empty($designer) AND auth()->user()->can('design.super')) { ?>

                             <td class=" align-middle" colspan="3">

                              <form action="<?=url_to('Design::allocateDesigner')?>" method="POST">

                                <input type="hidden" name="productId" value="<?=$id?>"/>

                                <select name="phase">

                                  <option selected disabled>Set Phase</option>

                                  <?php 

                                    foreach($phases as $x => $y) { ?>

                                    <option value="<?=$x?>" <?=($x == $product['phase']) ? "selected" : NULL?>><?=$y?></option>

                                  <?php } ?>

                                </select>

                                <select name="designer">

                                  <option selected disabled>Unallocated</option>

                                  <?php 

                                  foreach($designers as $design) { ?>

                                    <option value="<?=$design['id']?>" <?=($designer == $design['id']) ? "selected" : NULL?>><?=$encrypter->decrypt(base64_decode($design['name']))?></option>

                                  <?php } ?>

                                </select>

                               <select name="status">

                                <option selected disabled>Set Status</option>

                                <?php 

                                if ($product['status'] == NULL) { ?>

                                  <option value="1">&#129306;Model</option>

                                  <option value="8">&#129306;Production</option>

                                <?php } else {

                                  foreach($cadStatuses as $status) { ?>

                                    <option value="<?=$status['id']?>" <?=($status['id'] == $product['status']) ? "selected" : NULL?>><?=$status['icon']?> <?=$status['name']?></option>

                                  <?php } 

                                }

                                ?>

                              </select>

                              <button type="submit" class="btn btn-primary fw-semibold px-6">Set</button>

                              </form>

                            </td>









                          <?php } else { ?>









                            <td class="align-middle">

                            <?php 

                            /*

                              if(auth()->user()->can('design.super')) { ?>

                                <form action="<?=url_to('Design::setPhase')?>" method="GET">

                                  <input type="hidden" name="productId" value="<?=$id?>"/>

                                  <select name="phase">

                                    <option selected disabled>Set Phase</option>

                                    <?php 

                                      foreach($phases as $x => $y) { ?>

                                      <option value="<?=$x?>" <?=($x == $product['phase']) ? "selected" : NULL?>><?=$y?></option>

                                    <?php } ?>

                                  </select>

                                  <button type="submit" class="btn btn-primary fw-semibold px-6">Set</button>

                                </form>

                              <?php } else {

                                echo $phases[$product['phase']];

                              }*/


                              $final_phase = isset($product['phase']) ? $product['phase'] : '';
                              echo isset($phases[$final_phase]) ? $phases[$final_phase] : '';

                            ?>

                          </td>

                          <td class=" align-middle">

                              <?php
                                $final_designer = isset($designersArray[$designer]) ? $designersArray[$designer] : '';
                                if($final_designer != ''){
                                  echo $encrypter->decrypt(base64_decode($final_designer));
                                }  

                              ?>

                            </td>

                          <td class="align-middle">

                            <?php //if(auth()->user()->can('design.super')) { 

                              echo $product['status']; 

                            /* } else {?>

                            <form action="<?=url_to('Design::setStatus')?>" method="POST">

                              <input type="hidden" name="productId" value="<?=$id?>"/>

                              <select name="status">

                                <option selected disabled>Set Status</option>

                                <?php 



                                if ($product['status'] == NULL) { ?>

                                  <option value="1">&#129306;Model</option>

                                  <option value="8">&#129306;Production</option>

                                <?php 

                                } else if($product['phase'] == 4) {

                                  foreach($cadStatuses as $status) { ?>

                                    <option value="<?=$status['id']?>" <?=($status['id'] == $product['status']) ? "selected" : NULL?>><?=$status['icon']?> <?=$status['name']?></option>

                                  <?php } 

                                } else if($product['phase'] == 2 OR $product['phase'] == 3 ) {

                                  foreach($visualStatuses as $status) { ?>

                                    <option value="<?=$status['id']?>" <?=($status['id'] == $product['status']) ? "selected" : NULL?>><?=$status['icon']?> <?=$status['name']?></option>

                                  <?php } 

                                }

                                ?>





                              </select>

                              <button type="submit" class="btn btn-primary fw-semibold px-6">Set</button>

                            </form>

                            <?php } */ ?>

                          </td>

                            

                          <?php }



                        ?>

                        







                        <td>

                          <?php if($product['phase'] == 4 AND $product['status'] == 10 AND empty($modifications)) {?>

                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#design_complete_modal_CAD<?= $id; ?>">Complete</button>

                          <?php } else { 

                            echo (!empty($modifications)) ? '<a href="'.url_to('Design::lookupModifications').'?sku='.$aqCode.'" target="_blank" class="btn btn-danger fw-semibold px-6"><i class="bi bi-exclamation-triangle"></i>'.$modifications.'</a>' : NULL;

                          } 

                          //if(auth()->user()->can('design.super')) {

                            if($product['visualPhase'] == 1) {

                              echo '<i class="bi bi-pen-fill text-success"></i>';

                            } else {

                              echo '<i class="bi bi-pen"></i>';

                            }

                            

                            if($product['cadPhase'] == 1) {

                              echo '<i class="bi bi-box-fill text-success"></i>';

                            } else {

                              echo '<i class="bi bi-box"></i>';

                            }



                            if($product['artworkPhase'] == 1) {

                              echo '<i class="bi bi-brush-fill text-success"></i>';

                            } else {

                              echo '<i class="bi bi-brush"></i>';

                            }

                          //}

                          ?>

                        

                        </td>

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

foreach ($products as $product) { 

  if($product['status'] != 10 AND $product['phase'] == 2) {

    continue;

  }



  $id = $product['product_id'];

  $PN = $product['pnumber'];

  $aqCode = $product['aqcode'];

  $productName = $product['productname'];

  $designer = $product['designerId'] ? $product['designerId'] : NULL;

?>

    <!--begin::Modals-->

    <div class="modal fade" id="design_complete_modal_CAD<?= $id; ?>" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-small p-9">

            <div class="modal-content modal-rounded">

                <div class="modal-header">

                    <h2>Complete Design</h2><br/>

                    <h3><?= $aqCode." ".$productName; ?></h3>

                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">

                        <i class="ki-duotone ki-cross fs-1">

                            <span class="path1"></span>

                            <span class="path2"></span>

                        </i>

                    </div>

                </div>

                <!--begin::Modal body-->

                <div class="modal-body px-5 my-7">

                    <!--begin::Form-->

                    <form id="kt_modal_add_user_form" class="form" method="POST" action="<?= url_to('Design::designComplete');?>">

                        <input type="hidden" name="productId" id="productId" value="<?=$id?>">

                        <!--begin::Scroll-->

                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                            <!--begin::Input group-->

                            <div class="fv-row mb-7">

                                <label class="required fw-semibold fs-6 mb-2">Total Metres</label>

                                <input type="number" name="totalMetres" step="0.1" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="(m)" required/>

                            </div>

                            <div class="fv-row mb-7">

                                <label class="required fw-semibold fs-6 mb-2">Artwork</label>

                                <select name="artwork" class="form-control form-control-solid mb-3 mb-lg-0" required>

                                  <option disabled selected>Please Select</option>

                                  <option value="0">None</option>

                                  <option value="1">Printed</option>

                                  <option value="2">Hand Painted</option>

                                </select>

                            </div>

                            <div class="fv-row mb-7">

                                <label class="required fw-semibold fs-6 mb-2">Foam</label>

                                <select name="foam" class="form-control form-control-solid mb-3 mb-lg-0" required>

                                  <option disabled selected>Please Select</option>

                                  <option value="0">No</option>

                                  <option value="1">Yes</option>

                                </select>

                            </div>

                            <div class="fv-row mb-7">

                                <label class="required fw-semibold fs-6 mb-2">Metal</label>

                                <select name="metal" class="form-control form-control-solid mb-3 mb-lg-0" required>

                                  <option disabled selected>Please Select</option>

                                  <option value="0">No</option>

                                  <option value="1">Yes</option>

                                </select>

                            </div>

                            <div class="fv-row mb-7">

                                <label class="required fw-semibold fs-6 mb-2">Weld</label>

                                <select name="weld" class="form-control form-control-solid mb-3 mb-lg-0" required>

                                  <option disabled selected>Please Select</option>

                                  <option value="0">No</option>

                                  <option value="1">Yes</option>

                                </select>

                            </div>

                            <div class="fv-row mb-7">

                                <label class="required fw-semibold fs-6 mb-2">Disco Ready</label>

                                <select name="discoReady" class="form-control form-control-solid mb-3 mb-lg-0" required>

                                  <option disabled selected>Please Select</option>

                                  <option value="0">No</option>

                                  <option value="1">Yes</option>

                                </select>

                            </div>

                            <div class="fv-row mb-7">

                                <label class="required fw-semibold fs-6 mb-2">Wood</label>

                                <select name="wood" class="form-control form-control-solid mb-3 mb-lg-0" required>

                                  <option disabled selected>Please Select</option>

                                  <option value="0">No</option>

                                  <option value="1">Yes</option>

                                </select>

                            </div>                       

                           </div>

                        <!--end::Scroll-->

                        <!--begin::Actions-->

                        <div class="text-center pt-10">

                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>

                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">

                                <span class="indicator-label">Submit</span>

                                <span class="indicator-progress">Please wait... 

                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>

                            </button>

                        </div>

                        <!--end::Actions-->

                    </form>

                    <!--end::Form-->

                </div>

                <!--end::Modal body-->

            </div>

        </div>

    </div>

    <!--end::Modals-->

<?php 

}



echo $this->endSection();