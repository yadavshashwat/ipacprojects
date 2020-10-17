
<?php
// Check for previous visits
$query = $this->db->get('people_Count');
$result = $query->result_array();
$current_count = $result[0]['people_count'];
$new_visit_count = $current_count + 1;
$this->db->set('people_count', $new_visit_count, FALSE);
$this->db->update('people_Count');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include('head_element.php'); ?>
<title>NAF</title>
<meta name="description" content="" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
<link rel="stylesheet" href="https://res.cloudinary.com/indianpac/raw/upload/v1532441970/naf/minified_css/owl-pta.carousel.min.css">
<link rel="stylesheet" href="https://res.cloudinary.com/indianpac/raw/upload/naf/minified_css/owl-banner.carousel.min.css">
<link rel="stylesheet" href="https://res.cloudinary.com/indianpac/raw/upload/v1532441971/naf/minified_css/owl.carousel.min.css">
<link rel="stylesheet" href="https://res.cloudinary.com/indianpac/raw/upload/v1532441971/naf/minified_css/owl.theme.default.min.css">
<link rel="stylesheet" href="https://res.cloudinary.com/indianpac/raw/upload/v1532441971/naf/minified_css/owl-pta.theme.default.min.css">
<!--<link rel="stylesheet" href="<?php /*echo base_url();*/?>assets/css/slicss.css">
-->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/swiper.min.css">

<style>
.map_active {
	background: #8080803b;
}
</style>
<style>
.subheading-support-to-naf {
	position: relative;
	top: 5px;
	word-spacing: 1px;
	letter-spacing: 1px;
	font-size: 18px;
	padding: 0 2rem 1rem;
	font-family: serif;
	font-style: italic;
}
.final_wrapper {
	align-items: center;
	display: flex;
	height: 9rem;
	justify-content: center;
	margin: 3rem auto;
	width: 85%;
}
.testimonial-body-flex, .pta-body-flex{
	margin:0 auto;
}
.item-testimonial{
	float:left;
	background-color:#188a44;
}
.testimonial-content{
	width: 70%;
    padding: 10px 20px;
    font-size: 20px;
    position: relative;
}
.testimonial-content:after{
	content: " ";
    position: absolute;
    display: block;
    width: 27%;
    height: 132px;
    top: 0;
    right: 0;
    background: #333333;
    transform-origin: bottom left;
    -ms-transform: skew(-30deg, 0deg);
    -webkit-transform: skew(-30deg, 0deg);
    transform: skew(-20deg, 0deg);
    z-index: 1;
}
.item-testimonial img{
	width:30%;
	max-width: 30%;
    float: left;	
}
.name_desg{
	width:100%;
	float:left;
	background-color:#eca962;
}
 @-webkit-keyframes scroll {
 0% {
 -webkit-transform: translateX(0);
 transform: translateX(0);
}
 100% {
 -webkit-transform: translateX(calc(-250px * 7));
 transform: translateX(calc(-250px * 7));
}
}
 @keyframes scroll {
 0% {
 -webkit-transform: translateX(0);
 transform: translateX(0);
}
 100% {
 -webkit-transform: translateX(calc(-250px * 7));
 transform: translateX(calc(-250px * 7));
}
}
.slider {
	background: white;
	box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.125);
	height: 150px;
	margin: auto;
	overflow: hidden;
	position: relative;
	width: 100%;
}
.slider::before, .slider::after {
	background: linear-gradient(to right, white 0%, rgba(255, 255, 255, 0) 100%);
	content: "";
	height: 150px;
	position: absolute;
	width: 130px;
	z-index: 2;
}
.slider::after {
	right: -1px;
	top: 0;
	-webkit-transform: rotateZ(180deg);
	transform: rotateZ(180deg);
}
.slider::before {
	left: -1px;
	top: 0;
}
.slider .slide-track {
	-webkit-animation: scroll 40s linear infinite;
	animation: scroll 40s linear infinite;
	display: flex;
 width: calc(250px * 14);
}
.slider .slide {
	height: 100px;
	width: 250px;
}
</style>
</head>
<body class="home home-wrapper">
<!--Banner container--> 
<!-- Google Tag Manager (noscript) --> 

<!-- End Google Tag Manager (noscript) -->

<!--header code-->
<?php include('header_home.php'); ?>
<?php include('trending_banner.php'); ?>

