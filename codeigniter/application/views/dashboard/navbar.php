<div class="div-navbar w-nav" data-animation="over-left" data-collapse="all" data-duration="200">
  <div class="btn-navbar-menu" data-ix="sidebar-appear-toggle">
		<span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
	</div>
  <h3 class="h-logo">TermtraiL</h3>
  <div class="div-navbar-container w-container">
    <h4 class="h-sub-topic-heading"></h4>
    <h3 class="h-main-topic-heading">Banks</h3>
  </div>
  <div class="div-navbar-username-toggle" data-ix="user-account-banner-toggle">
    <div class="text-navbar-username">
			<strong><?=$user->username?></strong>
		</div>
		<span class="icon-user-banner-expand glyphicon glyphicon-plus"  id="toggle-expand" aria-hidden="true"></span>
		<span class="icon-user-banner-collapse glyphicon glyphicon-minus" id="toggle-collapse" aria-hidden="true"></span>
  </div>
  <div class="div-navbar-account">
    <a class="btn-navbar-account-menu-item w-inline-block" href="<?=site_url('logout')?>">
      <img class="img-navbar-account-menu-item" src="<?=base_url('images/power-off-icon.png')?>"/>
      <div class="text-navbar-account-menu-item">Sign Out</div>
    </a>
    <a class="btn-navbar-account-menu-item w-inline-block" href="#">
      <img class="img-navbar-account-menu-item" src="<?=base_url('images/settings_1.png')?>"/>
      <div class="text-navbar-account-menu-item">Account</div>
    </a>
  </div>
</div>