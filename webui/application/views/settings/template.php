<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<div class="row">
		<div class="col-lg">
			<? $current_tab = $this->uri->segment('2'); ?>
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<? if ($current_tab == ''): ?><a class="nav-link active" href=""><?else:?>
					<a class="nav-link" href="/settings/"><?endif;?>
						<i class="fa fa-home"></i> <?=lang('settings_main_title');?>
					</a>
				</li>
				<li class="nav-item">
					<? if ($current_tab == 'models'): ?><a class="nav-link active" href=""><?else:?>
					<a class="nav-link" href="/settings/models/"><?endif;?>
						<i class="fa fa-phone-square-alt"></i> <?=lang('settings_models_title');?>
					</a>
				</li>
				<li class="nav-item">
					<? if ($current_tab == 'fw'): ?><a class="nav-link active" href=""><?else:?>
					<a class="nav-link" href="/settings/fw/"><?endif;?>
						<i class="fa fa-microchip"></i> <?=lang('settings_fw_title');?>
					</a>
				</li>
				<li class="nav-item">
					<? if ($current_tab == 'params'): ?><a class="nav-link active" href=""><?else:?>
					<a class="nav-link" href="/settings/params/"><?endif;?>
						<i class="fa fa-align-justify"></i> <?=lang('settings_params_title');?>
					</a>
				</li>
				<li class="nav-item">
					<? if ($current_tab == 'servers'): ?><a class="nav-link active" href=""><?else:?>
					<a class="nav-link" href="/settings/servers/"><?endif;?>
						<i class="fa fa-server"></i> <?=lang('settings_servers_title');?>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col-lg">
			<?=$content;?>
		</div>
	</div>
</div>