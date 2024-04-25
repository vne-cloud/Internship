<?
opcache_reset();
require_once('../admin/config.php');
if(ADMIN <> "true")
{
	header("location: ".SCRIPT_FOLDER."");
	exit;
}
echo "<script type='text/javascript' src='/admin/js/jquery.js'></script>
<script type='text/javascript' src='/admin/ckeditor/ckeditor.js'></script>";

$funcNum = $_GET['CKEditorFuncNum'] ;
$CKEditor = $_GET['CKEditor'] ;
$langCode = $_GET['langCode'] ;


$current_dir = "../admin/upload/";
$dir = opendir($current_dir);


$i=1;
while ($file = readdir($dir))
{
	if($file<>'..' && $file<>'.')
	{
		echo "<div id='file".$i."' title='".$file."' style='float: left; width: 150px; height: 150px; cursor: pointer; border: 1px solid #ccc; margin: 0px 20px 20px 0px; position: relative;'>
			<img src='/admin/upload/".$file."' style='max-height: 150px; max-width: 150px;' />
			<div style='padding: 5px 5px 5px 5px; position: absolute; bottom: 0px; width: 140px; background: #ccc; font-size: 12px; color: #000; line-height: 1;'>
				".$file."
			</div>
		</div>";
	}
	$http_path = '/admin/upload/'.$file;
	echo "<script type='text/javascript'>
		$('#file".$i."').click(function(){
			window.opener.CKEDITOR.tools.callFunction( '$funcNum', '$http_path');
			self.close();
		});
	</script>";
	$i++;
}

closedir($dir);

?>