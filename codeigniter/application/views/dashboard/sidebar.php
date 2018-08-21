<div class='div-sidebar-scroll'>
	<div class="div-sidebar">
		<div class="div-sidebar-navbar w-clearfix">
			<a class="a-sidebar-navbar-tab active w-inline-block" href="#" id="a-sidebar-menu-tab">
				<img src="<?=base_url('images/menu-s.png')?>">
			</a>
			<a class="a-sidebar-navbar-tab w-inline-block" href="#" id="a-sidebar-inbox-tab">
				<img src="<?=base_url('images/inbox-no-notification-s.png')?>">
			</a>
			<a class="a-sidebar-navbar-tab w-inline-block" href="#" id="a-sidebar-search-tab">
				<img src="<?=base_url('images/search-folder-gold.png')?>">
			</a>
			<a class="a-sidebar-navbar-tab disabled w-inline-block" href="#" id="a-sidebar-grid-tracker-tab">
				<img class="img-sidebar-grid-tracker-tab img-appear" id="img-grid-tracker-chapter-grey" src="<?=base_url('images/chapter-grey.png')?>" alt='Chapter'>
				<img class="img-sidebar-grid-tracker-tab" id="img-grid-tracker-chapter-gold" src="<?=base_url('images/chapter-gold.png')?>" alt='Chapter'>
			</a>
		</div>
		<div class="div-sidebar-content">
			<div class="div-sidebar-navbar-tab-pane appear" id="div-sidebar-menu">
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
						<a class="a-sidebar-menu-li collapsible w-clearfix w-inline-block" href="#">
							<img src="<?=base_url('images/resource.png')?>">
							<div class="a-sidebar-collapsible text-sidebar-menu">Add Resource</div>
							<img class="img-sidebar-li-expand appear" fill="#b3b3b3" src="<?=base_url('images/plus-s_1.png')?>" width="25">
							<img class="img-sidebar-li-collapse" fill="#b3b3b3" src="<?=base_url('images/minus-thin.png')?>">
						</a>
						<ul class="div-sidebar-submenu w-list-unstyled">
							<li class="li-sidebar-submenu">
								<a class="a-sidebar-submenu add-resource w-inline-block" id="sidebar-submenu-add-question" href="#">
									<img class="img-sidebar-menu-li" src="<?=base_url('images/minus-s.png')?>">
									<div class="text-sidebar-submenu">Question</div>
								</a>
							</li>
							<li class="li-sidebar-submenu">
								<a class="a-sidebar-submenu add-resource w-inline-block" id="sidebar-submenu-add-chapter" href="#">
									<img class="img-sidebar-menu-li" src="<?=base_url('images/minus-s.png')?>">
									<div class="text-sidebar-submenu">Chapter</div>
								</a>
							</li>
							<li class="li-sidebar-submenu">
								<a class="a-sidebar-submenu add-resource w-inline-block" id="sidebar-submenu-add-bank" href="#">
									<img class="img-sidebar-menu-li" src="<?=base_url('images/minus-s.png')?>">
									<div class="text-sidebar-submenu">Bank</div>
								</a>
							</li>
							<li class="li-sidebar-submenu">
								<a class="a-sidebar-submenu add-resource w-inline-block" id="sidebar-submenu-add-course" href="#">
									<img class="img-sidebar-menu-li" src="<?=base_url('images/minus-s.png')?>">
									<div class="text-sidebar-submenu">Course</div>
								</a>
							</li>
							<li class="li-sidebar-submenu">
								<a class="a-sidebar-submenu add-resource w-inline-block" id="sidebar-submenu-add-school" href="#">
									<img class="img-sidebar-menu-li" src="<?=base_url('images/minus-s.png')?>">
									<div class="text-sidebar-submenu">School</div>
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
			<div class="div-sidebar-navbar-tab-pane" id="div-sidebar-messages">
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
			<div class="div-sidebar-navbar-tab-pane" id="div-sidebar-search">
				<div class="div-tt-search-bar-wrapper">
					<form id="tt-search-form" autocomplete="off">
						<input class="w-input" id="tt-search-input" data-name="tt-search" maxlength="256" name="tt-search" placeholder="Current Section" type="text">
					</form>
					<img class="img-clear-tt-sidebar-search" src="<?=base_url('images/cross-diag-grey.png')?>">
				</div>
				<ul class="ul-sidebar-menu w-list-unstyled">
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li collapsible w-clearfix w-inline-block" id="user-search-categories-anchor" href="#">
							<img src="http://localhost/images/resource.png">
							<div class="a-sidebar-collapsible text-sidebar-menu">
								<?= strlen($user->username) > 16 ? substr($user->username, 0, 13).'...' : $user->username ?>
							</div>
							<img class="img-sidebar-li-expand" fill="#b3b3b3" src="http://localhost/images/plus-s_1.png" width="25">
							<img class="img-sidebar-li-collapse appear" fill="#b3b3b3" src="http://localhost/images/minus-thin.png">
						</a>
						<ul class="ul-sidebar-search-categories appear">
							<li class="li-sidebar-search-category">
								<a class="a-sidebar-search-category a-sidebar-submenu w-inline-block checked"  data-grid-source="local" data-grid-section="current-section" data-category-title="Current Section" id="current-section-search-category" href="#">
									<div class="div-tt-search-category-checkbox checked"></div>
									<div class="text-tt-search-category">Current Section</div>
								</a>
							</li>
							<li class="li-sidebar-search-category">
								<a class="a-sidebar-search-category a-sidebar-submenu w-inline-block" data-grid-source="local" data-grid-section="school" data-category-title="Your Schools" id="user-schools-search-category" href="#">
									<div class="div-tt-search-category-checkbox"></div>
									<div class="text-tt-search-category">Schools</div>
								</a>
							</li>
							<li class="li-sidebar-search-category">
								<a class="a-sidebar-search-category a-sidebar-submenu w-inline-block" data-grid-source="local" data-grid-section="course" data-category-title="Your Courses" id="user-courses-search-category" href="#">
									<div class="div-tt-search-category-checkbox"></div>
									<div class="text-tt-search-category">Courses</div>
								</a>
							</li>
							<li class="li-sidebar-search-category">
								<a class="a-sidebar-search-category a-sidebar-submenu w-inline-block" data-grid-source="local" data-grid-section="bank" data-category-title="Your Banks" id="user-banks-search-category" href="#">
									<div class="div-tt-search-category-checkbox"></div>
									<div class="text-tt-search-category">Banks</div>
								</a>
							</li>
							<li class="li-sidebar-search-category">
								<a class="a-sidebar-search-category a-sidebar-submenu w-inline-block" data-grid-source="local" data-grid-section="chapter" data-category-title="Your Chapters" id="user-chapters-search-category" href="#">
									<div class="div-tt-search-category-checkbox"></div>
									<div class="text-tt-search-category">Chapters</div>
								</a>
							</li>
							<li class="li-sidebar-search-category">
								<a class="a-sidebar-search-category a-sidebar-submenu w-inline-block" data-grid-source="local" data-grid-section="question" data-category-title="Your Questions" id="user-questions-search-category" href="#">
									<div class="div-tt-search-category-checkbox"></div>
									<div class="text-tt-search-category">Questions</div>
								</a>
							</li>
						</ul>
					</li>
					<li class="li-sidebar-menu">
						<a class="a-sidebar-menu-li collapsible w-clearfix w-inline-block" id="termtrail-search-categories-anchor" href="#">
							<img src="http://localhost/images/tl_logo.png">
							<div class="a-sidebar-collapsible text-sidebar-menu">TermtraiL</div>
							<img class="img-sidebar-li-expand appear" fill="#b3b3b3" src="http://localhost/images/plus-s_1.png" width="25">
							<img class="img-sidebar-li-collapse" fill="#b3b3b3" src="http://localhost/images/minus-thin.png">
						</a>
						<ul class="ul-sidebar-search-categories" id="termtrail-search-categories-ul">
							<li class="li-sidebar-search-category">
								<a class="a-sidebar-search-category a-sidebar-submenu w-inline-block" data-grid-source="universal" data-grid-section="user" data-category-title="TL Users" id="termtrail-users-search-category" href="#">
									<div class="div-tt-search-category-checkbox"></div>
									<div class="text-tt-search-category">Users</div>
								</a>
							</li>
							<li class="li-sidebar-search-category">
								<a class="a-sidebar-search-category a-sidebar-submenu w-inline-block" data-grid-source="universal" data-grid-section="school" data-category-title="TL Schools" id="termtrail-schools-search-category" href="#">
									<div class="div-tt-search-category-checkbox"></div>
									<div class="text-tt-search-category">Schools</div>
								</a>
							</li>
							<li class="li-sidebar-search-category">
								<a class="a-sidebar-search-category a-sidebar-submenu w-inline-block" data-grid-source="universal" data-grid-section="course" data-category-title="TL Courses" id="termtrail-courses-search-category" href="#">
									<div class="div-tt-search-category-checkbox"></div>
									<div class="text-tt-search-category">Courses</div>
								</a>
							</li>
							<li class="li-sidebar-search-category">
								<a class="a-sidebar-search-category a-sidebar-submenu w-inline-block" data-grid-source="universal" data-grid-section="bank" data-category-title="TL Banks" id="termtrail-banks-search-category" href="#">
									<div class="div-tt-search-category-checkbox"></div>
									<div class="text-tt-search-category">Banks</div>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="div-sidebar-navbar-tab-pane" id="div-sidebar-grid-tracker">
				<ul class="ul-sidebar-questions-list w-clearfix">
					<li class="li-grid-tracker-item" data-grid-tracker-item-id="1">1</li>
					<li class="li-grid-tracker-item" data-grid-tracker-item-id="2">2</li>
					<li class="li-grid-tracker-item" data-grid-tracker-item-id="3">3</li>
					<li class="li-grid-tracker-item" data-grid-tracker-item-id="4">4</li>
				</ul>
			</div>
		</div>
	</div>
</div>