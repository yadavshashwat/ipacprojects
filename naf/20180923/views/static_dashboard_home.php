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
</head>
<body class="home home-wrapper">
<!--header code-->
<?php include('header_home.php'); ?>
<div class="container-fluid text-center banner_bg">
  <div class="container banner_title">
  <?php if($langcookie=="en"){ ?>
    <h1>After 73 years, the nation came together to resurrect the conversation around Mahatma Gandhi’s 18-point Constructive Programme. </h1>
    <h5><font color="#ffbb56">59,67,890</font> citizens came together to decide</h5>
    <?php } ?>
    <?php if($langcookie=="hi"){ ?>
    <h1>73 साल बाद, देश महात्मा गांधीजी के 18-सूत्रीय रचनात्मक कार्यक्रम पर चर्चा को पुनर्जीवित करने के लिए एकजुट हुआ है.</h1>
    <h5><font color="#ffbb56">59,67,890</font> नागरिकों की भागीदारी से चुना गया:</h5>
    <?php } ?>
  </div>
  <div class="container banner_inner">
    <div class="row">
      <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 banner_agenda">
      	<?php if($langcookie=="en"){ ?>
        <h2>The Agenda</h2>
        <h4>The top 10 priorities of the nation</h4>
        <?php } ?>
    	<?php if($langcookie=="hi"){ ?>
    	<h2>एजेंडा</h2>
        <h4>देश की 10 प्राथमिकताएं</h4>
    	<?php } ?>
        <div class="desktop_agendas">
          <div class="agendaOut agendacls9 " id="selectedOpt">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>Women</h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda9.png"> 
                      <!--<p class="only_mob_desc"> Tap to see details </p>--> 
                    </div>
                    <div class="transition agendaImg" id="gandhi_border">7%</div>
                  </div>
                  <!--<div class="agendaoverlay">
                 <label class="transition" id="agenda_description">Protect the interests of farmers and help them become self-reliant without exploiting them for political purposes</label>
                 </div>--> 
                </div>
              </div>
            </div>
          </div>
          <div class="agendaOut agendacls13 " id="selectedOpt">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>Economic Equality</h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda13.png"> </div>
                    <div class="transition agendaImg" id="gandhi_border">7%</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="agendaOut agendacls14 " id="selectedOpt">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>Kisans</h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda14.png"> </div>
                    <div class="transition agendaImg" id="gandhi_border">7%</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="agendaOut agendacls11 " id="selectedOpt">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>Provincial Languages</h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda11.png"> </div>
                    <div class="transition agendaImg" id="gandhi_border">7%</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="agendaOut agendacls17 " id="selectedOpt">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>Lepers</h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda17.png"> </div>
                    <div class="transition agendaImg" id="gandhi_border">7%</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="agendaOut agendacls1 " id="selectedOpt">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>communal Unity</h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda1.png"> </div>
                    <div class="transition agendaImg" id="gandhi_border">7%</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="agendaOut agendacls8 " id="selectedOpt">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>Adult Education</h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda8.png"> </div>
                    <div class="transition agendaImg" id="gandhi_border">7%</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="agendaOut agendacls10 " id="selectedOpt">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>Education in Health &amp; Hygiene</h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda10.png"> </div>
                    <div class="transition agendaImg" id="gandhi_border">7%</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="agendaOut agendacls18 " id="selectedOpt">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>Students</h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda18.png"> </div>
                    <div class="transition agendaImg" id="gandhi_border">7%</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="agendaOut agendacls12 " id="selectedOpt">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>National Language</h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda12.png"> </div>
                    <div class="transition agendaImg" id="gandhi_border">7%</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mobile_agendas">
          <div class="agendaOut agendacls9 " id="selectedOpt">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>Women</h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda9.png"> 
                      <!--<p class="only_mob_desc"> Tap to see details </p>--> 
                    </div>
                    <div class="transition agendaImg" id="gandhi_border">7%</div>
                  </div>
                  <!--<div class="agendaoverlay">
                 <label class="transition" id="agenda_description">Protect the interests of farmers and help them become self-reliant without exploiting them for political purposes</label>
                 </div>--> 
                </div>
              </div>
            </div>
          </div>
          <div class="agendaOut agendacls13 " id="selectedOpt">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>Economic Equality</h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda13.png"> </div>
                    <div class="transition agendaImg" id="gandhi_border">7%</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="agendaOut agendacls14 " id="selectedOpt">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>Kisans</h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda14.png"> </div>
                    <div class="transition agendaImg" id="gandhi_border">7%</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="agendaOut agendacls11 " id="selectedOpt">
            <div class="agendacontainer">
              <div class="table_cell">
                <div class="agenda_point_right">
                  <div class="default">
                    <div class="agendatitlenicon">
                      <h5>Provincial Languages</h5>
                      <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda11.png"> </div>
                    <div class="transition agendaImg" id="gandhi_border">7%</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="read_more"><span><img src="<?php echo base_url()?>assets/images/icons/view_more.png" id="for_mobile" /></span></div>
          <div class="for_mobile" id="for_mobile_container" style="display:none;">
            <div class="agendaOut agendacls17 " id="selectedOpt">
              <div class="agendacontainer">
                <div class="table_cell">
                  <div class="agenda_point_right">
                    <div class="default">
                      <div class="agendatitlenicon">
                        <h5>Lepers</h5>
                        <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda17.png"> </div>
                      <div class="transition agendaImg" id="gandhi_border">7%</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="agendaOut agendacls1 " id="selectedOpt">
              <div class="agendacontainer">
                <div class="table_cell">
                  <div class="agenda_point_right">
                    <div class="default">
                      <div class="agendatitlenicon">
                        <h5>communal Unity</h5>
                        <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda1.png"> </div>
                      <div class="transition agendaImg" id="gandhi_border">7%</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="agendaOut agendacls8 " id="selectedOpt">
              <div class="agendacontainer">
                <div class="table_cell">
                  <div class="agenda_point_right">
                    <div class="default">
                      <div class="agendatitlenicon">
                        <h5>Adult Education</h5>
                        <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda8.png"> </div>
                      <div class="transition agendaImg" id="gandhi_border">7%</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="agendaOut agendacls10 " id="selectedOpt">
              <div class="agendacontainer">
                <div class="table_cell">
                  <div class="agenda_point_right">
                    <div class="default">
                      <div class="agendatitlenicon">
                        <h5>Education in Health &amp; Hygiene</h5>
                        <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda10.png"> </div>
                      <div class="transition agendaImg" id="gandhi_border">7%</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="agendaOut agendacls18 " id="selectedOpt">
              <div class="agendacontainer">
                <div class="table_cell">
                  <div class="agenda_point_right">
                    <div class="default">
                      <div class="agendatitlenicon">
                        <h5>Students</h5>
                        <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda18.png"> </div>
                      <div class="transition agendaImg" id="gandhi_border">7%</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="agendaOut agendacls12 " id="selectedOpt">
              <div class="agendacontainer">
                <div class="table_cell">
                  <div class="agenda_point_right">
                    <div class="default">
                      <div class="agendatitlenicon">
                        <h5>National Language</h5>
                        <img id="gandhi_invert" class="gandhijiicon" src="<?php echo base_url()?>assets/images/icons/icon-agenda12.png"> </div>
                      <div class="transition agendaImg" id="gandhi_border">7%</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12 banner_leader">
      <?php if($langcookie=="en"){ ?>
        <h2>The Leader</h2>
        <h4>Chosen to take up the people’s agenda</h4>
        <?php } ?>
    	<?php if($langcookie=="hi"){ ?>
    	<h2>नेता</h2>
        <h4>एजेंडा को आगे ले जाने के लिए चयनित नेता</h4>
    	<?php } ?>
        
        <div class="agendaOut laedercls1 " id="selectedOpt">
          <div class="agendacontainer">
            <div class="table_cell">
              <div class="agenda_point_right">
                <div class="default">
                  <div class="agendatitlenicon"> </div>
                  <div class="transition agendaImg" id="gandhi_border">7%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="agendaOut laedercls2 " id="selectedOpt">
          <div class="agendacontainer">
            <div class="table_cell">
              <div class="agenda_point_right">
                <div class="default">
                  <div class="agendatitlenicon"> </div>
                  <div class="transition agendaImg" id="gandhi_border">7%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="agendaOut laedercls3 " id="selectedOpt">
          <div class="agendacontainer">
            <div class="table_cell">
              <div class="agenda_point_right">
                <div class="default">
                  <div class="agendatitlenicon"> </div>
                  <div class="transition agendaImg" id="gandhi_border">7%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="agendaOut laedercls4 " id="selectedOpt">
          <div class="agendacontainer">
            <div class="table_cell">
              <div class="agenda_point_right">
                <div class="default">
                  <div class="agendatitlenicon"> </div>
                  <div class="transition agendaImg" id="gandhi_border">7%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="agendaOut laedercls5 " id="selectedOpt">
          <div class="agendacontainer">
            <div class="table_cell">
              <div class="agenda_point_right">
                <div class="default">
                  <div class="agendatitlenicon"> </div>
                  <div class="transition agendaImg" id="gandhi_border">7%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="agendaOut laedercls6 " id="selectedOpt">
          <div class="agendacontainer">
            <div class="table_cell">
              <div class="agenda_point_right">
                <div class="default">
                  <div class="agendatitlenicon"> </div>
                  <div class="transition agendaImg" id="gandhi_border">7%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container banner_bottom_sec">
    <div class="row">
      <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 banner_bottom_text">
      <?php if($langcookie=="en"){ ?>
        <h2>Sign up to help the chosen leader get elected in the upcoming general elections</h2>
        <?php } ?>
    	<?php if($langcookie=="hi"){ ?>
    	<h2>साइन अप कर चयनित नेता को लोकसभा चुनाव जीतने में मदद करें</h2>
    	<?php } ?>
        
      </div>
      <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12 banner_button"> <a href="<?php echo base_url()?>register">
        <div class="btn transition shrBtn line-height-fix campaign-read-share">
        
        <?php if($langcookie=="en"){ ?>
        Campiagn for India
        <?php } ?>
    	<?php if($langcookie=="hi"){ ?>
    	<h2>देश के लिए अभियान</h2>
    	<?php } ?>
        </div>
        </a> </div>
    </div>
  </div>
