<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

    <div class="container d-flex justify-content-center p-5">
        <div class="card col-12 col-md-5 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-5"><?= lang('Auth.register') ?></h5>

                <?php if (session('error') !== null) : ?>
                    <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                <?php elseif (session('errors') !== null) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php if (is_array(session('errors'))) : ?>
                            <?php foreach (session('errors') as $error) : ?>
                                <?= $error ?>
                                <br>
                            <?php endforeach ?>
                        <?php else : ?>
                            <?= session('errors') ?>
                        <?php endif ?>
                    </div>
                <?php endif ?>

                <form action="" method="post">
                    <?= csrf_field() ?>

                    <!-- Email -->
                    <div class="form-floating mb-2">
                        <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                        <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                    </div>

                    <!-- Username -->
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="floatingUsernameInput" name="username" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required>
                        <label for="floatingUsernameInput"><?= lang('Auth.username') ?></label>
                    </div>

                    <!-- Username -->
                        <input type="hidden" class="form-control" id="staff_id" name="staff_id" inputmode="text" autocomplete="staff_id" placeholder="Employee ID" value="<?=$staffId;?>">


                            <label>Super Admin</label><input type="checkbox"  name="groups[]" value="superadmin"><br/>

                            <label>Develoepr</label><input type="checkbox"  name="groups[]" value="developer"><br/>

                            <label>Production Super User</label><input type="checkbox"  name="groups[]" value="productionsuper"><br/>
                            <label>Production User</label><input type="checkbox"  name="groups[]" value="productionuser"><br/>

                            <label>Designer</label><input type="checkbox"  name="groups[]" value="designer"><br/>

                            <label>User</label><input type="checkbox" name="groups[]" value="user"><br/>

                    
                    <div class="d-grid col-12 col-md-8 mx-auto m-3">
                        <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
