<!DOCTYPE html>
<html lang="en">
<head>
<?php include('head_element.php'); ?>
<title>NAF</title>
<meta name="description" content="" />

<!--     <link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">

        <link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->

    <style>
.rajesh_btn{
  visibility: visible;
    position: fixed;
    top: 90%;
    background-color: rgb(214, 214, 214);
    bottom: 0;
}
</style>
<script>
/*function Hindi(){

document.getElementById('English').style.visibility="hidden";
document.getElementById('English').style.display="none";

document.getElementById('Hindi').style.visibility="visible";
document.getElementById('Hindi').style.display="block";
}

function English(){
document.getElementById('English').style.visibility="visible";
document.getElementById('English').style.display="block";
document.getElementById('Hindi').style.visibility="hidden";
document.getElementById('Hindi').style.display="none";
}*/

</script>
</head>
<body class="ipac_edit_body">
<input type="hidden" name="referral_code" id="referral_code" value="<?php echo $referral_code?>">
<input type="hidden" name="referral_owner_id" id="referral_owner_id" value="<?php echo $referral_owner_id?>">
<div class="backImg"></div>
<div class="wrapper">
  <?php include('header.php'); ?>
  <div class="homeMain agendaMain">
    <div class="headSearch">
      <div class="breadcrums">
        <ul>
<!--            Code shashwat start-->

            <?php


            $active = 0;
            if (isset($_COOKIE['step_agenda']) && isset($_COOKIE['step_vote'])) {
                if ($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "0") {
                    $href1 = "agenda";
                    $step1 = "Set the Agenda";
                    $step1_hi = "एजेंडा तय करें ";
                    $href2 = "/vote";
                    $step2 = "Choose the Leader";
                    $step2_hi = "नेता चुनें ";
                    $active = "0";
                } else if ($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "1") {
                    $href1 = "vote";
                    $step1 = "Choose the Leader";
                    $step1_hi = "नेता चुनें ";
                    $href2 = "agenda";
                    $step2 = "Set the Agenda";
                    $step2_hi = "एजेंडा तय करें ";
                    $active = "1";
                } else if ($_COOKIE['step_agenda'] == "1" && $_COOKIE['step_vote'] == "0") {
                    $href1 = "agenda";
                    $step1 = "Set the Agenda";
                    $step1_hi = "एजेंडा तय करें ";
                    $href2 = "vote";
                    $step2 = "Choose the Leader";
                    $step2_hi = "नेता चुनें ";
                    $active = "0";

                } else {
                    $href1 = "agenda";
                    $step1 = "Set the Agenda";
                    $step1_hi = "एजेंडा तय करें";
                    $href2 = "vote";
                    $step2 = "Choose the Leader";
                    $step2_hi = "नेता चुनें ";
                    $active = "0";
                }
            }else{
                    $href1 = "agenda";
                    $step1 = "Set the Agenda";
                    $step1_hi = "एजेंडा तय करें";
                    $href2 = "vote";
                    $step2 = "Choose the Leader";
                    $step2_hi = "नेता चुनें ";
                    $active = "0";
            }
            ?>


            <a href="<?php echo base_url().$href1?>">
                <li class="transition breadcrumsActive">
                    <div class="topFlag"></div>
                    <?php if($langcookie=="en"){ ?>
                        <span>Step 1</span> <?php echo $step1; ?>
                    <?php } ?>
                    <?php if($langcookie=="hi"){ ?>
                        <span>स्टेप-1  </span> <?php echo $step1_hi; ?>
                    <?php } ?>
                    <div class="bottomFlag"></div>
                </li>
            </a>
            </li></a><li class="transition <?php if ($active == "1"){echo 'breadcrumsActive';}?>">
                <div class="topFlag"></div>
                <?php if($langcookie=="en"){ ?>
                    <span>Step 2</span><?php echo $step2; ?>
                <?php }?>
                <?php if($langcookie=="hi"){ ?>
                    <span>स्टेप-2</span> <?php echo $step2_hi; ?>
                <?php }?>
                <div class="bottomFlag"></div>
            </li>
            <li class="transition">
                <div class="topFlag"></div>
                <?php if($langcookie=="en"){ ?>
                    <span>Step 3</span>Campaign for India
                <?php }?>
                <?php if($langcookie=="hi"){ ?>
                    <span>स्टेप-3</span> राष्ट्र के लिए अभियान 
                <?php }?>

