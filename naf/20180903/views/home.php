<!DOCTYPE html>
<html lang="en">
<head>
<?php include('head_element.php'); ?>
<title>NAF</title>
<meta name="description" content=""/>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:100,300" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/swiper.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/result.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/about_naf.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/gallery_news.css">
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
</head>
<body class="home home-wrapper">
<!--header code-->
<?php include('header_home.php'); ?>
<div class="container-fluid text-center banner_bg">
  <div class="container banner_title">
    <?php if($langcookie=="en"){ ?>
    <h1>After 73 years, the nation came together to resurrect the conversation around Mahatma Gandhi’s 18-point Constructive Programme</h1>
	<h2><font color="#ffbb56"><?php
		$fmt = new NumberFormatter($locale = 'en_IN', NumberFormatter::DECIMAL);
		echo $fmt->format($people_hits['totalvisit']);
	?></font> citizens participated to decide:</h2>
    <?php } ?>
    <?php if($langcookie=="hi"){ ?>
    <h1>73 साल बाद, देश महात्मा गांधीजी के 18-सूत्रीय रचनात्मक कार्यक्रम पर चर्चा को पुनर्जीवित करने के लिए एकजुट हुआ है</h1>
    <h2><font color="#ffbb56"><?php
    $fmt = new NumberFormatter($locale = 'en_IN', NumberFormatter::DECIMAL);
    echo $fmt->format($people_hits['totalvisit']);
  ?></font> नागरिकों की भागीदारी से चुना गया:</h2>
    <?php } ?>
  </div>
  <div class="container banner_inner">
    <div class="">
      <div class=" col-lg-7 col-md-7 col-sm-12 col-xs-12 banner_agenda">
        <?php if($langcookie=="en"){ ?>
        <h2>The Agenda</h2>
        <h4>The top 10 priorities of the nation</h4>
        <?php } ?>
        <?php if($langcookie=="hi"){ ?>
        <h2>एजेंडा</h2>
        <h4>देश की 10 प्राथमिकताएं</h4>
        <?php } ?>
        <div class="desktop_agendas">
          <?php
                    $i = 1;
                    foreach ($top_ten_agendas as $key => $value) {
                    $total_per = 0;
                    if ($value['total_vote'] == 0) {
                        $total_per = 0;
                    } else {
                        $total_per = round(($value['total_vote'] / $total_agenda_vote) * 100, 1);
                    }
                    ?>
          <div class="agendaOut <?php echo 'agendacls' . $value['id']; ?> " id="selectedOpt" data-toggle="tooltip" title="<?php if($langcookie=="en"){ echo $value['agenda_name']; } if($langcookie=="hi"){ echo $value['agenda_name_hindi']; } ?>">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>
                        <?php if($langcookie=="en"){ ?>
                        <?php echo $value['agenda_topic'] ?>
                        <?php }?>
                        <?php if($langcookie=="hi"){ ?>
                        <?php echo $value['agenda_topic_hindi'] ?>
                        <?php }?>
                      </h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url() ?>assets/images/icons/icon-agenda<?php echo $value['id']; ?>.png"> 
                      <!--<p class="only_mob_desc"> Tap to see details </p>--> 
                    </div>
                    <!--<div class="transition agendaImg" id="gandhi_border"><?php //echo $total_per ?><small>%</small></div>-->
                  </div>
                  <!--<div class="agendaoverlay">
                 <label class="transition" id="agenda_description">Protect the interests of farmers and help them become self-reliant without exploiting them for political purposes</label>
                 </div>--> 
                </div>
              </div>
            </div>
          </div>
          <?php $i++; } ?>
        </div>
        <div class="mobile_agendas">
        
        <?php
                    $i = 1;
                    foreach ($get_top_four_top_agenda as $key => $value) {
                    $total_per = 0;
                    if ($value['total_vote'] == 0) {
                        $total_per = 0;
                    } else {
                        $total_per = round(($value['total_vote'] / $total_agenda_vote) * 100, 1);
                    }
                    ?>
          <div class="agendaOut <?php echo 'agendacls' . $value['id']; ?> " id="selectedOpt" data-toggle="tooltip" title="<?php if($langcookie=="en"){ echo $value['agenda_name']; } if($langcookie=="hi"){ echo $value['agenda_name_hindi']; } ?>">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>
                        <?php if($langcookie=="en"){ ?>
                        <?php echo $value['agenda_topic'] ?>
                        <?php }?>
                        <?php if($langcookie=="hi"){ ?>
                        <?php echo $value['agenda_topic_hindi'] ?>
                        <?php }?>
                      </h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url() ?>assets/images/icons/icon-agenda<?php echo $value['id']; ?>.png"> 
                      <!--<p class="only_mob_desc"> Tap to see details </p>--> 
                    </div>
                    <!--<div class="transition agendaImg" id="gandhi_border"><?php //echo $total_per ?><small>%</small></div>-->
                  </div>
                  <!--<div class="agendaoverlay">
                 <label class="transition" id="agenda_description">Protect the interests of farmers and help them become self-reliant without exploiting them for political purposes</label>
                 </div>--> 
                </div>
              </div>
            </div>
          </div>
          <?php $i++; } ?>
          
          
          <div class="read_more"><span><img src="<?php echo base_url()?>assets/images/icons/view_more.png" id="for_mobile" /></span></div>
          <div class="for_mobile" id="for_mobile_container" style="display:none;">
            <?php
                    $i = 1;
                    foreach ($get_rest_six_top_agenda as $key => $value) {
                    $total_per = 0;
                    if ($value['total_vote'] == 0) {
                        $total_per = 0;
                    } else {
                        $total_per = round(($value['total_vote'] / $total_agenda_vote) * 100, 1);
                    }
                    ?>
          <div class="agendaOut <?php echo 'agendacls' . $value['id']; ?> " id="selectedOpt" data-toggle="tooltip" title="<?php if($langcookie=="en"){ echo $value['agenda_name']; } if($langcookie=="hi"){ echo $value['agenda_name_hindi']; } ?>">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>
                        <?php if($langcookie=="en"){ ?>
                        <?php echo $value['agenda_topic'] ?>
                        <?php }?>
                        <?php if($langcookie=="hi"){ ?>
                        <?php echo $value['agenda_topic_hindi'] ?>
                        <?php }?>
                      </h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url() ?>assets/images/icons/icon-agenda<?php echo $value['id']; ?>.png"> 
                      <!--<p class="only_mob_desc"> Tap to see details </p>--> 
                    </div>
                    <!--<div class="transition agendaImg" id="gandhi_border"><?php //echo $total_per ?><small>%</small></div>-->
                  </div>
                  <!--<div class="agendaoverlay">
                 <label class="transition" id="agenda_description">Protect the interests of farmers and help them become self-reliant without exploiting them for political purposes</label>
                 </div>--> 
                </div>
              </div>
            </div>
          </div>
          <?php $i++; } ?>
            
          </div>
        </div>
      </div>
      <div class=" col-lg-5 col-md-5 col-sm-12 col-xs-12 banner_leader">
        <?php if($langcookie=="en"){ ?>
        <h2>The Leader</h2>
        <h4>Top leaders to take the agenda forward</h4>
        <?php } ?>
        <?php if($langcookie=="hi"){ ?>
        <h2>नेता</h2>
        <h4>एजेंडा को आगे ले जाने के लिए चुने गए प्रमुख नेता</h4>
        <?php } ?>
        <?php
                    $i = 1;

                    foreach ($top_six_leaders as $key => $value) {

                        $total_per = 0;


                        if ($value['total_vote'] == 0) {

                            $total_per = 0;

                        } else {

                            $total_per = round(($value['total_vote'] / $total_votes) * 100, 1);

                        }


                        ?>
        <div class="agendaOut laedercls<?php echo $value['id']; ?> " id="selectedOpt">
          <div class="agendacontainer">
            <div class="table_cell">
              <div class="agenda_point_right">
                <div class="default">
                  <div class="agendatitlenicon"> </div>
                  <div class="transition agendaImg" id="gandhi_border"><?php echo $total_per ?><small>%</small></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php $i++;
                    } ?>
      </div>
    </div>
  </div>
  <div class="container banner_bottom_sec">
    <div class="">
      <div class=" col-lg-7 col-md-7 col-sm-12 col-xs-12 banner_bottom_text">
        <?php if($langcookie=="en"){ ?>
        <h2>Sign up to take the agenda to the nation</h2>
        <?php } ?>
        <?php if($langcookie=="hi"){ ?>
        <h2>इस एजेंडा के राष्ट्रव्यापी प्रसार के लिए साइन अप करें</h2>
        <?php } ?>
      </div>
      <div class=" col-lg-5 col-md-5 col-sm-12 col-xs-12 banner_button"> 
        <?php if($disable_register_new){?>
          <div class="btn transition shrBtn line-height-fix disable campaign-read-share">
          <?php if($langcookie=="en"){ ?>
          Done
          <?php } ?>
          <?php if($langcookie=="hi"){ ?>
          <h2> किया हुआ</h2>
          <?php } ?>
          </div>
        
          <?php }else{?>
            <a href="<?php echo base_url()?>register">
          <div class="btn transition shrBtn line-height-fix campaign-read-share campaign-for-india-button">
          <?php if($langcookie=="en"){ ?>
          Campaign for India
          <?php } ?>
          <?php if($langcookie=="hi"){ ?>
          <h2>देश के लिए अभियान</h2>
          <?php } ?>
          </div>
          </a>
            <?php }?>
               
      </div>
    </div>
  </div>
</div>

