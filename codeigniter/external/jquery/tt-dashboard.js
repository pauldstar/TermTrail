function $tt(query)
{ // cache the jquery queries
	this.cache = this.cache || {};
	if ( ! this.cache[query]) this.cache[query] = $(query);
	return this.cache[query];
}

function log(out) 
{
	console.log(out);
}

$tt(document).ready(function()
{
	NAVBAR.$navBurgerMenu.click(SIDEBAR.toggleSidebar);
	NAVBAR.$subTopicHeading.click(PAGE_CONTENT.openPreviousSection);

	TOOLBAR.$toolbarSearch.click(SIDEBAR.launchSidebarSearch);
	TOOLBAR.$toolDropdownToggle.click(TOOLBAR.toggleToolDropDown);

	SIDEBAR.$addResourceLi.click(POPUP.popupAddResource);
	SIDEBAR.initGridCounter();
	SIDEBAR.$gridCounterLi.click(PAGE_CONTENT.gridboxFocus);
	SIDEBAR.$gridCounterLi.dblclick(PAGE_CONTENT.selectGridbox);
	SIDEBAR.$gridCounterLi.mouseleave(PAGE_CONTENT.gridboxUnfocus);
	SIDEBAR.$sidebarMenuLi.click(SIDEBAR.switchActiveSidebarMenu);
	SIDEBAR.$sidebarNavButton.click(SIDEBAR.switchActiveSidebarNav);
	SIDEBAR.$searchCross.click(SIDEBAR.selectClearSearchBar);
	SIDEBAR.$searchNavButton.click(SIDEBAR.selectClearSearchBar);
	SIDEBAR.$searchCategory.click(SIDEBAR.selectSearchCategory);

	PAGE_CONTENT.initPageContentGrid();
	PAGE_CONTENT.refreshPageGrid('bank');
	$tt(document).on('click', '.div-gridbox', PAGE_CONTENT.openGridboxSection);
	$tt(document).on('click', '.div-selection-checkbox', PAGE_CONTENT.selectGridbox);
	$tt(document).on('mouseenter', '.div-gridbox', PAGE_CONTENT.displayGridIcons);
	$tt(document).on('mouseleave', '.div-gridbox', PAGE_CONTENT.hideGridIcons);
	
	POPUP.$popupBackground.click(POPUP.removePopup);
});

/* 
NAVBAR
*/

var NAVBAR =
{
	$navBurgerMenu: $('.btn-navbar-menu'),
	$subTopicHeading: $('.h-sub-topic-heading'),
	
	updateMainTopicHeading: function(text)
	{
	  $tt('.h-main-topic-heading').html(text);
	},
	
	updateSubTopicHeading: function(text)
	{
	  $tt('.h-sub-topic-heading').html(text);
	}
}

/* 
TOOLBAR
*/

var TOOLBAR = 
{
	defaultGridStatusText:  '',
	selectedGridboxCount:  0,
	$toolbarSearch:  $('#toolbar-search'),
	$toolDropdownToggle:  $('.div-tool-dropdown-toggle'),
	
	toggleToolDropDown: function()
	{
		var dataToolToggle = $(this).attr('data-tool-toggle');
		if (dataToolToggle === "1") $(this).toggleClass('pressed');
	}
}

/* 
SIDEBAR
*/

