<style scoped>
header {
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-orient: horizontal;
	-webkit-box-direction: normal;
	-ms-flex-direction: row;
	flex-direction: row;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
 	background:url(<?php echo base_url(); ?>assets/images/top_header_bg.jpg);
	background-repeat: no-repeat;
	background-size: cover;
	background-position: center;
	height: 9.5rem;
	padding: 0 3rem;
	justify-content: flex-start;
}
.gandhiji {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 14%;
	flex: 0 0 14%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
	background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/gandhiji-blur.png);
	background-repeat: no-repeat;
}
.recent-naf-logo {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 68%;
	flex: 0 0 68%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
 <?php if($langcookie=="en") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/NAF-logo-afteredit.png) no-repeat 50% 100%;
 <?php
}
?> <?php if($langcookie=="hi") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/naf_logo_hindi_main-min.png) no-repeat 50% 100%;
 <?php
}
?>
}
.recent-view-result-btn {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 19%;
	flex: 0 0 19%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-pack: end;
	-ms-flex-pack: end;
	justify-content: flex-end;
	-webkit-box-align: end;
	-ms-flex-align: end;
	align-items: flex-end;
	margin: 1.5rem 0;
}
.recent-view-result-btn .registerMobile .recent-view-result {
	position: relative;
	background: #178a0c;
	width: 12em;
	height: 2.8em;
	font-size: 1.2em;
	border-radius: 3px;
	border: 1px solid #178a0c;
	box-shadow: none;
	line-height: 40px;
}
.recent-view-result-btn .registerMobile .recent-view-result:hover {
	border: 1px solid #178a0c;
	background: transparent;
	color: #178a0c;
	font-weight: 600;
	-webkit-transition: all 1s;
	-o-transition: all 1s;
	transition: all 1s;
}

@media (max-width: 320px) {
.recent-naf-logo {
	display: none;
}
.recent-view-result-btn {
	display: none;
}
.recent-logo-btn-mobile {
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	-ms-flex-direction: column;
	flex-direction: column;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 60%;
	flex: 0 0 60%;
}
.recent-mobile-naf-logo {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 70%;
	flex: 0 0 70%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
 <?php if($langcookie=="en") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/NAF-logo-afteredit.png);
 <?php
}
?> <?php if($langcookie=="hi") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/naf_logo_hindi_main-min.png);
 <?php
}
?> background-size: 100%;
 background-repeat: no-repeat;
 background-position: 0% 100%;
}
.recent-mobile-view-result-btn {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 30%;
	flex: 0 0 30%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	margin: 0;
	-webkit-box-align: center;
	-ms-flex-align: center;
	align-items: center;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
	padding: 0;
}
header {
	padding: 0;
	height: 4.8rem;
	-webkit-box-pack: start;
	-ms-flex-pack: start;
	justify-content: flex-start;
	background-position: 60%;
}
.gandhiji {
	background-position: 0em 10px;
	background-size: contain;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 20%;
	flex: 0 0 20%;
}
.recent-mobile-view-result-btn .registerMobile .recent-view-result {
	width: 85px;
	font-size: 10px;
	height: 20px;
	line-height: 7.5px;
	margin-top: 0;
	box-shadow: none;
	border-radius: 0;
}
}

@media (min-width:321px) and (max-width:360px) {
.recent-naf-logo {
	display: none;
}
.recent-view-result-btn {
	display: none;
}
header {
	padding: 0;
	height: 8.8rem;
	-webkit-box-pack: start;
	-ms-flex-pack: start;
	justify-content: flex-start;
	background-position: 60%;
}
.recent-logo-btn-mobile {
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	-ms-flex-direction: column;
	flex-direction: column;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 50%;
	flex: 0 0 50%;
}
.recent-mobile-naf-logo {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 70%;
	flex: 0 0 70%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
<?php if($langcookie=="en") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/NAF-logo-afteredit.png);
 <?php
}
?> <?php if($langcookie=="hi") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/naf_logo_hindi_main-min.png);
 <?php
}
?> background-size: 100%;
 background-repeat: no-repeat;
 background-position: 0% 100%;
}
.recent-mobile-view-result-btn {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 30%;
	flex: 0 0 30%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	margin: 0;
	-webkit-box-align: center;
	-ms-flex-align: center;
	align-items: center;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
	padding: 0;
}
.gandhiji {
	background-position: 0em 1em;
	background-size: contain;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 30%;
	flex: 0 0 30%;
}
.recent-mobile-view-result-btn .registerMobile .recent-view-result {
	width: 80px;
	font-size: 9px;
	height: 20px;
	line-height: 8px;
	margin-top: 0;
	box-shadow: none;
	border-radius: 0;
}
}