<!-- Voting button trial -->
<div class=" container-fluid recent-plan-wrapper"> 
  <!-- <div class="recent-plan-quote">

        <h1><?php if($langcookie=="en"){ ?>An attempt, after 73 years, to resurrect the conversation around Mahatma Gandhi’s 18-point Constructive Programme <?php }?>  <?php if($langcookie=="hi"){ ?> 73 साल बाद, महात्मा गांधीजी के 18-सूत्रीय रचनात्मक कार्यक्रम पर चर्चा को पुनर्जीवित करने का एक प्रयास <?php }?> </h1>
    </div> -->
  <div class="recent-plan-content-wrapper" id="digi_counter">
    <div class="recent-set-the-agenda">
      <div class="recent-agenda-wrapper"><img
                        src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/agenda-icon-recent.png"
                        alt="Set Agenda" title="Set Agenda"></div>
      <div class="recent-agenda-content">
        <h3>
          <?php if($langcookie=="en"){ ?>
          Set the Agenda
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          एजेंडा तय करें
          <?php }?>
        </h3>
        <p>
          <?php if($langcookie=="en"){ ?>
          Contribute and vote to decide the top 10 priorities of the nation
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          राष्ट्र की 10 प्राथमिकताओं को तय करने में अपना योगदान और वोट दें
          <?php }?>
        </p>
        <!-- <a href="<?php echo base_url(); ?>agenda">
        <div class="btn transition">Vote</div> -->
        <?php if ($disable_agenda) { ?>
        <div class="btn transition disable campaign-read-share-vote">
          <?php if($langcookie=="en"){ ?>
          Done
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          किया हुआ
          <?php }?>
        </div>
        <?php } else { ?>
        <a href="<?php echo base_url(); ?>agenda" id="Set_the_agenda">
        <div class="btn transition campaign-read-share-vote">
          <?php if($langcookie=="en"){ ?>
          Vote
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          वोट करें
          <?php }?>
        </div>
        </a>
        <?php } ?>
        </a>
        <?php if (isset($total_leader_voted_count)) { ?>
          <!--<p class="stats" style="margin-top:22px;"></p>--> 
          <!--<p class="stats"><?php //echo $total_agenda_voted_count;?> people have already set their agenda</p>-->
          
          <?php } else { ?>
          <!--<p class="stats" style="margin-top:20px;"></p>-->
          <?php } ?>
      </div>
    </div>
    <div class="recent-choose-the-leader">
      <div class="recent-leader-wrapper"><img
                        src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/choose-the-leader-icon-recent.png"
                        alt="choose leader" title="choose leader"></div>
      <div class="recent-leader-content">
        <h3>
          <?php if($langcookie=="en"){ ?>
          Choose the Leader
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          नेता चुनें
          <?php }?>
        </h3>
        <p>
          <?php if($langcookie=="en"){ ?>
          Vote for the leader best suited to adopt and execute this agenda
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          इस एजेंडा को अपनाने और अमल में लाने के लिए योग्य नेता को चुनें
          <?php }?>
        </p>
        <!-- <div class="btn transition" data-toggle="tooltip" data-placement="top" title="Set Agenda tooltip"> Vote </div> -->
        <?php if ($disable_vote) { ?>
        <div class="btn transition disable  campaign-read-share-vote">
          <?php if($langcookie=="en"){ ?>
          Done
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          किया हुआ
          <?php }?>
        </div>
        <?php } else { ?>
        <a href="<?php echo base_url(); ?>vote">
        <div class="btn transition campaign-read-share-vote" id="Choose_the_leader">
          <?php if($langcookie=="en"){ ?>
          Vote
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          वोट करें
          <?php }?>
        </div>
        </a> 
        <!--<div class="btn voteBtn transition" data-toggle="tooltip" data-placement="top" title="Set Agenda" id="Choose_the_leader">Vote</div>-->
        <?php } ?>
        <?php if (isset($total_leader_voted_count)) { ?>
          <!--<p class="stats" style="margin-top:22px;"></p> --> 
          <!--<p class="stats"><?php //echo $total_leader_voted_count;?> people have already chosen their leader</p>-->
          <?php } else { ?>
          <!--<p class="stats" style="margin-top:20px;"></p>-->
          <?php } ?>
      </div>
    </div>
    <!-- <div class="recent-naf-eco-system">
            <div class="recent-naf-eco-system-wrapper"><img
                        src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/ecosystem-icon-recent.png"/>
            </div>
            <div class="recent-naf-eco-system-conent" id="digi_counter">
                <div class="recent-naf-eco-system-heading"><?php if($langcookie=="en"){ ?>NAF eco system<?php }?>  <?php if($langcookie=="hi"){ ?>NAF इकोसिस्टम<?php }?></div>
                <div class="recent-people-organisations">
                    <div class="recent-people">
                        <div class="digi-7 digi-people counter-value" data-count="<?php echo $people_hits['totalvisit'];?>"> 4,30,000
                        </div>
                        <div class="digi-sub-heading recent-people-subheading"><?php if($langcookie=="en"){ ?>Participants<?php }?>  <?php if($langcookie=="hi"){ ?>प्रतिभागी<?php }?></div>
                    </div>
                    <div class="recent-associates">
                        <div class="digi-7 digi-asso counter-value" data-count="<?php echo $asso_count; ?>">
                            50000
                        </div>
                        <div class="digi-sub-heading"><?php if($langcookie=="en"){ ?>Youth Driving NAF<?php }?>  <?php if($langcookie=="hi"){ ?>NAF के युवा सारथी<?php }?></div>
                    </div>
                </div>
                <div class="recent-associates-influencers">
                    
                    <div class="recent-orgi">
                        <div class="digi-7 digi-orgi counter-value" data-count="<?php echo $part_count; ?>"> 150
                        </div>
                        <div class="digi-sub-heading"><?php if($langcookie=="en"){ ?>Organizations<?php }?>  <?php if($langcookie=="hi"){ ?>संस्थान<?php }?></div>
                    </div>
                    <div class="recent-influencers">
                        <div class="digi-7 digi-influ counter-value" data-count="<?php echo $testi_count; ?>">
                            150
                        </div>
                        <div class="digi-sub-heading"><?php if($langcookie=="en"){ ?>Distinguished Personalities<?php }?>  <?php if($langcookie=="hi"){ ?>प्रतिष्ठित व्यक्ति<?php }?></div>
                    </div>
                </div>
            </div>
        </div> --> 
  </div>
</div>

<!-- Voting button trial --> 

