<!DOCTYPE html>

<html lang="en">

<head>

    <?php include('head_element.php'); ?>

    <title>NAF</title>

    <meta name="description" content=""/>

    <style type="text/css">


    </style>

</head>

<body class="ipac_edit_body">


<div class="backImg"></div>

<div class="wrapper">

    <?php include('header.php'); ?>

    <div class="homeMain resultMain">

        <div class="testimonial-section">
            <!-- Testimonials heading -->
            <div class="testimonial-heading-flex">
                <h2>Voting Results</h2>
                <!--<h4>There is no one who loves pain itself, who seeks after it and wants to have it</h4>-->
                <div class="green-border-down"></div>
            </div>
        </div>

        <style scoped>
            .congos_section{
                text-align: center;
            }
            .pta_compliment{
                text-align: center;
            }
            .new_design_block {
                background: #333333;
                color: white;
                text-align: center;
                width: 90%;
                margin: 7% 5%;
                padding: 2% 7% 2% 7%;
                border-radius: 3px;
            }

            .new_design_block_info{
                margin-top:0;
            }
            @media (max-width:768px){
                .new_design_block{
                    background: #333333;
                    color: white;
                    text-align: center;
                    width: 90%;
                    margin: 7% 5%;
                    padding: 0% 7% 10% 7%;
                }
            }
        </style>

        <h2 class="congos_section">Congratulations!</h2>
        <p class="pta_compliment">You have been successfully registered as Part Time Associate</p>

<!--        <div class="resultIn nomiCert">-->
<!---->
<!--            <div class="headCert">-->
<!---->
<!--                <div class="topInfo">-->
<!---->
<!--                    <p>Congratulations! You have been successfully registered as Part Time Associate</p>-->
<!---->
<!--                </div>-->

                <!-- <div class="btnCert shrBtn">

                                Share

                                <?php

                $url = base_url();

                ?>

                                <div class="shareDiv">

                                    <svg class="fbImg" viewBox="0 0 8379 8379"><g id="Layer_x0020_1"><rect class="fil0" height="8379" width="8379"/><path class="fil1" d="M5111 3490l-627 0 0 -412c0,-154 102,-190 174,-190 72,0 443,0 443,0l0 -680 -610 -3c-677,0 -832,507 -832,832l0 453 -392 0 0 701 392 0c0,899 0,1983 0,1983l825 0c0,0 0,-1095 0,-1983l556 0 71 -701z"/></g></svg><a href="https://twitter.com/share?text=Join National Agenda Forum. Imagine all the forty crore of people busying themselves with the whole of the Constructive Programme which is designed to build up the nation from the very bottom upward. - Mahatma Gandhi. Gandhiji, in his 18-point Constructive Programme, had outlined the blueprint for independent India. In his 150th Birth Anniversary year, let us come together to pay tribute to his legacy and unite the nation to formulate an actionable agenda for India.&p[summary]=""&url=<?php echo $url; ?>&via=National Agenda Forum&hashtags=NationalAgendaForum" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=250'); return false"><svg class="twitImg" viewBox="0 0 9291 9291"><g id="Layer_x0020_1"><rect class="fil0" height="9291" width="9291"/><path class="fil1" d="M6852 3277c-162,72 -336,120 -520,142 188,-112 331,-289 399,-501 -178,106 -373,180 -576,220 -165,-176 -400,-286 -660,-286 -500,0 -906,405 -906,906 0,70 8,140 24,206 -753,-38 -1420,-398 -1867,-946 -78,134 -122,289 -122,455 0,314 160,592 403,754 -144,-5 -285,-43 -411,-113l0 11c0,439 312,805 727,888 -77,21 -156,32 -239,32 -58,0 -115,-6 -170,-16 115,359 449,621 846,628 -311,243 -701,388 -1125,388 -73,0 -145,-4 -216,-13 401,257 877,407 1388,407 1665,0 2576,-1380 2576,-2576 0,-39 -1,-78 -3,-117 178,-128 331,-287 452,-469z"/></g></svg></a><a onclick="share_on_whatsapp('<?php echo $url; ?>', 'Join National Agenda Forum')" href="javascript:;"><svg class="whatsImg" viewBox="0 0 8379 8379"><g id="Layer_x0020_1"><rect class="fil0" height="8379" width="8379"/><g id="_899307880"><path class="fil1" d="M6460 4075c-30,-1197 -1016,-2158 -2229,-2158 -1199,0 -2176,939 -2229,2117 -1,32 -2,65 -2,97 0,419 117,809 320,1143l-402 1188 1235 -393c320,175 687,276 1078,276 1232,0 2230,-991 2230,-2214 0,-19 0,-38 -1,-56zm-2229 1917l0 0c-381,0 -735,-113 -1032,-308l-720 229 233 -691c-224,-307 -357,-684 -357,-1091 0,-61 3,-121 10,-181 92,-942 894,-1680 1866,-1680 984,0 1794,757 1869,1716 4,48 6,96 6,145 0,1026 -842,1861 -1875,1861z"/><path class="fil1" d="M5253 4578c-55,-27 -324,-159 -374,-177 -50,-18 -87,-27 -123,28 -37,54 -142,176 -173,211 -33,37 -64,41 -119,14 -55,-27 -231,-83 -440,-269 -162,-143 -273,-321 -304,-375 -31,-54 -3,-84 24,-111 25,-25 54,-64 83,-95 7,-9 13,-18 19,-26 13,-20 22,-39 35,-65 19,-36 9,-68 -4,-95 -14,-27 -123,-294 -169,-403 -45,-108 -91,-90 -124,-90 -31,0 -68,-5 -104,-5 -37,0 -96,14 -146,68 -50,54 -191,186 -191,453 0,63 11,125 28,185 55,191 174,349 195,376 27,35 378,601 934,820 556,216 556,144 656,134 101,-8 324,-130 369,-258 46,-126 46,-235 32,-258 -13,-21 -50,-35 -104,-62z"/></g></g></svg></a>

                                </div> 

                            </div> -->

                <!-- <a href="<?php echo base_url() ?>result/download_result/<?php echo base64_encode($user_detail['id']) ?>"><div class="btnCert dwldBtn">Download</div></a> -->