var SIDEBAR =
{
	$addResourceLi:  $('.a-sidebar-submenu'),
	$activeSidebarMenuLi:  $('.a-sidebar-menu-li').eq(0),
	$gridCounter:  $('.ul-sidebar-questions-list'),
	$gridCounterLi:  $('.li-sidebar-question'),
	$sidebarNavButton:  $('.a-navbar-toggle-buttons'),
	$sidebarMenuLi:  $('.a-sidebar-menu-li'),
	$searchCategory:  $('.a-sidebar-search-category'),
	$searchCross:  $('.img-clear-tt-sidebar-search'),
	$searchNavButton:  $('#btn-sidebar-search'),
	searchValue:  '',
	
	initGridCounter: function()
	{
		SIDEBAR.$gridCounter.sortable(
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
				PAGE_CONTENT.$pageGrid.move(fromIndex, toIndex);
				movedGridCounterElement.trigger("click");
			}
		});
	},
	
	launchSidebarSearch: function()
	{
		if ($tt('.div-sidebar-scroll').hasClass('sidebar-close')) SIDEBAR.toggleSidebar();
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
		SIDEBAR.updateSearchBarPlaceholder('Current Section');
	},
	
	selectClearSearchBar: function()
	{
		$tt('.text-field-tt-search').val('');
		$tt('.text-field-tt-search').select();
	},
	
	selectSearchCategory: function()
	{
		$tt('.a-sidebar-search-category').removeClass('checked');
		$tt('.div-tt-search-category-checkbox').removeClass('checked');
		$(this).addClass('checked');
		$(this).children('.div-tt-search-category-checkbox').addClass('checked');
		// update search bar placeholder
		var category = $(this).children('.text-tt-search-category').html();
		var newPlaceholder = category;
		SIDEBAR.selectClearSearchBar();
		SIDEBAR.updateSearchBarPlaceholder(newPlaceholder);
	},
	
	switchActiveSidebarMenu: function()
	{
		if ( ! $(this).hasClass('collapsible'))
		{
			$tt('.a-sidebar-menu-li').removeClass('active');
			
			$(this).addClass('active');
			var liAttribute = $(this).attr('data-action');
			var alreadyActive = $(this).is(SIDEBAR.$activeSidebarMenuLi);
			
			if (liAttribute === 'refresh-grid' && !alreadyActive)
			{
				var section = $(this).attr('data-title');
				PAGE_CONTENT.refreshPageGrid(section);
				NAVBAR.updateMainTopicHeading(section+'s');
				NAVBAR.updateSubTopicHeading('');
				SIDEBAR.$activeSidebarMenuLi = $(this);
			}
		}
	},
	
	switchActiveSidebarNav: function()
	{
		$tt('.a-navbar-toggle-buttons').removeClass('active');
		$(this).addClass('active');
	},
	
	toggleSidebar: function()
	{
		$tt('.div-sidebar-scroll').toggleClass('sidebar-close');
		$tt('.div-page-content-wrapper').toggleClass('stretch');
	},
	
	updateSearchBarPlaceholder: function(text)
	{
		$tt('.text-field-tt-search').attr('placeholder', text);
	}
}

/* 
PAGE CONTENT
*/

