<?php
//header('content-type:text/html;charset=utf-8');
function transByte($size){
	$size=$size;
	$arr=array("B","KB","MB","GB","TB","PB","EB","ZB");
	for($i=0;$size>=1024&&$i<7;$i++){
		$size=$size/1024;
	}
	$res=round($size,2).$arr[$i];
	return $res;
}
function delF($path){
	if (is_file($path)) {
		unlink($path);
		return"文件删除成功！";
	}else{
		return"文件删除失败！";
	}
}


?>