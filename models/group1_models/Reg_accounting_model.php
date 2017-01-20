<?php

class Reg_accounting_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    //select families to display
      public function getFamilies($filterInfo = NULL)
    {
        $this->db->select('family_id, isPaid');
        $this->db->from('admin_accounting');
        // $this->db->where('family_id is NOT NULL', null, false);

        if(@$filterInfo['family_id'] == NULL){
          unset($filterInfo['family_id']);
        }

       if(count($filterInfo) > 0){

        	if(isset($filterInfo['isPaid'])){
              $this->db->where('isPaid', $filterInfo['isPaid']);
          } else if(isset($filterInfo['family_id'])){
              $this->db->where('family_id', $filterInfo['family_id']);
          }

        }

        $query = $this->db->get()->result();

        return $query;
    }

    //this function grabs all the familyIDs and creates an array of the ids + number of users with student permissions (kids) to calculate the total owed for registration
    public function getKidCount(){

        $this->db->select('family_id, user_id');
        $this->db->from('users');
        $this->db->like('permission', "1", 'before');
        $query = $this->db->get()->result();

        $familyIDKidCounts = array();

        foreach($query as $rowObject){
            if(isset($familyIDKidCounts[$rowObject->family_id])){
                $familyIDKidCounts[$rowObject->family_id] += 1;
            }else{
                $familyIDKidCounts[$rowObject->family_id] = 1;
            }
        }

        return $familyIDKidCounts;
    }

    public function updatePaymentStatus($post){

        $data= $_POST['rowData'];

        //TODO: should use codeigniter update_batch() function for efficiency
        foreach($data as $row){
            if(isset($row['update_payment_status'])){
                $this->db->where('family_id', $row['family_id']);
                $this->db->update('admin_accounting', array('isPaid' => !$row['paid_status']));
            }

        }
        redirect('reg_accounting');
    }

    //reset all families to unpaid status
    public function resetAllPayments(){
        $data = 'false';
        $this->db->set('isPaid', $data);
        $this->db->update('admin_accounting');


        header('Location: reg_accounting');
    }

    // public function reg_filter($paid, $family_id = NULL){
    //
    //
    //
    // }

}
