<?php
/*header('content-type:text/html;charset=utf-8');
$path='../webroot/';
if (is_dir($path)) {
	$handle=opendir($path);
	while (($item=readdir($handle))!==false) {
		if ($item!=='.'&&$item!=='..') {
			echo $item;
			echo "<br>";
		}
	}
}*/
function readDire($path){
		$arr=array();
	if (is_dir($path)) {
		//打开目录 获取handle
		$handle=opendir($path);
		//打开读取目录
		while (($item=readdir($handle))!==false) {
			if ($item!=='.'&&$item!=='..') {
				//储存文件信息
				$filepath=$path.'/'.$item;
				$info['filepath']=$filepath;
				$info['filename']=$item;
				$info['readable']=is_readable($filepath);
				$info['writeable']=is_writable($filepath);
				$info['execute']=is_executable($filepath);
				$info['ctime']=date("Y/m/d",filectime($filepath));
				$info['mtime']=date("Y/m/d",filemtime($filepath));
				$info['atime']=date("Y/m/d",fileatime($filepath));;
				if (is_dir($filepath)) {
					$arr['dir'][]=$info;
				}
				if (is_file($filepath)) {
					$arr['file'][]=$info;
				}
			}
		}
	}
				//关闭句柄
		closedir($handle);
		return $arr;
}

function getDirSize($path){
	
	$sum=0;
	global $sum;
	$handle=opendir($path);
	while (($item=readdir($handle))!==false) {
		if ($item!='.'&&$item!='..') {
			$filePath=$path.'/'.$item;
			if (is_file($filePath)) {
				$sum+=filesize($filePath);
			}
			if (is_dir($filePath)) {
				$func=__FUNCTION__;
				$func($filePath);
			}
		}
	}
	closedir($handle);
	return $sum;
}

function checkDirName($dirName){
	$pattern="/[\?\*<>\|]/";
	if (preg_match($pattern, $dirName)) {
		return false;
	}else{
		return true;
	}
}

function createDir($dirName){
	if (!checkDirName($dirName)) {
		return '目录名称包含非法字符，创建失败！';
	}
	if (file_exists($dirName)) {
		return '存在同名目录，创建失败！';
	}
	if (mkdir($dirName,755,true)) {
		return '目录创建成功！';
	}else{
		return'目录创建失败！';
	}

}

function delD($path){
$handle=opendir($path);
while (($item=readdir($handle))==!false) {
	if ($item!=='.'&&$item!=='..') {
		$filepath=$path.'/'.$item;
		if (is_file($filepath)) {
		unlink($filePath);
			}
		if (is_dir($filepath)) {
				$func=__FUNCTION__;
				$func($filepath);
			}
		}
	}
	closedir($handle);
	rmdir($path);
	return'文件删除成功';
}





?>
