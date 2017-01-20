<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reg_accounting extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('group1_models/reg_accounting_model');
        $this->load->model('group1_models/user_model');
    }

	public function index(){
		$this->show_accounting();
	}

    //show accounting page only to admin
    public function show_accounting($error = NULL){
        if($this->session->logged_in){ // if logged in do

            // check permission
            if(str_split($this->user_model->getPermission($this->session->userID))[0]){

                $data['familyArray'] = (array)$this->reg_accounting_model->getFamilies($this->input->post());
                $data['kidCountsByFamilyID'] = $this->reg_accounting_model->getKidCount();

                $this->load->view('group1/templates/header');
                $this->load->view('group1/templates/navbar/navbar');
                $this->load->view('group1/accounting/accounting_table', $data);
                $this->load->view('group1/templates/navbar/navbottom');
                $this->load->view('group1/templates/footer');

            } else { // else redirect to Login_controller
           		header('Location: login');
       		}
    	}
	}

    //update individual accounting records
	public function updateAccounting(){
        $this->load->helper('form');
		$this->reg_accounting_model->updatePaymentStatus($this->input->post());
	}

    //resets every family's status to unpaid
    public function resetAllAccounts(){
        $this->reg_accounting_model->resetAllPayments();
    }


    // public function reg_filter_accounting(){
    //     $paid = $this->input->post('isPaid');
    //     $family_id = $this->input->post('family_id');
    //
    //
    //
    //
    //     $this->reg_accounting_model->reg_filter($paid, $family_id);
    //
    //
    //     // flash these families
    //
    //     // redirect back to reg accounting table
    //
    // }
}