</div>
<!-- LEADER AGENDA STARTS-->
<div class="container-fluid campaign-about-naf campaign-dis-orgi" id="campaign-leader-agenda">
  <div class="row">
    <div class="col-12" id="leader-agenda-ground">
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
      <div class="row" id="popularity-progress">
        <div class="col-md-4 col-lg-4" id="agenda-points-section">
          <label class="custom-select" for="styledSelect1">
            <select id="styledSelect1" name="options">
              <option value=""> See all States </option>
              <option value="1"> Option 1 </option>
              <option value="2"> Option 2 </option>
              <option value="3"> Option 3 </option>
              <option value="4"> Option 4 </option>
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
            <div id="agenda-points" class="active">Communal Unity</div>
            <div id="agenda-points">Provincial Languages</div>
            <div id="agenda-points">Women</div>
            <div id="agenda-points">Education in Health & Hygiene</div>
            <div id="agenda-points">Adult Education</div>
            <div id="agenda-points">Students</div>
            <div id="agenda-points">Economic Equality</div>
            <div id="agenda-points">National Language</div>
            <div id="agenda-points">Kisans</div>
            <div id="agenda-points">Lepers</div>
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
        </div>
      </div>
    </div>
  </div>
</div>
<!-- LEADER AGENDA ENDS--> 
<!-- ABOUT NAF STARTS-->
<div class="container-fluid campaign-about-naf">
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 about-naf-column">
    <?php if($langcookie=="en"){ ?>
          <h1>About NAF</h1>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h1>NAF के बारे में</h1>
          <?php }?>
      
      <p class="desktop"> 
      <?php if($langcookie=="en"){ ?>
          As the nation celebrates the 150<sup>th</sup> Birth Anniversary year of<br>
        Mahatma Gandhi, Indian Political Action Committee (I-PAC)<br>
        launches the National Agenda Forum (NAF), a pan-India initiative to<br>
        resurrect the conversation around his 18-point Constructive<br>
        Programme and use it to re-imagine and co-create India’s priorities<br>
        to formulate an actionable agenda for contemporary India.
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          महात्मा गांधीजी के 150वीं जयंती वर्ष के अवसर पर इंडियन पॉलिटिकल एक्शन कमिटी (I-PAC) ने नेशनल एजेंडा फोरम (NAF) लॉन्च किया है।<br> इस देशव्यापी पहल का उद्देश्य गांधीजी के 18-सूत्रीय रचनात्मक कार्यक्रम पर चर्चा को पुनर्जीवित करना और इस चर्चा के जरिए देश की प्राथमिताओं को पुनर्कल्पित और सहनिर्मित कर, समकालीन भारत के लिए क्रियान्वयन योग्य एजेंडा तैयार करना है। 
          <?php }?>
      </p>
      <p class="mobile"> 
      <?php if($langcookie=="en"){ ?>
          As the nation celebrates the 150<sup>th</sup> Birth Anniversary year of<br>
        Mahatma Gandhi, Indian Political Action Committee (I-PAC)<br>
        launches the National Agenda Forum (NAF), a pan-India initiative to<br>
        resurrect the conversation around his 18-point Constructive<br>
        Programme and use it to re-imagine and co-create India’s priorities<br>
        to formulate an actionable agenda for contemporary India.
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          महात्मा गांधीजी के 150वीं जयंती वर्ष के अवसर पर इंडियन पॉलिटिकल एक्शन कमिटी (I-PAC) ने नेशनल एजेंडा फोरम (NAF) लॉन्च किया है।<br> इस देशव्यापी पहल का उद्देश्य गांधीजी के 18-सूत्रीय रचनात्मक कार्यक्रम पर चर्चा को पुनर्जीवित करना और इस चर्चा के जरिए देश की प्राथमिताओं को पुनर्कल्पित और सहनिर्मित कर, समकालीन भारत के लिए क्रियान्वयन योग्य एजेंडा तैयार करना है। 
          <?php }?>
      </p>
      <div class="shareBtnOut desktop">
        <?php $url = base_url(); ?>
        <div class="btn transition shrBtn campaign-read-share">
          <?php if($langcookie=="en"){ ?>
          Read and share
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          पढ़ें और शेयर करें
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
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 video-column d-flex align-items-center">
      <div class="video-image-overlay"> <img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/gph.png" width="100%" height="100%"> </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 about-naf-column mobile">
      <div class="shareBtnOut">
        <?php $url = base_url(); ?>
        <div class="btn transition shrBtn line-height-fix campaign-read-share">
          <?php if($langcookie=="en"){ ?>
          Read and share
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          पढ़ें और शेयर करें
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
          <h1>18-सूत्रीय रचनात्मक कार्यक्रम पढ़ें और शेयर करें</h1>
          <?php }?>
  <div class="row">
    <div class="col-12 d-flex align-content-center flex-wrap padding-left-fix scroller number_desktop smooth-scroll">
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_calender.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="53">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Days</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>दिन</h5>
          <?php }?>
          
        </div>
        </a> </div>
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_district.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="706">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Districts</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>जिले</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_state.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="29">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>States</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>राज्य</h5>
          <?php }?>
          
        </div>
        </a> </div>
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_participant.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="7354898">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Participants</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>भागीदार</h5>
          <?php }?>
          
        </div>
        </a> </div>
      <div class="numbers"> <a href="#campaign-youth">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_volunteer.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="101897">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Youth<br/>
            Volunteers</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>युवा<br/> वॉलेंटियर्स</h5>
          <?php }?>
          
        </div>
        </a> </div>
      <div class="numbers"> <a href="#distinguished-personalities">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_personality.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="352">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Distinguished<br/>
            Personalities</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>प्रतिष्ठित<br/> व्यक्ति</h5>
          <?php }?>
          
        </div>
        </a> </div>
      <div class="numbers"> <a href="#campaign-partners">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_organization.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="923">0</h2>
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
          <h2 class="counter-value" data-count="4578">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Colleges</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>कॉलेज</h5>
          <?php }?>
          
        </div>
        </a> </div>
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_agenda.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="78">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Agendas<br/>
            Nominated</h5>
            <?php }?>
            <?php if($langcookie=="hi"){ ?>
          <h5>नामित<br/> एजेंडा</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_leader.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="815">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Leaders<br/>
            Nominated</h5>
            <?php }?>
            <?php if($langcookie=="hi"){ ?>
          <h5>नामित<br/> नेता</h5>
          <?php }?>
        </div>
        </a> </div>
    </div>
    <div class="col-12 d-flex align-content-center flex-nowrap padding-left-fix scroller number_mobile">
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_calender.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="53">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Days</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>दिन</h5>
          <?php }?>
          
        </div>
        </a> </div>
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_district.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="706">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Districts</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>जिले</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_state.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="29">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>States</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>राज्य</h5>
          <?php }?>
          
        </div>
        </a> </div>
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_participant.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="7354898">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Participants</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>भागीदार</h5>
          <?php }?>
          
        </div>
        </a> </div>
      <div class="numbers"> <a href="#campaign-youth">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_volunteer.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="101897">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Youth<br/>
            Volunteers</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>युवा<br/> वॉलेंटियर्स</h5>
          <?php }?>
          
        </div>
        </a> </div>
      <div class="numbers"> <a href="#distinguished-personalities">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_personality.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="352">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Distinguished<br/>
            Personalities</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>प्रतिष्ठित<br/> व्यक्ति</h5>
          <?php }?>
          
        </div>
        </a> </div>
      <div class="numbers"> <a href="#campaign-partners">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_organization.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="923">0</h2>
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
          <h2 class="counter-value" data-count="4578">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Colleges</h5>
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          <h5>कॉलेज</h5>
          <?php }?>
          
        </div>
        </a> </div>
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_agenda.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="78">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Agendas<br/>
            Nominated</h5>
            <?php }?>
            <?php if($langcookie=="hi"){ ?>
          <h5>नामित<br/> एजेंडा</h5>
          <?php }?>
        </div>
        </a> </div>
      <div class="numbers"> <a href="javascript:void(0)">
        <div class="number_icon col-md-3 col-lg-3 col-sm-4 col-xs-4"> <img src="<?php echo base_url();?>assets/images/icons/icon_leader.png" /> </div>
        <div class="number_text col-md-9 col-lg-9 col-sm-8 col-xs-8">
          <h2 class="counter-value" data-count="815">0</h2>
          <?php if($langcookie=="en"){ ?>
          <h5>Leaders<br/>
            Nominated</h5>
            <?php }?>
            <?php if($langcookie=="hi"){ ?>
          <h5>नामित<br/> नेता</h5>
          <?php }?>
        </div>
        </a> </div>
    </div>
  </div>