<!-- LEADER AGENDA STARTS-->
<div style="display:none;" class="container-fluid campaign-about-naf campaign-dis-orgi" id="campaign-leader-agenda">
  <div class="">
    <div class="col-md-12" id="leader-agenda-ground">
      <div class="d-flex justify-content-center">
        <?php if($langcookie=="en"){ ?>
        <div class="leader-agenda-leader">Leader</div>
        <div class="leader-agenda-agenda">Agenda</div>
        <?php } ?>
        <?php if($langcookie=="hi"){ ?>
        <div class="leader-agenda-leader">नेता</div>
        <div class="leader-agenda-agenda">एजेंडा</div>
        <?php } ?>
      </div>
      <div class="" id="popularity-progress">
        <div class="col-md-4 col-lg-4" id="agenda-points-section">
          <label class="custom-select" for="styledSelect1">
            <select id="state" name="state">
              <option value="All States" selected>All States</option>
              <option value="Andhra Pradesh"  <?php if(@$_POST['state']=="Andhra Pradesh"){echo "selected";} ?>>Andhra Pradesh</option>
              <option value="Arunachal Pradesh" <?php if(@$_POST['state']=="Arunachal Pradesh"){echo "selected";} ?>>Arunachal Pradesh</option>
              <option value="Assam" <?php if(@$_POST['state']=="Assam"){echo "selected";} ?>>Assam </option>
              <option value="Bihar" <?php if(@$_POST['state']=="Bihar"){echo "selected";} ?>>Bihar </option>
              <option value="Chandigarh" <?php if(@$_POST['state']=="Chandigarh"){echo "selected";} ?>>Chandigarh </option>
              <option value="Chhattisgarh" <?php if(@$_POST['state']=="Chhattisgarh"){echo "selected";} ?>>Chhattisgarh </option>
              <option value="Dadra and Nagar Haveli" <?php if(@$_POST['state']=="Dadra and Nagar Haveli"){echo "selected";} ?>>Dadra and Nagar Haveli </option>
              <option value="Daman and Diu" <?php if(@$_POST['state']=="Daman and Diu"){echo "selected";} ?>>Daman and Diu </option>
              <option value="Delhi" <?php if(@$_POST['state']=="Delhi"){echo "selected";} ?>> Delhi </option>
              <option value="Goa" <?php if(@$_POST['state']=="Goa"){echo "selected";} ?>> Goa </option>
              <option value="Gujarat" <?php if(@$_POST['state']=="Gujarat"){echo "selected";} ?>> Gujarat </option>
              <option value="Haryana" <?php if(@$_POST['state']=="Haryana"){echo "selected";} ?>> Haryana </option>
              <option value="Himachal Pradesh" <?php if(@$_POST['state']=="Himachal Pradesh"){echo "selected";} ?>> Himachal Pradesh </option>
              <option value="Jammu and Kashmir" <?php if(@$_POST['state']=="Jammu and Kashmir"){echo "selected";} ?>> Jammu and Kashmir </option>
              <option value="Jharkhand" <?php if(@$_POST['state']=="Jharkhand"){echo "selected";} ?>> Jharkhand </option>
              <option value="Karnataka" <?php if(@$_POST['state']=="Karnataka"){echo "selected";} ?>> Karnataka </option>
              <option value="Kerala" <?php if(@$_POST['state']=="Kerala"){echo "selected";} ?>> Kerala </option>
              <option value="Madhya Pradesh" <?php if(@$_POST['state']=="Madhya Pradesh"){echo "selected";} ?>> Madhya Pradesh </option>
              <option value="Maharashtra" <?php if(@$_POST['state']=="Maharashtra"){echo "selected";} ?>> Maharashtra </option>
              <option value="Manipur" <?php if(@$_POST['state']=="Manipur"){echo "selected";} ?>> Manipur </option>
              <option value="Meghalaya" <?php if(@$_POST['state']=="Meghalaya"){echo "selected";} ?>> Meghalaya </option>
              <option value="Mizoram" <?php if(@$_POST['state']=="Mizoram"){echo "selected";} ?>> Mizoram </option>
              <option value="Nagaland" <?php if(@$_POST['state']=="Nagaland"){echo "selected";} ?>> Nagaland </option>
              <option value="Odisha" <?php if(@$_POST['state']=="Odisha"){echo "selected";} ?>> Odisha </option>
              <option value="Puducherry" <?php if(@$_POST['state']=="Puducherry"){echo "selected";} ?>>Puducherry </option>
              <option value="Punjab" <?php if(@$_POST['state']=="Punjab"){echo "selected";} ?>>Punjab </option>
              <option value="Rajasthan" <?php if(@$_POST['state']=="Rajasthan"){echo "selected";} ?>>Rajasthan </option>
              <option value="Sikkim" <?php if(@$_POST['state']=="Sikkim"){echo "selected";} ?>>Sikkim </option>
              <option value="Tamil Nadu" <?php if(@$_POST['state']=="Tamil Nadu"){echo "selected";} ?>>Tamil Nadu </option>
              <option value="Telangana" <?php if(@$_POST['state']=="Telangana"){echo "selected";} ?>>Telangana </option>
              <option value="Tripura" <?php if(@$_POST['state']=="Tripura"){echo "selected";} ?>>Tripura </option>
              <option value="Uttar Pradesh" <?php if(@$_POST['state']=="Uttar Pradesh"){echo "selected";} ?>>Uttar Pradesh </option>
              <option value="Uttarakhand" <?php if(@$_POST['state']=="Uttarakhand"){echo "selected";} ?>>Uttarakhand </option>
              <option value="West Bengal" <?php if(@$_POST['state']=="West Bengal"){echo "selected";} ?>>West Bengal </option>
            </select>
          </label>
          <label class="custom-select mobile" for="styledSelect2">
            <select id="styledSelect2" name="options">
              <option value=""> Select Agenda Point </option>
              <option value="1"> Option 1 </option>
              <option value="2"> Option 2 </option>
              <option value="3"> Option 3 </option>
              <option value="4"> Option 4 </option>
            </select>
          </label>
          <div class="d-flex justify-content-between flex-wrap desktop" id="agenda-points-wrapper">
            <input type='submit' name='agenda' id="agenda" class="agenda-points active" value='Kisans' selected>
            <input type='submit' name='agenda' id="agenda" class="agenda-points" value='Women'>
            <input type='submit' name='agenda' id="agenda" class="agenda-points" value='Students'>
            <input type='submit' name='agenda' id="agenda" class="agenda-points" value='Economic Equality'>
            <input type='submit' name='agenda' id="agenda" class="agenda-points" value='Education in Health & Hygiene'>
            <input type='submit' name='agenda' id="agenda" class="agenda-points" value='New or Basic Education'>
            <input type='submit' name='agenda' id="agenda" class="agenda-points" value='Village Sanitation'>
            <input type='submit' name='agenda' id="agenda" class="agenda-points" value='Communal Unity'>
            <input type='submit' name='agenda' id="agenda" class="agenda-points" value='Labour'>
            <input type='submit' name='agenda' id="agenda" class="agenda-points" value='Adult Education'>
          </div>
        </div>
        <div class="col-md-8 col-lg-8" id="popularity-leaders-column">
          <h4 id="popularity-leaders">POPULARITY OF LEADERS</h4>
          <div class="d-flex flex-row bd-highlight mb-3" id="leader-progress-wrapper">
            <div class="p-2 bd-highlight leader-name">Akhilesh Yadav</div>
            <div class="p-2 bd-highlight leader-percentage" style="flex: 0 0 33.75%;background-color: rgb(1, 178, 165);">45%</div>
          </div>
          <div class="d-flex flex-row bd-highlight mb-3" id="leader-progress-wrapper">
            <div class="p-2 bd-highlight leader-name">Narendra Modi</div>
            <div class="p-2 bd-highlight leader-percentage" style="flex: 0 0 48.75%;background-color: rgb(53, 68, 71);">65%</div>
          </div>
          <div class="d-flex flex-row bd-highlight mb-3" id="leader-progress-wrapper">
            <div class="p-2 bd-highlight leader-name">Rahul Gandhi</div>
            <div class="p-2 bd-highlight leader-percentage" style="flex: 0 0 26.25%;background-color: rgb(245, 95, 91);">35%</div>
          </div>
          <div class="d-flex flex-row bd-highlight mb-3" id="leader-progress-wrapper">
            <div class="p-2 bd-highlight leader-name">Mamta Banerjee</div>
            <div class="p-2 bd-highlight leader-percentage" style="flex: 0 0 36.75%;background-color: rgb(234, 194, 15);">49%</div>
          </div>
          <div class="d-flex flex-row bd-highlight mb-3" id="leader-progress-wrapper">
            <div class="p-2 bd-highlight leader-name">Mayawati</div>
            <div class="p-2 bd-highlight leader-percentage" style="flex: 0 0 36%;background-color: rgb(92, 104, 106);">48%</div>
          </div>
          <div class="d-flex flex-row bd-highlight mb-3" id="leader-progress-wrapper">
            <div class="p-2 bd-highlight leader-name">Nitish Kumar</div>
            <div class="p-2 bd-highlight leader-percentage" style="flex: 0 0 29.25%;background-color: rgb(134, 205, 228);">39%</div>
          </div>
          <?php /*?><div id="xyz">      
          <?php

                $state="All States";
                $agenda="Kisans";
                echo "Case 1:";
                echo "Default National, Agenda:Kisan";
                echo "</br>";
                $sql11="SELECT `LEADER`,sum(`AGENDA_VOTES`) as tv FROM `naf_state_dashboard` WHERE `AGENDA`='Kisans' group by `LEADER` order by tv desc LIMIT 0,5";
                $result11=mysql_query($sql11);
                    $rem11=0;
                        $csum11=0;
                        while($row11=mysql_fetch_array($result11)){

                        $sql21="SELECT sum(`AGENDA_VOTES`) as total FROM `naf_state_dashboard` WHERE `AGENDA`='Kisans'";
                            $result21=mysql_query($sql21);
                        while($row21=mysql_fetch_array($result21)){

                                $sum11=$row21['total'];
                            }

                            echo $row11['LEADER'];
                        echo "&nbsp";
                            echo "&nbsp";
                            echo "&nbsp";

                            
                            $lv11=$row11['tv'];
                        echo $row11['tv'];

                            $per11=round(($lv11/$sum11)*100,2);
                            echo "&nbsp";
                            echo "&nbsp";
                            echo "&nbsp";

                            echo $per11;
                            echo "</br>";
                        $csum11=$csum11+$row11['tv'];

                    }
                echo "Others";
                $otc11=$sum11-$csum11;
                $otcp11=round(($otc11/$sum11)*100,2);

                echo $otc11;
                echo "&nbsp";
                echo "&nbsp";
                echo "&nbsp";

                echo $otcp11;



                if(isset($_POST['agenda'])){

                    if($_POST['state']=="All States"){


                        echo "<script>document.getElementById('xyz').innerHTML='';</script>";
                        echo "Case 2:";
                        echo "Agenda Select Kiya But State Change Nhi Kiya";
                        echo "</br>";
                        echo $_POST['agenda'];
                    $agall=$_POST['agenda'];
                echo "</br>";
                    $sql12="SELECT `LEADER`,sum(`AGENDA_VOTES`) as tv FROM `naf_state_dashboard` WHERE `AGENDA`='$agall' group by `LEADER` order by tv desc LIMIT 0,5";

                $result12=mysql_query($sql12);
                        $rem12=0;
                        $csum12=0;
                        while($row12=mysql_fetch_array($result12)){

                            $sql22="SELECT sum(`AGENDA_VOTES`) as total FROM `naf_state_dashboard` WHERE `AGENDA`='$agall'";
                            $result22=mysql_query($sql22);
                        while($row22=mysql_fetch_array($result22)){

                                $sum12=$row22['total'];

                            }


                            echo $row12['LEADER'];
                            echo "&nbsp";
                            echo "&nbsp";
                        echo "&nbsp";

                            
                            $lv12=$row12['tv'];
                            echo $row12['tv'];

                            $per12=round(($lv12/$sum12)*100,2);
                        echo "&nbsp";
                            echo "&nbsp";
                            echo "&nbsp";


                        echo $per12;
                            echo "</br>";
                            $csum12=$csum12+$row12['tv'];

                    }
                echo "Others";
                $otc12=$sum12-$csum12;
                $otcp12=round(($otc12/$sum12)*100,2);

                echo $otc12;
                echo "&nbsp";
                echo "&nbsp";
                echo "&nbsp";

                echo $otcp12;


                        
                    }
                    else if(isset($_POST['state']) ){

                        echo "<script>document.getElementById('xyz').innerHTML='';</script>";
                        echo "Case 3:";
                        echo "State Bhi Change Kiya hAI aur Agenda Bhi Select Kiya Hai";
                        echo "</br>";
                        echo $_POST['state'];
                        echo "</br>";
                        echo $_POST['agenda'];
                    $st=$_POST['state'];
                        $ag=$_POST['agenda'];

                        echo "</br>";
                        echo "</br>";


                        $sql1="SELECT * FROM `naf_state_dashboard` WHERE `STATE`='$st' and `AGENDA`='$ag' order by `AGENDA_VOTES` desc limit 0,5";
                        $result1=mysql_query($sql1);
                        $rem=0;
                        $csum=0;
                        while($row=mysql_fetch_array($result1)){


                            $sql2="SELECT sum(`AGENDA_VOTES`) as total FROM `naf_state_dashboard` WHERE `STATE`='$st' and `AGENDA`='$ag'";
                            $result2=mysql_query($sql2);
                            while($row2=mysql_fetch_array($result2)){
                                $sum=$row2['total'];

                        }


                        echo $row['LEADER'];
                            echo "&nbsp";
                        echo "&nbsp";
                            echo "&nbsp";

                            
                            $lv=$row['AGENDA_VOTES'];
                        echo $row['AGENDA_VOTES'];

                        $per=round(($lv/$sum)*100,2);
                            echo "&nbsp";
                            echo "&nbsp";
                            echo "&nbsp";


                            echo $per;
                        echo "</br>";
                            $csum=$csum+$row['AGENDA_VOTES'];

                        }
                echo "Others";
                $otc=$sum-$csum;
                $otcp=round(($otc/$sum)*100,2);

                echo $otc;
                echo "&nbsp";
                echo "&nbsp";
                echo "&nbsp";

                echo $otcp;

                    }

                    

                }

            ?>
            </div><?php */?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- LEADER AGENDA ENDS--> 
