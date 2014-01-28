$( document ).ready(function() {
    

	//Visa/dölj konversation
	$('.show-conversation').on('click', function(event){

		var targetObj = $(event.target).parent();
		var postDiv = targetObj[0];

		$(postDiv).find('.reply-post').toggleClass('show')

		$(postDiv).find('.reply-form').toggleClass('show');

		var txt = $(this).html();

		if(txt == 'Visa Konversation') {
			$(this).html('Dölj Konversation');
		} else {
			$(this).html('Visa Konversation');
		}

		event.preventDefault();

	});

	$('.answer-to-post').on('click', function(event){

		var targetObj = $(event.target).parents();
		var postDiv = targetObj[3];

		$(postDiv).find('.reply-form').toggleClass('show');

		event.preventDefault();

	});


});