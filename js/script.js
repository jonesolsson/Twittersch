$( document ).ready(function() {


	

	//Styr vart "Visa Konversation" ska synas
	var pDiv = $('.post');

	for(var i = 0; i < pDiv.length; i++) {
		
		if($('.is-reply').closest(pDiv[i]).length == 0 && $('.reply-post').closest(pDiv[i]).length == 0) {

			$(pDiv[i]).find('.show-conversation').html('');

		}
	}

	for(var i = 0; i < pDiv.length; i++) {

		if($('.reply-post').closest(pDiv[i]).length == 0) {
			$(pDiv[i]).find('.show-conversation').addClass('modalLink');
			$(pDiv[i]).find('.show-conversation').attr('href', '#modal1');
		}

	}



	//Hantera Visa/dölj konversation
	$('.show-conversation').on('click', function(event){

		var txt = $(this).html();

		var targetObj = $(event.target).parents();
		var postDiv	  = targetObj[3];

		if($('.reply-post').closest(postDiv).length == 0) {
			


		} else {

			$(postDiv).toggleClass('reply-post-color');
			$(postDiv).find('.reply-post').toggleClass('show');
			$(postDiv).find('.reply-form').toggleClass('show');

			if(txt == 'Visa Konversation') {
				$(this).html('Dölj Konversation');
			} else {
				$(this).html('Visa Konversation');
			}


		}

		event.preventDefault();

	});


	//Hantera Svara-knappen
	$('.answer-to-post').on('click', function(event){

		var targetObj = $(event.target).parents();
		var postDiv = targetObj[3];

		$(postDiv).find('.reply-form').toggleClass('show');

		$(postDiv).toggleClass('reply-post-color');	

		event.preventDefault();

	});




});