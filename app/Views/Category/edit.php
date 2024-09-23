<?php 
# Call in main template
echo $this->extend('layouts/default');

# Meta title Section 
echo $this->section('heading');
// echo $title; // You can uncomment this if needed
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
  
        <div class="row justify-content-center">
            <div class="row justify-content-center">
                <!-- Update the form action to point to the 'update' method with the correct category ID -->
                <form action="<?= url_to('Category::update', $category['id']); ?>" method="POST">
                <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="categoryName" class="col-form-label-sm">Category Name</label>
                        <input type="text" class="form-control form-control-sm" name="categoryName"
                            id="categoryName" value="<?= set_value('categoryName', $category['categoryName']) ?>">
                            <?php if (isset($validation) && $validation->hasError('categoryName')): ?>
                                <div class="text-danger"><?= $validation->getError('categoryName') ?></div>
                            <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="categoryDescription" class="col-form-label-sm">Category Description</label>
                        <textarea class="form-control form-control-sm" name="categoryDescription" id="categoryDescription"><?= set_value('categoryDescription', $category['categoryDescription']) ?></textarea>
                            <?php if (isset($validation) && $validation->hasError('categoryDescription')): ?>
                                <div class="text-danger"><?= $validation->getError('categoryDescription') ?></div>
                            <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="status" class="col-form-label-sm">Status</label>
                        <select class="form-control form-control-sm" name="status" id="status">
                            <option value="">Select Status</option>
                            <option value="1" <?= set_select('status', '1', $category['status'] == '1') ?>>Active</option>
                            <option value="0" <?= set_select('status', '0', $category['status'] == '0') ?>>Deactive</option>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('status')): ?>
                                <div class="text-danger"><?= $validation->getError('status') ?></div>
                            <?php endif; ?>
                    </div>

                    <button id="saveButton" type="submit"
                        class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0 form-control-sm">
                        <span class="icon text-white">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text">Update</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Container-->
</div>
<!--end::Post-->
</div>

<?php 
echo $this->endSection();
