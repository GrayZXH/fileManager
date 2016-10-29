<?php
	header('content-type:text/html;charset=utf-8');
	require 'function/dir.func.php';
	require 'function/file.func.php';
	define('PATH', 'webroot');
	$path=(isset($_REQUEST['path']))?$_REQUEST['path']:PATH;
	$info=readDire($path);
	@$act=$_REQUEST['act'];
	@$dirName=$_REQUEST['dirName'];
	@$ditem=$_REQUEST['ditem'];
	switch ($act) {
		case 'createDir':
			$res=createDir($path.'/'.$dirName);
			exit($res);
			break;
		case 'delD':
			$res=delD($ditem);
			exit($res);	
			break;
		case 'delF':
			$res=delF($ditem);
			exit($res);	
			break;
	}
	
?>

<!DOCTYPE html>
<html lang="cmn-Hans-CN">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>文件在线管理系统</title>
	<link rel="icon" type="image/png" href="images/666.png">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/file.css">
</head>
<body>
<div>
<nav class="navbar navbar-default" role="navigation">
  	<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">文件在线管理系统</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
		  <li><a href="index.php"><span class="glyphicon glyphicon-home"></span>主目录</a></li>
		  <li><a href="#createDir" data-toggle="modal"><span class="glyphicon glyphicon-file"></span>新建文件</a></li>
		  <li><a href="#uploadfile" data-toggle="modal"><span class="glyphicon glyphicon-cloud-upload"></span>上传文件</a></li>
		  <li><a href="#"><span class="glyphicon glyphicon-info-sign"></span>系统信息</a></li>
		  <li><a href="#"><span class="glyphicon glyphicon-envelope"></span>联系我们</a></li>
		  <li class="dropdown">
		    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
		    <ul class="dropdown-menu" role="menu">
		      <li><a href="#">Action</a></li>
		      <li><a href="#">Another action</a></li>
		      <li><a href="#">Something else here</a></li>
		      <li class="divider"></li>
		      <li><a href="#">Separated link</a></li>
		    </ul>
		  </li>
		</ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>

	<div class="jumbotron jumu">
  		<div class="container">
		 <h1>Hello, world!</h1>
		 <p>...</p>
		 <p><a class="btn btn-primary btn-lg" href="#" role="button">下载/download</a></p>
  		</div>
	</div>
