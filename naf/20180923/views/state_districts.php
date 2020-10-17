<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head_element.php'); ?>
    <title>NAF | Leaders Nominated</title>
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

<div class="container">
    <div class="row">
        <div class="col-md-12  table-responsive">
            <table style="border-collapse: collapse;" class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th class="text-left">Sl.No.</th>
                    <th class="text-left">State</th>
                    <th class="text-left">District</th>
                </tr>
                </thead>
                <tbody>
                <?php
                //print_r($getnoninatedldresults);
				$i=1;
                    foreach ($getstatedistricts as $index => $agendas_nominated) {
                        ?>
                        <tr>
                        <td class="text-left"><?php echo $i; ?></td>
                            <td class="text-left"><?php echo $agendas_nominated['STATE']; ?></td>
                            <td class="text-left"><?php echo $agendas_nominated['DISTRICT']; ?></td>
                        </tr>
                        <?php
						$i++;
                    }

                ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!--<div class="row">
        <div class="col-md-12">
            <?php //echo $this->pagination->create_links(); ?>
        </div>
    </div>
    <div class="sli4">
        <a href="<?php //echo base_url() ?>">BACK</a>
    </div>-->
</div>
<?php include('footer.php'); ?>
</body>
<script type="text/javascript">

    var phone_val = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
    var whitespaces_val = /^\s+$/;

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
