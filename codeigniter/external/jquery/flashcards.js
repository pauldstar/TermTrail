$(document).ready(function()
{
	PAGE_CONTENT.initPageContentGrid();
	PAGE_CONTENT.$textField.keypress(PAGE_CONTENT.addFlashCard);
});	

var PAGE_CONTENT =
{
	$pageGrid: '',
	$textField: $('#text-field'),
	
	initPageContentGrid: function()
	{
		PAGE_CONTENT.$pageGrid = new Muuri('.div-grid',  
		{
			dragEnabled: false,
			items: '.div-gridbox-wrapper',
			layout: { alignBottom: true }
		})
	},
	
	addFlashCard: function(section, fullItemIdJson)
	{
		if (event.which === 13)
		{ // pressed ENTER key
			event.preventDefault();
			var flashText = $(this).val();
			if ( ! flashText) return;
			var ajaxUrlSegments = 'flashcards/set_and_get_new_card/';
			var cardPost = $.post(HELPER.callController(ajaxUrlSegments), {text: flashText});
			
			$(this).val('');
			$(this).select();
		
			cardPost.done(function(data) 
			{ 
				var cardView = JSON.parse(data);
				element = document.createElement('div');
				element.innerHTML = cardView;
				PAGE_CONTENT.$pageGrid.add(element.firstChild);
			});
		}
	}
}

var HELPER = 
{
	callController: function(segments)
	{
		return siteUrl+'/'+segments;
	},
}