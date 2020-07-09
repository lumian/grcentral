<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->session->flashdata('success_result')): ?>
<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>
<div class="jumbotron">
	<h1>Home Page</h1>
	<p class="lead">This is a home page of this site</p>
</div>