var PAGE_CONTENT =
{
	currentPageGridParentID: '',
	$focusedGridbox: '',
	$pageGrid: '',
	previousGridSectionData: [],
	
	displayGridIcons: function()
	{
		$(this).find('.div-gridbox-footer-buttons').fadeTo(200, 1);
		$(this).find('.div-selection-checkbox').fadeTo(200, 1);
	},
	
	filter: function()
	{
		//filterFieldValue = filterField.value;
		grid.filter(function(item) 
		{
			var element = item.getElement();
			var isSearchMatch = !SIDEBAR.searchValue ? true : (element.getAttribute('data-title') || '').toLowerCase().indexOf(searchFieldValue) > -1;
			var isFilterMatch = !filterFieldValue ? true : (element.getAttribute('data-color') || '') === filterFieldValue;
			return isSearchMatch && isFilterMatch;
		});
	},
		
	getGridboxTitle: function($gridbox)
	{
		return $gridbox.children('.div-gridbox-header').children('.h-gridbox-title').html();
	},
		
	getGridboxNumberElement: function(item)
	{
		return $(item.getElement()).find('.text-gridbox-numbering');
	},
	
	getGridItems: function(gridData)
	{
		var gridItems = [];
		
		gridData.forEach(function(content)
		{
			element = document.createElement('div');
			element.innerHTML = content;
			gridItems.push(element.firstChild);
		});
		
		return gridItems;
	},
	
	gridboxFocus: function()
	{ // scroll to highlighted gridbox
		var gridIndex = $(this).html() - 1;
		PAGE_CONTENT.$focusedGridbox = $tt('.div-gridbox').eq(gridIndex);
		PAGE_CONTENT.$focusedGridbox.addClass('outline-div-gridbox');
		var scrollOffset = PAGE_CONTENT.$focusedGridbox.offset().top - 350;
		$tt('html, body').animate({scrollTop: scrollOffset}, 500);
	},
	
	gridboxUnfocus: function()
	{
		if (PAGE_CONTENT.$focusedGridbox != '') 
		{
			PAGE_CONTENT.$focusedGridbox.removeClass('outline-div-gridbox');
			PAGE_CONTENT.$focusedGridbox = '';
		}
	},
	
	hideGridIcons: function()
	{
		if ( ! $(this).hasClass('selected'))
		{ // only fadeout if grid-box hasn't been selected
			$(this).find('.div-gridbox-footer-buttons').fadeTo(200, 0);
			$(this).find('.div-selection-checkbox').fadeTo(200, 0);
		}
	},
	
	initPageContentGrid: function()
	{
		PAGE_CONTENT.$pageGrid = new Muuri('.div-page-content-grid',  
		{
			dragEnabled: false,
			items: '.div-gridbox-wrapper',
			sortData: 
			{
				gridboxNumber: function(item, element) 
				{
					var gridboxNumber = PAGE_CONTENT.getGridboxNumberElement(item).html();
					return parseInt(gridboxNumber);
				}
			},
			layout: function(items, containerWidth, containerHeight) 
			{ // custom strict horizontal left-to-right order
				if ( ! items.length) return layout;
				var layout = { slots: {}, height: 0, setHeight: true }; 
				// container width is always perfectly divisible by item width (210px)
				var colCount = containerWidth / items[0]._width;
				var rowCount = 1 + parseInt(items.length / colCount);
				var slotDimensions = HELPER.array2D(rowCount);
				var newSlot, topSlot, leftSlot, slotRow, slotCol;
				items.forEach(function(item, index)
				{
					newSlot = { left: 0, top: 0, height: item._height, width: item._width };
					slotCol = index % colCount;
					slotRow = parseInt(index / colCount);
					if (PAGE_CONTENT.topRowExists(slotRow))
					{ // add slot to row below
						topSlot = slotDimensions[slotRow-1][slotCol];
						newSlot.top = topSlot.top + topSlot.height;
					}
					if (PAGE_CONTENT.leftColExists(slotCol))
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
			var $pageGridItems = PAGE_CONTENT.$pageGrid.getItems();
			var gridboxNumberClass;
			while (fromIndex < toIndex)
			{ // dragged down the order
				gridboxNumberClass = PAGE_CONTENT.getGridboxNumberElement($pageGridItems[fromIndex]);
				fromIndex++;
				gridboxNumberClass.html(fromIndex);
			}
			while (fromIndex > toIndex)
			{ // dragged up the order
				gridboxNumberClass = PAGE_CONTENT.getGridboxNumberElement($pageGridItems[fromIndex]);
				gridboxNumberClass.html(fromIndex+1);
				fromIndex--;
			}
			PAGE_CONTENT.getGridboxNumberElement(data.item).html(toIndex+1);
			PAGE_CONTENT.$pageGrid.refreshSortData();
			PAGE_CONTENT.$pageGrid.synchronize();
		});
	},
	
	leftColExists: function(slotCol)
	{
		if (slotCol-1 === -1) return false;
		return true;
	},
	
	openGridboxSection: function()
	{
		SIDEBAR.$activeSidebarMenuLi.removeClass('active');
		
		var fullItemIdJson = $(this).data('full-id-json');
		var section = $(this).data('child-section');
		PAGE_CONTENT.refreshPageGrid(section, fullItemIdJson);
		
		var gridboxTitle = PAGE_CONTENT.getGridboxTitle($(this));
		NAVBAR.updateMainTopicHeading(section+'s');
		NAVBAR.updateSubTopicHeading(gridboxTitle);

		PAGE_CONTENT.savePreviousGridSectionData(section);
	},
	
	openPreviousSection: function()
	{
		var data = PAGE_CONTENT.previousGridSectionData.pop();
		
		return;
	},
	
	savePreviousGridSectionData: function(gridSection)
	{
		var fullParentId = 
			PAGE_CONTENT.currentPageGridParentID === '' ? '' : PAGE_CONTENT.currentPageGridParentID;
		var data = {section: gridSection, fullParentId: fullParentId};
		PAGE_CONTENT.previousGridSectionData.push(data);
	},
	
	refreshPageGrid: function(section, fullItemIdJson = '')
	{
		var gridItems = PAGE_CONTENT.$pageGrid.getItems();
		PAGE_CONTENT.$pageGrid.remove(gridItems, {removeElements: true, layout: false});
		var ajaxUrlSegments = 'dashboard/ajax_get_grid/' + section;
		var gridPost = $.post(HELPER.callController(ajaxUrlSegments), 
		{
			full_item_id_json: JSON.stringify(fullItemIdJson)
		});
		
		gridPost.done(function(data) 
		{ 
			var gridData = JSON.parse(data);
			gridItems = PAGE_CONTENT.getGridItems(gridData);
			PAGE_CONTENT.$pageGrid.add(gridItems);
		});
	},
	
	selectGridbox: function()
	{
		var $target = $(this);
		if ($(event.target).is($SIDEBAR.gridCounterLi))
		{
			$target = PAGE_CONTENT.$focusedGridbox.children('.div-selection-checkbox');
			PAGE_CONTENT.gridboxUnfocus();
		}
	  if ($target.hasClass('selected'))
		{ // update status text
			TOOLBAR.selectedGridboxCount--;
			if (TOOLBAR.selectedGridboxCount === 0) 
				$tt('.text-grid-status').html(TOOLBAR.defaultGridStatusText);
			else $tt('.text-grid-status').html(TOOLBAR.selectedGridboxCount + ' Selected');
		}
		else 
		{ // update status text
			TOOLBAR.selectedGridboxCount++;
			if (TOOLBAR.selectedGridboxCount === 1) 
				TOOLBAR.defaultGridStatusText = $tt('.text-grid-status').html();
			$tt('.text-grid-status').html(TOOLBAR.selectedGridboxCount + ' Selected');
		}
		$target.toggleClass('selected');
		$target.parents('.div-gridbox').toggleClass('selected');
		$target.siblings('.div-gridbox-footer').toggleClass('selected');
	},
	
	topRowExists: function(slotRow)
	{
		if (slotRow-1 === -1) return false;
		return true;
	}
}

/* 
POPUP
*/

var POPUP = 
{
	$popupBackground: $('.popup-background'),
	visiblePopups: [],
	
	popupAddResource: function()
	{
		var popups = [];
		popups.push($tt('.popup-background'));
		popups.push($tt('.div-add-resource'));
		popups.push($tt('.div-generic-popup-wrapper'));
		POPUP.togglePopupAppear(popups);
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
	},
	
	removePopup: function(event) 
	{ 
		if (event.target === POPUP.$popupBackground) POPUP.togglePopupAppear();
	},
	
	togglePopupAppear: function(popupArray)
	{
		POPUP.visiblePopups = popupArray;
		POPUP.visiblePopups.forEach(function(popup) { popup.toggleClass('appear') });
		if (POPUP.visiblePopups.length > 0) POPUP.visiblePopups = [];
	}
}

/* 
HELPER
*/

var HELPER = 
{
	array2D: function(rows)
	{
		var array = [];
		for (var i = 0; i < rows; i++) array[i] = [];
		return array;
	},

	callController: function(segments)
	{
		return siteUrl+'/'+segments;
	},
	
	loadAsset: function(segments)
	{
		return baseUrl+segments;
	}
}

/* TT SEARCH INPUT */
	/* $('.text-field-tt-search').keypress(function(event)
	{
		if (event.which === 13) 
		{ // pressed ENTER key
			event.preventDefault();
			var newSearch = $(this).val();
			if (SIDEBAR.searchValue !=== newSearch)
			{
				SIDEBAR.searchValue = newSearch;
				console.log(SIDEBAR.searchValue);
				filter();
			}
		}
	}); */