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
        @media (min-width: 1025px) and (max-width: 1440px) {
            .nationalPerson {
                width: 49.50%;
            }
        }
    </style>
    <title>NAF</title>
    <meta name="description" content="" />

    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/show_result.css">

    <?php

    //echo $_COOKIE['language'];
    /*
    if(!isset($_COOKIE['language'])){

    $_COOKIE['language']="en";
    $langcookie=$_COOKIE['language'];
    }

    else {
        $langcookie=$_COOKIE['language'];
    }

    */
    ?>


    <?php
    if(isset($_COOKIE['path'])){
        if($_COOKIE['path']=="agenda"){
            $step1="Set the Agenda";
            $step2="Choose the Leader";
            $step1_hi="एजेंडा का चयन करें";
            $step2_hi="नेता चुने";
        }elseif($_COOKIE['path']=="vote"){
            $step2="Set the Agenda";
            $step1="Choose the Leader";
            $step2_hi="एजेंडा का चयन करें";
            $step1_hi="नेता चुने";
        }else{
            $step1="Set the Agenda";
            $step2="Choose the Leader";
            $step1_hi="एजेंडा का चयन करें";
            $step2_hi="नेता चुने";
        }
    }else{
        $step1="Set the Agenda";
        $step2="Choose the Leader";
        $step1_hi="एजेंडा का चयन करें";
        $step2_hi="नेता चुने";
    }?>



</head>
<body class="register ipac_edit_body">

