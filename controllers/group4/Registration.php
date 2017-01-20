<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Registration extends CI_Controller {

	public $current_id;
	public $user_data;

	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'group4/Registration_model' ); // I can now access the Registration_model class ($this->Registration_model)
		$this->load->model('group1_models/user_model'); // I can now access the User_model class ($this->User_model)
    $this->load->model('group4/semester_model');

		$this->user_data = $this->Registration_model->get_user();
		$this->current_id = $this->user_data['user_id'];

		$this->clearance = $this->user_model->getPermission($this->session->userID); // grab the users permission from the db and store it in clearance
	}

	public function select() {


        $temp = $this->session->flashdata();
        $semId = null;
        if(isset($temp['remove'])){
          $semId = $temp['remove'];
        } else if(isset($temp['add'])){
          $semId = $temp['add'];
        }

        $post_student = $this->input->post("student_id");
        $student_id = $post_student ? $post_student : $this->session->flashdata('student_id');
        // var_dump($data['student_id']);
        $semester_id = $semId ? $semId : $this->input->post('semester_id');
    		$data = $this->Registration_model->get_data($student_id, $semester_id);

        $data['student_id'] = $student_id;
        $data['semester_id'] = $semester_id;

    		$data['reg_clearance'] = $this->clearance;
        $data['user_info'] = $this->user_data;



        // print_r($this->session->flashdata('student_id'));

        $this->load->view('group1/templates/header');
    		$this->load->view('group1/templates/navbar/navbar', $data);
    		$this->load->view('group4/registration/view_two', $data);
    		$this->load->view('group1/templates/navbar/navbottom');
    		$this->load->view('group1/templates/footer');
	}

	public function add_class() {

		$user_id = $this->input->post('add_user');

    // check start time of new course
    $new_time = $this->input->post('start_time');
		$course_id = $this->input->post('add_course');
		$semester_id = $this->input->post('add_semester');

    $registered_times = $this->Registration_model->getTimes($user_id);
    // print_r($registered_times);
    // compare against start time of all registered courses
    foreach($registered_times as $time){
      if($new_time == $time["time1start"] && $semester_id == $time["semester_id"]){
          // redirect back to registration page with flash error message (time conflict "you already have a class at this time")

              $flash = array("add" => $semester_id, "student_id" => $user_id, "error" => "! You already have a class in this time frame !");

              $this->session->set_flashdata($flash);
          		redirect('select_registration');
      }
    }

		$this->Registration_model->add($user_id, $course_id, $semester_id);

    $flash = array("add" => $semester_id, "student_id" => $user_id);

    $this->session->set_flashdata($flash);
		redirect('select_registration');
	}

	public function remove_class() {
		$user_id = $this->input->post('remove_user');
		$course_id = $this->input->post('remove_course');
		$semester_id = $this->input->post('remove_semester');
		$this->Registration_model->remove($user_id, $course_id, $semester_id);

    $flash = array("remove" => $semester_id, "student_id" => $user_id);

    $this->session->set_flashdata($flash);
		redirect('select_registration');
	}

  // for the record... i didn't name this
	public function view() {
		$query = $this->Registration_model->get_semesters()->result_array();
		$data['semester'] = $query;

		$data['current_semester'] = $this->semester_model->get_current();

		$data['reg_clearance'] = $this->clearance;

    $user_info = (array)$this->user_model->getUserInfo($this->session->userID);

    $data['students'] = $this->user_model->getKids($user_info);

    if(count($data['students'])){
      $data["studentExists"] = 1;
    } else {
      $data["studentExists"] = 0;
    }


    if(count($data['semester'])){
      $data['exists'] = 1;
    } else {
      $data['exists'] = 0;
    }

    $this->load->view('group1/templates/header');
    $this->load->view('group1/templates/navbar/navbar', $data);
    $this->load->view('group4/registration/view', $data);
    $this->load->view('group1/templates/navbar/navbottom');
    $this->load->view('group1/templates/footer');
	}
}
