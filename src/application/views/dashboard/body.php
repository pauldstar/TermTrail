<div id='wrapper' class='container-fluid toggled'>
  <div class='row'>
    <div id='sidebar-wrapper' class='bg-mid-colour'>
      <ul class='sidebar-menu'>
        <li><a href="#">Trails</a></li>
        <li id="collapse-plus">
          <a class='sidebar-collapsible' href="#">
            Courses
            <img id="icon" src='<?=base_url('images/plus.png')?>' alt="+"/>
          </a>
          <ul class="sidebar-submenu bg-dark-colour">
            <li><a href="#">Maths</a></li>
            <li><a href="#">Chemistry</a></li>
          </ul></li>
        <li><a href="#">Settings</a></li>
        <li><a href="#">Help</a></li>
        <li><a href="#">Give Feedback</a></li>
        <li><a href="#">Privacy</a></li>
        <li><a href="#">Terms</a></li>
      </ul>
    </div>
    <!-- /#sidebar-wrapper -->
    <div id='page-content-wrapper' class='container-fluid'>
      <div class="row">
        <div class="col-xs-12">
          <h3>Recent Trails</h3>
        </div>
        <?php foreach ($trails as $trail): ?>
        <div class='grid-box-wrapper col-sm-4 col-lg-3'>
          <div class='grid-box container-fluid'>
            <div class='grid-header row'>
              <div class='col-xs-12'>
                <?=ucwords($trail->trail_title)?>
                <a href='#'><img class='settings-icon' src='<?=base_url('images/settings.png')?>' alt='Settings'/></a>
              </div>
            </div>
            <div class='row'>
              <div class='col-xs-12'>
                <ul class='grid-box-trail-data-list'>
                  <li><?=$trail->course_id?></li>
                </ul>
              </div>
            </div>
            <div class='grid-footer row'>
              <div class='col-xs-12'>
                <?=$trail->owner_id?> 
                <a href='#'><img class='share-icon' src='<?=base_url('images/share.png')?>' alt='Settings'/></a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
<script>
  // toggle the side-navbar
  $('#side-menu-toggle').click(function(event) {
    event.preventDefault();
    $('#wrapper').toggleClass('toggled');
    $('#side-menu-toggle').parent().toggleClass('active');
  });
  // toggle the side-bar sub-menu
  $('.sidebar-collapsible').click(function(event) {
    event.preventDefault();
    var li = $(this).parent();
    var img = $(this).find('img');
    var li_id = $(li).attr('id');
    if (li_id == 'collapse-plus')
    {
      var src = '<?php echo base_url("images/minus.png")?>';
      $(img).attr('src', src);
      $(li).attr('id', 'collapse-minus');
    }
    else
    {
      var src = '<?php echo base_url("images/plus.png")?>';
      $(img).attr('src', src);
      $(li).attr('id', 'collapse-plus');
    }
  });
</script>
<!-- 
  <script>
    $(document).ready(function(){
      $('.indexTopDiv').hide();
      $('#clientSignUpDiv').fadeIn();
      $('.navbar li').removeClass('active');
      $('#signUpMI').parent().addClass('active');
      $('.myError').fadeIn();
    });
    $(document).ready(function(){
    // loads home page div and change active navbar item
    $('#homeMI').click(function(){
    $('.indexTopDiv').hide();
    $('#homeDiv').fadeIn('slow');
    $('.myError').hide();
    $('.navbar li').removeClass('active');
    $('#homeMI').parent().addClass('active');
    });
    // loads login page
    $('#loginMI').click(function(){
    $('.indexTopDiv').hide();
    $('#loginDiv').fadeIn('slow');
    $('.myError').hide();
    $('.navbar li').removeClass('active');
    $('#loginMI').parent().addClass('active');
    });
    // loads client sign up page, and change active navbar item
    $('.clientSignUpBtn').click(function(){
    $('.indexTopDiv').hide();
    $('#clientSignUpDiv').fadeIn('slow');
    $('.myError').hide();
    $('.navbar li').removeClass('active');
    $('#signUpMI').addClass('active');
    });
    // loads explorer sign up page, and change active navbar item
    $('.explorerSignUpBtn').click(function(){
    $('.indexTopDiv').hide();
    $('#explorerSignUpDiv').fadeIn('slow');
    $('.myError').hide();
    $('.navbar li').removeClass('active');
    $('#signUpMI').addClass('active');
    });
    });
  </script>
  -->