<!--            </div>-->

            <!--  <div class="certFirst">

                            <table style="margin: auto; width: 100%; max-width: 600px; border: solid 1px #333; padding: 20px; font-family: 'Roboto', sans-serif;">

                                <tr>

                                    <td>

                                        <img src="<?php echo base_url() ?>assets/images/ipacLogo.png" style="height: 100px; display: block; width: auto; margin: auto; margin-bottom: 20px;">

                                    </td>

                                </tr>

                                <tr>

                                    <td style="line-height: 26px;">

                                        <p style="margin-bottom: 20px;">Hi <?php echo $user_detail['user_name'] ?>,</p>

                                        <p style="margin-bottom: 10px;">Thanks for registering as a NAF Fellow. NAF Fellows will be the agents to become the voice of the masses, engage the masses to choose leader &amp; set the agenda for the Government.</p>

                                        <p style="margin-bottom: 10px;">Your unique registration ID is: <b><?php echo $user_detail['registration_number'] ?></b></p>

                                        <p style="margin-bottom: 10px;">Please keep checking the NAF website and I-PAC Facebook page for regular NAF updates.</p>

                                        <p style="margin-bottom: 10px;">NAF Website: https://www.indianpac.com/naf</p>

                                        <p style="margin-bottom: 10px;">I-PAC Facebook Page: https://www.facebook.com/IndianPAC</p>

                                        <p>Thanks, <br>I-PAC</p>

                                    </td>

                                </tr>

                            </table>                        

                        </div> -->

