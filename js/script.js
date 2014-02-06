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

	//Hantera Detaljer
	$('.details').on('click', function(event){

		var targetObj = $(event.target).parents();
		var postDiv = targetObj[3];

		$(postDiv).find('.detail-wrap').toggleClass('show');

		event.preventDefault();

	});


	
	//Flygplan --> 'VISKA' @ huvudformulär
	$('.tweet-btn').mouseover(function(event) {
 		t = event.target;
 		if(t.tagName == 'INPUT') {
 			$(t).val('Viska');
 			$(t).css('color', '#fff');
 		}
	})
	.mouseout(function(){
		$(t).val('');
	});

	//Flygplan --> 'VISKA' @ feed-formilär
	var planeBtn = $('.test');

	planeBtn.mouseover(function(event){

		t = event.target;
		tParent = $(t).parent();

		if(t.tagName == 'INPUT') {
			$(t).val('Viska');
			$(t).css('color', '#fff');

			plane = tParent.find('.ion-paper-airplane');
			$(plane).css('z-index', '-10');
		}
	})
	.mouseout(function(){
		$(t).val('');
		$(plane).css('z-index', '');
	});
	

	// BILDCENTRERING
	$(function(){
	    centerImageVertically();
	    $(window).resize(function() {
	        centerImageVertically();
	    });
	    function centerImageVertically() {
	        var imgframes = $('.profile-pic img');
	        imgframes.each(function(i){
	            var imgVRelativeOffset = ($(this).height() - $(this).parent().height()) / 2;
	            $(this).css({
	                'position': 'absolute',
	                'top': imgVRelativeOffset * -1
	            });
	        });
	    }
	});


	//MENY

	

	$('.mobile-nav-btn').on('click', function(){
		mobWrap = $('.mobile-nav-wrap');
		mobNav = $('.mobile-nav');


		$(mobWrap).fadeToggle();
		$(mobNav).toggleClass('fade-color');
		$('.mobile-nav-btn').toggleClass('btn-color');

	});




});