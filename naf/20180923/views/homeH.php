<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include('head_element.php'); ?>
        <title>NAF</title>
        <meta name="description" content="" />
    <!--     <link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
    </head>
    <body class="home">       
        <div class="popup setAgendaPopup popUpOverlayClose" >
            <div class="popupIn">
                <div class="table_cell">
                    <div class="popupData">
                         <div class="closePopup">Close</div> 
                        <h5>Please set the Agenda first</h5>
                        <a href="<?php echo base_url();?>agenda"><div class="btn transition">Set The Agenda</div></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="wrapper topWrap">
            <div class="backImg"></div>
            <div ></div>
            <img class="gandhiBack" src="<?php echo base_url()?>assets/images/gandhi.png">
            <img class="gandhiBack2" src="<?php echo base_url()?>assets/images/gandhi-naf.png">
            <img class="gandhiBack3" src="<?php echo base_url()?>assets/images/gandhi-charkha-naf.png">
            <?php include('header.php'); ?>
            <div class="aboutNAF">
                <p>As the nation celebrates the 150th Birth Anniversary year of Mahatma Gandhi, Indian Political Action Committee (I-PAC) aims to pay tribute by resurrecting the conversation around his Constructive Programme. <label class="mobileHide">In 1945, through his <a href="http://www.indianpac.com/naf/Constructive_Programme.pdf" target="_blank">18-point Constructive Programme</a>, Gandhi ji outlined the key priorities for independent India and urged citizens to work towards them.</label></p>
                <p class="mobileHide">Taking this spirit forward, I-PAC has launched the National Agenda Forum (NAF), a pan-India initiative to <b>resurrect the conversation</b> around Gandhi ji’s vision and use it to <b>re-imagine</b> and <b>co-create</b> India’s priorities to formulate an actionable agenda for contemporary India.</p>
                <h2>"Be the change you want to see in the world"<span>- Mahatma Gandhi</span></h2>
                <p class="seeMore">See More</p>
            </div>
        </div>
        <div class="homeMain">
            <div class="wrapper">
                <div class="steps">
                    <!-- <h2>How to Participate</h2> -->
                    <div class="stepsIn">
                        <div class="step">1</div>
                        <img src="<?php echo base_url()?>assets/images/icons/share.png" alt="Set Agenda" title="Set Agenda"><h3>Share the vision</h3>
                        <p>Make the nation aware of Gandhiji's 18-point Constructive Programme</p>
                        <div class="shareBtnOut">
                            <div class="btn transition shrBtn">Share

                                <?php
                                    $url = base_url();
                                ?>
                                
                            </div>
                            <div class="shareDiv">
                                <div class="shareDivIn fbBtn">
                                    <svg class="fbImg" viewBox="0 0 8379 8379"><g id="Layer_x0020_1"><rect class="fil0" height="8379" width="8379"/><path class="fil1" d="M5111 3490l-627 0 0 -412c0,-154 102,-190 174,-190 72,0 443,0 443,0l0 -680 -610 -3c-677,0 -832,507 -832,832l0 453 -392 0 0 701 392 0c0,899 0,1983 0,1983l825 0c0,0 0,-1095 0,-1983l556 0 71 -701z"/></g></svg>
                                </div><div class="shareDivIn twitBtn">
                                    <a href="https://twitter.com/share?text=Gandhiji, in his Constructive Programme, had outlined the blueprint for independent India. In his 150th Birth Anniversary year, let us spread his vision &amp; formulate an actionable agenda for India. Join #NationalAgendaForum, visit www.indianpac.com/naf/&p[summary]=""&url=<?php echo $url; ?>&via=National Agenda Forum&hashtags=NationalAgendaForum" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=250'); return false"><svg class="twitImg" viewBox="0 0 9291 9291"><g id="Layer_x0020_1"><rect class="fil0" height="9291" width="9291"/><path class="fil1" d="M6852 3277c-162,72 -336,120 -520,142 188,-112 331,-289 399,-501 -178,106 -373,180 -576,220 -165,-176 -400,-286 -660,-286 -500,0 -906,405 -906,906 0,70 8,140 24,206 -753,-38 -1420,-398 -1867,-946 -78,134 -122,289 -122,455 0,314 160,592 403,754 -144,-5 -285,-43 -411,-113l0 11c0,439 312,805 727,888 -77,21 -156,32 -239,32 -58,0 -115,-6 -170,-16 115,359 449,621 846,628 -311,243 -701,388 -1125,388 -73,0 -145,-4 -216,-13 401,257 877,407 1388,407 1665,0 2576,-1380 2576,-2576 0,-39 -1,-78 -3,-117 178,-128 331,-287 452,-469z"/></g></svg></a>
                                </div><div class="shareDivIn whatsBtn">
                                    <a onclick="share_on_whatsapp('<?php echo $url; ?>', 'Join National Agenda Forum')" href="javascript:;"><svg class="whatsImg" viewBox="0 0 8379 8379"><g id="Layer_x0020_1"><rect class="fil0" height="8379" width="8379"/><g id="_899307880"><path class="fil1" d="M6460 4075c-30,-1197 -1016,-2158 -2229,-2158 -1199,0 -2176,939 -2229,2117 -1,32 -2,65 -2,97 0,419 117,809 320,1143l-402 1188 1235 -393c320,175 687,276 1078,276 1232,0 2230,-991 2230,-2214 0,-19 0,-38 -1,-56zm-2229 1917l0 0c-381,0 -735,-113 -1032,-308l-720 229 233 -691c-224,-307 -357,-684 -357,-1091 0,-61 3,-121 10,-181 92,-942 894,-1680 1866,-1680 984,0 1794,757 1869,1716 4,48 6,96 6,145 0,1026 -842,1861 -1875,1861z"/><path class="fil1" d="M5253 4578c-55,-27 -324,-159 -374,-177 -50,-18 -87,-27 -123,28 -37,54 -142,176 -173,211 -33,37 -64,41 -119,14 -55,-27 -231,-83 -440,-269 -162,-143 -273,-321 -304,-375 -31,-54 -3,-84 24,-111 25,-25 54,-64 83,-95 7,-9 13,-18 19,-26 13,-20 22,-39 35,-65 19,-36 9,-68 -4,-95 -14,-27 -123,-294 -169,-403 -45,-108 -91,-90 -124,-90 -31,0 -68,-5 -104,-5 -37,0 -96,14 -146,68 -50,54 -191,186 -191,453 0,63 11,125 28,185 55,191 174,349 195,376 27,35 378,601 934,820 556,216 556,144 656,134 101,-8 324,-130 369,-258 46,-126 46,-235 32,-258 -13,-21 -50,-35 -104,-62z"/></g></g></svg></a>
                                </div><div class="shareDivIn pdfBtnOut">
                                    <div class="pdfBtn transition">
                                        <a href="http://www.indianpac.com/naf/Constructive_Programme.pdf" target="_blank">Download PDF</a>
                                    </div>
                                </div> 
                            </div> 
                        </div>

                        <!-- <p class="stats">&nbsp;</p> -->
                    </div><div class="stepsIn">
                        <div class="step">2</div>
                        <img src="<?php echo base_url()?>assets/images/icons/agenda.png" alt="Set Agenda" title="Set Agenda"><h3>Set the agenda</h3>
                        <p>Contribute and vote to set the actionable agenda for contemporary India.</p>
                        <?php if($disable_agenda){?><div class="btn transition disabled">Done</div><?php }else{?><a href="<?php echo base_url();?>agenda"><div class="btn transition">Vote</div></a><?php }?>
                        <!-- <p class="stats"><?php echo $total;?> have already voted.</p> -->
                    </div><div class="stepsIn">
                        <div class="step">3</div>
                        <img src="<?php echo base_url()?>assets/images/icons/vote.png" alt="Set Agenda" title="Set Agenda"><h3>Choose the leader</h3>
                        <p>Vote for the leader best suited to adopt and execute this agenda.</p>
                        <?php if($disable_vote){?><div class="btn voteBtn transition disabled">Done</div><?php }else{?><div class="btn voteBtn transition">Vote</div><?php }?>
                        <!-- <p class="stats"><?php echo $total;?> have already voted.</p> -->
                        <!-- <div class="setAgendaPopup">Set Agenda First</div> -->
                    </div><div class="stepsIn registerBlock">
                        <div class="step">4</div>
                        <img src="<?php echo base_url()?>assets/images/icons/register.png" alt="Set Agenda" title="Set Agenda"><h3>Campaign for india</h3>
                        <p>Help the choosen leader to get elected in the upcoming General Elections</p>
                        <?php if($disable_register){?><div class="btn regiBtn transition disabled">Done</div><?php }else{?>
                            <?php if(!$disable_agenda && !$disable_vote){?>
                            <div class="btn regiBtn transition">Register</div>
                            <?php }else{ ?>
                            <a href="<?php echo base_url();?>register"><div class="btn transition">Register</div></a>
                            <?php }?>                        
                        <?php }?>
                        
                        <!--<p class="stats"><?php echo $total;?> have already joined.</p>-->
                        <!-- <div class="setAgendaPopup">Set Agenda First</div> -->
                    </div>
                </div>
                <div class="videoSec">
                    <h2>NAF explainer Video</h2>
                    <!-- <iframe src="https://www.youtube.com/embed/G1lhrO6L2e8?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe> -->
                    <iframe src="https://www.youtube.com/embed/kZH0xKlP8To?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

                </div>
                <div class="milestones">
                    <h2>NAF Milestones</h2>
                    
                    <div class="milestonesIn topMile completedMile">
                        <div class="milestonesLine">
                            <div class="mileImg">
                                <img src="<?php echo base_url()?>assets/images/icons/launch.png" alt="launch" title="NAF Launch">
                            </div>
                        </div>
                        <div class="milestonesBot mileDesc">
                            <h5>29th June 18</h5>
                            <p>NAF Launch</p>
                        </div>
                    </div><div class="milestonesIn topMile completedMile">
                        <div class="milestonesLine">
                            <div class="mileImg">
                                <img src="<?php echo base_url()?>assets/images/icons/opens.png" alt="launch" title="NAF Launch">
                            </div>
                        </div>
                        <div class="milestonesBot mileDesc">
                            <h5>11th July 18</h5>
                            <p>Voting opens to set the key national priorities and choose the leader</p>
                        </div>
                    </div><div class="milestonesIn topMile">
                        <div class="milestonesLine">
                            <div class="mileImg">
                                <img src="<?php echo base_url()?>assets/images/icons/results.png" alt="launch" title="NAF Launch">
                            </div>
                        </div>
                        <div class="milestonesBot mileDesc">
                            <h5>15th August 18</h5>
                            <p>Voting Results</p>
                        </div>
                    </div><div class="milestonesIn topMile">
                        <div class="milestonesLine">
                            <div class="mileImg">
                                <img src="<?php echo base_url()?>assets/images/icons/meeting .png" alt="launch" title="NAF Launch">
                            </div>
                        </div>
                        <div class="milestonesBot mileDesc">
                            <h5>Sep'18 - Oct'18</h5>
                            <p>Meeting with the leader</p>
                        </div>
                    </div><div class="milestonesIn topMile">
                        <div class="milestonesLine">
                            <div class="mileImg">
                                <img src="<?php echo base_url()?>assets/images/icons/toNation.png" alt="launch" title="NAF Launch">
                            </div>
                        </div>
                        <div class="milestonesBot mileDesc">
                            <h5>Oct'18 - Jan 19</h5>
                            <p>Taking the agenda to the nation</p>
                        </div>
                    </div><div class="milestonesIn topMile">
                        <div class="milestonesLine">
                            <div class="mileImg">
                                <img src="<?php echo base_url()?>assets/images/icons/adoption.png" alt="launch" title="NAF Launch">
                            </div>
                        </div>
                        <div class="milestonesBot mileDesc">
                            <h5>Jan'19 - Feb'19</h5>
                            <p>Adoption of agenda as part of official manifesto of the party</p>
                        </div>
                    </div>

                </div>
                
             <!--    <div class="starPerformers">
                    <ul>
                        <li>
                            <img src="<?php echo base_url()?>assets/images/starPerform/" alt="" title=""> 
                        </li>
                    </ul>
                </div>
 -->
                <div class="testimonials">
                    <ul class="testimonialSlide">
                        <li>
                            <h4>"NAF is a rare opportunity for the aam aadmi to choose the leader to lead the nation"</h4>
                        </li><li>
                            <h4>"Kudos to I-PAC for coming up with such a great idea – NAF will surely help us choose the next BIG leader and agenda"</h4>
                        </li><li>
                            <h4>"Let’s change our current inept corrupt political system by choosing the next person to lead us"</h4>
                        </li><li>
                            <h4>"A novel and ambitious idea that actually asks the people who THEY want to lead them and the agenda THEY care about"</h4>
                        </li><li>
                            <h4>"NAF is a great opportunity to move past the current crop and choose a new, dynamic person to lead us"</h4>
                        </li><li>
                            <h4>"NAF is a great opportunity to move past the current crop and choose a new, dynamic person to lead us"</h4>
                        </li><li>
                            <h4>"It’s about time that the voice of the YOUTH gets heard and NAF seems the perfect platform for that"</h4>
                        </li><li>
                            <h4>"Voting in NAF is a one-minute job that will help us change India’s destiny"</h4>
                        </li><li>
                            <h4>"NFA is a great initiative by I-PAC which engages the citizens of India to set the agenda for their leader"</h4>
                        </li><li>
                            <h4>"I have always wanted to do more than just vote. NFA is the platform I had been waiting for"</h4>
                        </li>
                    </ul>
                </div>

                <div class="partners">
                    <h2>NAF Partners</h2>
                    <ul>
                        <li>
                            <img src="<?php echo base_url()?>assets/images/partners/DainikJagaran.png" alt="" title="">
                        </li><li>
                            <img src="<?php echo base_url()?>assets/images/partners/DeccanChronical.png" alt="" title="">
                        </li><li>
                            <img src="<?php echo base_url()?>assets/images/partners/Dinamani.png" alt="" title="">
                        </li><li>
                            <img src="<?php echo base_url()?>assets/images/partners/eenadu.png" alt="" title="">
                        </li><li>
                            <img src="<?php echo base_url()?>assets/images/partners/FinancialTimes.png" alt="" title="">
                        </li><li>
                            <img src="<?php echo base_url()?>assets/images/partners/hariBhumi.png" alt="" title="">
                        </li><li>
                            <img src="<?php echo base_url()?>assets/images/partners/HindustanTimes.png" alt="" title="">
                        </li><li>
                            <img src="<?php echo base_url()?>assets/images/partners/IndianExpress.png" alt="" title="">
                        </li><li>
                            <img src="<?php echo base_url()?>assets/images/partners/Naidunia.png" alt="" title="">
                        </li><li>
                            <img src="<?php echo base_url()?>assets/images/partners/NBTLogo.png" alt="" title="">
                        </li><li>
                            <img src="<?php echo base_url()?>assets/images/partners/TheHindu.png" alt="" title="">
                        </li><li>
                            <img src="<?php echo base_url()?>assets/images/partners/TimesofIndia.png" alt="" title="">
                        </li>
                    </ul>
                </div>
                <img class="mileBack" src="<?php echo base_url()?>assets/images/mileBack.png">
            </div>
        </div>
            <?php include('footer.php'); ?> 
            <script src='https://www.google.com/recaptcha/api.js'></script>  
            <script src="<?php echo base_url()?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
            <script src="<?php echo base_url()?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
            

        </div>
    </body>
    <script type="text/javascript">

        var phone_val = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
        var whitespaces_val = /^\s+$/;   
        $( document ).ready(function() {
            /*$('.registerBtn').on('click touch', function(event) {
                $('.registerMobile').fadeToggle();
            });

            $(document).on('click touch', function(event) {
                if (!$(event.target).parents().addBack().is('.registerBtn, .registerMobile')) {
                    $('.registerMobile').fadeOut();
                }
            }); */
            
            

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
                    url: "<?php echo base_url(); ?>home/check_user",
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
                    url: "<?php echo base_url(); ?>home/verify_otp",
                    data: formData,
                    dataType: "JSON",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,  
                    success: function(result) {
                        if(result.status == "success"){
                            //location.reload(); 
                            window.location.href = "<?php echo base_url(); ?>"+result.msg; 
                            //window.location.replace("<?php echo base_url(); ?>"+result.msg);                           
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
                    url: "<?php echo base_url(); ?>home/resend_otp",
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
        });
        
        function validateblanktext(stringtext) {
            if(stringtext == "" || whitespaces_val.test(stringtext) || stringtext == 0) {
                return false;
            } else {
                return true;
            }
        }
    </script>
    
</html>