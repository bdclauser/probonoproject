<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Semesters extends CI_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'group4/semester_model' ); // I can now access the Semester_model class ($this->Semester_model)
		$this->load->model('group1_models/user_model'); // I can now access the User_model class ($this->User_model)
		$this->clearance = $this->user_model->getPermission($this->session->userID); // grab the users permission from the db and store it in clearance
	}

	public function add() {
		$this->clearance = $this->semester_model->getPermission ( $this->session->userID ); // removed this from constructor and put it here - error onClick of forgot_password
		$permArray = str_split ( $this->clearance );

		if ($this->session->logged_in && $permArray [0] == 1) { // if logged in show browse users
			$this->semester_model->add_semester();
			redirect('');
		} else { // else redirect to Login_controller
			header ( 'Location: login' );
		}
	}

	public function select() {

    $temp = $this->session->flashdata();
    $semId = null;
    if(isset($temp['remove'])){
      $semId = $temp['remove'];
    } else if(isset($temp['add'])){
      $semId = $temp['add'];
    }

    $semester_id = $semId ? $semId : $this->input->post('semester_id');
		$data = $this->semester_model->get_data($semester_id);

    $data['semester_id'] = $semester_id;
		$data['reg_clearance'] = $this->clearance;

    $this->load->view('group1/templates/header');
		$this->load->view('group1/templates/navbar/navbar', $data);
		$this->load->view('group4/semesters/edit_selected', $data);
		$this->load->view('group1/templates/navbar/navbottom');
		$this->load->view('group1/templates/footer');
	}

  // edit_semesters page buttons **************************************************

  // edit semester name and date
  // add classes to semester
  public function editButton(){
      $post = $this->input->post();
      $this->semester_model->update_semester($post);

      $this->session->set_flashdata("add", $post['semester_id']);
      redirect("select_semester");
  }

  // set this semester to current
  public function currentButton(){
      $semester_id = $this->input->post('semester_id');
      $this->semester_model->set_current($semester_id);

      $this->session->set_flashdata("add", $semester_id);
      redirect("select_semester");
  }

  // delete this semester
  // confirm and redirect back to the select semester page
  public function deleteButton(){
    $semester_id = $this->input->post('semester_id');
    $new_current = $this->semester_model->delete($semester_id);
    if($this->semester_model->get_current() == $semester_id) {
      $this->semester_model->set_current($new_current);
      $semester_id = $new_current;
    }

    redirect('edit_semester');

  }

  // ****************************************************************


	public function add_class() {
		$semester_id = $this->input->post('add_semester');
		$course_id = $this->input->post('add_course');
		$this->semester_model->add($semester_id, $course_id);

    $this->session->set_flashdata("add", $semester_id);

		redirect('select_semester');
	}

	public function remove_class() {
		$semester_id = $this->input->post('remove_semester');
		$course_id = $this->input->post('remove_course');
		$this->semester_model->remove($semester_id, $course_id);

    $this->session->set_flashdata("remove", $semester_id);

		redirect('select_semester');
	}

	public function editSemesterPage() {

		$data['semester'] = $this->semester_model->get_semesters()->result_array();

		$data['current_semester'] = $this->semester_model->get_current();

		$data['reg_clearance'] = $this->clearance;
    $this->load->view('group1/templates/header');
    $this->load->view('group1/templates/navbar/navbar', $data);
    $this->load->view('group4/semesters/edit', $data);
    $this->load->view('group1/templates/navbar/navbottom');
    $this->load->view('group1/templates/footer');
	}
}