</div>
<!-- Numbers ENDS--> 
<!-- INFLUENCERS STARTS-->
<div class="container-fluid campaign-about-naf campaign-dis-persona" id="distinguished-personalities">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 about-naf-column">
      <h1><?php echo $testi_count; ?> 
	  <?php if($langcookie=="en"){ ?>
         Distinguished<br/> Personalities
          <?php }?>
          <?php if($langcookie=="hi"){ ?>
          प्रतिष्ठित<br/> व्यक्ति
          <?php }?></h1>
          <?php if($langcookie=="en"){ ?>
      <p> We are humbled by the support extended to NAF by distinguished personalities from all over the world including nobel and padma vibhushan awardees, contemporary Gandhians, eminent sportspersons and bollywood celebrities </p>
      		<?php }?>
          <?php if($langcookie=="hi"){ ?>
          <p>NAF को नोबेल और पद्म विभूषण पुरस्कार विजेता, समकालीन गांधीवादी, प्रतिष्ठित खिलाड़ियों और बॉलीवुड हस्तियों समेत दुनियाभर के प्रतिष्ठित व्यक्तित्वों ने समर्थन दिया है।</p>
          <?php }?>
      <a href="<?php echo base_url();?>home/influencers">
      <div class="btn campaign-read-share line-height-fix desktop"> <?php if($langcookie=="en"){ ?>See More<?php }?><?php if($langcookie=="hi"){ ?>पूरा देखें <?php }?></div>
      </a> </div>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 d-flex align-content-center flex-wrap padding-right-fix" id="random-testimonials"> 
      <!-- <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div>
            <div class="testimonial-foto"></div> --> 
    </div>
    <div class="d-flex col-xs-12 col-sm-12 col-md-4 col-lg-4 about-naf-column justify-content-center mobile"> <a href="<?php echo base_url();?>home/influencers">
      <div class="btn campaign-read-share line-height-fix mobile"> <?php if($langcookie=="en"){ ?>See More<?php }?><?php if($langcookie=="hi"){ ?>पूरा देखें <?php }?> </div>
      </a> </div>
  </div>
