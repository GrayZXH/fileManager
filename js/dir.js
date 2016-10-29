$(document).ready(function(){
	var path=$("hiddenpath").val();
	$(".createDir").click(function(){
		var dirName=$("#dirName").val();
		$.ajax({
			type:'POST',
			url:"index.php?act=createDir",
			data:{dirName:dirName,path:path},
			success:function(data){
				$("#createDir").modal('hide');
				$("#msgAlert .modal-body").html(data);
				$("#msgAlert").modal();
			}
		});
	});

	$(".delDir").click(function(){
		var delFileName=$(this).attr("data-filename");
		var url=$(this).attr("data-url");
		$("#delFileName").html(delFileName);
		$("#delBtn").attr("href",url);
	});

	$("#delBtn").click(function(){
		var url=$(this).attr("href");
		$.ajax({
			type:"GET",
			url:url,
			success:function(data){
				$("#delDir").modal('hide');
				$("#msgAlert .modal-body").html(data);
				$("#msgAlert").modal();

			}
		});
	})


	



	$("#reload").click(function(){
		location.reload();
	})




})
