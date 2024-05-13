<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="GRCentral">

	<title><?=$title;?></title>

	<link href="/style/bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="/style/icons/css/all.css" rel="stylesheet">

	<link rel="icon" href="/style/favicon.ico">
	<meta name="theme-color" content="#7952b3">

	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}
	</style>
	
	<!-- Custom styles for this template -->
	<link href="/style/style.css" rel="stylesheet">
	<script src="/style/bootstrap/js/jquery-3.6.0.min.js"></script>
	<script src="/style/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark mb-6">
		<div class="container-fluid">
			<a class="navbar-brand" href="/"><?=$this->config->item('site_title', 'grcentral');?></a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav me-auto mb-2 mb-md-0">
					<!-- Main menu -->
					<? $current = $this->uri->segment('1'); ?>
					<li class="nav-item">
						<a class="nav-link<? if ($current === FALSE OR $current == ''): ?> active<? endif; ?>" href="<?=site_url();?>"><i class="fa fa-home"></i> <?=lang('main_menu_home');?></a>
					</li>
					<? if ($this->grcentral->is_user()): ?>
						<li class="nav-item">
							<a class="nav-link<? if ($current == 'devices'): ?> active<? endif; ?>" href="<?=site_url('devices');?>"><i class="fa fa-phone-square-alt"></i> <?=lang('main_menu_devices');?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link<? if ($current == 'phonebook'): ?> active<? endif; ?>" href="<?=site_url('phonebook');?>"><i class="fa fa-address-book"></i> <?=lang('main_menu_phonebook');?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link<? if ($current == 'logs'): ?> active<? endif; ?>" href="<?=site_url('logs');?>"><i class="fa fa-list-ul"></i> <?=lang('main_menu_logs');?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link<? if ($current == 'settings'): ?> active<? endif; ?>" href="<?=site_url('settings');?>"><i class="fa fa-cog"></i> <?=lang('main_menu_settings');?></a>
						</li>
					<? endif; ?>
					<!-- End Main menu -->
				</ul>
				<? if (!$this->grcentral->is_user()): ?>
					<button type="button" class="btn btn-success my-2 my-sm-0" data-bs-toggle="modal" data-bs-target="#ModalAuth"><i class="fa fa-sign-in-alt"></i> <?=lang('main_btn_login');?></button>
				<? else: ?>
					<? if ($this->grcentral->check_cfg_need_apply()):?>
						<button type="button" class="btn btn-warning my-2 my-sm-0" data-bs-toggle="modal" data-bs-target="#ModalNeedApply"><i class="fa fa-exclamation-circle"></i> <?=lang('main_btn_cfg_apply');?></button>
					<? endif; ?>
					<a href="/auth/logout" type="button" class="btn btn-danger my-2 mx-2 my-sm-0" ><i class="fa fa-sign-out-alt"></i> <?=lang('main_btn_logout');?></a>
				<? endif; ?>
			</div>
		</div>
	</nav>
	<main role="main" class="container">
		<?=$content;?>
		<hr class="my-2">
		<footer class="mb-4">
			<small class="text-muted">2020-2024 &copy; Powered by <a href="https://github.com/lumian/grcentral" target="_blank">GRCentral</a> v.<?=$this->config->item('version', 'grcentral');?></small>
		</footer>
	</main>
	<? if (!$this->grcentral->is_user()): ?>
		<?=$this->load->view('auth', NULL, TRUE); ?>
	<? endif;?>
	<? if ($this->grcentral->check_cfg_need_apply()):?>
		<?=$this->load->view('need_apply', NULL, TRUE); ?>
	<? endif;?>
	
	<script>
		$(function () {
			$('[data-bs-toggle="tooltip"]').tooltip()
		})
	</script>
</body>
</html>
