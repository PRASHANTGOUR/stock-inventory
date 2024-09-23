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
                        <form method="post">
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
                <?php  if (auth()->user()->can('production.super')) { ?>
                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <!--begin::Add product-->
                    <a href="<?= url_to('Production::addUnit');?>" class="btn btn-primary">
                    <span class="icon text-white-600">
                      <i class="fas fa-plus-circle"></i>
                    </span>
                    <span class="text">Add New Work</span>
                  </a>
                  <a href="<?php echo url_to('Production::recentlyAdded');?>" class="btn btn-primary">
                    <span class="text">Products Added Report</span>
                  </a>
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
                            <th class="min-w-70px">P Number</th>
                            <th class="min-w-70px">AQ Code</th>
                            <th class="min-w-120px">Product Name</th>
                            <th class="min-w-50px">Coef</th>
                            <th class="min-w-50px">Progress</th>
                            <th class="min-w-50px">Status</th>
                            <th class="min-w-50px">Team</th>
                            <th class="min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">

                    <?php
                    /*foreach ($department as $dpt) :
                    ?>
                      <tr>
                        <td class="align-middle"><?= $dpt['id']; ?></td>
                        <td class="align-middle"><?= $dpt['name']; ?></td>
                        <td class="align-middle"><a href="<?php echo base_url('master/view_team_output/') . $dpt['id'];?>">Output</a></td>
                        <td class="align-middle text-center">
                          <a href="<?= base_url('master/e_dept/') . $dpt['id'] ?>">
                            <span class="icon text-white" title="Edit">
                              <i class="fas fa-edit"></i>
                            </span>
                          </a> |
                          <a href="<?= base_url('master/d_dept/') . $dpt['id'] ?>" onclick="return confirm('Deleted Department will lost forever. Still want to delete?')">
                            <span class="icon text-white" title="Delete">
                              <i class="fas fa-trash-alt"></i>
                            </span>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; */?>

               
                    <?php
                    $i = 1;
                    foreach ($products as $product) {
                      $Coef = $product['coef'] ;
                    
                      if($product['department_id'] == "Split") {
                        $query = $this->db->query("SELECT SUM(`coefficent`) AS `coefficent` FROM `8yxzprogress` LEFT JOIN `8yxzproducts` on `8yxzprogress`.`product_id` = `8yxzproducts`.`product_id` WHERE `parent` = ?;", [$product['product_id']]);
                        $row = $query->getRow();
                        $SumCoef = $row ? $row->coefficent : 0;
                      } else {
                        $query = $this->db->query("SELECT SUM(coefficent) AS coefficent FROM 8yxzprogress WHERE product_id = ?", [$product['product_id']]);
                        $row = $query->getRow();
                        $SumCoef = $row ? $row->coefficent : 0;
                      }
                        
                      $Progress = ($Coef > 0) ? round(($SumCoef/ $Coef) *100) : NULL;
                      //$Progress = round(($SumCoef/ $Coef) *100);
                      
                      ?>
                      <tr>
                        <td class=" align-middle"><?= $product['pnumber']; ?></td>
                        <td class=" align-middle"><?= $product['aqcode']; ?></td>
                        <td class=" align-middle"><?= $product['productname']; ?></td>
                        <td class=" align-middle"><?= $Coef ; ?> </td>
                        <td class=" align-middle"><?= $Progress; ?> %</td>
                        <td class=" align-middle"><?= $product['status']; ?> </td>
                        <td class=" align-middle"><?= $product['department_id']; ?></td>
                        
                        <td class="align-middle">
                        <?php if (auth()->user()->can('production.super')) { ?>
                          <a href="<?= url_to('Production::editUnit')?>?p=<?= $product['product_id']; ?>">
                            <span class="icon text-white" title="Edit">
                              <i class="bi bi-pencil-square"></i>
                            </span>
                          </a> | 
                          <a href="<?= url_to('Production::addProductModification')?>?p=<?= $product['product_id']; ?>">
                            <span class="icon text-white" title="Modification">
                              <i class="bi bi-scissors"></i>
                            </span>
                          </a> | 
                        <?php } 
                        
                        if(!empty($Progress)) {?>
                        <a href="<?= url_to('Production::viewUnitProgressHistory')?>?p=<?= $product['product_id']; ?>">
                          <span class="icon text-white" title="History">
                              <i class="bi bi-clock-history"></i>
                            </span>
                          </a>
                        </td>
                        <?php } ?>
                        
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