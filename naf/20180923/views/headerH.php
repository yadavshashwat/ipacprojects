<header>
	<div class="headIn">
		<a href="<?php echo base_url();?>"><img class="logo" src="<?php echo base_url()?>assets/images/logo.png"><img class="name" src="<?php echo base_url()?>assets/images/name.png"></a><!-- <div class="name">
		<h3>NATIONAL AGENDA FORUM</h3>
			<p>Initiative of Indian Political Action Committee</p>
		</div> -->
		<?php 
		$status = 1;
		if(isset($_SESSION['user']['log_in']) && $_SESSION['user']['log_in']){
			$status = 0;
		}
		
		if($title!='Result' && $status){ ?>
		<!-- <div class="registerBtn transition">Login</div> -->
			<div class="registerMobile">
				<?php
					//if(!isset($show_popup)){
				?>
					<p>Already Registered? <span class="topSeeResult">See Result</span></p><form id="pta_form1" name="pta_form1" autocomplete="off" method="POST">
						<div class="indiaCode">+91</div><input class="mobileNumber" type="text" placeholder="Enter Your Mobile Number" name="pta_mobile_number" id="pta_mobile_number" autocomplete="off" maxlength="10" minlength="10"><input type="submit" class="btn" value="GET OTP">
						<div class="error" id="blank">Please enter your mobile number</div>
		                <div class="error" id="valid">Please enter valid mobile number</div>
		                <div class="error" id="custom_error"></div>
		            </form>
		        <?php
		        	//}
		        ?>
			</div>
			<?php } ?>
		<!--<div class="langOpt">-->
		<!--	<a href=""><p>Hindi</p></a><a href=""><p class="selectedLang">ENGLISH</p></a>-->
		<!--</div>-->
		
	</div>
	<!-- <div class="btnCert shrBtn">
        <?php
            $url = base_url();
        ?>
		<div class="shareDiv">
            <a href="https://www.facebook.com/sharer/sharer.php?s=100&p[url]=<?php echo $url; ?>&p[title]=National Agenda Forum&p[summary]=Initiative of Indian Political Action Committee" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=250'); return false"><svg class="fbImg" viewBox="0 0 8379 8379"><g id="Layer_x0020_1"><rect class="fil0" height="8379" width="8379"/><path class="fil1" d="M5111 3490l-627 0 0 -412c0,-154 102,-190 174,-190 72,0 443,0 443,0l0 -680 -610 -3c-677,0 -832,507 -832,832l0 453 -392 0 0 701 392 0c0,899 0,1983 0,1983l825 0c0,0 0,-1095 0,-1983l556 0 71 -701z"/></g></svg></a><a href="https://twitter.com/share?text=Initiative of Indian Political Action Committee&url=<?php echo $url; ?>&via=National Agenda Forum&hashtags=NAF" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=250'); return false"><svg class="twitImg" viewBox="0 0 9291 9291"><g id="Layer_x0020_1"><rect class="fil0" height="9291" width="9291"/><path class="fil1" d="M6852 3277c-162,72 -336,120 -520,142 188,-112 331,-289 399,-501 -178,106 -373,180 -576,220 -165,-176 -400,-286 -660,-286 -500,0 -906,405 -906,906 0,70 8,140 24,206 -753,-38 -1420,-398 -1867,-946 -78,134 -122,289 -122,455 0,314 160,592 403,754 -144,-5 -285,-43 -411,-113l0 11c0,439 312,805 727,888 -77,21 -156,32 -239,32 -58,0 -115,-6 -170,-16 115,359 449,621 846,628 -311,243 -701,388 -1125,388 -73,0 -145,-4 -216,-13 401,257 877,407 1388,407 1665,0 2576,-1380 2576,-2576 0,-39 -1,-78 -3,-117 178,-128 331,-287 452,-469z"/></g></svg></a><a onclick="share_on_whatsapp('<?php echo $url; ?>', 'National Agenda Forum Initiative of Indian Political Action Committee')" href="javascript:;"><svg class="whatsImg" viewBox="0 0 8379 8379"><g id="Layer_x0020_1"><rect class="fil0" height="8379" width="8379"/><g id="_899307880"><path class="fil1" d="M6460 4075c-30,-1197 -1016,-2158 -2229,-2158 -1199,0 -2176,939 -2229,2117 -1,32 -2,65 -2,97 0,419 117,809 320,1143l-402 1188 1235 -393c320,175 687,276 1078,276 1232,0 2230,-991 2230,-2214 0,-19 0,-38 -1,-56zm-2229 1917l0 0c-381,0 -735,-113 -1032,-308l-720 229 233 -691c-224,-307 -357,-684 -357,-1091 0,-61 3,-121 10,-181 92,-942 894,-1680 1866,-1680 984,0 1794,757 1869,1716 4,48 6,96 6,145 0,1026 -842,1861 -1875,1861z"/><path class="fil1" d="M5253 4578c-55,-27 -324,-159 -374,-177 -50,-18 -87,-27 -123,28 -37,54 -142,176 -173,211 -33,37 -64,41 -119,14 -55,-27 -231,-83 -440,-269 -162,-143 -273,-321 -304,-375 -31,-54 -3,-84 24,-111 25,-25 54,-64 83,-95 7,-9 13,-18 19,-26 13,-20 22,-39 35,-65 19,-36 9,-68 -4,-95 -14,-27 -123,-294 -169,-403 -45,-108 -91,-90 -124,-90 -31,0 -68,-5 -104,-5 -37,0 -96,14 -146,68 -50,54 -191,186 -191,453 0,63 11,125 28,185 55,191 174,349 195,376 27,35 378,601 934,820 556,216 556,144 656,134 101,-8 324,-130 369,-258 46,-126 46,-235 32,-258 -13,-21 -50,-35 -104,-62z"/></g></g></svg></a>
        </div>  
    </div> -->
</header>


<div class="popup loaderPopup">
    <div class="popupIn">
        <div class="table_cell">
            <img src="<?php echo base_url()?>assets/images/loader.svg">
        </div>
    </div>
</div>

<!-- <div class="breadCrums">
	<p>1. VOTE</p><img src="<?php echo base_url()?>assets/images/bcImg.png"><p>2. REGISTER</p><img src="<?php echo base_url()?>assets/images/bcImg.png"><p>3. RESULTS</p>
</div> -->

<!-- <div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'hi', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->