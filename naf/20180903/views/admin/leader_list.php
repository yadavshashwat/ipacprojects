<!DOCTYPE html>
<html>
	<?php
		$this->load->view('admin/head_meta');
	?>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<?php
			$this->load->view('admin/top_header');
			$this->load->view('admin/left_sidebar');
		?>

		<div class="content-wrapper">
			<section class="content-header">
				<h1><?php echo isset($page_title) ? $page_title : '' ; ?></h1>
				<ol class="breadcrumb">
        			<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        			<li class="active"><?php echo isset($page_title) ? $page_title : '' ; ?></li>
      			</ol>
			</section>

			<section class="content">
				<div class="box">
        			<div class="box-body">
            			<div class="pull-left">
            				
            			</div>
            			<!-- <div class="pull-right">
	                        <a href="<?php echo base_url()?>admin/add_university" class="btn btn-success" style="margin-bottom: 5px;">Add Leader <span class="glyphicon glyphicon-plus-sign"></span></a>
		                </div> -->

		                <table class="table table-bordered margin-large-top" id="example1" style="width:100%;">
		                 	<thead>
                        		<tr class="headings tbl_style">
                        			<th>Sr. No</th>
                        			<th>Leader Name</th>
                        			<th>Feature</th>
									<th>Total Vote</th>
                        		</tr>
                        	</thead>
                        	<tbody>
                        		
                        	</tbody>
		                </table>
            		</div>
            	</div>
			</section>
		</div>

		<div class="control-sidebar-bg"></div>

		<?php
			$this->load->view('admin/footer');
		?>

	</div>

	<script type="text/javascript">
		

		function deleteRow(id){

			var base_url = '<?php echo base_url(); ?>';

			bootbox.confirm({
	            //title: 'Delete Details!!',
	            message: "Are you sure you want to delete this entry?",
	            buttons: {
	                'cancel': {
	                    label: 'Cancel',
	                    className: 'btn-default'
	                },
	                'confirm': {
	                    label: 'Continue',
	                    className: 'btn-success pull-right'
	                }
	            },
	            callback: function(result) {

	                if (result) {
	                    $.ajax({

	                        type: "POST",
	                        dataType:"json",
	                        url: base_url+'admin/university/delete_university',
	                        data: {
	                            id: id
	                        },
	                        success: function(result) {
	                        	if(result["errCode"]!="-1"){
		                   			bootbox.alert("<p style='color:red'>"+result['msg']+"</p>", function() {
		                         	});
		                    	}else{
			                       bootbox.alert(result['msg'], function() {
			                            location.href=base_url+'admin/university';
			                       });
			                    }
	                        },
	                        error: function() {
	                            bootbox.alert("Failed to delete details", function() {
	                            });
	                        }
	                    });

	                }
	            }
	        });
		}

		$(function(){
			$('#example1').DataTable({				
		      	"paging": true,
		      	"aLengthMenu": [
					[10, 50, 100, -1],
					[10, 50, 100, "All"]
				],
				
		      	"searching": true,
		      	"ordering": true,
		      	"info": true,
		      	"autoWidth": true,
		      	"order": [[ 1, "asc" ]],
		      	"columnDefs": [
				   { "orderable": false, "targets": [0,2] }
				],
				dom: 'Blfrtip',
		        buttons: [
		            {  
		              extend: 'excel',
		              text: 'Download as Excel' ,
		              exportOptions: {
		                    columns: [ 0, 1, 2, 3]
		                }
		            },
		            {  
		              extend: 'csv',
		              text: 'Download as CSV' ,
		              exportOptions: {
		                    columns: [ 0, 1, 2, 3]
		                }
		            }
		        ],
				"pageLength": 10,
				"processing": true, //Feature control the processing indicator.
        		"serverSide": true,
				"ajax": {
		            url : "<?php echo site_url("admin/leaders/ajax_load_data") ?>",
		            type : 'POST'
		        }
		    });
		});
	</script>

</body>
</html>