<style scoped>
    @font-face {
        font-family: 'Digital-7';
        src: url('https://res.cloudinary.com/indianpac/raw/upload/naf/fonts/Digital-7.woff') format('woff'),
        url('https://res.cloudinary.com/indianpac/raw/upload/naf/fonts/Digital-7.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
    @font-face {
        font-family: 'digital-7.regular';
        src: url('https://res.cloudinary.com/indianpac/raw/upload/naf/fonts/digital-7.regular.eot'),
        url('https://res.cloudinary.com/indianpac/raw/upload/v1532943577/naf/fonts/digital-7.regular.woff2') format('woff2');
        font-weight: normal;
        font-style: normal;
    }

    .recent-plan-wrapper{
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        background: #F7F7F7;
    }
    .recent-plan-quote h1{
        margin: 3rem 30rem 0;
        text-align: center;
        font-family: 'Open Sans', sans-serif;
        font-weight: lighter;
        font-size: 2rem;
    }
    .recent-plan-content-wrapper{
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        flex-direction: row;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 17em;
        flex: 0 0 17em;
    }
    .recent-set-the-agenda{
        position: relative;
        padding: 0rem 5rem 0rem;
        flex:0 0 33.333%;
        display:-webkit-box;
        display:-ms-flexbox;
        display:flex;
        -webkit-box-orient:horizontal;
        -webkit-box-direction:normal;
        -ms-flex-direction:row;
        flex-direction:row;
        margin: 2rem 0;
        border-right:1px solid;
        -webkit-border-image:
                -webkit-gradient(radial, 0 0, 0 100%, from(gray), to(rgba(0, 0, 0, 0))) 1 100%;
        -webkit-border-image:
                -webkit-radial-gradient(gray, rgba(0, 0, 0, 0)) 1 100%;
        -moz-border-image:
                -moz-radial-gradient(gray, rgba(0, 0, 0, 0)) 1 100%;
        -o-border-image:
                -o-radial-gradient(gray, rgba(0, 0, 0, 0)) 1 100%;
        border-image:
                radial-gradient(gray, rgba(0, 0, 0, 0)) 1 100%;
    }
    .recent-agenda-wrapper{
        position:relative;
        left:0.7rem;
    }
    .recent-agenda-content{
        position: relative;
        left: 2rem;
        flex: 0 0 70%;
    }
    .recent-agenda-content h3,.recent-leader-content h3{
        text-transform: uppercase;
        margin: 0 0 0.5rem 0;
        font-size:1.7em;
    }
    .recent-agenda-content p, .recent-leader-content p{
        margin: 0 0 1.5rem 0;
        font-size:1.4em;
    }
    .recent-agenda-content > a > .recent-agenda-vote{
        border: 3px solid #CB6D23;
        background: transparent;
        color: #CB6D23;
        line-height: 28px;
        border-radius: 5px;
        width: 150px;
        text-transform: uppercase;
        height: 45px;
        font-size: 1.2em;
    }
    .recent-agenda-content > a > .recent-agenda-vote:hover{
        background: #CB6D23;
        color: white;
        -webkit-transition: all 1s;-o-transition: all 1s;transition: all 1s;
    }
    .recent-choose-the-leader{
        position: relative;
        padding: 0rem 7rem 0rem 3rem;
        flex:0 0 33.333%;
        display:-webkit-box;
        display:-ms-flexbox;
        display:flex;
        -webkit-box-orient:horizontal;
        -webkit-box-direction:normal;
        -ms-flex-direction:row;
        flex-direction:row;
        margin: 2rem 0;
        border-right:1px solid;
        -webkit-border-image:
                -webkit-gradient(radial, 0 0, 0 100%, from(gray), to(rgba(0, 0, 0, 0))) 1 100%;
        -webkit-border-image:
                -webkit-radial-gradient(gray, rgba(0, 0, 0, 0)) 1 100%;
        -moz-border-image:
                -moz-radial-gradient(gray, rgba(0, 0, 0, 0)) 1 100%;
        -o-border-image:
                -o-radial-gradient(gray, rgba(0, 0, 0, 0)) 1 100%;
        border-image:
                radial-gradient(gray, rgba(0, 0, 0, 0)) 1 100%;
    }
    .recent-leader-wrapper{
        position:relative;
        left:0.7rem;
    }
    .recent-leader-content{
        position: relative;
        left: 2rem;
        flex: 0 0 70%;
    }
    .recent-leader-content > #Choose_the_leader{
        border: 3px solid #002D56;
        background: transparent;
        color: #002D56;
        line-height: 28px;
        border-radius: 5px;
        width: 150px;
        text-transform: uppercase;
        height: 45px;
        font-size: 1.2em;
    }
    .recent-leader-content > #Choose_the_leader:hover{
        background: #002D56;
        color: white;
        -webkit-transition: all 1s;-o-transition: all 1s;transition: all 1s;
    }
    .recent-naf-eco-system{
        position: relative;
        padding: 2rem 6rem 2rem 1rem;
        flex:0 0 33.333%;
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
    }
    .recent-naf-eco-system-wrapper{
        position: relative;
        left: 0.7rem;
    }
    .recent-naf-eco-system-conent{
        -webkit-box-flex: 0;
        -ms-flex: 0 0 70%;
        flex: 0 0 70%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        position: relative;
        left: 1rem;

    }
    .recent-naf-eco-system-heading{
        text-align: center;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 22%;
        flex: 0 0 22%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align:start;
        -ms-flex-align:start;
        align-items:flex-start;
        -webkit-box-pack:start;
        -ms-flex-pack:start;
        justify-content:flex-start;
        color: #363636;
        text-transform: uppercase;
        font-size: 1.7rem;
        font-weight: 700;
    }
    .recent-people-organisations{
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        flex-direction: row;
        -webkit-box-align:start;
        -ms-flex-align:start;
        align-items:flex-start;
        -webkit-box-flex:0;
        -ms-flex:0 0 45%;
        flex:0 0 45%;
    }
    .recent-people-organisations .recent-people{
        -webkit-box-flex: 0;
        -ms-flex: 0 0 40%;
        flex: 0 0 40%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align:start;
        -ms-flex-align:start;
        align-items:flex-start;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }
    .recent-people-organisations .recent-orgi{
        -webkit-box-flex: 0;
        -ms-flex: 0 0 60%;
        flex: 0 0 60%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }
    .recent-associates-influencers{
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        flex-direction: row;
        -webkit-box-align:start;
        -ms-flex-align:start;
        align-items:flex-start;
    }
    .recent-associates-influencers .recent-associates{
        -webkit-box-flex: 0;
        -ms-flex: 0 0 40%;
        flex: 0 0 40%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align:center;
        -ms-flex-align:center;
        align-items:center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }
    .recent-associates-influencers .recent-influencers{
        -webkit-box-flex: 0;
        -ms-flex: 0 0 60%;
        flex: 0 0 60%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }
    .digi-7{
        font-family: 'Digital-7','digital-7.regular';
        font-size: 2.5em;
        letter-spacing: 2px;
    }
    .digi-people{
        color:#D3994A;
    }
    .digi-orgi{
        color:#00B701;
    }
    .digi-asso{
        color:#00828A;
    }
    .digi-influ{
        color:#516AB0;
    }
    .digi-sub-heading{
        font-size: 1.4em;
        font-weight: bold;
        -ms-flex-item-align:center;
        -ms-grid-row-align:center;
        align-self:center;
    }
    @media (max-width:320px) {
        .recent-agenda-content > a > .recent-agenda-vote,
        .recent-leader-content > #Choose_the_leader {
            width: 150px;
            height: 50px;
            line-height: 30px;
        }
    }
    @media (max-width: 768px){
        .owl-carousel-trending .owl-nav button.owl-next, .owl-carousel-trending .owl-nav button.owl-prev{
            display:none;
        }
        .recent-plan-quote h1 {
            margin: 0rem 0rem 0em;
            font-size: 1.1rem;
            border-top: 15px solid #ECECEC;
            padding: 0 1em 1em;
        }
        .recent-plan-content-wrapper {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 58rem;
            flex: 0 0 58rem;
            -webkit-box-orient:vertical;
            -webkit-box-direction:normal;
            -ms-flex-direction:column;
            flex-direction:column;
        }
        .recent-set-the-agenda{
            padding:0;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-ordinal-group:2;-ms-flex-order:1;order:1;
            border-image: none;
            border-right: none;
            border-top: 15px solid #ececec;
            padding-top: 1em;
        }
        .recent-agenda-content p {
            margin: 0 2rem 0.5rem 2rem;
            text-align: center;
        }
        .recent-agenda-content{
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            left:0;

        }
        .recent-choose-the-leader{
            padding:0;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-ordinal-group:3;-ms-flex-order:2;order:2;
            margin:0;
            border-image: none;
            border-right: none;
            border-top: 15px solid #ececec;
            padding-top: 1em;
        }
        .recent-leader-content{
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            left:0;
        }
        .recent-leader-content p {
            margin: 0 2rem 0.5rem 2rem;
            text-align: center;
        }
        .recent-naf-eco-system{
            padding:0;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-ordinal-group:1;
            -ms-flex-order:0;
            order:0;
        }
        .recent-people-organisations {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items:center;
            -webkit-box-flex: 0;
            -ms-flex: 0 0 49%;
            flex: 0 0 49%;
        }
        .recent-people-subheading {
            left: 0;
        }
        .recent-associates-influencers {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }
        .recent-agenda-wrapper {
            left: 0;
        }
        .recent-leader-wrapper {
            left: 0;
        }
        .recent-naf-eco-system-wrapper {
            left: 0;
        }
        .recent-naf-eco-system-conent {
            left: 0rem;
        }
        .recent-people-organisations .recent-people {
            margin: 12px;
        }
        .recent-people-organisations .recent-orgi {
            margin: 0;
        }
        .recent-associates-influencers .recent-associates {
            margin: 12px 0;
        }
        .recent-agenda-content h3, .recent-leader-content h3 {
            font-size: 1.2em;
        }
        .recent-agenda-content p, .recent-leader-content p {
            font-size: 1em;
        }
        .recent-naf-eco-system-heading {
            font-size: 1.2rem;
        }
        .digi-7 {
            font-size: 1.7em;
        }
        .digi-sub-heading {
            font-size: 1em;
        }
        .recent-agenda-wrapper > img{
            height:4em;
        }
        .recent-leader-wrapper > img {
            height:4em;
        }
        .recent-naf-eco-system-wrapper > img {
            height:4em;
        }
        .recent-agenda-content > a > .recent-agenda-vote,
        .recent-leader-content > #Choose_the_leader {
            width: 150px;
            height: 50px;
            line-height: 30px;
        }
    }
    @media (min-width: 769px) and (max-width:1024px){
        .recent-plan-quote h1 {
            margin: 3rem 6rem 0;
            font-size: 1.7rem;
        }
        .recent-set-the-agenda {
            padding: 0rem 0rem 0rem;
        }
        .recent-agenda-wrapper > img{
            height:2em;
        }
        .recent-choose-the-leader {
            padding: 0rem 0rem 0rem 0rem;
        }
        .recent-leader-wrapper > img {
            height:2em;
        }
        .recent-naf-eco-system {
            padding: 2rem 0rem 2rem 0rem;
        }
        .recent-naf-eco-system-wrapper > img {
            height:2em;
        }
        .recent-naf-eco-system-wrapper {
            left: 0;
        }
        .recent-agenda-content h3, .recent-leader-content h3 {
            font-size: 1.2em;
        }
        .recent-agenda-content p, .recent-leader-content p {
            font-size: 1em;
        }
        .recent-naf-eco-system-heading {
            font-size: 1.2rem;
        }
        .digi-7 {
            font-size: 1.7em;
        }
        .digi-sub-heading {
            font-size: 1em;
        }
        .recent-people-organisations {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 43%;
            flex: 0 0 43%;
        }

    }
    @media (min-width: 1025px) and (max-width:1440px){
        .recent-plan-quote h1 {
            margin: 3rem 15rem 0;
        }
        .recent-set-the-agenda {
            padding: 0rem 5rem 0rem;
        }
        .recent-choose-the-leader {
            padding: 0rem 7rem 0rem 3rem;
        }
        .recent-naf-eco-system {
            padding: 2rem 6rem 2rem 1rem;
        }
        .recent-agenda-content h3, .recent-leader-content h3 {
            font-size: 1.3em;
        }
        .recent-agenda-content p, .recent-leader-content p {
            font-size: 1em;
        }
        .recent-naf-eco-system-heading {
            font-size: 1.3rem;
        }
        .digi-7 {
            font-size: 1.7em;
        }
        .digi-sub-heading {
            font-size: 1em;
        }
        .recent-people-organisations {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 43%;
            flex: 0 0 43%;
        }
    }
