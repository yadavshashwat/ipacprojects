<!DOCTYPE html>
<html lang="en">
<head>
<?php include('head_element.php'); ?>
<title>NAF</title>
<meta name="description" content="" />
</head>
<body class="ipac_edit_body">
<!-- <input type="hidden" name="referral_code" id="referral_code" value="<?php echo $referral_code?>"> -->
<!-- <input type="hidden" name="referral_owner_id" id="referral_owner_id" value="<?php echo $referral_owner_id?>"> -->
<div class="backImg"></div>
<div class="wrapper">
  <?php include('header.php'); ?>
  <div class="homeMain agendaMain">
	<h1>Thank you for voting</h1>
	<h2>Please wait you will be redirected to registration in a while</h2>
  </div>

  <?php include('footer.php'); ?>
<!--  <script src='https://www.google.com/recaptcha/api.js'></script> -->
</div>
<!-- Google Code for Naf Conversion Conversion Page -->
		<script type="text/javascript">
			/* <![CDATA[ */
			var google_conversion_id = 797445191;
			var google_conversion_label = "Iiz7CN7f0oUBEMeYoPwC";
			var google_remarketing_only = false;
			/* ]]> */
		</script>
		<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
			<div style="display:inline;">
				<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/797445191/?label=Iiz7CN7f0oUBEMeYoPwC&amp;guid=ON&amp;script=0"/>
			</div>
		</noscript>
</body>
<script>
// function Redirect(){
  
// }
setTimeout(function(){
	// document.write("Please wait you will be redirected in 1sec");
	window.location.href = ("<?php echo base_url()?>register/");	
}, 500);
</script>
</html>
