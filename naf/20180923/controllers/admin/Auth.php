<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include 'BaseController.php';

	class Auth extends BaseController {

		public function __construct(){
	        parent::__construct();
	        $this->load->model('Auth_model','auth');
	    }

	    public function list_groups($pageno = 1){
	    	if(!$this->session->has_userdata('admin_login')){
        		redirect('admin/login');
        	} 

        	$data['site_name'] = $this->config->item('site_name');
	        $data['menu']      = 'access_control';
	        $data['sub_menu']  = 'list_groups';
	        $data['page_title']  = 'Manage User Groups';

	        $data["get"] = $_GET;

			$video_type = 1;

	        $resultsPerPage = 10;
	        //$pageno = 1;
	        if($pageno == ""){
	        	$pageno = 1;
	        }
	        
	        $start = ($pageno - 1) * $resultsPerPage;

        	$data["row_count"] = $this->auth->getGroupsCount($data["get"]);
        	$lastpage = $data["row_count"] / $resultsPerPage;
        	$lastpage = ceil($lastpage);

			if ($pageno <= 1) {
			    $pageno = 1;
			} else if ($pageno > $lastpage) {
			    $pageno = $lastpage;
			}

			if ($pageno == 1) {
			    $start = '0';
			} else {
			    $start = $start;
			}

			$data["pageno"] = $pageno;
			$data["lastpage"] = $lastpage;
			$data["resultsPerPage"] = $resultsPerPage;

        	//$data["results"] = $this->auth->getAllGroups($start, $resultsPerPage, $data["get"]);
        	$data["results"] = array();
        	$this->load->view('admin/list_user_groups',$data);
	    }

	    public function ajax_load_data(){

	        $search_params = array();
	        if($_POST['search']['value']){
	            $search_params["search"] = $_POST['search']['value'];
	        }

	        $list = $this->auth->getAllGroups($_POST['start'], $_POST['length'], $search_params);

	        $data = array();
	        $no = $_POST['start'];

	        foreach ($list as $key => $value) {
	            $no++;
	            $row = array();
	            
	            $row[] = "<strong>".$no.".</strong>";
	            $row[] = $value["group_name"];

	            $rights = "";

	            $dt=str_split($value["group_rights"]);
	            foreach($dt as $newdt){
	            	if($newdt==1){
	            		$rights .= "Read<br/>";
	            	}
	            	if($newdt==2){
	            		$rights .= "Write<br/>";
	            	}
	            }

	            $row[] = $rights;

	            $module_rights = "";
	            $right_on_module=json_decode($value["right_on_module"],true);
				$count2=0;
                foreach($right_on_module as $nd){
                	$module_rights .= ($count2+1).". ".$nd."<br/>";
                	$count2++;
                }

                $row[] = $module_rights;

                $submodule_rights = "";
                $count6=0;
	            if(strtolower($value["group_name"])=="super admin"){
	            	$submodule_rights = "All";
	            }else{
	            	foreach ($value['right_on_submodule_details'] as $nd) {
	            		$submodule_rights .= ($count6 + 1) . ". " . $nd . "<br/>";
	            		$count6++;
	            	}
	            }
	            $row[] = $submodule_rights;

	            if(strtolower($value["group_name"])!="super admin"){
	            	$row[] = '<a  class="btn btn-xs btn-primary" href="'.base_url().'admin/edit_subject/'.$value['group_id'].'" data-toggle="tooltip" title="Edit"><span style="padding:3px" class="glyphicon glyphicon-edit"></span></a><br><br><a class="btn btn-xs btn-danger" href="javascript:;" onclick="deleteRow('.$value['group_id'].')" data-toggle="tooltip" title="Delete"><span style="padding:3px" class="glyphicon glyphicon-remove-sign"></span></a>';
	            }else{
	            	$row[] = "NA";
	            }

	            $data[] = $row;
	        }



	        $output = array(
	                "draw" => $_POST['draw'],
	                "recordsTotal" => $this->auth->getGroupsCount(array()),
	                "recordsFiltered" => $this->auth->getGroupsCount($search_params),
	                "data" => $data,
	        );
	        //output to json format
	        echo json_encode($output);
	    }

	    public function add_user_group(){
	    	if(!$this->session->has_userdata('admin_login')){
        		redirect('admin/login');
        	} 

        	$data['site_name'] = $this->config->item('site_name');
	        $data['menu']      = 'access_control';
	        $data['sub_menu']  = 'list_groups';
	        $data['page_title']  = 'Register a New Group';

	        $data['error'] = '';$data['success'] = '';

	        if(!empty($_POST)){

	        	$groupname = $_POST["groupname"];
		        $modulename = $_POST["modulename"];
		        $submodulename = $_POST["submodulename"];
		        $modulename = json_encode($modulename, TRUE);
		        $permissions = $_POST["permissions"];
		        $permissions = implode("", $permissions);

	        	$returnArr = array();

	        	if(empty($_POST['permsissions'])){
	        		$_POST['permsissions'][0] = 1;
	        	}

	        	if ($_POST["permissions"] == "") {
		            $returnArr["errCode"] = 2;
		            $returnArr["errMsg"] = "Admin Group Permissions are required !!";

		            echo(json_encode($returnArr));
		            exit;
		        }


		        if ($_POST["modulename"] == "") {
		            $returnArr["errCode"] = 2;
		            $returnArr["errMsg"] = "Please Select Module on you want to add this group!!";

		            echo(json_encode($returnArr));
		            exit;
		        }



		        $checkmodule = json_decode($modulename, TRUE);

		        foreach ($checkmodule as $value) {
		            if ($value == "") {
		                $returnArr["errCode"] = 2;
		                $returnArr["errMsg"] = "Please Select Module on you want to add this group!!";
		                echo(json_encode($returnArr));
		                exit;
		            }
		        }


		        if (empty($submodulename)) {
		            $returnArr["errCode"] = 2;
		            $returnArr["errMsg"] = "Please Select at least one submodule !!";

		            echo(json_encode($returnArr));
		            exit;
		        }


		        foreach ($submodulename as $value) {
		            if ($value == "") {
		                $returnArr["errCode"] = 2;
		                $returnArr["errMsg"] = "Please Select Sub-Module on you want to add this group!!";
		                echo(json_encode($returnArr));
		                exit;
		            }

		        }

	            $result = $this->auth->add_user_group($groupname, $permissions, $modulename, $submodulename); 
	            if($result == 1){
	            	$returnArr["errCode"] = -1;
	            	$returnArr["msg"] = "Group Added Successfully.";
	            }else{
	            	$returnArr["errCode"] = 1;
	            	$returnArr["msg"] = "Error to add details.";
	            }
	            echo json_encode($returnArr);
	            exit;
	        }

	        $data['all_modules'] = $this->auth->get_all_modules();
			$this->load->view('admin/add_user_group',$data);
	    }

	    public function get_sub_modules(){

	    	$submodules = $this->auth->get_sub_modules($_POST['allmodules']);
	    ?>	
	    		<label>Permision on Sub Module&nbsp;<span class="required">*</span>&nbsp;&nbsp;:</label>
	    		<select class="form-control select2" id="submodulename" name="submodulename" data-placeholder="----Select Submodules-----" multiple required="">
	                <option value="">----Select Submodules----</option>
	                <?php

	                foreach ($submodules as $value) {
	                    echo "<option>" . $value . "</option>";
	                }
	                ?>

	            </select>
	            <script type="text/javascript">$('.select2').select2();</script>
	    <?php
	    	//print_r($_POST);
	    }

	}
?>