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
?>

<!--begin::Post-->
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div class="container-xxl">
        <!--begin::Products-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <?php if (auth()->user()->can('admin.super')) { ?>

            <div class="card-header align-items-center py-5 gap-2 gap-md-5">

                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <!--begin::Add product-->
                    <a href="apps/ecommerce/catalog/add-product.html" class="btn btn-primary">Add Team</a>
                    <!--end::Add product-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <?php } ?>
        <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-200px">ID</th>
                            <th class="text-end min-w-100px">Team Name</th>
                            <th class="text-end min-w-70px">Outputs</th>
                            <?php if (auth()->user()->can('development.development')) { ?>
                              <th class="text-end min-w-100px">Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">

                    <?php
                    foreach ($department as $dpt) :
                    ?>
                      <tr>
                        <td class="align-middle"><?= $dpt['id']; ?></td>
                        <td class="align-middle"><?= $dpt['name']; ?></td>
                        <td class="align-middle">
                          <a href="<?= url_to('Production::viewTeamsOuput').'?t='.$dpt['id'];?>">
                            <span class="icon text-white" title="History">
                              <i class="bi bi-clock-history"></i>
                            </span>
                          </a>
                        </td>
                        <?php if (auth()->user()->can('development.development')) { ?>
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
                        <?php } ?>

                      </tr>
                    <?php endforeach; ?>
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