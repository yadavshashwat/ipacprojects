<!DOCTYPE html>
<html lang="en">
<head>
<?php include('head_element.php'); ?>
<title>NAF</title>
<meta name="description" content="" />
    <link rel="stylesheet" href="https://res.cloudinary.com/indianpac/raw/upload/v1532441970/naf/minified_css/owl-pta.carousel.min.css">
    <link rel="stylesheet" href="https://res.cloudinary.com/indianpac/raw/upload/v1532441971/naf/minified_css/owl.carousel.min.css">
    <link rel="stylesheet" href="https://res.cloudinary.com/indianpac/raw/upload/v1532441971/naf/minified_css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://res.cloudinary.com/indianpac/raw/upload/v1532441971/naf/minified_css/owl-pta.theme.default.min.css">
	<style>
		.map_active{
			background: #8080803b;
		}
	</style>
    <style>
              .customPrevBtnTestimonial{
                  position:absolute;
                  top:50%;
                  left:3%;
                  color:rgba(0,0,0,0.5);
                  cursor: pointer;
                  height:50px;
                  width:50px;
              }
              .customPrevBtnTestimonial img{
                  height:100%;
                  width:100%;
              }
              .customNextBtnTestimonial{
                  position:absolute;
                  top:50%;
                  right:3%;
                  color:rgba(0,0,0,0.5);
                  cursor: pointer;
                  height:50px;
                  width:50px;
              }
              .customNextBtnTestimonial img{
                  height:100%;
                  width:100%;
              }
@media (max-width: 768px){
.customNextBtnTestimonial {
    right: 0%;
    top: 57%;
    height: 40px;
    width: 35px;
    line-height: 50px;
}
.customPrevBtnTestimonial {
    left: 0%;
    top: 57%;
    height: 40px;
    width: 35px;
    line-height: 50px;
}
}
              .customPrevBtnPta{
                  position:absolute;
                  top:55%;
                  left:3%;
                  -webkit-filter:invert(100%);
                  filter:invert(100%);
                  cursor: pointer;
                  height:50px;
                  width:50px;
              }
              .customPrevBtnPta img{
                  height:100%;
                  width:100%;
              }
              .customNextBtnPta{
                  position:absolute;
                  top:55%;
                  right:3%;
                  -webkit-filter:invert(100%);
                  filter:invert(100%);
                  cursor: pointer;
                  height:50px;
                  width:50px;
              }

              .customNextBtnPta img{
                  height: 100%;
                  width:100%;
              }
              @media (max-width:768px){
                  .customPrevBtnPta{
                      left: 0%;
						top: 50%;
						height: 40px;
						width: 35px;
						line-height: 50px;
                  }
                  .customNextBtnPta {
					right: 0%;
					top: 50%;
					height: 40px;
					width: 35px;
					line-height: 50px;
				}
              }
          </style>
</head>
<body class="home home-wrapper">
<!--Banner container-->


<div class="header-wrapper">
  <div class="wrapper topWrap">
    <div class="backImg"></div>
    <div ></div>
    <img class="gandhiBack" src="https://res.cloudinary.com/indianpac/image/upload/naf/images/gandhi.png"> <!--<img class="gandhiBack2" src="<?php echo base_url()?>assets/images/gandhi-naf.png">--> <img class="gandhiBack3" src="https://res.cloudinary.com/indianpac/image/upload/naf/images/gandhi-charkha-naf.png">
    <?php include('header_home.php'); ?>
    <div class="aboutNAF">
      <p>As the nation celebrates the 150<sup>th</sup> Birth Anniversary year of Mahatma Gandhi, Indian Political Action Committee (I-PAC) launches the National Agenda Forum (NAF), a pan-India initiative to <b>resurrect the conversation</b> around his <a href="https://res.cloudinary.com/indianpac/image/upload/naf/images/Constructive_Programme.pdf" class="cs_link" target="_blank">18-point Constructive Programme</a> and use it to <b>re-imagine</b> and <b>co-create</b> India’s priorities to formulate an actionable agenda for contemporary India.</p>
