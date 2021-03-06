/*
 - use jquery filters e.g. 'div:not(.box)' rather than if statements.
 - set event listeners as shown in the 'document ready' section.
 - Unless creating a new module is necessary, encapsulate all variables and 
		functions inside the currently provided modules.
 - prefix jQuery object variables with '$' e.g. $sidebarMenuDiv.
 - arrange functions, event delegations, and variables in alphabetical order.
 - cache jqueries by either storing in a variable (prefixed with '$'), or 
		calling via the $jqCache function; which reuses previously called jQueries.
 - make dependencies between functions explicit by: encapsulating in a function;
		function parameters; callbacks; throwing errors; using global variables 
		(last resort as it can be easy to neglect updating them).
*/

log = output => console.log(output);

function $jqCache(query)
{ // cache the jqueries
	this.cache = this.cache || {};
	if ( ! this.cache[query]) this.cache[query] = $(query);
	return this.cache[query];
}

$jqCache(document).ready(function()
{
	switch (pageTitle)
	{
		case 'dashboard':
			// NAVBAR
			NAVBAR.$navBurgerMenu.click(SIDEBAR.toggleSidebar);
			NAVBAR.$subTopicHeading.click(PAGE_CONTENT.reloadPreviousPageGrid);
			
			// TOOL-BAR
			TOOLBAR.$toolbarSearch.click(SIDEBAR.launchSidebarSearch);
			TOOLBAR.$toolDropdownToggle.click(TOOLBAR.toggleToolDropDown);
			
			// SIDEBAR
			$(document).on('click', '.a-sidebar-navbar-tab:not(.disabled)', 
				SIDEBAR.switchActiveSidebarNavTab);
			$(document).on('click', '.li-grid-tracker-item', 
				PAGE_CONTENT.gridboxFocus);
			$(document).on('dblclick', '.li-grid-tracker-item', 
				PAGE_CONTENT.toggleGridboxSelect);
			$(document).on('mouseleave', '.li-grid-tracker-item', 
				PAGE_CONTENT.gridboxUnfocus);
			SIDEBAR.$addResourceLi.click(POPUP.popupAddResource);
			SIDEBAR.$collapsibleSidebarMenuLi.click(SIDEBAR.toggleSidebarSubmenu);
			SIDEBAR.$clearSearchButton.click(SIDEBAR.resetSearchBarActivity);
			SIDEBAR.initGridTracker();
			SIDEBAR.$nonCollapsibleSidebarMenuLi.click(
				SIDEBAR.switchActiveSidebarMenu);
			SIDEBAR.$searchCategory.click(SIDEBAR.selectSearchCategory);
			SIDEBAR.$searchCategoryCollapsibleAnchor.click(
				SIDEBAR.switchExpandedSearchCategorySubmenu);
			SIDEBAR.$searchNavButton.click(SIDEBAR.resetSearchBarActivity);
			SIDEBAR.$searchField.keyup(PAGE_CONTENT.searchGrid);
			SIDEBAR.$searchForm.submit(HELPER.preventDefault);
			
			// PAGE_CONTENT
			$(document).on('click', 'body', PAGE_CONTENT.clearGridboxSelections);
			$(document).on('click', '.div-gridbox', PAGE_CONTENT.openGridbox);
			$(document).on('click', '.div-selection-checkbox', 
				PAGE_CONTENT.toggleGridboxSelect);
			$(document).on('mouseenter', '.div-gridbox', HELPER.displayIcons);
			$(document).on('mouseleave', '.div-gridbox:not(.selected)', 
				HELPER.hideIcons);
			PAGE_CONTENT.initPageContentGrid();
			PAGE_CONTENT.loadNewPageGrid('bank', 'local', 'Banks');
			
			// POP-UP
			$(document).on('click', '.a-question-popup-tab:not(.w--current)', 
				POPUP.switchActiveQuestionPopupTab);
			$(document).on('click', '.div-answer-wrapper *:not(.div-qna-header)',
				HELPER.stopEventPropagation);
			$(document).on('click', '.div-answer-wrapper:not(.expanded)', 
				HELPER.displayIcons);
			$(document).on('click', '.div-answer-wrapper.expanded', 
				HELPER.hideIcons);
			$(document).on('click', '.div-answer-wrapper', 
				POPUP.toggleQuestionAnswerForm);
			$(document).on('mouseenter', '.div-answer-wrapper.expanded', 
				HELPER.displayIcons);
			$(document).on('mouseenter', '.div-question-comment-wrapper', 
				HELPER.displayIcons);
			$(document).on('mouseenter', '.div-question-wrapper', 
				HELPER.displayIcons);
			$(document).on('mouseleave', '.div-answer-wrapper.expanded', 
				HELPER.hideIcons);
			$(document).on('mouseleave', '.div-question-comment-wrapper', 
				HELPER.hideIcons);
			$(document).on('mouseleave', '.div-question-wrapper', 
				HELPER.hideIcons);
			POPUP.$popupBackground.click(POPUP.removePopup);
			
			break;
			
		case 'landing_page':
			return;
	}
});

