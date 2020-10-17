$(function(){

	$('.popUpOverlayClose').on('click touch', function(event) {
		if (!$(event.target).parents().addBack().is('.popupData')) {
	    	$('.popup').fadeOut();
	  	}
	});	

	$('.closePopup').on("click", function(){
		$('.popup').fadeOut();
	});
	
	window.fbAsyncInit = function() {
        FB.init({appId: 1006900869478204, status: true, cookie: true,
                 xfbml: true});
        };

     $('.seeMore').on('click touch', function(event) {
     	$('.mobileHide').slideToggle();
     });	

	
	$('.fbImg').click(function (e) {
        FB.ui({
            quote:'Gandhiji, in his Constructive Programme (https://goo.gl/Qpphxj), had outlined the blueprint for independent India. ' +
			'Let\'s spread his vision and formulate an actionable agenda for India in his 150th Birth Anniversary year. Join #NationalAgendaForum',
            method: 'share',
            mobile_iframe: true,
            href: 'http://www.indianpac.com/naf/'
        });
    });
    
    $('.voteBtn, .regiBtn').on('click touch', function(event) {
    	$('.setPopup').fadeIn();
    	// $(this).parent().find('.setAgendaPopup').delay(2000).fadeOut();
    });

    // $('.voteBtn, .btn').on('click touch', function(event) {
    // 	$('.setPopup').fadeIn();
    // });

	
	/*$('.ptaMember .btn').on('click touch', function(event) {
		$('.popup').fadeIn();
		$('.popup').delay(60000).fadeOut();
	});*/

	// $(".ptaMember .mobileNumber").on("keyup",function(event){
	// 	var counttext = $(".ptaMember .mobileNumber").value;
	// 	console.log(counttext);
	// });

	$('.resultBtn').on('click touch', function(event) {
		$('#pta_form1').fadeIn();
	});

	$(document).on('click touch', function(event) {
        if (!$(event.target).parents().addBack().is('.registerMobile')) {
            
          }
    });    
    $(document).on('click touch', function(event) {
        if (!$(event.target).parents().addBack().is('.registerMobile1')) {
            
          }
    });    	

	$('#profile_pic').change(function(e){
        var fileName = e.target.files[0].name;
        $('.fileName').text(fileName);
        $('.fileName').attr('title', fileName);
        // alert('The file "' + fileName +  '" has been selected.');
    });

    $('.seeResult').on('click touch', function(event) {
		$('.resultPopup').fadeIn();
	});

	$('.home-wrapper .registerMobile .viewResult').on('click touch', function(event) {
		$("#pta_form1 .error").fadeOut();
		$("#pta_mobile_number").val('');
		$('.registerPopup').fadeIn();
	});
	

	$('.openPopup').on('click touch', function(event) {
		var idName = $(this).attr('id');
		$('.infoDataPopup').fadeIn();
		$('.infoIn').fadeOut();
		$('.' + idName + 'Info').delay(500).fadeIn();
	});

	$('.aboutNAF span').on('click touch', function(event) {
		var idP = $(this).attr('id');
		$('.infoDataHome').fadeIn();
		$('.infoIn').fadeOut();
		$('.' + idP + 'Info').delay(500).fadeIn();
	});


	$('.shrBtn').on('click touch', function(event) {
		$(this).parent().find('.shareDiv').fadeToggle();
	});
	
	$('.shrBtnResult').on('click touch', function(event) {
        $(this).parent().find('.shareDivResult').fadeToggle();
    });
	

	$('.topSeeResult').on('click touch', function(event) {
		$('.registerMobile form').slideToggle();
	});

	$(document).on('click touch', function(event) {
		if (!$(event.target).parents().addBack().is('.shrBtn')) {
	    	$('.shareDiv').fadeOut();
	  	}
	});	
	
	$(document).on('click touch', function(event) {
        if (!$(event.target).parents().addBack().is('.shrBtnResult')) {
            $('.shareDivResult').fadeOut();
        }
    });

});

