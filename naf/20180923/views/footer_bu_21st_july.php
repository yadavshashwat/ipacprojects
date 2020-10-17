<footer>
	<div class="footerIn">
		<ul>
			<a href="http://www.indianpac.com" target="_blank"><li>I-PAC</li></a><!-- <li>Download brochure</li> --><a href="<?php echo base_url()?>assets/images/NAF-Concept-Note.pdf" target="_blank"><li id="about">NAF Concept Note</li></a><li class="openPopup" id="faq">NAF FAQs</li><li class="openPopup" id="privacy">Privacy Policy</li><li class="openPopup" id="terms">Terms & Conditions</li>
		</ul>
		<div class="copyright">
			<div class="copyright-ipac">I-PAC All rights reserved &copy;2018  &nbsp|&nbsp</div>
			<div class="follow_flex">
            <span style="float:left;">Follow us:&nbsp</span>
				<a href="https://www.facebook.com/IndianPAC/" target="_blank" style="float:left;line-height: 0px"><img height="30px" src="<?php echo base_url() ?>/assets/images/fb.svg"/></a>
				<a href="https://twitter.com/IndianPAC" target="_blank" style="float:left;line-height: 0px"><img height="30px" src="<?php echo base_url() ?>/assets/images/twit.svg"/></a>
			</div>
		</div>
	</div>
</footer>


