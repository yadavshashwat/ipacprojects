var email_val = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var phone_val = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
var numeric_val = /^\d+$/;
var alphanumeric_val = /^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/;
var date_val = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
var regExp = /[A-Za-z0-9_~\-!@#\$%\^&\*\(\)]+$/i;
var regExpnumbers = "/[0-9]/g;";
var whitespaces_val = /^\s+$/;
var alphaspace = /^[a-zA-Z ]*$/;
var format_spe = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;


$(function(){

	$("#regiForm").on("submit", function(e) {
		e.preventDefault();
		$(".loaderPopup").fadeIn(); 
		var name = $("#regName").val();
		var gender = $("#regGender").val();
		var dobMonth = $("#regMonth").val();
		var dobDay = $("#regDay").val();
		var dobYear = $("#regYear").val();
		var mobile = $("#regMobile").val();
		var whatsapp = $("#regWhatsapp").val();
		var email = $("#regEmail").val();
		var state = $("#regState").val();
		var district = $("#regDistrict").val();
		var studType = $("#regStudType").val();
		var collState = $("#regCollgState").val();
		var regCollgDistrict = $("#regCollgDistrict").val();
		var collName = $("#regCollName").val();

		var personality_1 = $("#personality_1").val();
		var personality_2 = $("#personality_2").val();

		if(!validateblanktext(name)) {
			$("#regName").parent().find('.blank').fadeIn();
			$("#regName").focus();
			$(".loaderPopup").fadeOut();
			return false;
		}else if(format_spe.test(name)) {
			$("#regName").parent().find('.blank').fadeIn();
			$("#regName").focus();
			$(".loaderPopup").fadeOut();
			return false;
		}
		
		if(!validateblanktext(gender)) {
			$("#regGender").parent().find('.blank').fadeIn();
			$("#regGender").focus();
			$(".loaderPopup").fadeOut();
			return false;
		}

		if((!validateblanktext(dobMonth)) || (!validateblanktext(dobDay)) || (!validateblanktext(dobYear))) {
			$("#regDay").parent().find('.blank').fadeIn();
			$("#regDay").focus();
			$(".loaderPopup").fadeOut();
			return false;
		}

		if(!validateblanktext(mobile)) {
			$("#regMobile").parent().find('.blank').fadeIn();
			$("#regMobile").focus();
			$(".loaderPopup").fadeOut();
			return false;
		} else if(!phone_val.test(mobile)) {
			$("#regMobile").parent().find('.valid').fadeIn();
			$("#regMobile").focus();
			$(".loaderPopup").fadeOut();
			return false;
		}

		
		if(!validateblanktext(whatsapp)) {
			$("#regWhatsapp").parent().find('.blank').fadeIn();
			$("#regWhatsapp").focus();
			$(".loaderPopup").fadeOut();
			return false;
		} else if(!phone_val.test(whatsapp)) {
			$("#regWhatsapp	").parent().find('.valid').fadeIn();
			$("#regWhatsapp").focus();
			$(".loaderPopup").fadeOut();
			return false;
		}
		

		if(!validateblanktext(email)) {
			$("#regEmail").parent().find('.blank').fadeIn();
			$("#regEmail").focus();
			$(".loaderPopup").fadeOut();
			return false;
		}
		
		
		if(studType == 1){
			if(collState == ""){
				$("#regCollgState").parent().find('.blank').fadeIn();
				$("#regCollgState").focus();
				$(".loaderPopup").fadeOut();
				return false;
			}

			if(regCollgDistrict == "0" || regCollgDistrict == ""){
				$("#regCollgDistrict").parent().find('.blank').fadeIn();
				$("#regCollgDistrict").focus();
				$(".loaderPopup").fadeOut();
				return false;
			}
			//alert(collName);
			if(collName == ""){
				$("#regCollName").parent().find('.blank').fadeIn();
				$("#regCollName").focus();
				$(".loaderPopup").fadeOut();
				return false;
			}
		}else{
			if(!validateblanktext(state)) {
				$("#regState").parent().find('.blank').fadeIn();
				$("#regState").focus();
				$(".loaderPopup").fadeOut();
				return false;
			}

			if(!validateblanktext(district)) {
				$("#regDistrict").parent().find('.blank').fadeIn();
				$("#regDistrict").focus();
				$(".loaderPopup").fadeOut();
				return false;
			}
		}
		var profile_pic = $("#profile_pic").val()	
		if(profile_pic == ""){
			/*$("#profile_pic").parent().parent().find('.blank').html('Please upload your profile pic.');
			$("#profile_pic").parent().parent().find('.blank').fadeIn();
			$("#profile_pic").focus();
			return false;*/
		}else{
			var fileExtension = ['png', 'jpg', 'jpeg'];
	        if ($.inArray($("#profile_pic").val().split('.').pop().toLowerCase(), fileExtension) == -1) {
	            //alert("Only formats are allowed : "+fileExtension.join(', '));
	            $("#profile_pic").val('');
	            $("#profile_pic").parent().find('.blank').html('Only PNG, JEG or JPEG files supported.');
	            $("#profile_pic").parent().find('.blank').fadeIn();
				$("#profile_pic").focus();
				$(".loaderPopup").fadeOut();
				return false;
	        }
		}

		if(personality_1 != ""){
			if(format_spe.test(personality_1)) {
				$("#personality_1").parent().find('.blank').fadeIn();
				$("#personality_1").focus();
				$(".loaderPopup").fadeOut();
				return false;				
			}
		}

		if(personality_2 != ""){
			if(format_spe.test(personality_2)) {
				$("#personality_2").parent().find('.blank').fadeIn();
				$("#personality_2").focus();
				$(".loaderPopup").fadeOut();
				return false;
			}
		}
				
		var formData = new FormData($("form#regiForm")[0]);
		// alert("random");
		 
		$.ajax({
			url: baseurl + "register/submit_register",
			data: formData,
			dataType: "JSON",
			type: "POST",
			cache: false,
            contentType: false,
            processData: false,  
			success: function(result) {
				$(".loaderPopup").fadeOut();
				if(result.status == "success"){
					// $('.otpPopup').fadeIn();
					// $('.resendOtp').delay(20000).fadeIn();
					window.location.href = baseurl+"result";
					console.log("1")	
					console.log(baseurl)
				}else if(result.status == 'php_error'){
					window.href.location = baseurl + "result";
					console.log("2")	
					console.log(baseurl)
				}else if(result.status == 'php_error'){
					console.log("3")
					/*console.log(result["msg"]);
					console.log(result.msg);*/
					$.each(result["msg"], function(i, v) {
                        $("#"+i+"_error").html(v);
                        $("#"+i+"_error").fadeIn();
                    });
				}else{
					console.log("4")
					//alert(result.msg);

					$(".phpError").html(result.msg);
					$(".phpError").fadeIn();
				}
			}
		});
	});


	$(".mobileNumber").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

	function validateblanktext(stringtext) {
	    if(stringtext == "" || whitespaces_val.test(stringtext) || stringtext == 0) {
	        return false;
	    } else {
	        return true;
	    }
	}

	$(".formField input").on("keyup",function(event){
		var counttext = $(this).val();
		if(counttext == ''){
			$(this).removeClass('notBlank');
			$(this).parent().find('.blank').fadeIn();
		}else{
			$(this).addClass('notBlank');
			$(this).parent().find('.blank').fadeOut();
		}
	});

	$(".formField select").on("change",function(event){
		var counttext = $(this).val();
		if(counttext == 0){
			$(this).removeClass('notBlank');
			$(this).parent().find('.blank').fadeIn();
		}else{
			$(this).addClass('notBlank');
			$(this).parent().find('.blank').fadeOut();
		}
	});


	$('.monthDOB').on('change', function(){
		var addOption = "";
		var month = $(this).val();
		
		if(month === '2'){
			dayCount = 29;
		}if(month === '4' || month === '6' || month === '9' || month === '11'){
			dayCount = 30;
		}if(month === '1' || month === '3' || month === '5' || month === '7' || month === '8' || month === '10' || month === '12'){
			dayCount = 31;
		}
		// alert(addOption);
		// addOption = "";
		// addOption = addOption + '<option value='0'>'+ i +'</option>';
		for(var i = 1; i<=dayCount; i++){
			addOption = addOption + '<option value=' + i + '>'+ i +'</option>';
			// console.log(dayCount + "---" + addOption);
		}
		$('.dayDOB').removeClass('disable');
		$('.dayDOB').html("<option value='0'>Day</option>");
		$('.dayDOB').append(addOption);

	});

	$('.dayDOB').on('change', function(){
		var addOptionYear = "";
		var year = 2005;
		$('.yearDOB').removeClass('disable');
		for(var i = 1; i<=100; i++){
			
			addOptionYear = addOptionYear + '<option value=' + year + '>'+ year +'</option>';
			year--;
		}
		$('.yearDOB').append(addOptionYear);
	});

	

	$(".mobileNOInout").on("keyup",function(event){
		var counttext = $(this).val();
		// console.log(counttext);
		if($('.sameMobile input').is(':checked')){
			$('.whatsappNOInout').val(counttext);
		}		
	});

	$('.sameMobile input').click(function(){
		if(!$(this).is(':checked')){
			$('.whatsappNOInout').val('');
			$('.whatsappNOInout').focus();
			$("#regWhatsapp").prop("readonly", false);
		}else{
			$('.whatsappNOInout').val($(".mobileNOInout").val());
			$("#regWhatsapp").prop("readonly", true);
		}
	});

	$("#regState").on("change",function(event){
		var state_id = $(this).val();
		//alert(baseurl);
		if(state_id!='0'){
			$.ajax({
				url: baseurl + "register/get_all_district_in_state",
				data: {'state_id':state_id},
				dataType: "JSON",
				type: "POST",				
				success: function(result) {
					$html = '<option value="0">Select District</option>';
				  	$.each(result, function(k, v) {
				  		$html += "<option value='"+v.id+"'>"+v.district_name+"</option>"
				    	//console.log(v.district_name);
				  	});
				  	$('#regDistrict').empty().append($html);
				}
			});
		}else{
			$html = '<option value="0">Select District</option>';
			$('#regDistrict').empty().append($html);
		}
	});

	$("#regStudType").on("change",function(event){
		var type = $(this).val();
		if(type == '1'){
			$("#regCollgState").parent().parent().show();
			$("#regCollgDistrict").parent().parent().show();
			$("#regCollName").parent().parent().show();

			$("#regState").parent().parent().hide();
			$("#regDistrict").parent().parent().hide();			
			
		}else{			
			$("#regCollgState").parent().parent().hide();
			$("#regCollgDistrict").parent().parent().hide();
			$("#regCollName").parent().parent().hide();
			$("#regState").parent().parent().show();
			$("#regDistrict").parent().parent().show();
		}
	});


	$("#regCollgState").on("change",function(event){
		var state_id = $(this).val();

		var availableTags = [];
		$( "#regCollName" ).autocomplete({
          	source: availableTags
        });

		if(state_id!='0'){
			$.ajax({
				url: baseurl + "register/get_all_district_in_state",
				data: {'state_id':state_id},
				dataType: "JSON",
				type: "POST",				
				success: function(result) {
					$html = '<option value="0">Select District</option>';
				  	$.each(result, function(k, v) {
				  		$html += "<option value='"+v.id+"'>"+v.district_name+"</option>"
				    	//console.log(v.district_name);
				  	});
				  	$('#regCollgDistrict').empty().append($html);					
				}
			});
		}else{
			$html = '<option value="0">Select District</option>';
			$('#regDistrict').empty().append($html);
		}
	});

	$("#regCollgDistrict").on("change",function(event){		 
		 var state_id = $("#regCollgState").val();
		 var district_id = $(this).val();
		//alert(baseurl);
		var availableTags = [];
		if(state_id!='0'){
			$.ajax({
				url: baseurl + "register/get_all_collages_in_state_district",
				data: {'state_id':state_id,'district_id':district_id},
				dataType: "JSON",
				type: "POST",				
				success: function(result) {
					$html = '';
				  	$.each(result, function(k, v) {
				  		$html += "<option>"+v.collage_name+"</option>";
			  		 	availableTags.push(v.collage_name);
				    	//console.log(v.district_name);
				  	});
				  	//$('#regCollName_list').empty().append($html);
				  	$( "#regCollName" ).autocomplete({
		              source: availableTags
		            });
				}
			});
		}else{
			$html = '<option value="0">Select District</option>';
			$('#regDistrict').empty().append($html);
		}
	});



	/*$("#otp_submit").on("submit", function(e) {
		e.preventDefault();
		//window.location.href = baseurl+"result";
		$("#otp_submit .error").fadeOut();
		var user_otp = $("#user_otp").val();
		if(!validateblanktext(user_otp)) {
			$("#user_otp_error").html("OTP is required.")
			$("#user_otp_error").fadeIn();
			$("#user_otp").focus();
			return false;
		}

		var formData = new FormData($("form#otp_submit")[0]);
		//$('.otpPopup').fadeIn();
		
		$.ajax({
			url: baseurl + "register/verify_otp",
			data: formData,
			dataType: "JSON",
			type: "POST",
			cache: false,
            contentType: false,
            processData: false,  
			success: function(result) {
				if(result.status == "success"){
					//$('.otpPopup').fadeIn();
					window.location.href = baseurl+"result";
				}else{
					$("#otp_submit .error").fadeIn();
					$("#user_otp_error").html(result.msg);
				}
			}
		});
	});

	$("#pta_form").on("submit", function(e) {
		e.preventDefault();
		var mobile = $("#pta_mobile_number").val();
		$("#pta_form .error").fadeOut();
		if(!validateblanktext(mobile)) {
			$('#blank').fadeIn();
			$("#pta_mobile_number").focus();
			return false;
		} else if(!phone_val.test(mobile)) {
			$('#valid').fadeIn();
			$("#pta_mobile_number").focus();
			return false;
		}

		var formData = new FormData($("form#pta_form")[0]);

		$.ajax({
			url: baseurl + "register/check_PTA_user",
			data: formData,
			dataType: "JSON",
			type: "POST",
			cache: false,
            contentType: false,
            processData: false,  
			success: function(result) {
				if(result.status == "success"){
					$('.otpPopup').fadeIn();
					$('.resendOtp').delay(20000).fadeIn();
				}else{
					
					$("#custom_error").html(result.msg);
					$("#custom_error").fadeIn();
				}
			}
		});
	});*/

	$("#profile_pic").change(function () {
        var fileExtension = ['png', 'jpg', 'jpeg'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            //alert("Only formats are allowed : "+fileExtension.join(', '));
            $("#profile_pic").val('');
            $("#profile_pic").parent().find('.blank').html('Only PNG, JEG or JPEG files supported.');
            $("#profile_pic").parent().find('.blank').fadeIn();
			$("#profile_pic").focus();
        }
    });

    $("#pta_form1").on("submit", function(e) {
        e.preventDefault();
        var mobile = $("#pta_mobile_number").val();
        $("#pta_form1 .error").fadeOut();
        if(!validateblanktext(mobile)) {
            $('#blank').fadeIn();
            $("#pta_mobile_number").focus();
            return false;
        } else if(!phone_val.test(mobile)) {
            $('#valid').fadeIn();
            $("#pta_mobile_number").focus();
            return false;
        }

        var formData = new FormData($("form#pta_form1")[0]);

        $.ajax({
            url: baseurl +"register/check_user",
            data: formData,
            dataType: "JSON",
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,  
            success: function(result) {
                if(result.status == "success"){
                    $('.otpPopup').fadeIn();
                }else{                            
                    $("#custom_error").html(result.msg);
                    $("#custom_error").fadeIn();
                }
            }
        });
    }); 


    $("#otp_submit").on("submit", function(e) {
        e.preventDefault();
        //window.location.href = baseurl+"result";
        $("#otp_submit .error").fadeOut();
        var user_otp = $("#user_otp").val();
        if(!validateblanktext(user_otp)) {
            $("#user_otp_error").html("OTP is required.")
            $("#user_otp_error").fadeIn();
            $("#user_otp").focus();
            return false;
        }

        var formData = new FormData($("form#otp_submit")[0]);
        //$('.otpPopup').fadeIn();
        
        $.ajax({
            url: baseurl +"register/verify_otp",
            data: formData,
            dataType: "JSON",
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,  
            success: function(result) {
                if(result.status == "success"){
                    //location.reload(); 
                    window.location.href = baseurl+result.msg; 
                    //window.location.replace("<?php echo base_url(); ?>"+result.msg);                           
                }else{
                    $("#otp_submit .error").fadeIn();
                    $("#user_otp_error").html(result.msg);
                }
            }
        });
    });
});

