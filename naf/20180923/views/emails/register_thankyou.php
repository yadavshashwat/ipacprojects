<?php
$langcookie='en';
if(isset($_COOKIE['language'])){
    $langcookie=$_COOKIE['language'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration as a Part Time Associate of I-PAC</title>
</head>
<?php if($langcookie=="hi"){ ?>
    <body>
    <p>नमस्कार   <?php echo isset($user_name) ? $user_name : 'user'; ?>,</p>
    <p>इडियन पॉलिटिकल एक्शन कमिटी (I-PAC) के राष्ट्र के लिए अभियान के साथ <strong>पार्ट टाइम एसोसिएट (PTA) </strong>के तौर पर रजिस्टर करने के लिए आपका धन्यवाद।</p>
    <p>आपका यूनीक रजिस्ट्रेशन आईडी <strong><?php echo isset($registration_number) ? ''.$registration_number : ''; ?></strong>है। </p>
    <p>जो पीटीए सक्रिय तौर पर इस पहल में हिस्सा लेंगे, उन्हें मिलेगा:</p>
    <ul>
        <li>प्रतिभागी प्रमाण-पत्र</li>
        <li>राष्ट्रीय नेताओं के साथ मिलने का मौका</li>
        <li>I-PAC के साथ इंटर्नशिप एवं जॉब में वरियता</li>
    </ul>
    <p>आपके पहले काम हैं:</p>
    <ol>
        <li>अपने ईमेल कॉन्टैक्ट में   <a href="mailto:pta@indianpac.com">pta@indianpac.com</a> को जोड़ें।</li>
        <li>राष्ट्र के लिए अभियान से जुड़े अपडेट्स के लिए I-PAC से  <a href="https://www.facebook.com/indianpac"> फेसबुक</a>, <a href="https://www.twitter.com/indianpac">ट्वीटर </a>, एवं  <a href="https://www.instagram.com/indianpac">इंस्टाग्राम</a> पर जुड़ें।</li>
    </ol>
    <p>I-PAC परिवार में आपका स्वागत है, हम आपके साथ इस पहल को सफल बनाने की आशा रखते हैं|</p>
    <p>सादर,<br>
        इडियन पॉलिटिकल एक्शन कमिटी (I-PAC) </p>
    <br>
    </body>
<?php }else{ ?>
    <body>
    <p>Hi  <?php echo isset($user_name) ? $user_name : 'user'; ?>,</p>
    <p>Thanks for registering as a <strong>Part Time Associate (PTA)</strong>  to Campaign for India with the Indian Political Action Committee (I-PAC).</p>
    <p>Your unique registration ID is: <strong><?php echo isset($registration_number) ? ''.$registration_number : ''; ?></strong></p>
    <p>PTAs who actively participate in the initiative become eligible for:</p>
    <ul>
        <li>Certificates of participation</li>
        <li>Opportunities to interact with the national leadership</li>
        <li>Preference in applications for internship and job opportunities at I-PAC</li>
    </ul>
    <p>Your initial set of tasks are:</p>
    <ol>
        <li>Add the email ID  <a href="mailto:pta@indianpac.com">pta@indianpac.com</a> in your email contacts </li>
        <li>Connect with us on <a href="https://www.facebook.com/indianpac">Facebook</a>, <a href="https://www.twitter.com/indianpac">Twitter</a>, and <a href="https://www.instagram.com/indianpac">Instagram</a> for Campaign for India updates.</li>
    </ol>
    <p>Welcome to the I-PAC family, we look forward to working with you.</p>
    <p>Regards,<br>
        Indian Political Action Committee (I-PAC)</p>
    <br>
    </body>
<?php }?>

</html>
