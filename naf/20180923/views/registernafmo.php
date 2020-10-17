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
        <style>
            
        </style>
        
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

        <div class="popup resultPopup popUpOverlayClose" >
            <div class="popupIn">
                <div class="table_cell">
                    <div class="popupData">
                        <div class="closePopup"><?php if($langcookie=="en"){ ?> Close<?php }?>  <?php if($langcookie=="hi"){ ?>बंद करें <?php }?> </div> 
                        <div class="resultPopup">
                            <h2><?php if($langcookie=="en"){ ?> Your Submission Summary<?php }?>  <?php if($langcookie=="hi"){ ?>आपके एजेंडा और लीडर सुझाव<?php }?> </h2>
                            <table>
                                <tr>
                                    <th><?php if($langcookie=="en"){ ?>Agenda Voted For<?php }?>  <?php if($langcookie=="hi"){ ?>आपके सुझाए एजेंडा<?php }?>  </th>
                                </tr>
                                
								<?php if($langcookie=="en"){ ?>
								<?php foreach($agenda_selected['agenda_list'] as $key => $value){ ?>
                                <tr>
                                    <td><?php echo $value['agenda_name']?></td>
                                </tr>
                                <?php }?>
<?php }?>	
                                
                                
                                <?php if($langcookie=="hi"){ ?>
								<?php foreach($agenda_selected['agenda_list'] as $key => $value){ ?>
                                <tr>
                                    <td><?php echo $value['agenda_name_hindi']?></td>
                                </tr>
                                <?php }?>
<?php }?>
                                
                                
                                
                                
                                
                                                         
                                <?php 
                                if(!empty($agenda_selected['new_agenda'])){ ?>
                                <tr>
                                    <td><?php echo $agenda_selected['new_agenda'];?></td>
                                </tr>
                                <?php }
                                ?>   
                            </table>
                           <!--  <p>Agenda Voted For</p>
                            <ul>
                                <?php foreach($agenda_selected['agenda_list'] as $key => $value){ ?>
                                    <li><?php echo $value['agenda_name']?></li>
                                <?php }?>
                                <?php 
                                if(!empty($agenda_selected['new_agenda'])){ ?>
                                    <li><?php echo $agenda_selected['new_agenda'];?></li>
                                <?php }
                                ?>                                
                            </ul> -->
                            <table>
                                <tr>
                                    <th><?php if($langcookie=="en"){ ?> Leader Voted For<?php }?>  <?php if($langcookie=="hi"){ ?>आपके द्वारा चुने गये नेता<?php }?> 
                                    
                                    </th>
                                </tr>
                                <?php 
                                if(!empty($leader_selected['leader_list'])){?>
                                    <tr>
                                        <td>
										
										<?php if($langcookie=="en"){ ?><?php echo $leader_selected['leader_list']['full_name'];?><?php }?>  <?php if($langcookie=="hi"){ ?><?php echo $leader_selected['leader_list']['full_name_hindi'];?><?php }?> 
                                        
                                        </td>
                                    
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td><?php echo $leader_selected['new_leader'];?></td>
                                    </tr>
                                <?php }?>
                            </table>
                           <!--  <p>Leader Voted For</p>
                            <ul>
                                <?php 
                                if(!empty($leader_selected['leader_list'])){?>
                                <li><?php echo $leader_selected['leader_list']['full_name'];?></li>
                                <?php }else{ ?>
                                    <li><?php echo $leader_selected['new_leader'];?></li>
                                <?php }?>

                                
                            </ul> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="backImg"></div>
        <div class="wrapper">
            <?php include('header.php'); ?>
                <div class="homeMain regiMain">
                    <div class="breadcrums">
                        <ul>
                            <li class="transition register_blur">
                                <div class="topFlag"></div>
                                <?php if($langcookie=="en"){ ?>
                                <span>Step 1</span> <?php echo $step1;?>
                                <?php } ?>
                                <?php if($langcookie=="hi"){ ?>
                                <span>स्टेप-1</span> <?php echo $step1_hi;?>
                                <?php } ?>


                                <div class="bottomFlag"></div>
                            </li><li class="transition register_blur">
                                <div class="topFlag"></div>
                                <?php if($langcookie=="en"){ ?>
            <span>Step 2</span><?php echo $step2;?>
            <?php }?>
            <?php if($langcookie=="hi"){ ?>
            <span>स्टेप-2</span> <?php echo $step2_hi;?>
            <?php }?>
                                 <div class="bottomFlag"></div>
                            </li><li class="transition breadcrumsActive">
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
<!--                    <div class="topInfo">-->
<!--                        <p>Help the chosen Leader to get elected in the upcoming General Elections</p>-->
<!--                        <p><i>Register as Part Time Associate with Indian Political Action Committee</i></p>-->
<!--                    </div>-->
                    <?php if(!isset($_COOKIE['see_result'])){ ?>
                    
                    <div class="result_table_flex">
         
         
         
         
        <div class="result_table">
        <div class="result_table_heading">
              <div class="result_table_name"><?php if($langcookie=="en"){ ?>AGENDA RESULT<?php }?>  <?php if($langcookie=="hi"){ ?>एजेंडा परिणाम <?php }?> </div>
              <div class="result_table_icon"> </div>
            </div>
        <div class="result_table_subheading">
              <div class="result_table_subname"><?php if($langcookie=="en"){ ?>NAME<?php }?>  <?php if($langcookie=="hi"){ ?>नाम<?php }?><sup>*</sup> </div>
              <div class="result_table_votes"><?php if($langcookie=="en"){ ?>VOTES (%)<?php }?>  <?php if($langcookie=="hi"){ ?>वोट (%)<?php }?>  </div>
            </div>
        <div class="result_table_data">
              <?php
                    $i = 1;

                    foreach ($top_agendas as $key => $value) {

                    $total_per = 0;


                    if ($value['total_vote'] == 0) {

                        $total_per = 0;

                    } else {

                        $total_per = round(($value['total_vote'] / $total_agenda_vote) * 100, 1);

                    }


                    ?>
              <div class="result_data_wrap">
            <div class="result_data_progress_constant">
                  <div class="charts_constant">
                <div class="chart chart--dev">
                      <div class="chart--horiz">
                    <div class="chart__bar_constant <?php echo 'agendacls' . $value['id']; ?>" style="width:<?php echo 100; ?>%;"> <span class="serial_data"><?php echo $i; ?>.</span> 

                    <img class="serial_img_agenda" src="<?php echo base_url() ?>assets/images/icons/icon-result<?php echo $value['id']; ?>.png"> 

                    <span class="result_topic"><?php if($langcookie=="en"){ ?><?php echo $value['agenda_topic'] ?><?php }?>  <?php if($langcookie=="hi"){ ?><?php echo $value['agenda_topic_hindi'] ?><?php }?></span> </div>
                  </div>
                    </div>
              </div>
                </div>
            <div class="result_data_progress">
                  <div class="charts">
                <div class="chart chart--dev">
                      <div class="chart--horiz">
                    <div class="chart__bar <?php echo 'agendacls' . $value['id']; ?>" style="width:<?php echo $total_per * 3; ?>%;"> </div>
                  </div>
                    </div>
              </div>
                </div>
            <div class="result_data_percentage"> <?php echo $total_per ?>% </div>
          </div>
              <?php $i++;
                    } ?>
            </div>
      </div>
            
          <div class="result_table">
          
        <div class="result_table_heading">
              <div class="result_table_name"><?php if($langcookie=="en"){ ?> LEADER RESULT<?php }?>  <?php if($langcookie=="hi"){ ?>नेता परिणाम   <?php }?>  </div>
              <div class="result_table_icon"> </div>
            </div>
        <div class="result_table_subheading">
              <div class="result_table_subname"><?php if($langcookie=="en"){ ?>RANK AND NAME<?php }?>  <?php if($langcookie=="hi"){ ?>रैंक एवं नाम<?php }?> <sup>*</sup> </div>
              <div class="result_table_votes"><?php if($langcookie=="en"){ ?> VOTES (%)<?php }?>  <?php if($langcookie=="hi"){ ?>वोट (%)<?php }?>  </div>
            </div>
        <div class="result_table_data">
              <?php
                    $i = 1;

                    foreach ($top_leaders as $key => $value) {

                        $total_per = 0;


                        if ($value['total_vote'] == 0) {

                            $total_per = 0;

                        } else {

                            $total_per = round(($value['total_vote'] / $total_votes) * 100, 1);

                        }


                        ?>
              <div class="result_data_wrap">
            <div class="result_data_progress_constant">
                  <div class="charts_constant">
                <div class="chart chart--dev">
                      <div class="chart--horiz">
                    <div class="chart__bar_constant_leader" style="width:<?php echo 100; ?>%;"> <span class="serial_data"><?php echo $i; ?>.</span> <img class="serial_img" src="<?php echo base_url() ?>assets/images/Leader_Photos/<?php echo $value['id']; ?>.jpg"> <span class="result_topic">

<?php if($langcookie=="en"){ ?><?php echo $value['full_name'] ?><?php }?>  <?php if($langcookie=="hi"){ ?><?php echo $value['full_name_hindi'] ?><?php }?>
                    
                      


                    </span> </div>
                  </div>
                    </div>
              </div>
                </div>
            <div class="result_data_progress">
                  <div class="charts">
                <div class="chart chart--dev">
                      <div class="chart--horiz">
                    <div class="chart__bar_leader_percentage" style="width:<?php echo $total_per; ?>%;"> </div>
                  </div>
                    </div>
              </div>
                </div>
            <div class="result_data_percentage"> <?php echo $total_per ?>% </div>
          </div>
              <?php $i++;
                    } ?>
            </div>
      </div>
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
        </div>
   
                    
                    
                    
                    
                   <!-- 
						<div class="resultIn nomiResults">
							<h2>Agenda Result</h2>
							<table>
								<thead>
								<tr>
									<th width="90">Rank</th>
									<th>Agenda</th>
									<th width="120">Votes&nbsp;(%)</th>
								</tr>
								</thead>
								<tbody>
								<?php

								$i = 1;
								foreach ($top_agendas as $key => $value) {
									$style = "";
									if($i % 2==0){
										$style = "";
									}else if($i % 3 == 0){
										$style = "background-color: #CDEEF7";
									}else if($i % 3 == 1){
										$style = "background-color: #FDEED7";
									}else if($i % 3 == 2){
										$style = "background-color: #DAECDC";
									}

									$total_per = 0;

									if($value['total_vote'] == 0){
										$total_per = 0;
									}else{
										$total_per = round(($value['total_vote']/$total_agenda_vote) * 100,1);
									}

									?>
									<tr>
										<td style="<?php echo $style;?>"><?php echo $i;?>.</td>
										<td class="agendaName" style="<?php echo $style;?>"><?php echo $value['agenda_name']?></td>
										<td style="<?php echo $style;?>"><?php echo $total_per?>%</td>
									</tr>
									<?php $i++; }?>
								</tbody>
							</table>
						</div><div class="resultIn nomiResults">
                            <h2>Leader Result</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th width="90">Rank</th>
                                        <th>Leader</th>
                                        <th width="120">Votes&nbsp;(%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $i = 1;
                                foreach ($top_leaders as $key => $value) { 
                                    $style = "";                                    
                                    if($i % 2==0){
                                        $style = "";
                                    }else if($i % 3 == 0){
                                        $style = "background-color: #CDEEF7";
                                    }else if($i % 3 == 1){
                                        $style = "background-color: #FDEED7";
                                    }else if($i % 3 == 2){
                                        $style = "background-color: #DAECDC";
                                    }

                                    $total_per = 0;
                                    if($value['total_vote'] == 0){
                                        $total_per = 0;
                                    }else{
                                        $total_per = round(($value['total_vote']/$total_votes) * 100,1);
                                    }
                                    ?>
                                    <tr>
                                        <td style="<?php echo $style;?>"><?php echo $i;?>.</td>
                                        <td class="agendaName" style="<?php echo $style;?>"><?php echo $value['full_name']?></td>
                                        <td style="<?php echo $style;?>"><?php echo $total_per?>%</td>
                                    </tr> 
                                <?php $i++; }?>
                                </tbody>
                            </table>
                        </div>
                   
                   
                   
                   
                   -->
                   
                   
                    <?php 
                        //$counter = $_COOKIE['see_result'] + 1;
                        setcookie("see_result","1",time() + (10 * 365 * 24 * 60 * 60),"/");
                    }?>
                    
                    
                    
                    
                    
<!--
                    <div class="seeResult btn transition">
                     <?php if($langcookie=="en"){ ?>See Summary<?php }?>  <?php if($langcookie=="hi"){ ?>सारांश देखें  <?php }?>
                    </div>
-->

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
						<p class="tick_marks"><font style="color:#278747">&#10004;</font>&nbsp;&nbsp;<?php if($langcookie=="en"){ ?>Help the chosen Leader to get elected in the upcoming General Elections<?php }?>  <?php if($langcookie=="hi"){ ?>चुने गये नेता की आगामी लोकसभा चुनाव जीतने में सहायता करें<?php }?></p>
						<p class="tick_marks"><font style="color:#278747">&#10004;</font>&nbsp;&nbsp;<?php if($langcookie=="en"){ ?>Keep viewing the updated results<?php }?>  <?php if($langcookie=="hi"){ ?>अपडेटेड रिजल्ट देखते रहें<?php }?></p>
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
                            </div><div class="formIn">
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
                            <div class="nationalPerson">
                                <p><?php if($langcookie=="en"){ ?>Name a non-political person who you think should enter politics at the national level<?php }?><?php if($langcookie=="hi"){ ?>एक ऐसे गैर-राजनीतिक आदमी का नाम बताएं, जिसे आपको लगता है कि राष्ट्रीय स्तर की राजनीति में प्रवेश करना चाहिए<?php }?> </p>
                                <div class="formField">
                                    <input type="text" name="personality_1" id="personality_1" placeholder="<?php if($langcookie=="en"){ ?>Enter Non-Politician's Name<?php }?><?php if($langcookie=="hi"){ ?>गैर-राजनीतिक आदमी का नाम लिखें<?php }?>">
                                    <div class="error blank"><?php if($langcookie=="en"){ ?>Please enter valid Personality name<?php }?><?php if($langcookie=="hi"){ ?>कृपया व्यक्ति का नाम सही लिखें<?php }?> </div>
                                </div>
                                
                            </div><div class="nationalPerson">
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
            <!--<script type="text/javascript" src="<?php echo base_url()?>assets/js/validation_mobi.js"></script>-->

            <script type="text/javascript">
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
                            url: baseurl + "Registernafmo/submit_register_naf_mobi",
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
                                }else if(result.status == 'php_error'){
                                    window.href.location = baseurl + "result";
                                }else if(result.status == 'php_error'){
                                    /*console.log(result["msg"]);
                                    console.log(result.msg);*/
                                    $.each(result["msg"], function(i, v) {
                                        $("#"+i+"_error").html(v);
                                        $("#"+i+"_error").fadeIn();
                                    });
                                }else{
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
                            console.log(dayCount + "---" + addOption);
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
                                url: baseurl + "registernafmo/get_all_district_in_state",
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
                                url: baseurl + "registernafmo/get_all_district_in_state",
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
                                url: baseurl + "registernafmo/get_all_collages_in_state_district",
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
                            url: baseurl +"registernafmo/check_user",
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
                            url: baseurl +"registernafmo/verify_otp",
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




            </script>

        </div>
		<!-- Google Code for Naf Conversion Conversion Page -->
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
		</noscript>
    </body>
</html>
