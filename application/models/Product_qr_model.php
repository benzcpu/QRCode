<?php

class Product_qr_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//serial,pdq_token
		$this->genQR_by="serial_id";

	}
	function checkprudctionQR($where){
		if($where!=""){
			$data=$this->db->query("select * from tb_product_qr ".$where)->result();
			return $data;
		}
	}
	function insert($data){
		$dataResult=array();
		$genQR_By=$this->genQR_by;
		foreach ($data as $key=>$items){
			foreach ($items as $keys=>$item){


				$checkSerial=$this->checkprudctionQR("where serial_id='".$item['serial']."'");
				if(count($checkSerial)>=1){
					$dataResult[$keys]=$checkSerial[0]->$genQR_By;
				}else{
					$insertTable=array();
					$insertTable['serial_id']=$item['serial'];
					$insertTable['pdq_name']=$item['name'];
					$insertTable['pdq_token']=$item['serial'].genId();
					$insertTable['date_create']=dateNow();
					$this->db->insert("tb_product_qr",$insertTable);
					$dataResult[$keys]=$insertTable[$genQR_By];
				}
			}
		}
		return return_true($dataResult);
	}
}
