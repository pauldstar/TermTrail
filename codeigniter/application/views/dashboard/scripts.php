<!-- HT5 shim and Respond.js for IE8 support of HT5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="<?=base_url('external/bootstrap3/js/html5shiv372.min.js')?>"></script>;
<script src="<?=base_url('external/bootstrap3/js/respond.min.js')?>"></script>;
<script src="<?=base_url('external/bootstrap3/js/html5shiv373.min.js')?>"></script>;
<![endif]-->

<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script>window.jQuery || document.write('<script src="<?=base_url('external/jquery/jquery3/jquery-3.2.1.min.js')?>">\x3C/script>')</script>

<script src="<?=base_url('external/bootstrap3/js/bootstrap.min.js')?>"></script>;
<script src="<?=base_url('external/webflow/dashboard/js/webfont.js')?>" type="text/javascript"></script>
<script type="text/javascript">
	WebFont.load(
	{
		google: 
		{
			families: 
			[
				"Open Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic",
				"Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic",
				"Francois One:regular:latin-ext,vietnamese,latin","Arimo:regular,italic,700,700italic"
			]
		}
	});
</script>
<script type="text/javascript">
	!function(o, c)
	{
		var n = c.documentElement,
			t = " w-mod-";
		n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
	}(window, document);
</script>
<script src="<?=base_url('external/muuri/hammer.min.js')?>"></script>
<script src="<?=base_url('external/muuri/velocity.min.js')?>"></script>
<script src="<?=base_url('external/muuri/muuri.min.js')?>"></script>
<script src="<?=base_url('external/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.js')?>"></script>
<script type="text/javascript"> 
	var siteUrl = "<?=site_url()?>";
	var baseUrl = "<?=base_url()?>";
</script>
<script src="<?=base_url('external/jquery/tt-dashboard.js')?>" type="text/javascript"></script>
<!--<script src="<?=base_url('external/webflow/dashboard/js/webflow.js')?>" type="text/javascript"></script>->
<!-- [if lte IE 9]><script src="<?=base_url('external/webflow/dashboard/js/placeholders.min.js')?>" type="text/javascript"></script> -->