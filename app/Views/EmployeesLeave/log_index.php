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

                    <form method="post">

                      
                    </form>

                    <!--end::Search-->

                </div>

                <!--end::Card title-->

                <?php  if (auth()->user()->can('production.super')) { ?>

                <!--begin::Card toolbar-->

                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                    <!--begin::Add product-->

                    

                    <!--end::Add product-->

                </div>

                <!--end::Card toolbar-->

                <?php } ?>

            </div>

            <!--end::Card header-->

        <!--begin::Card body-->

            <div class="card-body pt-0">

                <!--begin::Table-->

                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">

                    <thead>

                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">

                            <th class="min-w-70px">User</th>
                            <th class="min-w-70px">Event Type</th>
                            <th class="min-w-100px">EventDetails</th>
                            <th class="min-w-100px">Date</th>
                            

                        </tr>

                    </thead>

                    <tbody class="fw-semibold text-gray-600">



                    <?php

                    $i = 1;

                    foreach ($products as $product) {

                      ?>

                      <tr>
                        <td class=" align-middle"><?= $product['User']; ?></td>
                        <td class=" align-middle"><?= $product['EventType']; ?></td>
                        <td class=" align-middle">
                            <?php 
                            $EventDetails = $product['EventDetails'];
                            if($product['EventType'] == 'Leave Updated'){
                                $EventDetails_decode = json_decode($EventDetails);
                                echo '<div style="width:45%;float:left;"> <b>Old Data</b><br>';
                                $old_data = isset($EventDetails_decode->old_data) ? $EventDetails_decode->old_data : array();
                                if($old_data){
                                    foreach($old_data as $key=>$EventDetails_decode_old_data_val){
                                        if($key == 'employee_id' || $key == 'all_employee' || $key == 'updated_at' || $key == 'created_at' || $key == 'id'){
                                            
                                        }else{
                                            $key = str_replace('_',' ',$key);
                                            echo '<strong>'.$key.'</strong> :'.$EventDetails_decode_old_data_val.'<br>';
                                        }    
                                    }
                                }
                                echo '</div>';
                                echo '<div style="width:45%;float:left;"> <b>New Data</b><br>';
                                $new_data = isset($EventDetails_decode->new_data) ? $EventDetails_decode->new_data : array();
                                if($new_data){
                                    foreach($new_data as $key=>$EventDetails_decode_old_data_val){
                                        if($key == 'employee_id' || $key == 'all_employee' || $key == 'updated_at' || $key == 'created_at' || $key == 'id'){
                                            
                                        }else{
                                            $key = str_replace('_',' ',$key);
                                            echo '<strong>'.$key.'</strong> :'.$EventDetails_decode_old_data_val.'<br>';
                                        }    
                                    }
                                }
                                echo '</div>';
                            }else{
                                echo $EventDetails;
                            }
                            ?>
                            </td>
                        <td class=" align-middle"><?= $product['Date']; ?></td>
                        
                        

                        

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