/* 
HELPER FUNCTIONS
*/
	
var HELPER = 
{
	stringContainsSubstrings: function(string, substringArray)
	{
		var containsSubstring = true;
		
		substringArray.forEach(substring =>
		{
			if (string.indexOf(substring) === -1) containsSubstring = false;
    });
		
    return containsSubstring;
	},
	
	array2d: function(rows)
	{
		var array = [];
		for (var i = 0; i < rows; i++) array[i] = [];
		return array;
	},

	callController: segments => siteUrl+'/'+segments,
	
	displayIcons: function()
	{
		$(this).find('.icon-wrapper').fadeTo(200, 1);
	},
	
	hideIcons: function()
	{
		$(this).find('.icon-wrapper').fadeTo(200, 0);
	},
	
	loadAsset: segments => baseUrl+segments,
	
	stopEventPropagation: event => event.stopPropagation(),
	
	preventDefault: event => event.preventDefault()
}

/* 
NAVBAR
*/

var NAVBAR =
{
	$navBurgerMenu: $('.btn-navbar-menu'),
	$subTopicHeading: $('.h-sub-topic-heading'),
	
	updateNavbarHeadings: function(mainTopicHeading, subTopicHeading)
	{
		$jqCache('.h-main-topic-heading').html(mainTopicHeading);
	  $jqCache('.h-sub-topic-heading').html(subTopicHeading);
	},
}

/* 
TOOL-BAR
*/