<!-- 			<div class="btn transition shrBtn">
				Read and share the constructive programme
			</div> -->
      <div class="shareBtnOut">
      <div class="btn transition shrBtn">Read and share the constructive programme

          <?php
              $url = base_url();
          ?>
          
      </div>
      <div class="shareDiv">
          <div class="shareDivIn fbBtn">
              <svg class="fbImg" viewBox="0 0 8379 8379"><g id="Layer_x0020_1"><rect class="fil0" height="8379" width="8379"/><path class="fil1" d="M5111 3490l-627 0 0 -412c0,-154 102,-190 174,-190 72,0 443,0 443,0l0 -680 -610 -3c-677,0 -832,507 -832,832l0 453 -392 0 0 701 392 0c0,899 0,1983 0,1983l825 0c0,0 0,-1095 0,-1983l556 0 71 -701z"/></g></svg>
          </div><div class="shareDivIn twitBtn">
              <a href="https://twitter.com/share?text=Gandhiji, in his Constructive Programme (https://goo.gl/Qpphxj), had outlined the blueprint for independent India. Let's spread his vision and formulate an actionable agenda for India on his 150th Birth Anniversary year. Join %23NationalAgendaForum&p[summary]=""&url=<?php echo $url; ?>&via=National Agenda Forum&hashtags=NationalAgendaForum" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=250'); return false"><svg class="twitImg" viewBox="0 0 9291 9291"><g id="Layer_x0020_1"><rect class="fil0" height="9291" width="9291"/><path class="fil1" d="M6852 3277c-162,72 -336,120 -520,142 188,-112 331,-289 399,-501 -178,106 -373,180 -576,220 -165,-176 -400,-286 -660,-286 -500,0 -906,405 -906,906 0,70 8,140 24,206 -753,-38 -1420,-398 -1867,-946 -78,134 -122,289 -122,455 0,314 160,592 403,754 -144,-5 -285,-43 -411,-113l0 11c0,439 312,805 727,888 -77,21 -156,32 -239,32 -58,0 -115,-6 -170,-16 115,359 449,621 846,628 -311,243 -701,388 -1125,388 -73,0 -145,-4 -216,-13 401,257 877,407 1388,407 1665,0 2576,-1380 2576,-2576 0,-39 -1,-78 -3,-117 178,-128 331,-287 452,-469z"/></g></svg></a>
          </div><div class="shareDivIn whatsBtn">
          <a href="whatsapp://send?text=Gandhiji, in his Constructive Programme (https://goo.gl/Qpphxj), had outlined the blueprint for independent India. Let's spread his vision and formulate an actionable agenda for India on his 150th Birth Anniversary year. Join %23NationalAgendaForum www.indianpac.com/naf/" data-action="share/whatsapp/share"><svg class="whatsImg" viewBox="0 0 8379 8379"><g id="Layer_x0020_1"><rect class="fil0" height="8379" width="8379"/><g id="_899307880"><path class="fil1" d="M6460 4075c-30,-1197 -1016,-2158 -2229,-2158 -1199,0 -2176,939 -2229,2117 -1,32 -2,65 -2,97 0,419 117,809 320,1143l-402 1188 1235 -393c320,175 687,276 1078,276 1232,0 2230,-991 2230,-2214 0,-19 0,-38 -1,-56zm-2229 1917l0 0c-381,0 -735,-113 -1032,-308l-720 229 233 -691c-224,-307 -357,-684 -357,-1091 0,-61 3,-121 10,-181 92,-942 894,-1680 1866,-1680 984,0 1794,757 1869,1716 4,48 6,96 6,145 0,1026 -842,1861 -1875,1861z"/><path class="fil1" d="M5253 4578c-55,-27 -324,-159 -374,-177 -50,-18 -87,-27 -123,28 -37,54 -142,176 -173,211 -33,37 -64,41 -119,14 -55,-27 -231,-83 -440,-269 -162,-143 -273,-321 -304,-375 -31,-54 -3,-84 24,-111 25,-25 54,-64 83,-95 7,-9 13,-18 19,-26 13,-20 22,-39 35,-65 19,-36 9,-68 -4,-95 -14,-27 -123,-294 -169,-403 -45,-108 -91,-90 -124,-90 -31,0 -68,-5 -104,-5 -37,0 -96,14 -146,68 -50,54 -191,186 -191,453 0,63 11,125 28,185 55,191 174,349 195,376 27,35 378,601 934,820 556,216 556,144 656,134 101,-8 324,-130 369,-258 46,-126 46,-235 32,-258 -13,-21 -50,-35 -104,-62z"/></g></g></svg></a>
          </div><div class="shareDivIn emailBtn">
              <a href="mailto:?subject=Participation in the National Agenda Forum (NAF)&body=Gandhiji, on his Constructive Programme (https://goo.gl/Qpphxj), had outlined the blueprint for independent India. Let's spread his vision and formulate an actionable agenda for India in his 150th Birth Anniversary year. You can log on to www.indianpac.com/naf to participate in the National Agenda Forum (NAF) and resurrect the conversation around the 18-point Constructive Programme." title="Share by Email">
                  <svg height="512px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><polygon points="448,384 448,141.8 316.9,241.6 385,319 383,321 304.1,251.4 256,288 207.9,251.4 129,321 127,319 195,241.6    64,142 64,384  "/><polygon points="439.7,128 72,128 256,267.9  "/></g></svg>
              </a>
          </div><div class="shareDivIn pdfBtnOut">
              <div class="pdfBtn transition">
                  <a href="https://res.cloudinary.com/indianpac/image/upload/naf/images/Constructive_Programme.pdf" target="_blank">Download PDF</a>
              </div>
          </div>
      </div> 
  </div>
                  
       
    </div>
  </div>
  <div class="steps"> 
  <div class="stepsIn"> 
      <div class="stein_left"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/step1-icon.png" alt="Set Agenda" title="Set Agenda"></div>
      <div class="stein_right">
        <h3>Set the Agenda</h3>
        <p>Contribute and vote to decide the top 10 priorities of the nation</p>
        <!-- <a href="<?php echo base_url();?>agenda">
        <div class="btn transition">Vote</div> -->
        <?php if($disable_agenda){?><div class="btn transition disable blackdisable">Done</div><?php }else{?><a href="<?php echo base_url();?>agenda"><div class="btn transition">Vote</div></a><?php }?>
        </a>
        <?php if(isset($total_leader_voted_count)){ ?>
        <!--<p class="stats" style="margin-top:22px;"></p>--> 
        <!--<p class="stats"><?php //echo $total_agenda_voted_count;?> people have already set their agenda</p>-->
        
        <?php } else { ?>
        <!--<p class="stats" style="margin-top:20px;"></p>-->
        <?php } ?>
      </div>
    </div>
    <img class="arrows" src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/arrows.png" />
    <div class="stepsIn"> 
      <!--<div class="step">3</div>-->
      <div class="stein_left choose-leader-icon"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/step2-icon.png" alt="Set Agenda" title="Set Agenda"></div>
      <div class="stein_right">
        <h3>Choose the Leader</h3>
        <p>Vote for the leader best suited to adopt and execute this agenda</p>
        <!-- <div class="btn transition" data-toggle="tooltip" data-placement="top" title="Set Agenda tooltip"> Vote </div> -->
        <?php if($disable_vote){?><div class="btn transition disable blackdisable">Done</div><?php }else{?><div class="btn voteBtn transition" data-toggle="tooltip" data-placement="top" title="Set Agenda">Vote</div><?php }?>
        <?php if(isset($total_leader_voted_count)){ ?>
        <!--<p class="stats" style="margin-top:22px;"></p> --> 
        <!--<p class="stats"><?php //echo $total_leader_voted_count;?> people have already chosen their leader</p>-->
        
        <?php } else { ?>
        <!--<p class="stats" style="margin-top:20px;"></p>-->
        <?php } ?>
      </div>
    </div>
    <img class="arrows" src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/arrows.png" />
    <div class="stepsIn"> 
      <!--<div class="step">4</div>-->
      <div class="stein_left campaign-icon"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/step3-icon.png" alt="Set Agenda" title="Set Agenda"></div>
      <div class="stein_right">
        <h3>Campaign for India</h3>
        <p>Help the chosen leader to get elected in the upcoming general elections</p>
        <?php if($disable_register){?><div class="btn transition disable blackdisable">Done</div><?php }else{?>
          <?php if(!$disable_agenda && !$disable_vote){?>
          <div class="btn regiBtn transition">Register</div>
          <?php }else{ ?>
          <a href="<?php echo base_url();?>register"><div class="btn transition">Register</div></a>
          <?php }?>                        
      <?php }?>
        <!--<p class="stats"><a data-target="#myModal"><?php echo $total_register_user;?></a> people have already joined</p>--> 
      </div>
    </div>
  </div>