<!-- ABOUT NAF STARTS-->
<div class="container-fluid campaign-about-naf">
  <div class="row d-flex">
    <div class=" col-lg-5  col-md-5 col-sm-12  col-xs-12 about-naf-column">
      <?php if($langcookie=="en"){ ?>
      <h1>About NAF</h1>
      <?php }?>
      <?php if($langcookie=="hi"){ ?>
      <h1>NAF के बारे में</h1>
      <?php }?>
      <p class="desktop">
        <?php if($langcookie=="en"){ ?>
        As the nation celebrates the 150<sup>th</sup> Birth Anniversary year of Mahatma Gandhi, Indian Political Action Committee (I-PAC) launched the National Agenda Forum (NAF), a pan-India initiative to resurrect the conversation around his 18-point Constructive Programme and use it to re-imagine and co-create India’s priorities to formulate an actionable agenda for contemporary India.
        <?php }?>
        <?php if($langcookie=="hi"){ ?>
        महात्मा गांधीजी के 150वीं जयंती वर्ष के अवसर पर इंडियन पॉलिटिकल एक्शन कमिटी (I-PAC) ने नेशनल एजेंडा फोरम (NAF) लॉन्च किया है। इस देशव्यापी पहल का उद्देश्य गांधीजी के 18-सूत्रीय रचनात्मक कार्यक्रम पर चर्चा को पुनर्जीवित करना और इस चर्चा के जरिए देश की प्राथमिताओं को पुनर्कल्पित और सहनिर्मित कर, समकालीन भारत के लिए क्रियान्वयन योग्य एजेंडा तैयार करना है।
        <?php }?>
      </p>
      <p class="mobile">
        <?php if($langcookie=="en"){ ?>
        As the nation celebrates the 150<sup>th</sup> Birth Anniversary year of Mahatma Gandhi, Indian Political Action Committee (I-PAC) launched the National Agenda Forum (NAF), a pan-India initiative to resurrect the conversation around his 18-point Constructive Programme and use it to re-imagine and co-create India’s priorities to formulate an actionable agenda for contemporary India.
        <?php }?>
        <?php if($langcookie=="hi"){ ?>
        महात्मा गांधीजी के 150वीं जयंती वर्ष के अवसर पर इंडियन पॉलिटिकल एक्शन कमिटी (I-PAC) ने नेशनल एजेंडा फोरम (NAF) लॉन्च किया है। इस देशव्यापी पहल का उद्देश्य गांधीजी के 18-सूत्रीय रचनात्मक कार्यक्रम पर चर्चा को पुनर्जीवित करना और इस चर्चा के जरिए देश की प्राथमिताओं को पुनर्कल्पित और सहनिर्मित कर, समकालीन भारत के लिए क्रियान्वयन योग्य एजेंडा तैयार करना है।
        <?php }?>
      </p>
      <div class="shareBtnOut desktop">
        <?php $url = base_url(); ?>
        <div class="btn transition shrBtn campaign-read-share  campaign-read-share-2">
          <?php if($langcookie=="en"){ ?>
          Read and Share the Constructive Programme
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          रचनात्मक कार्यक्रम पढ़ें और शेयर करें
          <?php }?>
        </div>
        <div class="shareDiv">
          <div class="shareDivIn fbBtn">
            <svg class="fbImg" viewBox="0 0 8379 8379">
              <g id="Layer_x0020_1">
                <rect class="fil0" height="8379" width="8379"/>
                <path class="fil1"
                                        d="M5111 3490l-627 0 0 -412c0,-154 102,-190 174,-190 72,0 443,0 443,0l0 -680 -610 -3c-677,0 -832,507 -832,832l0 453 -392 0 0 701 392 0c0,899 0,1983 0,1983l825 0c0,0 0,-1095 0,-1983l556 0 71 -701z"/>
              </g>
            </svg>
          </div>
          <div class="shareDivIn twitBtn"> <a href="https://twitter.com/share?text=Gandhiji, in his Constructive Programme (https://goo.gl/Qpphxj), had outlined the blueprint for independent India. Let's spread his vision and formulate an actionable agenda for India on his 150th Birth Anniversary year. Join %23NationalAgendaForum&p[summary]=""&url=<?php echo $url; ?>
                        &via=National Agenda Forum&hashtags=NationalAgendaForum" target="_blank"
                        onclick="window.open(this.href,'targetWindow','toolbar=no,location=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=250');
                        return false">
            <svg class="twitImg" viewBox="0 0 9291 9291">
              <g id="Layer_x0020_1">
                <rect class="fil0" height="9291" width="9291"/>
                <path class="fil1"
                                        d="M6852 3277c-162,72 -336,120 -520,142 188,-112 331,-289 399,-501 -178,106 -373,180 -576,220 -165,-176 -400,-286 -660,-286 -500,0 -906,405 -906,906 0,70 8,140 24,206 -753,-38 -1420,-398 -1867,-946 -78,134 -122,289 -122,455 0,314 160,592 403,754 -144,-5 -285,-43 -411,-113l0 11c0,439 312,805 727,888 -77,21 -156,32 -239,32 -58,0 -115,-6 -170,-16 115,359 449,621 846,628 -311,243 -701,388 -1125,388 -73,0 -145,-4 -216,-13 401,257 877,407 1388,407 1665,0 2576,-1380 2576,-2576 0,-39 -1,-78 -3,-117 178,-128 331,-287 452,-469z"/>
              </g>
            </svg>
            </a> </div>
          <div class="shareDivIn whatsBtn"> <a href="whatsapp://send?text=Gandhiji, in his Constructive Programme (https://goo.gl/Qpphxj), had outlined the blueprint for independent India. Let's spread his vision and formulate an actionable agenda for India on his 150th Birth Anniversary year. Join %23NationalAgendaForum www.indianpac.com/naf/"
                            data-action="share/whatsapp/share">
            <svg class="whatsImg" viewBox="0 0 8379 8379">
              <g id="Layer_x0020_1">
                <rect class="fil0" height="8379" width="8379"/>
                <g id="_899307880">
                  <path class="fil1"
                                                d="M6460 4075c-30,-1197 -1016,-2158 -2229,-2158 -1199,0 -2176,939 -2229,2117 -1,32 -2,65 -2,97 0,419 117,809 320,1143l-402 1188 1235 -393c320,175 687,276 1078,276 1232,0 2230,-991 2230,-2214 0,-19 0,-38 -1,-56zm-2229 1917l0 0c-381,0 -735,-113 -1032,-308l-720 229 233 -691c-224,-307 -357,-684 -357,-1091 0,-61 3,-121 10,-181 92,-942 894,-1680 1866,-1680 984,0 1794,757 1869,1716 4,48 6,96 6,145 0,1026 -842,1861 -1875,1861z"/>
                  <path class="fil1"
                                                d="M5253 4578c-55,-27 -324,-159 -374,-177 -50,-18 -87,-27 -123,28 -37,54 -142,176 -173,211 -33,37 -64,41 -119,14 -55,-27 -231,-83 -440,-269 -162,-143 -273,-321 -304,-375 -31,-54 -3,-84 24,-111 25,-25 54,-64 83,-95 7,-9 13,-18 19,-26 13,-20 22,-39 35,-65 19,-36 9,-68 -4,-95 -14,-27 -123,-294 -169,-403 -45,-108 -91,-90 -124,-90 -31,0 -68,-5 -104,-5 -37,0 -96,14 -146,68 -50,54 -191,186 -191,453 0,63 11,125 28,185 55,191 174,349 195,376 27,35 378,601 934,820 556,216 556,144 656,134 101,-8 324,-130 369,-258 46,-126 46,-235 32,-258 -13,-21 -50,-35 -104,-62z"/>
                </g>
              </g>
            </svg>
            </a> </div>
          <div class="shareDivIn emailBtn"> <a href="mailto:?subject=Participation in the National Agenda Forum (NAF)&body=Gandhiji, on his Constructive Programme (https://goo.gl/Qpphxj), had outlined the blueprint for independent India. Let's spread his vision and formulate an actionable agenda for India in his 150th Birth Anniversary year. You can log on to www.indianpac.com/naf to participate in the National Agenda Forum (NAF) and resurrect the conversation around the 18-point Constructive Programme."
                            title="Share by Email">
            <svg height="512px" id="Layer_1" style="enable-background:new 0 0 512 512;"
                                    version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <g>
                <polygon
                                            points="448,384 448,141.8 316.9,241.6 385,319 383,321 304.1,251.4 256,288 207.9,251.4 129,321 127,319 195,241.6    64,142 64,384  "/>
                <polygon points="439.7,128 72,128 256,267.9  "/>
              </g>
            </svg>
            </a> </div>
          <div class="shareDivIn pdfBtnOut">
            <div class="pdfBtn transition"> <a href="https://res.cloudinary.com/indianpac/image/upload/naf/images/Constructive_Programme.pdf"
                                target="_blank">Download PDF</a> </div>
          </div>
        </div>
      </div>
    </div>
    <div class=" col-lg-7 col-md-7 col-sm-6 col-xs-12  video-column d-flex align-items-center">
      <div class="video-image-overlay"> <img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/gph.png" width="100%" height="100%"> </div>
    </div>
    <div class=" col-lg-6  col-md-6 col-sm-6  col-xs-12 about-naf-column about-naf-column-2 mobile">
      <div class="shareBtnOut">
        <?php $url = base_url(); ?>
        <div class="btn transition shrBtn line-height-fix campaign-read-share   campaign-read-share-2">
          <?php if($langcookie=="en"){ ?>
          Read and Share the Constructive Programme
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          रचनात्मक कार्यक्रम पढ़ें और शेयर करें
          <?php }?>
        </div>
        <div class="shareDiv">
          <div class="shareDivIn fbBtn">
            <svg class="fbImg" viewBox="0 0 8379 8379">
              <g id="Layer_x0020_1">
                <rect class="fil0" height="8379" width="8379"/>
                <path class="fil1"
                                            d="M5111 3490l-627 0 0 -412c0,-154 102,-190 174,-190 72,0 443,0 443,0l0 -680 -610 -3c-677,0 -832,507 -832,832l0 453 -392 0 0 701 392 0c0,899 0,1983 0,1983l825 0c0,0 0,-1095 0,-1983l556 0 71 -701z"/>
              </g>
            </svg>
          </div>
          <div class="shareDivIn twitBtn"> <a href="https://twitter.com/share?text=Gandhiji, in his Constructive Programme (https://goo.gl/Qpphxj), had outlined the blueprint for independent India. Let's spread his vision and formulate an actionable agenda for India on his 150th Birth Anniversary year. Join %23NationalAgendaForum&p[summary]=""&url=<?php echo $url; ?>
                            &via=National Agenda Forum&hashtags=NationalAgendaForum" target="_blank"
                            onclick="window.open(this.href,'targetWindow','toolbar=no,location=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=250');
                            return false">
            <svg class="twitImg" viewBox="0 0 9291 9291">
              <g id="Layer_x0020_1">
                <rect class="fil0" height="9291" width="9291"/>
                <path class="fil1"
                                            d="M6852 3277c-162,72 -336,120 -520,142 188,-112 331,-289 399,-501 -178,106 -373,180 -576,220 -165,-176 -400,-286 -660,-286 -500,0 -906,405 -906,906 0,70 8,140 24,206 -753,-38 -1420,-398 -1867,-946 -78,134 -122,289 -122,455 0,314 160,592 403,754 -144,-5 -285,-43 -411,-113l0 11c0,439 312,805 727,888 -77,21 -156,32 -239,32 -58,0 -115,-6 -170,-16 115,359 449,621 846,628 -311,243 -701,388 -1125,388 -73,0 -145,-4 -216,-13 401,257 877,407 1388,407 1665,0 2576,-1380 2576,-2576 0,-39 -1,-78 -3,-117 178,-128 331,-287 452,-469z"/>
              </g>
            </svg>
            </a> </div>
          <div class="shareDivIn whatsBtn"> <a href="whatsapp://send?text=Gandhiji, in his Constructive Programme (https://goo.gl/Qpphxj), had outlined the blueprint for independent India. Let's spread his vision and formulate an actionable agenda for India on his 150th Birth Anniversary year. Join %23NationalAgendaForum www.indianpac.com/naf/"
                                data-action="share/whatsapp/share">
            <svg class="whatsImg" viewBox="0 0 8379 8379">
              <g id="Layer_x0020_1">
                <rect class="fil0" height="8379" width="8379"/>
                <g id="_899307880">
                  <path class="fil1"
                                                    d="M6460 4075c-30,-1197 -1016,-2158 -2229,-2158 -1199,0 -2176,939 -2229,2117 -1,32 -2,65 -2,97 0,419 117,809 320,1143l-402 1188 1235 -393c320,175 687,276 1078,276 1232,0 2230,-991 2230,-2214 0,-19 0,-38 -1,-56zm-2229 1917l0 0c-381,0 -735,-113 -1032,-308l-720 229 233 -691c-224,-307 -357,-684 -357,-1091 0,-61 3,-121 10,-181 92,-942 894,-1680 1866,-1680 984,0 1794,757 1869,1716 4,48 6,96 6,145 0,1026 -842,1861 -1875,1861z"/>
                  <path class="fil1"
                                                    d="M5253 4578c-55,-27 -324,-159 -374,-177 -50,-18 -87,-27 -123,28 -37,54 -142,176 -173,211 -33,37 -64,41 -119,14 -55,-27 -231,-83 -440,-269 -162,-143 -273,-321 -304,-375 -31,-54 -3,-84 24,-111 25,-25 54,-64 83,-95 7,-9 13,-18 19,-26 13,-20 22,-39 35,-65 19,-36 9,-68 -4,-95 -14,-27 -123,-294 -169,-403 -45,-108 -91,-90 -124,-90 -31,0 -68,-5 -104,-5 -37,0 -96,14 -146,68 -50,54 -191,186 -191,453 0,63 11,125 28,185 55,191 174,349 195,376 27,35 378,601 934,820 556,216 556,144 656,134 101,-8 324,-130 369,-258 46,-126 46,-235 32,-258 -13,-21 -50,-35 -104,-62z"/>
                </g>
              </g>
            </svg>
            </a> </div>
          <div class="shareDivIn emailBtn"> <a href="mailto:?subject=Participation in the National Agenda Forum (NAF)&body=Gandhiji, on his Constructive Programme (https://goo.gl/Qpphxj), had outlined the blueprint for independent India. Let's spread his vision and formulate an actionable agenda for India in his 150th Birth Anniversary year. You can log on to www.indianpac.com/naf to participate in the National Agenda Forum (NAF) and resurrect the conversation around the 18-point Constructive Programme."
                                title="Share by Email">
            <svg height="512px" id="Layer_1" style="enable-background:new 0 0 512 512;"
                                        version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <g>
                <polygon
                                                points="448,384 448,141.8 316.9,241.6 385,319 383,321 304.1,251.4 256,288 207.9,251.4 129,321 127,319 195,241.6    64,142 64,384  "/>
                <polygon points="439.7,128 72,128 256,267.9  "/>
              </g>
            </svg>
            </a> </div>
          <div class="shareDivIn pdfBtnOut">
            <div class="pdfBtn transition"> <a href="https://res.cloudinary.com/indianpac/image/upload/naf/images/Constructive_Programme.pdf"
                                    target="_blank">Download PDF</a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- ABOUT NAF ENDS--> 