<!--Code end Shashwat -->

<!--                <a href="--><?php //echo base_url()?><!--/agenda">-->
<!--            <li class="transition breadcrumsActive">-->
<!--                <div class="topFlag"></div>-->
<!--                --><?php //if($langcookie=="en"){ ?>
<!--                    <span>Step 1</span> Set the Agenda-->
<!--                --><?php //} ?>
<!--                --><?php //if($langcookie=="hi"){ ?>
<!--                    <span>प्रथम चरण </span> एजेंडा का चयन करें-->
<!--                --><?php //} ?>
<!--                <div class="bottomFlag"></div>-->
<!--            </li>-->
<!--            </a>-->
<!--            <li class="transition">-->
<!--                <div class="topFlag"></div>-->
<!--                --><?php //if($langcookie=="en"){ ?>
<!--                    <span>Step 2</span>Choose the Leader-->
<!--                --><?php //}?>
<!--                --><?php //if($langcookie=="hi"){ ?>
<!--                    <span>द्वितीय चरण </span> नेता चुने-->
<!--                --><?php //}?>
<!--                <div class="bottomFlag"></div>-->
<!--            </li>-->
<!--            <li class="transition">-->
<!--                <div class="topFlag"></div>-->
<!--                --><?php //if($langcookie=="en"){ ?>
<!--                    <span>Step 3</span>Campaign for India-->
<!--                --><?php //}?>
<!--                --><?php //if($langcookie=="hi"){ ?>
<!--                    <span>तृतीय चरण</span> देश के लिए अभियान करें-->
<!--                --><?php //}?>
<!---->


<!--                // Code shashwat end-->




            
            
            <div class="bottomFlag"></div>
          </li>
        </ul>
      </div>
      <div class="topInfo"> 
         
        <!--                            <p>Contribute and vote to set the actionable agenda for contemporary India</p>-->
        
        
      </div>
      <div id="counter_agenda"><span id="left_count">0</span>/10 </div>
      <form name="agenda_form" id="agenda_form">
        <input type="hidden" name="session_id" id="session_id" value="<?php echo session_id()?>">
        <div class="agendaWrap">
        <div class="testimonial-heading-flex">
        
        <h2><?php if($langcookie=="en"){ ?> Agenda Points <?php }?>  <?php if($langcookie=="hi"){ ?> एजेंडा प्वाइंट  <?php }?></h2>
        
        <!--<h4>There is no one who loves pain itself, who seeks after it and wants to have it</h4>-->
        <div class="green-border-down"></div>


        <p style="text-align:center;margin-bottom:30px;"><?php if($langcookie=="en"){ ?> You can choose maximum 10 agenda points, including adding a new agenda item in the box below <?php }?> <?php if($langcookie=="hi"){ ?> अपने एजेंडा समेत अधिकतम 10 प्वाइंट का चुनाव करें, अपना एजेंडा जोड़ने के लिए नीचे दिए गए बॉक्स का प्रयोग करें।  <?php }?></p>
      </div>
          <h2><?php if($langcookie=="en"){ ?>Inspired by Gandhiji’s 18-point Constructive Programme <?php }?> <?php if($langcookie=="hi"){ ?> गांधीजी के 18-सूत्रीय रचनात्मक कार्यक्रम से प्रेरित <?php }?></h2>
          <!--<img src="<?php echo base_url(); ?>assets/images/1.png" onclick="Hindi()">
          <img src="<?php echo base_url(); ?>assets/images/2.png" onclick="English()">-->



          <?php /*?><?php foreach ($gandhi_agenda_list as $key => $value) {?>
          <div class="agendaOut transition <?php if(in_array($value['id'], $selected_agenda['agenda_list'])){ echo 'selectedOpt';}?>" id="selectedOpt">
            <div class="container transition">
              <div class="table_cell"> 
              <div class="agenda_point_left"><span class="checkmark transition" id="checkmark_selected"></span></div>
              <div class="agenda_point_middle">
                <h5><?php echo $value['agenda_topic']?></h5>
                <label class="transition" id="agenda_description"><?php echo $value['agenda_name']?></label>
                </div>
                <div class="agenda_point_right">
                <div class="transition agendaImg" id="gandhi_border"><img id="gandhi_invert" class="transition gandhijiicon" src="<?php echo base_url()?>assets/images/icons/Gandhi4.png"></div>
                </div>
                <input class="checkboxInput transition" type="checkbox" name="agenda_name[]" <?php if(in_array($value['id'], $selected_agenda['agenda_list'])){ echo 'checked="checked"';}?> value="<?php echo $value['id']?>">
              </div>
            </div>
          </div>
          <?php }?><?php */?>