</div>
<!-- INFLUENCERS ENDS--> 
<!-- PARTNERS STARTS-->
<div class="container-fluid campaign-about-naf campaign-dis-orgi" id="campaign-partners">
  <div class="row desktop">
    <div class="col-8 d-flex align-content-center flex-wrap padding-left-fix" id="random-partners"> </div>
    <div class="col-4 about-naf-column">
      <h1><?php echo $part_count; ?> <?php if($langcookie=="en"){ ?>Organizations<?php }?><?php if($langcookie=="hi"){ ?>संस्थान <?php }?></h1>
      <?php if($langcookie=="en"){ ?>
      <p> Organizations from all over India have extended support to NAF including UNESCO-MGIEP, Dabbawalas, Sulabh International, Akshaya Patra, South Asia Bamboo Foundation, Share, Sevagram Ashram, and Gandhi Smarak Nidhi </p>
      <?php }?><?php if($langcookie=="hi"){ ?>
      <p>यूनेस्को-एमजीआईईपी, डब्बावाला, सुलभ इंटरनेशनल, अक्षय पात्रा, साउथ एशिया बंबू फाउंडेशन, शेयर, सेवाग्राम आश्रम और गांधी स्मारक निधि समेत देश के संस्थानों ने NAF को समर्थन दिया है। </p>
      <?php }?>
      <a href="<?php echo base_url();?>home/organizations">
      <div class="btn campaign-read-share line-height-fix"> <?php if($langcookie=="en"){ ?>See More<?php }?><?php if($langcookie=="hi"){ ?>पूरा देखें <?php }?> </div>
      </a> </div>
  </div>
  <div class="row mobile">
    <div class="col-xs-12 col-sm-12 about-naf-column">
      <h1><?php echo $part_count; ?> <?php if($langcookie=="en"){ ?>Organizations<?php }?><?php if($langcookie=="hi"){ ?>संस्थान <?php }?></h1>
      <?php if($langcookie=="en"){ ?>
      <p> Organizations from all over India have extended support to NAF including UNESCO-MGIEP, Dabbawalas, Sulabh International, Akshaya Patra, South Asia Bamboo Foundation, Share, Sevagram Ashram, and Gandhi Smarak Nidhi </p>
      <?php }?><?php if($langcookie=="hi"){ ?>
      <p>यूनेस्को-एमजीआईईपी, डब्बावाला, सुलभ इंटरनेशनल, अक्षय पात्रा, साउथ एशिया बंबू फाउंडेशन, शेयर, सेवाग्राम आश्रम और गांधी स्मारक निधि समेत देश के संस्थानों ने NAF को समर्थन दिया है। </p>
      <?php }?>
    </div>
    <div class="col-xs-12 col-sm-12 d-flex align-content-center flex-wrap padding-right-fix" id="random-partners-mobile"> </div>
    <div class="d-flex col-xs-12 col-sm-12 col-md-4 col-lg-4 about-naf-column justify-content-center mobile"> <a href="<?php echo base_url();?>home/organizations">
      <div class="btn campaign-read-share line-height-fix"> <?php if($langcookie=="en"){ ?>See More<?php }?><?php if($langcookie=="hi"){ ?>पूरा देखें <?php }?> </div>
      </a> </div>
  </div>
