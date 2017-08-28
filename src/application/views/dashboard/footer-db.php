		<!-- HT5 shim and Respond.js for IE8 support of HT5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src='<?=base_url("bootstrap3/js/html5shiv372.min.js")?>'></script>;
		<script src='<?=base_url("bootstrap3/js/respond.min.js")?>'></script>;
		<script src='<?=base_url("bootstrap3/js/html5shiv373.min.js")?>'></script>;
		<![endif]-->
		<!-- jquery (necessary for bootstrap's javascript plugins) -->
		<script src='<?=base_url("jquery3/jquery-3.1.1.min.js")?>'></script>;
		<!-- include all compiled plugins (below), or include individual files as needed -->
		<script src='<?=base_url("bootstrap3/js/bootstrap.min.js")?>'></script>;
		<!-- fonts -->
		<script src='<?=base_url("webflow/js/webfont.js")?>' type="text/javascript"></script>
		<script type="text/javascript">
			WebFont.load({
				google: {
					families: [
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
		<script src='<?=base_url("tt/tt-dashboard.js")?>' type="text/javascript"></script>
		<!-- For webflow -->
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>-->
    <script src="<?=base_url('webflow/js/webflow.js')?>" type="text/javascript"></script>
    <!-- [if lte IE 9]><script src="<?=base_url('webflow/js/placeholders.min.js')?>" type="text/javascript"></script> -->
  </body>
</html>