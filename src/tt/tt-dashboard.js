$(document).ready(function()
{
	// TOGGLE THE SIDEBAR TO EXPAND/COLLAPSE PAGE-CONTENT-WRAPPER
	$('.btn-navbar-menu').click(function(event)
	{
		$('.div-page-content-wrapper').toggleClass('shrink');
	});
	// TOGGLE TOOLBAR BUTTONS WITH 'DATA-TOOL-TOGGLE' ATTRIBUTES
	$('.div-tool-dropdown-toggle').click(function(event)
	{
		var dataToolToggle = $(this).attr('data-tool-toggle');
		if (dataToolToggle == "1") $(this).toggleClass('pressed');
	});
	// GRID ICONS APPEAR
	$('.div-gridbox').mouseenter(function(event)
	{
		$(this).find('.div-gridbox-footer-buttons').fadeTo(200, 1);
		$(this).find('.div-selection-checkbox').fadeTo(200, 1);
	});
	// GRID ICONS DISAPPEAR
	$('.div-gridbox').mouseleave(function(event)
	{
		// only fadeout if grid-box hasn't been selected
		if (!$(this).hasClass('selected'))
		{
			$(this).find('.div-gridbox-footer-buttons').fadeTo(200, 0);
			$(this).find('.div-selection-checkbox').fadeTo(200, 0);
		}
	});
	// CHAPTER BOX ICONS APPEAR
	$('.a-chapter-item').mouseenter(function(event)
	{
		$(this).find('.img-chapter-info').fadeIn(200);
		$(this).find('.img-edit-chapter').fadeIn(200);
		$(this).find('.div-selection-checkbox').fadeTo(200, 1);
	});
	// GRID ICONS DISAPPEAR
	$('.a-chapter-item').mouseleave(function(event)
	{
		// only fadeout if grid-box hasn't been selected
		if (!$(this).hasClass('selected'))
		{
			$(this).find('.img-chapter-info').fadeOut(200);
			$(this).find('.img-edit-chapter').fadeOut(200);
			$(this).find('.div-selection-checkbox').fadeTo(200, 0);
		}
	});
});