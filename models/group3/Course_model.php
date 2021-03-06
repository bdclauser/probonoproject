<?php



class Course_model extends CI_Model

{



    public function __construct()

    {

        parent::__construct();

        $this->load->database();

        $this->load->model('group1_models/user_model');

    }





    // Get all info of all active courses

    public function all_course_info(){



        //$this->db->where('cancelled', 0);

        $this->db->order_by('cancelled ASC, course_name ASC');



        $query = (array)$this->db->get('courses')->result();



        // convert each inner object to array

        foreach($query as &$object){

            $object = (array)$object;



            $user = (array)$this->user_model->getUserInfo($object['teacher']);

            // print_r($user);

            $object['teacher'] = $user['first_name'].' '.$user['last_name'];

        }

        unset($object);



        return $query;

    }





    public function insert_new_class($class_info){





        $homework_hours = @$class_info['homework_hours'];



        if($homework_hours > 0){

            $homework = 1;

        }

        else{

            $homework = 0;

        }





        $values = array(

            'course_name'=>@$class_info['course_name'],

            'teacher'=>@$class_info['teacher'],

            'category'=>@$class_info['category'],

            'description' =>@$class_info['description'],

            'time1start'=>@$class_info['time1start'],

	        'time1end'=>@$class_info['time1end'],

            'time2start'=>@$class_info['time2start'],

            'time2end'=>@$class_info['time2end'],

            'tuition'=>@$class_info['tuition'],

            'fees'=>@$class_info['fees'],

            'min_gradelevel'=>@$class_info['min_gradelevel'],

            'max_gradelevel'=>@$class_info['max_gradelevel'],

            'min_students'=>@$class_info['min_students'],

            'max_students'=>@$class_info['max_students'],

            'max_waitlist'=>@$class_info['max_waitlist'],

            'homework_hours'=>@$homework_hours,

            'homework'=>@$homework,

            'notes'=>@$class_info['notes'],

            'highschool_class'=>@$class_info['highschool_class'],

            'cancelled'=>@$class_info['cancelled']

        );



        $this->db->set($values);

        $this->db->insert('courses');

    }



    public function get_one_course($course_id){

        $this->db->where('id', $course_id);



        $query = $this->db->get('courses')->result();

        // print_r($query);

        return $query[0];

    }





    public function update_course($class_info){



        $homework_hours = @$class_info['homework_hours'];



        if($homework_hours > 0){

            $homework = 1;

        }

        else{

            $homework = 0;

        }



        $array = array(

            'course_name'=>@$class_info['course_name'],

            'teacher'=>@$class_info['teacher'],

            'category'=>@$class_info['category'],

            'description' =>@$class_info['description'],

            'time1start'=>@$class_info['time1start'],

	        'time1end'=>@$class_info['time1end'],

            'time2start'=>@$class_info['time2start'],

            'time2end'=>@$class_info['time2end'],

            'tuition'=>@$class_info['tuition'],

            'fees'=>@$class_info['fees'],

            'min_gradelevel'=>@$class_info['min_gradelevel'],

            'max_gradelevel'=>@$class_info['max_gradelevel'],

            'min_students'=>@$class_info['min_students'],

            'max_students'=>@$class_info['max_students'],

            'max_waitlist'=>@$class_info['max_waitlist'],

            'homework_hours'=>@$homework_hours,

            'homework'=>@$homework,

            'notes'=>@$class_info['notes'],

            'highschool_class'=>@$class_info['highschool_class'],

            'cancelled'=>@$class_info['cancelled']

        );



        $this->db->where('id', $class_info['id']);



        $this->db->update('courses', $array);



    }



    public function save_category($cat_name){



        // check if $cat_name exists in database

        $this->db->select('category_name');

        $this->db->where('category_name', $cat_name);

        $query = $this->db->get('category')->result();

        if(!$query){

            $this->db->set("category_name", $cat_name);

            $this->db->insert("category");

            return true;

        } else {

            return false;

        }

    }



    public function get_categories($id = NULL){



        if($id){

            $this->db->where("CID", $id);

        }
		$this->db->order_by('category_name', 'ASC');



        $query = $this->db->get("category")->result();



        return $query;

    }



    public function remove_category($CID){



        $this->db->delete('category', array('CID' => $CID));

    }

}
