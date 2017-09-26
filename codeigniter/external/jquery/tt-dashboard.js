$(document).ready(function()
{
	/* 
	VARIABLES
	*/
	
	// NAVBAR
	var $navBurgerMenu = $('.btn-navbar-menu');
	// TOOLBAR
	var defaultGridStatusText = '';
	var selectedGridboxCount = 0;
	var $toolbarSearch = $('#toolbar-search');
	var $toolDropdownToggle = $('.div-tool-dropdown-toggle');
	// SIDEBAR
	var $addResource = $('.a-sidebar-submenu');
	var $currentSidebarMenuLi = $('.a-sidebar-menu-li').eq(0);
	var $gridCounter = $('.ul-sidebar-questions-list');
	var $gridCounterLi = $('.li-sidebar-question');
	var $sidebarNavButton = $('.a-navbar-toggle-buttons');
	var $sidebarMenuLi = $('.a-sidebar-menu-li');
	var $searchCategory = $('.a-sidebar-search-category');
	var $searchCross = $('.img-clear-tt-sidebar-search');
	var $searchNavButton = $('#btn-sidebar-search');
	var searchValue = '';
	// PAGE CONTENT
	var $focusedGridbox = '';
	var $gridbox = $('.div-gridbox');
	var $gridboxSelectionCheckbox = $('.div-selection-checkbox');
	var $pageGrid;
	// POPUP
	var $popupBackground = $('.popup-background');
	var visiblePopups = [];
	
	/*
	EVENTS
	*/
	
	// NAVBAR
	$navBurgerMenu.click(toggleSidebar);
	// TOOLBAR
	$toolbarSearch.click(launchSidebarSearch);
	$toolDropdownToggle.click(toggleToolDropDown);
	// SIDEBAR
	initGridCounter();
	$gridCounterLi.click(gridboxFocus);
	$gridCounterLi.dblclick(selectGridbox);
	$gridCounterLi.mouseleave(gridboxUnfocus);
	$sidebarMenuLi.click(switchActiveSidebarMenu);
	$sidebarNavButton.click(switchActiveSidebarNav);
	$searchCross.click(selectClearSearchBar);
	$searchNavButton.click(selectClearSearchBar);
	$searchCategory.click(selectSearchCategory);
	// PAGE CONTENT
	initPageContentGrid();
	refreshPageGrid('bank');
	$tt(document).on('click', '.div-selection-checkbox', selectGridbox);
	$tt(document).on('click', '.div-gridbox', openGridboxSection);
	$tt(document).on('mouseenter', '.div-gridbox', displayGridIcons);
	$tt(document).on('mouseleave', '.div-gridbox', hideGridIcons);
	// POPUP
	$addResource.click(popupAddResource);
	$popupBackground.click(removePopup);

	/*
	INTERACTIONS
	*/
	
	function openGridboxSection()
	{
		return;
	}
	
	function initPageContentGrid()
	{
		$pageGrid = new Muuri('.div-page-content-grid',  
		{
			dragEnabled: false,
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
				var layout = { slots: {}, height: 0, setHeight: true }; 
				// container width is always perfectly divisible by item width (210px)
				var colCount = containerWidth / items[0]._width;
				var rowCount = 1 + parseInt(items.length / colCount);
				var slotDimensions = array2D(rowCount);
				var newSlot, topSlot, leftSlot, slotRow, slotCol;
				items.forEach(function(item, index)
				{
					newSlot = { left: 0, top: 0, height: item._height, width: item._width };
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
			var $pageGridItems = $pageGrid.getItems();
			var gridboxNumberClass;
			while (fromIndex < toIndex)
			{ // dragged down the order
				gridboxNumberClass = itemGridNumberElement($pageGridItems[fromIndex]);
				fromIndex++;
				gridboxNumberClass.html(fromIndex);
			}
			while (fromIndex > toIndex)
			{ // dragged up the order
				gridboxNumberClass = itemGridNumberElement($pageGridItems[fromIndex]);
				gridboxNumberClass.html(fromIndex+1);
				fromIndex--;
			}
			itemGridNumberElement(data.item).html(toIndex+1);
			$pageGrid.refreshSortData();
			$pageGrid.synchronize();
		});
	}
	
	function initGridCounter()
	{
		$gridCounter.sortable(
		{ 
			scroll: false,
			update: function(event, ui)
			{ // update indices after sort and DOM change
				var gridCounterNumbers = 
					$tt('.ul-sidebar-questions-list').sortable('toArray', {attribute: 'data-gc-id'});
				var movedGridCounterElement = ui.item;
				var gridCounterNumber = parseInt(movedGridCounterElement.html());
				var fromIndex = toIndex = gridCounterNumber - 1;
				var currentGridCounterElement, newGridCounterNumber;
				while (gridCounterNumber < gridCounterNumbers[toIndex])
				{ // item dragged down the order
					currentGridCounterElement = 
						$tt('.ul-sidebar-questions-list').children('.li-sidebar-question').eq(toIndex);
					newGridCounterNumber = parseInt(currentGridCounterElement.html()) - 1;
					currentGridCounterElement.html(newGridCounterNumber);
					currentGridCounterElement.attr('data-gc-id', newGridCounterNumber);
					toIndex++;
				}
				while (gridCounterNumber > gridCounterNumbers[toIndex])
				{ // item dragged up the order
					currentGridCounterElement = 
						$tt('.ul-sidebar-questions-list').children('.li-sidebar-question').eq(toIndex);
					newGridCounterNumber = parseInt(currentGridCounterElement.html()) + 1;
					currentGridCounterElement.html(newGridCounterNumber);
					currentGridCounterElement.attr('data-gc-id', newGridCounterNumber);
					toIndex--;
				}
				movedGridCounterElement.html(toIndex+1);
				movedGridCounterElement.attr('data-gc-id', toIndex+1);
				$pageGrid.move(fromIndex, toIndex);
				movedGridCounterElement.trigger("click");
			}
		});
	}
	
	function gridboxFocus()
	{ // scroll to highlighted gridbox
		var gridIndex = $(this).html() - 1;
		$focusedGridbox = $tt('.div-gridbox').eq(gridIndex);
		$focusedGridbox.addClass('outline-div-gridbox');
		var scrollOffset = $focusedGridbox.offset().top - 350;
		$tt('html, body').animate({scrollTop: scrollOffset}, 500);
	}
	
	function gridboxUnfocus()
	{
		if ($focusedGridbox != '') 
		{
			$focusedGridbox.removeClass('outline-div-gridbox');
			$focusedGridbox = '';
		}
	}
	
	function selectGridbox()
	{
		var $target = $(this);
		if ($(event.target).is($gridCounterLi))
		{
			$target = $focusedGridbox.children('.div-selection-checkbox');
			gridboxUnfocus();
		}
	  if ($target.hasClass('selected'))
		{ // update status text
			selectedGridboxCount--;
			if (selectedGridboxCount == 0) $tt('.text-grid-status').html(defaultGridStatusText);
			else $tt('.text-grid-status').html(selectedGridboxCount + ' Selected');
		}
		else 
		{ // update status text
			selectedGridboxCount++;
			if (selectedGridboxCount == 1) defaultGridStatusText = $tt('.text-grid-status').html();
			$tt('.text-grid-status').html(selectedGridboxCount + ' Selected');
		}
		$target.toggleClass('selected');
		$target.parents('.div-gridbox').toggleClass('selected');
		$target.siblings('.div-gridbox-footer').toggleClass('selected');
	}
	
	function popupAddResource()
	{
		var popups = [];
		popups.push($tt('.popup-background'));
		popups.push($tt('.div-add-resource'));
		popups.push($tt('.div-generic-popup-wrapper'));
		togglePopupAppear(popups);
		var elementID = $(this).attr('id');
		switch (elementID)
		{
			case 'sidebar-submenu-add-question':
				$tt('.h-resource-main').html('Add Question');
				break;
			case 'sidebar-submenu-add-chapter':
				$tt('.h-resource-main').html('Add Chapter');
				break;
			case 'sidebar-submenu-add-bank':
				$tt('.h-resource-main').html('Add Bank');
				break;
			case 'sidebar-submenu-add-course':
				$tt('.h-resource-main').html('Add Course');
				break;
			case 'sidebar-submenu-add-school':
				$tt('.h-resource-main').html('Add School');
		}
	}
	
	function removePopup(event) 
	{ 
		if (event.target == $popupBackground) togglePopupAppear();
	}
	
	function switchActiveSidebarMenu()
	{
		if (!$(this).hasClass('collapsible')) 
		{ // only activate if not a collapsible
			$tt('.a-sidebar-menu-li').removeClass('active');
			$(this).addClass('active');
			var liAttribute = $(this).attr('data-action');
			var alreadyActive = $(this).is($currentSidebarMenuLi);
			if (liAttribute == 'refresh-grid' && !alreadyActive)
			{
				var section = $(this).attr('data-title');
				refreshPageGrid(section);
				updateMainTopicHeading(section);
				$currentSidebarMenuLi = $(this);
			}
		}
	}
	
	function refreshPageGrid(section, itemId = '')
	{
		var gridItems = $pageGrid.getItems();
		$pageGrid.remove(gridItems, {removeElements: true, layout: false});
		
		var ajaxUrlSegments = 'dashboard/ajax_get_grid/' + section + '/' + itemId;
		var gridPost = $.post(callController(ajaxUrlSegments));
		
		gridPost.done(function(data) 
		{ 
			var gridData = JSON.parse(data);
			gridItems = getGridItems(gridData);
			$pageGrid.add(gridItems);
		});
	}
	
	function getGridItems(gridData)
	{
		var gridItems = [];
		
		gridData.forEach(function(content)
		{
			element = document.createElement('div');
			element.innerHTML = content;
			gridItems.push(element.firstChild);
		});
		
		return gridItems;
	}
	
	function switchActiveSidebarNav()
	{
		$tt('.a-navbar-toggle-buttons').removeClass('active');
		$(this).addClass('active');
	}
	
	function selectSearchCategory()
	{
		$tt('.a-sidebar-search-category').removeClass('checked');
		$tt('.div-tt-search-category-checkbox').removeClass('checked');
		$(this).addClass('checked');
		$(this).children('.div-tt-search-category-checkbox').addClass('checked');
		// update search bar placeholder
		var category = $(this).children('.text-tt-search-category').html();
		var newPlaceholder = category;
		selectClearSearchBar();
		updateSearchBarPlaceholder(newPlaceholder);
	}
	
	function launchSidebarSearch()
	{
		if ($tt('.div-sidebar-scroll').hasClass('sidebar-close')) toggleSidebar();
		$tt('.div-sidebar-content').children().css('display', 'none');
		$tt('.div-sidebar-navbar').children().removeClass('active');
		$tt('#btn-sidebar-search').addClass('active');		
		$tt('.div-sidebar-search').css('display', 'block');
		// select to search 'current section' category
		$tt('.a-sidebar-search-category').removeClass('checked');
		$tt('.div-tt-search-category-checkbox').removeClass('checked');
		$tt('#current-section-search-category').addClass('checked');
		$tt('#current-section-search-category').
			children('.div-tt-search-category-checkbox').addClass('checked');
		$tt('.text-field-tt-search').select();
		updateSearchBarPlaceholder('Current Section');
	}
	
	function toggleToolDropDown()
	{
		var dataToolToggle = $(this).attr('data-tool-toggle');
		if (dataToolToggle == "1") $(this).toggleClass('pressed');
	}
	
	function displayGridIcons()
	{
		$(this).find('.div-gridbox-footer-buttons').fadeTo(200, 1);
		$(this).find('.div-selection-checkbox').fadeTo(200, 1);
	}
	
	function hideGridIcons()
	{
		if (!$(this).hasClass('selected'))
		{ // only fadeout if grid-box hasn't been selected
			$(this).find('.div-gridbox-footer-buttons').fadeTo(200, 0);
			$(this).find('.div-selection-checkbox').fadeTo(200, 0);
		}
	}
	
	function selectClearSearchBar()
	{
		$tt('.text-field-tt-search').val('');
		$tt('.text-field-tt-search').select();
	}

	function updateSearchBarPlaceholder(text)
	{
		$tt('.text-field-tt-search').attr('placeholder', text);
	}

	function updateMainTopicHeading(text)
	{
	  $tt('.h-main-topic-heading').html(text);
	}
	
	function updateSubTopicHeading(text)
	{
	  $tt('.h-sub-topic-heading').html(text);
	}
	
	function toggleSidebar()
	{
		$tt('.div-sidebar-scroll').toggleClass('sidebar-close');
		$tt('.div-page-content-wrapper').toggleClass('stretch');
	}

	function togglePopupAppear(popupArray)
	{
		visiblePopups = popupArray;
		visiblePopups.forEach(function(popup) { popup.toggleClass('appear') });
		if (visiblePopups.length > 0) visiblePopups = [];
	}

	function filter()
	{
		//filterFieldValue = filterField.value;
		grid.filter(function(item) 
		{
			var element = item.getElement();
			var isSearchMatch = !searchValue ? true : (element.getAttribute('data-title') || '').toLowerCase().indexOf(searchFieldValue) > -1;
			var isFilterMatch = !filterFieldValue ? true : (element.getAttribute('data-color') || '') === filterFieldValue;
			return isSearchMatch && isFilterMatch;
		});
	}

	/* 
	HELPERS
	*/
	
	function $tt(query)
	{ // cache the jquery queries
		this.cache = this.cache || {};
		if (!this.cache[query]) this.cache[query] = $(query);
		return this.cache[query];
	}
	
	function callController(segments)
	{
		return siteUrl+'/'+segments;
	}
	
	function loadAsset(segments)
	{
		return baseUrl+segments;
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
			if (searchValue !== newSearch)
			{
				searchValue = newSearch;
				console.log(searchValue);
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
			$pageGrid._settings.layout.horizontal = true;
			$pageGrid.layout();
			$('#icon-grid-cascade').css('display', 'inline-block');
			$('#icon-grid-rows').css('display', 'none');
		}
		else 
		{
			$pageGrid._settings.layout.horizontal = false;
			$pageGrid.layout();
			$('#icon-grid-cascade').css('display', 'none');
			$('#icon-grid-rows').css('display', 'inline-block');
		}
		gridMasonryActive = !gridMasonryActive;
	}); */