</div>
<!-- PARTNERS ENDS--> 
<!-- YOUTH DRIVING NAF STARTS-->
<div class="container-fluid campaign-about-naf campaign-dis-persona" id="campaign-youth">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 about-naf-column">
      <h1><?php echo $asso_count; ?><br>
        <?php if($langcookie=="en"){ ?>Youth Driving NAF<?php }?><?php if($langcookie=="hi"){ ?>NAF के युवा सारथी <?php }?></h1>
        <?php if($langcookie=="en"){ ?>
      <p> Young Indians from all districts of India have associated themselves with I-PAC to help drive NAF by spreading Gandhiji’s vision in their colleges and localities and getting citizens to participate in this unique initiative </p>
      <?php }?><?php if($langcookie=="hi"){ ?>
      <p>देश के सभी जिलों के युवा I-PAC के साथ जुड़कर अपने कॉलेजों एवं मोहल्लों में गांधीजी के संदेश को फैलाकर एवं नागरिकों को इस पहल से जोड़कर NAF को आगे बढ़ाने में मदद कर रहे हैं।</p>
      <?php }?>
      <a href="<?php echo base_url();?>home/associates">
      <div class="btn campaign-read-share line-height-fix desktop"> <?php if($langcookie=="en"){ ?>See More<?php }?><?php if($langcookie=="hi"){ ?>पूरा देखें <?php }?> </div>
      </a> </div>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 d-flex align-content-center flex-wrap padding-right-fix" id="random-youth"> </div>
    <div class="d-flex col-xs-12 col-sm-12 col-md-4 col-lg-4 about-naf-column justify-content-center mobile"> <a href="<?php echo base_url();?>home/associates">
      <div class="btn campaign-read-share line-height-fix mobile"> <?php if($langcookie=="en"){ ?>See More<?php }?><?php if($langcookie=="hi"){ ?>पूरा देखें <?php }?> </div>
      </a> </div>
  </div>