<div class="popup registerPopup popUpOverlayClose">
    <div class="popupIn">
        <div class="table_cell">
            <div class="popupData">
            	<div class="closePopup">Close</div> 
                <h5>Please Enter Your Mobile Number to see the result.</h5>
                <!-- <a href="<?php echo base_url();?>agenda"><div class="btn transition">Set The Agenda</div></a> -->
                <?php 
				$status = 1;
				if(isset($_SESSION['user']['log_in']) && $_SESSION['user']['log_in']){
					$status = 0;
				}
                if($title!='Result' && $status){ ?>
				<!-- <div class="registerBtn transition">Login</div> -->
					<div class="registerMobile">
			            <!-- <div class="btn resultBtn transition">View Result</div> -->
						<?php
							//if(!isset($show_popup)){
						?>
							<form id="pta_form1" name="pta_form1" autocomplete="off" method="POST">
								<div class="indiaCode">+91</div><input class="mobileNumber" type="text" placeholder="Enter Your Mobile Number" name="pta_mobile_number" id="pta_mobile_number" autocomplete="off" maxlength="10" minlength="10"><input type="submit" class="btn transition submitBtn" value="GET OTP">
								<div class="error" id="blank">Please enter your mobile number</div>
				                <div class="error" id="valid">Please enter valid mobile number</div>
				                <div class="error" id="custom_error"></div>
				            </form>
		                    
				        <?php
				        	//}
				        ?>
					</div>
				<?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="popup setPopup popUpOverlayClose" >
    <div class="popupIn">
        <div class="table_cell">
            <div class="popupData">
            	<div class="closePopup">Close</div> 
                <h5>Please Set The Agenda First</h5>
                <a href="<?php echo base_url();?>agenda"><div class="btn transition">Set The Agenda</div></a>
            </div>
        </div>
    </div>
</div>
<div class="popup infoPopup popUpOverlayClose" >
	<div class="popupIn">
		<div class="table_cell">
			<div class="popupData">
				<div class="closePopup">Close</div>
				<h5 style="margin-top: 20px;margin-bottom: 0;">You have not registered yet. </h5><br>
				<div style="text-align: center;"><em style="position: relative;top: -10px;font-size: 15px;">Make sure you have already voted and also registered to see the result.</em></div>
				<!--                <a href="--><?php //echo base_url();?><!--agenda"><div class="btn transition">Set The Agenda</div></a>-->
			</div>
		</div>
	</div>
</div>
<div class="popup otpPopup" >
    <div class="popupIn">
        <div class="table_cell">
            <div class="popupData">
                 <div class="closePopup">Cancel</div> 
                <h5>Enter OTP</h5>
                <form name="otp_submit" id="otp_submit" autocomplete="off">
                    <input type="number" name="user_otp" id="user_otp" value=""><input class="btn" type="submit" value="Submit">
                    <p class="resendOtp"><span>Resend OTP</span></p>
                    <div class="error">
                        <span id="user_otp_error"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="popup popUpOverlayClose infoDataPopup">
    <div class="popupIn">
        <div class="table_cell">
            <div class="popupData infoPopupData">
                <div class="closePopup">Close</div>
                <div class="infoIn termsInfo">
	                <h5>TERMS AND CONDITIONS FOR ENGAGEMENT AS PART TIME ASSOCIATES</h5>
	                <p>The following terms and conditions contained herein (“Terms and Conditions”) shall govern   your engagement as a Part Time Associate (“PTA”/”You”) with Indian PAC Consulting Pvt. Ltd. ("I-PAC"), a private limited company incorporated under the provisions of the Companies Act, 1956 and an existing company under the provisions of the Companies Act, 2013 having its registered office at Flat No-4A, Khushi Vila, East Boring Canal Road, Patna-800001.</p>
	                <h5 class="termHead">TERMS AND CONDITIONS</h5>
	                <ul class="numberBullets">
	                	<li>Your usage of the website- <a href="http://www.indianpac.com" target="_blank">http://www.indianpac.com/</a> (including all sub-pages thereof) shall be governed by I-PAC’s Fair Usage Policy and all applicable laws.</li>
	                	<li>By clicking on the “I Agree” button provided on PTA registration form you undertake that you have perused the Terms and Conditions and the Fair Usage Policy contained herein, in its entirety and agree to comply with the same without any coercion, duress or misrepresentation by I-PAC, any of its employees or any other third party.</li>
	                 	<li>You shall grant I-PAC the absolute right and authority to use your Personal Information (as defined under applicable laws) and all other information submitted by you during the course of your engagement as a PTA for communication, promotion or engagement in any manner it may deem fit, at its sole discretion. However, I-PAC warrants that your Personal Information will not be shared with any external third party without your consent.</li>
	                	<li>Your engagement as a PTA is strictly on a temporary and voluntary basis only and does not create an Employer-Employee relationship between you and I-PAC. Therefore, you shall not have any claims for remuneration, reimbursement or any other benefits available to an employee of I-PAC.</li>
	                	<li>There is no obligation on I-PAC to absorb you as an employee or offer an internship with I-PAC post the expiry or termination of your engagement, whichever is earlier.</li>
	                	<li>All the information, data and content received by you from I-PAC or any of its employees (whether in written or verbal form), is the proprietary information of I-PAC and you shall not disclose or divulge such information to any third party except with the prior written authorization of I-PAC.</li>
	                	<li>You hereby undertake that you will own or procure (at your own cost) the intellectual property rights to all the content created or provided by you during the course of your engagement with I-PAC. Further, you shall provide a royalty-free worldwide license to I-PAC to use the content generated by you in a manner it deems fit, at its sole discretion.</li>
	                	<li>You hereby indemnify to the fullest extent the Company, its officers, directors, employees, agents from and against any and all liabilities, costs, demands, causes of action, damages and expenses (including reasonable attorney’s fees) resulting from or alleged to result from the violation of these Terms and Conditions.</li>
	                	<li>Upon violation of any of these Terms by you, I-PAC reserves the right to take appropriate actions to prevent/control such violation.</li>
	                	<li>In no event shall I-PAC nor any of its officers, directors and employees, be liable to you for anything arising out of or in any way connected with your use of this Website, whether such liability is under contract, tort or otherwise, and I-PAC, including its officers, directors and employees shall not be liable for any indirect, consequential or special liability arising out of or in any way related to your use of this Website.</li>
	                	<li>If any provision of these Terms and Conditions is found to be unenforceable or invalid under any applicable law, such unenforceability or invalidity shall not render these Terms and Conditions unenforceable or invalid as a whole, and such provisions shall be deleted without affecting the remaining provisions herein.</li>
	                	<li>I-PAC may, in its sole discretion, amend or revise these Terms and Conditions from time to time with or without any notification. Your consent shall be deemed to be provided to such revised terms and conditions in the absence of any specific written objection or query from you to IPAC.</li>
	                	<li>These Terms, including any legal notices and disclaimers contained on this Website, constitute the entire agreement between Company and you in relation to your use of this Website, and supersede all prior agreements and understandings with respect to the same.</li>
						<li>You shall not at any time, in any way publicly disparage, call into disrepute, defame, slander or otherwise criticize I-PAC or any of its clients.</li>
						<li>I-PAC reserves the right to terminate your engagement immediately at any point without any notice, at its sole discretion on grounds including but not limited to gross negligence, misconduct, fraud, misrepresentation, vandalism, harassment or any other grounds as it may deem fit.</li>
						<li>These Terms and Conditions shall be governed by the laws of India and any dispute arising from or in relation to this shall be subject to the exclusive jurisdiction of the courts of Hyderabad, Telangana.</li>
	                </ul>
	            </div>
                <div class="infoIn aboutInfo">
	                <h5>About NAF</h5>
	                <p>Taking the spirit forward, 73 years later, I-PAC together with its associates and volunteers attempts to bring together millions of fellow citizens through the <b>National Agenda Forum (NAF)</b>, a pan-India initiative to <b>resurrect the conversation</b> arounf Gandhi's 18-point Contructive Programme and use it to <b>re-imagin and co-create India's priority</b> to formulate an actionable agenda for the present.</p>
	                <p>Inspired by Gandhi's Contructive Programme for a new India.</p>
	            </div>
	            <div class="infoIn faqInfo">
	            	<h5>About the Indian Political Action Committee (I-PAC)</h5>
	            	<div class="qtnOut">
		            	<!--<p class="qtnNo">1. </p>-->
		            	<h6>1.	What is I-PAC?</h6>
		            	<p>I-PAC is a platform of choice for educated youth and young professionals who want to participate in the Indian political system and contribute meaningfully in setting the agenda for incoming governments, without necessarily being part of a political party.</p>
		            	<p>I-PAC started as Citizens for Accountable Governance (CAG) in 2013 and has been operating in the socio-political domain since the last 5 years. This group, founded by young professionals from renowned academic and professional backgrounds, is described as “India’s first Political Action Committee”. I-PAC has transformed the way elections are fought in India by introducing professionalism and innovation at scale in campaigning.</p>
                        <p>I-PAC aims to bridge the gap between citizens' aspirations and the incoming Government's priorities in its endeavor to support the election of visionary, progressive and inclusive leaders to public offices. I-PAC has ensured that citizens' agenda becomes focal to its campaigns through 'Nitish ke Saat Nishchay' in Bihar and 'Captain de Nau Nukte' in Punjab. In UP, through the 'Kisan Yatra', I-PAC brought back the focus on the demand for farm loan waiver which found resonance across the country.</p>
		            </div>
		            <div class="qtnOut">
		            	<!--<p class="qtnNo">2. </p>-->
		            	<h6>2.	Is I-PAC affiliated to any particular political party? </h6>
		            	<p>I-PAC is not affiliated to any political party. The group has worked with different parties across the political spectrum, including the BJP, Mahagatbandhan (JDU, INC, RJD), INC and are currently working with YSRCP.</p>
		            </div>
                    <h5>About the National Agenda Forum (NAF)</h5>
		            <div class="qtnOut">
		            	<!--<p class="qtnNo">3. </p>-->
		            	<h6>1.	What is NAF?</h6>
		            	<p>NAF is a pan-India initiative to resurrect the conversation around Gandhiji’s 18-point Constructive Programme and use it to re-imagine and co-create India’s priorities to formulate an actionable agenda for contemporary India.</p>
		            	<p>NAF has four action points for everyone:</p>
		            	<ul>
		            		<li>Share the Vision: Make the nation aware of Gandhiji’s 18-point Constructive Programme</li>
		            		<li>Set the Agenda: Contribute and vote to set the actionable agenda for contemporary India</li>
		            		<li>Choose the Leader: Vote for the Leader best suited to adopt and execute this agenda </li>
                            <li>Campaign for India: Help the chosen Leader to get elected in the upcoming General Elections</li>
		            	</ul>
		            </div>
		            <div class="qtnOut">
		            	<!--<p class="qtnNo">4. </p>-->
		            	<h6>2.	Why is I-PAC launching NAF?</h6>
		            	<p>As the nation comes together to celebrate Mahatma Gandhi’s 150<sup>th</sup> Birth Anniversary year, I-PAC aims to resurrect the conversation around one of his most important pieces of work – an 18-point Constructive Programme for Poorna Swaraj.  Written over a period of time and last shared by Mahatma Gandhi in 1945, this 18-point Constructive Programme outlined the key priorities for independent India. </p>
                        <p>Gandhiji had said, <font style="font-style:italic">&ldquo;My list does not pretend to be exhaustive; it is merely illustrative&rdquo;</font>. He mentioned that the readers will see several new and important additions and encouraged them to add what in their opinion should be part of the key priorities of India.</p>
		            	<p>Taking this spirit forward, 73 years later, I-PAC together with its associates and volunteers attempts to bring together millions of fellow citizens through NAF to formulate an agenda for contemporary India and choose the leader who could take this agenda forward.</p>
		            </div>
		            <div class="qtnOut">
		            	<!--<p class="qtnNo">5. </p>-->
		            	<h6>3.	What can be included as a part of the agenda?</h6>
		            	<p>The agenda points will pertain to the principles of the Constructive Programme and include items of critical national importance which require government action. Citizen are free to add in other points which they think are of national importance.</p>
		            	
		            </div>
		            <div class="qtnOut">
		            	<!--<p class="qtnNo">6. </p>-->
		            	<h6>4.	Will the results of the voting process be open to the public?</h6>
		            	<p>Yes, citizens will be able to view the results upon voting and those who choose to register as Part Time Associates (PTAs) of I-PAC will be able to come back and view results at any time during the voting process.</p>
		            </div>
		            <div class="qtnOut">
		            	<!--<p class="qtnNo">7. </p>-->
		            	<h6>5.	How can I become a part of NAF?</h6>
		            	<p>Apart from sharing the vision, setting the agenda and choosing the leader, you can get involved in driving NAF by registering to be a Part Time Associate (PTA) with I-PAC using the ‘Register’ button on the website</p>
		            </div>
		            <div class="qtnOut">
		            	<!--<p class="qtnNo">8. </p>-->
		            	<h6>6.	What is the timeline of the entire campaign?</h6>
		            	<ul>
		            		<li>11 Jul&rsquo;18: Voting opens to set the key national priorities and choose the leader </li>
		            		<li>15 Aug&rsquo;18: Voting Results</li>
		            		<li>Sep&rsquo;18 – Oct&rsquo;18: Meetings with the Leader</li>
                            <li>Oct&rsquo;18 – Jan&rsquo;19: Taking the agenda to the nation</li>
                            <li>Jan&rsquo;19 – Feb&rsquo;19: Adoption of agenda as part of official manifesto of the party</li>
		            	</ul>
		            </div>
                    
                    <h5>About Part Time Associates (PTAs)</h5>
		            <div class="qtnOut">
		            	<!--/*<p class="qtnNo">9. </p>*/-->
		            	<h6>1.	Who are PTAs?</h6>
		            	<p>PTAs are young Indians who have voluntarily associated with I-PAC to help drive NAF and other national initiatives. </p>
		            </div>
		            <div class="qtnOut">
		            	
		            	<h6>2.	Why should I become a PTA?</h6>
		            	<p>By choosing to be a PTA, the youth get to:</p>
                        <ul>
		            		<li>Be an active member in <b>shaping the key political discourse in India</b></li>
		            		<li>Be a partner in <b>I-PAC’s decision-making process</b></li>
		            		<li>Be a preferred <b>applicant for internship and job opportunities</b> at I-PAC</li>
                            <li>Engage with the <b>national leadership</b></li>
                            <li>Be a core driver of <b>people’s campaigns like NAF</b></li>
                            <li>Be eligible for <b>NAF Certificates of achievement</b></li>
		            	</ul>
		            </div>
		            <div class="qtnOut">
		            	
		            	<h6>3.	How can I become a PTA?</h6>
		            	<p>By registering under the ‘Campaign for India’ section at <a href="http://www.indianpac.com/naf/" target="_blank">www.indianpac.com/naf</a></p>
		            </div>
		            
		            <div class="qtnOut">
		            	
		            	<h6>4.	What is the role of PTAs in NAF?</h6>
		            	<p>Here's how PTAs can help I-PAC to drive NAF:</p>
		            	<p>SHARE THE VISION</p>
                        <ul>
		            		<li>Help start the conversation around Gandhiji's vision for India.</li>
		            		<li>Visit <a href="http://www.indianpac.com/naf/" target="_blank">www.indianpac.com/naf</a>  now to "Share the Vision".</li>
		            	</ul>
                        <p>SET THE AGENDA and CHOOSE THE LEADER</p>
                        <ul>
		            		<li>Get people to vote for their choice of agenda and the leader.</li>
		            		<li>Voting opens on 11<sup>th</sup> July.</li>
		            	</ul>
                        <p>CAMPAIGN FOR INDIA</p>
                        <ul>
		            		<li>Form a team of like-minded individuals to work alongside you.</li>
		            		<li>Get them to register at <a href="http://www.indianpac.com/naf/" target="_blank">www.indianpac.com/naf</a>  now using your Referral ID (your registered Email ID).</li>
		            	</ul>
		            </div>
		            
	            </div>

	            <div class="infoIn privacyInfo">
	            	<h5>NAF Privacy Policy</h5>
	            	<p>Your privacy is important to us and this Privacy Policy shall govern your engagement as a Part Time Associate (“PTA”/”You”) with Indian PAC Consulting Pvt. Ltd. ("I-PAC, "us", "we") and your usage of the website <a href="http://www.indianpac.com/" target="_blank">http://www.indianpac.com/</a> (hereinafter referred to as the “website”). </p>
					<p>By visiting and/or using the website you have agreed to the following Privacy Policy. If you disagree with any part of this policy, please do not use our website. This policy provides information about the personal information that the website collects, and the ways in which the website uses that personal information.</p>
	            	<div class="qtnOut">
		            	<!-- <p class="qtnNo">1. </p> -->
		            	<h6>Personal information collection:</h6>
		            	<p>Personal Information means and includes all information that can be linked to a specific individual or to identify any individual, such as name, address, mailing address, telephone number, e-mail address, Aadhar number, constituency, voter details, information about the constituency, and any and all details that may be requested while any user visits or uses the website.</p>
						<p>We may collect and use the following kinds of personal information that you provide using for the purpose of registering with the website:</p>
						<ul>
							<li>Name</li>
							<li>Address</li>
							<li>Phone number</li>
							<li>Email address</li>
							<li>Date of birth</li>
							<li>College information</li>
							<li>Vote preference</li>
							<li>Other data that could directly or indirectly identify you</li>
						</ul>
		            </div>
		            <div class="qtnOut">
		            	<!-- <p class="qtnNo">2. </p> -->
		            	<h6>Using personal information:</h6>
		            	<p>We may use your personal information:</p>
		            	<ul>
		            		<li>For communication through Email, SMS, Calls, IVR, WhatsApp and social media platforms</li>
		            		<li>To display your information (name, photo, college, state and district) on our website and other I-PAC`s social media properties</li>
		            	</ul>
		            	<p>This is also to inform you that your information will never be shared with any third party and your vote preference will never be shown to public. Polling data will be used at overall level to show the final results.</p>
		            </div>
		            <div class="qtnOut">
		            	<!-- <p class="qtnNo">3. </p> -->
		            	<h6>Securing of your data:</h6>
		            	<p>We will store all the personal information provided by you on our secured servers and will take reasonable technical and organizational precautions to prevent the loss, misuse or alteration of your personal information.</p>
		            </div>
		            <div class="qtnOut">
		            	<!-- <p class="qtnNo">4. </p> -->
		            	<h6>Compliance with legal, regulatory, and law enforcement requests:</h6>
		            	<p>We cooperate with law enforcement and government officials and private parties to comply with the law. We will, in our sole discretion, disclose any information about you to such parties as necessary to respond to claims and legal processes, to protect our property and rights or the property and rights of a third party, to protect the safety of the public or an individual, or to prevent or stop illegal or unethical activity.</p>
		            	<p>If we are legally permitted to do so, we will take reasonable steps to notify you in the event we are required to provide your information to third parties as part of a legal process.</p>
		            </div>
		            <div class="qtnOut">
		            	<!-- <p class="qtnNo">4. </p> -->
		            	<h6>Updating this statement:</h6>
		            	<p>We may update this privacy policy by posting a new version on the website and we encourage you to review our Privacy Policy, occasionally to ensure you are familiar with any changes.</p>
		            </div>
	            </div>
                <div class="infoIn privacyInfo">
	            	<h5>NAF FAIR USE POLICY</h5>
	            	<p>Welcome to our website. If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use, which together with our privacy policy govern Indian Political Action Committee Private Limited’s (I-PAC) relationship with you in relation to this website. If you disagree with any part of these terms and conditions, please do not use our website.</p>
					<p>The term 'I-PAC' or 'us' or 'we' refers to the owner of the website whose registered office is Flat No-4A, Khushi Vila, East Boring Canal Road, Patna-800001. The term 'you' refers to the user or viewer of our website.</p>
	            	<div class="qtnOut">
		            	<!-- <p class="qtnNo">1. </p> -->
						<p>The use of this website is subject to the following terms of use:</p>
						<ul>
							<li>The content of the pages of this website is for your general information and use only. It is subject to change without notice.</li>
							<li>Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.</li>
							<li>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any information available through this website meet your specific requirements.</li>
							<li>This website contains material which is owned by or licensed to us. This material includes, but is not limited to, the design, layout, look, appearance and graphics. Reproduction is prohibited other than in accordance with the copyright notice, which forms part of these terms and conditions.</li>
							<li>All trademarks reproduced in this website which are not the property of, or licensed to, the operator are acknowledged on the website.</li>
							<li>Unauthorized use of this website may give rise to a claim for damages and/or be a criminal offence.</li>
							<li>From time to time this website may also include links to other websites. These links are provided for your convenience to provide further information. They do not signify that we endorse the website(s). We have no responsibility for the content of the linked website(s).</li>
							<li>Your use of this website and any dispute arising out of such use of the website is subject to the laws of India and the courts at Hyderabad, Telangana shall have exclusive jurisdiction to adjudicate such disputes</li>
						</ul>
		            </div>
                    
                    <div class="qtnOut">
		            	<!-- <p class="qtnNo">4. </p> -->
		            	<h6>Thank you for using the Website!</h6>
		            </div>
	            </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<script src="https://connect.facebook.net/en_US/all.js"></script>
<script src="<?php echo base_url()?>assets/js/slick.js" ></script>
<script src="<?php echo base_url()?>assets/js/main.js" ></script>
<script src="<?php echo base_url()?>assets/owl/dist/owl.carousel.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery-ui.min.js"></script>
<script>
   $(document).ready(function(){
      var owl = $('.owl-carousel');
      owl.owlCarousel({
         loop:true,
         items:3,
         margin:30,
         autoplay:true,
         autoplayTimeout:3000,
         autoplayHoverPause:true,
         nav:true,
         responsive:{
            0:{
               items:1,
               nav:false,
               loop:true,
				autoplay:true,
				autoplayTimeout:2000,
				autoplayHoverPause:true
            },
            600:{
               items:1,
               nav:false,
               loop:true,
				autoplay:true,
				autoplayTimeout:2000,
				autoplayHoverPause:true
            },
            1000:{
               loop:true,
               items:3,
               nav:true,
                autoplay:true,
                autoplayTimeout:3000,
                autoplayHoverPause:true
            }
         }
      });
      var owlPta = $('.owl-carousel-pta');
      owlPta.owlCarousel({
         items:5,
         loop:true,
         margin:10,
         autoplay:true,
         autoplayTimeout:3000,
         autoplayHoverPause:true,
         responsive:{
            0:{
               loop:true,
               items:1,
               nav:true,
				autoplay:true,
				autoplayTimeout:3000,
				autoplayHoverPause:true
            },
            600:{
               loop:true,
               items:3,
               nav:true,
				autoplay:true,
				autoplayTimeout:3000,
				autoplayHoverPause:true
            },
            1000:{
               loop:true,
               items:5,
               nav:true,
                autoplay:true,
                autoplayTimeout:2000,
                autoplayHoverPause:true
            },
			1100:{
               loop:true,
               items:6,
               nav:true,
                autoplay:true,
                autoplayTimeout:2000,
                autoplayHoverPause:true
            }
         }
      });
   });
</script>
<script>
FB.init({
        //appId: '1011565352334141'
		appId: '1006900869478204'
    });
</script>




