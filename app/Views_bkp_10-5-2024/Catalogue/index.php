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

					<!--begin::Content-->
					<div class="content fs-6 d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Toolbar-->
						<div class="toolbar" id="kt_toolbar">
							<div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
									<!--begin::Breadcrumb-->
									<ul class="breadcrumb fw-semibold fs-base my-1">
										<li class="breadcrumb-item text-muted">
											<a href="index.html" class="text-muted text-hover-primary">Home</a>
										</li>
										<li class="breadcrumb-item text-muted">eCommerce</li>
										<li class="breadcrumb-item text-muted">Catalog</li>
										<li class="breadcrumb-item text-gray-900">Products</li>
									</ul>
									<!--end::Breadcrumb-->
								</div>
								<!--end::Info-->
								<!--begin::Actions-->
								<div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
									<a href="#" class="btn bg-body btn-color-gray-700 btn-active-primary me-4" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">Invite Friends</a>
									<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project" id="kt_toolbar_primary_button">New Project</a>
								</div>
								<!--end::Actions-->
							</div>
						</div>
						<!--end::Toolbar-->
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
												<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
												<input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Product" />
											</div>
											<!--end::Search-->
										</div>
										<!--end::Card title-->
										<!--begin::Card toolbar-->
										<div class="card-toolbar flex-row-fluid justify-content-end gap-5">
											<div class="w-100 mw-150px">
												<!--begin::Select2-->
												<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-ecommerce-product-filter="status">
													<option></option>
													<option value="all">All</option>
													<option value="published">Published</option>
													<option value="scheduled">Scheduled</option>
													<option value="inactive">Inactive</option>
												</select>
												<!--end::Select2-->
											</div>
											<!--begin::Add product-->
											<a href="apps/ecommerce/catalog/add-product.html" class="btn btn-primary">Add Product</a>
											<!--end::Add product-->
										</div>
										<!--end::Card toolbar-->
									</div>
									<!--end::Card header-->
									<!--begin::Card body-->
									<div class="card-body pt-0">
										<!--begin::Table-->
										<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
											<thead>
												<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
													<th class="w-10px pe-2">
														<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
															<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="1" />
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
                                            <?php
                                            # Output of the data
                                                foreach($products as $product) { 
                                                    /*echo "id: ".$product['id']." SKU: ".$product['SKU']." Name: ".$product['Name']." Type: ".$product['type']."<br>"; */
                                                ?>
                                                    

												<tr>

													<td>
														<div class="form-check form-check-sm form-check-custom form-check-solid">
															<input class="form-check-input" type="checkbox" value="1" />
														</div>
													</td>
													<td>
														<div class="d-flex align-items-center">
															<!--begin::Thumbnail-->
															<a href="apps/ecommerce/catalog/edit-product.html" class="symbol symbol-50px">
																<span class="symbol-label" style="background-image:url(https://airquee.com/wp-content/uploads/2022/02/AQ5932.png);"></span>
															</a>
															<!--end::Thumbnail-->
															<div class="ms-5">
																<!--begin::Title-->
																<a href="apps/ecommerce/catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="product_name"><?= $product['Name']?></a>
																<!--end::Title-->
															</div>
														</div>
													</td>
													<td class="text-end pe-0">
														<span class="fw-bold"><?= $product['SKU']?></span>
													</td>
													<td class="text-end pe-0" data-order="3">
														<span class="badge badge-light-warning">Low stock</span>
														<span class="fw-bold text-warning ms-3">3</span>
													</td>
													<td class="text-end pe-0">197</td>
													<td class="text-end pe-0" data-order="rating-3">
														<div class="rating justify-content-end">
															<div class="rating-label checked">
																<i class="ki-duotone ki-star fs-6"></i>
															</div>
															<div class="rating-label checked">
																<i class="ki-duotone ki-star fs-6"></i>
															</div>
															<div class="rating-label checked">
																<i class="ki-duotone ki-star fs-6"></i>
															</div>
															<div class="rating-label">
																<i class="ki-duotone ki-star fs-6"></i>
															</div>
															<div class="rating-label">
																<i class="ki-duotone ki-star fs-6"></i>
															</div>
														</div>
													</td>
													<td class="text-end pe-0" data-order="Published">
														<!--begin::Badges-->
														<div class="badge badge-light-success"><?= $product['Status']?></div>
														<!--end::Badges-->
													</td>
													<td class="text-end">
														<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
														<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
														<!--begin::Menu-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="apps/ecommerce/catalog/edit-product.html" class="menu-link px-3">Edit</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
															</div>
															<!--end::Menu item-->
														</div>
														<!--end::Menu-->
													</td>
												</tr>
                                                <?php 
                                                # End Output foreach
                                                } ?>
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
					</div>
					<!--end::Content-->

<?php 
echo $this->endSection();