</div>
<!-- YOUTH DRIVING NAF ENDS--> 
<!-- COLLEGES STARTS-->
<div class="container-fluid campaign-about-naf campaign-dis-orgi" id="campaign-college">
  <div class="row desktop">
    <div class="col-8 d-flex align-content-center flex-wrap padding-left-fix" id="random-college"> </div>
    <div class="col-4 about-naf-column">
      <h1><?php echo $part_count; ?> <?php if($langcookie=="en"){ ?>Colleges<?php }?><?php if($langcookie=="hi"){ ?>कॉलेज<?php }?></h1>
      <?php if($langcookie=="en"){ ?>
      <p> The youth driving NAF are students enrolled in educational institutes all over India including IITs, IIMs, NITs, Delhi University, JNU, BHU, AMU, TISS, Jadhavpur University, University of Hyderabad, Anna University, etc. </p>
      <?php }?><?php if($langcookie=="hi"){ ?>
      <p>आईआईटी, आईआईएम, एनआईटी, दिल्ली यूनिवर्सिटी, जेएनयू, बीएचयू, एएमयू, टीआईएसएस, जाधवपुर यूनिवर्सिटी, हैदराबाद यूनिवर्सिटी, अन्ना यूनिवर्सिटी समेत देश के अलग-अलग शैक्षणिक संस्थानों के छात्र मिलकर NAF को आगे बढ़ा रहे हैं। </p>
      <?php }?>
      <a href="<?php echo base_url();?>home/associates">
      <div class="btn campaign-read-share line-height-fix"> <?php if($langcookie=="en"){ ?>See More<?php }?><?php if($langcookie=="hi"){ ?>पूरा देखें <?php }?> </div>
      </a> </div>
  </div>
  <div class="row mobile">
    <div class="col-xs-12 col-sm-12 about-naf-column">
      <h1><?php echo $part_count; ?> <?php if($langcookie=="en"){ ?>Colleges<?php }?><?php if($langcookie=="hi"){ ?>कॉलेज<?php }?></h1>
      <?php if($langcookie=="en"){ ?>
      <p> The youth driving NAF are students enrolled in educational institutes all over India including IITs, IIMs, NITs, Delhi University, JNU, BHU, AMU, TISS, Jadhavpur University, University of Hyderabad, Anna University, etc. </p>
      <?php }?><?php if($langcookie=="hi"){ ?>
      <p>आईआईटी, आईआईएम, एनआईटी, दिल्ली यूनिवर्सिटी, जेएनयू, बीएचयू, एएमयू, टीआईएसएस, जाधवपुर यूनिवर्सिटी, हैदराबाद यूनिवर्सिटी, अन्ना यूनिवर्सिटी समेत देश के अलग-अलग शैक्षणिक संस्थानों के छात्र मिलकर NAF को आगे बढ़ा रहे हैं। </p>
      <?php }?>
    </div>
    <div class="col-xs-12 col-sm-12 d-flex align-content-center flex-wrap padding-right-fix" id="campaign-college"> </div>
    <div class="d-flex col-xs-12 col-sm-12 about-naf-column justify-content-center mobile"> <a href="<?php echo base_url();?>home/associates">
      <div class="btn campaign-read-share line-height-fix mobile"> <?php if($langcookie=="en"){ ?>See More<?php }?><?php if($langcookie=="hi"){ ?>पूरा देखें <?php }?> </div>
      </a> </div>
  </div>
