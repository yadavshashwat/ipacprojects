<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head_element.php'); ?>
    <title>NAF | View Leader Votes</title>
    <meta name="description" content=""/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
</head>
<style scoped>
    .registerMobile, .site_naf_lang{
        visibility:hidden;
    }
    footer{
        visibility:hidden;
    }
</style>
<body class="home home-wrapper">
<?php include('header_home.php'); ?>
<style scoped>
    #search-vote-wrapper{
        margin: 1em auto;
        width: 80%;
    }
    #search_string{
        width:70%;
    }
    #user_leader_user_details{
        margin: 1em 0;
    }
    @media(max-width:768px){
        #search_string {
            width: 100%;
        }
        #leader_vote_back{
            width:69px;
        }
        .table-responsive{
            overflow-x:hidden;
            border:none;
        }
        #search-vote-wrapper {
            width: 90%;
            margin: 1em 1em 0 1em;
        }
        #user_leader_user_details{
            margin: 0 0 1em 0;
        }
    }
</style>
<div class="row" id="search-vote-wrapper">
    <div class="col-md-12 well" style="padding: 10px;">
        <?php
        $attr = array("class" => "form-inline", "role" => "form", "id" => "viewvotesform", "name" => "viewvotesform");
        echo form_open("viewvotes/filtervotes", $attr);?>
        <div class="form-inline" style="margin-bottom: 0px;width:100%">
            <input class="form-control" id="search_string" name="search_string" placeholder="ENTER REFERRAL CODE OR MOBILE NUMBER" type="text" value="<?php echo set_value('search_string'); ?>" required/>
            <input style="height: 34px;margin-bottom: 10px;" type="submit" name="btn_search" class="btn btn-success" value="Search" />
            <a href="<?php echo base_url().'viewvotes'; ?>" style="height: 34px;margin-bottom: 10px;" class="btn btn-default">Clear Filter</a>
            <a href="<?php echo base_url(); ?>" style="height: 34px;margin-bottom: 10px;" class="btn btn-primary" id="leader_vote_back">Back</a>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="container">
    <div class="row">
        <div style="display: none" class="col-md-12  table-responsive" id="vote_error_div">
            <center><h4 style="color: red" id="vote_error"></h4></center>
        </div>
        <div class="col-md-12  table-responsive" id="user_leader_user_details">
            <table style="width: 100%" id="user_details"></table>
        </div>
        <div class="col-md-12  table-responsive">
            <table style="border-collapse: collapse;display:none" class="table table-hover table-bordered" id="date_leader_vote_table">
                <thead>
                <tr>
                    <th class="text-left">Date</th>
                    <th class="text-left" style="white-space: nowrap">No of votes</th>
                </tr>
                </thead>
                <tbody id="date_vote_data"></tbody>
            </table>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12  table-responsive">
            <table style="border-collapse: collapse;display:none" class="table table-hover table-bordered" id="leader_vote_table">
                <thead>
                <tr>
                    <th class="text-left">Serial No.</th>
                    <th class="text-left" style="white-space: nowrap">Vote Registered (Date)</th>
                </tr>
                </thead>
                <tbody id="vote_data"></tbody>
            </table>
        </div>
    </div>
</div>
<?php include('footer.php');?>
<script>
    $("#viewvotesform").on("submit", function (e) {
        $("#user_details").html("");
        $("#leader_vote_table").hide();
        $("#date_leader_vote_table").hide();
        $("#vote_error_div").show();
        $("#vote_error").html('<img src="https://res.cloudinary.com/indianpac/image/upload/naf/images/icons/Ripple-2.1s-73px.gif" />');
        e.preventDefault();
        var formData = new FormData($("form#viewvotesform")[0]);
        $.ajax({
            url: "<?php echo base_url(); ?>viewvotes/filtervotes",
            data: formData,
            type: "POST",
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                if (result.status == "success") {
                    var html ="", html_group = "",html_user = "";
                    $.each(result.data,function(index,value){
                        html += '<tr>';
                        html += '<td>'+ (index+1) +'</td>';
                        html += '<td>'+ value.created_at +'</td>';
                        html += '</tr>';
                    });
                    $.each(result.data_dates, function(index,value,array){
                        html_group += '<tr>';
                        html_group += '<td>' + value.create_date +'</td>';
                        html_group += '<td>' + value.no_of_votes +'</td>';
                        html_group += '</tr>';
                    });

                    html_user += '<tr>';
                    html_user += '<td><strong>Name: </strong>'+result.user_name +'</td>';
                    html_user += '</tr>';
                    html_user += '<tr>';
                    html_user += '<td><strong>Mobile Number: </strong>'+result.mobile_number +'</td>';
                    html_user += '</tr>';
                    html_user += '<tr>';
                    html_user += '<td style="word-break: break-word;"><strong>Referral Link: </strong><a href="'+result.referral_link +'" target="_blank">'+result.referral_link +'</a></td>';
                    html_user += '</tr>';
                    html_user += '<tr>';
                    html_user += '<td><strong>Total Votes: </strong>'+result.total_votes +'</td>';
                    html_user += '</tr>';
                    $("#vote_error_div").hide();
                    $("#vote_data").html(html);
                    $("#leader_vote_table").fadeIn();
                    $("#user_details").html(html_user);
                    $("#date_vote_data").html(html_group);
                    $("#date_leader_vote_table").fadeIn();
                } else {
                    $("#leader_vote_table").hide();
                    $("#date_leader_vote_table").hide();
                    $("#vote_error_div").show();
                    $("#vote_error").html(result.msg);
                }
            }
        });
    });
</script>
</body>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</html>
