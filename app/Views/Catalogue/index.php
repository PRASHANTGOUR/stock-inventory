<?php 
# Call in main template
echo $this->extend('layouts/default');

# Meta title Section 
echo $this->section('heading');
echo $title;
echo $this->endSection();

echo $this->section('content'); 
?>

<div class="content fs-6 d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl">
            <div class="card card-flush">
                <!-- Card Header -->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-title">
                        <!-- Search Form -->
                        <form method="get" action="<?= base_url('catalogue/products') ?>">
                            <input type="text" name="search" value="<?= esc($search ?? '') ?>" class="form-control form-control-solid w-250px" placeholder="Search Product" />
                            <button type="submit" class="btn position-absolute" style="left:200px; top:27px"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <a href="<?= url_to('catalogue::create'); ?>" class="btn btn-primary">Add Product</a>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body pt-0">
                    <!-- Product Table -->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </div>
                                </th>
                                <th class="min-w-200px">Product</th>
                                <th class="text-end min-w-100px">SKU</th>
                                <th class="text-end min-w-70px">Qty</th>
                                <th class="text-end min-w-100px">Price</th>
                                <th class="text-end min-w-100px">Rating</th>
                                <th class="text-end min-w-100px">Status</th>
                                <th class="text-end min-w-70px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            <?php foreach($products as $product): ?>
                            <tr>
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <!-- Thumbnail -->
                                        <a href="<?= base_url('public/' . $product['upload_thumbnail']) ?>" target="_blank" class="symbol symbol-50px">
                                            <span class="symbol-label" style="background-image:url(<?= base_url('public/' . $product['upload_thumbnail']) ?>);"></span>
                                        </a>
                                        <div class="ms-5">
                                            <!-- Title -->
                                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold"><?= esc($product['product_name']) ?></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end pe-0"><?= esc($product['sku']) ?></td>
                                <td class="text-end pe-0"><?= esc($product['quantity']) ?></td>
                                <td class="text-end pe-0"><?= esc($product['price']) ?></td>
                                <td class="text-end pe-0">
                                    <div class="rating justify-content-end">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <div class="rating-label <?= ($i <= $product['rating']) ? 'checked' : '' ?>">
                                            <i class="ki-duotone ki-star fs-6"></i>
                                        </div>
                                        <?php endfor; ?>
                                    </div>
                                </td>
                                <td class="text-end pe-0">
                                    <div class="badge <?= ($product['status'] === 'out_of_stock') ? 'badge-light-warning' : 'badge-light-success' ?>">
                                        <?= ($product['status'] === 'out_of_stock') ? 'Out Stock' : 'In Stock' ?>
                                    </div>
                                </td>
                                <td class="">
                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="<?= url_to('catalogue::edit', $product['id']) ?>" class="menu-link px-3">Edit</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="<?= url_to('catalogue::delete', $product['id']) ?>" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
echo $this->endSection();
?>