</div>
<div class="homeMain">
  <div class="wrapper"> 
    <!-- Testimonials section -->
    <div class="testimonial-section"> 
      <!-- Testimonials heading -->
      <div class="testimonial-heading-flex">
        <h2>Support for NAF</h2>
        <!--<h4>There is no one who loves pain itself, who seeks after it and wants to have it</h4>-->
        <div class="green-border-down"></div>
      </div>
        <!-- Testimonial body-->
      <div class="testimonial-body-flex">
      
          <div class="customPrevBtnTestimonial"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/arrow-min-left.png"></div>
          <div class="customNextBtnTestimonial"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/arrow-min.png"></div>
        <div class="owl-carousel owl-theme">
			
        </div>
      </div>
        <!-- our partners section -->
        
<!--        <div class="our-partners-flex">-->
<!--            <div class="our-partner-logo">-->
<!--                <div class="tt-wrapper owl-carousel-pta owl-theme-pta">-->
<!--                    --><?php //foreach ($partner_list as $key4 => $value4) {?>
<!--                    <div class="list-wrapper item">-->
<!--                        <a class="tt-gplus">-->
<!--                            <img src="--><?php //echo base_url() ?><!--assets/images/partners/--><?php //echo $value4['partner_image_name'];?><!--">-->
<!--                            <span>-->
<!--                                <h4>--><?php //echo $value4['partner_name'];?><!--</h4>-->
<!--                                <p>--><?php //echo $value4['bio'];?><!--</p>-->
<!--                            </span>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                    --><?php //}?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
    <!-- Top Performing associates section -->
    <div class="testimonial-section-pta"> 
      <!-- Testimonials heading -->
      <div class="testimonial-heading-flex">
        <h2>Youth Driving NAF</h2>
        <!--<h4>There is no one who loves pain itself, who seeks after it and wants to have it</h4>-->
        <div class="green-border-down"></div>
      </div>
      <div class="pta-body-flex">
      
          <div class="customPrevBtnPta"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/arrow-min-left.png"></div>
          <div class="customNextBtnPta"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/arrow-min.png"></div>
        <div class="owl-carousel-pta owl-theme-pta">
          
          
        </div>
      </div>
    </div>
    <!--<img class="mileBack" src="<?php echo base_url()?>assets/images/mileBack.png">--> </div>
