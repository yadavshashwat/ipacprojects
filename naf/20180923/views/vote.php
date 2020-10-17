<?php 

//echo $_COOKIE['language'];
 
/*if(!isset($_COOKIE['language'])){
	
$_COOKIE['language']="en";
$langcookie=$_COOKIE['language'];	
}

else {
	$langcookie=$_COOKIE['language'];	
}

*/
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include('head_element.php'); ?>
        <style>
       .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
        } 
        </style>
        <title>NAF</title>
        <meta name="description" content="" />
    <!--     <link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
    </head>
    <body class="vote ipac_edit_body">
        <div class="backImg"></div>
        <div class="wrapper">
            <?php include('header.php'); ?>
                <div class="homeMain voteMain">
                    <form name="vote_form" id="vote_form" method="POST" autocomplete="off">
                    <input type="hidden" name="session_id" id="session_id" value="<?php echo $session_id?>">
                    <input type="hidden" name="referral_code" id="referral_code" value="<?php echo $referral_code?>">
                    <input type="hidden" name="referral_owner_id" id="referral_owner_id" value="<?php echo $referral_owner_id?>">
                    <div class="headSearch ">
                        <div class="breadcrums">
                            <ul>

                                <?php


                                $active = 0;
                                if (isset($_COOKIE['step_agenda']) && isset($_COOKIE['step_vote'])) {
                                    if ($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "0") {
                                        $href1 = "vote";
                                        $href2 = "agenda";
                                        $step1 = "Choose the Leader";
                                        $step1_hi = "नेता चुनें";
                                        $step2 = "Set the Agenda";
                                        $step2_hi = "एजेंडा तय करें";
                                        $active = "0";
                                    } else if ($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "1") {
                                        $href1 = "vote";
                                        $href2 = "agenda";
                                        $step1 = "Choose the Leader";
                                        $step1_hi = "नेता चुनें";
                                        $step2 = "Set the Agenda";
                                        $step2_hi = "एजेंडा तय करें";
                                        $active = "0";
                                    } else if ($_COOKIE['step_agenda'] == "1" && $_COOKIE['step_vote'] == "0") {
                                        $href1 = "agenda";
                                        $step1 = "Set the Agenda";
                                        $step1_hi = "एजेंडा तय करें";
                                        $href2 = "vote";
                                        $step2 = "Choose the Leader";
                                        $step2_hi = "नेता चुनें";
                                        $active = "1";

                                    } else {
                                        $href1 = "vote";
                                        $href2 = "agenda";
                                        $step1 = "Choose the Leader";
                                        $step1_hi = "नेता चुनें";
                                        $step2 = "Set the Agenda";
                                        $step2_hi = "एजेंडा तय करें";
                                        $active = "1";

                                    }
                                }else{
                                        $href1 = "vote";
                                        $step1 = "Choose the Leader";
                                        $step1_hi = "नेता चुनें";
                                        $href2 = "agenda";
                                        $step2 = "Set the Agenda";
                                        $step2_hi = "एजेंडा तय करें";
                                        $active = "0";

                                }
                                ?>



                                <a href="<?php echo base_url().$href1?>"><li class="transition breadcrumsActive">
                                    <div class="topFlag"></div>
                                    <?php if($langcookie=="en"){ ?>
                                    <span>Step 1</span> <?php echo $step1 ?>
                                    <?php } ?>
                                    <?php if($langcookie=="hi"){ ?>
                                    <span>स्टेप-1</span> <?php echo $step1_hi ?>
                                    <?php } ?>
                                    <div class="bottomFlag"></div>
                                </li></a><li class="transition <?php if ($active == "1"){echo 'breadcrumsActive';}?>">
                                    <div class="topFlag"></div>
                                    <?php if($langcookie=="en"){ ?>
                                    <span>Step 2</span><?php echo $step2 ?>
                                    <?php }?>
                                    <?php if($langcookie=="hi"){ ?>
                                    <span>स्टेप-2</span> <?php echo $step2_hi ?>
                                    <?php }?>
                                     <div class="bottomFlag"></div>
                                </li><li class="transition">
                                    <div class="topFlag"></div>
                                    <?php if($langcookie=="en"){ ?>
                                    <span>Step 3</span>Campaign for India
                                    <?php }?>
                                    <?php if($langcookie=="hi"){ ?>
                                    <span>स्टेप-3</span> राष्ट्र के लिए अभियान  
                                    <?php }?>
                                     <div class="bottomFlag"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="topInfo">