<div id="English" style="visibility: visible;">          
          <?php $i=1; foreach ($gandhi_agenda_list as $key => $value) {?>
          <div class="agendaOut <?php echo "agendacls".$value['id'];?> <?php if(in_array($value['id'], $selected_agenda['agenda_list'])){ echo 'selectedOpt';}?>" id="selectedOpt">
            <div class="container">
              <div class="table_cell"> 
              <div class="agenda_point_left"><span class="numbers"><?php echo $i;?></span><input class="checkboxInput transition" type="checkbox" name="agenda_name[]" <?php if(in_array($value['id'], $selected_agenda['agenda_list'])){ echo 'checked="checked"';}?> value="<?php echo $value['id']?>"></div>
              <div class="agenda_point_right">
              <div class="default">
              <div class="agendatitlenicon">
                <h5><?php if($langcookie=="en"){  echo $value['agenda_topic']; }?><?php if($langcookie=="hi"){  echo $value['agenda_topic_hindi']; }?></h5>
                <img id="gandhi_invert" class="transition gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda<?php echo $value['id']; ?>.png">
                <p class="only_mob_desc"><?php if($langcookie=="en"){ ?> Tap to see details <?php }?>  <?php if($langcookie=="hi"){ ?> 
विवरण देखने के लिए टैप करें
<?php }?></p>
                </div>
                <div class="transition agendaImg" id="gandhi_border"><img id="gandhi_invert" class="transition gandhijiicon" src="<?php echo base_url()?>assets/images/icons/Gandhi4.png"></div>
                </div>
                 <div class="agendaoverlay">
                 <label class="transition" id="agenda_description"><?php if($langcookie=="en"){  echo $value['agenda_name']; } ?><?php if($langcookie=="hi"){  echo $value['agenda_name_hindi']; } ?></label>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <?php $i++; }?>
          </div>















        </div>
   
        <div class="agendaWrap">
          <h2><?php if($langcookie=="en"){ ?> Gathered from peoples&rsquo; inputs <?php }?>  <?php if($langcookie=="hi"){ ?> जन-सुझाव द्वारा एकत्रित 
<?php }?></h2>


          <?php $j=19; foreach ($agenda_list as $key => $value) {?>
          <div class="agendaOut <?php echo "agendacls".$value['id'];?> <?php if(in_array($value['id'], $selected_agenda['agenda_list'])){ echo 'selectedOpt';}?>" id="selectedOpt">
            <div class="container">
              <div class="table_cell"> 
              <div class="agenda_point_left"><span class="numbers"><?php echo $j;?></span><input class="checkboxInput transition" type="checkbox" name="agenda_name[]" <?php if(in_array($value['id'], $selected_agenda['agenda_list'])){ echo 'checked="checked"';}?> value="<?php echo $value['id']?>"></div>
              <div class="agenda_point_right">
              <div class="default">
              <div class="agendatitlenicon">
                <h5><?php if($langcookie=="en"){ echo $value['agenda_topic']; }?> <?php if($langcookie=="hi"){ echo $value['agenda_topic_hindi']; }?></h5>
                <img id="gandhi_invert" class="transition gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda<?php echo $value['id']; ?>.png">
                <p class="only_mob_desc"><?php if($langcookie=="en"){ ?> Tap to see details <?php }?>  <?php if($langcookie=="hi"){ ?> 
विवरण देखने के लिए टैप करें
<?php }?></p>
                </div>
                <div class="transition agendaImg" id="gandhi_border"><img id="gandhi_invert" class="transition gandhijiicon" src="<?php echo base_url()?>assets/images/icons/fist.png"></div>
                </div>
                 <div class="agendaoverlay">
                 <label class="transition" id="agenda_description"><?php if($langcookie=="en"){ echo $value['agenda_name']; }?><?php if($langcookie=="hi"){ echo $value['agenda_name_hindi']; }?></label>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <?php $j++; }?>













          <div class="agendaOut agendaclscustom">
          <div class="container">
              <div class="table_cell"> 
          <div class="default agendaclscustom_inner" id="agendaclscustom_inner">
              <div class="agendatitlenicon">
                <h5><?php if($langcookie=="en"){ ?> List your own agenda below <?php }?>  <?php if($langcookie=="hi"){ ?> स्वयं का एजेंडा पॉइंट ऐड करे
<?php }?></h5>
                <img id="gandhi_invert" class="transition gandhijiicon" src="<?php echo base_url()?>assets/images/icons/note-icon1.png">
                </div>
                
                </div>
                 <div class="agendaoverlay" id="agendaoverlay">
                 <label class="transition" id="test"></label>
                 </div>
             </div>    
             </div>    
          </div>
        </div>
        
        <div class="agendaWrap">
          <h2><?php if($langcookie=="en"){ ?> Add your own agenda point <?php }?>  <?php if($langcookie=="hi"){ ?> अपना एजेंडा प्वाइंट जोड़ें
<?php }?></h2>
          <div class="transition addAgenda" id="add_agenda_sec">
            <div class="container transition"> 
              <!-- <span class="checkmark transition"></span> -->
              
              
              
              <textarea maxlength="300" placeholder='<?php if($langcookie=="en"){ ?> Add New Agenda <?php }?>  <?php if($langcookie=="hi"){ ?> अपना एजेंडा प्वाइंट जोड़ें 
