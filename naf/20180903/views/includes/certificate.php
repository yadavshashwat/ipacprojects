
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf8_unicode_ci"/>
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">

	</head>
	<body>
		<table style="margin: auto; width: 100%; max-width: 600px; border: solid 1px #333; padding: 20px; font-family: 'Roboto', sans-serif;">
			<tr>
				<td>
					<img src="<?php echo base_url()?>assets/images/ipacLogo.png" style="height: 100px; display: block; margin: auto; margin-bottom: 20px;">
				</td>
			</tr>
			<tr>
				<td>
					<p style="margin-bottom: 20px;">Hi <?php echo $user_detail['user_name']?>,</p>
					<!-- <p>Thanks for registering as a NAF Fellow. NAF Fellows will be the agents to become the voice of the masses, engage the masses to choose leader &amp; set the agenda for the Government.</p> -->
					<p>Your unique registration ID is: <b><?php echo $user_detail['registration_number']?></b></p>
					<p>Please keep checking the NAF website and I-PAC Facebook page for regular NAF updates.</p>
					<p>NAF Website: https://www.indianpac.com/naf</p>
					<p>I-PAC Facebook Page: https://www.facebook.com/IndianPAC</p>
					<p>Thanks, <br>I-PAC</p>
				</td>
			</tr>
		</table>
	</body>
</html>