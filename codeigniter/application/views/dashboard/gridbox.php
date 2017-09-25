<div class="div-gridbox-wrapper">
	<div class="div-gridbox">
		
		<div class="div-gridbox-header">
			<div class="text-gridbox-numbering"><?= $gridbox->gridbox_number ?></div>
			<?php if ($gridbox->section == 'question'): ?>
				<h5 class="h-gridbox-title"><?= $gridbox->title ?></h5>
			<?php else: ?>
				<h4 class="h-gridbox-title"><?= $gridbox->title ?></h4>
			<?php endif; ?>
			<div class="div-selection-checkbox">
				<span class="icon-selection-tick glyphicon glyphicon-ok" aria-hidden="true"></span>
			</div>
		</div>
		
		<div class="div-gridbox-middle">
			<ul class="ul-grid-box-data w-list-unstyled">
				<?php switch($gridbox->section):
					case 'question': ?>
						<?php foreach ($gridbox->subquestions as $subquestion): ?>
							<li class="li-gridbox-subquestion">
								<div class="text-grid-box-data-li"><?= $subquestion ?></div>
							</li>
						<?php endforeach; ?>
						<?php break; ?>
					<?php case 'chapter': ?>
					<?php case 'bank': ?>
					<?php case 'course': ?>
						<?php if ($gridbox->is_universal): ?>
							<li class="li-grid-box-data">
								<div class="text-grid-box-data-li">
									<strong><?= $gridbox->parent_label ?></strong><br>
									<?= $gridbox->parent_title ?>
								</div>
							</li>
						<?php endif; ?>
					<?php case 'school': ?>
						<li class="li-grid-box-data">
							<div class="text-grid-box-data-li">
								<strong><?= $gridbox->child_label ?></strong><br>
								<?= $gridbox->child_count ?>
							</div>
						</li>
						<li class="li-grid-box-data">
							<h5 class="grid-box-item-type"><?= $gridbox->source_type ?></h5>
						</li>
				<?php endswitch; ?>
			</ul>
		</div>
		
		<div class="div-gridbox-footer w-clearfix">
			<div class="div-gridbox-footer-buttons">
				<div class="w-dropdown" data-delay="0">
					<div class="div-gridbox-footer-dropdown-toggle w-dropdown-toggle">
						<img class="img-gridbox-share" src="<?=base_url('webflow/dashboard/images/share.png')?>">
					</div>
					<nav class="div-gridbox-footer-dropdown-li w-dropdown-list">
						<a class="a-gridbox-footer-dropdown-li w-dropdown-link" href="#">Twitter</a>
						<a class="a-gridbox-footer-dropdown-li w-dropdown-link" href="#">Facebook</a>
					</nav>
				</div>
				<div class="w-dropdown" data-delay="0">
					<div class="div-gridbox-footer-dropdown-toggle w-dropdown-toggle">
						<img class="img-gridbox-settings" data-ix="gridbox-settings-appear" src="<?=base_url('webflow/dashboard/images/settings-black.png')?>">
					</div>
					<nav class="div-gridbox-footer-dropdown-li w-dropdown-list">
						<a class="a-gridbox-footer-dropdown-li w-dropdown-link" href="#">Duplicate</a>
						<a class="a-gridbox-footer-dropdown-li w-dropdown-link" href="#">Delete</a>
						<a class="a-gridbox-footer-dropdown-li w-dropdown-link" href="#">Details</a>
						<a class="a-gridbox-footer-dropdown-li w-dropdown-link" href="#">Reset Score</a>
					</nav>
				</div>
			</div>
			<div class="div-gridbox-stat">
				<?php if ($gridbox->comment_count !== 0): ?>
					<img class="img-gridbox-comments" src="<?=base_url('webflow/dashboard/images/comment.png')?>">
					<div class="text-stats-number"><?= $gridbox->comment_count ?></div>
				<?php endif; ?>
			</div>
		</div>
		
	</div>
</div>