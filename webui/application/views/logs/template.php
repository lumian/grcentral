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
					<? if ($current_tab == 'system'): ?><a class="nav-link active" href=""><?else:?>
					<a class="nav-link" href="<?=site_url('logs/system');?>"><?endif;?>
						<i class="fa fa-cogs"></i> <?=lang('logs_tabs_title_system');?>
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