<!-- Numbers STARTS-->
<div class="container-fluid campaign-about-naf campaign-numbers campaign-dis-orgi" id="digi_counter">
  <?php if($langcookie=="en"){ ?>
  <h1>How the nation came together</h1>
  <?php }?>
  <?php if($langcookie=="hi"){ ?>
  <h1>और इस तरह एक साथ आया भारत</h1>
  <?php }?>
  <div class="row">
    <div class="col-12 d-flex align-content-center flex-wrap padding-left-fix number_desktop smooth-scroll">
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-lg-3  col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_calender.png" /> </div>
        <div class="number_text col-lg-9  col-md-9 col-sm-8 col-xs-8">
		  <h2 class="counter-value" data-count="<?php
		  		$now = time(); // or your date as well
				$OldDate = strtotime("2018-07-11");
				$datediff = $now - $OldDate; 
		  		echo ceil($datediff/86400);
		  ?>">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Days</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>दिन</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="<?php echo base_url();?>state_districts" target="_blank">
        <div class="number_icon col-lg-3  col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_district.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="712">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Districts</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>जिले</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="<?php echo base_url();?>state_districts" target="_blank">
        <div class="number_icon col-lg-3  col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_state.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="36">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>State & UTs</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>राज्य</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon  col-lg-3 col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_participant.png" /> </div>
        <div class="number_text  col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="<?php echo $people_hits['totalvisit'];?>">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Participants</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>भागीदार</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="#campaign-youth">
        <div class="number_icon col-lg-3 col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_volunteer.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="<?php echo $asso_count; ?>">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Youth<br/>
            Associates</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>युवा<br/>
            वॉलेंटियर्स</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="#distinguished-personalities">
        <div class="number_icon col-lg-3 col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_personality.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="<?php echo $testi_count;?>">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Distinguished<br/>
            Personalities</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>प्रतिष्ठित<br/>
            व्यक्ति</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="#campaign-partners">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_organization.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="<?php echo $part_count?>">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Organizations</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>संस्थान</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="#campaign-college">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_college.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="7536">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Colleges</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>कॉलेज</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="<?php echo base_url();?>agendas_nominated" target="_blank">
        <div class="number_icon col-lg-3 col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_agenda.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="<?php echo $nomi_agenda_count;?>">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Agendas<br/>
            Nominated</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>नामित<br/>
            एजेंडा</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="<?php echo base_url();?>leaders_nominated" target="_blank">
        <div class="number_icon col-lg-3 col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_leader.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="<?php echo $nomi_leader_count;?>">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Leaders<br/>
            Nominated</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>नामित<br/>
            नेता</h5>
          <?php }?>
        </div>
        </a> </div>
    </div>
    <div class="col-12 align-content-center number_mobile">
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-lg-3 col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_calender.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="<?php
		  		$now = time(); // or your date as well
				$OldDate = strtotime("2018-07-11");
				$datediff = $now - $OldDate; 
		  		echo ceil($datediff/86400);
		  ?>">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Days</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>दिन</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="<?php echo base_url();?>state_districts" target="_blank">
        <div class="number_icon col-lg-3 col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_district.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="712">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Districts</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>जिले</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="<?php echo base_url();?>state_districts" target="_blank">
        <div class="number_icon col-lg-3 col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_state.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="36">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>State & UTs</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>राज्य</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-lg-3 col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_participant.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="<?php echo $people_hits['totalvisit'];?>">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Participants</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>भागीदार</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="#campaign-youth">
        <div class="number_icon col-lg-3 col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_volunteer.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="<?php echo $asso_count; ?>">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Youth<br/>
            Associates</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>युवा<br/>
            वॉलेंटियर्स</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="#distinguished-personalities">
        <div class="number_icon col-lg-3 col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_personality.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="<?php echo $testi_count;?>">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Distinguished<br/>
            Personalities</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>प्रतिष्ठित<br/>
            व्यक्ति</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="#campaign-partners">
        <div class="number_icon col-lg-3 col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_organization.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="<?php echo $part_count?>">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Organizations</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>संस्थान</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="#campaign-college">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_college.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
		  <h2 class="counter-value" data-count="7536">0</h2>
          <?php if($langcookie=="en"){ ?>
		  <h5>Colleges</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>कॉलेज</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="<?php echo base_url();?>agendas_nominated" target="_blank">
        <div class="number_icon col-lg-3 col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_agenda.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="<?php echo $nomi_agenda_count;?>">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Agendas<br/>
            Nominated</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>नामित<br/>
            एजेंडा</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="<?php echo base_url();?>leaders_nominated" target="_blank">
        <div class="number_icon col-lg-3 col-md-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_leader.png" /> </div>
        <div class="number_text col-lg-9 col-md-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="<?php echo $nomi_leader_count;?>">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Leaders<br/>
            Nominated</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>नामित<br/>
            नेता</h5>
          <?php }?>
        </div>
        </a> </div>
    </div>
  </div>
</div>
<!-- Numbers ENDS--> 
<!-- INFLUENCERS STARTS-->
<div class="container-fluid campaign-about-naf campaign-dis-persona" id="distinguished-personalities">
  <div class="row d-flex no-gutters">
    <div class="col-xl-5  col-lg-5 col-md-5 col-sm-12 col-xs-12 about-naf-column">
	  <h1> 
		<?php
			$fmt = new NumberFormatter($locale = 'en_IN', NumberFormatter::DECIMAL);
			echo $fmt->format($testi_count);
		?>
        <?php if($langcookie=="en"){ ?>
        Distinguished<br/>
        Personalities
        <?php }?>
        <?php if($langcookie=="hi"){ ?>
        प्रतिष्ठित<br/>
        व्यक्ति
        <?php }?>
      </h1>
      <?php if($langcookie=="en"){ ?>
      <p> We are humbled by the support extended to NAF by distinguished personalities from all over the world including Nobel laureates and Padma awardees, contemporary Gandhians, eminent sportspersons and Bollywood celebrities </p>
      <?php }?>
      <?php if($langcookie=="hi"){ ?>
      <p> NAF को नोबेल पुरस्कार विजेता, पद्म सम्मान प्राप्त, समकालीन गांधीवादी, प्रतिष्ठित खिलाड़ियों और बॉलीवुड हस्तियों समेत दुनियाभर के प्रतिष्ठित व्यक्तित्वों ने समर्थन दिया है </p>
      <?php }?>
      <a href="<?php echo base_url();?>home/influencers">
      <div class="btn campaign-read-share line-height-fix d-none d-lg-block d-xl-block">
        <?php if($langcookie=="en"){ ?>
        See More
        <?php }?>
        <?php if($langcookie=="hi"){ ?>
        पूरा देखें
        <?php }?>
      </div>
      </a> </div>
    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12 d-flex align-content-center justify-content-end flex-wrap" id="random-testimonials"> </div>
    <div class="col-md-12 col-sm-12 col-xs-12 about-naf-column justify-content-center d-flex d-sm-flex d-md-flex d-lg-none d-xl-none"> <a href="<?php echo base_url();?>home/influencers">
      <div class="btn campaign-read-share line-height-fix mobile">
        <?php if($langcookie=="en"){ ?>
        See More
        <?php }?>
        <?php if($langcookie=="hi"){ ?>
        पूरा देखें
        <?php }?>
      </div>
      </a> </div>
  </div>
</div>
<!-- INFLUENCERS ENDS--> 
<!-- PARTNERS STARTS-->
<div class="container-fluid campaign-about-naf campaign-dis-orgi" id="campaign-partners">
  	<div class="row d-none d-sm-flex d-md-flex d-lg-flex d-xl-flex no-gutters">
		<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 d-sm-flex d-md-flex d-lg-flex d-xl-flex align-content-center justify-content-start flex-wrap" id="random-partners"> 
		<!--jquery--> 
		</div>
		<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 d-sm-flex d-md-flex d-lg-flex d-xl-flex flex-column about-naf-column">
			<h1 class="align-self-end align-self-md-start align-self-lg-end align-self-xl-end"> 
				<?php
					$fmt = new NumberFormatter($locale = 'en_IN', NumberFormatter::DECIMAL);
					echo $fmt->format($part_count);
				?>
				<?php if($langcookie=="en"){ ?>
				Organizations
				<?php }?>
				<?php if($langcookie=="hi"){ ?>
				संस्थान
				<?php }?>
			</h1>
			<?php if($langcookie=="en"){ ?>
			<p class="align-self-end"> 
				Organizations from all over India have extended support to NAF including Dabbawalas, Sulabh International, Akshaya Patra Foundation , South Asia Bamboo Foundation, Share NGO, Sevagram Ashram, and Gandhi Smarak Nidhi </p>
			<?php }?>
			<?php if($langcookie=="hi"){ ?>
			<p class="align-self-end"> 
				 डब्बावाला, सुलभ इंटरनेशनल, अक्षय पात्रा फाउंडेशन, साउथ एशिया बंबू फाउंडेशन, शेयर एन.जी.ओ., सेवाग्राम आश्रम और गांधी स्मारक निधि समेत देश के कई प्रतिष्ठित संस्थानों ने NAF को समर्थन दिया है 
			</p>
			<?php }?>
			<a href="<?php echo base_url();?>home/organizations" class="align-self-end align-self-md-start align-self-lg-end align-self-xl-end">
				<div class="btn campaign-read-share line-height-fix d-none d-lg-block d-xl-block">
					<?php if($langcookie=="en"){ ?>
					See More
					<?php }?>
					<?php if($langcookie=="hi"){ ?>
					पूरा देखें
					<?php }?>
				</div>
			</a> 
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 about-naf-column justify-content-center d-flex d-sm-flex d-md-flex d-lg-none d-xl-none"> 
			<a href="<?php echo base_url();?>home/organizations">
				<div class="btn campaign-read-share line-height-fix">
					<?php if($langcookie=="en"){ ?>
					See More
					<?php }?>
					<?php if($langcookie=="hi"){ ?>
					पूरा देखें
					<?php }?>
				</div>
			</a> 
		</div>
  	</div>
  	<div class="row d-block d-sm-none">
		<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12  col-xs-12 about-naf-column">
			<h1> 
				<?php 
					$fmt = new NumberFormatter($locale = 'en_IN', NumberFormatter::DECIMAL);
					echo $fmt->format($part_count);
				?>
				<?php if($langcookie=="en"){ ?>
				Organizations
				<?php }?>
				<?php if($langcookie=="hi"){ ?>
				संस्थान
				<?php }?>
			</h1>
			<?php if($langcookie=="en"){ ?>
			<p> 
				Organizations from all over India have extended support to NAF including UNESCO-MGIEP, Dabbawalas, Sulabh International, Akshaya Patra Foundation , South Asia Bamboo Foundation, Share NGO, Sevagram Ashram, and Gandhi Smarak Nidhi </p>
			<?php }?>
			<?php if($langcookie=="hi"){ ?>
			<p> 
				यूनेस्को-एमजीआईईपी, डब्बावाला, सुलभ इंटरनेशनल, अक्षय पात्रा फाउंडेशन, साउथ एशिया बंबू फाउंडेशन, शेयर एन.जी.ओ., सेवाग्राम आश्रम और गांधी स्मारक निधि समेत देश के कई प्रतिष्ठित संस्थानों ने NAF को समर्थन दिया है </p>
			<?php }?>
			<a href="<?php echo base_url();?>home/organizations" class="">
				<div class="btn campaign-read-share line-height-fix d-none d-lg-block d-xl-none">
					<?php if($langcookie=="en"){ ?>
					See More
					<?php }?>
					<?php if($langcookie=="hi"){ ?>
					पूरा देखें
					<?php }?>
				</div>
			</a> 
		</div>
		<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12 d-flex align-content-center flex-wrap" id="random-partners-mobile"> </div>
		<div class="col-md-12 col-sm-12 col-xs-12 about-naf-column justify-content-center d-flex d-sm-flex d-md-flex d-lg-none d-xl-none"> 
			<a href="<?php echo base_url();?>home/organizations">
				<div class="btn campaign-read-share line-height-fix">
					<?php if($langcookie=="en"){ ?>
					See More
					<?php }?>
					<?php if($langcookie=="hi"){ ?>
					पूरा देखें
					<?php }?>
				</div>
			</a> 
		</div>
	</div>
