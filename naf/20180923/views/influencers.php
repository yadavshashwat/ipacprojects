<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head_element.php'); ?>
    <title>NAF | Influencers</title>
    <meta name="description" content=""/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">

    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
<style type="text/css">
    .sli_part2 .testimonial_img, .sli_part2 .partner_img {position: absolute;top: 0;width: 150px;right: 0;}
    .sli4 {
        float: left;
        width: 100%;
        margin: 30px 0px 0px 0px;
        text-align: center;
    }
    .sli4 a {
        cursor: pointer;
        background-color: transparent;
        border: 2px solid #3c3c3c;
        color: #3c3c3c;
        padding: 5px 25px;
        font-family: 'Open Sans', sans-serif;
    }

    @media only screen and (max-width: 768px) {
        .influencers-box{ margin-left: 30%; }
    }
    @media only screen and (max-width: 480px) {
        .influencers-box{ margin-left: 12%; }
    }

    @media only screen and (max-width: 380px) {
        .influencers-box{ margin-left: 5%; }
    }
</style>
</head>
<body class="home home-wrapper">
<?php include('header_home.php'); ?>
<div class="container influencers_container">
    <div class="row">
        <?php
        if(count($Influencers_testimonial) > 0){
            foreach ($Influencers_testimonial as $influencer) {
                ?>
                <div class="influencers-box col-md-4 col-lg-3 col-xs-12 col-sm-6">
                    <div class="sli_part">
                        <div class="sli_part1">
                            <div class="sli_part1_icon"><img
                                        src="<?php echo base_url(); ?>assets/news/sli_side_logo.png"
                                        class="sli_side_logo lazyload"></div>
                            <div class="sli_part2">
                                <div class="sli_part2_sub1">
                                    <?php  if($influencer->testimonial != 'NA'){ ?>
                                    <center><img src="<?php echo base_url(); ?>assets/news/sli_quto.png"
                                                 class="sli_quto lazyload" style="width:30px;"></center>
                                    <p><?php
                                        echo $influencer->testimonial;
                                        ?>
                                    </p>
                                    <?php } ?>
                                </div>
                                <img src="https://www.indianpac.com/naf/assets/images/Influencers%20Internal/<?php echo $influencer->author_image; ?>"
                                     class="testimonial_img lazyload"></div>
                            <div class="sli_part3"><h3><?php echo $influencer->author; ?></h3>
                                <p><?php echo $influencer->designation; ?></p></div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
    <div class="sli4">
        <a href="<?php echo base_url() ?>">BACK</a>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
<script type="text/javascript">

    var phone_val = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
    var whitespaces_val = /^\s+$/;

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
                    window.location.href = "<?php echo base_url(); ?>" + result.msg;
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
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<!-- jsDeliver -->
<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-beta.2/lazyload.js"></script>
<script type="text/javascript">
    $(function() {
        lazyload();
    });
</script>
</html>