</style>
<div class="recent-plan-wrapper">
    <div class="recent-plan-quote">
        <h1>
            An attempt to resurrect the conversation and use it to re-imagine and co-create an actionable agenda for contemporary India
        </h1>
    </div>
    <div class="recent-plan-content-wrapper" id="digi_counter">
        <div class="recent-set-the-agenda">
            <div class="recent-agenda-wrapper">
                <img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/agenda-icon-recent.png" alt="Set Agenda" title="Set Agenda">
            </div>
            <div class="recent-agenda-content">
                <h3>Set the Agenda</h3>
                <p>Contribute and vote to decide the top 10 priorities of the nation</p>
                <!-- <a href="<?php echo base_url();?>agenda">
        <div class="btn transition">Vote</div> -->
                <?php if($disable_agenda){?>
                    <div class="btn transition disable blackdisable">Done</div>
                <?php }else{?>
                    <a href="<?php echo base_url();?>agenda" id="Set_the_agenda">
                        <div class="btn transition recent-agenda-vote">Vote</div>
                    </a>
                <?php }?>
                </a>
                <?php if(isset($total_leader_voted_count)){ ?>
                    <!--<p class="stats" style="margin-top:22px;"></p>-->
                    <!--<p class="stats"><?php //echo $total_agenda_voted_count;?> people have already set their agenda</p>-->

                <?php } else { ?>
                    <!--<p class="stats" style="margin-top:20px;"></p>-->
                <?php } ?>
            </div>
        </div>
        <div class="recent-choose-the-leader">
            <div class="recent-leader-wrapper">
                <img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/choose-the-leader-icon-recent.png" alt="choose leader" title="choose leader">
            </div>
            <div class="recent-leader-content">
                <h3>Choose the Leader</h3>
                <p>Vote for the leader best suited to adopt and execute this agenda</p>
                <!-- <div class="btn transition" data-toggle="tooltip" data-placement="top" title="Set Agenda tooltip"> Vote </div> -->
                <?php if($disable_vote){?>
                    <div class="btn transition disable blackdisable">Done</div>
                <?php }else{?>
                    <div class="btn voteBtn transition" data-toggle="tooltip" data-placement="top" title="Set Agenda" id="Choose_the_leader">Vote</div>
                <?php }?>
                <?php if(isset($total_leader_voted_count)){ ?>
                    <!--<p class="stats" style="margin-top:22px;"></p> -->
                    <!--<p class="stats"><?php //echo $total_leader_voted_count;?> people have already chosen their leader</p>-->
                <?php } else { ?>
                    <!--<p class="stats" style="margin-top:20px;"></p>-->
                <?php } ?>
            </div>
        </div>
        <div class="recent-naf-eco-system">
            <div class="recent-naf-eco-system-wrapper">
                <img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/ecosystem-icon-recent.png"/>
            </div>
            <div class="recent-naf-eco-system-conent" id="digi_counter">
                <div class="recent-naf-eco-system-heading">NAF eco system</div>
                <div class="recent-people-organisations">
                    <div class="recent-people">
                        <div class="digi-7 digi-people counter-value" data-count="<?php
                            $query = $this->db->get('people_Count');
                            $result = $query->result_array();
                            $current_count = $result[0]['people_count'];
                            echo $current_count;
                        ?>">
                            4,30,000
                        </div>
                        <div class="digi-sub-heading recent-people-subheading">People</div>
                    </div>
                    <div class="recent-orgi">
                        <div class="digi-7 digi-orgi counter-value" data-count="<?php echo count($part_count);?>">
                            0
                        </div>
                        <div class="digi-sub-heading">Organizations</div>
                    </div>
                </div>
                <div class="recent-associates-influencers">
                    <div class="recent-associates">
                        <div class="digi-7 digi-asso counter-value" data-count="<?php echo count($asso_count);?>">
                            15000
                        </div>
                        <div class="digi-sub-heading">Associates</div>
                    </div>
                    <div class="recent-influencers">
                        <div class="digi-7 digi-influ counter-value" data-count="<?php echo count($testi_count);?>">
                            0
                        </div>
                        <div class="digi-sub-heading">Influencers</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sli">
<div class="sli1">
        <h2>142 Influencers, 206 Organizations, and 28,901 Associates have joined the ever-growing NAF ecosystem</h2>
    </div>
    
    <div class="container" style="padding-bottom: 0px;">
    <span class="support_title">Support for NAF</span>
