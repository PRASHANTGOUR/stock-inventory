<?php 
# Call in main template
echo $this->extend('layouts/default');
# Meta title Section 
echo $this->section('heading');
// echo $title;
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
                <form action="<?= url_to('catalogue::store');?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="q" class="col-form-label-sm">Product Name</label>
                        <input type="text" class="form-control form-control-sm" name="product_name"
                            id="product_name" value="<?= set_value('product_name') ?>">
                            <?php if (isset($validation) && $validation->hasError('product_name')): ?>
                                <div class="text-danger"><?= $validation->getError('product_name') ?></div>
                            <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="q" class="col-form-label-sm">Product Thumbnail</label>
                        <input type="file" class="form-control form-control-sm" name="thumbnail"
                            id="thumbnail" value="<?= set_value('thumbnail') ?>">
                            <?php if (isset($validation) && $validation->hasError('thumbnail')): ?>
                                <div class="text-danger"><?= $validation->getError('thumbnail') ?></div>
                            <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="q" class="col-form-label-sm">Sku Name</label>
                        <input type="text" class="form-control form-control-sm" name="sku"
                            id="sku" value="<?= set_value('sku') ?>">
                            <?php if (isset($validation) && $validation->hasError('sku')): ?>
                                <div class="text-danger"><?= $validation->getError('sku') ?></div>
                            <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="q" class="col-form-label-sm">Quantity</label>
                        <input type="number" class="form-control form-control-sm" name="quantity"
                            id="quantity" value="<?= set_value('quantity') ?>">
                            <?php if (isset($validation) && $validation->hasError('quantity')): ?>
                                <div class="text-danger"><?= $validation->getError('quantity') ?></div>
                            <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="q" class="col-form-label-sm">Price</label>
                        <input type="number" class="form-control form-control-sm" name="price"
                            id="price" value="<?= set_value('price') ?>">
                            <?php if (isset($validation) && $validation->hasError('price')): ?>
                                <div class="text-danger"><?= $validation->getError('price') ?></div>
                            <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="q" class="col-form-label-sm">Rating</label>
                        <input type="number" class="form-control form-control-sm" name="rating"
                            id="rating" value="<?= set_value('rating') ?>">
                            <?php if (isset($validation) && $validation->hasError('rating')): ?>
                                <div class="text-danger"><?= $validation->getError('rating') ?></div>
                            <?php endif; ?>
                    </div>                    
                    <div class="form-group">
                        <label for="q" class="col-form-label-sm">Status</label>
                        <select class="form-control form-control-sm" name="status" id="status">
                            <option value="">Select Status</option>
                            <option value="available">Available</option>
                            <option value="out_of_stock">Out of Stock</option>
                            <option value="discontinued">Discontinued</option>
                            <!--<option value="1" <?= set_select('status', '1') ?>>Active</option>
                            <option value="0" <?= set_select('status', '0') ?>>Deactive</option>-->
                        </select>
                        <?php if (isset($validation) && $validation->hasError('status')): ?>
                                <div class="text-danger"><?= $validation->getError('status') ?></div>
                            <?php endif; ?>
                    </div>
                    <button id="saveButton" type="submit"
                        class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0 form-control-sm">
                        <span class="icon text-white">
                            <i class="fas fa-plus-circle"></i>
                        </span>
                        <span class="text">Save</span>
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