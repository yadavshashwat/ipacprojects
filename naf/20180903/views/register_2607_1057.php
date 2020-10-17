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
        <style>
            
        </style>
        
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/show_result.css">
    </head>
    <body class="register ipac_edit_body">

        <div class="popup resultPopup popUpOverlayClose" >
            <div class="popupIn">
                <div class="table_cell">
                    <div class="popupData">
                        <div class="closePopup">Close</div> 
                        <div class="resultPopup">
                            <h2>Your Submission Summary</h2>
                            <table>
                                <tr>
                                    <th>Agenda Voted For</th>
                                </tr>
                                <?php foreach($agenda_selected['agenda_list'] as $key => $value){ ?>
                                <tr>
                                    <td><?php echo $value['agenda_name']?></td>
                                </tr>
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
                                    <th>Leader Voted For</th>
                                </tr>
                                <?php 
                                if(!empty($leader_selected['leader_list'])){?>
                                    <tr>
                                        <td><?php echo $leader_selected['leader_list']['full_name'];?></td>
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
                                <span>Step 1</span> Set the Agenda
                                <div class="bottomFlag"></div>
                            </li><li class="transition register_blur">
                                <div class="topFlag"></div>
                                <span>Step 2</span>Choose the Leader
                                 <div class="bottomFlag"></div>
                            </li><a href="<?php echo base_url()?>/vote"><li class="transition breadcrumsActive">
                                <div class="topFlag"></div>
                                <span>Step 3</span>Campaign for India
                                 <div class="bottomFlag"></div>
                            </li></a>
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
              <div class="result_table_name"> AGENDA RESULT </div>
              <div class="result_table_icon"> </div>
            </div>
        <div class="result_table_subheading">
              <div class="result_table_subname"> NAME<sup>*</sup> </div>
              <div class="result_table_votes"> VOTES (%) </div>
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
                    <div class="chart__bar_constant <?php echo 'agendacls' . $value['id']; ?>" style="width:<?php echo 100; ?>%;"> <span class="serial_data"><?php echo $i; ?>.</span> <img class="serial_img_agenda" src="<?php echo base_url() ?>assets/images/icons/icon-result<?php echo $value['id']; ?>.png"> <span class="result_topic"><?php echo $value['agenda_topic'] ?></span> </div>
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
              <div class="result_table_name"> VOTE RESULT </div>
              <div class="result_table_icon"> </div>
            </div>
        <div class="result_table_subheading">
              <div class="result_table_subname"> RANK AND NAME<sup>*</sup> </div>
              <div class="result_table_votes"> VOTES (%) </div>
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
                    <div class="chart__bar_constant_leader" style="width:<?php echo 100; ?>%;"> <span class="serial_data"><?php echo $i; ?>.</span> <img class="serial_img" src="<?php echo base_url() ?>assets/images/Leader_Photos/<?php echo $value['id']; ?>.jpg"> <span class="result_topic"><?php echo $value['full_name'] ?></span> </div>
                  </div>
                    </div>
              </div>
                </div>
            <div class="result_data_progress">
                  <div class="charts">
                <div class="chart chart--dev">
                      <div class="chart--horiz">
                    <div class="chart__bar_leader_percentage" style="width:<?php echo $total_per*2.5; ?>%;"> </div>
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
                    
                    
                    
                    
                    
                    
                    <div class="seeResult btn transition">
                        See Summary
                    </div>
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
						<p class="register_heading">Register as Part Time Associate (PTA) with I-PAC</p>
						<p class="tick_marks"><font style="color:#278747">&#10004;</font>&nbsp;&nbsp;Help the chosen Leader to get elected in the upcoming General Elections</p>
						<p class="tick_marks"><font style="color:#278747">&#10004;</font>&nbsp;&nbsp;Keep viewing the updated results</p>
					</div>
                    <div class="registerForm">
<!--                        <h4 style="margin-top:0">New Registration</h4>-->
                        <form id="regiForm" name="regiForm" autocomplete="off"> 
                            <div class="formIn">
                                <div class="formTitle">
                                    Name<sup>*</sup>
                                </div><div class="formField">
                                    <input id="regName" type="text" name="regName" placeholder="Enter Your Name">
                                    <div class="error blank">Please enter your name</div>
                                    <div class="error" id="regName_error"></div>
                                </div>
                            </div><div class="formIn">
                                <div class="formTitle">
                                    Gender<sup>*</sup>
                                </div><div class="formField">
                                    <select id="regGender" name="regGender">
                                        <option value="0">Select Gender</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                        <option value="3">Other</option>
                                    </select>
                                    <div class="error blank">Please select your gender</div>
                                    <div class="error" id="regGender_error"></div>
                                </div>
                            </div><div class="formIn DOBForm">
                                <div class="formTitle">
                                    DOB<sup>*</sup>
                                </div><div class="formField">
                                    <select class="monthDOB" id="regMonth" name="regMonth">
                                        <option value="0">Month</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                          
                                    </select><select class="dayDOB disable" id="regDay" name="regDay">
                                        <option value="0">Day</option>
                                        
                                    </select><select class="yearDOB disable" id="regYear" name="regYear">
                                        <option value="0">Year</option>
                                        
                                    </select>
                                    <!-- <input type="text" name="" placeholder="Enter Your Name"> -->
                                    <div class="error blank">Please select date of birth</div>
                                    <div class="error" id="regMonth_error"></div>
                                    <div class="error" id="regDay_error"></div>
                                    <div class="error" id="regYear_error"></div>
                                </div>
                            </div><div class="formIn mobileNo">
                                <div class="formTitle">
                                    Mobile Number<sup>*</sup>
                                </div><div class="formField">
                                    <div class="indiaCode">+91</div><input id="regMobile" class="mobileNOInout mobileNumber" type="text" name="regMobile" placeholder="Enter Your Mobile Number" maxlength="10" minlength="10">
                                    <div class="error blank">Please enter your mobile number</div>
                                    <div class="error valid">Please enter valid mobile number</div>
                                    <div class="error" id="regMobile_error"></div>

                                </div>
                            </div><div class="formIn whatsappNo">
                                <div class="formTitle">
                                    WhatsApp Number<sup>*</sup>
                                </div><div class="formField">
                                    <div class="indiaCode">+91</div><input id="regWhatsapp" class="whatsappNOInout mobileNumber" type="text" name="regWhatsapp" placeholder="Enter Your WhatsApp Number" maxlength="10" minlength="10" readonly>
                                    <label class="container sameMobile"><p>Same As Mobile Number</p>
                                        <input type="checkbox" checked="checked">
                                        <span class="checkmark"></span>
                                    </label>
                                    <div class="error blank">Please enter your whatsapp number</div>
                                    <div class="error valid">Please enter valid whatsapp number</div>
                                    <div class="error" id="regWhatsapp_error"></div>

                                </div>
                            </div><div class="formIn">
                                <div class="formTitle">
                                    Email<sup>*</sup>
                                </div><div class="formField">
                                    <input type="email" id="regEmail" name="regEmail" placeholder="Enter Your Email">
                                    <div class="error blank">Please enter your email id</div>
                                    <div class="error valid">Please enter valid email id</div>
                                    <div class="error" id="regEmail_error"></div>
                                </div>
                            </div><div class="formIn">
								<div class="formTitle">
									College Student<sup>*</sup>
								</div><div class="formField">
									<select id="regStudType" name="regStudType">
										<option value="0">No</option>
										<option value="1">Yes</option>
									</select>
									<!-- <div class="error blank">Please Enter Your Name</div> -->
								</div>
							</div><div class="formIn">
                                <div class="formTitle">
                                    Home State<sup>*</sup>
                                </div><div class="formField">
                                    <select id="regState" name="regState">
                                        <option value="0">Select State</option>
                                        <?php 
                                        foreach ($all_state as $key => $value) { ?>
                                            <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                                        <?php }
                                        ?>
                                    </select>
                                     <div class="error blank">Please select state</div>
                                </div>
                            </div><div class="formIn">
                                <div class="formTitle">
                                    Home District<sup>*</sup>
                                </div><div class="formField">
                                    <select id="regDistrict" name="regDistrict">
                                        <option value="0">Select District</option>
                                    </select>
                                    <div class="error blank">Please select district</div>
                                </div>
                            </div><div class="formIn" style="display: none;">
                                <div class="formTitle">
                                    College State<sup>*</sup>
                                </div><div class="formField">
                                    <select id="regCollgState" name="regCollgState">
                                        <option value="">Select State</option>
                                        <?php 
                                        foreach ($all_state as $key => $value) { ?>
                                            <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                                        <?php }
                                        ?>
                                    </select>
                                    <div class="error blank">Please select your college state</div>
                                </div>
                            </div><div class="formIn" style="display: none;">
                                <div class="formTitle">
                                    College District<sup>*</sup>
                                </div><div class="formField">
                                    <select id="regCollgDistrict" name="regCollgDistrict">
                                        <option value="">Select District</option>
                                        
                                    </select>
                                    <div class="error blank">Please select collage district.</div>
                                </div>
                            </div><div class="formIn" style="display: none;">
                                <div class="formTitle">
                                    College Name<sup>*</sup>
                                </div><div class="formField">
                                    <input id="regCollName" type="text" name="regCollName" placeholder="Enter Your College Name" >
                                    <!-- <datalist id="regCollName_list">
                                        <option>colg1</option>
                                        <option>colg2</option>
                                    </datalist> -->
                                    <div class="error blank">Please select your college name</div>
                                </div>
                            </div><div class="formIn">
                                <div class="formTitle">
                                    Upload Profile Pic
                                </div><div class="formField">
                                    <div class="fileInput">
                                        <p class="fileName"></p>
                                        <span>Select file</span>
                                        <input id="profile_pic" type="file" name="profile_pic" accept="image/*">
                                        <p class="imgLimit">Max 1MB</p>
                                    </div>
                                    <div class="error blank">Please provide valid profile pic.</div>
                                </div>
                            </div>


                            <div class="nationalPerson">
                                <p>Name a non-political person who you think should enter politics at the national level</p>
                                <div class="formField">
                                    <input type="text" name="personality_1" id="personality_1" placeholder="Enter Non-Politician's Name">
                                    <div class="error blank">Please enter valid Personality name</div>
                                </div>
                                
                            </div><div class="nationalPerson">
                                <p>Name a non-political person who you think should enter politics at the district level</p>
                                <div class="formField">
                                    <input type="text" name="personality_2" id="personality_2"  placeholder="Enter Non-Politician's Name">
                                    <div class="error blank">Please enter valid Personality name</div>
                                </div>

                            </div>
                            
                            <input class="btn" type="submit" value="SUBMIT"><div class="phpError"></div><p class="terms">By Clicking This Button I Consent To The <span class="openPopup" id="terms">Terms & Conditions of NAF</span></p>
                            
                        </form>
                    </div>
                </div>
        	<?php include('footer.php'); ?>  
            <script type="text/javascript">
                var baseurl = "<?php echo base_url()?>";

            </script>
            <script type="text/javascript" src="<?php echo base_url()?>assets/js/validation.js"></script>
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
