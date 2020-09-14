<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct()
	{
		parent::__construct();


		$this->load->model('product_qr_model');
	}

	public function index()
	{

	}

	public function checkproduct($ud){
		$data['result']=$this->product_qr_model->checkprudctionQR("where serial_id='".$ud."'");
		$this->load->view('product/checkproduct',$data);
	}
}
