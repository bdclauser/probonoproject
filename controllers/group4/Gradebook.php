<?php
class Gradebook extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('group4/gen_model');
		$this->load->model('group4/gradebook_model');
		$this->load->model('group4/semester_model');
		$this->load->model('group4/registration_model');
		$this->load->helper('url_helper');
		$this->load->library('session');
		$this->load->model('group1_models/user_model'); // I can now access the User_model class ($this->User_model)
		$this->clearance = $this->user_model->getPermission($this->session->userID); // grab the users permission from the db and store it in clearance
	}

	public function set($id)
	{
		$_SESSION['userID'] = $id;
	}

	public function index()
	{
		$data['title'] = 'Gradebook';

		$userID = $_SESSION['userID'];

		$user = $this->gen_model->get_user($userID);

		// if($user["isAdmin"]){
		// 	$data['returnT'] = $this->gradebook_model->get_courses();
		// }

    if($user["isTeacher"]){
			//Retrieve courses that are taught by this teacher.
			$data['returnT'] = $this->gradebook_model->get_courses($userID, true);
		}

		//If a student or a parent checking on a student...
		// $parentView = @$_REQUEST["parentview"];
		// $data['parentView'] = $parentView;
		if($user["isStudent"]){
			//$query = "SELECT r.*, c.course_name FROM registration AS r JOIN courses AS c ON r.course_id=c.id WHERE r.user_id=";
			// if($parentView){
			// 	//Double check that the family member belongs to the same family as the parent.
			// 	$isInFamily = $this->gradebook_model->is_in_family($userID, @$_REQUEST["member"]);
			// 	if($isInFamily){
			// 		$data['returnS'] = $this->gradebook_model->get_courses(@$_REQUEST["member"]);
			// 	}
			// }else{
				$data['returnS'] = $this->gradebook_model->get_courses($userID);
			// };
		}

		//If the user is a parent, get a list of other family members.
		if($user["isParent"]){
			$data['returnP'] = $this->gradebook_model->get_family($userID);
		}

		//Add information to the data array.
		$data['userID'] = $userID;
		$data['user'] = $user;

    ///

		$data['reg_clearance'] = $this->clearance;
    $this->load->view('group1/templates/header');
    $this->load->view('group1/templates/navbar/navbar', $data);

    $this->load->view('group4/gradebook/index', $data);

    $this->load->view('group1/templates/navbar/navbottom');
    $this->load->view('group1/templates/footer');

    ///

	}

	public function student_gradebook()
	{
    $this->load->helper('date');

		$data['title'] = 'Gradebook';


    $course = $this->input->post('course');
		$courseID = $course ? $course : $this->session->flashdata('course_id');

    $id = $this->input->post('user_id');
		$userID = $id ? $id : $this->session->flashdata('user_id');

		// $parentView = @$_REQUEST["parentview"];

    // we need this for parent
		// if($parentView){
		// 	//Double check that the family member belongs to the same family as the parent.
		// 	$isInFamily = $this->gradebook_model->is_in_family($userID, @$_REQUEST["member"]);
		// 	if($isInFamily){
		// 		$data['grades_list'] = $this->gradebook_model->get_student_class_grades(@$_REQUEST["member"], $courseID);
		// 	}
		// }

    $data['now'] = now('America/New_York');
    $data['grades_list'] = $this->gradebook_model->get_student_class_grades($userID, $courseID);

    ///

			$data['reg_clearance'] = $this->clearance;
    $this->load->view('group1/templates/header');
    $this->load->view('group1/templates/navbar/navbar', $data);


    $this->load->view('group4/gradebook/student', $data);


    $this->load->view('group1/templates/navbar/navbottom');
    $this->load->view('group1/templates/footer');

    ///
	}

	public function teacher_gradebook()
	{
		$data['title'] = 'Gradebook';

    $id = $this->input->post('course');
    $courseID = $id ? $id : $this->session->flashdata('course');

    $user = $this->input->post('teacher_id');
		$userID = $user ? $user : $this->session->userID;

		//Confirm the course is taught by this teacher.
		$this->is_taught_by($userID, $courseID);

		//If delete has been passed in, delete an assignment.
		if(@$_REQUEST['delete'] && @$_REQUEST['assignment']){
			$this->gradebook_model->delete_assignment(@$_REQUEST['assignment']);
		}

		//If the 'saved-grades' query is in the URL, it's coming from grades_teacher.php.
		$savedGrades = @$_REQUEST['saved-grades'];
		if($savedGrades){
			$this->save_grades($savedGrades, $courseID);
		}

		$data['assignments'] = $this->gradebook_model->get_assignments($courseID);
		$data['courseID'] = $courseID;

    ///

			$data['reg_clearance'] = $this->clearance;
    $this->load->view('group1/templates/header');
    $this->load->view('group1/templates/navbar/navbar', $data);


    $this->load->view('group4/gradebook/teacher', $data);


    $this->load->view('group1/templates/navbar/navbottom');
    $this->load->view('group1/templates/footer');

    ///
	}

	public function new_assignment()
	{
		$data['title'] = 'Gradebook';

		$courseID = $this->input->post('course');
		$userID = $this->session->userID;

		//Confirm the course is taught by this teacher.
		$this->is_taught_by($userID, $courseID);

		$data['course'] = $this->gradebook_model->get_course($courseID);

		$data['success'] = "";

		/*
		 if statement checks if form was submited, if true then it proceeds to retrieve input
		 data and perform error checking and update assignment in database
		 */
		if($this->input->post('submit')){
			$name = $this->input->post('name');
			$maxPoints = $this->input->post('maxPoints');
			$dueDate = $this->input->post('dueDate');
			$notes = $this->input->post('notes');
			$courseID = $this->input->post('course');
			$error = '';

			if($name == '' ){
				$error = $error.' Please enter a title.';
			}
			if(($maxPoints < 0 || $maxPoints > 30000)){
				$error = $error.' Please enter a Maximum Point value of 0 or greater and less than 30000.';
			}
			if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $dueDate) && !preg_match('/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{4}$/', $dueDate)){
				$error = $error.' Please use mm/dd/yyyy format.';
			}
			if($error == ''){
				if(preg_match('/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{4}$/', $dueDate)){
					$dueDate = $this->dateToSql($dueDate);
				}
				$assignment_id = $this->gradebook_model->create_assignment($name, $maxPoints, $dueDate, $notes, $courseID);


        // *******************************************************************
        //this code inserts grade of null for each student in class


        $userIDs = $this->gradebook_model->get_students($courseID);


        $gradeObj = array(
          'array' => array(),
          'assignment_id' => $assignment_id
        );

        for($i = 0; $i < count($userIDs); $i++){

      			$grade = array(
                'user_id' => $userIDs[$i]['user_id'],  // get all user_id's in class
                'scored_points' => null
            );

      			array_push($gradeObj['array'], $grade);
    		};


        foreach($gradeObj['array'] AS $gradeArray){
            $this->gradebook_model->insert_grade($gradeArray, $assignment_id);
        };

        //*****************************************************************


				// need to develop plan of action for user after changes are successfully made
        $flash = array(
          "new_assignment" => true,
          "course" => $courseID
        );

        $this->session->set_flashdata($flash);

        redirect('teacher_gradebook');
			}
			else{
				echo $error;
			}
		}

		$data['courseID'] = $courseID;

    /////

		$data['reg_clearance'] = $this->clearance;
    $this->load->view('group1/templates/header');
    $this->load->view('group1/templates/navbar/navbar', $data);


		$this->load->view('group4/gradebook/new_assignment', $data);


    $this->load->view('group1/templates/navbar/navbottom');
    $this->load->view('group1/templates/footer');

    /////

	}

	public function edit_assignment()
	{
		$data['title'] = 'Gradebook';

		$courseID = $this->input->post('course');
		$assignmentID = $this->input->post('assignment');
		$userID = $this->session->userID;

		//Confirm the course is taught by this teacher.
		$this->is_taught_by($userID, $courseID);

		$data['course'] = $this->gradebook_model->get_course($courseID);

		$data['success'] = "";

		if($this->input->post('submit')){
			$name = $this->input->post('name');
			$maxPoints = $this->input->post('maxPoints');
			$dueDate = $this->input->post('dueDate');
			$notes = $this->input->post('notes');
			$courseID = $this->input->post('course');
			$error = '';

			if($name == '' ){
				$error = $error.' Please enter a title.';
			}
			if(($maxPoints < 0 || $maxPoints > 30000)){
				$error = $error.' Please enter a Maximum Point value of 0 or greater and less than 30000.';
			}
			if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $dueDate) && !preg_match('/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{4}$/', $dueDate)){
				$error = $error.' Please use mm/dd/yyyy format.';
			}
			if($error == ''){
				if(preg_match('/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{4}$/', $dueDate)){
					$dueDate = $this->dateToSql($dueDate);
				}
				$this->gradebook_model->update_assignment($assignmentID, $name, $maxPoints, $dueDate, $notes, $courseID);

				// need to develop plan of action for user after changes are successfully made
        $flash = array(
          "edit_assignment" => true,
          "course" => $courseID
        );

        $this->session->set_flashdata($flash);

        redirect('teacher_gradebook');
			}
			else{
				echo $error;
			}
		}
		$data['courseID'] = $courseID;
		$data['assignment'] = $this->gradebook_model->get_assignment($assignmentID);


    ///

			$data['reg_clearance'] = $this->clearance;
    $this->load->view('group1/templates/header');
    $this->load->view('group1/templates/navbar/navbar', $data);


		$this->load->view('group4/gradebook/edit_assignment', $data);


    $this->load->view('group1/templates/navbar/navbottom');
    $this->load->view('group1/templates/footer');

    ///
	}

	public function grade_assignment()
	{
		$data['title'] = 'Gradebook';

    $id = $this->input->post('course');
    $courseID = $id ? $id : $this->session->flashdata('course');

		$userID = $_SESSION['userID'];

    $assignment_id = $this->input->post('assignment');
		$assignmentID = $assignment_id ? $assignment_id : $this->session->flashdata('assignment_id');

		//Confirm the course is taught by this teacher.
		$this->is_taught_by($userID, $courseID);

		//Retrieve the grades for this assignment.
		$grades = $this->gradebook_model->get_grades($assignmentID);

		//Retrieve users in this class.
		$students = $this->gradebook_model->get_students($courseID);

		//Retrieve assignment information
		$assignment = $this->gradebook_model->get_assignment($assignmentID);





		//Build a table of grades.
		$tableHTML = "<form action='save_grades' method='post' id='grade_assignment_form'>
                      <input type='hidden' name='course' value='".$courseID."'>
                      <input type='hidden' name='assignment_id' value='".$assignmentID."'>";




		//For each student in the class, create a row.
		foreach($students as $row){
			//If a grade already exists for this student, record it as $existingGrade and set update to 1;
			//The existing grade will be used to populate that student's field.
			//Update will be passed along to determine if the grade should be inserted or updated.
			$existingGrade = "";
			$update = 0;
			foreach($grades AS $grade){
				if($grade["user_id"] == $row["user_id"]){
					$existingGrade = $grade["scored_points"];
					$update = 1;
					break;
				};

			};
			//Build the row.
			$tableHTML .=
			'<tr>
				<td>' . $row["last_name"] . ', ' . $row["first_name"] . '</td>
				<td>
            <input class="form-control" type="number" min="0" max="' . $assignment['max_points'] . '" name="points[]" value="' . $existingGrade . '">
            <input class="form-control" type="hidden" name="userID[]" value="'.$row["user_id"].'">
            <input class="form-control" type="hidden" name="update[]" max="1" min="0" value="' . $update . '">
        </td>
        <td>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#'.$row['user_id'].'">Assignment</button>
        </td>
			</tr>';
		}

    $tableHTML .= "</form>";

    foreach($grades as $grade){
      $tableHTML .= '
        <div class="modal fade" id="'.$grade['user_id'].'" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4><strong>Student Assignment Submission</strong></h4>
                </div>
                <div class="modal-body">'.
                  $grade['notes']
              .'</div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
          </div>
        </div>
      ';
    }
		$data['tableHTML'] = $tableHTML;
		$data['assignment'] = $assignment;
		$data['courseID'] = $courseID;


    ////
			$data['reg_clearance'] = $this->clearance;
    $this->load->view('group1/templates/header');
    $this->load->view('group1/templates/navbar/navbar', $data);


		$this->load->view('group4/gradebook/grade_assignment', $data);


    $this->load->view('group1/templates/navbar/navbottom');
    $this->load->view('group1/templates/footer');
    ////
	}

	public function save_grades()
	{

    $grades = $this->input->post('points');
    $userIDs = $this->input->post('userID');
    $update = $this->input->post('update');//This determines whether or not this grade needs to be inserted or updated.
    // print_r($update);

    $courseID = $this->input->post('course');

    $gradeObj = array(
      'array' => array(),
      'assignment_id' => $this->input->post('assignment_id')
    );




    for($i = 0; $i < count($grades); $i++){

  			$grade = array(
            'user_id' => $userIDs[$i],
            'scored_points' => $grades[$i],
            'update' => $update[$i]
        );

  			array_push($gradeObj['array'], $grade);
		};
    // $this->gradebook_model->insert_grade($gradeArray, $assignmentID);

    $parsedGrades = $gradeObj;


		//The grades are urlencoded JSON. Decode them into an associated array and get the assignment id.
		// $parsedGrades = json_decode(urldecode($savedGrades), true);
		$assignmentID = intval($parsedGrades['assignment_id']);


		//Loop through and either write an update or insert query.
		foreach($parsedGrades['array'] AS $gradeArray){
			// if($gradeArray['update'] && $gradeArray['scored_points']){

        // useful
				$this->gradebook_model->update_grade($gradeArray, $assignmentID);

      //
			// }elseif($gradeArray['scored_points']){
      //
      //   // useful
			// 	$this->gradebook_model->insert_grade($gradeArray, $assignmentID);
      //
      //
			// };
		};


    $flash = array(
      "course" => $courseID,
      "assignment_id" => $assignmentID,
      "flash_success" => TRUE
    );

    $this->session->set_flashdata($flash);

    redirect('teacher_grade_assignment');
		// header("Location: " . base_url() . "index.php/gradebook/teacher?course=" . $courseID);

	}

	public function is_taught_by($userID, $courseID)
	{
		$user = $this->gen_model->get_user($userID);

		$teacher = $this->gradebook_model->get_teacher($courseID);
		if($userID != $teacher && !$user['isAdmin']){
			header("Location: " . base_url() . "index.php/gradebook");

		}
	}

	public function dateToSql($d1){
		$year = substr($d1, -4);
		$month = substr($d1, 0, -8);
		$day = substr($d1, 3, -5);
		return $year.'-'.$month.'-'.$day;
	}


  public function student_submit_assignment_page(){

    $data['user_id'] = $this->input->post('user_id');
    $data['assignment_id'] = $this->input->post('assignment_id');
    $data['assignment_name'] = $this->input->post('assignment_name');
    $data['course_id'] = $this->input->post('course_id');



			$data['reg_clearance'] = $this->clearance;
    $this->load->view('group1/templates/header');
    $this->load->view('group1/templates/navbar/navbar', $data);


		$this->load->view('group4/gradebook/submit_assignment_page', $data);


    $this->load->view('group1/templates/navbar/navbottom');
    $this->load->view('group1/templates/footer');

  }

  public function student_submit_assignment(){


    $user_id = $this->input->post('user_id');
    $assignment_id = $this->input->post('assignment_id');
    $comments = $this->input->post('assignment_comments');
    $course_id = $this->input->post('course_id');


    $this->gradebook_model->student_submit_assignment_notes($user_id, $assignment_id, $comments);

    $flash = array(
      "submitted" => true,
      "course_id" => $course_id,
      "user_id" => $user_id
    );

    $this->session->set_flashdata($flash);


    redirect('student_gradebook');


  }

  public function pick_student_course(){
      $data['student_id'] = $this->input->post('student_id');

      $data['returnS'] = $this->gradebook_model->get_courses($data['student_id']);

  			$data['reg_clearance'] = $this->clearance;
      $this->load->view('group1/templates/header');
      $this->load->view('group1/templates/navbar/navbar', $data);


  		$this->load->view('group4/gradebook/pick_student_course', $data);


      $this->load->view('group1/templates/navbar/navbottom');
      $this->load->view('group1/templates/footer');

  }



    public function pick_teacher_course(){
        $data['teacher_id'] = $this->input->post('teacher_id');

        $data['returnT'] = $this->gradebook_model->get_courses($data['teacher_id'], true);

    			$data['reg_clearance'] = $this->clearance;
        $this->load->view('group1/templates/header');
        $this->load->view('group1/templates/navbar/navbar', $data);


    		$this->load->view('group4/gradebook/pick_teacher_course', $data);


        $this->load->view('group1/templates/navbar/navbottom');
        $this->load->view('group1/templates/footer');

    }


    public function submit_final_grade(){

          if($this->clearance[0] || $this->clearance[1]){
                $course_id = $this->input->post('course');

                $students = $this->gradebook_model->get_students($course_id);
                // print_r($students);


                $semester_id = $this->semester_model->get_current();
                $semester_name = $this->semester_model->get_semester_name($semester_id);

                $students_array = array();

                foreach($students as $student){

                  $teacher = $this->user_model->getUserInfo($student['teacher']);

                  // print_r($this->gradebook_model->get_student_class_grades($student['user_id'], $student['id']));
                  $class_assignments = $this->gradebook_model->get_student_class_grades($student['user_id'], $student['id']);

                  $max_points = 0;
                  $scored_points = 0;


                  foreach($class_assignments as $assign){
                      $max_points += $assign['max_points'];
                      $scored_points += $assign['scored_points'];
                  }




                  $array = array(
                    'student_name' => $student['last_name'].', '.$student['first_name'],
                    'student_id' => $student['user_id'],
                    'course_id' => $student['id'],
                    'course_name' => $student['course_name'],
                    'teacher_name' => $teacher->last_name.', '.$teacher->first_name,
                    'teacher_id' => $teacher->user_id,
                    'semester_id' => $semester_id,
                    'semester_name' => $semester_name, // get semester
                    'final_grade' => @round(($scored_points / $max_points), 4)*100
                  );

                  array_push($students_array, $array);
                }


                $data['students_array'] = $students_array;
          			$data['reg_clearance'] = $this->clearance;

                $this->load->view('group1/templates/header');
                $this->load->view('group1/templates/navbar/navbar', $data);


            		$this->load->view('group4/gradebook/set_final_grades_page', $data);


                $this->load->view('group1/templates/navbar/navbottom');
                $this->load->view('group1/templates/footer');

          } else {
            redirect('login');
          }
    }


    public function save_finals(){
      $letter_grade = $this->input->post('letter_grade');

      $students_array = $this->session->flashdata('students_array');


      // print_r('LETTER_GRADE');
      // print_r($letter_grade);
      // echo '<br><br>';
      // print_r('STUDENTS_ARRAY');
      // print_r($students_array);
      // echo '<br><br>';

      $course_id = $students_array[0]['course_id'];

      // save this to the transcript database
      foreach ($students_array as $student) {
        $data = array(
          'student_name' => $student['student_name'],
          'user_id' => $student['student_id'],
          'course_id' => $student['course_id'],
          'course_name' => $student['course_name'],
          'teacher_name' => $student['teacher_name'],
          'teacher_id' => $student['teacher_id'],
          'semester_id' => $student['semester_id'],
          'semester_name' => $student['semester_name'], // get semester
          'final_grade' => $letter_grade[$student['student_id']]
        );

        $this->gradebook_model->save_to_transcripts($data);
      }


      // print_r('Assignments');
      // delete all grades associated with course
      $assignments = $this->gradebook_model->get_assignments($course_id);
      // print_r($assignments);
      // echo '<br><br>';

      foreach ($assignments as $assignment) {
          $this->gradebook_model->delete_grades($assignment['assignment_id']);
      }


      // unregister student from course
      $this->registration_model->unregister_all_students($course_id);


      // *** build a way for students and to view transcripts


      // *** should I make a way for admin to edit transcript? - probably, what if teacher screws it up?


      // flash success message to gradebook on submit
      $flash = array(
        'final_grades_submitted' => TRUE
      );

      $this->session->set_flashdata($flash);
      redirect('gradebook');
    }



    public function view_transcript(){

      $user_id = $this->input->post('user_id');

      $data['semesters'] = $this->gradebook_model->get_transcript($user_id);
      // print_r($data['transcript']);
      $data['reg_clearance'] = $this->clearance;

      $this->load->view('group1/templates/header');
      $this->load->view('group1/templates/navbar/navbar', $data);


      $this->load->view('group4/gradebook/view_transcript_page', $data);


      $this->load->view('group1/templates/navbar/navbottom');
      $this->load->view('group1/templates/footer');

    }

    public function edit_transcript(){


      $id = $this->input->post('user_id');
      $user_id = $id ? $id : $this->session->flashdata('user_id');

      $data['semesters'] = $this->gradebook_model->get_transcript($user_id);
      $data['reg_clearance'] = $this->clearance;


      //****************
      $this->load->view('group1/templates/header');
      $this->load->view('group1/templates/navbar/navbar', $data);


      $this->load->view('group4/gradebook/edit_transcript_page', $data);


      $this->load->view('group1/templates/navbar/navbottom');
      $this->load->view('group1/templates/footer');
      //****************
    }

    public function submit_new_transcript(){

        $user_id = $this->input->post('user_id');
        $semester_id = $this->input->post('semester_id');
        $course_id = $this->input->post('course_id');
        $final_grade = $this->input->post('new_final');

        $this->gradebook_model->edit_transcript($user_id, $semester_id, $course_id, $final_grade);

        $this->session->set_flashdata('user_id', $user_id);
        redirect('edit_transcript');
    }

}
?>
