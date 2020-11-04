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
					<a class="nav-link" href="<?=site_url('phonebook');?>"><?endif;?>
						<i class="fa fa-address-book"></i> <?=lang('phonebook_tabs_title_abonents');?>
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