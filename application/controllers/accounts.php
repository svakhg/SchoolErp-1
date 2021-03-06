<?php
/**
 * Created by PhpStorm.
 * User: Akshat
 * Date: 7/20/2017
 * Time: 12:26 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Accounts extends MY_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('get_header_info','ghi');
        $username = $this->ghi->get_admin();
        $this->load->view('private/accounts/header',['username'=>$username]);
        $this->load->view('private/accounts/footer');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    }
    public function index(){
        $this->load->model('get_model', 'gm');
        $stu_list = $this->gm->account_list();
        $this->load->view('private/accounts/default', ['account_det' => $stu_list]);
    }

    public function account_group()
    {
        //To be replaced with passing parameters from view dynamically
        //goal: one controller and one module for complete genric Creation.
        $form_validation='account_group';
        $table_name='account_group';
        $view='accounts/account_group';
        $field='account_group_name';
        $this->insert_genric($form_validation,$table_name,$view,$field);
    }
    public function account_group_del()
    {
        if ($this->form_validation->run('account_gr_delete')) {

            $post = $this->input->post();
            unset($post['del_account_group']);
            $this->load->model('del_model', 'dm');
            $value = $post['account_group_delete'];
            $table_name='account_group';
            $field='account_group_name';
            if($this->dm->delete_row($table_name,$field,$value)){
                $this->load->model('get_model', 'gm');
                $list= $this->gm->get_list($field,$table_name);
                $this->load->view('private/accounts/account_group',['view' => $list]);
            }
        }
        else{
            $table_name='account_group';
            $field='account_group_name';
            $this->load->model('get_model', 'gm');
            $list= $this->gm->get_list($field,$table_name);
            $this->load->view('private/accounts/account_group',['view' => $list]);
        }
    }

    public function new_account(){

        //dynamically loading account group name in dropdown
        //inserting new account info in database via new account function and model
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->form_validation->run('account')) {



            $post = $this->input->post();
            unset($post['submit']);
            $this->load->model('add_model', 'am');
            $table_name='account';

            if ($this->am->insert_data($table_name,$post)) {
                $field_a='account_group_name';
                $table_name_a='account_group';
                $this->load->model('get_model','gm');
                $group= $this->gm->get_list($field_a,$table_name_a);
                $this->load->view('private/accounts/new_account',['group'=>$group]);

            } else {
                echo 'Database query error';
                $field_a='account_group_name';
                $table_name_a='account_group';
                $this->load->model('get_model','gm');
                $group= $this->gm->get_list($field_a,$table_name_a);
                $this->load->view('private/accounts/new_account',['group'=>$group]);
            }
        } else {
            $field_a='account_group_name';
            $table_name_a='account_group';
            $this->load->model('get_model','gm');
            $group= $this->gm->get_list($field_a,$table_name_a);
            $this->load->view('private/accounts/new_account',['group'=>$group]);
        }
    }
    public function account_del()
    {
        if ($this->form_validation->run('account_delete')) {

            $post = $this->input->post();
            unset($post['del_account_name']);
            $this->load->model('del_model', 'dm');
            $value = $post['account_name_delete'];
            $table_name='account';
            $field='account_name';
            if($this->dm->delete_row($table_name,$field,$value)){
                $this->load->model('get_model', 'gm');
                $list= $this->gm->get_list($field,$table_name);
                $this->load->view('private/accounts/delete',['view' => $list]);
            }
        }
        else{
            $table_name='account';
            $field='account_name';
            $this->load->model('get_model', 'gm');
            $list= $this->gm->get_list($field,$table_name);
            $this->load->view('private/accounts/delete',['view' => $list]);
        }
    }

    public function send_sms(){
        $this->load->view('private/accounts/send_sms');
    }
    public function import(){
        $this->load->view('private/accounts/import');
    }
    public function export(){
        $this->load->model('get_model', 'gm');
        $stu_list = $this->gm->account_list();
        $this->load->view('private/accounts/export', ['account_det' => $stu_list]);
    }
    public function excel_export(){
        $this->load->model('get_model');
        $this->load->library("excel");
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);
        $table_coloums = array("Account Name","Group","Address","City","Phone","Mobile","Email","Contact Person","Birthday on");
        $coloumn=0;
        foreach ($table_coloums as $field){
            $object->getActiveSheet()->setCellValueByColumnAndRow($coloumn,1,$field);
            $coloumn++;
        }
        $this->load->model('get_model', 'gm');
        $accounts_data = $this->gm->account_list();
        $excel_row = 2;
        foreach ($accounts_data as $row){
            $object->getActiveSheet()->setCellValueByColumnAndRow(0,$excel_row,$row->account_name);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1,$excel_row,$row->group_acc);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2,$excel_row,$row->address);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3,$excel_row,$row->city);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4,$excel_row,$row->phone);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5,$excel_row,$row->mobile);
            $object->getActiveSheet()->setCellValueByColumnAndRow(6,$excel_row,$row->email);
            $object->getActiveSheet()->setCellValueByColumnAndRow(7,$excel_row,$row->contact_per);
            $object->getActiveSheet()->setCellValueByColumnAndRow(8,$excel_row,$row->birthday_on);
            $excel_row++;
        }
        $object_writer =PHPExcel_IOFactory::createWriter($object,'Excel5');
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Description:attachment;filename="AccounData.xls"');
        $object_writer->save('php://output');

    }
    public function labels(){
        $this->load->view('private/accounts/labels');
    }

    public function open_balance_editor()
    {
        $this->load->model('get_model', 'gm');
        $stu_list = $this->gm->account_list();
        $this->load->view('private/accounts/open_balance_editor', ['account_det' => $stu_list]);
    }
    public function delete(){
        $this->load->view('private/accounts/delete');
    }
    public function balance_sheet(){
        $this->load->view('private/accounts/balance_sheet');
    }
    public function contra(){
        $this->load->view('private/accounts/contra');
    }
    public function credit_note(){
        $this->load->view('private/accounts/credit_note');
    }
    public function debit_note(){
        $this->load->view('private/accounts/debit_note');
    }
    public function journal(){
        $this->load->view('private/accounts/journal');
    }
    public function outstanding_balance(){
        $this->load->view('private/accounts/outstanding_balance');
    }

    public function profit_loss()
    {
        $this->load->view('private/accounts/profit_loss');
    }
    public function receipt(){
        $this->load->view('private/accounts/receipt');
    }
    public function trading_account(){
        $this->load->view('private/accounts/trading_account');
    }
    public function trial_balance(){
        $this->load->view('private/accounts/trial_balance');
    }
    public function payments(){
        $this->load->model('get_model', 'gm');
        $table_name='payments';
        $payments_table= $this->gm->show_table($table_name);

        //getting account name dropdown
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if ($this->form_validation->run('payments')) {
            $post = $this->input->post();
            unset($post['submit']);
            $this->load->model('add_model', 'am');
            $table_name='payments';
            if ($this->am->insert_data($table_name,$post)) {
                $field_a='account_name';
                $table_name_a='account';
                $this->load->model('get_model','gm');
                $account= $this->gm->get_list($field_a,$table_name_a);
                $this->load->view('private/accounts/payments',['account'=>$account,'payments' => $payments_table]);
            } else {
                echo 'Database query error';
                $field_a='account_name';
                $table_name_a='account';
                $this->load->model('get_model','gm');
                $account= $this->gm->get_list($field_a,$table_name_a);
                $this->load->view('private/accounts/payments',['account'=>$account,'payments' => $payments_table]);
            }
        } else {
            $field_a='account_name';
            $table_name_a='account';
            $this->load->model('get_model','gm');
            $account= $this->gm->get_list($field_a,$table_name_a);
            $this->load->view('private/accounts/payments',['account'=>$account,'payments' => $payments_table]);
        }
    }
}