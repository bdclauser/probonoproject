<?php

class Registration_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_semesters()
    {
    	$query = $this->db->get('semester');
        return $query;
    }

    public function add($user_id, $course_id, $semester_id)
    {
      $add = FALSE;
      // check courses num_students vs max_students
      $this->db->select('num_students, max_students, max_waitlist, current_waitlist, waitlist_students');
      $this->db->where('id', $course_id);
      $result_array = $this->db->get('courses')->result_array()[0];

      if ($result_array['num_students'] < $result_array['max_students']){
        // increment num_students
        $temp = ++$result_array['num_students'];

        $this->db->where('id', $course_id);
        $this->db->update('courses', array('num_students' => $temp));

        // add user to course
        $add = TRUE;

      } else if ($result_array['num_students'] >= $result_array['max_students']){
        // check waitlist for space
        if ($result_array['current_waitlist'] < $result_array['max_waitlist']){
          // increment waitlist
          $temp = ++$result_array['current_waitlist'];

          $this->db->where('id', $course_id);
          // append student_id to end of waitlist_students

          if($result_array['waitlist_students']){
            $waitArray = explode(',', $result_array['waitlist_students']);

            $waitArray[count($waitArray)] = $user_id;
            $waitArray = implode(',', $waitArray);
          } else {
            $waitArray = ''.$user_id;
          }


          $this->db->update('courses', array('current_waitlist' => $temp, 'waitlist_students' => $waitArray));
            // add user to course
            $add = TRUE;
        }
      }

      // add user
      if($add){
          $this->db->insert('registration', array('user_id' => $user_id, 'course_id'=>$course_id, 'semester_id'=>$semester_id));
      }

    }

    public function getTimes($user_id){
      $this->db->select('time1start, semester_id');

      $array = $this->db->from('registration')->join('courses', 'registration.course_id=courses.id')->
      where('user_id', $user_id)->get()->result_array();

      return $array;
    }

    public function unregister_all_students($course_id){
      $this->db->where('course_id', $course_id);
      $this->db->delete('registration');
    }

    public function remove($user_id, $course_id, $semester_id)
    {
      // get current course InfiniteIterator
      $this->db->select('num_students, max_students, max_waitlist, current_waitlist, waitlist_students');
      $this->db->where('id', $course_id);
      $result_array = $this->db->get('courses')->result_array()[0];


      // but***  what if there are waitlisted students and this student isn't one of them
      // also if enrolled student cancels and there are waitlisted students, the next inline should be enrolled automatically


      if ($result_array['waitlist_students']){ // if there is a waitlist

            $waitArray = explode(',', $result_array['waitlist_students']);

                for($i = 0; $i < count($waitArray); $i++){
                  if($waitArray[$i] == $user_id){ // if student is on waitlist

                        // remove them from waitlist_students
                        unset($waitArray[$i]);

                        $waitArray = array_values($waitArray); // reindex array

                        if(count($waitArray) == 0){
                          $waitArray = NULL;
                        } else {
                          // implode array
                          $waitArray = implode(',', $waitArray);
                        }

                        // decrement current_waitlist
                        $temp = --$result_array['current_waitlist'];

                        // update courses
                        $this->db->where('id', $course_id);
                        $this->db->update('courses', array('current_waitlist' => $temp, 'waitlist_students' => $waitArray));
                        // allow bottom query to execute
                        break;
                  } else if($i == (count($waitArray)-1)) {
                    // what if he's not on the waitlist?
                    // register #1 on waitlist

                      // shift $waitArray
                      array_shift($waitArray);
                      // implode array
                      $waitArray = implode(',', $waitArray);

                      // decrement current_waitlist
                      $temp = --$result_array['current_waitlist'];
                    // update courses
                    $this->db->where('id', $course_id);
                    $this->db->update('courses', array('current_waitlist' => $temp, 'waitlist_students' => $waitArray));

                    // allow bottom query to execute
                  }
                }
      } else { // if there is not a waitlist
        // decrement num_students
        $temp = --$result_array['num_students'];

        // update courses
        $this->db->where('id', $course_id);
        $this->db->update('courses', array('num_students' => $temp));

        // allow bottom query to execute
      }


    	$this->db->delete('registration', array('user_id' => $user_id, 'course_id'=>$course_id, 'semester_id'=>$semester_id));
    }


	public function get_teach()
	{
		$query = $this->db->where("teacher", $this->session->userID)->get("courses")->result_array();
    	$data['current_courses'] = $query;
		return $data;
	}

    public function get_data($user_id, $semester_id)
    {
    	$query_available = $this->db->from('registration')->join('courses', 'registration.course_id=courses.id')->
    	join('users', 'users.user_id=courses.teacher')->where(array("registration.user_id" => $user_id, "registration.semester_id" => $semester_id))
    	->get()->result_array();
    	$data['current_courses'] = $query_available;
      // print_r();
    	$where[] = 0;
	   	foreach ($query_available as $row) {
    		$where[] = $row['course_id'];
    	}

    	// $query_all = $this->db->from('courses')->
    	// join('users', 'users.user_id=courses.teacher')->where_not_in('id', $where)->get()->result_array();


    	$this->db->from('courses')->
    	join('users', 'users.user_id=courses.teacher')->
      join('available_classes', 'available_classes.course_id=courses.id')->
      where_not_in('id', $where);
      $query_all = $this->db->where('semester_id', $semester_id)->get()->result_array();
    	$data['all_courses'] = $query_all;

    	$query_semester = $this->db->where('semester_id', $semester_id)->get('semester')->row_array();
    	$data['semester_info'] = $query_semester;

    	$query_user = $this->db->where('user_id', $user_id)->get('users')->row_array();
    	$data['user_info'] = $query_user;

    	return $data;
    }

    public function get_name($user_id)
    {
    	$query = $this->db->where('user_id', $this->session->userID)->get('users');
    	$user_data = $query->row_array();
    	$readableName = sprintf("%s %s %s", $user_data["first_name"],
    			$user_data["middle_initial"], $user_data["last_name"]);
    	return $readableName;
    }

    // gets permission associated with $userID
    public function getPermission($userID) {
    	$this->db->select ( 'permission' );
    	$this->db->from ( 'users' );
    	$this->db->where ( 'user_id', $userID );
    	$query = $this->db->get ()->result ();

    	return $query [0]->permission;
    }

    public function getPassword($user_id)
    {
    	$this->db->select('password');
    	$this->db->where('user_id', $user_id);

    	$query = $this->db->get('users')->result();

    	return $query[0]->password;
    }

    public function validate($userID, $password)
    {
    	$array = array('user_id' => $userID, 'password' => $password);
    	$this->db->where($array);
    	$query = $this->db->get('users');


    	if ($query->result_id->num_rows == 1) {
    		return true;
    	} else {
    		return false;
    	}
    }

    public function get_user()
    {
    	$query = $this->db->where('user_id', $this->session->userID)->get('users');
    	return $query->row_array();
    }
}
