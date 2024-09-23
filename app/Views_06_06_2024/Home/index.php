<?php 
# Call in main template
echo $this->extend('layouts/default');

# title Section 
echo $this->section('heading');
echo $title;
// echo '<pre>';
// print_r(auth()->user());
// echo '</pre>';
echo $this->endSection();

# Main Content
echo $this->section('content'); 

echo $this->endSection();