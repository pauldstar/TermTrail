<div class="div-gridbox-wrapper">
	<div class="div-gridbox" data-full-json-id='[<?= json_encode($gridbox->full_id) ?>]' data-grid-section="<?= $gridbox->section ?>" data-grid-child-section="<?= $gridbox->child_label ?>">
		
		<div class="div-gridbox-header">
			<div class="text-gridbox-numbering"><?= $gridbox->gridbox_number ?></div>
			<?php if ($gridbox->section == 'question'): ?>
				<h5 class="h-gridbox-title"><?= $gridbox->title ?></h5>
			<?php else: ?>
				<h4 class="h-gridbox-title"><?= $gridbox->title ?></h4>
			<?php endif; ?>
			<div class="div-selection-checkbox icon-wrapper">
				<span class="icon-selection-tick glyphicon glyphicon-ok" aria-hidden="true"></span>
			</div>
		</div>
		
		<div class="div-gridbox-middle">
			<ul class="ul-gridbox-data w-list-unstyled">
				<?php switch($gridbox->section):
					case 'question': ?>
						<?php if ($gridbox->subquestions !== NULL): ?>
							<?php foreach ($gridbox->subquestions as $subquestion): ?>
								<li class="li-gridbox-subquestion">
									<div class="text-gridbox-data-li"><?= $subquestion ?></div>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
						<?php break; ?>
					<?php case 'chapter': ?>
					<?php case 'bank': ?>
					<?php case 'course': ?>
						<?php if ($gridbox->is_universal): ?>
							<li class="li-gridbox-data">
								<div class="text-gridbox-data-li">
									<strong><?= $gridbox->parent_label ?></strong><br>
									<?= $gridbox->parent_title ?>
								</div>
							</li>
						<?php endif; ?>
					<?php case 'school': ?>
						<li class="li-gridbox-data">
							<div class="text-gridbox-data-li">
								<strong><?= $gridbox->child_label.'s' ?></strong><br>
								<?= $gridbox->child_count ?>
							</div>
						</li>
				<?php endswitch; ?>
				<li class="li-gridbox-data">
					<h5 class="gridbox-item-type"><?= $gridbox->source_type ?></h5>
				</li>
			</ul>
		</div>
		
		<div class="div-gridbox-footer w-clearfix">
			<div class="div-gridbox-footer-buttons icon-wrapper">
				<div class="w-dropdown" data-delay="0">
					<div class="div-gridbox-footer-dropdown-toggle w-dropdown-toggle">
						<img class="img-gridbox-share" src="<?=base_url('images/share.png')?>">
					</div>
					<nav class="div-gridbox-footer-dropdown-li w-dropdown-list">
						<a class="a-gridbox-footer-dropdown-li w-dropdown-link" href="#">Twitter</a>
						<a class="a-gridbox-footer-dropdown-li w-dropdown-link" href="#">Facebook</a>
					</nav>
				</div>
				<div class="w-dropdown" data-delay="0">
					<div class="div-gridbox-footer-dropdown-toggle w-dropdown-toggle">
						<img class="img-gridbox-settings" data-ix="gridbox-settings-appear" src="<?=base_url('images/settings-black.png')?>">
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
					<img class="img-gridbox-comments" src="<?=base_url('images/comment.png')?>">
					<div class="text-stats-number"><?= $gridbox->comment_count ?></div>
				<?php endif; ?>
			</div>
			
		</div>
		
	</div>
</div>