<!--                            <p>Vote for the Leader best suited to adopt and execute the agenda.</p>-->
						<?php if($langcookie=="en"){ ?>
                            <p>If you don’t find leader of your choice in the list, then please ADD NEW LEADER.</p>
                        <?php }?>
                        <?php if($langcookie=="hi"){ ?>
                        	<p>इस लिस्ट में अगर आपकी पसंद का नेता नहीं है तो कृपया नए नेता का नाम जोड़ें </p>
                        <?php }?>
                        </div>
                    
                    <?php include('includes/leaders_list.php'); ?> 
                        <div class="g-recaptchaOut">
                            <!-- <div class="g-recaptcha" data-sitekey="<?php echo $site_key?>"></div> -->
                            <!-- Anwser this equation  -->
                            <!-- <p><?php echo $math_captcha_question;?></p> -->
                            <p><?php echo $captcha['image'];?></p><input type="text" name="captca_code" id="captca_code" value="" class="">
                        </div>


                        <?php

                        if (isset($_COOKIE['step_agenda']) && isset($_COOKIE['step_vote'])){
                            if($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "0"){
                                if($langcookie=="en"){
                                    echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                                    echo  "<input class='Proceed transition disabled' type='submit'  value='Continue and Select the Agenda'>";
                                    echo "</div>";
                                }
                                if($langcookie=="hi") {
                                    echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                                    echo  "<input class='Proceed transition disabled' type='submit'  value='जारी रखें और एजेंडा का चयन करें'>";
                                    echo "</div>";

                                }
                            }else if($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "1"){

                                if($langcookie=="en"){
                                    echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                                    echo  "<input class='Proceed transition disabled' type='submit'  value='Continue and Select the Agenda'>";
                                    echo "</div>";
                                }
                                if($langcookie=="hi") {
                                    echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                                    echo  "<input class='Proceed transition disabled' type='submit'  value='जारी रखें और एजेंडा का चयन करें'>";
                                    echo "</div>";
                                }

                            }else if($_COOKIE['step_agenda'] == "1" && $_COOKIE['step_vote'] == "0"){
                                if($langcookie=="en"){
                                    echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                                    echo  "<input class='Proceed transition disabled' type='submit'  value='Confirm and Submit'>";
                                    echo "</div>";
                                }
                                if($langcookie=="hi") {
                                    echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                                    echo "<input class='Proceed transition disabled' type='submit'  value='पुष्टि कर जमा करें' >";
                                    echo "</div>";
                                }

                            }else{
                                if($langcookie=="en"){
                                    echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                                    echo  "<input class='Proceed transition disabled' type='submit'  value='Confirm and Submit'>";
                                    echo "</div>";
                                }
                                if($langcookie=="hi") {
                                    echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                                    echo "<input class='Proceed transition disabled' type='submit'  value='पुष्टि कर जमा करें' >";
                                    echo "</div>";
                                }

                            }
                        }else{
                            if($langcookie=="en"){
                                echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                                echo  "<input class='Proceed transition disabled' type='submit'  value='Confirm and Set Agenda'>";
                                echo "</div>";
                            }
                            if($langcookie=="hi") {
                                echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                                echo "<input class='Proceed transition disabled' type='submit'  value='पुष्टि कर एजेंडा सेट करें' >";
                                echo "</div>";
                            }
                        }

                        ?>


                        <div class="error" id="validation_error"></div>
                    </div>
                    </form>
                </div>
            <?php include('footer.php'); ?>  
            <script src='https://www.google.com/recaptcha/api.js'></script>  
            <script src="<?php echo base_url()?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
            <script src="<?php echo base_url()?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        </div>
    </body>
    <script>
        $(window).on("scroll", function() {
            var content_height = $(document).height();
            var content_scroll_pos = $(window).scrollTop();
            var percentage_value = content_scroll_pos * 100 / content_height;

            if(percentage_value >= 80 && ( $(window).width() < 640))
            {
                document.getElementById('submitAgenda').style.position="relative";

//        document.getElementById('hiddensubmitAgenda').style.visibility="visible";
                //      document.getElementById('hiddensubmitAgenda').style.display="block";
                //     document.getElementById('submitAgenda').style.visibility="hidden";

            }
            if (percentage_value < 80 && ($(window).width() < 640))
            {

                document.getElementById('submitAgenda').style.position="fixed";
                document.getElementById('submitAgenda').style.top="90%";
                document.getElementById('submitAgenda').style.bottom="0px";
                document.getElementById('submitAgenda').style.visibility="visible";
                document.getElementById('submitAgenda').style.backgroundColor="#d6d6d6";
                //     document.getElementById('hiddensubmitAgenda').style.visibility="hidden";
                //   document.getElementById('hiddensubmitAgenda').style.display="none";

            }


        });

    </script>


    <script type="text/javascript">        
        var phone_val = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;   
        var whitespaces_val = /^\s+$/;
        var format_spe = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?0-9]/;

        $( document ).ready(function() {
            var availableTags = [];
            <?php
                foreach ($other_leaders as $key => $value) { ?>
                    availableTags.push("<?php if($langcookie=="en"){ echo $value['full_name']; } if($langcookie=="hi"){ echo $value['full_name_hindi']; } ?>");
            <?php }?>
			
			

            $( "#new_leader" ).autocomplete({
              source: availableTags
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


            $('.addNew').on('click touch', function(event) {
                // alert("fb");
                $(this).find('.addLeaderName').fadeIn();
            });

            $('.leadersIn').on('click touch', function(event) {
                $('.leadersIn').removeClass('selectedVote');
                $(this).addClass('selectedVote');
                $('.submitAgenda input').removeClass('disabled');
                if($(this).find('.checkRadio').is(':checked')) { 

                }
            });

            $('.vote_leader').on('click touch', function(event) {
                grecaptcha.reset();
                var leader_id = $(this).data("id");
                // var leaderImg = $(this).parent().parent().find('.leaderImg img').attr('src');
                // console.log(leaderImg);


                $("#selected_leader_img").html("");
                $("#leader_name").html("");
                $("#leader_id").val(''); 

                if(leader_id != '' && leader_id != 0){
                    $.ajax({
                        url: "<?php echo base_url(); ?>vote/getLeaderInfo",
                        data: {'leader_id':leader_id},
                        type: "POST",
                        dataType: "JSON",    
                        success: function(result) {
                            var html = '';
                            if(result.image_path!=''){
                              html = '<img src="<?php echo base_url(); ?>assets/images/'+result.image_path+'" id="leader_img" alt="'+result.full_name+'" title="'+result.full_name+'">';
                            }
                            //alert(html);
                            $("#selected_leader_img").html(html);
                            $("#leader_name").html("<h4>"+result.full_name+"</h4>");
                            $("#leader_id").val(result.id);                            
                            $('.votePupup').fadeIn();
                        }
                    });
                }            
            });

            $('.addNew .btn').on('click touch', function(event) {
                grecaptcha.reset();
                $('.addNewPopup').fadeIn();
            });  

            $("#vote_form").on("submit", function(e) {                
                e.preventDefault();

                var captca_code = $("#captca_code").val();
                if(!validateblanktext(captca_code)) {
                    $("#validation_error").html("Please provide captcha code.");
                    $("#validation_error").fadeIn();
                    return false;
                }else{
                    $("#validation_error").fadeOut();
                }

                var radioValue = $("input[name='vote']:checked").val();
                if(radioValue == "on"){

                    var new_leader = $("#new_leader").val();
                    if(!validateblanktext(new_leader)) {
                        $("#validation_error").html("Please choose your leader.");
                        $("#validation_error").fadeIn();
                        return false;
                    } 
                }

                // var formData = new FormData($("form#vote_form")[0]);
                if(localStorage.getItem('referral_code') == undefined || localStorage.getItem('referral_code') == ''){
                    var referral_code = 0;
                }else{
                    var referral_code = localStorage.getItem('referral_code');
                }
                if(localStorage.getItem('referral_owner_id') == undefined || localStorage.getItem('referral_owner_id') == ''){
                    var referral_owner_id = 0;
                }else{
                    var referral_owner_id = localStorage.getItem('referral_owner_id');
                }
                var formData = new FormData($("form#vote_form")[0]);
                formData.append('referral_code', referral_code);
                formData.append('referral_owner_id', referral_owner_id);


                $.ajax({
                    url: "<?php echo base_url(); ?>vote/updateLeaderVote",
                    data: formData,
                    type: "POST",
                    dataType: "JSON",  
                    cache: false,
                    contentType: false,
                    processData: false,  
                    success: function(result) {
                        if(result.status == "fail"){                           
                            $("#validation_error").html(result.msg);
                            $("#validation_error").fadeIn();
                            return false;
                        }else{
                            window.location.href ="<?php
                                if (isset($_COOKIE['step_agenda']) && isset($_COOKIE['step_vote'])){
                                    if($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "0"){
                                        echo base_url()."agenda";
                                    }else if($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "1"){
                                        echo base_url()."agenda";
                                    }else if($_COOKIE['step_agenda'] == "1" && $_COOKIE['step_vote'] == "0"){
                                        echo base_url()."thankyou";
                                    }else{
                                        echo base_url()."thankyou";
                                    }
                                }else{
                                    echo base_url()."agenda";
                                }

                                ?>"

                            //window.location.href = "<?php //echo base_url(); ?>//register";
                        }
                    }
                });

            });



            $("#new_leader").keypress(function(event){
                var regex = new RegExp("^[a-zA-Z ]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });

            $("#vote_leader_form").on("submit", function(e) {
                //$(".error").css("display","none");
                e.preventDefault();

                if(grecaptcha.getResponse() == "") {
                    $("#validation_error").html("Please confirm you are not robot.");
                    $("#validation_error").fadeIn();
                    return false;
                }else{
                    $("#validation_error").fadeOut();
                }

                var referral_code = $("#referral_code").val();
                var referral_owner_id = $("#referral_owner_id").val();
                var formData = new FormData($("form#vote_leader_form")[0]);
                formData.append('referral_code', referral_code);
                formData.append('referral_owner_id', referral_owner_id);

                $.ajax({
                    url: "<?php echo base_url(); ?>vote/updateLeaderVote",
                    data: formData,
                    type: "POST",
                    dataType: "JSON",  
                    cache: false,
                    contentType: false,
                    processData: false,  
                    success: function(result) {
                        if(result.status == "fail"){                           
                            $("#validation_error").html(result.msg);
                            $("#validation_error").fadeIn();
                            return false;
                        }else{
                            window.location.href ="<?php
                                if (isset($_COOKIE['step_agenda']) && isset($_COOKIE['step_vote'])){
                                    if($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "0"){
                                        echo base_url()."agenda";
                                    }else if($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "1"){
                                        echo base_url()."agenda";
                                    }else if($_COOKIE['step_agenda'] == "1" && $_COOKIE['step_vote'] == "0"){
                                        echo base_url()."thankyou";
                                    }else{
                                        echo base_url()."thankyou";
                                    }
                                }else{
                                    echo base_url()."agenda";
                                }

                                ?>"

                            //window.location.href = "<?php //echo base_url(); ?>//register";
                        }
                       /* $("#leader_name").html("<h4>"+result.full_name+"</h4>");
                        $("#leader_id").val(result.id);                            
                        $('.popup').fadeIn();*/
                    }
                });
            });  

            $("#vote_new_leader_form").on("submit", function(e) {
                //$(".error").css("display","none");                
                e.preventDefault();
                var new_leader = $('#new_leader').val();
                if(new_leader ==''){
                    $("#captcha_error").html("Please provide leader name.");
                    $("#captcha_error").fadeIn();
                    return false;
                }else if(format_spe.test(new_leader)) {
                    $("#captcha_error").html("Please provide valid leader name.");
                    $("#captcha_error").fadeIn();
                    return false;
                }

                /*if(grecaptcha.getResponse() == "") {
                    $("#captcha_error").html("Please confirm you are not robot.");
                    $("#captcha_error").fadeIn();
                    return false;
                }else{
                    $("#captcha_error").fadeOut();
                }*/
                var referral_code = $("#referral_code").val();
                var referral_owner_id = $("#referral_owner_id").val();
                var formData = new FormData($("form#vote_new_leader_form")[0]);
                formData.append('referral_code', referral_code);
                formData.append('referral_owner_id', referral_owner_id);

                $.ajax({
                    url: "<?php echo base_url(); ?>vote/addNewLeader",
                    data: formData,
                    type: "POST",
                    dataType: "JSON",  
                    cache: false,
                    contentType: false,
                    processData: false,  
                    success: function(result) {
                        if(result.status == "fail"){
                            $("#captcha_error").html(result.msg);
                            $("#captcha_error").fadeIn();
                            return false;
                        }else{
                            window.location.href ="<?php
                                if (isset($_COOKIE['step_agenda']) && isset($_COOKIE['step_vote'])){
                                    if($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "0"){
                                        echo base_url()."agenda";
                                    }else if($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "1"){
                                        echo base_url()."agenda";
                                    }else if($_COOKIE['step_agenda'] == "1" && $_COOKIE['step_vote'] == "0"){
                                        echo base_url()."register";
                                    }else{
                                        echo base_url()."register";
                                    }
                                }else{
                                    echo base_url()."register";
                                }

                                ?>"

                            //window.location.href = "<?php //echo base_url(); ?>//register";
                        }

                       /* $("#leader_name").html("<h4>"+result.full_name+"</h4>");
                        $("#leader_id").val(result.id);                            
                        $('.popup').fadeIn();*/
                    }
                });
            }); 

            function validateblanktext(stringtext) {
                if(stringtext == "" || whitespaces_val.test(stringtext) || stringtext == 0) {
                    return false;
                } else {
                    return true;
                }
            }

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
                    url: "<?php echo base_url(); ?>vote/check_user",
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
                    url: "<?php echo base_url(); ?>vote/verify_otp",
                    data: formData,
                    dataType: "JSON",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,  
                    success: function(result) {
                        /*if(result.status == "success"){
                            location.reload();
                            
                        }else{
                            $("#otp_submit .error").fadeIn();
                            $("#user_otp_error").html(result.msg);
                        }*/

                        if(result.status == "success"){
                            window.location.href = "<?php echo base_url(); ?>"+result.msg;
                        }else{
                            $("#otp_submit .error").fadeIn();
                            $("#user_otp_error").html(result.msg);
                        }
                    }
                });
            });   

            $(".resendOtp").on("click",function(e){
                //e.preventDefault();
                var mobile = $("#pta_mobile_number").val();
                $("#otp_submit .error").fadeOut();
                if(!validateblanktext(mobile)) {
                    $("#user_otp_error").html("Please provide mobile number.")
                    $("#user_otp_error").fadeIn();
                    $("#user_otp").focus();
                    return false;
                } else if(!phone_val.test(mobile)) {
                    $("#user_otp_error").html("Please provide valid mobile number.")
                    $("#user_otp_error").fadeIn();
                    $("#user_otp").focus();
                    return false;
                }

                $.ajax({
                    url: "<?php echo base_url(); ?>vote/resend_otp",
                    data: {'pta_mobile_number':mobile},
                    dataType: "JSON",
                    type: "POST",  
                    success: function(result) {
                        if(result.status == "success"){
                            $('.resendOtp').fadeOut();
                            $('.resendOtp').delay(20000).fadeIn();
                        }else{                            
                            $("#otp_submit .error").fadeIn();
                            $("#user_otp_error").html(result.msg);
                        }
                    }
                });
            });

            $('#student_table').DataTable({
                "paging": true,
                "searching": true,
            });
            $('#college_table').DataTable();
            $('#district_table').DataTable();
        });
    </script>
</html>