<div class="support_tabs">
<div class="custom_support_tab influ_tab" onClick="showInfluencers()">Influencers</div>
<div class="custom_support_tab org_tab" onClick="showOrganizations()">Organizations</div>
<div class="custom_support_tab asso_tab" onClick="showAssociates()">Associates</div>
</div>
</div>
<div class="sli3">    

<div class="testimonial-section" id="sinfluencers"> 
      <!-- Testimonial body-->
      
      <div class="testimonial-body-flex">
        <style scoped>
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
              @media (max-width:768px){
                  .customPrevBtnTestimonial{
                      left:2%;
                  }
                  .customNextBtnTestimonial{
                      right:2%;
                  }
              }
          </style>
          <div class="customPrevBtnTestimonial"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/arrow-min-left.png"></div>
          <div class="customNextBtnTestimonial"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/arrow-min.png"></div>
        <div class="owl-carousel owl-theme">
        </div>
      </div>
      <!--<blockquote style="text-align: center;">
        <div class="subheading-support-to-naf"><b>92</b> organizations spread across <b>19</b> states have associated with NAF</div>
      </blockquote>
      <div class="final_wrapper">
        <div class="slider">
          <div class="slide-track">
            <?php foreach ($partner_list as $key4 => $value4) {?>
            <div class="slide"> <img src="https://res.cloudinary.com/indianpac/image/upload/v1532638133/naf/images/organizations/<?php echo $value4['partner_image_name'];?>" alt="partners" /> </div>
            <?php }?>
          </div>
        </div>
      </div>-->
    </div>
<!------ Organizations ----->    
<div class="testimonial-section" id="sorganisations"> 
      <!-- Testimonial body-->
      
      <div class="testimonial-body-flex">
        <style scoped>
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
              @media (max-width:768px){
                  .customPrevBtnTestimonial{
                      left:2%;
                  }
                  .customNextBtnTestimonial{
                      right:2%;
                  }
              }
          </style>
          <div class="customPrevBtnTestimonial"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/arrow-min-left.png"></div>
          <div class="customNextBtnTestimonial"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/arrow-min.png"></div>
        <div class="owl-carousel owl-theme">
        </div>
      </div>
      <!--<blockquote style="text-align: center;">
        <div class="subheading-support-to-naf"><b>92</b> organizations spread across <b>19</b> states have associated with NAF</div>
      </blockquote>
      <div class="final_wrapper">
        <div class="slider">
          <div class="slide-track">
            <?php foreach ($partner_list as $key4 => $value4) {?>
            <div class="slide"> <img src="https://res.cloudinary.com/indianpac/image/upload/v1532638133/naf/images/organizations/<?php echo $value4['partner_image_name'];?>" alt="partners" /> </div>
            <?php }?>
          </div>
        </div>
      </div>-->
    </div>
<!------ START TO CREATE  TESTIMONIAL  PART BY BHAVIK ----->
<div class="testimonial-section-pta" id="sassociates"> 
      <div class="pta-body-flex">
        <style scoped>
              .customPrevBtnPta{
                  position:absolute;
                  top:55%;
                  left:3%;
                  /*-webkit-filter:invert(100%);
                  filter:invert(100%);*/
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
                  /*-webkit-filter:invert(100%);
                  filter:invert(100%);*/
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
                      left:2%;
                  }
                  .customNextBtnPta{
                      right:2%;
                  }
              }
          </style>
          <div class="customPrevBtnPta"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/arrow-min-left.png"></div>
          <div class="customNextBtnPta"><img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/arrow-min.png"></div>
        <div class="owl-carousel-pta owl-theme-pta">          
        </div>
      </div>
    </div>
    </div>
