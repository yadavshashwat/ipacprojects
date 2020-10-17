<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include 'BaseController.php';
class Leaders extends BaseController {

    public function __construct()
    {
        parent::__construct();

        if(!$this->session->has_userdata('admin_login')){
            redirect('admin-panel/login');
        }
        $this->load->model('Leaders_model','leaders');
    }   

    public function index(){        
        $this->leader_list();
    }

    public function leader_list(){
        $data['site_name']  = $this->config->item('site_name');
        $data['menu']       = 'leaders';
        $data['sub_menu']   = 'leader_list';
        $data['page_title'] = 'Leaders List';        
        
        $this->load->view('admin/leader_list',$data);
    }

    public function ajax_load_data(){
        $search_params = array();
        if($_POST['search']['value']){
            $search_params["search"] = $_POST['search']['value'];
        }
        //echo '<pre>';print_r($_POST);exit;
        $list = $this->leaders->get_all_leaders_details($_POST['start'], $_POST['length'], $search_params);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $key => $value) {
            $no++;
            $row = array();
            $row[] = "<strong>".$no.".</strong>";
            $row[] = $value["full_name"];

            if($value["is_feature"]){
                $row[] = "Yes";
            }else{
                $row[] = "No";
            }

            $row[] = $value["total_vote"];

           /* $row[] = '<a  class="btn btn-xs btn-primary" href="'.base_url().'admin/edit_university/'.$value['id'].'" data-toggle="tooltip" title="Edit"><span style="padding:3px" class="glyphicon glyphicon-edit"></span></a><br><br><a class="btn btn-xs btn-danger" href="javascript:;" onclick="deleteRow('.$value['id'].')" data-toggle="tooltip" title="Delete"><span style="padding:3px" class="glyphicon glyphicon-remove-sign"></span></a>';*/
            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->leaders->get_leaders_Count(array()),
                "recordsFiltered" => $this->leaders->get_leaders_Count($search_params),
                "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function new_leader_list(){
        $data['site_name']  = $this->config->item('site_name');
        $data['menu']       = 'new_leaders';
        $data['sub_menu']   = 'New leader_list';
        $data['page_title'] = 'New Leaders List';        
        
        $this->load->view('admin/new_leader_list',$data);
    }

    public function load_new_leaders(){
        $search_params = array();
        if($_POST['search']['value']){
            $search_params["search"] = $_POST['search']['value'];
        }
        //echo '<pre>';print_r($_POST);exit;
        $list = $this->leaders->get_all_new_leaders($_POST['start'], $_POST['length'], $search_params);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $key => $value) {
            $no++;
            $row = array();
            $row[] = "<strong>".$no.".</strong>";
            $row[] = $value["leader_name"];

           /* $row[] = '<a  class="btn btn-xs btn-primary" href="'.base_url().'admin/edit_university/'.$value['id'].'" data-toggle="tooltip" title="Edit"><span style="padding:3px" class="glyphicon glyphicon-edit"></span></a><br><br><a class="btn btn-xs btn-danger" href="javascript:;" onclick="deleteRow('.$value['id'].')" data-toggle="tooltip" title="Delete"><span style="padding:3px" class="glyphicon glyphicon-remove-sign"></span></a>';*/
            $data[] = $row;
        }

        $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->leaders->get_new_leaders_Count(array()),
                "recordsFiltered" => $this->leaders->get_new_leaders_Count($search_params),
                "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
}

?>