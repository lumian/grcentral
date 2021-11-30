<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<div class="row">
		<div class="col-lg">
			<? $current_tab = $this->uri->segment('2'); ?>
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<? if ($current_tab == 'provisioning'): ?><a class="nav-link active" href=""><?else:?>
					<a class="nav-link" href="<?=site_url('logs/provisioning');?>"><?endif;?>
						<i class="fa fa-bezier-curve"></i> <?=lang('logs_tabs_title_provisioning');?>
					</a>
				</li>
				<li class="nav-item">
					<? if ($current_tab == 'api'): ?><a class="nav-link active" href=""><?else:?>
					<a class="nav-link" href="<?=site_url('logs/api');?>"><?endif;?>
						<i class="fa fa-database"></i> <?=lang('logs_tabs_title_api');?>
					</a>
				</li>
				<? if ($this->settings_model->syssettings_get('monitoring_enable') == 'on'): ?>
				<li class="nav-item">
					<? if ($current_tab == 'monitoring'): ?><a class="nav-link active" href=""><?else:?>
					<a class="nav-link" href="<?=site_url('logs/monitoring');?>"><?endif;?>
						<i class="fa fa-wifi"></i> <?=lang('logs_tabs_title_monitoring');?>
					</a>
				</li>
				<? endif; ?>
			</ul>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col-lg">
			<?=$content;?>
		</div>
	</div>
</div>