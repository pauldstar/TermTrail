<div class='div-sidebar-scroll'>
	<div class="div-sidebar">
		<div class="div-sidebar-navbar w-clearfix">
			<a class="a-navbar-toggle-buttons active w-inline-block" data-ix="sidebar-menu-appear" href="#" id="btn-sidebar-menu">
				<img src="<?=base_url('images/menu-s.png')?>">
			</a>
			<a class="a-navbar-toggle-buttons w-inline-block" data-ix="sidebar-messages-appear" href="#" id="btn-sidebar-inbox">
				<img src="<?=base_url('images/inbox-no-notification-s.png')?>">
			</a>
			<a class="a-navbar-toggle-buttons w-inline-block" data-ix="sidebar-search-appear" href="#" id="btn-sidebar-search">
				<img src="<?=base_url('images/search-folder-gold.png')?>">
			</a>
			<a class="a-navbar-toggle-buttons w-inline-block" data-ix="sidebar-questions-appear" href="#" id="btn-sidebar-question-finder">
				<img id='chapter-grey' src="<?=base_url('images/chapter-grey.png')?>" alt='Chapter'>
				<img id='chapter-gold' src="<?=base_url('images/chapter-gold.png')?>" alt='Chapter'>
			</a>
		</div>
		<div class="div-sidebar-content">
			<div class="div-sidebar-menu">
				<ul class="ul-sidebar-menu w-list-unstyled">
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li active w-inline-block"  data-action="refresh-grid" data-title="bank" href="#">
							<img src="<?=base_url('images/bank.png')?>">
							<div class="text-sidebar-menu">Banks</div>
						</a>
					</li>
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li w-inline-block" data-action="refresh-grid" data-title="course" href="#">
							<img src="<?=base_url('images/course.png')?>">
							<div class="text-sidebar-menu">Courses</div>
						</a>
					</li>
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li w-inline-block" data-action="refresh-grid" data-title="school" href="#">
							<img src="<?=base_url('images/school-bag.png')?>">
							<div class="text-sidebar-menu">Schools</div>
						</a>
					</li>
				</ul>
				<ul class="ul-sidebar-menu w-list-unstyled">
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li collapsible w-clearfix w-inline-block" data-ix="submenu-expand" href="#">
							<img src="<?=base_url('images/resource.png')?>">
							<div class="a-sidebar-collapsible text-sidebar-menu">Add Resource</div>
							<img class="img-sidebar-li-expand" fill="#b3b3b3" src="<?=base_url('images/plus-s_1.png')?>" width="25">
							<img class="img-sidebar-li-collapse" data-ix="submenu-vanish" fill="#b3b3b3" src="<?=base_url('images/minus-thin.png')?>">
						</a>
						<ul class="div-sidebar-submenu w-list-unstyled">
							<li class="li-sidebar-submenu">
								<a class="a-sidebar-submenu add-resource w-inline-block" id="sidebar-submenu-add-question" href="#">
									<img class="img-sidebar-menu-li" src="<?=base_url('images/minus-s_1.png')?>">
									<div class="text-sidebar-submenu" data-ix="hide-submenu">Question</div>
								</a>
							</li>
							<li class="li-sidebar-submenu">
								<a class="a-sidebar-submenu add-resource w-inline-block" id="sidebar-submenu-add-chapter" href="#">
									<img class="img-sidebar-menu-li" src="<?=base_url('images/minus-s_1.png')?>">
									<div class="text-sidebar-submenu" data-ix="hide-submenu">Chapter</div>
								</a>
							</li>
							<li class="li-sidebar-submenu">
								<a class="a-sidebar-submenu add-resource w-inline-block" id="sidebar-submenu-add-bank" href="#">
									<img class="img-sidebar-menu-li" src="<?=base_url('images/minus-s_1.png')?>">
									<div class="text-sidebar-submenu" data-ix="hide-submenu">Bank</div>
								</a>
							</li>
							<li class="li-sidebar-submenu">
								<a class="a-sidebar-submenu add-resource w-inline-block" id="sidebar-submenu-add-course" href="#">
									<img class="img-sidebar-menu-li" src="<?=base_url('images/minus-s_1.png')?>">
									<div class="text-sidebar-submenu" data-ix="hide-submenu">Course</div>
								</a>
							</li>
							<li class="li-sidebar-submenu">
								<a class="a-sidebar-submenu add-resource w-inline-block" id="sidebar-submenu-add-school" href="#">
									<img class="img-sidebar-menu-li" src="<?=base_url('images/minus-s_1.png')?>">
									<div class="text-sidebar-submenu" data-ix="hide-submenu">School</div>
								</a>
							</li>
						</ul>
					</li>
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li w-inline-block" href="#">
							<img src="<?=base_url('images/delete.png')?>">
							<div class="text-sidebar-menu">Trash</div>
						</a>
					</li>
				</ul>
				<ul class="ul-sidebar-menu w-list-unstyled">
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li w-inline-block" href="#">
							<img src="<?=base_url('images/question_1.png')?>">
							<div class="text-sidebar-menu">Help Centre</div>
						</a>
					</li>
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li w-inline-block" href="#">
							<img src="<?=base_url('images/comment_2.png')?>">
							<div class="text-sidebar-menu">Feedback</div>
						</a>
					</li>
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li w-inline-block" href="#">
							<img src="<?=base_url('images/terms.png')?>">
							<div class="text-sidebar-menu">Terms</div>
						</a>
					</li>
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li w-inline-block" href="#">
							<img src="<?=base_url('images/keyboard.png')?>">
							<div class="text-sidebar-menu">Keyboard Shortcuts</div>
						</a>
					</li>
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li w-inline-block" href="#">
							<img src="<?=base_url('images/donate.png')?>">
							<div class="text-sidebar-menu">Donate</div>
						</a>
					</li>
				</ul>
			</div>
			<div class="div-sidebar-messages">
				<ul class="ul-sidebar-menu w-list-unstyled">
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li unread w-inline-block" href="#">
							<div class="text-sidebar-message-sender">TermTrail</div>
							<div class="text-sidebar-message-subject">Update</div>
						</a>
					</li>
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li active w-inline-block" href="#">
							<div class="text-sidebar-message-sender">Dangalo</div>
							<div class="text-sidebar-message-subject">Trail exported: Asset Geolocation</div>
						</a>
					</li>
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li w-inline-block" href="#">
							<div class="text-sidebar-message-sender">PVMKylez</div>
							<div class="text-sidebar-message-subject">Course import request: Maths</div>
						</a>
					</li>
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li w-inline-block" href="#">
							<div class="text-sidebar-message-sender">TermTrail</div>
							<div class="text-sidebar-message-subject">Welcome Message</div>
						</a>
					</li>
				</ul>
			</div>
			<div class="div-sidebar-search" id="search-side-bar">
				<div class="div-tt-search-bar-wrapper">
					<form id="tt-search-form" name="email-form">
						<input class="text-field-tt-search w-input" data-name="tt-search" id="tt-search-input" maxlength="256" name="tt-search" placeholder="Current Section" type="text">
					</form>
					<img class="img-clear-tt-sidebar-search" src="<?=base_url('images/cross-diag-grey.png')?>">
				</div>
				<ul class="ul-sidebar-search-categories">
					<li class="li-sidebar-search-category">
						<a class="a-sidebar-search-category checked w-inline-block" id="current-section-search-category" href="#">
							<div class="checked div-tt-search-category-checkbox"></div>
							<div class="text-tt-search-category">Current Section</div>
						</a>
					</li>
					<li class="li-sidebar-search-category">
						<a class="a-sidebar-search-category w-inline-block" href="#">
							<div class="div-tt-search-category-checkbox"></div>
							<div class="text-tt-search-category">Schools</div>
						</a>
					</li>
					<li class="li-sidebar-search-category">
						<a class="a-sidebar-search-category w-inline-block" href="#">
							<div class="div-tt-search-category-checkbox"></div>
							<div class="text-tt-search-category">Courses</div>
						</a>
					</li>
					<li class="li-sidebar-search-category">
						<a class="a-sidebar-search-category w-inline-block" href="#">
							<div class="div-tt-search-category-checkbox"></div>
							<div class="text-tt-search-category">Banks</div>
						</a>
					</li>
					<li class="li-sidebar-search-category">
						<a class="a-sidebar-search-category w-inline-block" href="#">
							<div class="div-tt-search-category-checkbox"></div>
							<div class="text-tt-search-category">Chapters</div>
						</a>
					</li>
					<li class="li-sidebar-search-category">
						<a class="a-sidebar-search-category w-inline-block" href="#">
							<div class="div-tt-search-category-checkbox"></div>
							<div class="text-tt-search-category">Questions</div>
						</a>
					</li>
				</ul>
			</div>
			<div class="div-sidebar-questions">
				<ul class="ul-sidebar-questions-list w-clearfix">
					<li class="li-sidebar-question" data-gc-id="1">1</li>
					<li class="li-sidebar-question" data-gc-id="2">2</li>
					<li class="li-sidebar-question" data-gc-id="3">3</li>
					<li class="li-sidebar-question" data-gc-id="4">4</li>
					<li class="li-sidebar-question" data-gc-id="5">5</li>
					<li class="li-sidebar-question" data-gc-id="6">6</li>
					<li class="li-sidebar-question" data-gc-id="7">7</li>
					<li class="li-sidebar-question" data-gc-id="8">8</li>
					<li class="li-sidebar-question" data-gc-id="9">9</li>
					<li class="li-sidebar-question" data-gc-id="10">10</li>
					<li class="li-sidebar-question" data-gc-id="11">11</li>
					<li class="li-sidebar-question" data-gc-id="12">12</li>
					<li class="li-sidebar-question" data-gc-id="13">13</li>
					<li class="li-sidebar-question" data-gc-id="14">14</li>
					<li class="li-sidebar-question" data-gc-id="15">15</li>
					<li class="li-sidebar-question" data-gc-id="16">16</li>
					<li class="li-sidebar-question" data-gc-id="17">17</li>
					<li class="li-sidebar-question" data-gc-id="18">18</li>
					<li class="li-sidebar-question" data-gc-id="19">19</li>
					<li class="li-sidebar-question" data-gc-id="20">20</li>
					<li class="li-sidebar-question" data-gc-id="21">21</li>
					<li class="li-sidebar-question" data-gc-id="22">22</li>
					<li class="li-sidebar-question" data-gc-id="23">23</li>
					<li class="li-sidebar-question" data-gc-id="24">24</li>
				</ul>
			</div>
		</div>
	</div>
</div>