</div>
<!-- PARTNERS ENDS--> 
<!-- YOUTH DRIVING NAF STARTS-->
<div class="container-fluid campaign-about-naf campaign-dis-persona" id="campaign-youth">
  	<div class="row d-flex no-gutters">
		<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12 about-naf-column">
			<h1>
				<?php
					$fmt = new NumberFormatter($locale = 'en_IN', NumberFormatter::DECIMAL);
					echo $fmt->format($asso_count);
				?><br>
				<?php if($langcookie=="en"){ ?>Youth Associates<?php }?>
				<?php if($langcookie=="hi"){ ?>NAF के युवा सारथी <?php }?>
			</h1>
			<?php if($langcookie=="en"){ ?>
			<p> 
				Youth from all districts of India have associated themselves with I-PAC to help drive NAF by spreading Gandhiji’s vision in their colleges and localities and getting citizens to participate in this unique initiative</p>
			<?php }?>
			<?php if($langcookie=="hi"){ ?>
			<p>
				ददेश के सभी जिलों के युवा I-PAC के साथ जुड़कर अपने कॉलेजों एवं मोहल्लों में गांधीजी के संदेश को फैलाकर एवं नागरिकों को इस पहल से जोड़कर NAF को आगे बढ़ाने में मदद कर रहे हैं
			</p>
			<?php }?>
			<a href="<?php echo base_url();?>home/associates">
				<div class="btn campaign-read-share line-height-fix desktop"> 
					<?php if($langcookie=="en"){ ?>See More<?php }?>
					<?php if($langcookie=="hi"){ ?>पूरा देखें <?php }?>
				</div>
			</a> 
		</div>
		<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12 d-flex align-content-center justify-content-end flex-wrap" id="random-youth"> </div>
		<div class="col-md-12 col-sm-12 col-xs-12 about-naf-column justify-content-center d-flex d-sm-flex d-md-flex d-lg-none d-xl-none"> 
			<a href="<?php echo base_url();?>home/associates">
				<div class="btn campaign-read-share line-height-fix mobile"> 
					<?php if($langcookie=="en"){ ?>See More<?php }?>
					<?php if($langcookie=="hi"){ ?>पूरा देखें <?php }?> 
				</div>
			</a> 
		</div>
  	</div>
</div>
<!-- YOUTH DRIVING NAF ENDS--> 
<!-- COLLEGES STARTS-->
<div class="container-fluid campaign-about-naf campaign-dis-orgi" id="campaign-college">
  	<div class="row d-none d-sm-flex d-md-flex d-lg-flex d-xl-flex no-gutters">
		<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12 d-flex align-content-center justify-content-start flex-wrap" id="random-college">
		<!--jquery-->	
		</div>
		<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12 d-flex flex-column about-naf-column">
			<h1 class="align-self-end align-self-md-start align-self-lg-end align-self-xl-end">
				7,536
				<?php if($langcookie=="en"){ ?>Colleges<?php }?>
				<?php if($langcookie=="hi"){ ?>कॉलेज<?php }?>
			</h1>
			<?php if($langcookie=="en"){ ?>
			<p class="align-self-end"> 
				The youth associates are students enrolled in educational institutes all over India including IITs, IIMs, NITs, Delhi University, JNU, BHU, AMU, TISS, Jadhavpur University, University of Hyderabad and Anna University
			</p>
			<?php }?>
			<?php if($langcookie=="hi"){ ?>
			<p class="align-self-end">
				आईआईटी, आईआईएम, एनआईटी, दिल्ली यूनिवर्सिटी, जेएनयू, बीएचयू, एएमयू, टीआईएसएस, जाधवपुर यूनिवर्सिटी, हैदराबाद यूनिवर्सिटी, अन्ना यूनिवर्सिटी समेत देश के अलग-अलग शैक्षणिक संस्थानों के छात्र मिलकर NAF को आगे बढ़ा रहे हैं
			</p>
			<?php }?>
			<a href="<?php echo base_url();?>home/associates" class="align-self-end align-self-md-start align-self-lg-end align-self-xl-end">
				<div class="d-sm-none d-xs-none d-md-none d-lg-block btn campaign-read-share line-height-fix"> 
					<?php if($langcookie=="en"){ ?>See More<?php }?>
					<?php if($langcookie=="hi"){ ?>पूरा देखें <?php }?> 
				</div>
			</a> 
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 about-naf-column justify-content-center d-flex d-sm-flex d-md-flex d-lg-none d-xl-none"> 
			<a href="<?php echo base_url();?>home/associates">
				<div class="btn campaign-read-share line-height-fix"> 
					<?php if($langcookie=="en"){ ?>See More<?php }?>
					<?php if($langcookie=="hi"){ ?>पूरा देखें <?php }?>
				</div>
			</a>
		</div>
	</div>
	<div class="row d-block d-sm-none">
    	<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12 d-flex flex-column about-naf-column">
			<h1 class="align-self-start">
				7,536
				<?php if($langcookie=="en"){ ?>Colleges<?php }?>
				<?php if($langcookie=="hi"){ ?>कॉलेज<?php }?>
			</h1>
			<?php if($langcookie=="en"){ ?>
			<p class="align-self-start"> 
				The youth associates are students enrolled in educational institutes all over India including IITs, IIMs, NITs, Delhi University, JNU, BHU, AMU, TISS, Jadhavpur University, University of Hyderabad and Anna University
			</p>
			<?php }?>
			<?php if($langcookie=="hi"){ ?>
			<p class="align-self-start">
				आईआईटी, आईआईएम, एनआईटी, दिल्ली यूनिवर्सिटी, जेएनयू, बीएचयू, एएमयू, टीआईएसएस, जाधवपुर यूनिवर्सिटी, हैदराबाद यूनिवर्सिटी, अन्ना यूनिवर्सिटी समेत देश के अलग-अलग शैक्षणिक संस्थानों के छात्र मिलकर NAF को आगे बढ़ा रहे हैं
			</p>
			<?php }?>
		</div>
		<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12 d-flex align-content-center justify-content-start flex-wrap" id="random-college-mobile">
		<!--jquery-->	
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 about-naf-column justify-content-center d-flex d-sm-flex d-md-flex d-lg-none d-xl-none"> 
			<a href="<?php echo base_url();?>home/associates">
			  	<div class="btn campaign-read-share line-height-fix"> 
					<?php if($langcookie=="en"){ ?>See More<?php }?>
					<?php if($langcookie=="hi"){ ?>पूरा देखें <?php }?>
				</div>
		  	</a>
		</div>
  	</div>
</div>
<!-- COLLEGES ENDS--> 
<!-- PEOPLE WHOM INDIA STARTS-->
<div class="container-fluid campaign-about-naf campaign-dis-orgi" id="campaign-india-wants">
  <div class="row d-flex no-gutters">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 about-naf-column">
      <h1>
        <?php if($langcookie=="en"){ ?>
        Top 10 non political personalities nominated by the people to join politics
        <?php }?>
        <?php if($langcookie=="hi"){ ?>
        10 प्रमुख गैर-राजनीतिक शख्सियत जिन्हें लोग राजनीति में देखना चाहते हैं
        <?php }?>
      </h1>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 d-flex align-content-center justify-content-end flex-wrap" id="random-india-wants"> 
		<div class="p-2 bd-highlight india-wants-div"><div class="indian-wants-box"><div class="indian-wants-text">Aamir Khan</div></div></div>
		<div class="p-2 bd-highlight india-wants-div"><div class="indian-wants-box"><div class="indian-wants-text">Akshay Kumar</div></div></div>
		<div class="p-2 bd-highlight india-wants-div"><div class="indian-wants-box"><div class="indian-wants-text">Anna Hazare</div></div></div>
		<div class="p-2 bd-highlight india-wants-div"><div class="indian-wants-box"><div class="indian-wants-text">Baba Ramdev</div></div></div>
		<div class="p-2 bd-highlight india-wants-div"><div class="indian-wants-box"><div class="indian-wants-text">Kailash Satyarthi</div></div></div>
		<div class="p-2 bd-highlight india-wants-div"><div class="indian-wants-box"><div class="indian-wants-text">Mahendra Singh Dhoni</div></div></div>
		<div class="p-2 bd-highlight india-wants-div"><div class="indian-wants-box"><div class="indian-wants-text">Raghuram Rajan</div></div></div>
		<div class="p-2 bd-highlight india-wants-div"><div class="indian-wants-box"><div class="indian-wants-text">Ratan Tata</div></div></div>
		<div class="p-2 bd-highlight india-wants-div"><div class="indian-wants-box"><div class="indian-wants-text">Ravish Kumar</div></div></div>
		<div class="p-2 bd-highlight india-wants-div"><div class="indian-wants-box"><div class="indian-wants-text">Saurav Ganguly</div></div></div>
	</div>
  </div>
</div>
<!-- PEOPLE WHOM INDIA ENDS--> 
<!--Gallery start-->
<div class="container-fluid campaign-gallery">
  <div class="overlay-black">
	<div class="row">
      <div class="row gallery-internal-row">
        <div class="naf-diary-header">
          <h1>
            <?php if($langcookie=="en"){ ?>
            NAF Diaries
            <?php }?>
            <?php if($langcookie=="hi"){ ?>
            NAF डायरी
            <?php }?>
          </h1>
        </div>
      </div>
      <div class="row gallery-internal-row">
        <div class="naf-diary-desc"> 
          <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the</p> --> 
        </div>
      </div>
      <div class="row gallery-internal-row">
        <div class="gallery-section">
          <div data-nanogallery2='{
                  "userID": "158720001@N04",
                  "kind": "flickr",
                  "thumbnailWidth": "auto",
                  "thumbnailHeight": "180",
                  "thumbnailBorderVertical": 0,
                  "thumbnailBorderHorizontal": 0,
                  "colorScheme": {
                    "thumbnail": {
                      "borderColor": "rgba(255,255,255,0)"
                    }
                  },
                  "allowHTMLinData": true,
                  "thumbnailHoverEffect2": "toolsSlideUp|scale120|borderLighter",
                  "galleryDisplayMode": "pagination",
                  "galleryMaxRows": 3,
                  "galleryPaginationMode": "numbers",
                  "thumbnailAlignment": "center",
                  "thumbnailGutterWidth": 20,
                  "thumbnailGutterHeight": 15,
                  "gallerySorting": "titleAsc",
                  "galleryFilterTags": "title"
                  }'> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Gallery End --> 
