<?php

	class Teacher_classes_model extends CI_Model {

	    public function __construct() {

        	parent::__construct();
        	$this->load->database();

    	}

		// public function get_current_classes2() {
    //
    //
    //   $this->
		// 	$query = $this->db->get('teacher_table');
    //
		// 	return $query->result();
    //
		// }

		// public function get_past_classes() {
    //
		// 	$query = $this->db->get('teacher_table');
    //
		// 	return $query->result();
    //
		// }


		// gets info for userID
		// public function get_current_classes($userID) {
    //
    //     	$this->db->select('current_courses');
    //     	$this->db->from('teacher_table');
    //     	$this->db->where('user_id', $userID);
    //     	$query = $this->db->get()->result();
    //
    //     	return $query[0];
    //
		// }
    public function get_current_classes($userID) {

          $this->db->select('id');
          $this->db->from('courses');
          $this->db->where('teacher', $userID);
          $query = $this->db->get()->result_array();

          return $query;

    }


		// gets course for userID
		public function get_course_info($idArr) {

        	$this->db->select('course_name, id');
        	$this->db->from('courses');
        	$this->db->where_in('id', $idArr );

        	$query = $this->db->get();
        	return $query->result_array();

//			$result = "";
			//echo "<br>" . $query->num_rows() . "<br>";
//			if($query->num_rows() > 0)
//				$result = $query->result_array();
//			else
//				$result = "No result";

			//echo "<br><br>HERE: ";
			//print_r($result);

        	//return $query[0];

//        	return $result;

		}


		// gets course for userID
		public function get_course_details($courseID) {

        	$this->db->select('*');
        	$this->db->from('courses');
        	$this->db->where('id', $courseID);

					$query = $this->db->get();
        	return $query->result_array();

		}


    // get all user info (user profile and settings pages)
    public function get_course_info_all($idArr)
    {

        // going to need to do a join to get family_id & misc_duties
        $this->db->where_in('id', $idArr );
        $query = $this->db->get('courses')->result();

        // print_r($query);
        return $query[0];
    }


		function result_getall2(){

			$this->db->select('tblanswers.*,credentials.*');
			$this->db->from('tblanswers');
			$this->db->join('credentials', 'tblanswers.answerid = credentials.cid', 'left');
			$query = $this->db->get();
			return $query->result();

		}


		function result_getall(){

			$this->db->select('tblanswers.*,credentials.*');
			$this->db->from('tblanswers');
			$this->db->join('credentials', 'tblanswers.answerid = credentials.cid', 'left');
			$query = $this->db->get();
			return $query->result();

		}





	}

?>