</div>
<div class="news-social-feed-flex">
	<div class="last_section">
		<h3>In The News</h3>
		<div class="last_section_left">
		<div class="last_section_left_news">
        <?php foreach ($news as $key2 => $value2) {?>
			<div class="news1">
				<div class="news_left">
					<a href="<?php echo $value2['news_link']; ?>" target="_blank"><img src="https://res.cloudinary.com/indianpac/image/upload/v1532445472/naf/images/news/<?php echo $value2['news_img_name']; ?>" /></a>
				</div>
				<div class="news_right">
					<h5><?php echo $value2['news_title']; ?></h5>
					<p><a href="<?php echo $value2['news_link']; ?>" target="_blank">Read More</a></p>
				</div>
			</div>
            <?php } ?>
          </div>  
            
		</div>
	</div>
	<div class="last_section">
		<h3>In Social Media</h3>
		<div class="last_section_left">
<div id="flockler_container"></div>
<script type="text/javascript">
var _flockler = _flockler || [];
_flockler.push({
  count: 20,
  refresh: 0,
  site: 5168,
  style: 'wall'
});
(function(d){var f = d.createElement('script');f.async=1;f.src='https://embed-cdn.flockler.com/embed-v2.js';s=d.getElementsByTagName('script')[0];s.parentNode.insertBefore(f,s);})(document);
</script>
		</div>
	</div>
</div>
<div class="homeMain milestonesec">
  <div class="wrapper map-milestones-flex">
    <div class="milestone-wrapper-left">
    <div class="map-numbers" id="counter">
	<div class="district_numbers map_active map_active_class" id="districts" onclick="showMap('https://www.google.com/maps/d/u/0/embed?mid=13Te4IycHq_zfZX8z4qpo5UZ2T0qzyfsA&z=5&ll=22.9734, 78.6569','districts');event.preventDefault()">
		<div class="map-icon"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/districts.png" /></div><span>DISTRICTS<br/><div class="counter-value" data-count="600">0</div><span  class="number_plus_sign">+</span></span>
	</div>
    <div class="college_numbers map_active_class" id="colleges" onclick="showMap('https://www.google.com/maps/d/u/0/embed?mid=1X5_T0CIPv66INFc7jseAKXZfp_Z5pL5X&z=5&ll=22.9734, 78.6569','colleges');event.preventDefault()">
    <div class="map-icon"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/college.png" /></div><span>COLLEGES<br/><div class="counter-value" data-count="2200">0</div><span  class="number_plus_sign">+</span></span>
    </div>
		<div class="pta_reg_numbers map_active_class" id="associates" onclick="showMap('https://www.google.com/maps/d/u/0/embed?mid=19Wo9ZGhDN7ALOIr8Iw5pj_kQnrSw6R8g&z=5&ll=22.9734, 78.6569','associates');event.preventDefault()">
			<div class="map-icon">
				<img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/associates.png" />
			</div><span>ASSOCIATES<br/><div class="counter-value" data-count="25000">0</div><span class="number_plus_sign">+</span></span>
		</div>
    </div>
      
      <iframe src="" width="100%" height="800" id="maps_iframe"></iframe>
    </div>
    <div class="milestone-wrapper-right">
      <div class="milestone-container">
        <div class="videoSec">
        <h2>How NAF Works</h2>
        <div class="green-border-down"></div>
          <!--<iframe src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>-->