<!-- New section start -->
<div class="container-fluid news-section-new">
  <div class="row first-row-news">
    <div class="row news-row-internal news-row-header">
      <div class="news-header">
        <h1>
          <?php if($langcookie=="en"){ ?>
          NAF In The News
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          खबरों में NAF
          <?php }?>
        </h1>
      </div>
    </div>
    <div class="row news-row-internal">
      <div class="news-sub-header"> 
        <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the</p> --> 
      </div>
    </div>
    <div id="news-container" class="row news-row-internal"> 
      <!-- <div class="col-lg-8r col-6 col-md-4 col-sm-6">
        <div class="individual-news-card"> <a href="" target="_blank">
          <div class="image-container"><img src="<?php echo base_url()?>assets/images/news/image005.png"></div>
          </a> </div>
      </div>
      <div class="col-lg-8r col-6 col-md-4 col-sm-6">
        <div class="individual-news-card"> <a href="" target="_blank">
        <div class="image-container"><img src="<?php echo base_url()?>assets/images/news/image005.png"></div>
          </a> </div>
      </div>
      <div class="col-lg-8r col-6 col-md-4 col-sm-6">
        <div class="individual-news-card"> <a href="" target="_blank">
        <div class="image-container"><img src="<?php echo base_url()?>assets/images/news/image005.png"></div>
          </a> </div>
      </div>
      <div class="col-lg-8r col-6 col-md-4 col-sm-6">
        <div class="individual-news-card"> <a href="" target="_blank">
        <div class="image-container"><img src="<?php echo base_url()?>assets/images/news/image005.png"></div>
          </a> </div>
      </div>
      <div class="col-lg-8r col-6 col-md-4 col-sm-6">
        <div class="individual-news-card"> <a href="" target="_blank">
        <div class="image-container"><img src="<?php echo base_url()?>assets/images/news/image005.png"></div>
          </a> </div>
      </div>
      <div class="col-lg-8r col-6 col-md-4 col-sm-6">
        <div class="individual-news-card"> <a href="" target="_blank">
        <div class="image-container"><img src="<?php echo base_url()?>assets/images/news/image005.png"></div>
          </a> </div>
      </div>
      <div class="col-lg-8r col-6 col-md-4 col-sm-6">
        <div class="individual-news-card"> <a href="" target="_blank">
        <div class="image-container"><img src="<?php echo base_url()?>assets/images/news/image005.png"></div>
          </a> </div>
      </div>
      <div class="col-lg-8r col-6 col-md-4 col-sm-6">
        <div class="individual-news-card"> <a href="" target="_blank">
        <div class="image-container"><img src="<?php echo base_url()?>assets/images/news/image005.png"></div>
          </a> </div>
      </div> --> 
    </div>
  </div>
</div>
<!-- New Section End -->
<?php include('footer.php'); ?>
</body>
<link href="https://unpkg.com/nanogallery2/dist/css/nanogallery2.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="https://unpkg.com/nanogallery2/dist/jquery.nanogallery2.min.js"></script>
<script>
//function agenda_func(k){

//	alert(document.getElementById('state').value));
//window.location.reload(true);


//alert("bro");
//	alert(document.getElementById('state').value);
//	alert(k);

//}
/*
function abc(){

	alert(document.getElementById('state').value);
alert(document.getElementById('agenda').value);
	//kisan ka class active krdo 
	document.cookie = "ag_ki = Kisans";

	alert('<?php echo $_COOKIE['ag_ki']; ?>');


}
*/




//$(document).ready(function(){ /* PREPARE THE SCRIPT */
//    $("#state").change(function(){ /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
//    	document.cookie = "ag_ki = Kisans";
//
//      var state = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */ 
//      //var agenda = $("#agenda").val(); /* GET THE VALUE OF THE SELECTED DATA */
//      //alert(agenda);
//      var dataString = "state="+state; /* STORE THAT TO A DATA STRING */
//      //var dataString2 = "agenda="+agenda; /* STORE THAT TO A DATA STRING */
//
//
//     $.ajax({ /* THEN THE AJAX CALL */
//        type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
//        url: "<?php echo base_url(); ?>home/home_agenda_leader", /* PAGE WHERE WE WILL PASS THE DATA */
//        data: dataString , /* THE DATA WE WILL BE PASSING */
//        success: function(result){ /* GET THE TO BE RETURNED DATA */
//          $("#xyz").html(result); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
//        }
//      });
//
//
//    });
//  });
//
//  $(document).ready(function(){ /* PREPARE THE SCRIPT */
//    $("#agenda").click(function(){ /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
// 
//alert($("#agenda").val());
//
//  //  	document.cookie = "ag_ki = Kisans";
//
//     var state = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */ 
//      //var agenda = $("#agenda").val(); /* GET THE VALUE OF THE SELECTED DATA */
//      //alert(agenda);
//      var dataString = "state="+state; /* STORE THAT TO A DATA STRING */
//      //var dataString2 = "agenda="+agenda; /* STORE THAT TO A DATA STRING */
//
//      $.ajax({ /* THEN THE AJAX CALL */
//        type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
//       url: "<?php echo base_url(); ?>home/home_agenda_leader", /* PAGE WHERE WE WILL PASS THE DATA */
//        data: dataString , /* THE DATA WE WILL BE PASSING */
//        success: function(result){ /* GET THE TO BE RETURNED DATA */
//          $("#xyz").html(result); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
//        }
//      });
//
//
//   });
//  });



</script>
<script>
// Select all links with hashes
$('a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });
</script>
<script>
$( "#for_mobile" ).click(function() {
  document.getElementById('for_mobile_container').style.display="block";
  $(this).hide();
});
    $('.home-leaderboard').on('click','.slider',function(){
        $(this).addClass('stop');
     });

     $('.home-leaderboard').on('click','.slider.stop',function(){
        $(this).removeClass('stop');
     });


    $(window).one('scroll',function() {
        //AJAX for getting leaderboard details
        $.ajax({
            url: "<?php echo base_url(); ?>home/leader_board_details",
            dataType: "JSON",
            type: "GET",
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                var html ="";
                var html2 = "";
                var html3 = "";
                
                if(result.status === 'success'){
                    var i = 0;
                    var j = 0;

                    // console.log(result.data);

                    $.each(result.data,function(index,value){
                        let changeInRank = value.y_rank - value.t_rank;
                        html += '<tr>';
                        html += '<td class="name-associate">'+ value.name +'<br><small>'+ value.college +'</small></td>';
                        // html += '<td class="college-cell">'+ value.College +'</td>';
                        html += '<td class="padding-the-cell">'+ value.t_votes +'</td>';
                        html += '<td class="college-cell  padding-the-cell">'+ value.t_rank +'</td>';
                        html += '<td class="padding-the-cell">'+ (changeInRank === 0 ? '( - )' : changeInRank > 0 ?  '<i class="fa fa-caret-up fa-2x" aria-hidden="true" style="color:green"></i>'+ ' ' + '+' + changeInRank + '' : '<i class="fa fa-caret-down fa-2x" aria-hidden="true" style="color:red;margin: 0 0 0 3px;position:relative;top:2px;"></i>' + ' ' + changeInRank) +'</td>';
                        html += '</tr>';

                                                if(i%3==0){
                            html2 += '<div class="slide">'
                        }
                            html2 += '<div class="leader-card">'
                                html2 += '<div class="image-container">'
                                    if (value.picture == ""){
                                    html2 += '<img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/leaderboard_associates/male-silhoute.jpg" alt="" />'
                                    }else{
                                    html2 += '<img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/leaderboard_associates/'+value.picture +'" alt="" />'    
                                    }
                                html2 += '</div>'
                                html2 += '<div class="ass-details">'
                                    html2 += '<div class="name-ass">'+ value.name +'</div>'
                                    if(value.college != ""){
                                    html2 += '<div class="college-ass"><small>'+ value.college +'</small></div>'
                                    }
                                    html2 += '<div class="votes-ass"><b>Votes</b> : '+ value.t_votes +'</span></div>'
                                    html2 += '<div class="rank-ass"><b>Rank</b> : '+ value.t_rank +'</span></div>'
                                    if(typeof(value.y_rank) === 'object' && value.y_rank == null){
                                        html2 += '<div class="rank-ass"><b>Change</b> :  <i class="fa fa-circle" aria-hidden="true"      style="color:#26ADE4"></i> New Entrant </div>'
                                    }else{
                                    html2 += '<div class="rank-ass"><b>Change</b> : '+ (changeInRank === 0 ? '( - )' : changeInRank > 0 ?  '<i class="fa fa-caret-up fa-2x" aria-hidden="true" style="color:green"></i>'+ ' ' + '+' + changeInRank + '' : '<i class="fa fa-caret-down fa-2x" aria-hidden="true" style="color:red;margin: 0 0 0 3px;position:relative;top:2px;"></i>' + ' ' + changeInRank) +'</div>'                                        
                                    }

                                html2 += '</div>'
                            html2 += '</div>'

                        i = i + 1;
                        if(i%3==0){
                            html2 += '</div>'
                        }

                        if(j%3==0){
                            html3 += '<div class="slide">'
                        }
                            html3 += '<div class="leader-card">'
                                html3 += '<div class="image-container">'
                                    if (value.picture == ""){
                                    html3 += '<img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/leaderboard_associates/male-silhoute.jpg" alt="" />'
                                    }else{
                                    html3 += '<img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/leaderboard_associates/'+value.picture +'" alt="" />'    
                                    }
                                html3 += '</div>'
                                html3 += '<div class="ass-details">'
                                    html3 += '<div class="name-ass">'+ value.name +'</div>'
                                    if(value.college != ""){
                                    html3 += '<div class="college-ass"><small>'+ value.college +'</small></div>'
                                    }
                                    html3 += '<div class="votes-ass"><b>वोट</b> : '+ value.t_votes +'</span></div>'
                                    html3 += '<div class="rank-ass"><b>रैंक</b> : '+ value.t_rank +'</span></div>'
                                    if(typeof(value.y_rank) === 'object' && value.y_rank == null){
                                        html3 += '<div class="rank-ass"><b>बदलाव</b> :  <i class="fa fa-circle" aria-hidden="true"      style="color:#26ADE4"></i> नया प्रतिभागी </div>'
                                    }else{
                                    html3 += '<div class="rank-ass"><b>बदलाव</b> : '+ (changeInRank === 0 ? '( - )' : changeInRank > 0 ?  '<i class="fa fa-caret-up fa-2x" aria-hidden="true" style="color:green"></i>'+ ' ' + '+' + changeInRank + '' : '<i class="fa fa-caret-down fa-2x" aria-hidden="true" style="color:red;margin: 0 0 0 3px;position:relative;top:2px;"></i>' + ' ' + changeInRank) +'</div>'                                        
                                    }
                                    // html3 += '<div class="rank-ass"><b>बदलाव</b> : '+ (changeInRank === 0 ? '( - )' : changeInRank > 0 ?  '<i class="fa fa-caret-up fa-2x" aria-hidden="true" style="color:green"></i>'+ ' ' + '+' + changeInRank + '' : '<i class="fa fa-caret-down fa-2x" aria-hidden="true" style="color:red;margin: 0 0 0 3px;position:relative;top:2px;"></i>' + ' ' + changeInRank) +'</div>'
                                html3 += '</div>'
                            html3 += '</div>'

                        j = j + 1;
                        if(j%3==0){
                            html3 += '</div>'
                        }

                    });
                    $("#leader_board_data").html(html);
                    $("#leader-board-slider-english").html(html2);
                    $("#leader-board-slider-hindi").html(html3);

                }
            }
        });
    });
