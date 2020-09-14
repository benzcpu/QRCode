<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Render extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('Ciqrcode');
		$this->path_upload='public/uploads/';
		$this->load->model('product_qr_model');
	}

	public function index()
	{
			$data['title']="Test QR PHP";
		 $this->load->view('render',$data);
	}

	public function renderQR(){
		foreach ($_POST['post'] as $item){
			$data['kodenya']= $item;
			$this->load->view('renderqr',$data);
		}



	}
	public function QRcode($kodenya ){
		QRcode::png(
			$kodenya,
			$outfile= false,
			$lavel =QR_ECLEVEL_Q,
			$site = 8,
			$margin=2
		);
	}
	public function uploadQr(){
//		xlx|xlsx
		$filename=array_keys($_FILES)[0];
		$data['allowed_types']="xlx|xlsx";
		$data['filename']=$filename;
		$data['tokenkey']=tokenkeyUploadFile();
		$result=$this->upload($data);

		if($result['status']=="401"){
			echo json_encode($result);
		exit();
		}
		if($result['status']=="200"){





				if($result['status']=="200"){
					$filename=$result['upload_data']['file_name'];


					$this->load->library('excel');
					$dataupdate = array();
					$inputFileName = $this->path_upload . $filename;
					$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$objReader->setReadDataOnly(true);
					$objPHPExcel = $objReader->load($inputFileName);
					$countsheet = $objPHPExcel->getSheetCount();
					$component = array();
					$component_option = array();
					$checkcontrollist = false;
					for ($countItem = 0; $countItem < $countsheet; $countItem++) {
						$table_name = $objPHPExcel->getSheetNames()[$countItem];
						$table_name =   $table_name;

						$objWorksheet = $objPHPExcel->setActiveSheetIndex($countItem);
						$highestRow = $objWorksheet->getHighestRow();
						$highestColumn = $objWorksheet->getHighestColumn();
						$headingsArray = $objWorksheet->rangeToArray('A1:' . $highestColumn . $highestRow, null, true, true, true);
						$arrayData = array();
						$i = 0;
						foreach ($headingsArray[1] as $item) {
							$arrayData[$i] = ($item);
							$i++;
						}
						for ($i = 2; $i <= count($headingsArray); $i++) {
							$j = 0;
							foreach ($headingsArray[$i] as $key => $item) {

								if ($key == "A") {
									$genId ='1';
									$component[$item] = $genId;
									$dataupdate[$table_name][$i - 2][$arrayData[$j]] = $item;
								} else {

										$dataupdate[$table_name][$i - 2][$arrayData[$j]] = $item;

								}

								$j++;

							}


						}
					}

					unlink($inputFileName);
					$data=$this->product_qr_model->insert($dataupdate);

					echo json_encode($data);


			}
		}

	}

	function upload($data){

		if($data['tokenkey']!=tokenkeyUploadFile()){
			return return_false('token not access please connect to develop');
		}
		unset($data['tokenkey']);

		$config['upload_path']          = $this->path_upload;
		$config['allowed_types']        = $data['allowed_types'];
		$config['encrypt_name']        = TRUE;

		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload($data['filename']))
		{


			return( array("status"=>'401' ,'error' => $this->upload->display_errors()));
		}
		else
		{
			return(  array( "status"=>'200','upload_data' => $this->upload->data()));
		}
	}
}
