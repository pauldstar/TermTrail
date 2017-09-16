$(document).ready(function()
{
	var gridPageContent;
	var gridBox2Highlight = '';
	var defaultGridStatusText = '';
	var selectedGridboxCount = 0;
	var ttSearchValue = '';
	var visiblePopups = [];
	var 
	log(
	
	/* ----------------------------------------------------------------------------------------------
	 * INTERACTIONS
	 * ------------------------------------------------------------------------------------------- */
	 
	/* ADD RESOURCE POP-UP */
	$('.a-sidebar-submenu').click(function(event)
	{
		visiblePopups.push($('.popup-background'));
		visiblePopups.push($('.div-add-resource'));
		visiblePopups.push($('.div-generic-popup-wrapper'));
		togglePopupAppear();
		log(visiblePopups);
		var elementID = $(this).attr('id');
		switch (elementID)
		{
			case 'sidebar-submenu-add-question':
				$('.h-resource-main').html('Add Question');
				break;
			case 'sidebar-submenu-add-chapter':
				$('.h-resource-main').html('Add Chapter');
				break;
			case 'sidebar-submenu-add-bank':
				$('.h-resource-main').html('Add Bank');
				break;
			case 'sidebar-submenu-add-course':
				$('.h-resource-main').html('Add Course');
				break;
			case 'sidebar-submenu-add-school':
				$('.h-resource-main').html('Add School');
		}
	});
	$('.popup-background').click(function(event)
	{
		if (event.target == this) 
		{
			togglePopupAppear();
			visiblePopups = [];
		}
		log(visiblePopups);
	});
	
	/* MUURI GRID */
	gridPageContent = new Muuri('.div-page-content-grid',  
	{
		dragEnabled: true,
		items: '.div-gridbox-wrapper',
		sortData: 
		{
			gridboxNumber: function(item, element) 
			{
				var gridboxNumber = itemGridNumberElement(item).html();
				return parseInt(gridboxNumber);
			}
		},
		layout: function(items, containerWidth, containerHeight) 
		{ // custom strict horizontal left-to-right order
			if (!items.length) return layout;
			var layout = {
				slots: {},
				height: 0,
				setHeight: true
			}; // container width is always perfectly divisible by item width (210px)
			var colCount = containerWidth / items[0]._width;
			var rowCount = 1 + parseInt(items.length / colCount);
			var slotDimensions = array2D(rowCount);
			var newSlot, topSlot, leftSlot, slotRow, slotCol;
			items.forEach(function(item, index)
			{
				newSlot = {
					left: 0, 
					top: 0, 
					height: item._height, 
					width: item._width
				};
				slotCol = index % colCount;
				slotRow = parseInt(index / colCount);
				if (topRowExists(slotRow))
				{ // add slot to row below
					topSlot = slotDimensions[slotRow-1][slotCol];
					newSlot.top = topSlot.top + topSlot.height;
				}
				if (leftColExists(slotCol))
				{ // add slot to rightward col
					leftSlot = slotDimensions[slotRow][slotCol-1];
					newSlot.left = leftSlot.left + leftSlot.width;
				}
				slotDimensions[slotRow][slotCol] = newSlot;
				layout.slots[item._id] = newSlot;
				layout.height = Math.max(layout.height, newSlot.top + newSlot.height);
			});
			return layout;
		}
	})
	.on('move', function(data)
	{ // update indices after item move
		var fromIndex = data.fromIndex;
		var toIndex = data.toIndex;
		var gridPageContentItems = gridPageContent.getItems();
		var gridboxNumberClass;
		while (fromIndex < toIndex)
		{ // dragged down the order
			gridboxNumberClass = itemGridNumberElement(gridPageContentItems[fromIndex]);
			fromIndex++;
			gridboxNumberClass.html(fromIndex);
		}
		while (fromIndex > toIndex)
		{ // dragged up the order
			gridboxNumberClass = itemGridNumberElement(gridPageContentItems[fromIndex]);
			gridboxNumberClass.html(fromIndex+1);
			fromIndex--;
		}
		itemGridNumberElement(data.item).html(toIndex+1);
		gridPageContent.refreshSortData();
		gridPageContent.synchronize();
	});
	
	/* GRID COUNTER SORTABLE */
	$('.ul-sidebar-questions-list').sortable(
	{ 
		scroll: false,
		update: function(event, ui)
		{ // update indices after sort and DOM change
			var gridCounterNumbers = 
				$('.ul-sidebar-questions-list').sortable('toArray', {attribute: 'data-gc-id'});
			var movedGridCounterElement = ui.item;
			var gridCounterNumber = parseInt(movedGridCounterElement.html());
			var fromIndex = toIndex = gridCounterNumber - 1;
			var currentGridCounterElement, newGridCounterNumber;
			while (gridCounterNumber < gridCounterNumbers[toIndex])
			{ // item dragged down the order
				currentGridCounterElement = 
					$('.ul-sidebar-questions-list').children('.li-sidebar-question').eq(toIndex);
				newGridCounterNumber = parseInt(currentGridCounterElement.html()) - 1;
				currentGridCounterElement.html(newGridCounterNumber);
				currentGridCounterElement.attr('data-gc-id', newGridCounterNumber);
				toIndex++;
			}
			while (gridCounterNumber > gridCounterNumbers[toIndex])
			{ // item dragged up the order
				currentGridCounterElement = 
					$('.ul-sidebar-questions-list').children('.li-sidebar-question').eq(toIndex);
				newGridCounterNumber = parseInt(currentGridCounterElement.html()) + 1;
				currentGridCounterElement.html(newGridCounterNumber);
				currentGridCounterElement.attr('data-gc-id', newGridCounterNumber);
				toIndex--;
			}
			movedGridCounterElement.html(toIndex+1);
			movedGridCounterElement.attr('data-gc-id', toIndex+1);
			gridPageContent.move(fromIndex, toIndex);
			movedGridCounterElement.trigger("click");
		}
	});
	
	/* HIGHLIGHT GRIDBOX WHEN CLICKING GRID COUNTER */
	$('.li-sidebar-question').on('click mouseleave dblclick', function(event)
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
				break;
			case 'dblclick':
				gridBox2Highlight.children('.div-selection-checkbox').trigger('click');
				$(this).trigger('mouseleave');
		}
	});
	
	/* SIDEBAR MENU ITEM ACTIVATE */
	$('.a-sidebar-menu-li').click(function(event)
	{
		if (!$(this).hasClass('collapsible')) 
		{ // only activate if not a collapsible
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
	$('.btn-navbar-menu').click(toggleSidebar);
	
	/* CLEAR TT SEARCHBAR WITH SEARCH BAR 'X' */
	$('.img-clear-tt-sidebar-search').click(clearSearchBar);
	
	/* TRIGGER TT SEARCH BAR FROM SIDEBAR NAV */
	$('#btn-sidebar-search').click(clearSearchBar);
	
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
	
	/* TRIGGER TT SEARCH BAR FROM TOOLBAR */
	$('#toolbar-search').click(function(event)
	{
		if ($('.div-sidebar-scroll').hasClass('sidebar-close')) toggleSidebar();
		$('.div-sidebar-content').children().css('display', 'none');
		$('.div-sidebar-navbar').children().removeClass('active');
		$('#btn-sidebar-search').addClass('active');		
		$('.div-sidebar-search').css('display', 'block');
		// select to search 'current section' category
		$('.a-sidebar-search-category').removeClass('checked');
		$('.div-tt-search-category-checkbox').removeClass('checked');
		$('#current-section-search-category').addClass('checked');
		$('#current-section-search-category').children('.div-tt-search-category-checkbox').addClass('checked');
		$('.text-field-tt-search').select();
		updateSearchBarPlaceholder('Current Section');
	});
	
	/* TOGGLE TOOLBAR BUTTONS WITH 'DATA-TOOL-TOGGLE' ATTRIBUTES */
	$('.div-tool-dropdown-toggle').click(function(event)
	{
		var dataToolToggle = $(this).attr('data-tool-toggle');
		if (dataToolToggle == "1") $(this).toggleClass('pressed');
	});
	
	/* TOGGLE GRID ICONS OPACITY */
	$('.div-gridbox').on('mouseenter mouseleave', function(event)
	{
		switch (event.type)
		{
			case 'mouseenter':
				$(this).find('.div-gridbox-footer-buttons').fadeTo(200, 1);
				$(this).find('.div-selection-checkbox').fadeTo(200, 1);
				break;
			case 'mouseleave':
				if (!$(this).hasClass('selected'))
				{ // only fadeout if grid-box hasn't been selected
					$(this).find('.div-gridbox-footer-buttons').fadeTo(200, 0);
					$(this).find('.div-selection-checkbox').fadeTo(200, 0);
				}
		}
	});
	
	/* SELECT GRID/CHAPTER BOX AND UPDATE STATUS TEXT */
	$('.div-selection-checkbox').click(function(event)
	{
		if ($(this).hasClass('selected')) 
		{
			selectedGridboxCount--;
			if (selectedGridboxCount == 0) $('.text-grid-status').html(defaultGridStatusText);
			else $('.text-grid-status').html(selectedGridboxCount + ' Selected');
		} 
		else 
		{
		  selectedGridboxCount++;
			if (selectedGridboxCount == 1) defaultGridStatusText = $('.text-grid-status').html();
			$('.text-grid-status').html(selectedGridboxCount + ' Selected');
		}
		$(this).toggleClass('selected');
		$(this).parent().toggleClass('selected');
		$(this).siblings('.div-gridbox-footer').toggleClass('selected');
	});

	/* ----------------------------------------------------------------------------------------------
	 * FUNCTIONS (PRODUCTION) FOR INTERACTIONS
	 * ------------------------------------------------------------------------------------------- */
	 
	function filter()
	{
		//filterFieldValue = filterField.value;
		grid.filter(function(item) 
		{
			var element = item.getElement();
			var isSearchMatch = !ttSearchValue ? true : (element.getAttribute('data-title') || '').toLowerCase().indexOf(searchFieldValue) > -1;
			var isFilterMatch = !filterFieldValue ? true : (element.getAttribute('data-color') || '') === filterFieldValue;
			return isSearchMatch && isFilterMatch;
		});
	}

	function leftColExists(slotCol)
	{
		if (slotCol-1 == -1) return false;
		return true;
	}

	function topRowExists(slotRow)
	{
		if (slotRow-1 == -1) return false;
		return true;
	}

	function array2D(rows)
	{
		var array = [];
		for (var i = 0; i < rows; i++) array[i] = [];
		return array;
	}

	function itemGridNumberElement(item)
	{
		return $(item.getElement()).find('.text-gridbox-numbering');
	}

	function clearSearchBar()
	{
		$('.text-field-tt-search').val('');
		$('.text-field-tt-search').select();
	}

	function updateSearchBarPlaceholder(text)
	{
		$('.text-field-tt-search').attr('placeholder', text);
	}

	function toggleSidebar()
	{
		$('.div-sidebar-scroll').toggleClass('sidebar-close');
		$('.div-page-content-wrapper').toggleClass('stretch');
	}

	function togglePopupAppear()
	{
		visiblePopups.forEach(function(popup) 
		{
			popup.toggleClass('appear');
		});
	}

	/* ----------------------------------------------------------------------------------------------
	 * FUNCTIONS (DEVELOPMENT) FOR INTERACTIONS
	 * ------------------------------------------------------------------------------------------- */

	function log(out) 
	{
		console.log(out);
	}
});
/* TT SEARCH INPUT */
	/* $('.text-field-tt-search').keypress(function(event)
	{
		if (event.which == 13) 
		{ // pressed ENTER key
			event.preventDefault();
			var newSearch = $(this).val();
			if (ttSearchValue !== newSearch)
			{
				ttSearchValue = newSearch;
				console.log(ttSearchValue);
				filter();
			}
		}
	}); */
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
	
	/* GRID FORMAT TOGGLE */
	/* $('#toolbar-grid-format').click(function(event)
	{
		if (gridMasonryActive) 
		{
			gridPageContent._settings.layout.horizontal = true;
			gridPageContent.layout();
			$('#icon-grid-cascade').css('display', 'inline-block');
			$('#icon-grid-rows').css('display', 'none');
		}
		else 
		{
			gridPageContent._settings.layout.horizontal = false;
			gridPageContent.layout();
			$('#icon-grid-cascade').css('display', 'none');
			$('#icon-grid-rows').css('display', 'inline-block');
		}
		gridMasonryActive = !gridMasonryActive;
	}); */