<div class="backImg"></div>
<div class="wrapper"> 
    <?php include('header.php'); ?>
    <div class="homeMain regiMain">
        <!--                    <div class="topInfo">-->
        <!--                        <p>Help the chosen Leader to get elected in the upcoming General Elections</p>-->
        <!--                        <p><i>Register as Part Time Associate with Indian Political Action Committee</i></p>-->
        <!--                    </div>-->

        <h2 class="congos_section"><?php if($langcookie=="en"){ ?> Campaign for India<?php }?>  <?php if($langcookie=="hi"){ ?>देश के लिए अभियान<?php }?>  </h2>
        <!-- <p class="pta_compliment"><?php if($langcookie=="en"){ ?>Your vote has been successfully registered.<?php }?>  <?php if($langcookie=="hi"){ ?>आपका वोट दर्ज हो चुका है |<?php }?> </p> -->
        <br/>






        <!-- <div class="headSearch">
                        <div class="headSearchIn">
                            <h2>REGISTER WITH NAF</h2>
                            <p>The set the agenda for General Election 2019
                            </p>
                        </div><div class="headSearchIn congrast">
                            <p class="confirm">Congratulations! Your Vote Has Been Registered</p>
                            <p class="count"><?php echo $total_votes;?> Votes Casted Till Now </p>
                        </div>
                    </div>


                    <div class="ptaMember">
                        <h6>Already a PTA Member?</h6><form id="pta_form" action="javascript:;" name="pta_form" autocomplete="off"><div class="indiaCode">+91</div><input class="mobileNumber" type="text" placeholder="Enter Your Mobile Number" name="pta_mobile_number" id="pta_mobile_number" autocomplete="off" maxlength="10" minlength="10"><input type="submit" class="btn" value="GET OTP"><div class="error" id="blank">Please enter your mobile number</div>
                        <div class="error" id="valid">Please enter valid mobile number</div><div class="error" id="custom_error"></div></form>
                    </div>

                    <div class="or">
                        <span>OR</span>
                    </div> -->
        <div class="topInfo register_topInfo">
            <p class="register_heading"><?php if($langcookie=="en"){ ?>Register as Part Time Associate (PTA) with I-PAC<?php }?>  <?php if($langcookie=="hi"){ ?>I-PAC के साथ पार्ट टाइम एसोसिएट (PTA) के तौर पर रजिस्टर करें<?php }?></p>
            <p class="tick_marks"><font style="color:#278747">&#10004;</font>&nbsp;&nbsp;<?php if($langcookie=="en"){ ?>Sign up to take the agenda to the nation<?php }?>  <?php if($langcookie=="hi"){ ?>इस एजेंडा के राष्ट्रव्यापी प्रसार के लिए साइन अप करें<?php }?></p>
        </div>
        <div class="registerForm">
            <!--                        <h4 style="margin-top:0">New Registration</h4>-->
            <form id="regiForm" name="regiForm" autocomplete="off">
                <input type="hidden" name="referral_code" id="referral_code" value="<?php echo $referral_code?>">
                <div class="formIn">
                    <div class="formTitle"><?php if($langcookie=="en"){ ?>Name<?php }?>  <?php if($langcookie=="hi"){ ?>नाम<?php }?><sup>*</sup>
                    </div><div class="formField">
                        <input id="regName" type="text" name="regName" placeholder="<?php if($langcookie=="en"){ ?>Enter Your Name<?php }?>  <?php if($langcookie=="hi"){ ?>अपना नाम लिखें<?php }?>">
                        <div class="error blank"><?php if($langcookie=="en"){ ?>Please enter your name<?php }?>  <?php if($langcookie=="hi"){ ?>अपना नाम लिखें<?php }?></div>
                        <div class="error" id="regName_error"></div>
                    </div>
                </div><div class="formIn">
                    <div class="formTitle">
                        <?php if($langcookie=="en"){ ?>Gender<?php }?>  <?php if($langcookie=="hi"){ ?>लिंग<?php }?><sup>*</sup>
                    </div><div class="formField">
                        <select id="regGender" name="regGender">
                            <option value="0"><?php if($langcookie=="en"){ ?>Select Gender<?php }?>  <?php if($langcookie=="hi"){ ?>लिंग चुने<?php }?><sup>*</sup></option>
                            <option value="1"><?php if($langcookie=="en"){ ?>Male<?php }?>  <?php if($langcookie=="hi"){ ?>पुरुष <?php }?></option>
                            <option value="2"><?php if($langcookie=="en"){ ?>Female<?php }?>  <?php if($langcookie=="hi"){ ?>स्त्री <?php }?></option>
                            <option value="3"><?php if($langcookie=="en"){ ?>Other<?php }?>  <?php if($langcookie=="hi"){ ?>अन्य <?php }?></option>
                        </select>
                        <div class="error blank"><?php if($langcookie=="en"){ ?>Please select your gender<?php }?>  <?php if($langcookie=="hi"){ ?>लिंग चुनें<?php }?></div>
                        <div class="error" id="regGender_error"></div>
                    </div>
                </div><div class="formIn DOBForm">
                    <div class="formTitle">
                        <?php if($langcookie=="en"){ ?>DOB<?php }?>  <?php if($langcookie=="hi"){ ?>जन्म तिथि<?php }?><sup>*</sup>
                    </div><div class="formField">
                        <select class="monthDOB" id="regMonth" name="regMonth">
                            <option value="0"><?php if($langcookie=="en"){ ?>Month<?php }?><?php if($langcookie=="hi"){ ?>महीना<?php }?></option>
                            <option value="1"><?php if($langcookie=="en"){ ?>January<?php }?><?php if($langcookie=="hi"){ ?>जनवरी<?php }?></option>
                            <option value="2"><?php if($langcookie=="en"){ ?>February<?php }?><?php if($langcookie=="hi"){ ?>फ़रवरी<?php }?></option>
                            <option value="3"><?php if($langcookie=="en"){ ?>March<?php }?><?php if($langcookie=="hi"){ ?>मार्च<?php }?></option>
                            <option value="4"><?php if($langcookie=="en"){ ?>April<?php }?><?php if($langcookie=="hi"){ ?>अप्रैल<?php }?></option>
                            <option value="5"><?php if($langcookie=="en"){ ?>May<?php }?><?php if($langcookie=="hi"){ ?>मई<?php }?></option>
                            <option value="6"><?php if($langcookie=="en"){ ?>June<?php }?><?php if($langcookie=="hi"){ ?>जून<?php }?></option>
                            <option value="7"><?php if($langcookie=="en"){ ?>July<?php }?><?php if($langcookie=="hi"){ ?>जुलाई<?php }?></option>
                            <option value="8"><?php if($langcookie=="en"){ ?>August<?php }?><?php if($langcookie=="hi"){ ?>अगस्त<?php }?></option>
                            <option value="9"><?php if($langcookie=="en"){ ?>September<?php }?><?php if($langcookie=="hi"){ ?>सितंबर<?php }?></option>
                            <option value="10"><?php if($langcookie=="en"){ ?>October<?php }?><?php if($langcookie=="hi"){ ?>अक्टूबर<?php }?></option>
                            <option value="11"><?php if($langcookie=="en"){ ?>November<?php }?><?php if($langcookie=="hi"){ ?>नवंबर<?php }?></option>
                            <option value="12"><?php if($langcookie=="en"){ ?>December<?php }?><?php if($langcookie=="hi"){ ?>दिसंबर<?php }?></option>

                        </select><select class="dayDOB disable" id="regDay" name="regDay">
                            <option value="0"><?php if($langcookie=="en"){ ?>Day<?php }?><?php if($langcookie=="hi"){ ?>दिन<?php }?></option>

                        </select><select class="yearDOB disable" id="regYear" name="regYear">
                            <option value="0"><?php if($langcookie=="en"){ ?>Year<?php }?><?php if($langcookie=="hi"){ ?>साल<?php }?></option>

                        </select>
                        <!-- <input type="text" name="" placeholder="Enter Your Name"> -->
                        <div class="error blank"><?php if($langcookie=="en"){ ?>Please select date of birth<?php }?><?php if($langcookie=="hi"){ ?>अपना जन्म तिथि लिखें<?php }?></div>
                        <div class="error" id="regMonth_error"></div>
                        <div class="error" id="regDay_error"></div>
                        <div class="error" id="regYear_error"></div>
                    </div>
                </div><div class="formIn mobileNo">
                    <div class="formTitle">
                        <?php if($langcookie=="en"){ ?>Mobile Number<?php }?><?php if($langcookie=="hi"){ ?>मोबाईल नंबर<?php }?><sup>*</sup>
                    </div><div class="formField">
                        <div class="indiaCode">+91</div><input id="regMobile" class="mobileNOInout mobileNumber" type="text" name="regMobile" placeholder="<?php if($langcookie=="en"){ ?>Enter Your Mobile Number<?php }?><?php if($langcookie=="hi"){ ?>अपना मोबाईल नंबर लिखें <?php }?>" maxlength="10" minlength="10">
                        <div class="error blank"><?php if($langcookie=="en"){ ?>Please enter your mobile number<?php }?><?php if($langcookie=="hi"){ ?>अपना मोबाईल नंबर लिखें <?php }?></div>
                        <div class="error valid"><?php if($langcookie=="en"){ ?>Please enter valid mobile number<?php }?><?php if($langcookie=="hi"){ ?>कृपया सही मोबाइल नंबर लिखें<?php }?></div>
                        <div class="error" id="regMobile_error"></div>

                    </div>
                </div><div class="formIn whatsappNo">
                    <div class="formTitle">
                        <?php if($langcookie=="en"){ ?>WhatsApp Number<?php }?><?php if($langcookie=="hi"){ ?>व्हाट्सएप नंबर<?php }?><sup>*</sup>
                    </div><div class="formField">
                        <div class="indiaCode">+91</div><input id="regWhatsapp" class="whatsappNOInout mobileNumber" type="text" name="regWhatsapp" placeholder="<?php if($langcookie=="en"){ ?>Enter Your WhatsApp Number<?php }?><?php if($langcookie=="hi"){ ?>अपना व्हाट्सएप लिखें<?php }?>" maxlength="10" minlength="10" readonly>
                        <label class="container sameMobile"><p><?php if($langcookie=="en"){ ?>Same As Mobile Number<?php }?><?php if($langcookie=="hi"){ ?>मोबाइल नंबर के समान<?php }?></p>
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                        </label>
                        <div class="error blank"><?php if($langcookie=="en"){ ?>Please enter your whatsapp number<?php }?><?php if($langcookie=="hi"){ ?>कृपया अपना व्हाट्सएप नंबर लिखें<?php }?></div>
                        <div class="error valid"><?php if($langcookie=="en"){ ?>Please enter valid whatsapp number<?php }?><?php if($langcookie=="hi"){ ?>कृपया अपना सही व्हाट्सएप नंबर लिखें<?php }?></div>
                        <div class="error" id="regWhatsapp_error"></div>

                    </div>
                </div><div class="formIn">
                    <div class="formTitle">
                        <?php if($langcookie=="en"){ ?>Email<?php }?><?php if($langcookie=="hi"){ ?>ईमेल<?php }?>
                        <sup>*</sup>
                    </div><div class="formField">
                        <input type="email" id="regEmail" name="regEmail" placeholder="<?php if($langcookie=="en"){ ?>Enter Your Email<?php }?><?php if($langcookie=="hi"){ ?>अपना ईमेल आई डी लिखें<?php }?>">
                        <div class="error blank"><?php if($langcookie=="en"){ ?>Please enter your email id<?php }?><?php if($langcookie=="hi"){ ?>कृपया अपना ईमेल आई डी लिखें<?php }?></div>
                        <div class="error valid"><?php if($langcookie=="en"){ ?>Please enter valid email id<?php }?><?php if($langcookie=="hi"){ ?>कृपया अपना सही ईमेल आई डी लिखें<?php }?></div>
                        <div class="error" id="regEmail_error"></div>
                    </div>
                </div>
                <div class="formIn">
                    <div class="formTitle">
                        <?php if($langcookie=="en"){ ?>College Student ? <?php }?><?php if($langcookie=="hi"){ ?>कॉलेज छात्र ?<?php }?><sup>*</sup>
                    </div><div class="formField">
                        <select id="regStudType" name="regStudType">
                            <option value="0"><?php if($langcookie=="en"){ ?>No<?php }?><?php if($langcookie=="hi"){ ?>ना<?php }?></option>
                            <option value="1"><?php if($langcookie=="en"){ ?>Yes<?php }?><?php if($langcookie=="hi"){ ?>हां<?php }?></option>
                        </select>
                        <!-- <div class="error blank">Please Enter Your Name</div> -->
                    </div>
                </div><div class="formIn">
                    <div class="formTitle">
                        <?php if($langcookie=="en"){ ?>Home State<?php }?><?php if($langcookie=="hi"){ ?>गृह राज्य<?php }?><sup>*</sup>
                    </div><div class="formField">
                        <select id="regState" name="regState">
                            <option value="0"><?php if($langcookie=="en"){ ?>Select State<?php }?><?php if($langcookie=="hi"){ ?>राज्य चुनें<?php }?> </option>
                            <?php
                            foreach ($all_state as $key => $value) { ?>
                                <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                            <?php }
                            ?>
                        </select>
                        <div class="error blank"><?php if($langcookie=="en"){ ?>Please select state<?php }?><?php if($langcookie=="hi"){ ?>कृपया राज्य चुनें<?php }?></div>
                    </div>
                </div><div class="formIn">
                    <div class="formTitle">
                        <?php if($langcookie=="en"){ ?>Home District<?php }?><?php if($langcookie=="hi"){ ?>गृह जिला<?php }?> <sup>*</sup>
                    </div><div class="formField">
                        <select id="regDistrict" name="regDistrict">
                            <option value="0"><?php if($langcookie=="en"){ ?>Select District<?php }?><?php if($langcookie=="hi"){ ?>जिला चुनें<?php }?></option>
                        </select>
                        <div class="error blank"><?php if($langcookie=="en"){ ?>Please select district<?php }?><?php if($langcookie=="hi"){ ?>कृपया जिला चुनें)<?php }?></div>
                    </div>
                </div><div class="formIn" style="display: none;">
                    <div class="formTitle">
                        <?php if($langcookie=="en"){ ?>College State<?php }?><?php if($langcookie=="hi"){ ?>कॉलेज का राज्य<?php }?><sup>*</sup>
                    </div><div class="formField">
                        <select id="regCollgState" name="regCollgState">
                            <option value=""><?php if($langcookie=="en"){ ?>Select State<?php }?><?php if($langcookie=="hi"){ ?>राज्य चुनें<?php }?></option>
                            <?php
                            foreach ($all_state as $key => $value) { ?>
                                <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                            <?php }
                            ?>
                        </select>
                        <div class="error blank"><?php if($langcookie=="en"){ ?>Please select your college state<?php }?><?php if($langcookie=="hi"){ ?>कृपया कॉलेज का राज्य चुनें<?php }?></div>
                    </div>
                </div><div class="formIn" style="display: none;">
                    <div class="formTitle">
                        <?php if($langcookie=="en"){ ?>College District<?php }?><?php if($langcookie=="hi"){ ?>कॉलेज जिला <?php }?> <sup>*</sup>
                    </div><div class="formField">
                        <select id="regCollgDistrict" name="regCollgDistrict">
                            <option value=""><?php if($langcookie=="en"){ ?>Select District<?php }?><?php if($langcookie=="hi"){ ?>जिला चुने<?php }?></option>

                        </select>
                        <div class="error blank"><?php if($langcookie=="en"){ ?>Please select college district.<?php }?><?php if($langcookie=="hi"){ ?>कृपया कॉलेज का जिला चुनें<?php }?></div>
                    </div>
                </div><div class="formIn" style="display: none;">
                    <div class="formTitle">
                        <?php if($langcookie=="en"){ ?>College Name<?php }?><?php if($langcookie=="hi"){ ?>कॉलेज का नाम<?php }?> <sup>*</sup>
                    </div><div class="formField">
                        <input id="regCollName" type="text" name="regCollName" placeholder="<?php if($langcookie=="en"){ ?>Enter Your College Name<?php }?><?php if($langcookie=="hi"){ ?>कॉलेज का नाम भरें<?php }?>" >
                        <!-- <datalist id="regCollName_list">
                            <option>colg1</option>
                            <option>colg2</option>
                        </datalist> -->
                        <div class="error blank"><?php if($langcookie=="en"){ ?>Please select your college name<?php }?><?php if($langcookie=="hi"){ ?>कृपया कॉलेज का नाम चुने<?php }?></div>
                    </div>
                </div><div class="formIn">
                    <div class="formTitle">
                        <?php if($langcookie=="en"){ ?>Upload Profile Pic<?php }?><?php if($langcookie=="hi"){ ?>प्रोफाइल पिक्चर अपलोड करें<?php }?>

                    </div><div class="formField">
                        <div class="fileInput">
                            <p class="fileName"></p>
                            <span><?php if($langcookie=="en"){ ?>Select file<?php }?><?php if($langcookie=="hi"){ ?>फाइल चुनें<?php }?></span>
                            <input id="profile_pic" type="file" name="profile_pic" accept="image/*">
                            <p class="imgLimit"><?php if($langcookie=="en"){ ?>Max 1MB<?php }?><?php if($langcookie=="hi"){ ?>अधिकतम 1 एमबी<?php }?></p>
                        </div>
                        <div class="error blank"><?php if($langcookie=="en"){ ?>Please provide valid profile pic.<?php }?><?php if($langcookie=="hi"){ ?>कृपया सही प्रोफाइल पिक्चर अपलोड करें<?php }?> </div>
                    </div>
                </div>

                <div class="nationalPerson">
                    <p><?php if ($langcookie == "en") { ?>Language Preference 1<?php } ?><?php if ($langcookie == "hi") { ?>प्रथम भाषा<?php } ?></p>
                    <div class="formField">
                        <select id="regLangPreference1" name="regLangPreference1" style="width:100%">
                            <option value=""><?php if ($langcookie == "en") { ?>Select Language<?php } ?><?php if ($langcookie == "hi") { ?>भाषा चुनिए<?php } ?></option>
                            <option value="English">English</option>
                            <option value="Hindi">हिन्दी</option>
                            <option value="Bengali">বাংলা</option>
                            <option value="Telugu">తెలుగు</option>
                            <option value="Marathi">मराठी</option>
                            <option value="Tamil">தமிழ்</option>
                            <option value="Urdu">اردو</option>
                            <option value="Kannada">ಕನ್ನಡ</option>
                            <option value="Gujarati">ગુજરાતી</option>
                            <option value="Odia">ଓଡ଼ିଆ</option>
                            <option value="Malayalam">മലയാളം</option>
                        </select>
                    </div>
                </div>
                <div class="nationalPerson">
                    <p><?php if ($langcookie == "en") { ?>Language Preference 2<?php } ?><?php if ($langcookie == "hi") { ?>द्वितीय भाषा<?php } ?></p>
                    <div class="formField">
                        <select id="regLangPreference2" name="regLangPreference2" style="width:100%">
                            <option value=""><?php if ($langcookie == "en") { ?>Select Language<?php } ?><?php if ($langcookie == "hi") { ?>भाषा चुनिए<?php } ?></option>
                            <option value="English">English</option>
                            <option value="Hindi">हिन्दी</option>
                            <option value="Bengali">বাংলা</option>
                            <option value="Telugu">తెలుగు</option>
                            <option value="Marathi">मराठी</option>
                            <option value="Tamil">தமிழ்</option>
                            <option value="Urdu">اردو</option>
                            <option value="Kannada">ಕನ್ನಡ</option>
                            <option value="Gujarati">ગુજરાતી</option>
                            <option value="Odia">ଓଡ଼ିଆ</option>
                            <option value="Malayalam">മലയാളം</option>
                        </select>
                    </div>
                </div>
                <div class="nationalPerson" style="display: none;">
                    <p><?php if($langcookie=="en"){ ?>Name a non-political person who you think should enter politics at the national level<?php }?><?php if($langcookie=="hi"){ ?>एक ऐसे गैर-राजनीतिक आदमी का नाम बताएं, जिसे आपको लगता है कि राष्ट्रीय स्तर की राजनीति में प्रवेश करना चाहिए<?php }?> </p>
                    <div class="formField">
                        <input type="text" name="personality_1" id="personality_1" placeholder="<?php if($langcookie=="en"){ ?>Enter Non-Politician's Name<?php }?><?php if($langcookie=="hi"){ ?>गैर-राजनीतिक आदमी का नाम लिखें<?php }?>">
                        <div class="error blank"><?php if($langcookie=="en"){ ?>Please enter valid Personality name<?php }?><?php if($langcookie=="hi"){ ?>कृपया व्यक्ति का नाम सही लिखें<?php }?> </div>
                    </div>

                </div>
                <div class="nationalPerson" style="display: none;">
                    <p><?php if($langcookie=="en"){ ?>Name a non-political person who you think should enter politics at the district level<?php }?><?php if($langcookie=="hi"){ ?>एक ऐसे गैर-राजनीतिक आदमी का नाम बताएं, जिसे आपको लगता है कि जिले स्तर की राजनीति में प्रवेश करना चाहिए<?php }?></p>
                    <div class="formField">
                        <input type="text" name="personality_2" id="personality_2"  placeholder="<?php if($langcookie=="en"){ ?>Enter Non-Politician's Name<?php }?><?php if($langcookie=="hi"){ ?>गैर-राजनीतिक आदमी का नाम लिखें<?php }?>">
                        <div class="error blank"><?php if($langcookie=="en"){ ?>Please enter valid Personality name<?php }?><?php if($langcookie=="hi"){ ?>कृपया व्यक्ति का नाम सही लिखें<?php }?> </div>
                    </div>

                </div>

                <input class="btn" type="submit" value="<?php if($langcookie=="en"){ ?>SUBMIT<?php }?><?php if($langcookie=="hi"){ ?>जमा करें<?php }?> "><div class="phpError"></div><p class="terms"><?php if($langcookie=="en"){ ?>By Clicking This Button I Consent To The <?php }?><?php if($langcookie=="hi"){ ?>इस बटन को दबाकर <?php }?><span class="openPopup" id="terms"><?php if($langcookie=="en"){ ?>Terms & Conditions of NAF<?php }?><?php if($langcookie=="hi"){ ?>NAF की नियम एवं शर्तें<?php }?></span><?php if($langcookie=="en"){ ?><?php }?><?php if($langcookie=="hi"){ ?> स्वीकार करता हूं<?php }?></p>

            </form>
        </div>
    </div>
    <?php include('footer.php'); ?>
    <script type="text/javascript">
        var baseurl = "<?php echo base_url()?>";
    </script>
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/validation.js"></script>
</div>



<!-- Global site tag (gtag.js) - Google Ads: 797445191 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-797445191"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'AW-797445191');
</script>

<!-- Google Code for Naf Conversion Conversion Page -->

<!-- 
		<script type="text/javascript">
			/* <![CDATA[ */
			var google_conversion_id = 797445191;
			var google_conversion_label = "Iiz7CN7f0oUBEMeYoPwC";
			var google_remarketing_only = false;
			/* ]]> */
		</script>
		

        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
			<div style="display:inline;">
				<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/797445191/?label=Iiz7CN7f0oUBEMeYoPwC&amp;guid=ON&amp;script=0"/>
			</div>
		</noscript> -->




<script type="text/javascript">
    localStorage.removeItem('referral_code');
    localStorage.removeItem('referral_owner_id');
</script>
</body>

</html>
