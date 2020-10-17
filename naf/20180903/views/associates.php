<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head_element.php'); ?>
    <title>NAF | Associates</title>
    <meta name="description" content=""/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
    <!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
    <style type="text/css">
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
        .pagination li {
            padding: 5px 4px;
        }
    </style>
</head>
<body class="home home-wrapper">
<?php include('header_home.php'); ?>
<div class="row" style="margin-top: 10px;width:88%;margin-right: auto; margin-left: auto;padding-left: 15px;padding-right: 15px;">
    <div class="col-md-12 well" style="padding: 10px;">
        <?php
        $attr = array("class" => "form-inline", "role" => "form", "id" => "form1", "name" => "form1");
        echo form_open("home/search_associates", $attr);?>
        <div class="form-group" style="margin-bottom: 0px;width:100%">
            <input class="form-control" style="width:100%" id="search_string" name="search_string" placeholder="SEARCH BY ASSOCIATE NAME, COLLEGE NAME..." type="text" value="<?php echo set_value('search_string'); ?>" required/>
        </div>
        <div class="form-group" style="margin-bottom: 0px;">
            <input style="height: 34px;margin-bottom: 10px;" type="submit" name="btn_search" class="btn btn-success" value="Search" />
            <a href="<?php echo base_url().'home/associates'; ?>" style="height: 34px;margin-bottom: 10px;" class="btn btn-default">Clear Filter</a>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12  table-responsive">
            <table style="border-collapse: collapse;" class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th class="text-left">Associate Name</th>
                    <th class="text-left">College Name</th>
                    <th class="text-left" style="white-space: nowrap">College State</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (count($Associates_pta_randomiser) > 0) {
                    $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                    foreach ($Associates_pta_randomiser as $index => $associate) {
                        ?>
                        <tr>
                            <td class="text-left"><?php echo ucwords(strtolower($associate->user_name)); ?></td>
                            <td class="text-left"><?php echo ucwords($associate->collage_name); ?></td>
                            <td class="text-left" style="white-space: nowrap"><?php echo $associate->name; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
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
    $(function () {
        lazyload();
    });
</script>
</html>