@media (min-width:361px) and (max-width:380px) {
.recent-naf-logo {
	display: none;
}
.recent-view-result-btn {
	display: none;
}
header {
	padding: 0;
	height: 4.8rem;
	-webkit-box-pack: start;
	-ms-flex-pack: start;
	justify-content: flex-start;
	background-position: 60%;
}
.recent-logo-btn-mobile {
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	-ms-flex-direction: column;
	flex-direction: column;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 60%;
	flex: 0 0 60%;
}
.recent-mobile-naf-logo {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 75%;
	flex: 0 0 75%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
 <?php if($langcookie=="en") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/NAF-logo-afteredit.png);
 <?php
}
?> <?php if($langcookie=="hi") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/naf_logo_hindi_main-min.png);
 <?php
}
?> background-size: 100%;
 background-repeat: no-repeat;
 background-position: 0% 100%;
}
.recent-mobile-view-result-btn {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 30%;
	flex: 0 0 30%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	margin: 0;
	-webkit-box-align: center;
	-ms-flex-align: center;
	align-items: center;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
	padding: 0;
}
.gandhiji {
	background-position: 0em 1em;
	background-size: contain;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 20%;
	flex: 0 0 20%;
}
.recent-mobile-view-result-btn .registerMobile .recent-view-result {
	width: 85px;
	font-size: 10px;
	height: 20px;
	line-height: 7px;
	margin-top: 0;
	box-shadow: none;
	border-radius: 0;
}
}

@media (min-width:381px) and (max-width:421px) {
.recent-naf-logo {
	display: none;
}
.recent-view-result-btn {
	display: none;
}
header {
	padding: 0;
	height: 4.8rem;
	-webkit-box-pack: start;
	-ms-flex-pack: start;
	justify-content: flex-start;
	background-position: 60%;
}
.recent-logo-btn-mobile {
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	-ms-flex-direction: column;
	flex-direction: column;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 60%;
	flex: 0 0 60%;
}
.recent-mobile-naf-logo {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 75%;
	flex: 0 0 75%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
 <?php if($langcookie=="en") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/NAF-logo-afteredit.png);
 <?php
}
?> <?php if($langcookie=="hi") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/naf_logo_hindi_main-min.png);
 <?php
}
?> background-size: 100%;
 background-repeat: no-repeat;
 background-position: 0% 100%;
}
.recent-mobile-view-result-btn {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 30%;
	flex: 0 0 30%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	margin: 0;
	-webkit-box-align: center;
	-ms-flex-align: center;
	align-items: center;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
	padding: 0;
}
.gandhiji {
	background-position: 0em 1em;
	background-size: contain;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 20%;
	flex: 0 0 20%;
}
.recent-mobile-view-result-btn .registerMobile .recent-view-result {
	width: 85px;
	font-size: 10px;
	height: 23px;
	line-height: 10px;
	margin-top: 0;
	box-shadow: none;
	border-radius: 0;
}
}

@media (min-width:422px) and (max-width:465px) {
.recent-naf-logo {
	display: none;
}
.recent-view-result-btn {
	display: none;
}
header {
	padding: 0;
	height: 4.8rem;
	-webkit-box-pack: start;
	-ms-flex-pack: start;
	justify-content: flex-start;
	background-position: 60%;
}
.recent-logo-btn-mobile {
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	-ms-flex-direction: column;
	flex-direction: column;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 60%;
	flex: 0 0 60%;
}
.recent-mobile-naf-logo {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 70%;
	flex: 0 0 70%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
 <?php if($langcookie=="en") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/NAF-logo-afteredit.png);
 <?php
}
?> <?php if($langcookie=="hi") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/naf_logo_hindi_main-min.png);
 <?php
}
?> background-size: 100%;
 background-repeat: no-repeat;
 background-position: 0% 100%;
}
.recent-mobile-view-result-btn {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 30%;
	flex: 0 0 30%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	margin: 0;
	-webkit-box-align: center;
	-ms-flex-align: center;
	align-items: center;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
	padding: 0;
}
.gandhiji {
	background-position: 0em 1em;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 20%;
	flex: 0 0 20%;
	background-size: contain;
}
.recent-mobile-view-result-btn .registerMobile .recent-view-result {
	width: 100px;
	font-size: 12px;
	height: 25px;
	line-height: 12px;
	margin-top: 0;
	box-shadow: none;
	border-radius: 0;
}
}