<!--        </div>-->
        <div class="resultIn nomiCert new_design_block">

            <div class="topInfo resultInfo new_design_block_info">

                <p>Use this <em>Unique Voting Link</em> to invite your friends to become a part of NAF</p>

            </div>

            <div class="partAssociate">

                <div class="copyCode">

                    <input type="text" id="myInput"
                           value="<?php echo base_url() ?>referral/<?php echo $user_detail['registration_number'] ?>"><div class="btn transition shrBtnResult">Share</div>
                    <div class="shareDivResult">
                        <div class="shareDivIn fbBtn">
                            <svg class="fbImg2" viewBox="0 0 8379 8379">
                                <g id="Layer_x0020_1">
                                    <rect class="fil0" height="8379" width="8379"/>
                                    <path class="fil1"
                                          d="M5111 3490l-627 0 0 -412c0,-154 102,-190 174,-190 72,0 443,0 443,0l0 -680 -610 -3c-677,0 -832,507 -832,832l0 453 -392 0 0 701 392 0c0,899 0,1983 0,1983l825 0c0,0 0,-1095 0,-1983l556 0 71 -701z"/>
                                </g>
                            </svg>
                        </div>
                        <div class="shareDivIn twitBtn">
                            <a href="https://twitter.com/share?text=Vote on the National Agenda Forum <?php echo base_url() ?>referral/<?php echo $user_detail['registration_number'] ?> to revisit Gandhiji's Constructive Programme, set the agenda &amp; choose the right leader for India. Join %23NationalAgendaForum&p[summary]=""&url=<?php echo $url; ?>
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
                            </a>
                        </div>
                        <div class="shareDivIn whatsBtn">
                            <a href="whatsapp://send?text=Vote on the National Agenda Forum <?php echo base_url() ?>referral/<?php echo $user_detail['registration_number'] ?> to revisit Gandhiji's Constructive Programme, set the agenda &amp; choose the right leader for India."
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
                            </a>
                        </div>
                    </div>

                </div>

                <p class="voteScore">You have <?php echo $my_assoc_count ?> votes on your link</p>

            </div>

        </div>

        <style scoped>
            .result_table_flex{
                display: flex;
                flex-direction: row;
                justify-content: space-between;
            }
            .result_table {
                width:48%;
            }
            .result_topic{
                position: absolute;
                text-align: left;
                left: 3px;
                top: 46px;
                font-size: 13px;
            }
            .result_table_heading {
                position: relative;
                display: flex;
                flex-direction: row;
                align-items: center;
                background: #333333;
                border: 1px solid #333333;
                color: white;
                padding: 10px;
            }

            .result_table_name {
                flex: 0 0 90%;
            }

            .result_table_icon {
                flex: 0 0 10%;
            }

            .result_table_subheading {
                position: relative;
                display: flex;
                flex-direction: row;
                align-items: center;
                background: #9D9D9D;
                border: 1px solid #9D9D9D;
                color: white;
                height: 40px;
                line-height: 30px;
            }

            .result_table_subname {
                flex: 0 0 75.1%;
                border-right: 1px solid #8A8A8A;
                padding-left: 10px;
                height: 100%;
            }

            .result_table_votes {
                flex: 0 0 24.9%;
                padding-left: 25px;
            }

            .result_table_data {
                position: relative;
                display: flex;
                flex-direction: column;
            }

            .result_data_wrap{
                position: relative;
                display:flex;
                flex-direction:row;
            }

            .result_data_progress {
                flex: 0 0 37.5%;
                height: 100px;
                padding-top: 20px;
                border-bottom: 1px solid #8A8A8A;
                border-right: 1px solid #8A8A8A;
            }

            .result_data_progress_constant {
                flex: 0 0 37.5%;
                height: 100px;
                padding-top: 20px;
                border-left: 1px solid #8A8A8A;
                border-bottom: 1px solid #8A8A8A;
            }

            .result_data_percentage {
                flex: 0 0 25%;
                height: 100px;
                border-bottom: 1px solid #8A8A8A;
                border-right: 1px solid #8A8A8A;
                padding: 30px 0 0 25px;
                font-size: 20px;
                font-style: italic;
                font-weight: bold;
            }

            .serial_data{
                position: relative;
                top: -35px;
                left: 14px;
                color: white;
            }

            .serial_img{
                position: relative;
                top: -12px;
                height: 60px;
                width: 60px;
                border-radius: 50%;
                left: 30px;
                padding: 3px;
                background: white;
            }

            .serial_img_agenda{
                position: relative;
                top: -12px;
                height: 60px;
                width: 60px;
                border-radius: 50%;
                left: 30px;
                padding: 10px;
                background: white;
            }

            .charts {
                width: 100%;
                z-index: 10;
                padding: 0 0 0 0px;
            }
            .charts_constant{
                padding: 0 0 0 10px;
            }

            .chart {
                margin: 30px 0 0;
            }
            .chart:first-child {
                margin: 0;
            }

            .chart--horiz {
                width:100%;
            }

            .chart__bar {
                height: 40px;
                border-top-right-radius: 10px;
                border-bottom-right-radius: 10px;
                opacity: 0;
                animation: 1s anim-lightspeed-in ease forwards;
            }
            .chart__bar_constant {
                height: 40px;
                border-top-left-radius: 20px;
                border-bottom-left-radius: 20px;
                opacity: 0;
                animation: 1s anim-lightspeed-in ease forwards;
            }
            .chart__bar_constant_leader{
                height: 40px;
                border-top-left-radius: 20px;
                border-bottom-left-radius: 20px;
                opacity: 0;
                animation: 1s anim-lightspeed-in ease forwards;
                background: #09941E;
            }
            .chart__bar_leader_percentage{
                height: 40px;
                border-top-right-radius: 10px;
                border-bottom-right-radius: 10px;
                opacity: 0;
                animation: 1s anim-lightspeed-in ease forwards;
                background: linear-gradient(to left, #49C327, #09941E);
            }
            .chart--dev .chart__bar:nth-of-type(11) {
                animation-delay: 2.7s;
            }
            .chart--dev .chart__bar:nth-of-type(10) {
                animation-delay: 2.5s;
            }
            .chart--dev .chart__bar:nth-of-type(9) {
                animation-delay: 2.3s;
            }
            .chart--dev .chart__bar:nth-of-type(8) {
                animation-delay: 2.1s;
            }
            .chart--dev .chart__bar:nth-of-type(7) {
                animation-delay: 1.9s;
            }
            .chart--dev .chart__bar:nth-of-type(6) {
                animation-delay: 1.7s;
            }
            .chart--dev .chart__bar:nth-of-type(5) {
                animation-delay: 1.5s;
            }
            .chart--dev .chart__bar:nth-of-type(4) {
                animation-delay: 1.3s;
            }
            .chart--dev .chart__bar:nth-of-type(3) {
                animation-delay: 1.1s;
            }
            .chart--dev .chart__bar:nth-of-type(2) {
                animation-delay: 0.9s;
            }
            .chart--dev .chart__bar:nth-of-type(1) {
                animation-delay: 0.7s;
            }
            .chart--prod .chart__bar:nth-of-type(2) {
                animation-delay: 4.2s;
            }
            .chart--prod .chart__bar:nth-of-type(1) {
                animation-delay: 4s;
            }
            .chart--design .chart__bar:nth-of-type(3) {
                animation-delay: 5.6s;
            }
            .chart--design .chart__bar:nth-of-type(2) {
                animation-delay: 5.4s;
            }
            .chart--design .chart__bar:nth-of-type(1) {
                animation-delay: 5.2s;
            }
            @keyframes anim-lightspeed-in {
                0% {
                    transform: translateX(-200%);
                    opacity: 1;
                }
                100% {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @media (max-width:768px){
                .result_topic{
                    position: absolute;
                    text-align: left;
                    left: 3px;
                    top: 46px;
                    font-size: 10px;
                }
                .result_table_flex {
                    display: flex;
                    flex-direction: column;
                }
                .result_table {
                    width:100%;
                    margin-bottom: 20px;
                }
                .result_table_subname {
                    font-size: 12px;
                }

                .result_table_votes {
                    font-size: 12px;
                }
            }
        </style>
        <div class="result_table_flex">
            <div class="result_table">
                <div class="result_table_heading">
                    <div class="result_table_name">
                        AGENDA RESULT
                    </div>
                    <div class="result_table_icon">

                    </div>
                </div>
                <div class="result_table_subheading">
                    <div class="result_table_subname">
                        NAME<sup>*</sup>
                    </div>
                    <div class="result_table_votes">
                        VOTES (%)
                    </div>
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
                                        <div class="chart__bar_constant <?php echo 'agendacls' . $value['id']; ?>" style="width:<?php echo 100; ?>%;">
                                            <span class="serial_data"><?php echo $i; ?>.</span>
                                            <img class="serial_img_agenda" src="<?php echo base_url() ?>assets/images/icons/icon-agenda<?php echo $value['id']; ?>.png">
                                            <span class="result_topic"><?php echo $value['agenda_topic'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="result_data_progress">
                                <div class="charts">
                                    <div class="chart chart--dev">
                                        <div class="chart--horiz">
                                            <div class="chart__bar <?php echo 'agendacls' . $value['id']; ?>" style="width:<?php echo $total_per * 3; ?>%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="result_data_percentage">
                            <?php echo $total_per ?>%
                        </div>
                    </div>
                        <?php $i++;
                    } ?>
                </div>
            </div>
            <div class="result_table">
                <div class="result_table_heading">
                    <div class="result_table_name">
                        VOTE RESULT
                    </div>
                    <div class="result_table_icon">

                    </div>
                </div>
                <div class="result_table_subheading">
                    <div class="result_table_subname">
                        RANK AND NAME<sup>*</sup>
                    </div>
                    <div class="result_table_votes">
                        VOTES (%)
                    </div>
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
                                            <div class="chart__bar_constant_leader" style="width:<?php echo 100; ?>%;">
                                                <span class="serial_data"><?php echo $i; ?>.</span>
                                                <img class="serial_img" src="<?php echo base_url() ?>assets/images/Leader_Photos/<?php echo $value['id']; ?>.jpg">
                                                <span class="result_topic"><?php echo $value['full_name'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="result_data_progress">
                                <div class="charts">
                                    <div class="chart chart--dev">
                                        <div class="chart--horiz">
                                            <div class="chart__bar_leader_percentage" style="width:<?php echo $total_per*2.5; ?>%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="result_data_percentage">
                                <?php echo $total_per ?>%
                            </div>
                        </div>
                        <?php $i++;
                    } ?>
                </div>
            </div>
        </div>

<!--        <div class="resultIn nomiResults">-->
<!---->
<!--            <h4>Agenda Result</h4>-->
<!---->
<!--            <div class="resultDiv">-->
<!---->
<!--                <table>-->
<!---->
<!--                    <thead>-->
<!---->
<!--                    <tr>-->
<!---->
<!--                        <th width="90">Rank</th>-->
<!---->
<!--                        <th>Agenda</th>-->
<!---->
<!--                        <th width="120">Votes (%)</th>-->
<!---->
<!--                    </tr>-->
<!---->
<!--                    </thead>-->
<!---->
<!--                    <tbody>-->
<!---->
<!--                    --><?php
//
//
//                    $i = 1;
//
//                    foreach ($top_agendas as $key => $value) {
//
//                        $style = "";
//
//                        if ($i % 2 == 0) {
//
//                            $style = "";
//
//                        } else if ($i % 3 == 0) {
//
//                            $style = "background-color: #CDEEF7";
//
//                        } else if ($i % 3 == 1) {
//
//                            $style = "background-color: #FDEED7";
//
//                        } else if ($i % 3 == 2) {
//
//                            $style = "background-color: #DAECDC";
//
//                        }
//
//
//                        $total_per = 0;
//
//
//                        if ($value['total_vote'] == 0) {
//
//                            $total_per = 0;
//
//                        } else {
//
//                            $total_per = round(($value['total_vote'] / $total_agenda_vote) * 100, 1);
//
//                        }
//
//
//                        ?>
<!---->
<!--                        <tr>-->
<!---->
<!--                            <td style="--><?php //echo $style; ?><!--">--><?php //echo $i; ?><!--.</td>-->
<!--                            <td class="--><?php //echo 'agendacls' . $value['id']; ?><!--"><img-->
<!--                                        src="--><?php //echo base_url() ?><!--assets/images/icons/icon-agenda--><?php //echo $value['id']; ?><!--.png"></img>-->
<!--                            </td>-->
<!---->
<!---->
<!--                            <td class="agendaName"-->
<!--                                style="--><?php //echo $style; ?><!--">--><?php //echo $value['agenda_name'] ?><!--</td>-->
<!---->
<!--                            <td style="--><?php //echo $style; ?><!--">--><?php //echo $total_per ?><!--%</td>-->
<!---->
<!--                        </tr>-->
<!---->
<!--                        --><?php //$i++;
//                    } ?>
<!---->
<!--                    </tbody>-->
<!---->
<!--                </table>-->
<!---->
<!--            </div>-->
<!---->
<!--             <p class="noteResult">--><?php //echo $total_agenda_voted_count; ?><!-- people have already set agenda.</p> -->
<!---->
<!--        </div>-->
<!--        <div class="resultIn nomiResults">-->
<!---->
<!--            <h4>Leader Result</h4>-->
<!---->
<!--            <div class="resultDiv">-->
<!---->
<!--                <table>-->
<!---->
<!--                    <thead>-->
<!---->
<!--                    <tr>-->
<!---->
<!--                        <th width="90">Rank</th>-->
<!---->
<!--                        <th>Leader</th>-->
<!---->
<!--                        <th width="120">Votes (%)</th>-->
<!---->
<!--                    </tr>-->
<!---->
<!--                    </thead>-->
<!---->
<!--                    <tbody>-->
<!---->
<!--                    --><?php
//
//                    $i = 1;
//
//                    foreach ($top_leaders as $key => $value) {
//
//                        $style = "";
//
//                        if ($i % 2 == 0) {
//
//                            $style = "";
//
//                        } else if ($i % 3 == 0) {
//
//                            $style = "background-color: #CDEEF7";
//
//                        } else if ($i % 3 == 1) {
//
//                            $style = "background-color: #FDEED7";
//
//                        } else if ($i % 3 == 2) {
//
//                            $style = "background-color: #DAECDC";
//
//                        }
//
//
//                        $total_per = 0;
//
//                        if ($value['total_vote'] == 0) {
//
//                            $total_per = 0;
//
//                        } else {
//
//                            $total_per = round(($value['total_vote'] / $total_votes) * 100, 1);
//
//                        }
//
//                        ?>
<!---->
<!--                        <tr>-->
<!---->
<!--                            <td style="--><?php //echo $style; ?><!--">--><?php //echo $i; ?><!--.</td>-->
<!---->
<!--                            <td>-->
<!--                                <img src="--><?php //echo base_url() ?><!--assets/images/Leader_Photos/--><?php //echo $value['id']; ?><!--.jpg"></img>-->
<!--                            </td>-->
<!---->
<!--                            <td class="agendaName" style="--><?php //echo $style; ?><!--">--><?php //echo $value['full_name'] ?><!--</td>-->
<!---->
<!--                            <td style="--><?php //echo $style; ?><!--">--><?php //echo $total_per ?><!--%</td>-->
<!---->
<!--                        </tr>-->
<!---->
<!--                        --><?php //$i++;
//                    } ?>
<!---->
<!--                    </tbody>-->
<!---->
<!--                </table>-->
<!---->
<!--            </div>-->
<!---->
<!--            <p class="noteResult">*Only leaders with 10000+ votes have been shown in the results.--><?php //echo $total_leader_voted_count; ?><!-- people have already choose leader.</p>-->
<!---->
<!--        </div>-->
<!---->
<!---->
<!--    </div>-->

    <?php include('footer.php'); ?>


    <script type="text/javascript">

        function share_on_whatsapp(currenturl, metadescription) {

            window.location.href = "whatsapp://send?text=" + encodeURIComponent("\n\n" + metadescription) + " " + currenturl;

        }

    </script>

</div>

</body>

<!--    <script type="text/javascript">-->
<!---->
<!--        function copyToClipBoard() {-->
<!---->
<!--          var copyText = document.getElementById("myInput");-->
<!---->
<!--          copyText.select();-->
<!---->
<!--          //alert(copyText);-->
<!---->
<!--          document.execCommand("copy");-->
<!---->
<!--           copyText.value-->
<!---->
<!--        }-->
<!---->
<!--    </script>-->

</html>
