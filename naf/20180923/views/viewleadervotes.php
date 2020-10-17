<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head_element.php'); ?>
    <title>NAF | Leader Votes</title>
    <meta name="description" content=""/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
</head>
<body class="home home-wrapper">
<style scoped>
    .registerMobile, .site_naf_lang{
        visibility:hidden;
    }
</style>
<?php include('header_home.php'); ?>
<style scoped>
.form-signin
{
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
}
.form-signin .form-signin-heading, .form-signin .checkbox
{
    margin-bottom: 10px;
}
.form-signin .checkbox
{
    font-weight: normal;
}
.form-signin .form-control
{
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.form-signin .form-control:focus
{
    z-index: 2;
}
.form-signin input[type="text"]
{
    margin-bottom: -1px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}
.form-signin input[type="password"]
{
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.account-wall
{
    margin-top: 20px;
    padding: 20px 0px 20px 0px;
    background-color: #f7f7f7;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}
.verify-mobile-wrapper{
    margin-top: 57px;width:35%;margin-right: auto; margin-left: auto;
}
#form-heading-nct{
    text-align:center;
}
@media(max-width: 768px){
    .verify-mobile-wrapper{
        width:90%;
    }
}
</style>
<div  class="row verify-mobile-wrapper" id="nct-mobile-number">
    <div class="col-sm-12 col-md-12">
        <p class="h5" id="form-heading-nct">Please confirm your access</p>
        <div class="account-wall">
            <?php
            $attr = array("class" => "form-signin", "role" => "form", "id" => "verifymobile", "name" => "verifymobile");
            echo form_open("viewvotes/sendotp_leader_vote", $attr);?>
            <input id="mobile_number_nct" name="mobile_number_nct" type="text" class="form-control" placeholder="Mobile Number" required autofocus>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Send OTP</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div class="row verify-mobile-wrapper" id="nct-otp-verify" style="display: none">
    <div class="col-sm-12 col-md-12">
        <div class="account-wall">
            <?php
            $attr = array("class" => "form-signin", "role" => "form", "id" => "verifyotp", "name" => "verifyotp");
            echo form_open("viewvotes/verifyotp_leader_vote", $attr);?>
            <input type="text" name="verify_otp_nct" class="form-control" placeholder="Enter OTP" required autofocus>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Verify OTP</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div style="display: none" class="col-md-12  table-responsive" id="vote_error_div">
            <center><h4 style="color: red" id="vote_error"></h4></center>
        </div>
    </div>
</div>
<style scoped>
    footer{
        visibility:hidden;
    }
</style>
<?php include('footer.php');?>
<script>
    $("#verifymobile").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData($("form#verifymobile")[0]);
        $("#vote_error_div").hide();
        $.ajax({
            url: "<?php echo base_url(); ?>viewvotes/sendotp_leader_vote",
            data: formData,
            type: "POST",
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                if (result.status == "success") {
                    $('#nct-mobile-number').hide();
                    $('#nct-otp-verify').fadeIn();
                    $("#vote_error_div").fadeIn();
                    $("#vote_error").html(result.msg);
                } else {
                    $("#vote_error_div").fadeIn();
                    $("#vote_error").html(result.msg);
                }
            }
        });
    });

    $("#verifyotp").on("submit", function (e) {
        e.preventDefault();
        var mobile_number = $("#mobile_number_nct").val();
        var formData = new FormData($("form#verifyotp")[0]);
        formData.append('mobile_number_nct', mobile_number);
        $("#vote_error_div").hide();
        $.ajax({
            url: "<?php echo base_url(); ?>viewvotes/verifyotp_leader_vote",
            data: formData,
            type: "POST",
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                if (result.status == "success") {
                   window.location.href = "<?php echo base_url().'viewvotes';  ?>";
                } else {
                    $("#vote_error_div").fadeIn();
                    $("#vote_error").html(result.msg);
                }
            }
        });
    });
</script>
</body>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</html>