@media (min-width:466px) and (max-width:480px) {
.recent-naf-logo {
	display: none;
}
.recent-view-result-btn {
	display: none;
}
.recent-logo-btn-mobile {
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	-ms-flex-direction: column;
	flex-direction: column;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 58%;
	flex: 0 0 58%;
}
.recent-mobile-naf-logo {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 70%;
	flex: 0 0 70%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
 <?php if($langcookie=="en") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/NAF-logo-afteredit.png);
 <?php
}
?> <?php if($langcookie=="hi") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/naf_logo_hindi_main-min.png);
 <?php
}
?> background-size: 100%;
 background-repeat: no-repeat;
 background-position: 0% 100%;
}
.recent-mobile-view-result-btn {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 30%;
	flex: 0 0 30%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	margin: 0;
	-webkit-box-align: center;
	-ms-flex-align: center;
	align-items: center;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
	padding: 0;
}
header {
	padding: 0;
	height: 5.8rem;
	-webkit-box-pack: start;
	-ms-flex-pack: start;
	justify-content: flex-start;
	background-position: 60%;
}
.gandhiji {
	background-position: 0em 1em;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 21%;
	flex: 0 0 21%;
	background-size: contain;
}
.recent-mobile-view-result-btn .registerMobile .recent-view-result {
	width: 90px;
	font-size: 10px;
	height: 22px;
	line-height: 9px;
	margin-top: 0;
	box-shadow: none;
	border-radius: 0;
}
}

@media (min-width:481px) and (max-width: 768px) {
.recent-naf-logo {
	display: none;
}
.recent-view-result-btn {
	display: none;
}
.recent-logo-btn-mobile {
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	-ms-flex-direction: column;
	flex-direction: column;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 60%;
	flex: 0 0 60%;
	justify-content: center;
}
.recent-mobile-naf-logo {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 50%;
	flex: 0 0 50%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
 <?php if($langcookie=="en") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/NAF-logo-afteredit.png);
 <?php
}
?> <?php if($langcookie=="hi") {
?> background: url(https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/naf_logo_hindi_main-min.png);
 <?php
}
?> background-repeat: no-repeat;
 <?php if($langcookie=="en") {
?> background-position: 50% 100%;
 <?php
}
?> <?php if($langcookie=="hi") {
?> background-position: 50% 40%;
 <?php
}
?>
background-size: 100%;
align-items: center;
}
.recent-mobile-view-result-btn {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 30%;
	flex: 0 0 30%;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	margin: 0;
	-webkit-box-align: center;
	-ms-flex-align: center;
	align-items: center;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	justify-content: center;
	padding: 0;
}
header {
	padding: 0;
	height: 8.8rem;
	-webkit-box-pack: start;
	-ms-flex-pack: start;
	justify-content: flex-start;
}
.gandhiji {
	background-position: 0em 1em;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 20%;
	flex: 0 0 20%;
	background-size: contain;
}
.recent-mobile-view-result-btn .registerMobile .recent-view-result {
	width: 100px;
	font-size: 12px;
	height: 30px;
	line-height: 16px;
	margin-top: 0;
	box-shadow: none;
	border-radius: 0;
}
}

@media (min-width:769px) {
.recent-logo-btn-mobile {
	display: none;
}
}

@media (min-width: 769px) and (max-width:1024px) {
header {
	height: 5.8em;
	padding: 0 6em;
}
.gandhiji {
	background-size: contain;
	background-position: 0% 1em;
	flex: 0 0 22.5%;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 22.5%;
}
.recent-view-result-btn {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 22.5%;
	flex: 0 0 22.5%;
	margin: 0.8rem 0;
}
.recent-naf-logo {
	background-size: contain;
 <?php if($langcookie=="en") {
?> background-position: 0em 1.5em;
 <?php
}
?> <?php if($langcookie=="hi") {
?> background-position: 0em 0.5em;
 <?php
}
?> flex: 0 0 55%;
 -webkit-box-flex: 0;
 -ms-flex: 0 0 55%;
}
.recent-view-result-btn .registerMobile .recent-view-result {
	width: 9.5em;
	font-size: 0.5em;
	line-height: 10px;
}
}

