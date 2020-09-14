<html>
<title><?php  echo $title; ?></title>
<body >
<h1>QR Code</h1>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<img style="width: 80px" src="<?php echo site_url('render/Qrcode/1234jhasdkjhakjshdkjahskdhakjshdj')?>" alt="">

<form onsubmit="uploadFileExcel(this)" action="<?php echo base_url('render/uploadQr')?>" id="site_upload_uploadData">
	<input type="file" class="ui-hidden" id="import_site" name="userfile" size="20">
	<button type="submit"  class="  bmmodal-button" id="site_upload_checkstatus_import" action="http://cms.kod-d.com/site/import" value="import"><i class="fas fa-file-import"></i> Import</button>
</form>
<div id="render_QR">

</div>
<script>
	function uploadFileExcel(me){

		event.preventDefault();
			var formData = new FormData(me);
			console.log(formData);
			var url=$('#site_upload_uploadData').attr('action');
			$.ajax({
				type:'POST',
				url: url,
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				success:function(data){
					if(data){
						data=JSON.parse(data);
						$('#render_QR').html("");
						if(data.status=="200"){
								$.ajax({
									url:'<?php echo base_url('render/renderQR/')?>',
									method:"POST",
									data:{post:data.message},
									success:function(dataQR){
										$('#render_QR').html(dataQR);
									}
								});


						}else{

						}
					}
				},
				error: function(data){

				}
			});
	}
</script>
</body>
</html>
