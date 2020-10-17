<!DOCTYPE html>
<html>
<head>
	<title>Test mail</title>
</head>
<body>
	<p>Hi <?php echo isset($user_name) ? $user_name : 'user'; ?>,</p>

	<p>Your unique registration ID is: <strong><?php echo isset($registration_number) ? $registration_number : ''; ?></strong></p>

	<p>Please keep checking the NAF website and I-PAC Facebook page for regular NAF updates.
	<br>NAF Website: https://www.indianpac.com/naf</p>

	<p>I-PAC Facebook Page: https://www.facebook.com/IndianPAC</p>

	<br>
	<p>Thanks<br>
	I-PAC  </p>           
</body>
</html>