<!-- 主体区域 -->
	<div class="container mbd">
			<div class="row">
			<div class="col-lg-4">
				<p>文件位置：<?php echo $path ?></p></div>
			<div class="col-lg-8">
				<p><a href="javascript:window.history.go(-1)">上一页</a></p>
			</div>
		
			</div>
	</div>
	<div class="container">
		<div class="table-responsive">
		  <table class="table table-bordered table-hover text-center">
			<thead>
			<tr>
				<th>类型</th>
				<th>名称</th>
				<th>大小</th>
				<th>读</th>
				<th>写</th>
				<th>执行</th>
				<th class="hidden-xs">创建时间</th>
				<th class="hidden-xs">修改时间</th>
				<th class="hidden-xs">访问时间</th>
				<th>操作</th>
			</tr>
			</thead>
			<tbody>

			<?php
					if (!empty($info)) {
					if (!empty($info['dir'])) {
					foreach ($info['dir'] as $value) {
			?>
				<tr>
					<td><!-- 类型 --><span class="glyphicon glyphicon-folder-open"></span></td>
					<td><!-- 名称 --><?php echo $value['filename']?></td>
					<td><!-- 大小 --><?php $sum=0; echo transByte(getDirSize($value['filepath'])) ?></td>
					<td><!--读--><span class="<?php echo $value['readable']?'glyphicon glyphicon-ok':'glyphicon glyphicon-remove'?>"</span></td>
					<td><!--写--><span class="<?php echo $value['writeable']?'glyphicon glyphicon-ok':'glyphicon glyphicon-remove'?>"></span></td>
					<td><!--执行--><span class="<?php echo $value['execute']?'glyphicon glyphicon-ok':'glyphicon glyphicon-remove'?>"></span></td>
					<td class="hidden-xs"><?php echo $value['ctime']?><!-- 创建时间 --></td>
					<td class="hidden-xs"><?php echo $value['mtime']?></td>
					<td class="hidden-xs"><?php echo $value['atime']?></td>
					<td>
					<a href="index.php?path=<?php echo $value['filepath'];?>" class="btn btn-info btn-sm" role="button">打开</a>
					<a href="#delDir" class="btn btn-danger btn-sm delDir"  data-toggle="modal" data-url="index.php?act=delD&ditem=<?php echo $value['filepath'];?>" data-filename="<?php echo $value['filename'];?>">删除</a>
				</tr>
			<?php 
				}
			}
			?>
			<?php
					if (!empty($info['file'])) {
					foreach ($info['file'] as $value) {
			?>
				<tr>
					<td><!-- 类型 --><span class="glyphicon glyphicon-file"></span></td>
					<td><!-- 名称 --><?php echo $value['filename']?></td>
					<td><!-- 大小 --><?php echo transByte(filesize($value['filepath'])) ?></td>
					<td><!--读--><span class="<?php echo $value['readable']?'glyphicon glyphicon-ok':'glyphicon glyphicon-remove'?>"</span></td>
					<td><!--写--><span class="<?php echo $value['writeable']?'glyphicon glyphicon-ok':'glyphicon glyphicon-remove'?>"></span></td>
					<td><!--执行--><span class="<?php echo $value['execute']?'glyphicon glyphicon-ok':'glyphicon glyphicon-remove'?>"></span></td>
					<td class="hidden-xs"><?php echo $value['ctime']?><!-- 创建时间 --></td>
					<td class="hidden-xs"><?php echo $value['mtime']?></td>
					<td class="hidden-xs"><?php echo $value['atime']?></td>
					<td>
					<a href="#" class="btn btn-info btn-sm" role="button">打开</a>
					<a href="#delDir" data-toggle="modal" data-url="index.php?act=delF&ditem=<?php echo $value['filepath'];?>" data-filename="<?php echo $value['filename'];?>" class="btn btn-danger btn-sm delDir" role="button">删除</a>
				</tr>
				<?php
				}
			}
		}else{
			?>
				<tr>
					<td colspan="10">该文件夹为空，请返回<a href="javascript:window.history.go(-1)">上一级</a>>目录</td>
				</tr>
			<?php
		}
			?>
			</tbody>
		  </table>
		</div>
		
	</div>

<!-- 尾部 -->
<footer class="text-center">
	<p>© 2012-2016 www.php.net</p>
	<p>蜀ICP备13014270号-4 Version 5.0.0 release20160127</p>
</footer>

<!-- 隐藏域 -->
	<input type="hidden" class="hiddenpath" value="<?php echo $path;?>">
<!-- 新建文件夹 -->

<!-- Modal -->
<div class="modal fade" id="createDir">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">新建文件夹</h4>
      </div>
      <div class="modal-body">


	  <div class="form-group">
	    <label for="exampleInputEmail1">请输入新建文件夹名称</label>
	    <input type="text" class="form-control" id="dirName" placeholder="不要包含非法字符\ / * ? &quot; : &lt; &gt; |">

	  </div>
	
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary createDir">确定</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- 上传文件 -->
<!-- Modal -->
<div class="modal fade" id="uploadfile">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">上传文件</h4>
      </div>
      <div class="modal-body">
		<!-- enctype用来指定表单编码方式 -->
		<form method="post" action="index.php?act=uploadfile&filename=" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
				<input type="file" name="upfile">
				<input type="text" name="" class="form-control "> 
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-primary ">上传</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<!-- 删除文件夹 -->
<!-- Modal -->
<div class="modal fade" id="delDir">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">删除文件</h4>
      </div>
      <div class="modal-body">
		<p>你要删除<span id="delFileName"></span>文件吗？</p>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="delBtn">确定</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- 信息提示modal -->
<!-- Modal -->
<div class="modal fade" id="msgAlert">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">信息提示</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" id="reload" class="btn btn-default" data-dismiss="modal">确定</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/dir.js"></script>
</body>
</html>