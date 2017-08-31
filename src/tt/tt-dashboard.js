$(document).ready(function()
{
	/* ----------------------------------------------------------------------
	 * LIST OF INTERACTIONS
	 * ---------------------------------------------------------------------- */
	
	// SIDEBAR MENU ITEM ACTIVATE
	$('.a-sidebar-menu-li').click(function(event)
	{
		// only activate if not a collapsible
		if (!$(this).hasClass('collapsible')) 
		{
			$('.a-sidebar-menu-li').removeClass('active');
			$(this).addClass('active');
		}
	});
	
	// SIDEBAR NAVBAR ITEM ACTIVATION
	$('.a-navbar-toggle-buttons').click(function(event)
	{
		$('.a-navbar-toggle-buttons').removeClass('active');
		$(this).addClass('active');
	});
	
	// TOGGLE SIDEBAR AND STRETCH PAGE CONTENT
	$('.btn-navbar-menu').click(function(event)
	{
		$('.div-sidebar').toggleClass('sidebar-close');
		$('.div-page-content-wrapper').toggleClass('shrink');
	});
	
	// CLEAR TT SEARCHBAR
	$('.img-clear-tt-sidebar-search').click(function(event) 
	{ 
		clearSearchBar();
	});
	
	// TRIGGER TT SEARCH BAR FROM SIDEBAR NAV
	$('#button-sidebar-search').click(function(event)
	{
		clearSearchBar();
	});
		
	// TRIGGER TT SEARCH BAR FROM TOOLBAR
	$('#toolbar-search').click(function(event)
	{
		if ($('.div-sidebar').hasClass('sidebar-close')) 
		{
			$('.div-sidebar').removeClass('sidebar-close');
			$('.div-page-content-wrapper').toggleClass('shrink');
		}
		$('.div-sidebar-content').children().css('display', 'none');
		$('.div-sidebar-navbar').children().removeClass('active');
		$('#button-sidebar-search').addClass('active');		
		$('.div-sidebar-search').css('display', 'block');
		// select to search 'current section' category
		$('.a-sidebar-search-category').removeClass('checked');
		$('.div-tt-search-category-checkbox').removeClass('checked');
		$('#current-section-search-category').addClass('checked');
		$('#current-section-search-category').children('.div-tt-search-category-checkbox').addClass('checked');
		$('.form-sidebar-tt-search-text-field').select();
		updateSearchBarPlaceholder('Current Section');
	});
	
	// TOGGLE TOOLBAR BUTTONS WITH 'DATA-TOOL-TOGGLE' ATTRIBUTES
	$('.div-tool-dropdown-toggle').click(function(event)
	{
		var dataToolToggle = $(this).attr('data-tool-toggle');
		if (dataToolToggle == "1") $(this).toggleClass('pressed');
	});
	
	// INITIALISE MASONRY FOR THE GRID
	$('.grid').masonry(
	{
		itemSelector: '.grid-item',
		columnWidth: '.grid-sizer',
		percentPosition: true
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
	
	// SELECT GRID/CHAPTER BOX AND UPDATE STATUS TEXT
	defaultGridStatus = '';
	selectedGridboxCount = 0;
	$('.div-selection-checkbox').click(function(event)
	{
		if ($(this).hasClass('selected')) 
		{
			selectedGridboxCount--;
			if (selectedGridboxCount == 0) $('.text-grid-status').html(defaultGridStatus);
			else $('.text-grid-status').html(selectedGridboxCount + ' Selected');
		} 
		else 
		{
		  selectedGridboxCount++;
			if (selectedGridboxCount == 1) defaultGridStatus = $('.text-grid-status').html();
			$('.text-grid-status').html(selectedGridboxCount + ' Selected');
		}
		$(this).toggleClass('selected');
		$(this).parent().toggleClass('selected');
		$(this).siblings('.div-gridbox-footer').toggleClass('selected');
	});
	
	// SELECT TT SEARCH CATEGORY
	$('.a-sidebar-search-category').click(function(event)
	{
		$('.a-sidebar-search-category').removeClass('checked');
		$('.div-tt-search-category-checkbox').removeClass('checked');
		$(this).addClass('checked');
		$(this).children('.div-tt-search-category-checkbox').addClass('checked');
		// update search bar placeholder
		var category = $(this).children('.text-tt-search-category').html();
		var newPlaceholder = category;
		clearSearchBar();
		updateSearchBarPlaceholder(newPlaceholder);
	});
	
	/* ----------------------------------------------------------------------
	 * LIST OF FUNCTIONS USED BY INTERACTIONS
	 * ---------------------------------------------------------------------- */
	 
	function clearSearchBar()
	{
		$('.form-sidebar-tt-search-text-field').val('');
		$('.form-sidebar-tt-search-text-field').select();
	}
	
	function updateSearchBarPlaceholder(text)
	{
		$('.form-sidebar-tt-search-text-field').attr('placeholder', text);
	}
});