@media (min-width: 1025px) and (max-width:1440px) {
header {
	height: 7.8em;
	padding: 0 6.2em;
}
.gandhiji {
	background-size: contain;
	background-position: 0% 1em;
	flex: 0 0 22.5%;
	-webkit-box-flex: 0;
	-ms-flex: 0 0 22.5%;
}
.recent-naf-logo {
 <?php if($langcookie=="en") {
?> background-position: 0em 1.5em;
 <?php
}
?> <?php if($langcookie=="hi") {
?> background-position: 0em 0.5em;
 <?php
}
?> background-size: contain;
 flex: 0 0 55%;
 -webkit-box-flex: 0;
 -ms-flex: 0 0 55%;
}
.recent-view-result-btn {
	-webkit-box-flex: 0;
	-ms-flex: 0 0 22.5%;
	flex: 0 0 22.5%;
	margin: 1.2rem 0;
}
.recent-view-result-btn .registerMobile .recent-view-result {
	font-size: 0.7em;
	line-height: 18px;
	width: 9em;
}
}
.charkha {
    position: absolute;
    right: 0;
    z-index: 0;
    height: 100%;
}
.influencers_container{max-width:90%;}
@media (min-width: 768px){
.sli_part2_sub1{
	width: 74%;
	padding: 5px 40px 5px 5px;
}
}
</style>
<header>

<div class="gandhiji"></div>
<a href="<?php echo base_url(); ?>" class="recent-naf-logo"></a>
<div class="charkha"><img src="<?php echo base_url(); ?>assets/images/icons/header_charkha.png" /></div>
<div class="site_naf_lang" style="float: right;position: absolute;right:5px;z-index: 999;margin-top: 10px;margin-bottom: 10px;">
  <div onclick="Hindi()" style="padding-right: 5px;float: left;background: linear-gradient(to right, #f79f45 0%, #278747 100%);
    -webkit-background-clip: text;-webkit-text-fill-color: transparent;cursor: pointer;font-size: 12px;">हिंदी  &nbsp;|</div>
  <div onclick="English()" style="padding-left: 2px;float: left;
    background: linear-gradient(to right,#000654 0%, #ff0000 100%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;cursor: pointer;font-size: 12px;">English</div>
</div>
<?php /*?><div class="recent-view-result-btn">
  <?php
        $status = 1;
        if(isset($_SESSION['user']['log_in']) && $_SESSION['user']['log_in']){
            $status = 0;
        }

        if($title!='Result' && $status){ ?>
  <div class="registerMobile">
    <div class="btn resultBtn transition viewResult recent-view-result" id="View_result">
      <?php if($langcookie=="en"){ ?>
      View Result
      <?php }?>
      <?php if($langcookie=="hi"){ ?>
      परिणाम देखें
      <?php }?>
    </div>
  </div>
  <?php } ?>
</div><?php */?>
<div class="recent-logo-btn-mobile"> <a href="<?php echo base_url(); ?>"  class="recent-mobile-naf-logo"></a>
  <?php /*?><div class="recent-mobile-view-result-btn">
    <?php
            $status = 1;
            if(isset($_SESSION['user']['log_in']) && $_SESSION['user']['log_in']){
                $status = 0;
            }

            if($title!='Result' && $status){ ?>
    <div class="registerMobile">
      <div class="btn resultBtn transition viewResult recent-view-result" id="View_result">
        <?php if($langcookie=="en"){ ?>
        View Result
        <?php }?>
        <?php if($langcookie=="hi"){ ?>
        परिणाम देखें
        <?php }?>
      </div>
    </div>
    <?php } ?>
  </div><?php */?>
</div>
</header>
<div class="popup loaderPopup">
  <div class="popupIn">
    <div class="table_cell"> <img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/loader.svg"> </div>
  </div>
</div>

<!-- comment victor test-->