</div>
<div class="sli">
    <div class="sli1">
        <h2>142 Influencers, 206 Organizations, and 28,901 Associates have joined the ever-growing NAF ecosystem</h2>
    </div>
    <div class="sli2">
        <img src="<?php echo base_url();?>assets/news/sli_glass.png">
    </div>
    <div class="sli3">
        <div class="container">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <span>Support for NAF</span>
                <ul class="nav nav-pills nav-justified">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"><a href="#" class="bg1">Influencers</a></li>
                    <li data-target="#myCarousel" data-slide-to="1"><a href="#" class="bg2">Organisations</a></li>
                    <li data-target="#myCarousel" data-slide-to="2"><a href="#" class="bg3">Associates</a></li>
                </ul>
                <!-- Wrapper for slides -->
                <div class="carousel-inner">

                    <!-- Influencers testimonial SECTION BY BHAVIK -->

                    <div class="item active">

                        <div class="sli_part">
                            <?php
                            foreach($Influencers_testimonial as $w1=>$q1)
                            {
                            ?>
                                <div class="sli_part1">
                                    <div class="sli_part1_icon"><img
                                                src="<?php echo base_url(); ?>assets/news/sli_side_logo.png"></div>
                                    <div class="sli_part2">
                                        <div class="sli_part2_sub1">
                                            <center><img src="<?php echo base_url(); ?>assets/news/sli_quto.png">
                                            </center>
                                            <p><?php echo $q1['testimonial']?></p>
                                        </div>
                                        <img src="https://res.cloudinary.com/indianpac/image/upload/v1533116413/naf/images/testimonials/<?php echo $q1['author_image']?>">
                                    </div>
                                    <div class="sli_part3">
                                        <h3><?php echo $q1['author']?></h3>
                                        <p><?php echo $q1['designation']?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                        </div>
                    </div>

                    <!-- Organization  partner SECTION BY BHAVIK -->

                    <div class="item">
                        <div class="sli_part">
                            <?php
                            foreach ($Organization_partner as $a1=>$b1)
                            {
                            ?>
                             <div class="sli_part1">
                                <div class="sli_part1_icon"><img src="<?php echo base_url();?>assets/news/sli_side_logo.png"></div>
                                <div class="sli_part2">
                                    <div class="sli_part2_sub1">
                                        <center><img src="<?php echo base_url();?>assets/news/sli_quto.png"></center>
                                        <p><?php echo $b1['bio']?></p>
                                    </div>
                                    <img src="https://res.cloudinary.com/indianpac/image/upload/v1532851206/naf/images/organizations/<?php echo $b1['partner_image_name']?>">
                                </div>
                                <div class="sli_part3">
                                    <h3><?php echo $b1['partner_name']?></h3>
                                    <p></p>
                                </div>
                            </div>
                            <?php
                            }
                            ?>

                        </div>
                    </div>

                    <!-- Accsociation pta_randomiser  SECTION BY BHAVIK -->

                    <div class="item">
                        <div class="sli_part">
                            <?php
                            foreach ($Associates_pta_randomiser as $l=>$m)
                            {

                                ?>
                                <div class="sli_part1">
                                    <div class="sli_part1_icon"><img
                                                src="<?php echo base_url(); ?>assets/news/sli_side_logo.png"></div>
                                    <div class="sli_part2">
                                        <div class="sli_part2_sub1">
                                            <center><img src="<?php echo base_url(); ?>assets/news/sli_quto.png">
                                            </center>
                                            <p>Yes, I strongly hold the view that there exists a reciprocal relationship between Women Empowerment and Social Stability. I fel very happy that NAF has taken up the mantle to educate the youth abouth the ideals of the father of the nation.</p>
                                        </div>
                                        <img src="https://res.cloudinary.com/indianpac/image/upload/v1532604249/naf/images/top_pta_performers/<?php echo $m['image_id']?>">
                                    </div>
                                    <div class="sli_part3">
                                        <h3><?php echo $m['name']?></h3>
                                        <p><?php echo $m['college_name']?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                        </div>
                    </div><!-- End Item -->

                </div><!-- End Carousel Inner -->




            </div><!-- End Carousel -->
        </div>
    </div>
    <div class="sli4">
        <button>SEE MORE</button>
    </div>
</div>

<!-----  END TO CREATE  TESTIMONIAL  PART BY BHAVIK ----->

<!-- NEWS SECTION START -->


<style type="text/css">
    /** NEWS SLIDER CSS START */
    * {box-sizing: border-box}
    .mySlides {display: none;border-radius: 7px;}
    .news_slider img {vertical-align: middle;}
    /* Slideshow container */
    .slideshow-container {max-width: 1000px;position: relative;padding-top: 40px;flex: 1; /* margin: auto; */position: relative;padding-left: 150px;padding-right: 50px;box-sizing: border-box; width: 50%}
    /* Next & previous buttons */
    .prev, .next {cursor: pointer;position: absolute;bottom: 30px;width: auto;padding: 16px;margin-top: -22px;color: white;font-weight: bold;font-size: 18px;transition: 0.6s ease;border-radius: 0 3px 3px 0;}
    /* Position the "next button" to the right */
    .prev {left: 0px;bottom: 6px;}
    .next {right: 0px;bottom: 6px;right: 0;border-radius: 3px 0 0 3px;}
    /* On hover, add a black background color with a little bit see-through */
    .prev:hover, .next:hover {background-color: rgba(0, 0, 0, 0.8);}
    /* Caption text */
    .text {font-size: 15px;padding: 8px 12px;bottom: 8px;width: 100%;text-align: center;}
    /* Number text (1/3 etc) */
    .numbertext {color: #f2f2f2;font-size: 12px;padding: 8px 12px;position: absolute;top: 0;}
    /* The dots/bullets/indicators */
    .dot {cursor: pointer;/*height: 15px; width: 15px;*/margin: 0 3px;border-radius: 50%;display: inline-block;transition: background-color 0.6s ease;}
    .dot {border: 3px solid transparent;}
    .active_div {background-color: #717171;border: 3px solid #c36300;}
    /* Fading animation */
    .fade {-webkit-animation-name: fade;-webkit-animation-duration: 1.5s;animation-name: fade;animation-duration: 1.5s;}
    @-webkit-keyframes fade { from {opacity: .4} to {opacity: 1} }
    @keyframes fade { from {opacity: .4} to {opacity: 1} }
    /* On smaller screens, decrease text size */
    @media only screen and (max-width: 300px) {  .prev, .next, .text {font-size: 11px}  }
    .news_slider {color: #fff;max-width: 1920px;margin: 0 auto;float:left}
    .bottom_section {display: flex;flex-direction: row;margin: auto;}
    .mySlides {background: #fff;padding: 25px;border-radius: 7px; width: 80%; margin:auto; -ms-transform: skewX(-7deg);
        -webkit-transform: skewX(-7deg);max-height: 215px;min-height: 215px;transform: skewX(-7deg);}
    .slide_Content {display: flex;}
    .slide_Content {display: flex;flex-direction: row;color: #000;}
    .slide_img {flex: 1;align-items: center;justify-content: center;align-self: center;max-width: 150px;}
    .swiper-slide img {border-radius: 50%;}
    .Slide_text {flex: 4;border-left: 1px solid;padding-left: 30px;}
    .Slide_text h1 {margin: 0px;font-size: 22PX;}
    .Slide_text p { margin-top: 10px;}
    .Slide_text a {color: #c36300;}
    .milstone {  flex: 1;padding-top: 40px; padding-bottom: 30px;background: #424242; position: relative; padding-right: 150px;padding-left: 50px;}
    .milstone ul {list-style: none;padding: 0;}
    .milstone ul li {display: inline-block;width: 32%;text-align: center;vertical-align: top;margin-bottom: 15px;}
    .milstone ul li h6 {font-size: 16px;margin: 0px;}
    .milstone ul li p {font-size: 14px;color: #cacaca;margin-top: 5px;}
    .milstone ul li .icon {height: 91px;width: 91px;margin: 0 auto;background: red;border-radius: 100%;background: url(<?php echo base_url()?>assets/news/mileston_bg.png);margin-bottom: 10px;}
    .milstone ul li .icon1 {background-position: 0px 0px;}
    /*.milstone ul li:hover .icon1 {background-position: 0px 274px;}*/
    .milstone ul li .icon2 {background-position: 345px 0px;}
    /*.milstone ul li:hover .icon2 {background-position: 345px 274px;}*/
    .milstone ul li .icon3 {background-position: 94px 0px;}
    /*.milstone ul li:hover .icon3 {background-position: 94px 274px;}*/
    .milstone ul li .icon4 {background-position: -2px -182px;}
    /*.milstone ul li:hover .icon4 {background-position: -2px 92px;}*/
    .milstone ul li .icon5 {background-position: 342px -182px;}
    /*.milstone ul li:hover .icon5 {background-position: 342px 92px;}*/
    .milstone ul li .icon6 {background-position: 91px -182px;}
    /*.milstone ul li:hover .icon6 {background-position: 688px 92px;}*/
    .milstone_active_icon1 { background-position: 0px 274px !important; }
    .milstone_active_icon2 { background-position: 345px 274px !important; }
    .milstone_active_icon3 { background-position: 94px 274px !important; }
    .milstone_active_icon4 { background-position: -2px 92px !important; }
    .milstone_active_icon5 { background-position: 342px 92px !important; }
    .milstone_active_icon6 { background-position: 688px 92px !important; }

    @media only screen and (max-width: 1280px) {
        .Slide_text h1 {font-size: 22px;}
        .Slide_text p {font-size: 14px;}
        .dot img {width: 60px;}
        .milstone ul li {width: 49%;}
    }

    @media only screen and (max-width: 1080px) {
        .bottom_section {flex-direction: column;}
        .slideshow-container{ width: 100%; }
        .slideshow-container, .milstone {padding: 60px 90px;max-width: none;}
        .milstone ul li {margin-bottom: 45px;width: 32%;}
    }

    @media only screen and (max-width: 768px) {
        .milstone ul li {margin-bottom: 25px;width: 49%;}
        .mySlides {text-align: center;}
        .Slide_text {flex: 4;padding-left: 0px;margin-top: 10px;padding-top: 10px;border-left: none;}
        .dot {margin: 0 0px;}
        .slide_Content {flex-direction: column;}
        .dot img {width: 60px;}
        .prev, .next {bottom: -5px;}
    }

    @media only screen and (max-width: 640px) {
        .slideshow-container, .milstone {padding: 40px 30px;}
    }

    @media only screen and (max-width: 610px) {
        .slideshow-container, .milstone {padding: 30px 30px;}
        .slideshow-container h1, .milstone h1 {font-size: 24px;}
        .milstone ul {position: relative;overflow: hidden;}
        .milstone ul li {position: relative;padding-bottom: 25px;margin-bottom: 0px;width: 100%;display: flex;}
        .milstone ul li:after {content: "";width: 2px;position: absolute; /* background-color: red; */height: 100%;left: 45px;z-index: 1;border-left: 2px dashed;}
        .milstone ul li h6 {font-size: 16px;border-bottom: 1px solid;margin: 0px;padding-bottom: 5px;padding-left: 20px;}
        .milstone ul li:last-child:after {content: "";display: none;}
        .milstone ul li p {padding-left: 20px;}
        .mile_content {align-items: left;align-self: center;justify-content: left;flex: 4;text-align: left;}
        .milstone ul li .icon {z-index: 2;max-width: 92px; /* float: left; */flex: 1;min-width: 92px;}
    }

    .swiper-container {
        width: 70%;
        height: 100px;
        padding: 0px 50px;
    }
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: transparent;
        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
        /*height: 91px!important;
        width: 91px!important; */
    }
    .swiper-button-next, .swiper-button-prev{ background-color: rgba(0,0,0,0.5); background-image: none;  padding: 5px;     line-height: 32px; border-radius: 5px;}
    .swiper-button-next{right: 0;}
    .swiper-button-prev{left: 0;}
    .previous_block{ display: block;
        margin-left: -40px;
        position: absolute;
        z-index: 1;
        opacity: 0.5;

        transform: scale(.8);}

    .next_block{    display: block;
        position: absolute;
        right: -40px;
        opacity: 0.5;
        transform: scale(.8);}
    .active_block{display: block; opacity: 1; transform: scale(1);
        z-index: 2;
        position: absolute;
        left: 0;
        right: 0;}
    .slide_inner_box{overflow: hidden;
        position: relative;
        min-height: 330px;}
    .swiper_thumbnail{ position: absolute;bottom: 0; }
    @media only screen and (max-width: 1600px) {.slide_inner_box {min-height: 360px;max-height: 100%;}}
    @media only screen and (max-width: 1400px) {.slide_inner_box {min-height: 400px;max-height: 100%;}}
    @media only screen and (max-width: 1260px) {.slide_inner_box {min-height: 450px;max-height: 100%;}}
    @media only screen and (max-width: 1080px) {.slide_inner_box {min-height: 290px;max-height: 100%;}}
    @media only screen and (max-width: 768px) {.slide_inner_box {min-height: 390px;max-height: 100%;}.swiper-container{width:80%}}
    @media only screen and (max-width: 640px) {.slide_inner_box {min-height: 420px;max-height: 100%;}.swiper-container{width:80%}}
    @media only screen and (max-width: 480px) {.slide_inner_box {min-height: 460px;max-height: 100%;}.swiper-container{width:80%}}
    @media only screen and (max-width: 380px) {.slide_inner_box {min-height: 520px;max-height: 100%;}.swiper-container{width:80%}}
    /** NEWS SLIDER CSS END */
</style>

<div class="news_slider" style="background: #2a2a2a;">
    <div class="bottom_section">
        <div class="slideshow-container">
            <h1>IN THE NEWS</h1>
            <br/>
            <?php if(count($news)){ ?>
                <div class="slide_inner_box">
                <?php foreach ($news as $key_index => $new) {?>
                        <div class="mySlides">
                            <div class="slide_Content">
                                <div class="slide_img"><img src="<?php echo base_url()?>assets/news/<?php echo $new['news_img_name']; ?>"></div>
                                <div class="Slide_text">
                                    <h4><?php echo $new['news_title']; ?></h4>
                                    <p><?php echo $new['news_content']; ?></p>
                                    <a href="<?php echo $new['news_link']; ?>" target="_blank">Read More</a>
                                </div>
                            </div>
                        </div>
                <?php } ?>
                </div>
                <br>
                <!-- Swiper -->
                <div class="swiper-container swiper_thumbnail">
                    <div class="swiper-wrapper">
                        <?php foreach ($news as $key_index => $new) {?>
                            <div class="swiper-slide"><span class="dot" onclick="currentSlide(<?php echo ($key_index + 1); ?>)"><img src="<?php echo base_url()?>assets/news/<?php echo $new['news_img_name']; ?>"> </span></div>
                        <?php } ?>
                    </div>
                    <!-- Add Arrows -->
                    <div id="slideNextBtn" class="swiper-button-next"><img src="<?php echo base_url()?>assets/news/right-arrow.png" height="30"></div>
                    <div class="swiper-button-prev"><img src="<?php echo base_url()?>assets/news/left-arrow.png" height="30"></div>
                    <!-- Add Pagination -->
                </div>
                <br>
            <?php } ?>
        </div>
        <div class="milstone">
            <h1>MILESTONES</h1>
            <br/>
            <ul>
                <li>
                    <div class="icon icon1 milstone_active_icon1"></div>
                    <div class="mile_content">
                        <h6>29 jun '18</h6>
                        <p>NAF Launch</p>
                    </div>
                </li>
                <li>
                    <div class="icon icon2 milstone_active_icon2"></div>
                    <div class="mile_content">
                        <h6>11 jul '18</h6>
                        <p>Voting opens to set the agenda and choose the leader </p>
                    </div>
                </li>
                <li>
                    <div class="icon icon3"></div>
                    <div class="mile_content">
                        <h6>15 Aug ’18</h6>
                        <p>Voting results</p>
                    </div>
                </li>

                <li>
                    <div class="icon icon4"></div>
                    <div class="mile_content">
                        <h6>Sep’18 – Oct’18</h6>
                        <p>Meetings with the leader</p>
                    </div>
                </li>
                <li>
                    <div class="icon icon5"></div>
                    <div class="mile_content">
                        <h6>Oct’18 – Jan’19</h6>
                        <p>Taking the agenda to the nation</p>
                    </div>
                </li>

                <li>
                    <div class="icon icon6"></div>
                    <div class="mile_content">
                        <h6>Jan’19 – Feb’19</h6>
                        <p>Adoption of agenda as part of official manifesto of the party</p>
                    </div>
                </li>
            </uL>
        </div>
    </div>
</div>
<!-- NEWS SECTION END -->


<?php include('footer.php'); ?>
</body>
<script type="text/javascript">

        var phone_val = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
        var whitespaces_val = /^\s+$/;   
        $( document ).ready(function() {
            /*$('.registerBtn').on('click touch', function(event) {
                $('.registerMobile').fadeToggle();
            });

            $(document).on('click touch', function(event) {
                if (!$(event.target).parents().addBack().is('.registerBtn, .registerMobile')) {
                    $('.registerMobile').fadeOut();
                }
            }); */
            $(".owl-carousel-trending").owlCarousel({
                nav:true,
                dots:true,
                items:4,
                margin:10,
                responsive:{
                    300:{
                        items:1
                    },
                    400:{
                        items:1
                    },
                    600:{
                        items:2
                    },
                    800:{
                        items:2
                    },
                    1100:{
                        items:4
                    }
                }
            });
			document.getElementById("sinfluencers").style.display="block";
			document.getElementById("sassociates").style.display="none";
			document.getElementById("sorganisations").style.display="none";
			
			
            
            // Initialize the carousels
            var owl = $('.owl-carousel');
            var owlPta = $('.owl-carousel-pta');

            owlPta.owlCarousel();
            var lastItemIndexTestimonial = 0;
            var lastItemIndexPta = 0;
            var testimonialTotalCount = 0;
            var ptaTotalCount = 0;
            var ptaArray = [];
            var ptaCarousel="";
            var firstPtaArray=[];
            var testimonialCarousel="";
            $.ajax({
                url: "<?php echo base_url(); ?>home/getTotalTestimonialCount",
                dataType: "JSON",
                type: "GET",
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    testimonialTotalCount = result.length;
                }
            });
            $.ajax({
                url: "<?php echo base_url(); ?>home/getPTA",
                dataType: "JSON",
                type: "GET",
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    ptaTotalCount = result.length;
                    ptaArray = result;

                    // get first 7 pta from ptaArray;
                    firstPtaArray = ptaArray.slice(0,7);
                    owlPta.trigger('destroy.owl.carousel');
                    owlPta.find('.owl-stage-outer').children().unwrap();
                    owlPta.removeClass("owl-center owl-loaded owl-text-select-on");
                    $.each(firstPtaArray, function( index, value ) {
                        ptaCarousel += "<div class=\"sli_part\"><div class=\"sli_part1\"><div class=\"sli_part1_icon\"><img src=\"https://www.ipactesting.com/hepta/assets/news/sli_side_logo.png\" class=\"sli_side_logo\"></div><div class=\"sli_part2\"><img src=\"https://res.cloudinary.com/indianpac/image/upload/naf/images/top_pta_performers/"+ value.image_id +"\"></div><div class=\"sli_part3\"><h3>" + value.name + "</h3><p>" + value.college_name + "</p></div></div></div>";
                        lastItemIndexPta = index + 1;
                    });
                    owlPta.html(ptaCarousel);
                    //reinitialize the carousel (call here your method in which you've set specific carousel properties)
                    owlPta.owlCarousel({
                        items: 5,
                        loop: true,
                        margin: 10,
                        responsive: {
                            0: {
                                loop: true,
                                items: 1,
                                nav: false,
                            },
                            600: {
                                loop: true,
                                items: 2,
                                nav: false,
                            },
                            1000: {
                                loop: true,
                                items: 3,
                                nav: false,
                            },
                            1100: {
                                loop: true,
                                items: 4,
                                nav: false,
                            }
                        }
                    });
                }
            });


            // make the API call get first 4 rows from DB
            $.ajax({
                url: "<?php echo base_url(); ?>home/getTestimonials",
                dataType: "JSON",
                type: "GET",
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    // add the new items
                    $.each(result, function( index, value ) {
                        testimonialCarousel += "<div class=\"sli_part\"><div class=\"sli_part1\"><div class=\"sli_part1_icon\"><img src=\"https://www.ipactesting.com/hepta/assets/news/sli_side_logo.png\" class=\"sli_side_logo\"></div><div class=\"sli_part2\"><div class=\"sli_part2_sub1\"><center><img src=\"https://www.ipactesting.com/hepta/assets/news/sli_quto.png\" class\"sli_quto\"  style=\"width:30px;\"></center><p>" + value.testimonial + "</p></div><img src=\"https://res.cloudinary.com/indianpac/image/upload/naf/images/testimonials/"+ value.author_image +"\"></div><div class=\"sli_part3\"><h3>" + value.author + "</h3><p>" + value.designation + "</p></div></div></div>"
                        lastItemIndexTestimonial = parseInt(value.id);
                    });
                    owl.html(testimonialCarousel);
                    //reinitialize the carousel (call here your method in which you've set specific carousel properties)
                    owl.owlCarousel({
                        dots: false,
                        loop: true,
                        items: 3,
                        margin: 10,
                        slideTransition:'linear',
                        responsive: {
                            0: {
                                items: 1,
                                nav: false,
                                loop: true,
                            },
                            600: {
                                items: 1,
                                nav: false,
                                loop: true,
                            },
                            1000: {
                                loop: true,
                                items: 4,
                                nav: false,
                                animateOut: 'fadeOut',
                                animateIn: 'fadeIn',
                            }
                        }
                    });

                }
            });

            // Go to the next item
            $('.customNextBtnTestimonial').click(function() {

                if(lastItemIndexTestimonial === testimonialTotalCount){
                    owl.trigger('next.owl.carousel', [300]);
                    return;
                }
                $.ajax({
                    url: "<?php echo base_url(); ?>home/next_testimonials",
                    data: {'item_count':lastItemIndexTestimonial},
                    dataType: "JSON",
                    type: "POST",
                    success: function(result) {
                        // console.log(result);
                        $.each(result, function( index, value ) {
                            testimonialCarousel = "<div class=\"sli_part\"><div class=\"sli_part1\"><div class=\"sli_part1_icon\"><img src=\"https://www.ipactesting.com/hepta/assets/news/sli_side_logo.png\" class=\"sli_side_logo\"></div><div class=\"sli_part2\"><div class=\"sli_part2_sub1\"><center><img src=\"https://www.ipactesting.com/hepta/assets/news/sli_quto.png\" class\"sli_quto\"  style=\"width:30px;\"></center><p>" + value.testimonial + "</p></div><img src=\"https://res.cloudinary.com/indianpac/image/upload/naf/images/testimonials/"+ value.author_image +"\"></div><div class=\"sli_part3\"><h3>" + value.author + "</h3><p>" + value.designation + "</p></div></div></div>";
                            owl.trigger('add.owl.carousel',[testimonialCarousel]).trigger('refresh.owl.carousel');
                            lastItemIndexTestimonial = parseInt(value.id);
                        });

                        owl.trigger('next.owl.carousel', [300]);
                    }
                });

            });
            // Go to the next item
            var nextPtaIndexForSlice = 0;
            $('.customNextBtnPta').click(function() {
                if(lastItemIndexPta === ptaTotalCount){
                    return;
                }
                // I have last index
                $.each(ptaArray, function(index, value){
                    if(index === lastItemIndexPta){
                        nextPtaIndexForSlice = index;
                    }
                });

                var nextPtaArray = ptaArray.slice(nextPtaIndexForSlice, nextPtaIndexForSlice + 1);

                $.each(nextPtaArray, function( index, value ) {
                    ptaCarousel = "<div class=\"sli_part\"><div class=\"sli_part1\"><div class=\"sli_part1_icon\"><img src=\"https://www.ipactesting.com/hepta/assets/news/sli_side_logo.png\" class=\"sli_side_logo\"></div><div class=\"sli_part2\"><img src=\"https://res.cloudinary.com/indianpac/image/upload/naf/images/top_pta_performers/"+ value.image_id +"\"></div><div class=\"sli_part3\"><h3>" + value.name + "</h3><p>" + value.college_name + "</p></div></div></div>";
                    owlPta.trigger('add.owl.carousel',[ptaCarousel]).trigger('refresh.owl.carousel');
                    lastItemIndexPta++;
                });
                owlPta.trigger('next.owl.carousel', [300]);
            });
            // Go to the previous item
            $('.customPrevBtnTestimonial').click(function() {
                // With optional speed parameter
                // Parameters has to be in square bracket '[]'
                if(testimonialTotalCount === lastItemIndexTestimonial){
                    owl.trigger('prev.owl.carousel', [300]);
                    return;
                }else{
                    $.ajax({
                        url: "<?php echo base_url(); ?>home/next_testimonials",
                        data: {'item_count':lastItemIndexTestimonial},
                        dataType: "JSON",
                        type: "POST",
                        success: function(result) {
                            console.log(result);
                            $.each(result, function( index, value ) {
                                testimonialCarousel = "<div class=\"sli_part\"><div class=\"sli_part1\"><div class=\"sli_part1_icon\"><img src=\"https://www.ipactesting.com/hepta/assets/news/sli_side_logo.png\" class=\"sli_side_logo\"></div><div class=\"sli_part2\"><div class=\"sli_part2_sub1\"><center><img src=\"https://www.ipactesting.com/hepta/assets/news/sli_quto.png\" class\"sli_quto\"  style=\"width:30px;\"></center><p>" + value.testimonial + "</p></div><img src=\"https://res.cloudinary.com/indianpac/image/upload/naf/images/testimonials/"+ value.author_image +"\"></div><div class=\"sli_part3\"><h3>" + value.author + "</h3><p>" + value.designation + "</p></div></div></div>";
                                owl.trigger('add.owl.carousel',[testimonialCarousel]).trigger('refresh.owl.carousel');
                                lastItemIndexTestimonial = parseInt(value.id);
                            });
                            owl.trigger('prev.owl.carousel', [300]);

                        }
                    });
                }


            });

            // Go to the previous item
            $('.customPrevBtnPta').click(function() {
                // With optional speed parameter
                // Parameters has to be in square bracket '[]'
                if(ptaTotalCount === lastItemIndexPta){
                    return;
                }
                // I have last index
                $.each(ptaArray, function(index, value){
                    if(index === lastItemIndexPta){
                        nextPtaIndexForSlice = index;
                    }
                });

                var nextPtaArray = ptaArray.slice(nextPtaIndexForSlice, nextPtaIndexForSlice + 1);

                $.each(nextPtaArray, function( index, value ) {
                    ptaCarousel = "<div class=\"sli_part\"><div class=\"sli_part1\"><div class=\"sli_part1_icon\"><img src=\"https://www.ipactesting.com/hepta/assets/news/sli_side_logo.png\" class=\"sli_side_logo\"></div><div class=\"sli_part2\"><img src=\"https://res.cloudinary.com/indianpac/image/upload/naf/images/top_pta_performers/"+ value.image_id +"\"></div><div class=\"sli_part3\"><h3>" + value.name + "</h3><p>" + value.college_name + "</p></div></div></div>";
                    owlPta.trigger('add.owl.carousel',[ptaCarousel]).trigger('refresh.owl.carousel');
                    lastItemIndexPta++;
                });
                owlPta.trigger('prev.owl.carousel', [300]);
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
		
		function showInfluencers(){
            document.getElementById("sinfluencers").style.display="block";
            document.getElementById("sassociates").style.display="none";
			document.getElementById("sorganisations").style.display="none";
        }

        function showAssociates(){
            document.getElementById("sinfluencers").style.display="none";
            document.getElementById("sassociates").style.display="block";
			document.getElementById("sorganisations").style.display="none";
        }
		
		function showAssociates(){
			document.getElementById("sorganisations").style.display="block";
            document.getElementById("sinfluencers").style.display="none";
            document.getElementById("sassociates").style.display="none";
        }
        
        function validateblanktext(stringtext) {
            if(stringtext == "" || whitespaces_val.test(stringtext) || stringtext == 0) {
                return false;
            } else {
                return true;
            }
        }
		//Counter code
		var a = 0;
        $(window).scroll(function() {

            var oTop = $('#digi_counter').offset().top - window.innerHeight;
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
                                x=this.countNum.toString();
                                var lastThree = x.substring(x.length-3);
                                var otherNumbers = x.substring(0,x.length-3);
                                if(otherNumbers != '')
                                    lastThree = ',' + lastThree;
                                var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
                                $this.text(res);
                                //alert('finished');
                            }

                        });
                });
                a = 1;
            }

        });
    </script>
<script>
// var district_location = "https://www.google.com/maps/d/u/0/embed?mid=13Te4IycHq_zfZX8z4qpo5UZ2T0qzyfsA&z=5&ll=22.9734, 78.6569";
// (function(){
//         document.getElementById('maps_iframe').src = district_location;
//     })();
// function showMap(loc, id) {
//   document.getElementById("maps_iframe").src=loc;
// }
</script>
<script>
	$(function() {
		$('.map_active_class').click(function(){
			$('.map_active_class').removeClass('map_active');
			$(this).addClass('map_active');
		});
	});
</script>


<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.js"></script>-->
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

<!-- NEWS SLIDER SCRIPT START  -->
<script src="<?php echo base_url()?>assets/js/swiper.min.js"></script>
<script type="text/javascript">

    var slideIndex = 1;
    var swiper;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active_div", "");
            if(slides[i].className == 'mySlides active_block'){
                slides[i].className = slides[i].className.replace(" active_block", "");
            }

            if(slides[i-1] != undefined){
                if(slides[i-1].className == 'mySlides previous_block'){
                    slides[i-1].className = slides[i-1].className.replace(" previous_block", "");
                }
            }

            if(slides[i+1] != undefined){
                if(slides[i+1].className == 'mySlides next_block'){
                    slides[i+1].className = slides[i+1].className.replace(" next_block", "");
                }
            }
        }

        if(slideIndex != 1){
            if(slides[slideIndex - 2] != undefined){
                slides[slideIndex - 2].style.display = "block";
                slides[slideIndex - 2].className = "mySlides previous_block";
            }
        }

        if(slideIndex != 1) {
            slides[slideIndex - 1].style.display = "block";
            slides[slideIndex - 1].className = "mySlides active_block";
        }else{
            slides[slideIndex - 1].style.display = "block";
            slides[slideIndex - 1].className = "mySlides active_block";
        }

        if(slideIndex < slides.length){
            if (slides[slideIndex] != undefined) {
                slides[slideIndex].style.display = "block";
                slides[slideIndex].className = "mySlides next_block";
            }
        }

        dots[slideIndex - 1].className += " active_div";
    }

    setInterval(function(){
        slideIndex = slideIndex + 1;
        currentSlide(slideIndex );
        var slides = document.getElementsByClassName("mySlides");
        if(slideIndex == slides.length){
            swiper.slideTo(0, 1, true);
        }else{
            if(slideIndex > 4){
                document.getElementById('slideNextBtn').click();
            }
        }
    }, 10000);

    swiper = new Swiper('.swiper-container', {
        loop: false,
        slidesPerView: 7,
        spaceBetween: 60,
        slidesOffsetAfter: 40,
        slidesOffsetBefore: 10,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            1700: {
                slidesPerView: 4,
                spaceBetween: 40
            },
            1080: {
                slidesPerView: 7,
                spaceBetween: 40
            },

            768: {
                slidesPerView: 5,
                spaceBetween: 30
            },
            640: {
                slidesPerView: 3,
                spaceBetween: 30,
                slidesOffsetAfter: 30,
                slidesOffsetBefore: 30,
            },

            480: {
                slidesPerView: 3,
                spaceBetween: 30,
                slidesOffsetAfter: 20,
                slidesOffsetBefore: 20,
            }
        }
    });
</script>
<!-- NEWS SLIDER SCRIPT END  -->
</html>
