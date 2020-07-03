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
					<a class="nav-link" href="/phones/"><?endif;?>
						<?=lang('phones_title');?>
					</a>
				</li>
				<? if ($current_tab == 'info'): ?>
				<li class="nav-item">
					<a class="nav-link active" href="">
						<?=lang('phones_info_title');?>
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