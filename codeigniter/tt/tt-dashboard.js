$(document).ready(function()
{
	/* ----------------------------------------------------------------------------------------------
	 * INTERACTIONS
	 * ------------------------------------------------------------------------------------------- */
	 
	var gridPageContent, 
			gridActive = true;
			
	/* MUURI GRID */
	gridPageContent = new Muuri('.div-page-content-grid', 
	{
		dragEnabled: true,
	});
	
	/* SORTABLE GRID COUNTER */
	$('.ul-sidebar-questions-list').sortable(
	{ 
		scroll: false,
		distance: 20,
		// containment: 'parent', // box constraining the sortable items
	});
	
	/* HIGHLIGHT GRIDBOX WHEN CLICKING GRID COUNTER */
	var gridBox2Highlight = '';
	$('.li-sidebar-question').on('click mouseleave', function(event)
	{
		switch (event.type)
		{
			case 'click':
				var gridIndex = $(this).html() - 1;
				gridBox2Highlight = $('.div-gridbox').eq(gridIndex);
				gridBox2Highlight.addClass('outline-div-gridbox');
				// scroll to highlighted gridbox
				var scrollOffset = $(gridBox2Highlight).offset().top - 350;
				$('html, body').animate({scrollTop: scrollOffset}, 500);
				break;
			case 'mouseleave':
				if (gridBox2Highlight != '') 
				{
					gridBox2Highlight.removeClass('outline-div-gridbox');
					gridBox2Highlight = '';
				}
		}
	});
		
	/* SIDEBAR MENU ITEM ACTIVATE */
	$('.a-sidebar-menu-li').click(function(event)
	{
		// only activate if not a collapsible
		if (!$(this).hasClass('collapsible')) 
		{
			$('.a-sidebar-menu-li').removeClass('active');
			$(this).addClass('active');
		}
	});
	
	/* SIDEBAR NAVBAR ITEM ACTIVATION */
	$('.a-navbar-toggle-buttons').click(function(event)
	{
		$('.a-navbar-toggle-buttons').removeClass('active');
		$(this).addClass('active');
	});
	
	/* TOGGLE SIDEBAR AND STRETCH PAGE CONTENT */
	$('.btn-navbar-menu').click(function(event)
	{
		$('.div-sidebar-scroll').toggleClass('sidebar-close');
		$('.div-page-content-wrapper').toggleClass('stretch');
	});
	
	/* CLEAR TT SEARCHBAR WITH SEARCH BAR 'X' */
	$('.img-clear-tt-sidebar-search').click(function(event) 
	{ 
		clearSearchBar();
	});
	
	/* TRIGGER TT SEARCH BAR FROM SIDEBAR NAV */
	$('#btn-sidebar-search').click(function(event)
	{
		clearSearchBar();
	});
		
	/* TRIGGER TT SEARCH BAR FROM TOOLBAR */
	$('#toolbar-search').click(function(event)
	{
		if ($('.div-sidebar-scroll').hasClass('sidebar-close')) 
		{
			$('.div-sidebar-scroll').removeClass('sidebar-close');
			$('.div-page-content-wrapper').toggleClass('stretch');
		}
		$('.div-sidebar-content').children().css('display', 'none');
		$('.div-sidebar-navbar').children().removeClass('active');
		$('#btn-sidebar-search').addClass('active');		
		$('.div-sidebar-search').css('display', 'block');
		// select to search 'current section' category
		$('.a-sidebar-search-category').removeClass('checked');
		$('.div-tt-search-category-checkbox').removeClass('checked');
		$('#current-section-search-category').addClass('checked');
		$('#current-section-search-category').children('.div-tt-search-category-checkbox').addClass('checked');
		$('.form-sidebar-tt-search-text-field').select();
		updateSearchBarPlaceholder('Current Section');
	});
	
	/* TOGGLE TOOLBAR BUTTONS WITH 'DATA-TOOL-TOGGLE' ATTRIBUTES */
	$('.div-tool-dropdown-toggle').click(function(event)
	{
		var dataToolToggle = $(this).attr('data-tool-toggle');
		if (dataToolToggle == "1") $(this).toggleClass('pressed');
	});
	
	/* TOGGLE GRID ICONS OPACITY */
	$('.div-gridbox').mouseenter(function(event)
	{
		$(this).find('.div-gridbox-footer-buttons').fadeTo(200, 1);
		$(this).find('.div-selection-checkbox').fadeTo(200, 1);
	});
	$('.div-gridbox').mouseleave(function(event)
	{
		// only fadeout if grid-box hasn't been selected
		if (!$(this).hasClass('selected'))
		{
			$(this).find('.div-gridbox-footer-buttons').fadeTo(200, 0);
			$(this).find('.div-selection-checkbox').fadeTo(200, 0);
		}
	});
	
	/* SELECT GRID/CHAPTER BOX AND UPDATE STATUS TEXT */
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
	
	/* SELECT TT SEARCH CATEGORY */
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
	
  /* ----------------------------------------------------------------------------------------------
   * FUNCTIONS FOR INTERACTIONS
   * ------------------------------------------------------------------------------------------- */
	
	function clearSearchBar()
	{
		$('.form-sidebar-tt-search-text-field').val('');
		$('.form-sidebar-tt-search-text-field').select();
	}
	
	function updateSearchBarPlaceholder(text)
	{
		$('.form-sidebar-tt-search-text-field').attr('placeholder', text);
	}
	
	function dump(obj) 
	{
    var out = '';
    for (var i in obj) out += i + ": " + obj[i] + "\n";
    console.log(out);
		/* // or, if you wanted to avoid alerts...
    var pre = document.createElement('pre');
    pre.innerHTML = out;
    document.body.appendChild(pre) */
	}
});
	