<?php }?>' name="new_agenda" id="new_agenda" oninput="checkFilled();"><?php echo $selected_agenda['new_agenda'];?></textarea>
              <div class="transition agendaImg"><img  class="transition" id="new_agenda_icon" src="<?php echo base_url()?>assets/images/icons/note-icon.png"></div>
              
              <!-- <input class="checkboxInput transition" type="checkbox"> -->
              <div class="error" id="agenda_error"></div>
            </div>
          </div>
          <div id="textarea_feedback"></div>
        </div>
        
        <!-- <div class="g-recaptchaOut">

                                <div class="g-recaptcha" data-sitekey="<?php echo $site_key?>"></div>

                            </div> -->

<!--Change shashwat start          -->
<?php

    if (isset($_COOKIE['step_agenda']) && isset($_COOKIE['step_vote'])){
        if($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "0"){
            if($langcookie=="en"){
                echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                echo "<input class='Proceed transition disabled' type='submit'  value='Continue and Choose the Leader' >";
                echo "</div>";
            }
            if($langcookie=="hi") {
                echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                echo "<input class='Proceed transition disabled' type='submit'  value='आगे बढ़ें और नेता चुनें' >";
                echo "</div>";
            }
        }else if($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "1"){

            if($langcookie=="en"){
                echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                echo "<input class='Proceed transition disabled' type='submit'  value='Submit' >";
                echo "</div>";
            }
            if($langcookie=="hi") {
                echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                echo "<input class='Proceed transition disabled' type='submit'  value='पुष्टि कर जमा करें' >";
                echo "</div>";

            }

        }else if($_COOKIE['step_agenda'] == "1" && $_COOKIE['step_vote'] == "0"){
            if($langcookie=="en"){
                echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                echo "<input class='Proceed transition disabled' type='submit'  value='Continue and Choose the Leader' >";
                echo "</div>";
            }
            if($langcookie=="hi") {
                echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                echo "<input class='Proceed transition disabled' type='submit'  value='आगे बढ़ें और नेता चुनें' >";
                echo "</div>";
            }

        }else{
            if($langcookie=="en"){
                echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                echo "<input class='Proceed transition disabled' type='submit'  value='Continue and Choose the Leader' >";
                echo "</div>";
            }
            if($langcookie=="hi") {
                echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
                echo "<input class='Proceed transition disabled' type='submit'  value='आगे बढ़ें और नेता चुनें' >";
                echo "</div>";
            }

        }
    }else{
        if($langcookie=="en"){
            echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
            echo "<input class='Proceed transition disabled' type='submit'  value='Continue and Choose the Leader' >";
            echo "</div>";
        }
        if($langcookie=="hi") {
            echo "<div class='submitAgenda' id='submitAgenda' style='visibility: visible;'>";
            echo "<input class='Proceed transition disabled' type='submit'  value='आगे बढ़ें और नेता चुनें' >";
            echo "</div>";
        }
    }