</script>
<script type="text/javascript">

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    var phone_val = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
    var whitespaces_val = /^\s+$/;

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    $(document).ready(function () {
        //get video on click code
        $('.video-image-overlay').click(function(){
            // console.log(' You are in victor');
            $('.video-image-overlay')
                .html('<iframe height="331" src="https://www.youtube.com/embed/Wu5KVhZ4sUI?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>')
                .fadeIn(3000);

        });

        // Using way point trigger API to get distinguished personalities
        $('#distinguished-personalities').waypoint(function() {
            // AJAX now
            $.ajax({
                url: "<?php echo base_url(); ?>home/random_testimonials",
                dataType: "JSON",
                type: "GET",
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    // console.log("API CHECK", result);
                    var randomTestimonialHtml = "";
                    if(result.status === 'success' && result.data.length > 0){
                        var randomTestimonials;
                        // for mobile only 4
                        // for desktop all
                        if(isMobile.any()){
                            randomTestimonials = $.grep(result.data, function(value, index){return index < 4});
                        }else{
                            randomTestimonials = result.data;
                        }
						console.log(randomTestimonials);
                        // for each starts
                        $.each(randomTestimonials, function(index,value){
                            randomTestimonialHtml += '<div class="testimonial-foto" style="background-image:url(https://www.indianpac.com/campaign-dev/assets/images/Influencers/'+ value.author_image +');background-size: cover;background-repeat: no-repeat;"><div class="testimonial-info-box"><div class="testimonial-info-text">'+ value.author +'</div></div></div>'
                        });//for each ends
                        $('#random-testimonials').html(randomTestimonialHtml);
                        $('#random-testimonials').animate({'opacity':'1'}, 1000);
                    }else{
                      // Error Handling or Fallback
                    }
                }
            });// AJAX ends
            this.destroy();
          }, {
          offset: '100%'
        });


        // Using way point trigger API to get partners
        $('#campaign-partners').waypoint(function() {
            // AJAX now
            $.ajax({
                url: "<?php echo base_url(); ?>home/random_partners",
                dataType: "JSON",
                type: "GET",
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    // console.log("API CHECK", result);
                    var randomPartnerHtml = "";
                    if(result.status === 'success' && result.data.length > 0){
                        var randomPartners;
                        if(isMobile.any()){
                            randomPartners = $.grep(result.data, function(value, index){return index < 4});
                        }else{
                            randomPartners = result.data;
                        }
                        // for each starts
                        $.each(randomPartners, function(index,value){
                            randomPartnerHtml += '<div class="testimonial-foto" style="background-image:url(https://www.indianpac.com/campaign-dev/assets/images/partners_new/'+ value.partner_image_name +');background-size: contain;background-position: center;background-repeat: no-repeat;"><div class="testimonial-info-box"><div class="testimonial-info-text">'+ value.partner_name +'</div></div></div>'
                        });//for each ends
                        $('#random-partners').html(randomPartnerHtml);
                        $('#random-partners-mobile').html(randomPartnerHtml);
                        $('#random-partners').animate({'opacity':'1'}, 1000);
                    }else{
                      // Error Handling or Fallback
                    }
                }
            });// AJAX ends
            this.destroy();
          }, {
          offset: '100%'
        });

        // Using way point trigger API to get youth
        $('#campaign-youth').waypoint(function() {
            // AJAX now
            $.ajax({
                url: "<?php echo base_url(); ?>home/random_youth_driving",
                dataType: "JSON",
                type: "GET",
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    // console.log("API CHECK", result);
                    var randomYouthHtml = "";
                    if(result.status === 'success' && result.data.length > 0){
                        var randomYouth;
                        if(isMobile.any()){
                            randomYouth = $.grep(result.data, function(value, index){return index < 4});
                        }else{
                            randomYouth = result.data;
                        }
                        // for each starts
                        $.each(randomYouth, function(index,value){
                          randomYouthHtml += '<div class="testimonial-foto" style="background-image:url(https://www.indianpac.com/campaign-dev/assets/images/ptas/'+ value.image_id +');background-size: cover;background-repeat: no-repeat;"><div class="testimonial-info-box"><div class="testimonial-info-text">'+ value.name +'</div></div></div>'

                            // randomYouthHtml += '<div class="testimonial-foto" style="background-image:url(https://www.indianpac.com/campaign-dev/assets/images/ptas/'+ value.image_id +')"></div>'
                        });//for each ends
                        $('#random-youth').html(randomYouthHtml);
                        $('#random-youth').animate({'opacity':'1'}, 1000);
                    }else{
                      // Error Handling or Fallback
                    }
                }
            });// AJAX ends
            this.destroy();
          }, {
          offset: '100%'
        });

        // Using way point trigger API to get partners
        $('#campaign-college').waypoint(function() {
            // AJAX now
            $.ajax({
                url: "<?php echo base_url(); ?>home/random_college",
                dataType: "JSON",
                type: "GET",
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    // console.log("API CHECK", result);
                    var randomCollegeHtml = "";
                    if(result.status === 'success' && result.data.length > 0){
                        var randomcollege;
                        if(isMobile.any()){
                            randomcollege = $.grep(result.data, function(value, index){return index < 4});
                        }else{
                            randomcollege = result.data;
                        }
                        // for each starts
                        $.each(randomcollege, function(index,value){
                            randomCollegeHtml += '<div class="testimonial-foto" style="background-image:url(https://www.indianpac.com/campaign-dev/assets/images/Colleges/'+ value.college_image +');background-size: contain;background-position: center;background-repeat: no-repeat;"><div class="testimonial-info-box"><div class="testimonial-info-text">'+ value.college_name +'</div></div></div>'
                        });//for each ends
                        $('#random-college').html(randomCollegeHtml).animate({'opacity':'1'}, 1000);
                        $('#random-college-mobile').html(randomCollegeHtml).animate({'opacity':'1'}, 1000);
                
                    }else{
                      // Error Handling or Fallback
                    }
                }
            });// AJAX ends
            this.destroy();
          }, {
          offset: '100%'
        });


        $('#campaign-partners').waypoint(function() {
            // AJAX now
            $.ajax({
                url: "<?php echo base_url(); ?>home/random_news",
                dataType: "JSON",
                type: "GET",
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    // console.log("API CHECK", result);
                    var randomNewsHtml = "";
                    if(result.status === 'success' && result.data.length > 0){
                        var i = 1;
                        $.each(result.data,function(index,value){
                            if (i > 6){
                                randomNewsHtml += '<div class="col-lg-8r col-md-4 col-sm-4 col-4 d-none d-lg-block">'
                            }else{
                                randomNewsHtml += '<div class="col-lg-8r col-md-4 col-sm-4 col-4  ">'
                            }
                                // randomNewsHtml += '<div class="col-lg-8r col-4 col-md-4 col-sm-4">'
                                    randomNewsHtml += '<a href="'+ value.news_link +'" target="_blank"><div class="individual-news-card" style="background-image:url(https://www.indianpac.com/campaign-dev/assets/images/news/'+ value.news_img_name +');background-size: contain;background-position: center;background-repeat: no-repeat;"> '
                                        // randomNewsHtml += '<div class="image-container" ><img src="https://www.indianpac.com/campaign-dev/assets/images/news/'+ value.news_img_name +'"></div>'
                                        // randomNewsHtml += '<div class="image-container" ><img src="https://www.indianpac.com/campaign-dev/assets/images/news/'+ value.news_img_name +'"></div>'

                                        randomNewsHtml += '</div></a></div> '

                        i = i + 1;

                        });
                        console.log(randomNewsHtml)
                        $('#news-container').html(randomNewsHtml);
                    }else{
                      // Error Handling or Fallback
                    }
                }
            });// AJAX ends
            this.destroy();
          }, {
          offset: '100%'
        });


        
        // Counter code
        $('#digi_counter').waypoint(function() {
            //Counter code
            var a = 0;
            $('.counter-value').each(function () {
                var $this = $(this),
                    countTo = $this.attr('data-count');
                $({
                    countNum: $this.text()
                }).animate({
                        countNum: countTo
                    },

                    {

                        duration: 3000,
                        easing: 'linear',
                        step: function () {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function () {
                            x = this.countNum.toString();
                            var lastThree = x.substring(x.length - 3);
                            var otherNumbers = x.substring(0, x.length - 3);
                            if (otherNumbers != '')
                                lastThree = ',' + lastThree;
                            var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
                            $this.text(res);
                            //alert('finished');
                        }

                    });
                });
				a = 1;
				this.destroy();
            }, {
            offset: '100%'
        });

        $.ajax({
            url: "<?php echo base_url(); ?>home/getTotalTrendingCount",
            dataType: "JSON",
            type: "GET",
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                trendingTotalCount = result.length;
            }
        });

        $.ajax({
            url: "<?php echo base_url(); ?>home/getTotalTestimonialCount",
            dataType: "JSON",
            type: "GET",
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                testimonialTotalCount = result.length;
            }
        });

        $.ajax({
            url: "<?php echo base_url(); ?>home/getTotalPartnerCount",
            dataType: "JSON",
            type: "GET",
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                partnerTotalCount = result.length;
            }
        });

    });

    // document ready ends

    $("#pta_form1").on("submit", function (e) {
        e.preventDefault();
        var mobile = $("#pta_mobile_number").val();
        $("#pta_form1 .error").fadeOut();
        if (!validateblanktext(mobile)) {
            $('#blank').fadeIn();
            $("#pta_mobile_number").focus();
            return false;
        } else if (!phone_val.test(mobile)) {
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
            success: function (result) {
                if (result.status == "success") {
                    $('.registerPopup').fadeOut();
                    $('.otpPopup').fadeIn();
                    $('.resendOtp').delay(20000).fadeIn();
                } else {
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


    $("#otp_submit1").on("submit", function (e) {
        e.preventDefault();
        //window.location.href = baseurl+"result";
        $("#otp_submit.error").fadeOut();
        var user_otp = $("#user_otp").val();
        if (!validateblanktext(user_otp)) {
            $("#user_otp_error").html("OTP is required.")
            $("#user_otp_error").fadeIn();
            $("#user_otp").focus();
            return false;
        }

        var formData = new FormData($("form#otp_submit1")[0]);
        //$('.otpPopup').fadeIn();

        $.ajax({
            url: "<?php echo base_url(); ?>home/verify_otp",
            data: formData,
            dataType: "JSON",
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                if (result.status == "success") {
                    //location.reload();
                    window.location.href = "<?php echo base_url(); ?>" + result.msg;
                    //window.location.replace("<?php echo base_url(); ?>"+result.msg);
                } else {
                    $("#otp_submit1 .error").fadeIn();
                    $("#user_otp_error").html(result.msg);
                }
            }
        });

    });

    $(".resendOtp").on("click", function (e) {
        //e.preventDefault();
        var mobile = $("#pta_mobile_number").val();
        $("#otp_submit1 .error").fadeOut();
        if (!validateblanktext(mobile)) {
            $("#user_otp_error").html("Please provide mobile number.")
            $("#user_otp_error").fadeIn();
            $("#user_otp").focus();
            return false;
        } else if (!phone_val.test(mobile)) {
            $("#user_otp_error").html("Please provide valid mobile number.")
            $("#user_otp_error").fadeIn();
            $("#user_otp").focus();
            return false;
        }

        $.ajax({
            url: "<?php echo base_url(); ?>home/resend_otp",
            data: {'pta_mobile_number': mobile},
            dataType: "JSON",
            type: "POST",
            success: function (result) {
                if (result.status == "success") {
                    $('.resendOtp').fadeOut();
                    $('.resendOtp').delay(20000).fadeIn();
                } else {
                    $("#otp_submit1 .error").fadeIn();
                    $("#user_otp_error").html(result.msg);
                }
            }
        });
    });

    function validateblanktext(stringtext) {
        if (stringtext == "" || whitespaces_val.test(stringtext) || stringtext == 0) {
            return false;
        } else {
            return true;
        }
    }
	
</script>
<script type="text/javascript">
    <?php if(!empty($this->uri->segment(2))){ ?>
    localStorage.setItem('referral_code','<?php echo $this->uri->segment(2); ?>');
    localStorage.setItem('referral_owner_id','<?php echo $referral_owner_id; ?>');
    <?php }else{ ?>
    localStorage.setItem('referral_code','0');
    localStorage.setItem('referral_owner_id','<?php echo $referral_owner_id; ?>');
    <?php }?>
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
