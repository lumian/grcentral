<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="GRCentral">
	
	<title><?=$title;?></title>
	
	<link href="<?=base_url("style/bootstrap/css/bootstrap.min.css");?>" rel="stylesheet">
	<link href="<?=base_url("style/icons/css/all.css");?>" rel="stylesheet">
	<link rel="icon" href="<?=base_url("style/favicon.ico");?>">
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
</head>
<body>
	<div class="col-lg-8 mx-auto p-3 py-md-5">
		<header class="d-flex align-items-center pb-3 mb-3 border-bottom">
			<span class="fs-4"><?=$title;?></span>
		</header>

		<main>
		
		<? if ($step == 'welcome'): ?>
		
			<h3 class="mb-4">Welcome to GRCentral installer</h3>
			<p class="fs-5 col-md-8">This installer will help you install WebUI for managing Grandstream devices. To perform the installation, follow the steps using the buttons below.</p>

			<div class="mb-5 mt-4">
				<hr>
				<a href="<?=site_url('installer/step/1');?>" class="btn btn-success btn-lg px-4">Start <i class="fa fa-angle-double-right"></i></a>
			</div>
			
		<? elseif ($step == '1'): ?>
		
			<h3 class="mb-4">Checking write access to files/directories</h3>
			
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>File name</th>
						<th>Write permission</th>
					</tr>
				</thead>
				<tbody>
					<? foreach($content['check_result'] as $file): ?>
						<tr><td><?=$file['name'];?></td><? if ($file['write']): ?><td class="table-success"><i class="fa fa-check"></i> Available</td><? else: ?><td class="table-danger"><i class="fa fa-times"></i> Not available</td><? endif; ?></tr>
					<? endforeach; ?>
				</tbody>
			</table>
			
			<? if ($content['status_ok']): ?>
				<div class="alert alert-success mt-4" role="alert">
					 <h4 class="alert-heading"><i class="fa fa-check"></i> Success</h4>
					<p>The checks were successfully passed. You can proceed to the next step.</p>
				</div>
			<? else: ?>
				<div class="alert alert-danger mt-4" role="alert">
					<h4 class="alert-heading"><i class="fa fa-times"></i> Failed</h4>
					<p>Could not get write access to one or more files or directories. Set write permissions for the above files and directories and try again.</p>
				</div>
			<? endif; ?>
			
			<div class="mb-5 mt-4">
				<hr>
				<a href="<?=site_url('installer');?>" class="btn btn-secondary btn-lg px-4"><i class="fa fa-angle-double-left"></i> Previous</a>
				<? if (!$content['status_ok']): ?><a href="<?=site_url('installer/step/1');?>" class="btn btn-warning btn-lg px-4"><i class="fa fa-sync"></i> Restart check</a><? endif; ?>
				<a href="<?=site_url('installer/step/2');?>" class="btn btn-success btn-lg px-4<? if (!$content['status_ok']): ?> disabled<? endif; ?>">Next <i class="fa fa-angle-double-right"></i></a>
			</div>
			
		<? elseif ($step == '2'): ?>
		
			<h3 class="mb-4">Database and system settings</h3>
			
			<p class="fs-5 col-md-8">Fill in all the fields in the form below. Some fields were filled in automatically based on the current configuration files or environment variables.<br /><i>All fields are required to be filled in.</i></p>
			
			<form id="Settings" method="post" action="<?=site_url('installer/step/2');?>">
				<div class="row">
					<div class="col-md-6">
						<div class="card">
							<div class="card-header">
								System settings
							</div>
							<div class="card-body">
								<div class="row mt-2">
									<label for="system_domain" class="col-sm-3 col-form-label">Domain</label>
									<div class="col-sm-9">
										<input type="text" name="system_domain" class="form-control" id="system_domain" value="<?=$content['post_data']['system_domain'];?>" required>
									</div>
								</div>
								<div class="row mt-2">
									<label for="system_language" class="col-sm-3 col-form-label">Language</label>
									<div class="col-sm-9">
										<select name="system_language" class="form-select" id="system_language" required>
											<? foreach($content['language_list'] as $lang): ?>
												<option value="<?=$lang;?>"<? if ($lang == $content['post_data']['system_language']): ?> selected<? endif;?>><?=ucfirst($lang);?></option>
											<? endforeach; ?>
										</select>
									</div>
								</div>
								<div class="row mt-2">
									<label for="system_keep_logs" class="col-sm-3 col-form-label">Keep logs (days)</label>
									<div class="col-sm-9">
										<input type="text" name="system_keep_logs" class="form-control" id="system_keep_logs" value="<?=$content['post_data']['system_keep_logs'];?>" required>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="card">
							<div class="card-header">
								Web access (Default: admin:admin)
							</div>
							<div class="card-body">
								<div class="row mt-2">
									<label for="admin_login" class="col-sm-3 col-form-label">Admin login</label>
									<div class="col-sm-9">
										<input type="text" name="admin_login" class="form-control" id="admin_login" value="<?=$content['post_data']['admin_login'];?>" required>
									</div>
								</div>
								<div class="row mt-2">
									<label for="admin_password" class="col-sm-3 col-form-label">Admin password</label>
									<div class="col-sm-9">
										<input type="password" name="admin_password" class="form-control" id="admin_password" value="<?=$content['post_data']['admin_password'];?>" required>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-4">
					<div class="col-sm-6">
						<div class="card <?if($content['status_db_ok'] === FALSE): ?> border-danger<? endif;?>">
							<div class="card-header">
								Database settings
							</div>
							<div class="card-body">
								<div class="row">
									<label for="database_hostname" class="col-sm-3 col-form-label">Hostname</label>
									<div class="col-sm-9">
										<input type="text" name="database_hostname" class="form-control" id="database_hostname" value="<?=$content['post_data']['database_hostname'];?>" required>
									</div>
								</div>
								<div class="row mt-2">
									<label for="database_username" class="col-sm-3 col-form-label">Username</label>
									<div class="col-sm-9">
										<input type="text" name="database_username" class="form-control" id="database_username" value="<?=$content['post_data']['database_username'];?>" required>
									</div>
								</div>
								<div class="row mt-2">
									<label for="database_password" class="col-sm-3 col-form-label">Password</label>
									<div class="col-sm-9">
										<input type="password" name="database_password" class="form-control" id="database_password" value="<?=$content['post_data']['database_password'];?>" required>
									</div>
								</div>
								<div class="row mt-2">
									<label for="database_name" class="col-sm-3 col-form-label">Database name</label>
									<div class="col-sm-9">
										<input type="text" name="database_name" class="form-control" id="database_name" value="<?=$content['post_data']['database_name'];?>" required>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-4">
					<div class="col-sm-12">
						<button class="btn btn-success btn-lg px-4"><i class="fa fa-save"></i> Save settings </a>
					</div>
				</div>
			</form>
			
			<? if ($content['status_ok'] === TRUE): ?>
				<div class="alert alert-success mt-4" role="alert">
					 <h4 class="alert-heading"><i class="fa fa-check"></i> Success</h4>
					<p>The checks were successfully passed. You can proceed to the next step.</p>
				</div>
			<? elseif ($content['status_ok'] === FALSE): ?>
				<div class="alert alert-danger mt-4" role="alert">
					<h4 class="alert-heading"><i class="fa fa-times"></i> Failed</h4>
					<p>
					Errors occurred during the data verification process.
					<? if ($content['status_db_ok'] === FALSE): ?>
						<br />Failed to connect to the database server using the provided parameters.
					<? endif; ?>
					</p>
				</div>
			<? endif; ?>
			
			<div class="mb-5 mt-4">
				<hr>
				<a href="<?=site_url('installer/step/1');?>" class="btn btn-secondary btn-lg px-4"><i class="fa fa-angle-double-left"></i> Previous</a>
				<a href="<?=site_url('installer/step/3');?>" class="btn btn-success btn-lg px-4<? if (!$content['status_ok']): ?> disabled<? endif; ?>">Next <i class="fa fa-angle-double-right"></i></a>
			</div>
		
		<? elseif ($step == '3'): ?>
		
			<h3 class="mb-4">GRCentral installation is complete!</h3>
			<p class="fs-5 col-md-8">You have completed all the necessary steps to install the GR Central system.<br />Now you can go to the web interface and start using this product.</p>
			
			<div class="mb-5 mt-4 ">
				<hr>
				<a href="<?=site_url();?>" class="btn btn-success btn-lg px-4">Go to the web interface <i class="fa fa-angle-double-right"></i></a>
			</div>
		
		<? else:?>
		
			<h3 class="mb-4">Error!</h3>
			<p class="fs-5 col-md-8">The installation step is not recognized.<br />Please go back to the start of the installation and try again.</p>
			
			<div class="mb-5 mt-4 ">
				<hr>
				<a href="<?=site_url('installer');?>" class="btn btn-secondary btn-lg px-4"><i class="fa fa-angle-double-left"></i> Go to insaller start page</a>
			</div>
			
		<? endif;?>
		
		</main>
		<footer class="pt-5 my-5 text-muted border-top">
			<small class="text-muted">2020-2024 &copy; Powered by <a href="https://github.com/lumian/grcentral" target="_blank"><?=$this->config->item('site_title', 'grcentral');?></a> v.<?=$this->config->item('version', 'grcentral');?></small>
		</footer>
	</div>
	<script src="<?=base_url("style/bootstrap/js/bootstrap.bundle.min.js");?>"></script>
</body>
</html>