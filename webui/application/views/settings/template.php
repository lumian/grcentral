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
					<a class="nav-link" href="<?=site_url('settings');?>"><?endif;?>
						<i class="fa fa-home"></i> <?=lang('settings_tabs_title_main');?>
					</a>
				</li>
				<li class="nav-item">
					<? if ($current_tab == 'models'): ?><a class="nav-link active" href=""><?else:?>
					<a class="nav-link" href="<?=site_url('settings/models');?>"><?endif;?>
						<i class="fa fa-phone-square-alt"></i> <?=lang('settings_tabs_title_models');?>
					</a>
				</li>
				<li class="nav-item">
					<? if ($current_tab == 'fw'): ?><a class="nav-link active" href=""><?else:?>
					<a class="nav-link" href="<?=site_url('settings/fw');?>"><?endif;?>
						<i class="fa fa-microchip"></i> <?=lang('settings_tabs_title_fw');?>
					</a>
				</li>
				<li class="nav-item">
					<? if ($current_tab == 'params'): ?><a class="nav-link active" href=""><?else:?>
					<a class="nav-link" href="<?=site_url('settings/params');?>"><?endif;?>
						<i class="fa fa-align-justify"></i> <?=lang('settings_tabs_title_params');?>
					</a>
				</li>
				<li class="nav-item">
					<? if ($current_tab == 'servers'): ?><a class="nav-link active" href=""><?else:?>
					<a class="nav-link" href="<?=site_url('settings/servers');?>"><?endif;?>
						<i class="fa fa-server"></i> <?=lang('settings_tabs_title_servers');?>
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