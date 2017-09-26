<?php $user = $_SESSION['user']; ?>
<div class='div-page-content-wrapper'>
	<div class='div-page-content-grid'>
		<?php foreach ($banks as $index => $bank): ?>
		<div class="div-gridbox-wrapper">
			<div class="div-gridbox">
				<div class="div-gridbox-header">
					<div class="text-gridbox-numbering"><?= $index + 1 ?></div>
					<h4 class="h-gridbox-title"><?= $bank->bank_title ?></h4>
				</div>
				<div class="div-gridbox-middle">
					<ul class="ul-gridbox-data w-list-unstyled">
						<li class="li-gridbox-data">
							<div class="text-gridbox-data-li">
								<strong>Course</strong><br>
								<?= $user->schools[$bank->school_id - 1]->courses[$bank->course_id - 1]->course_title ?>
							</div>
						</li>
						<li class="li-gridbox-data">
							<div class="text-gridbox-data-li">
								<strong>Chapters</strong><br><?= sizeof($bank->chapters) ?>
							</div>
						</li>
						<li class="li-gridbox-data">
							<h5 class="gridbox-item-type"><?= $bank->bank_type ?></h5>
						</li>
					</ul>
				</div>
				<div class="div-selection-checkbox">
					<span class="icon-selection-tick glyphicon glyphicon-ok" aria-hidden="true"></span>
				</div>
				<div class="div-gridbox-footer w-clearfix">
					<div class="div-gridbox-footer-buttons">
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
						<img class="img-gridbox-comments" src="<?=base_url('images/comment.png')?>">
						<div class="text-stats-number">0</div>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
<!--<div class="div-gridbox-wrapper">
			<div class="div-gridbox okay">
				<div class="text-gridbox-numbering">4</div>
				<div class="div-selection-checkbox"><span class="icon-selection-tick glyphicon glyphicon-ok" aria-hidden="true"></span></div>
				<div class="div-gridbox-header">
					<h5 class="h-gridbox-title">When are LTS's strongly bisimilar?</h5>
				</div>
				<div class="div-gridbox-middle">
					<ul class="ul-gridbox-data w-list-unstyled">
						<li class="li-gridbox-subquestion">
							<div class="text-gridbox-data-li">What's a colouring?</div>
						</li>
						<li class="li-gridbox-subquestion">
							<div class="text-gridbox-data-li">What's a colouring?</div>
						</li>
						<li class="li-gridbox-subquestion">
							<div class="text-gridbox-data-li">What's a colouring?</div>
						</li>
						<li class="li-gridbox-subquestion">
							<div class="text-gridbox-data-li">What's a colouring?</div>
						</li>
						<li class="li-gridbox-subquestion">
							<div class="text-gridbox-data-li">What's a colouring?</div>
						</li>
						<li class="li-gridbox-data">
							<h5 class="gridbox-item-type">pauldstar</h5>
						</li>
					</ul>
				</div>
				<div class="div-gridbox-footer w-clearfix">
					<div class="div-gridbox-footer-buttons">
						<div class="w-dropdown" data-delay="0">
							<div class="div-gridbox-footer-dropdown-toggle w-dropdown-toggle"><img class="img-gridbox-share" src="<?=base_url('images/share.png')?>"></div>
							<nav class="div-gridbox-footer-dropdown-li w-dropdown-list"><a class="a-gridbox-footer-dropdown-li w-dropdown-link" href="#">Twitter</a><a class="a-gridbox-footer-dropdown-li w-dropdown-link" href="#">Facebook</a></nav>
						</div>
						<div class="w-dropdown" data-delay="0">
							<div class="div-gridbox-footer-dropdown-toggle w-dropdown-toggle"><img class="img-gridbox-settings" data-ix="gridbox-settings-appear" src="<?=base_url('images/settings-black.png')?>"></div>
							<nav class="div-gridbox-footer-dropdown-li w-dropdown-list"><a class="a-gridbox-footer-dropdown-li w-dropdown-link" href="#">Duplicate</a><a class="a-gridbox-footer-dropdown-li w-dropdown-link" href="#">Details</a><a class="a-gridbox-footer-dropdown-li w-dropdown-link" href="#">Reset Score</a></nav>
						</div>
					</div>
					<div class="div-gridbox-stat">
						<img class="img-gridbox-comments" src="<?=base_url('images/comment.png')?>">
						<div class="text-stats-number">5</div>
					</div>
				</div>
			</div>
		</div>-->
	</div>
</div>