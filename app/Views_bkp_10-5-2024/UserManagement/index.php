<?php
# Call in main template
echo $this->extend('layouts/default');

# Meta Title Section 
echo $this->section('heading');
echo "User Management";
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
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <?php if (auth()->user()->can('development.development')) { ?>
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
                <?php } ?>
                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <!--begin::Add product-->
                    <a href="<?= url_to('UserManagement::addUser'); ?>" class="btn btn-primary">Add User</a>
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
                            <th class="min-w-200px">User Name</th>
                            <th class="min-w-100px">E-mail</th>
                            <th class="min-w-70px">Group</th>
                            <th class="min-w-100px">Permissions</th>
                            <th class="min-w-70px">Edit</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <?php
                        foreach ($users as $user) {
                        ?>
                            <tr <?php if ($user->isBanned()) {
                                    echo "style='color: red; font-weight: bold;'";
                                } ?>>
                                <td><?= $user->username; ?></td>
                                <td><?= $user->email; ?></td>
                                <td><?php echo implode(", ", $user->groups); ?></td>
                                <td><?php echo implode(", ", $user->permissions); ?></td>
                                <td>
                                    <a href="<?= url_to('UserManagement::getUser', $user->id); ?>">
                                        <span class="icon" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </a> | 
                                    <a href="#" class="menu-link px-2" data-bs-toggle="modal" data-bs-target="#user_ban_modal_<?= $user->id; ?>">
                                        <span class="icon" title="Active Status">
                                            <i class="<?= $user->isbanned() ? "bi-exclamation-circle" : "bi-check-circle-fill";?>  fs-3"></i>
                                        </span>
                                    </a> | 
                                    <a href="#" class="menu-link px-2" data-bs-toggle="modal" data-bs-target="#user_reset_modal_<?= $user->id; ?>">
                                        <span class="icon" title="Force Password Reset">
                                            <i class="bi-arrow-counterclockwise fs-33"></i>
                                        </span>
                                    </a> | 
                                    <a href="#" class="menu-link px-2" data-bs-toggle="modal" data-bs-target="#user_delete_modal_<?= $user->id; ?>">
                                        <span class="icon" title="Delete">
                                            <i class="bi bi-x-lg"></i>
                                        </span>
                                    </a>
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
foreach ($users as $user) { ?>
    <!--begin::Modals-->
    <div class="modal fade" id="user_delete_modal_<?= $user->id; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-small p-9">
            <div class="modal-content modal-rounded">
                <div class="modal-header">
                    <h2>Delete User - <?= $user->username; ?></h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y m-5">
                    <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">
                        <div class="container">
                            <h2>Confirm delete user?</h2>
                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                                <a href="<?= url_to('UserManagement::deleteUser', $user->id); ?>" class="btn btn-primary">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modals-->

    <!--begin::Modals-->
    <div class="modal fade" id="user_reset_modal_<?= $user->id; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-small p-9">
            <div class="modal-content modal-rounded">
                <div class="modal-header">
                    <h2>Forec User Reset - <?= $user->username; ?></h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y m-5">
                    <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">
                        <div class="container">
                            <h2>Confirm Force Password Reset?</h2>
                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                                <a href="<?= url_to('UserManagement::forcePasswordChange', $user->id); ?>" class="btn btn-primary">Reset</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modals-->

        <!--begin::Modals-->
        <div class="modal fade" id="user_ban_modal_<?= $user->id; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-small p-9">
            <div class="modal-content modal-rounded">
                <div class="modal-header">
                    <h2>Change User Account Status - <?= $user->username; ?></h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y m-5">
                    <div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">
                        <div class="container">
                            <h2>Confirm <?= $user->isBanned() ? "Re-activate" : "Deactivate" ?></h2>
                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                               <?php if ($user->isBanned()) { ?>
                                    <a href="<?= url_to('UserManagement::enableUser', $user->id); ?>" class="btn btn-primary">Re-activate</a>
                                <?php } else { ?>
                                    <a href="<?= url_to('UserManagement::disableUser', $user->id); ?>" class="btn btn-primary">Deactivate</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modals-->

    

<?php }
echo $this->endSection();