var TOOLBAR = 
{
	defaultGridStatusText: '',
	selectedGridboxCount: 0,
	$toolbarSearch: $('#toolbar-search'),
	$toolDropdownToggle: $('.div-tool-dropdown-toggle'),
	
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
	$addResourceLi: $('.add-resource'),
	$activeSidebarMenuLi: $('.a-sidebar-menu-li').eq(0),
	$collapsibleSidebarMenuLi: $('.a-sidebar-menu-li.collapsible'),
	$gridTracker: $('.ul-sidebar-questions-list'),
	$nonCollapsibleSidebarMenuLi: $('.a-sidebar-menu-li:not(.collapsible)'),
	$searchCategory: $('.a-sidebar-search-category'),
	$clearSearchButton: $('.img-clear-tt-sidebar-search'),
	$searchNavButton: $('#btn-sidebar-search'),
	$searchField: $('#tt-search-input'),
	$searchForm: $('#tt-search-form'),
	currentSearchFieldValue: '',
	currentSearchCategoryTitle: 'Current Section',
	searchTabWasAltered: false,
	$searchCategoryCollapsibleAnchor: $('.search-category-collapsible-anchor'),
	
	switchExpandedSearchCategorySubmenu: function()
	{
		var clickedAnchorId = $(this).attr('id');
		
		switch (clickedAnchorId)
		{
			case 'user-search-categories-anchor':
				SIDEBAR.closeSidebarSubmenu('#termtrail-search-categories-anchor');
				break;
			
			case 'termtrail-search-categories-anchor':
				SIDEBAR.closeSidebarSubmenu('#user-search-categories-anchor');
		}
	},
	
	buildGridTracker: function(gridItemCount)
	{
		var sidebarHtml = '';
		if (gridItemCount === 0) sidebarHtml = '<li>No grid items</li>';
		else for (var id = 1; id <= gridItemCount; id++)
			sidebarHtml += `<li class="li-grid-tracker-item"
				data-grid-tracker-item-id="${id}">${id}</li>`;
		
		SIDEBAR.$gridTracker.html(sidebarHtml);
	},
	
	disableGridTrackerTab: function()
	{
		if ( ! $jqCache('#a-sidebar-grid-tracker-tab').hasClass('disabled'))
		{
			$jqCache('#img-grid-tracker-chapter-gold').removeClass('img-appear');
			$jqCache('#img-grid-tracker-chapter-grey').addClass('img-appear');
			$jqCache('#a-sidebar-grid-tracker-tab').addClass('disabled');
			SIDEBAR.$gridTracker.sortable('disable');
		}
	},
	
	enableGridTrackerTab: function()
	{
		if ($jqCache('#a-sidebar-grid-tracker-tab').hasClass('disabled') && (
			PAGE_CONTENT.currentGridSection === 'chapter' || 
			PAGE_CONTENT.currentGridSection === 'question' ))
		{
			$jqCache('#img-grid-tracker-chapter-gold').addClass('img-appear');
			$jqCache('#img-grid-tracker-chapter-grey').removeClass('img-appear');
			$jqCache('#a-sidebar-grid-tracker-tab').removeClass('disabled');
			SIDEBAR.$gridTracker.sortable('enable');
		}
	},
	
	closeGridTrackerAndOpenMainMenu: function()
	{
		SIDEBAR.disableGridTrackerTab();
		
		if ($jqCache('#a-sidebar-grid-tracker-tab').hasClass('active'))
		{
			$jqCache('#a-sidebar-grid-tracker-tab').removeClass('active');
			$jqCache('#a-sidebar-menu-tab').addClass('active');
			$jqCache('#div-sidebar-grid-tracker').removeClass('appear');
			$jqCache('#div-sidebar-menu').addClass('appear');
		}
	},
	
	deactivateSidebarMenuLi: function()
	{
		if (SIDEBAR.$activeSidebarMenuLi != null) 
		{
			SIDEBAR.$activeSidebarMenuLi.removeClass('active');
			SIDEBAR.$activeSidebarMenuLi = null;
		}
	},
	
	initGridTracker: function()
	{
		SIDEBAR.$gridTracker.sortable(
		{ 
			disabled: true,
			scroll: false,
			update: function(event, ui)
			{ // update indices after sort and DOM change
				var unorderedGridTrackerNumbersAfterMove = SIDEBAR.$gridTracker.
					sortable('toArray', {attribute: 'data-grid-tracker-item-id'});
				var movedGridTrackerElement = ui.item;
				var movedGridTrackerElementNumber = parseInt(
					movedGridTrackerElement.html());
				var fromIndex = toIndex = movedGridTrackerElementNumber - 1;
				var currentGridTrackerElement, newGridTrackerElementNumber;
				while (movedGridTrackerElementNumber < 
					unorderedGridTrackerNumbersAfterMove[toIndex])
				{ // item dragged down the order
					currentGridTrackerElement = 
						SIDEBAR.$gridTracker.children('.li-grid-tracker-item').eq(toIndex);
					newGridTrackerElementNumber = 
						parseInt(currentGridTrackerElement.html()) - 1;
					currentGridTrackerElement.html(newGridTrackerElementNumber);
					currentGridTrackerElement.attr(
						'data-grid-tracker-item-id', newGridTrackerElementNumber);
					toIndex++;
				}
				while (movedGridTrackerElementNumber > 
					unorderedGridTrackerNumbersAfterMove[toIndex])
				{ // item dragged up the order
					currentGridTrackerElement = 
						SIDEBAR.$gridTracker.children('.li-grid-tracker-item').eq(toIndex);
					newGridTrackerElementNumber = 
						parseInt(currentGridTrackerElement.html()) + 1;
					currentGridTrackerElement.html(newGridTrackerElementNumber);
					currentGridTrackerElement.attr(
						'data-grid-tracker-item-id', newGridTrackerElementNumber);
					toIndex--;
				}
				movedGridTrackerElement.html(toIndex+1);
				movedGridTrackerElement.attr('data-grid-tracker-item-id', toIndex+1);
				PAGE_CONTENT.$pageGrid.move(fromIndex, toIndex);
			}
		});
	},
	
	launchGridTracker: function(gridItemCount)
	{
		SIDEBAR.buildGridTracker(gridItemCount);
		
		$jqCache('#img-grid-tracker-chapter-grey').removeClass('img-appear');
		$jqCache('#img-grid-tracker-chapter-gold').addClass('img-appear');
		$jqCache('#a-sidebar-grid-tracker-tab').removeClass('disabled');
		SIDEBAR.$gridTracker.sortable('enable');
		
		if ($jqCache('.div-sidebar-scroll').hasClass('sidebar-close')) 
		{
			SIDEBAR.toggleSidebar();
			$jqCache('.a-sidebar-navbar-tab').removeClass('active');
			$jqCache('#a-sidebar-grid-tracker-tab').addClass('active');
			$jqCache('.div-sidebar-navbar-tab-pane').removeClass('appear');
			$jqCache('#div-sidebar-grid-tracker').addClass('appear');
		}
	},
	
	launchSidebarSearch: function()
	{
		if ($jqCache('.div-sidebar-scroll').hasClass('sidebar-close')) 
				SIDEBAR.toggleSidebar();
		$jqCache('.div-sidebar-navbar-tab-pane').removeClass('appear');
		$jqCache('.a-sidebar-navbar-tab').removeClass('active');
		$jqCache('#a-sidebar-search-tab').addClass('active');	
		$jqCache('#div-sidebar-search').addClass('appear');
		// select to search 'current section' category
		$jqCache('.a-sidebar-search-category').removeClass('checked');
		$jqCache('.div-tt-search-category-checkbox').removeClass('checked');
		$jqCache('#current-section-search-category').addClass('checked');
		$jqCache('#current-section-search-category').
			children('.div-tt-search-category-checkbox').addClass('checked');
		$jqCache('#tt-search-input').select();
		SIDEBAR.setSearchBarPlaceholder('Current Section');
	},
	
	selectAndClearSearchBar: function()
	{
		$jqCache('#tt-search-input').val('');
		$jqCache('#tt-search-input').select();
	},
	
	resetSearchBarActivity: function()
	{
		SIDEBAR.selectAndClearSearchBar();
		PAGE_CONTENT.$pageGrid.filter('.div-gridbox-wrapper');
		SIDEBAR.enableGridTrackerTab();
	},
	
	selectSearchCategory: function()
	{
		var nextSearchCategoryTitle = $(this).data('category-title');
		
		if (SIDEBAR.currentSearchCategoryTitle !== nextSearchCategoryTitle)
		{
			SIDEBAR.searchTabWasAltered = true;
			
			if (nextSearchCategoryTitle === 'Current Section') 
					PAGE_CONTENT.reloadPreviousPageGrid();
			else
			{
				if (SIDEBAR.currentSearchCategoryTitle === 'Current Section')
					PAGE_CONTENT.savePreviousGridSectionData();
				
				var gridSection = $(this).data('grid-section');
				var gridSource = $(this).data('grid-source');
				PAGE_CONTENT.loadNewPageGrid(gridSection, gridSource, 
					`Search ${nextSearchCategoryTitle}`);
			}
			
			$jqCache('.a-sidebar-search-category').removeClass('checked');
			$jqCache('.div-tt-search-category-checkbox').removeClass('checked');
			$(this).addClass('checked');
			$(this).children('.div-tt-search-category-checkbox').addClass('checked');
			// update search bar placeholder
			var newPlaceholder = nextSearchCategoryTitle;
			SIDEBAR.selectAndClearSearchBar();
			SIDEBAR.setSearchBarPlaceholder(newPlaceholder);
			SIDEBAR.currentSearchCategoryTitle = nextSearchCategoryTitle;
		}
	},
	
	resetSearchTab: function()
	{
		if (SIDEBAR.searchTabWasAltered)
		{
			$jqCache('#tt-search-input').val('');
			SIDEBAR.setSearchBarPlaceholder('Current Section');
			
			$jqCache('.a-sidebar-search-category').removeClass('checked');
			$jqCache('.div-tt-search-category-checkbox').removeClass('checked');
			
			var currentSectionSearchCategoryLi = 
				$jqCache('#current-section-search-category');
			currentSectionSearchCategoryLi.addClass('checked');
			currentSectionSearchCategoryLi.
				children('.div-tt-search-category-checkbox').addClass('checked');
			
			SIDEBAR.openSidebarSubmenu('#user-search-categories-anchor');
			SIDEBAR.closeSidebarSubmenu('#termtrail-search-categories-anchor');
			
			SIDEBAR.searchTabWasAltered = false;
		}
	},
	
	openSidebarSubmenu: function(subMenuAnchorSelector)
	{
		var $submenuAnchor = $jqCache(subMenuAnchorSelector);
		SIDEBAR.getThisSidebarSubmenu($submenuAnchor).addClass('appear');
		$submenuAnchor.children('.img-sidebar-li-expand').removeClass('appear');
		$submenuAnchor.children('.img-sidebar-li-collapse').addClass('appear');
	},
	
	closeSidebarSubmenu: function(subMenuAnchorSelector)
	{
		var $submenuAnchor = $jqCache(subMenuAnchorSelector);
		SIDEBAR.getThisSidebarSubmenu($submenuAnchor).removeClass('appear');
		$submenuAnchor.children('.img-sidebar-li-expand').addClass('appear');
		$submenuAnchor.children('.img-sidebar-li-collapse').removeClass('appear');
	},
	
	toggleSidebarSubmenu: function()
	{
		SIDEBAR.getThisSidebarSubmenu($(this)).toggleClass('appear');
		$(this).children('.img-sidebar-li-expand').toggleClass('appear');
		$(this).children('.img-sidebar-li-collapse').toggleClass('appear');
	},
	
	getThisSidebarSubmenu: function($sidebarMenuItem)
	{
		return $sidebarMenuItem.next();
	},
	
	switchActiveSidebarMenu: function()
	{
		$jqCache('.a-sidebar-menu-li').removeClass('active');
		
		$(this).addClass('active');
		var liAttribute = $(this).attr('data-action');
		var alreadyActive = $(this).is(SIDEBAR.$activeSidebarMenuLi);
		
		if (liAttribute === 'refresh-grid' && ! alreadyActive)
		{
			var gridSection = $(this).data('title');
			var gridTitle = gridSection+'s';
			PAGE_CONTENT.loadNewPageGrid(gridSection, 'local', gridTitle);
			SIDEBAR.$activeSidebarMenuLi = $(this);
		}
	},
	
	switchActiveSidebarNavTab: function()
	{
		$('.a-sidebar-navbar-tab').removeClass('active');
		$(this).addClass('active');
		$jqCache('.div-sidebar-navbar-tab-pane').removeClass('appear');
		
		SIDEBAR.resetSearchTab();
		
		switch ($(this).attr('id'))
		{
			case 'a-sidebar-menu-tab':
				$jqCache('#div-sidebar-menu').addClass('appear');
				break;
			case 'a-sidebar-inbox-tab':
				$jqCache('#div-sidebar-messages').addClass('appear');
				break;
			case 'a-sidebar-search-tab':
				$jqCache('#div-sidebar-search').addClass('appear');
				break;
			case 'a-sidebar-grid-tracker-tab':
				$jqCache('#div-sidebar-grid-tracker').addClass('appear');
		}
	},
	
	toggleSidebar: function()
	{
		$jqCache('.div-sidebar-scroll').toggleClass('sidebar-close');
		$jqCache('.div-page-content-wrapper').toggleClass('stretch');
	},
	
	setSearchBarPlaceholder: function(text)
	{
		$jqCache('#tt-search-input').attr('placeholder', text);
	}
}