?>

<!--Uncomment this to revert the changes-->

<!--        --><?php //if($langcookie=="en"){ ?>
<!--            <div class="submitAgenda" id="submitAgenda" style="visibility: visible;">-->
<!--              <input class="Proceed transition disabled" type="submit"  value="Continue and Choose the Leader" >-->
<!--            </div>-->
<!--        --><?php //}?>
<!--        --><?php //if($langcookie=="hi"){ ?>
<!--            <div class="submitAgenda" id="submitAgenda" style="visibility: visible;">-->
<!--              <input class="Proceed transition disabled" type="submit"  value="जारी रखें और नेता चुने" >-->
<!--            </div>-->
<!--        --><?php //}?>

        
<!--Change shashwat end-->

       <!-- <div class="submitAgenda" id="hiddensubmitAgenda" style="visibility: hidden;display:none;">
          <input class="Proceed transition disabled" type="submit"  value="Continue and Choose the Leader" >
        </div>
        -->



        <div class="error" id="validation_error"></div>
      </form>
    </div>
  </div>
  <?php include('footer.php'); ?>
<!--  <script src='https://www.google.com/recaptcha/api.js'></script> -->
</div>
</body>


<script>
$(window).on("scroll", function() {
   var content_height = $(document).height();
   var content_scroll_pos = $(window).scrollTop();
    var percentage_value = content_scroll_pos * 100 / content_height;

    if(percentage_value >= 87 && ( $(window).width() < 640))
    {
        document.getElementById('submitAgenda').style.position="relative";
   
//        document.getElementById('hiddensubmitAgenda').style.visibility="visible";
  //      document.getElementById('hiddensubmitAgenda').style.display="block";
   //     document.getElementById('submitAgenda').style.visibility="hidden";
 
  }
  if (percentage_value < 87 && ($(window).width() < 640))
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

<script>




        $(function(){

            //var countCheck = 0;

            var format_spe = /[!@#$%^&*()\=\[\]{}\\|<>\/]/;

            var phone_val = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;

            var whitespaces_val = /^\s+$/;   

            checkboxCheked();

            function checkboxCheked(){
                $('.checkboxInput').each(function(){
                    var status = $(this).prop("checked");
                    if(status == true){
                       $(this).parent().parent().parent().addClass('selectedOpt');
                    }else{
                       $(this).parent().parent().parent().removeClass('selectedOpt');
                    }
                });  

                var countCheck = $('.checkboxInput:checked').size();
                var newAgenda = $.trim($('#new_agenda').val());
                var total = countCheck; 
                if(newAgenda!=''){
                    total = total + 1;
                }
                console.log(total);
				document.getElementById('left_count').innerHTML=total;
                if(total >= 1 && total < 10){
                    $('.Proceed').removeClass('disabled');
                    $('.agendaOut').removeClass('disabled');
                    $('.addAgenda').removeClass('disabled');
                }if(total >= 10){




                  $('.agendaOut').each(function(i, obj) {
                        toremove = $(this).find('.container:not(.selectedOpt)').parent()
                        toremove.addClass('disabled')
                    });
                    if(newAgenda == ""){
                        $('.addAgenda').addClass('disabled');
                    }else{
                        $('.addAgenda').removeClass('disabled');
                    }

                    $('.Proceed').removeClass('disabled');




                }if(total < 1){
                    $('.Proceed').addClass('disabled');
                }

                //$('.addAgenda').removeClass('disabled');

                var text = $("#new_agenda").val();
                if(text == "" && total < 1){
                    $('.Proceed').addClass('disabled');
                }else if((text != "") || (total >= 1 && total < 10)){
                    $('.Proceed').removeClass('disabled');
                }
            }   

            $('.addAgenda textarea').keyup(function(){
                /*var text = $(this).val();
                if(text != ""){
                    $('.Proceed').removeClass('disabled');
                }else if(text == ""){
                    $('.Proceed').addClass('disabled');
                }*/
                checkboxCheked();
                // alert(text);
            });



            function validateblanktext(stringtext) {

                if(stringtext == "" || whitespaces_val.test(stringtext) || stringtext == 0) {

                    return false;

                } else {

                    return true;

                }

            }



            $('.checkboxInput').click(function(){

                checkboxCheked()

            });



            $("#agenda_form").on("submit", function(e) {

                //$(".error").css("display","none");

                e.preventDefault();



                var countCheck = $('.checkboxInput:checked').size();

                var newAgenda = $.trim($('#new_agenda').val());

                if(newAgenda!=''){

                    if(format_spe.test(newAgenda)) {

                        $("#agenda_error").html("Please provide valid agenda.");

                        $("#agenda_error").fadeIn();

                        return false;

                    }else{

                        $("#agenda_error").html("");

                        $("#agenda_error").fadeOut();

                    }

                }

                

                /*if(grecaptcha.getResponse() == "") {

                    $("#validation_error").html("Please confirm you are not robot.");

                    $("#validation_error").fadeIn();

                    return false;

                }else{

                    $("#validation_error").fadeOut();

                }*/



                var referral_code = $("#referral_code").val();

                var referral_owner_id = $("#referral_owner_id").val();

                var formData = new FormData($("form#agenda_form")[0]);

                formData.append('referral_code', referral_code);

                formData.append('referral_owner_id', referral_owner_id);



                $.ajax({

                    url: "<?php echo base_url(); ?>agenda/addUserAgenda",

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

                        }else if(result.status == "php_error"){ 

                            var error = '';  

                            $.each( result.msg, function( index, object ){

                                error += '<p>'+object+'</p>';

                            });

                            $("#validation_error").html(error);

                            $("#validation_error").fadeIn();

                            return false;

                        }else{

                            // Code shashwat start

                            window.location.href ="<?php

                                if (isset($_COOKIE['step_agenda']) && isset($_COOKIE['step_vote'])){
                                    if($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "0"){
                                        echo base_url()."vote";
                                    }else if($_COOKIE['step_agenda'] == "0" && $_COOKIE['step_vote'] == "1"){
                                        echo base_url()."thankyou";
                                    }else if($_COOKIE['step_agenda'] == "1" && $_COOKIE['step_vote'] == "0"){
                                        echo base_url()."vote";
                                    }else{
                                        echo base_url()."vote";
                                    }
                                }else{
                                    echo base_url()."vote";
                                }

                            ?>"
                            //window.location.href = "<?php //echo base_url(); ?>//vote";

                            // Code shashwat end

                        }

                    }

                });

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

                    url: "<?php echo base_url(); ?>agenda/check_user",

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

                    url: "<?php echo base_url(); ?>agenda/verify_otp",

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

                    url: "<?php echo base_url(); ?>agenda/resend_otp",

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

    </script>
<script>
function checkFilled() {
    var inputVal = document.getElementById("new_agenda");
	var add_agenda_sec=document.getElementById("add_agenda_sec");
	var new_agenda_icon=document.getElementById("new_agenda_icon");
	new_agenda_icon.classList.add("highlight_after_input");
    if (inputVal.value != "") {
        add_agenda_sec.style.backgroundColor = "#018C4A";
		new_agenda_icon.classList.add("highlight_after_input");
    document.getElementById('test').style.visibility = 'visible';
    document.getElementById('test').innerHTML = inputVal.value;
	document.getElementById('agendaclscustom_inner').style.opacity=0;
	document.getElementById('agendaoverlay').style.opacity=1;
    }
    else{
        add_agenda_sec.style.backgroundColor = "";
		new_agenda_icon.classList.remove("highlight_after_input");
     document.getElementById('test').style.visibility = 'hidden';
   document.getElementById('agendaclscustom_inner').style.opacity=1;
	document.getElementById('agendaoverlay').style.opacity=0;
    }

}

checkFilled();
</script>
<script>
		$(document).ready(function() {
			var text_max = 300;
		 <?php if($langcookie=="en"){ ?>    
			var a=' characters remaining'; 
			<?php }?>
			<?php if($langcookie=="hi"){ ?>    
			var a=' अक्षर बाकी'; 
			<?php }?>
			
			$('#textarea_feedback').html(text_max + a);

			$('#new_agenda').keyup(function() {
				var text_length = $('#new_agenda').val().length;
				var text_remaining = text_max - text_length;

				$('#textarea_feedback').html(text_remaining + ' characters remaining');
			});
		});
		
if ( $(window).width() < 1024) {
	
}
	</script>
</html>
