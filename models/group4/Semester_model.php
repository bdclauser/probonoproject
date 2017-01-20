<?php

class Semester_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function update_semester($post)
    {
        $data = array(
            'semester_name' => $post['semester_name'],
            'start_date' => $post['start_date'],
            'end_date' => $post['end_date'],
        );
        $this->db->where("semester_id", $post['semester_id']);
        $this->db->update('semester', $data);
    }

    public function add_semester()
    {
      $data = array(
        'semester_name' => $this->input->post('semester_name'),
        'start_date' => $this->input->post('start_date'),
        'end_date' => $this->input->post('end_date'),
      );

      $this->db->insert('semester', $data);
    }


    public function get_semesters()
    {
    	$query = $this->db->get('semester');
        return $query;
    }

    public function add($semester_id, $course_id)
    {
    	$this->db->insert('available_classes', array('semester_id' => $semester_id, 'course_id'=>$course_id));
    }

    public function remove($semester_id, $course_id)
    {
    	$this->db->delete('available_classes', array('semester_id' => $semester_id, 'course_id'=>$course_id));
    }

    public function delete($semester_id)
    {
    	$this->db->delete('semester', array('semester_id' => $semester_id));
    	$query = $this->db->get('semester')->row_array();

    	return $query['semester_id'];
    }

    public function set_current($semester_id)
    {
    	$this->db->update('semester', array('current' => 0));


      $this->db->where("semester_id", $semester_id);
      $this->db->update("semester", array("current" => 1));
    }

    public function get_current()
    {
       $this->db->where("current", 1);
       $query = $this->db->get("semester")->row_array();
    	 return $query['semester_id'];
    }

    public function get_semester_name($semester_id)
    {
       $this->db->where("current", 1);
       $query = $this->db->get("semester")->row_array();
    	 return $query['semester_name'];
    }

    public function get_data($semester_id)
    {
    	$query_available = $this->db->from('available_classes')->join('courses', 'available_classes.course_id=courses.id')->
    	join('users', 'users.user_id=courses.teacher')->where("semester_id", $semester_id)->get()->result_array();
    	$data['current_courses'] = $query_available;

    	$where[] = 0;
	   	foreach ($query_available as $row) {
    		$where[] = $row['course_id'];
      }

    	$query_all = $this->db->from('courses')->
    	join('users', 'users.user_id=courses.teacher')->where_not_in('id', $where)->get()->result_array();
    	$data['all_courses'] = $query_all;

    	$query_semester = $this->db->where('semester_id', $semester_id)->get('semester')->row_array();
    	$data['semester_info'] = $query_semester;

    	return $data;
    }
//     // everything from here down is totally redundant... sorry about that.
//     public function get_name($user_id)
//     {
//     	$query = $this->db->where('user_id', $this->session->userID)->get('users');
//     	$user_data = $query->row_array();
//     	$readableName = sprintf("%s %s %s", $user_data["first_name"],
// 			$user_data["middle_initial"], $user_data["last_name"]);
//     	return $readableName;
//     }
//
   // gets permission associated with $userID
   public function getPermission($userID) {
 	$this->db->select ( 'permission' );
 	$this->db->from ( 'users' );
 	$this->db->where ( 'user_id', $userID );
 	$query = $this->db->get ()->result ();

 	return $query [0]->permission;
 }
//
//     public function getPassword($user_id)
//     {
//     	$this->db->select('password');
//     	$this->db->where('user_id', $user_id);
//
//     	$query = $this->db->get('users')->result();
//
//     	return $query[0]->password;
//     }
//
//     public function validate($userID, $password)
//     {
//     	$array = array('user_id' => $userID, 'password' => $password);
//     	$this->db->where($array);
//     	$query = $this->db->get('users');
//
//
//     	if ($query->result_id->num_rows == 1) {
//     		return true;
//     	} else {
//     		return false;
//     	}
//     }
}
