$( document ).ready(function() {


	var test = $('.post');

	for(var i = 0; i < test.length; i++) {
		
		if($('.reply-post').closest(test[i]).length == 0) {

			$(test[i]).find('.show-conversation').html('');

		}

	}

	//Visa/dölj konversation
	$('.show-conversation').on('click', function(event){

		var txt = $(this).html();

		var targetObj = $(event.target).parents();
		postDiv = targetObj[3];

/*		if($('.reply-post').closest(postDiv).length == 0) {
			
			var linkObj = $(event.target);
			link = linkObj[0];

			$(link).attr('href', 'www.hej.com');
	
		} */


		$(postDiv).toggleClass('reply-post-color');	

		$(postDiv).find('.reply-post').toggleClass('show')

		$(postDiv).find('.reply-form').toggleClass('show');
		

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

		$(postDiv).toggleClass('reply-post-color');	

		event.preventDefault();

	});




});