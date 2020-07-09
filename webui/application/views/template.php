<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="GSCentral">

	<title><?=$title;?></title>

	<link href="/style/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="/style/icons/css/all.css" rel="stylesheet">

	<link rel="icon" href="/style/favicon.ico">
	<meta name="theme-color" content="#563d7c">


	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
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
	<script src="/style/bootstrap/js/jquery-3.5.1.min.js"></script>
	<script src="/style/bootstrap/js/bootstrap.bundle.min.js" integrity="sha256-Xt8pc4G0CdcRvI0nZ2lRpZ4VHng0EoUDMlGcBSQ9HiQ=" crossorigin="anonymous"></script>
</head>

<body>
	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
		<a class="navbar-brand" href="/"><?=$this->config->item('site_title', 'grcentral');?></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav mr-auto">
				<!-- Main menu -->
				<? $current = $this->uri->segment('1'); ?>
				<? if ($current === FALSE OR $current == ''): ?><li class="nav-item active"><? else: ?><li class="nav-item"><? endif; ?>
					<a class="nav-link" href="/"><i class="fa fa-home"></i> <?=lang('main_menu_home');?></a>
				</li>
				<? if ($this->grcentral->is_user()): ?>
					<? if ($current == 'phones'): ?><li class="nav-item active"><? else: ?><li class="nav-item"><? endif; ?>
						<a class="nav-link" href="/phones/"><i class="fa fa-phone-square-alt"></i> <?=lang('main_menu_phones');?></a>
					</li>
					<? if ($current == 'settings'): ?><li class="nav-item active"><? else: ?><li class="nav-item"><? endif; ?>
						<a class="nav-link" href="/settings/"><i class="fa fa-cog"></i> <?=lang('main_menu_settings');?></a>
					</li>
				<? endif; ?>
				<!-- End Main menu -->
			</ul>
			<!--<form class="form-inline mt-2 mt-md-0">-->
			<? if (!$this->grcentral->is_user()): ?>
				<button type="button" class="btn btn-success my-2 my-sm-0" data-toggle="modal" data-target="#ModalAuth"><i class="fa fa-sign-in-alt"></i> <?=lang('main_btn_login');?></button>
			<? else: ?>
				<a href="/auth/logout" type="button" class="btn btn-danger my-2 my-sm-0" ><i class="fa fa-sign-out-alt"></i> <?=lang('main_btn_logout');?></a>
			<? endif; ?>
		</div>
	</nav>
	<main role="main" class="container">
		<?=$content;?>
		<hr class="my-2">
		<footer class="mb-4">
			<small class="text-muted">2020 &copy; Powered by <a href="https://github.com/lumian/grcentral" target="_blank">GRCentral</a> v.<?=$this->config->item('version', 'grcentral');?></small>
		</footer>
	</main>
	<? if (!$this->grcentral->is_user()): ?>
		<?=$this->load->view('auth', NULL, TRUE); ?>
	<? endif;?>
	<script>
		$(function () {
		  $('[data-toggle="tooltip"]').tooltip()
		})
	</script>
</body>
</html>