</div>
<!-- COLLEGES ENDS--> 
<!-- PEOPLE WHOM INDIA STARTS-->
<div class="container-fluid campaign-about-naf campaign-dis-orgi" id="campaign-india-wants">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 about-naf-column">
            <h1><?php if($langcookie=="en"){ ?>People whom India wants to join politics<?php }?><?php if($langcookie=="hi"){ ?>with all due respect keep hindi content here<?php }?></h1>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 d-flex align-content-center flex-wrap padding-right-fix" id="random-india-wants">
            <div class="p-2 flex-fill bd-highlight india-wants-div"></div>
            <div class="p-2 flex-fill bd-highlight india-wants-div"></div>
            <div class="p-2 flex-fill bd-highlight india-wants-div"></div>
            <div class="p-2 flex-fill bd-highlight india-wants-div"></div>
            <div class="p-2 flex-fill bd-highlight india-wants-div"></div>
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
            एन ए एफ डायरी
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
                  "gallerySorting": "random",
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
    <div class="row news-row-internal">
      <div class="news-header">
        <h1>NAF in news</h1>
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

                    console.log(result.data);

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
                .html('<iframe height="331" src="https://www.youtube.com/embed/hwlW5LSTfNg?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>')
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
                        // for each starts
                        $.each(randomTestimonials, function(index,value){
                            randomTestimonialHtml += '<div class="testimonial-foto" data-toggle="tooltip" data-html="true" title="'+ value.author +'" style="background-image:url(https://www.indianpac.com/campaign-dev/assets/images/Influencers/'+ value.author_image +')"></div>'
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
                            randomPartnerHtml += '<div class="testimonial-foto" data-toggle="tooltip" data-html="true" title="'+ value.partner_name +'" style="background-image:url(https://res.cloudinary.com/ipacnew/image/upload/v1535363792/NAF/Organizations/'+ value.partner_image_name +')"></div>'
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
                            randomYouthHtml += '<div class="testimonial-foto" style="background-image:url(https://res.cloudinary.com/indianpac/image/upload/naf/images/leaderboard_associates/'+ value.picture +')"></div>'
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
                            randomCollegeHtml += '<div class="testimonial-foto" data-toggle="tooltip" data-html="true" title="'+ value.college_name +'" style="background-image:url(https://www.indianpac.com/campaign-dev/assets/images/Colleges/'+ value.college_image +');background-size:cover;background-repeat: no-repeat;"></div>'
                        });//for each ends
                        $('#random-college').html(randomCollegeHtml);
                        $('#random-college-mobile').html(randomCollegeHtml);
                        $('#random-college').animate({'opacity':'1'}, 1000);
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
                                randomNewsHtml += '<div class="col-lg-8r col-4 col-md-4 col-sm-4 d-none d-lg-block">'
                            }else{
                                randomNewsHtml += '<div class="col-lg-8r col-4 col-md-4 col-sm-4">'
                            }
                                // randomNewsHtml += '<div class="col-lg-8r col-4 col-md-4 col-sm-4">'
                                    randomNewsHtml += '<div class="individual-news-card"> <a href="'+ value.news_link +'" target="_blank">'
                                        randomNewsHtml += '<div class="image-container"><img src="https://www.indianpac.com/campaign-dev/assets/images/news/'+ value.news_img_name +'"></div>'
                                        randomNewsHtml += '</a> </div></div>'

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
