/*
 - use jquery filters e.g. 'div:not(.box)' rather than if statements.
 - set event listeners as shown in the 'document ready' section.
 - Unless creating a new module is necessary, encapsulate all variables and functions inside the currently provided modules.
 - prefix jQuery object variables with '$' e.g. $sidebarMenuDiv.
 - arrange functions, event delegations, and variables in alphabetical order.
 - cache jqueries by either storing in a variable (prefixed with '$'), or calling via the $jqCache function; which reuses previously called jQueries.
 - make dependencies between functions explicit by: encapsulating in a function; function parameters; callbacks; throwing errors; using global variables (last resort as it can be easy to neglect updating them).
*/

function $jqCache(query)
{ // cache the jqueries
	this.cache = this.cache || {};
	if ( ! this.cache[query]) this.cache[query] = $(query);
	return this.cache[query];
}

function log(out) { console.log(out); }

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
			$jqCache(document).on('click', '.a-sidebar-navbar-tab:not(.disabled)', SIDEBAR.switchActiveSidebarNavSection);
			$jqCache(document).on('click', '.li-grid-tracker-item', PAGE_CONTENT.gridboxFocus);
			$jqCache(document).on('dblclick', '.li-grid-tracker-item', PAGE_CONTENT.toggleGridboxSelect);
			$jqCache(document).on('mouseleave', '.li-grid-tracker-item', PAGE_CONTENT.gridboxUnfocus);
			SIDEBAR.$addResourceLi.click(POPUP.popupAddResource);
			SIDEBAR.$collapsibleSidebarMenuLi.click(SIDEBAR.toggleSidebarSubmenu);
			SIDEBAR.initGridTracker();
			SIDEBAR.$nonCollapsibleSidebarMenuLi.click(SIDEBAR.switchActiveSidebarMenu);
			SIDEBAR.$searchCategory.click(SIDEBAR.selectSearchCategory);
			SIDEBAR.$searchCross.click(SIDEBAR.selectClearSearchBar);
			SIDEBAR.$searchNavButton.click(SIDEBAR.selectClearSearchBar);

			// PAGE_CONTENT
			$jqCache(document).on('click', 'body', PAGE_CONTENT.clearGridboxSelections);
			$jqCache(document).on('click', '.div-gridbox', PAGE_CONTENT.openGridbox);
			$jqCache(document).on('click', '.div-selection-checkbox', PAGE_CONTENT.toggleGridboxSelect);
			$jqCache(document).on('mouseenter', '.div-gridbox', HELPER.displayIcons);
			$jqCache(document).on('mouseleave', '.div-gridbox:not(.selected)', HELPER.hideIcons);
			PAGE_CONTENT.initPageContentGrid();
			PAGE_CONTENT.loadNewPageGrid('bank');

			// POP-UP
			$jqCache(document).on('click', '.a-question-popup-tab:not(.w--current)', POPUP.switchActiveQuestionPopupTab);
			$jqCache(document).on('click', '.div-answer-wrapper *:not(.div-qna-header)', HELPER.stopEventPropagation);
			$jqCache(document).on('click', '.div-answer-wrapper:not(.expanded)', HELPER.displayIcons);
			$jqCache(document).on('click', '.div-answer-wrapper.expanded', HELPER.hideIcons);
			$jqCache(document).on('click', '.div-answer-wrapper', POPUP.toggleQuestionAnswerForm);
			$jqCache(document).on('mouseenter', '.div-answer-wrapper.expanded', HELPER.displayIcons);
			$jqCache(document).on('mouseenter', '.div-question-comment-wrapper', HELPER.displayIcons);
			$jqCache(document).on('mouseenter', '.div-question-wrapper', HELPER.displayIcons);
			$jqCache(document).on('mouseleave', '.div-answer-wrapper.expanded', HELPER.hideIcons);
			$jqCache(document).on('mouseleave', '.div-question-comment-wrapper', HELPER.hideIcons);
			$jqCache(document).on('mouseleave', '.div-question-wrapper', HELPER.hideIcons);
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
	array2d: function(rows)
	{
		var array = [];
		for (var i = 0; i < rows; i++) array[i] = [];
		return array;
	},

	callController: function(segments)
	{
		return siteUrl+'/'+segments;
	},
	
	displayIcons: function()
	{
		$(this).find('.icon-wrapper').fadeTo(200, 1);
	},
		
	hideIcons: function()
	{
		$(this).find('.icon-wrapper').fadeTo(200, 0);
	},
	
	loadAsset: function(segments)
	{
		return baseUrl+segments;
	},
	
	stopEventPropagation: function(event)
	{
		event.stopPropagation();
	}
}

