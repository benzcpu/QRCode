<?php
function tokenkeyUploadFile(){
	return 'Jqs23Ax';
}
function return_false($message){
	return $message=array('status'=>401,'message'=>$message);
}
function return_true($message){
	return $message=array('status'=>200,'message'=>$message);
}
function isset_not_empty(&$value, $default = null)
{
	try {
		return isset($value) && !empty($value) ? $value : $default;
	} catch (\Exception $e) {
		return $default;
	}


}
function dd($data){
	print_r($data);
	exit();
}
function genelatekey($count=""){
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randstring = '';
	if($count ==""){
		$count="5";
	}
	for ($i = 0; $i < $count; $i++) {
		$randstring = $randstring.$characters[rand(0, strlen($characters)-1)];
	}
	return $randstring;
}
function genID($key=""){
	return md5(genelatekey(10).dateNow().$key);

}
function dateNow($format=""){
	date_default_timezone_set("Asia/Bangkok");
	if($format==""){
		return date("Y-m-d H:i:s");
	}else{
		return date($format);
	}

}
