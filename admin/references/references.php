<?
require_once('../config.php');
echo $HEADER;
if(ADMIN <> "true" && MODER <> "true")
{
	header("location: /admin");
	exit;
}



echo $FOOTER;
?>