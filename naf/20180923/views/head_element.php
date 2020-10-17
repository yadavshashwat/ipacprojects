<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$language_variable = "";
$parts = parse_url($actual_link);
if(isset($parts['query'])){
    parse_str($parts['query'], $query);
    if(isset($query['lang'])){
        $language_variable = $query['lang'];
    }
}




if(!isset($_COOKIE['language'])){
    if ($language_variable == ""){
        setcookie("language","en",time() + (10 * 365 * 24 * 60 * 60),"/");
        $langcookie="en";
    }else if($language_variable == "English"){
        setcookie("language","en",time() + (10 * 365 * 24 * 60 * 60),"/");
        $langcookie="en";
    }else if($language_variable == "Hindi"){
        setcookie("language","hi",time() + (10 * 365 * 24 * 60 * 60),"/");
        $langcookie="hi";
    }else{
        setcookie("language","en",time() + (10 * 365 * 24 * 60 * 60),"/");
        $langcookie="en";
    }
}else {
    if ($language_variable !=="" ){
        if ($language_variable == ""){
            setcookie("language","en",time() + (10 * 365 * 24 * 60 * 60),"/");
            $langcookie="en";
        }else if($language_variable == "English"){
            setcookie("language","en",time() + (10 * 365 * 24 * 60 * 60),"/");
            $langcookie="en";
        }else if($language_variable == "Hindi"){
            setcookie("language","hi",time() + (10 * 365 * 24 * 60 * 60),"/");
            $langcookie="hi";
        }else{
            setcookie("language","en",time() + (10 * 365 * 24 * 60 * 60),"/");
            $langcookie="en";
        }}
    else{
        $langcookie=$_COOKIE['language'];
        }

    }





?>





<meta http-equiv="Cache-control" content="no-cache" />
<meta charset="utf-8" />
<meta name="MobileOptimized" content="320" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
<meta name="google-signin-client_id" content="784213681989-6q1ei1mlr5reo5rdkd2u631tnc26nj2a.apps.googleusercontent.com">
<meta name="google-signin-scope" content="https://www.googleapis.com/auth/analytics.readonly">




<link rel="icon" href="<?php echo base_url()?>assets/images/favicon.png">
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/main.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<?php if ($langcookie=="en"){?> 
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/custom.css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/custom_victor.css">
<?php }?>

<?php if ($langcookie=="hi"){?> 
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/custom_hindi.css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/custom_victor_hindi.css">
<?php }?>



<meta property="og:url" content="http://indianpac.com/naf/">
<meta property="og:type" content="website">
<meta property="og:title" content="Join National Agenda Forum">
<meta property="og:description" content="Gandhiji, in his Constructive Programme (https://goo.gl/Qpphxj), had outlined the blueprint for independent India. Let's spread his vision and formulate an actionable agenda for India in his 150th Birth Anniversary year. Join #NationalAgendaForum, visit www.indianpac.com/naf/">
<meta property="og:image" content="<?php echo base_url()?>assets/images/logo.png">
<!-- Global site tag (gtag.js) - Google Analytics -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121633598-3"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-121633598-3');
</script>
<!-- Hotjar Tracking Code for https://www.indianpac.com/naf/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:955483,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
