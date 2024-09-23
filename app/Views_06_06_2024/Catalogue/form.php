
<? # Call in main template ?>
<?= $this->extend('layouts/default');?>

<? # Meta Title Section ?>
<?= $this->section('title');?>
Production
<?= $this->endSection();?>

<? # Meta Title Section ?>
<?= $this->section('heading');?>
Production
<?= $this->endSection();?>

<? # Main Content ?>
<?= $this->section('content'); ?>

<h2>Form</h2>

    <a href="<?php echo site_url('/production');?>">Home</a><br>

<?= form_open("production/create")?>
<label for="title">Title</label>
<input type="text" id="text" name="text" value="<?old("title")?>">

<label for="content">Content</label>
<textarea id="content" name="content" value="<?old("content")?>"></textarea>

</form>

<?= $this->endSection();?>