/* 
NAVBAR
*/

var NAVBAR =
{
	$navBurgerMenu: $('.btn-navbar-menu'),
	$subTopicHeading: $('.h-sub-topic-heading'),
	
	updateMainTopicHeading: function(text)
	{
	  $jqCache('.h-main-topic-heading').html(text);
	},
	
	updateSubTopicHeading: function(text)
	{
	  $jqCache('.h-sub-topic-heading').html(text);
	}
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
	$addResourceLi: $('.a-sidebar-submenu'),
	$activeSidebarMenuLi: $('.a-sidebar-menu-li').eq(0),
	$collapsibleSidebarMenuLi: $('.a-sidebar-menu-li.collapsible'),
	$gridTracker: $('.ul-sidebar-questions-list'),
	$nonCollapsibleSidebarMenuLi: $('.a-sidebar-menu-li:not(.collapsible)'),
	$searchCategory: $('.a-sidebar-search-category'),
	$searchCross: $('.img-clear-tt-sidebar-search'),
	$searchNavButton: $('#btn-sidebar-search'),
	searchValue: '',
	
	buildGridTracker: function(gridItemCount)
	{
		var sidebarHtml = '';
		if (gridItemCount === 0) sidebarHtml = '<li>No grid items</li>';
		else
			for (var id = 1; id <= gridItemCount; id++)
				sidebarHtml += 
					'<li class="li-grid-tracker-item" data-grid-tracker-item-id="'+id+'">'+id+'</li>';
		
		SIDEBAR.$gridTracker.html(sidebarHtml);
	},
	
	closeGridTracker: function()
	{
		$jqCache('#img-grid-tracker-chapter-gold').removeClass('img-appear');
		$jqCache('#img-grid-tracker-chapter-grey').addClass('img-appear');
		$jqCache('#a-sidebar-grid-tracker-tab').addClass('disabled');
		SIDEBAR.$gridTracker.sortable('disable');
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
	
	getThisSidebarSubmenu: function($sidebarMenuItem)
	{
		return $sidebarMenuItem.next();
	},
	
	initGridTracker: function()
	{
		SIDEBAR.$gridTracker.sortable(
		{ 
			disabled: true,
			scroll: false,
			update: function(event, ui)
			{ // update indices after sort and DOM change
				var unorderedGridTrackerNumbersAfterMove = 
					SIDEBAR.$gridTracker.sortable('toArray', {attribute: 'data-grid-tracker-item-id'});
				var movedGridTrackerElement = ui.item;
				var movedGridTrackerElementNumber = parseInt(movedGridTrackerElement.html());
				var fromIndex = toIndex = movedGridTrackerElementNumber - 1;
				var currentGridTrackerElement, newGridTrackerElementNumber;
				while (movedGridTrackerElementNumber < unorderedGridTrackerNumbersAfterMove[toIndex])
				{ // item dragged down the order
					currentGridTrackerElement = 
						SIDEBAR.$gridTracker.children('.li-grid-tracker-item').eq(toIndex);
					newGridTrackerElementNumber = parseInt(currentGridTrackerElement.html()) - 1;
					currentGridTrackerElement.html(newGridTrackerElementNumber);
					currentGridTrackerElement.attr('data-grid-tracker-item-id', newGridTrackerElementNumber);
					toIndex++;
				}
				while (movedGridTrackerElementNumber > unorderedGridTrackerNumbersAfterMove[toIndex])
				{ // item dragged up the order
					currentGridTrackerElement = 
						SIDEBAR.$gridTracker.children('.li-grid-tracker-item').eq(toIndex);
					newGridTrackerElementNumber = parseInt(currentGridTrackerElement.html()) + 1;
					currentGridTrackerElement.html(newGridTrackerElementNumber);
					currentGridTrackerElement.attr('data-grid-tracker-item-id', newGridTrackerElementNumber);
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
		
		if ($jqCache('.div-sidebar-scroll').hasClass('sidebar-close')) SIDEBAR.toggleSidebar();
		$jqCache('.a-sidebar-navbar-tab').removeClass('active');
		$jqCache('#a-sidebar-grid-tracker-tab').addClass('active');
		$jqCache('.div-sidebar-navbar-tab-pane').removeClass('appear');
		$jqCache('#div-sidebar-grid-tracker').addClass('appear');
	},
	
	launchSidebarSearch: function()
	{
		if ($jqCache('.div-sidebar-scroll').hasClass('sidebar-close')) SIDEBAR.toggleSidebar();
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
		$jqCache('.text-field-tt-search').select();
		SIDEBAR.updateSearchBarPlaceholder('Current Section');
	},
	
	selectClearSearchBar: function()
	{
		$jqCache('.text-field-tt-search').val('');
		$jqCache('.text-field-tt-search').select();
	},
	
	selectSearchCategory: function()
	{
		$jqCache('.a-sidebar-search-category').removeClass('checked');
		$jqCache('.div-tt-search-category-checkbox').removeClass('checked');
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
		$jqCache('.a-sidebar-menu-li').removeClass('active');
		
		$(this).addClass('active');
		var liAttribute = $(this).attr('data-action');
		var alreadyActive = $(this).is(SIDEBAR.$activeSidebarMenuLi);
		
		if (liAttribute === 'refresh-grid' && ! alreadyActive)
		{
			var gridSection = $(this).attr('data-title');
			PAGE_CONTENT.loadNewPageGrid(gridSection);
			NAVBAR.updateMainTopicHeading(gridSection+'s');
			NAVBAR.updateSubTopicHeading('');
			SIDEBAR.$activeSidebarMenuLi = $(this);
		}
	},
	
	switchActiveSidebarNavSection: function()
	{
		$('.a-sidebar-navbar-tab').removeClass('active');
		$(this).addClass('active');
		$jqCache('.div-sidebar-navbar-tab-pane').removeClass('appear');
		
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
	
	toggleSidebarSubmenu: function()
	{
		SIDEBAR.getThisSidebarSubmenu($(this)).toggleClass('appear');
		$(this).children('.img-sidebar-li-expand').toggleClass('appear');
		$(this).children('.img-sidebar-li-collapse').toggleClass('appear');
	},
	
	updateSearchBarPlaceholder: function(text)
	{
		$jqCache('.text-field-tt-search').attr('placeholder', text);
	}
}

/* 
PAGE CONTENT
*/

var PAGE_CONTENT =
{
	currentGridParentFullID: '',
	$focusedGridbox: null,
	$pageGrid: null,
	previousGridSectionData: [],
	gridboxesAreSelected: false,
	
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
					var gridboxNumber = PAGE_CONTENT.getGridItemNumberElement(item).html();
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
		.on('dragStart', function(item, event) 
		{
			// check if user is online, else disable drag sort
		})
		.on('move', function(moveData)
		{ // update indices after item move (for both UI and database)
			var fromIndex = moveData.fromIndex;
			var toIndex = moveData.toIndex;
			
			var $gridboxItem = $(moveData.item.getElement());
			var gridboxFullJsonId = $gridboxItem.children('.div-gridbox').data('full-json-id');
			var gridboxSection = $gridboxItem.children('.div-gridbox').data('grid-section');

			var ajaxUrlSegments = 
				'dashboard/ajax_move_gridbox/'+gridboxSection+'/'+fromIndex+'/'+toIndex;
			var gridPost = $.post(HELPER.callController(ajaxUrlSegments),
				{ grid_box_full_json_id: JSON.stringify(gridboxFullJsonId) });
			
			gridPost.done(function(data)
			{ 
				var $pageGridItems = PAGE_CONTENT.$pageGrid.getItems();
				var gridboxNumberElement;
				while (fromIndex < toIndex)
				{ // dragged down the order
					gridboxNumberElement = PAGE_CONTENT.getGridItemNumberElement($pageGridItems[fromIndex]);
					fromIndex++;
					gridboxNumberElement.html(fromIndex);
				}
				while (fromIndex > toIndex)
				{ // dragged up the order
					gridboxNumberElement = PAGE_CONTENT.getGridItemNumberElement($pageGridItems[fromIndex]);
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
		
		var gridboxFullJsonId = $(this).data('full-json-id');
		var gridboxSection = $(this).data('grid-section');
		var gridboxChildSection = $(this).data('grid-child-section');
		
		$(this).trigger('mouseleave'); // hide icons
		
		if (gridboxSection === 'question') POPUP.popupQuestionTabs(gridboxFullJsonId);
		else
		{
			var gridboxTitle = PAGE_CONTENT.getGridboxTitle($(this));
			PAGE_CONTENT.savePreviousGridSectionData(gridboxSection);
			PAGE_CONTENT.loadNewPageGrid(gridboxChildSection, gridboxFullJsonId);
			
			NAVBAR.updateMainTopicHeading(gridboxTitle+': '+gridboxChildSection+'s');
			NAVBAR.updateSubTopicHeading('< '+gridboxSection);
		}
	},
	
	reloadPreviousPageGrid: function()
	{
		PAGE_CONTENT.removePageGridItems();
		
		var data = PAGE_CONTENT.previousGridSectionData.pop();
		$('.h-main-topic-heading').html(data.mainTopicHeading);
		$('.h-sub-topic-heading').html(data.subTopicHeading);
		
		var gridItemElements = PAGE_CONTENT.getGridItemElements('gridItems', data.gridItems);
		PAGE_CONTENT.addGridElements(data.gridSection, gridItemElements);
	},
	
	addGridElements: function(gridSection, gridItemElements)
	{
		PAGE_CONTENT.checkAndToggleGridDragAndTracker(gridSection, gridItemElements.length);
		PAGE_CONTENT.$pageGrid.add(gridItemElements);
	},
	
	savePreviousGridSectionData: function(gridSection)
	{
		var data = 
		{
			gridSection: gridSection,
			subTopicHeading: $('.h-sub-topic-heading').html(),
			mainTopicHeading: $('.h-main-topic-heading').html(),
			gridItems: PAGE_CONTENT.$pageGrid.getItems(),
		};
		PAGE_CONTENT.previousGridSectionData.push(data);
	},
	
	loadNewPageGrid: function(gridSection, gridboxFullJsonId)
	{
		var ajaxUrlSegments = 'dashboard/ajax_get_grid_views/'+gridSection;
		var gridPost = $.post(HELPER.callController(ajaxUrlSegments), 
			{ grid_box_full_json_id: JSON.stringify(gridboxFullJsonId) });
		
		gridPost.done(function(data) 
		{ 
			PAGE_CONTENT.removePageGridItems();
		
			var gridViews = JSON.parse(data);
			var gridItemElements = PAGE_CONTENT.getGridItemElements('gridViews', gridViews);
			PAGE_CONTENT.addGridElements(gridSection, gridItemElements);
		});
	},
	
	checkAndToggleGridDragAndTracker: function(gridSection, gridItemCount)
	{
		if (gridSection === 'chapter' || gridSection === 'question') 
		{
			SIDEBAR.launchGridTracker(gridItemCount);
			PAGE_CONTENT.$pageGrid._settings.dragEnabled = true;
		}
		else 
		{
			SIDEBAR.closeGridTracker();
			PAGE_CONTENT.$pageGrid._settings.dragEnabled = false;
		}
	},
	
	removePageGridItems: function()
	{
		var gridItems = PAGE_CONTENT.$pageGrid.getItems();
		PAGE_CONTENT.$pageGrid.remove(gridItems, {removeElements: true, layout: false});
	},
	
	toggleGridboxSelect: function(event)
	{
		event.stopPropagation();
		
		var $targetedGridboxCheckbox;
		if ($(event.target).is($('.li-grid-tracker-item')))
		{
			$targetedGridboxCheckbox = PAGE_CONTENT.$focusedGridbox.find('.div-selection-checkbox');
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
				html('Clear '+TOOLBAR.selectedGridboxCount+' Selection(s)');
		}
		else 
		{ // update status text
			TOOLBAR.selectedGridboxCount++;
			if (TOOLBAR.selectedGridboxCount === 1)
			{
				TOOLBAR.defaultGridStatusText = $jqCache('.text-grid-status').html();
				PAGE_CONTENT.gridboxesAreSelected = true;
			}
			$jqCache('.text-grid-status').html('Clear '+TOOLBAR.selectedGridboxCount+' Selection(s)');
			$jqCache('.text-grid-status').addClass('selected');
		}
		$targetedGridboxCheckbox.toggleClass('selected');
		$targetedGridboxCheckbox.parents('.div-gridbox').toggleClass('selected');
		$targetedGridboxCheckbox.siblings('.div-gridbox-footer').toggleClass('selected');
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
			// no jqCache for tabs-question; the clicked question may not be cached due to change
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
				log(SIDEBAR.searchValue);
				filter();
			}
		}
	}); 
	
	(function($) {

  var allStarCast = [
    { firstName: "Zack", lastName: "Morris" },
    { firstName: "Kelly", lastName: "Kapowski" },
    { firstName: "Lisa", lastName: "Turtle" },
    { firstName: "Screech", lastName: "Powers" },
    { firstName: "A.C.", lastName: "Slater" },
    { firstName: "Jessie", lastName: "Spano" },
    { firstName: "Richard", lastName: "Belding" }
  ]

  // iterate through the cast and find zack and kelly

  var worldsCutestCouple = $.map(allStarCast, function(actor, idx) {
    if (actor.firstName === "Zack" || actor.firstName === "Kelly") {
      return actor;
    }
  });
	*/