<!--          <iframe id="ytplayer" type="text/html" width="720" height="405"-->
<!--src="https://www.youtube.com/embed/kZH0xKlP8To?rel=0?cc_load_policy=1&disablekb=1&enablejsapi=1&loop=1&modestbranding=1&playsinline=1&color=white"-->
<!--frameborder="0" allowfullscreen></iframe>-->
			<iframe id="ytplayer" type="text/html" width="720" height="405" src="https://www.youtube.com/embed/CCfe9rEb72s?rel=0" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="milestones ">
          <h2 class="heading_milestones">Milestones</h2>
          <div class="green-border-down green-border-heading"></div>
          <div class="milestonesIn topMile">
            <div class="milestonesLine">
              <div class="mileImg"> <img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/launch.png" alt="launch" title="NAF Launch"> </div>
            </div>
            <div class="milestonesBot mileDesc">
              <h5>29 Jun&rsquo;18</h5>
              <p>NAF Launch</p>
            </div>
          </div>
          <div class="milestonesIn topMile">
            <div class="milestonesLine">
              <div class="mileImg"> <img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/opens.png" alt="launch" title="NAF Launch"> </div>
            </div>
            <div class="milestonesBot mileDesc">
              <h5>11 Jul&rsquo;18</h5>
              <p>Voting opens to set the key national priorities and choose the leader</p>
            </div>
          </div>
          <div class="milestonesIn topMile">
            <div class="milestonesLine">
              <div class="mileImg"> <img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/results.png" alt="launch" title="NAF Launch"> </div>
            </div>
            <div class="milestonesBot mileDesc">
              <h5>15 Aug&rsquo;18</h5>
              <p>Voting Results</p>
            </div>
          </div>
          <div class="milestonesIn topMile">
            <div class="milestonesLine">
              <div class="mileImg"> <img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/meeting.png" alt="launch" title="NAF Launch"> </div>
            </div>
            <div class="milestonesBot mileDesc">
              <h5>Sep&rsquo;18 - Oct&rsquo;18</h5>
              <p>Meeting with the leader</p>
            </div>
          </div>
          <div class="milestonesIn topMile">
            <div class="milestonesLine">
              <div class="mileImg"> <img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/toNation.png" alt="launch" title="NAF Launch"> </div>
            </div>
            <div class="milestonesBot mileDesc">
              <h5>Oct&rsquo;18 - Jan&rsquo;19</h5>
              <p>Taking the agenda to the nation</p>
            </div>
          </div>
          <div class="milestonesIn topMile">
            <div class="milestonesLine">
              <div class="mileImg"> <img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/adoption.png" alt="launch" title="NAF Launch"> </div>
            </div>
            <div class="milestonesBot mileDesc">
              <h5>Jan&rsquo;19 - Feb&rsquo;19</h5>
              <p>Adoption of agenda as part of official manifesto of the party</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>

</body>
<script src="<?php echo base_url() ?>assets/js/dyna_sld.js"></script>
<script>

        var phone_val = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
        var whitespaces_val = /^\s+$/;   
        $( document ).ready(function() {
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
                            $('.registerPopup').fadeOut();
                            $('.otpPopup').fadeIn();
                            $('.resendOtp').delay(20000).fadeIn();
                        }else{ 
                            <?php if(!$disable_register){?>
                              $('.registerPopup').fadeOut();
                              $(".infoPopup").fadeIn();
                            <?php }?>
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
		
		var a = 0;
    $(window).scroll(function() {

        var oTop = $('#counter').offset().top - window.innerHeight;
        if (a == 0 && $(window).scrollTop() > oTop) {
            $('.counter-value').each(function() {
                var $this = $(this),
                    countTo = $this.attr('data-count');
                $({
                    countNum: $this.text()
                }).animate({
                        countNum: countTo
                    },

                    {

                        duration: 2000,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $this.text(this.countNum);
                            //alert('finished');
                        }

                    });
            });
            a = 1;
        }

    });
    </script>
<script>
var district_location = "https://www.google.com/maps/d/u/0/embed?mid=13Te4IycHq_zfZX8z4qpo5UZ2T0qzyfsA&z=5&ll=22.9734, 78.6569";
(function(){
        document.getElementById('maps_iframe').src = district_location;
    })();
function showMap(loc, id) {
  document.getElementById("maps_iframe").src=loc;
}
</script>
<script>
	$(function() {
		$('.map_active_class').click(function(){
			$('.map_active_class').removeClass('map_active');
			$(this).addClass('map_active');
		});
	});
</script>
</html>
