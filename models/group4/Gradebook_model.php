<?php
class Gradebook_model extends CI_Model{

	public function __construct()
	{
		$this->load->database();
	}

	public function get_course($courseID){
		$this->db->from('courses');
		$this->db->where('id', $courseID);
		$this->db->limit(1);
		$query = $this->db->get();

		return $query->row_array();
	}

	public function get_courses($id = FALSE, $teacher = FALSE)
	{
		if($id && $teacher){
			$query = $this->db->get_where('courses', array('teacher' => $id));
		}elseif($id){
			$this->db->from('registration');
			$this->db->join('courses', 'registration.course_id = courses.id');
			$this->db->join('semester', 'registration.semester_id = semester.semester_id');
			$this->db->where('registration.user_id', $id);
			$query = $this->db->get();
		}else{
			$query = $this->db->get('courses');
		}
		return $query->result_array();
	}

	public function get_family($id)
	{
		//Get the user's family ID.
		$query = $this->db->get_where('users', array('user_id' => $id));
		$familyID = $query->row_array()["family_id"];

		//Get the user's family members.
		//"SELECT user_id, first_name, last_name FROM users WHERE family_id=" . $family['family_id'] . " AND user_id<>" . $userID . " ORDER BY last_name, first_name"
		$this->db->select('user_id, first_name, last_name');
		$this->db->from('users');
		$this->db->where('family_id', $familyID);
		$this->db->where('user_id !=', $id);
		$this->db->order_by('last_name, first_name');
		$query = $this->db->get();

		return $query->result_array();
	}

	public function is_in_family($parent, $member)
	{
		//Get the user's family ID.
		$query = $this->db->get_where('users', array('user_id' => $parent));
		$familyID = $query->row_array()["family_id"];

		//Check if there is a user with the same id as member in that family.
		$query = $this->db->get_where('users', array('family_id' => $familyID, 'user_id' => $member));
		return $query->result_array();
	}

	public function get_student_class_grades($userID, $courseID)
	{
		$this->db->from('grades');
		$this->db->join('assignments', 'grades.assignment_id = assignments.assignment_id');
		$this->db->where('user_id', $userID);
		$this->db->where('course_id', $courseID);
		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_teacher($courseID)
	{
		$this->db->select('teacher');
		$this->db->from('courses');
		$this->db->where('id', $courseID);
		$this->db->limit(1);
		$query = $this->db->get();

		return $query->row_array()["teacher"];
	}

	public function get_assignment($assignmentID)
	{
		$this->db->from('assignments');
		$this->db->where('assignment_id', $assignmentID);
		$this->db->limit(1);
		$query = $this->db->get();

		return $query->row_array();
	}

	public function get_assignments($courseID)
	{
		$this->db->from('assignments');
		$this->db->where('course_id', $courseID);
		$this->db->order_by('due_date');
		$query = $this->db->get();

		return $query->result_array();
	}

	public function create_assignment($name, $maxPoints, $dueDate, $notes, $courseID)
	{
		//course_id, assignment_name, max_points, due_date, notes
		$data = array(
			'course_id' => $courseID,
			'assignment_name' => $name,
			'max_points' => $maxPoints,
			'due_date' => $dueDate,
			'notes' => $notes
		);

		$this->db->insert('assignments', $data);
    // return primary ID of previous insert
    return $this->db->insert_id();
	}



	public function delete_assignment($assignmentID)
	{
		//Delete the assignment and all associated grades.
		$this->db->where('assignment_id', $assignmentID);
		$this->db->delete('assignments');
		$this->db->where('assignment_id', $assignmentID);
		$this->db->delete('grades');
	}

  public function delete_grades($assignmentID){

		$this->db->where('assignment_id', $assignmentID);
		$this->db->delete('grades');
  }

	public function get_grades($assignmentID)
	{
		$this->db->from('grades');
		$this->db->where('assignment_id', $assignmentID);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_students($courseID)
	{
		$this->db->from('courses');
		$this->db->join('registration', 'registration.course_id = courses.id');
		$this->db->join('users', 'registration.user_id = users.user_id');
		$this->db->where('courses.id', $courseID);
		$this->db->order_by('users.last_name, users.first_name');
		$query = $this->db->get();
		return $query->result_array();
	}

  // ******************************************* me

  // public function get_final_grade($user_id, $course_id){
  //     // get scored_points of all assignments associated with user_id & course_id
  //     $this->db->from('grades');
  //     $this->db->join('assignments', );
  //         // join 'grades' && 'assignments'   --  by assignment_id
  // }
  //**********************************************


  public function update_assignment($assignmentID, $name, $maxPoints, $dueDate, $notes, $courseID)
  {
    //course_id, assignment_name, max_points, due_date, notes
    $data = array(
      'assignment_id' => $assignmentID,
      'course_id' => $courseID,
      'assignment_name' => $name,
      'max_points' => $maxPoints,
      'due_date' => $dueDate,
      'notes' => $notes
    );

    $this->db->replace('assignments', $data);
  }

  // need this **********************************************************
  //*******************************************************************************
  //******************************************************************************************
  //*******************************************************************************************************



  public function student_submit_assignment_notes($user_id, $assignment_id, $comments){

    $this->db->where('user_id', $user_id);
    $this->db->where('assignment_id', $assignment_id);

    $this->db->update('grades', array('notes' => $comments));

  }

	public function update_grade($gradeObj, $assignmentID)
	{
    // grade_assignment page in teacher_gradebook only needs to call this function
		$data = array(
			"scored_points" => intval($gradeObj['scored_points'])
		);
		$this->db->where('user_id', $gradeObj['user_id']);
		$this->db->where('assignment_id', $assignmentID);
		$this->db->update('grades', $data);
	}

	public function insert_grade($gradeObj, $assignmentID)
	{
    // this function gets called on creation of new assignment

    $data = array(
			'assignment_id' => $assignmentID,
			'user_id' => intval($gradeObj['user_id']),
			'scored_points' => intval($gradeObj['scored_points'])
		);
		$this->db->insert('grades', $data);
	}

  //***************************************************************************************************************
  //*****************************************************************************************************
  //****************************************************************************************
  //******************************************************************************

  public function save_to_transcripts($data){

    $this->db->insert('transcripts', $data);

  }

  public function get_transcript($user_id){

    $this->db->where('user_id', $user_id);
    $this->db->order_by('semester_id', 'ASC');
    // $this->db->group_by('semester_id');

    $transcripts = $this->db->get('transcripts')->result_array();

    $semester = @$transcripts[0]['semester_id'];


    $final_array = array();

    $temp_array = array();

    foreach ($transcripts as $class) {

      if($class['semester_id'] != $semester){
          array_push($final_array, $temp_array);
          $temp_array = array();
          $semester = $class['semester_id'];
      }

      array_push($temp_array, $class);

    }
        array_push($final_array, $temp_array);

    return $final_array;

  }

  public function edit_transcript($user_id, $semester_id, $course_id, $final_grade){
    $this->db->where('user_id', $user_id);
    $this->db->where('semester_id', $semester_id);
    $this->db->where('course_id', $course_id);

    $this->db->update('transcripts', array("final_grade" => $final_grade));
  }

}
?>