/* 	// CHAPTER BOX ICONS APPEAR
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
	}); */
	
	/* SORTABLE GRID */
	/* $('.div-page-content-grid').sortable(
	{ 
		items: '.div-gridbox-wrapper',
		distance: 5,
		cursor: 'move',
		start: function ()
		{
			gridPageContent.masonry('destroy'); // destroy
			$('.div-gridbox-header').nextAll().css('display', 'none');
			$('.div-gridbox').css('height', '200px');
		},
		stop: function ()
		{
			$('.div-gridbox-header').nextAll().css('display', 'block');
			$('.div-gridbox').css('height', '');
			gridPageContent.masonry(pageContentMasonryOptions); // re-initialize
		}
	}); */
	
	/* TOGGLE GRID FORMAT */
	/* $('#toolbar-grid-format').click(function(event)
	{
		toggleGridFormat(gridActive);
		gridActive = !gridActive;
	}); */
	
	/* DROPPABLE GRIDBOX */
	/* $('.div-gridbox-wrapper').droppable({
		accept: '.div-gridbox-wrapper',
		over: function ()
		{
		  $(this).children('.div-gridbox').addClass('accepting');
		},
		out: function ()
		{
			$(this).children('.div-gridbox').removeClass('accepting');
		},
		drop: function ()
		{
			$(this).children('.div-gridbox').removeClass('accepting');
			var elems = gridPageContent.masonry('getItemElements');
			dump(elems);
			gridPageContent.masonry('remove', elems);
			//gridPageContent.masonry( 'addItems', elems );
			gridPageContent.prepend(elems).masonry('prepended', elems);
		}
	}); */
	
	/* DRAGGABLE GRIDBOX */
	/* $('.div-gridbox-wrapper').draggable({
		containment: 'parent',
		cancel: '.div-selection-checkbox, .div-gridbox-footer',
		revert: 'invalid',
		revertDuration: 200,
		zIndex: 6,
		opacity: 0.7,
		start: function ()
		{}
			
	}); */
	
	/* ISOTOPE INITIALISE */
	/* $('.div-page-content-grid').isotope({
		itemSelector: '.div-gridbox-wrapper', 
		percentPosition: true,
		masonry: {
			columnWidth: '.grid-sizer',
			horizontalOrder: true
		}
	}); */
	
	/* MASONRY OPTIONS FOR THE GRID */
	/* var pageContentMasonryOptions = { 
		// specify the child elements in the grid
		itemSelector: '.div-gridbox-wrapper', 
		// width of grid-sizer sets the max width of a column
		columnWidth: '.grid-sizer', 
		// item width in percent, instead of pixel values
		percentPosition: true, 
		// (mostly) maintain horizontal left-to-right order.
		horizontalOrder: true 
	};
	gridPageContent = $('.div-page-content-grid').masonry(pageContentMasonryOptions);
	gridPageContent.masonry(pageContentMasonryOptions); */
	
	/* function toggleGridFormat(gridActive)
	{
		if (gridActive) 
		{
			gridPageContent.masonry('destroy'); // destroy
			$('#icon-grid-cascade').css('display', 'inline-block');
			$('#icon-grid-rows').css('display', 'none');
		}
		else 
		{
			gridPageContent.masonry(pageContentMasonryOptions); // re-initialize
			$('#icon-grid-cascade').css('display', 'none');
			$('#icon-grid-rows').css('display', 'inline-block');
		}
	} */