/* 
PAGE CONTENT
*/

var PAGE_CONTENT =
{
	$focusedGridbox: null,
	$pageGrid: null,
	previousGridSectionData: [],
	gridboxesAreSelected: false,
	currentGridSection: '',
	
	clearGridboxSelections: function()
	{
		if (PAGE_CONTENT.gridboxesAreSelected)
		{
			$jqCache('.text-grid-status').html(TOOLBAR.defaultGridStatusText);
			$jqCache('.text-grid-status').removeClass('selected');
			$jqCache('.div-selection-checkbox').removeClass('selected');
			$jqCache('.div-gridbox').removeClass('selected');
			$jqCache('.div-gridbox-footer').removeClass('selected');
			TOOLBAR.selectedGridboxCount = 0;
		}
	},
	
	searchGrid: function(event)
	{
		var newSearchValue = $(this).val().toLowerCase();
		
		if (SIDEBAR.currentSearchFieldValue !== newSearchValue)
		{
			if (newSearchValue === '') SIDEBAR.enableGridTrackerTab();
			else 
			{
				SIDEBAR.searchTabWasAltered = true;
				SIDEBAR.disableGridTrackerTab();
			}
			
			SIDEBAR.currentSearchFieldValue = newSearchValue;
			PAGE_CONTENT.filterGrid('search');
		}
	},
	
	filterGrid: function(filterMode)
	{
		try
		{
			switch (filterMode)
			{
				case 'search':
				{
					var searchTerms = SIDEBAR.currentSearchFieldValue.split(' ');

					PAGE_CONTENT.$pageGrid.filter(function(item)
					{
						var gridboxTitle = item.getElement().
							getAttribute('data-gridbox-title').toLowerCase();
							
						var isSearchMatch = HELPER.stringContainsSubstrings(
							gridboxTitle, searchTerms);
							
						return isSearchMatch;
					});
					
					break;
				}
				
				case 'filter':
					break;
					
				case 'sort':
					return;
			}
		}
		catch (error) {}
	},
	
	getGridboxTitle: function($gridbox)
	{
		return $gridbox.parent().data('gridbox-title');
	},

	getGridItemNumberElement: function(item)
	{
		return $(item.getElement()).find('.text-gridbox-numbering');
	},
	
	getGridItemElements: function(sourceType, source)
	{
		var gridElements = [];
		
		switch(sourceType)
		{
			case 'gridViews':
				source.forEach(function(gridboxView)
				{
					element = document.createElement('div');
					element.innerHTML = gridboxView;
					gridElements.push(element.firstChild);
				});
				break;
			case 'gridItems':
				source.forEach(function(gridItem)
				{
					element = document.createElement('div');
					element.innerHTML = gridItem._element.outerHTML;
					gridElements.push(element.firstChild);
				});
		}
		
		return gridElements;
	},
	
	gridboxFocus: function(event)
	{ // scroll to highlighted gridbox
		event.stopPropagation();
		var gridItemIndex = $(this).html() - 1;
		PAGE_CONTENT.$focusedGridbox = $('.div-gridbox').eq(gridItemIndex);
		PAGE_CONTENT.$focusedGridbox.addClass('outline-div-gridbox');
		var scrollOffset = PAGE_CONTENT.$focusedGridbox.offset().top - 350;
		$jqCache('html, body').animate({scrollTop: scrollOffset}, 500);
	},
	
	gridboxUnfocus: function()
	{
		if (PAGE_CONTENT.$focusedGridbox != null) 
		{
			PAGE_CONTENT.$focusedGridbox.removeClass('outline-div-gridbox');
			PAGE_CONTENT.$focusedGridbox = null;
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
					var gridboxNumber = 
						PAGE_CONTENT.getGridItemNumberElement(item).html();
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
				var slotDimensions = HELPER.array2d(rowCount);
				var newSlot, topSlot, leftSlot, slotRow, slotCol;
				items.forEach(function(item, index)
				{
					newSlot = { left: 0, top: 0, 
						height: item._height, width: item._width };
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
		.on('dragStart', function(item, event) 
		{
			// check if user is online, else disable drag sort
		})
		.on('move', function(moveData)
		{ // update indices after item move (for both UI and database)
			var fromIndex = moveData.fromIndex;
			var toIndex = moveData.toIndex;
			
			var $gridboxItem = $(moveData.item.getElement());
			var gridboxFullJsonId = 
				$gridboxItem.children('.div-gridbox').data('full-json-id');
			var gridboxSection = 
				$gridboxItem.children('.div-gridbox').data('grid-section');

			var ajaxUrlSegments = 
				`dashboard/ajax_move_gridbox/${gridboxSection}/${fromIndex}/${toIndex}`;
			var gridPost = $.post(HELPER.callController(ajaxUrlSegments),
			{ 
				grid_box_full_json_id: JSON.stringify(gridboxFullJsonId) 
			});
			
			gridPost.done(function(data)
			{ 
				var $pageGridItems = PAGE_CONTENT.$pageGrid.getItems();
				var gridboxNumberElement;
				while (fromIndex < toIndex)
				{ // dragged down the order
					gridboxNumberElement = 
						PAGE_CONTENT.getGridItemNumberElement($pageGridItems[fromIndex]);
					fromIndex++;
					gridboxNumberElement.html(fromIndex);
				}
				while (fromIndex > toIndex)
				{ // dragged up the order
					gridboxNumberElement = 
						PAGE_CONTENT.getGridItemNumberElement($pageGridItems[fromIndex]);
					gridboxNumberElement.html(fromIndex+1);
					fromIndex--;
				}
				PAGE_CONTENT.getGridItemNumberElement(moveData.item).html(toIndex+1);
				PAGE_CONTENT.$pageGrid.refreshSortData();
				PAGE_CONTENT.$pageGrid.synchronize();
			});
		});
	},
	
	leftColExists: function(slotCol)
	{
		if (slotCol-1 === -1) return false;
		return true;
	},
	
	openGridbox: function()
	{
		SIDEBAR.deactivateSidebarMenuLi();
		SIDEBAR.resetSearchTab();
		
		var gridboxFullJsonId = $(this).data('full-json-id');
		var gridboxChildSection = $(this).data('grid-child-section');
		
		$(this).trigger('mouseleave'); // hide icons
		
		if (PAGE_CONTENT.currentGridSection === 'question') 
			POPUP.popupQuestionTabs(gridboxFullJsonId);
		else
		{
			var gridboxTitle = PAGE_CONTENT.getGridboxTitle($(this));
			var gridTitle = `${gridboxTitle}: ${gridboxChildSection}s`;
			PAGE_CONTENT.savePreviousGridSectionData();
			PAGE_CONTENT.loadNewPageGrid(gridboxChildSection, 'local', 
				gridTitle, gridboxFullJsonId);
		}
	},
	
	reloadPreviousPageGrid: function()
	{
		PAGE_CONTENT.removePageGridItems();
		
		var data = PAGE_CONTENT.previousGridSectionData.pop();
		
		NAVBAR.updateNavbarHeadings(data.mainTopicHeading, data.subTopicHeading);
		
		var gridItemElements = 
			PAGE_CONTENT.getGridItemElements('gridItems', data.gridItems);
		PAGE_CONTENT.addGridElements(data.gridSection, gridItemElements, false);
		SIDEBAR.resetSearchTab();
	},
	
	addGridElements: function(
		gridSection, gridItemElements, evokedFromSidebarMenu)
	{
		PAGE_CONTENT.currentGridSection = gridSection;
		PAGE_CONTENT.checkAndToggleGridDragAndTracker(
			gridItemElements.length, evokedFromSidebarMenu);
		PAGE_CONTENT.$pageGrid.add(gridItemElements);
	},
	
	savePreviousGridSectionData: function()
	{
		var data = 
		{
			gridSection: PAGE_CONTENT.currentGridSection,
			subTopicHeading: $('.h-sub-topic-heading').html(),
			mainTopicHeading: $('.h-main-topic-heading').html(),
			gridItems: PAGE_CONTENT.$pageGrid.getItems(),
		};
		PAGE_CONTENT.previousGridSectionData.push(data);
	},
	
	loadNewPageGrid: function(
		gridSection, gridSource, gridTitle, gridboxFullJsonId)
	{
		var ajaxUrlSegments = 
			`dashboard/ajax_get_grid_views/${gridSection}/${gridSource}`;
		var gridPost = $.post(HELPER.callController(ajaxUrlSegments),
			{ grid_box_full_json_id: JSON.stringify(gridboxFullJsonId) });
		
		gridPost.done(function(data) 
		{ 
			PAGE_CONTENT.removePageGridItems();

			var gridViews = JSON.parse(data);
			var gridItemElements = 
				PAGE_CONTENT.getGridItemElements('gridViews', gridViews);
			var mainTopicHeading = gridTitle;
			var subTopicHeading = gridboxFullJsonId ? 
				'< '+PAGE_CONTENT.currentGridSection : '';
			NAVBAR.updateNavbarHeadings(mainTopicHeading, subTopicHeading);
			var evokedFromSidebarMenu = ! gridboxFullJsonId ? true : false;
			PAGE_CONTENT.addGridElements(
				gridSection, gridItemElements, evokedFromSidebarMenu);
		});
	},
	
	checkAndToggleGridDragAndTracker: function(
		gridItemCount, evokedFromSidebarMenu)
	{
		if ( ! evokedFromSidebarMenu && (
			PAGE_CONTENT.currentGridSection === 'chapter' || 
			PAGE_CONTENT.currentGridSection === 'question' ))
		{
			SIDEBAR.launchGridTracker(gridItemCount);
			PAGE_CONTENT.$pageGrid._settings.dragEnabled = true;
		}
		else 
		{
			SIDEBAR.closeGridTrackerAndOpenMainMenu();
			PAGE_CONTENT.$pageGrid._settings.dragEnabled = false;
		}
	},
	
	removePageGridItems: function()
	{
		var gridItems = PAGE_CONTENT.$pageGrid.getItems();
		PAGE_CONTENT.$pageGrid.remove(gridItems, 
			{removeElements: true, layout: false});
	},
	
	toggleGridboxSelect: function(event)
	{
		event.stopPropagation();
		
		var $targetedGridboxCheckbox;
		if ($(event.target).is($('.li-grid-tracker-item')))
		{
			$targetedGridboxCheckbox = 
				PAGE_CONTENT.$focusedGridbox.find('.div-selection-checkbox');
			PAGE_CONTENT.gridboxUnfocus();
		}
		else $targetedGridboxCheckbox = $(this);
		
	  if ($targetedGridboxCheckbox.hasClass('selected'))
		{ // update status text
			TOOLBAR.selectedGridboxCount--;
			if (TOOLBAR.selectedGridboxCount === 0) 
			{
				$jqCache('.text-grid-status').html(TOOLBAR.defaultGridStatusText);
				$jqCache('.text-grid-status').removeClass('selected');
				PAGE_CONTENT.gridboxesAreSelected = false;
			}
			else $jqCache('.text-grid-status').
				html(`Clear ${TOOLBAR.selectedGridboxCount} Selection(s)`);
		}
		else 
		{ // update status text
			TOOLBAR.selectedGridboxCount++;
			if (TOOLBAR.selectedGridboxCount === 1)
			{
				TOOLBAR.defaultGridStatusText = $jqCache('.text-grid-status').html();
				PAGE_CONTENT.gridboxesAreSelected = true;
			}
			$jqCache('.text-grid-status').
				html(`Clear ${TOOLBAR.selectedGridboxCount} Selection(s)`);
			$jqCache('.text-grid-status').addClass('selected');
		}
		$targetedGridboxCheckbox.toggleClass('selected');
		$targetedGridboxCheckbox.parents('.div-gridbox').toggleClass('selected');
		$targetedGridboxCheckbox.
			siblings('.div-gridbox-footer').toggleClass('selected');
	},
	
	topRowExists: function(slotRow)
	{
		if (slotRow-1 === -1) return false;
		return true;
	}
}

/* 
POP-UP
*/

var POPUP = 
{
	$popupBackground: $('.popup-background'),
	$popupWrapper: $('.div-generic-popup-wrapper'),
	popupElementsToDisplay: [],
	answerFormIsExpanded: false,
	
	popupAddResource: function()
	{
		POPUP.popupElementsToDisplay.push(POPUP.$popupBackground);
		POPUP.popupElementsToDisplay.push(POPUP.$popupWrapper);
		POPUP.popupElementsToDisplay.push($jqCache('.div-add-resource'));
		POPUP.displayPopup();
		switch ($(this).attr('id'))
		{
			case 'sidebar-submenu-add-question':
				$jqCache('.h-resource-main').html('Add Question');
				break;
			case 'sidebar-submenu-add-chapter':
				$jqCache('.h-resource-main').html('Add Chapter');
				break;
			case 'sidebar-submenu-add-bank':
				$jqCache('.h-resource-main').html('Add Bank');
				break;
			case 'sidebar-submenu-add-course':
				$jqCache('.h-resource-main').html('Add Course');
				break;
			case 'sidebar-submenu-add-school':
				$jqCache('.h-resource-main').html('Add School');	
		}
	},
	
	popupQuestionTabs: function(gridboxFullJsonId)
	{
		var ajaxUrlSegments = 'dashboard/ajax_get_question_tab_popup_view/';
		var popupPost = $.post(HELPER.callController(ajaxUrlSegments), 
		{
			grid_box_full_json_id: JSON.stringify(gridboxFullJsonId)
		});
		
		popupPost.done(function(data) 
		{ 
			var popupView = JSON.parse(data);
			// tabs-question element isn't jqCached
			$('.tabs-question').replaceWith(popupView);
			POPUP.popupElementsToDisplay.push(POPUP.$popupBackground);
			POPUP.popupElementsToDisplay.push(POPUP.$popupWrapper);
			POPUP.popupElementsToDisplay.push($('.tabs-question'));
			POPUP.displayPopup();
		});
	},	
	
	removePopup: function(event) 
	{ 
		POPUP.popupElementsToDisplay.forEach(function(element) 
		{ 
			element.removeClass('appear') 
		});
		
		POPUP.popupElementsToDisplay = [];
		POPUP.answerFormIsExpanded = false;
	},
	
	displayPopup: function()
	{
		POPUP.popupElementsToDisplay.forEach(function(element) 
		{ 
			element.addClass('appear') 
		});
	},
	
	switchActiveQuestionPopupTab: function()
	{
		var $newActiveTab = $('.a-question-popup-tab:not(.w--current)');
		$('.a-question-popup-tab').removeClass('w--current');
		$newActiveTab.addClass('w--current');
		
		var $newActiveTabPane = $('.tab-pane-question-popup:not(.w--tab-active)');
		$('.tab-pane-question-popup').removeClass('w--tab-active');
		$newActiveTabPane.addClass('w--tab-active');
	},
	
	toggleQuestionAnswerForm: function(event)
	{
		if (POPUP.answerFormIsExpanded)
		{
			$(this).children('.form-block-answer').removeClass('appear');
			$(this).removeClass('expanded');
			POPUP.answerFormIsExpanded = false;
		}
		else
		{
			$(this).children('.form-block-answer').addClass('appear');
			$(this).addClass('expanded');
			POPUP.answerFormIsExpanded = true;
		}
	}
}