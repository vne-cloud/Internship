<?

/* --- Правый контент --- */

function content(){
	global $params;
	$fn = "";

	if (isset($_GET['edit']) || isset($_GET['add']) || $params[1] == 'setting') {

		$left_lines = "";
		$content = "contentDef";

		if (isset($_GET['edit']) || isset($_GET['add'])) {
			$left_lines = "<a class='leftLines' href='".$_SERVER['PHP_SELF']."'><span class='leftLinkBtn' title='Перейти к списку'></span></a>";
			$content = "contentEdit";
		}

		$fn .= "<div class='button save'>".SEND."</div>
		<section class='content ".$content." vcell'>
			".$left_lines."
			<div class='contentIn ".anime()."'>";
	}
	else {
		$fn .= "<section class='content vcell'>
			<div class='list'>
			<div class='listClose'></div>";
	}

	return $fn;
}

/* --- // --- */


/* --- Панель администратора --- */

function admin_menu(){
	global $params;
	global $parts;
	$fn = "";

	foreach($parts as $key => $val)
	{
		$nav = explode ("|", $val);
		$cl = "";
		if($params[1] == $nav[0]) {
			$cl = "admin_menu_link_act";
			$name = $nav[1];
		}

		//новые заявки
		$kols = '';
		if ($nav[3] == 7) {
			$dres = mysql_query("SELECT count(*) AS kol FROM sends WHERE `read` = 0");
			$drow = mysql_fetch_array($dres);
			$dkol = $drow['kol'];
			if (!empty($dkol)) $kols = " <span class='kols'>(".$dkol.")</span>";
		}

		$fn .= "<a href='/admin/".$nav[0]."/".$nav[1]."' class='admin_menu_link ".$cl." admin_icon".$nav[3]."' title='".$nav[2]."'>".$nav[2]." ".$kols."</a>";

		$fn .= "<div class='admin_menu_child'>";
			//МОДУЛИ
			if ($nav[0] == 'modules' && $params[1] == 'modules') {
				$fn .= modules();
			}
			//СПРАВОЧНИКИ
			else if ($nav[0] == 'references' && ($params[1] == 'references')) {
				$fn .= references();
			}
			//ЗАЯВКИ
			else if ($nav[0] == 'sends' && $params[1] == 'sends') {
				$fn .= sends();
			}
			//РАССЫЛКИ
			else if ($nav[0] == 'subs' && $params[1] == 'subs') {
				//$fn .= subs();
			}

		$fn .= "</div>";
	}

	//$fn .= "<div class='admin_menu_link'>&nbsp;</div>";

	return $fn;
}

/* --- // --- */


/* --- Левое меню (для узкой версии) --- */

function left_pages(){
	global $params;
	$fn = "";

	//МОДУЛИ
	if ($params[1] == 'modules') {
		$fn .= modules();
	}
	//СПРАВОЧНИКИ
	else if ($params[1] == 'references') {
		$fn .= references();
	}
	//ЗАЯВКИ
	else if ($params[1] == 'sends') {
		$fn .= sends();
	}
	//РАССЫЛКИ
	else if ($params[1] == 'subs') {
		//$fn .= subs();
	}

	return $fn;
}

/* --- // --- */


/* --- Модули --- */

function modules() {
	global $params;
	global $modules;
	$fn = "";

	$php_self = $_SERVER['PHP_SELF'];
	$php_self = str_replace('/admin/', '', $php_self);

	$i = 0;
	$fn .= "<div class='menu leftModules'>
		<div class='leftArrow'>скрыть</div>
		<div class='menuIn'>
			<div class='menuContent'>";
			foreach($modules['links'] as $key => $val) {
				$cl = $after ="";
				if($_SERVER['PHP_SELF'] == "/admin/modules/".$val) {
					$cl = "leftLinkAct ";
				}
				$fn .= "<div class='leftLink ".$cl."'>
					<a href='".$val."' class='admin_link'>".$modules['names'][$i]."</a>
				</div>";

				$i++;
			}
	$fn .= "</div>
		</div>
	</div>";

	return $fn;
}

/* --- // --- */


/* --- Справочники --- */

function references() {
	global $params;
	global $references;

	$php_self = $_SERVER['PHP_SELF'];
	$php_self = str_replace('/admin/', '', $php_self);

	$i = 0;
	$fn .= "<div class='menu leftModules'>
		<div class='leftArrow'>скрыть</div>
		<div class='menuIn'>
			<div class='menuContent'>";
			foreach($references['links'] as $key => $val) {
				$cl = $after ="";
				if($_SERVER['PHP_SELF'] == "/admin/references/".$val) {
					$cl = "leftLinkAct ";
				}
				$fn .= "<div class='leftLink ".$cl."'>
					<a href='".$val."' class='admin_link'>".$references['names'][$i]."</a>
				</div>";

				$i++;
			}
	$fn .= "</div>
		</div>
	</div>";

	return $fn;
}

/* --- // --- */



/* --- Заявки --- */

function sends() {
	global $params;
	global $sends;

	return "";

	$php_self = $_SERVER['PHP_SELF'];
	$php_self = str_replace('/admin/', '', $php_self);

	$i = 0;

	$fn .= "<div class='menu leftModules'>
		<div class='leftArrow'>скрыть</div>
		<div class='menuIn'>
			<div class='menuContent'>";
			foreach($sends['links'] as $key => $val) {
				$cl = $after ="";
				if($_SERVER['PHP_SELF'] == "/admin/sends/".$val) {
					$cl = "leftLinkAct ";
				}
				$fn .= "<div class='leftLink ".$cl."'>
					<a href='".$val."' class='admin_link'>".$sends['names'][$i]."</a>
				</div>";

				$i++;
			}
	$fn .= "</div>
		</div>
	</div>";

	return $fn;
}

/* --- // --- */


/* --- Рассылка --- */

function subs() {
	global $params;
	global $subs;

	$php_self = $_SERVER['PHP_SELF'];
	$php_self = str_replace('/admin/', '', $php_self);

	$i = 0;

	$fn .= "<div class='menu leftModules'>
		<div class='leftArrow'>скрыть</div>
		<div class='menuIn'>
			<div class='menuContent'>";
			foreach($subs['links'] as $key => $val) {
				$cl = $after ="";
				if($_SERVER['PHP_SELF'] == "/admin/subs/".$val) {
					$cl = "leftLinkAct ";
				}
				$fn .= "<div class='leftLink ".$cl."'>
					<a href='".$val."' class='admin_link'>".$subs['names'][$i]."</a>
				</div>";

				$i++;
			}
	$fn .= "</div>
		</div>
	</div>";

	return $fn;
}

/* --- // --- */


/* --- Ватермарк --- */

function watermark($path, $watermark_path) {
	if ($watermark_path && is_file($watermark_path) && file_exists($watermark_path)) {
		$_watermark_path = escapeshellarg($watermark_path);
		$_path = escapeshellarg($path);

		exec('composite -gravity center '.$_watermark_path.' '.$_path.' '.$_path.'');
	}
}

/* --- // --- */


/* --- MIME --- */

function mime_type_by_extention($filename) {
	$extention = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

	switch ($extention) {
		case 'jpg': $mime_type = 'image/jpeg'; break;
		case 'jpeg': $mime_type = 'image/jpeg'; break;
		case 'png':  $mime_type = 'image/png'; break;
		case 'gif':  $mime_type = 'image/gif'; break;
		case 'bmp':  $mime_type = 'image/bmp'; break;
		case 'wbmp': $mime_type = 'image/vnd.wap.wbmp'; break;
		case 'tif':
		case 'tiff': $mime_type = 'image/tiff'; break;
		default: $mime_type = false;
	}

	return $mime_type;
}

/* --- // --- */


/* --- РЕСАЙЗ --- */

function resize_image($path, $width_required, $height_required, $mode = 'crop', $quality = 100, $watermark_path = NULL) {
	$quality = is_int($quality) ? (int)$quality : 100;

	$_getimagesize = getimagesize($path);

	$width_original = $_getimagesize[0];
	$height_original = $_getimagesize[1];

	$width_required = floor($width_required);
	$height_required = floor($height_required);

	switch ($mode) {
		case 'crop': {
			if ($width_original > $height_original) {
				$width_resize = floor(($width_original * $height_required) / $height_original);
				$height_resize = $height_required;
			} else if ($width_original < $height_original) {
				$width_resize = $width_required;
				$height_resize = floor(($width_required * $height_original) / $width_original);
			} else {
				$width_resize = $width_required;
				$height_resize = $height_required;
			}
			break;
		}
		case 'composite': {
			if ($width_original > $height_original) {
				$width_resize = $width_required;
				$height_resize = floor(($width_required * $height_original) / $width_original);
			} else if ($width_original < $height_original) {
				$width_resize = floor(($width_original * $height_required) / $height_original);
				$height_resize = $height_required;
			} else {
				$width_resize = $width_required;
				$height_resize = $height_required;
			}
			break;
		}
	}

	$_path = escapeshellarg($path);

	exec('convert -resize '.$width_resize.'x'.$height_resize.' -quality '.$quality.' '.$_path.' '.$_path);

	switch ($mode) {
		case 'crop': {
			exec('convert -gravity center -crop '.$width_required.'x'.$height_required.'+0+0 -quality '.$quality.' '.$_path.' '.$_path);
			break;
		}
		case 'composite': {
			$tmp_filename = '.tmp'.rand(1000, 9999);

			$_mime_content_type = mime_content_type($path);

			if ($_mime_content_type === 'inode/x-empty' || $_mime_content_type === 'application/x-empty') {
				$_mime_content_type = mime_type_by_extention($path);
			}

			switch ($_mime_content_type) {
				case 'image/gif':
				case 'image/png': {
					$im = imagecreatetruecolor($width_required, $height_required);
					imagesavealpha($im, true);
					$color = imagecolorallocatealpha($im, 0, 0, 0, 127);
					imagefill($im, 0, 0, $color);
					imagepng($im, $tmp_filename);
					imagedestroy($im);
					unset($im);
					break;
				}

				default: {
					$im = imagecreatetruecolor($width_required, $height_required);
					$color = imagecolorallocate($im, 255, 255, 255);
					imagefill($im, 0, 0, $color);
					imagejpeg($im, $tmp_filename, 100);
					imagedestroy($im);
					unset($im);
					break;
				}
			}

			$_tmp_filename = escapeshellarg($tmp_filename);

			exec('composite -gravity center '.$_path.' '.$_tmp_filename.' '.$_path);

			unlink($tmp_filename);
			break;
		}
	}

	if ($watermark_path) {
		watermark($path, $watermark_path);
	}
}

/* --- // --- */


/* --- Случайный пароль --- */

function random_password()
{
	$out = '';
	$arr = array();
	for($i=97; $i<123; $i++) $arr[] = chr($i);
	for($i=65; $i<91; $i++) $arr[] = chr($i);
	for($i=0; $i<10; $i++) $arr[] = $i;
	shuffle($arr);
	for($i=0; $i<9; $i++)
	{
		$out .= $arr[mt_rand(0, sizeof($arr)-1)];
	}
	return $out;
}

/* --- // --- */


/* --- Навигация страниц --- */

class Navigator
{
	function navigator($all,$pnumber,$query = "")
	{
		if (empty($query)) $query = get();
		$this->all=$all;
		$this->pnumber=$pnumber;
		$this->query=$query;
		if(isset($_GET['page']))
		{
			$this->page = (int)$_GET['page'];
		}
		else
		{
			$this->page = 1;
		}
	}
	function num_pages()
	{
		$this->num_pages=ceil($this->all/$this->pnumber);
		return $this->num_pages;
	}
	function start()
	{
		$this->num_pages=ceil($this->all/$this->pnumber);
		if ($this->page>$this->num_pages)
		{
			$this->page=$this->num_pages;
		}
		if (isset($_GET['last']))
		{
			$this->page=$this->num_pages;
		}
		$this->start=$this->page*$this->pnumber-$this->pnumber;
		if ($this->page > $this->num_pages || $this->page < 1)
		{
			$this->page=$this->num_pages;
		}
		return abs($this->start);
	}
	function navi()
	{
		if ($this->page < $this->num_pages)
		{
			$next = "<a class='next_page' href='".$_SERVER['SCRIPT_NAME']."?page=".($this->page+1).$this->query."'>далее</a>";
		}
 		else
		{
			$next ="";
		}
		if ($this->page > 1)
		{
			$prev = "<a class='prev_page' href='".$_SERVER['SCRIPT_NAME']."?page=".($this->page-1).$this->query."'>назад</a>";
		}
		else
		{
			$prev ="";
		}
		if ($this->num_pages<2)
		{
			return "";
		}
		$main = $prev."<div class='block_nav'><table class='nav_table'><tr><td>";
		for($pr = "", $i =1; $i <= $this->num_pages; $i++)
		{
			if($i == 1 || $i == $this->num_pages || abs($i-$this->page) < 7)
			{
				if($i == $this->page)
				{
					$pr = "<div class='active_nav'>".$i."</div>";
				}
				else
				{
					$pr = "<a class='noactive_nav' href='".$_SERVER['SCRIPT_NAME']."?page=".$i.$this->query."'>".$i."</a>";
				}
			}
			else
			{
				if($pr == "<div class='etc'>...</div>" || $pr == "")
				{
					$pr = "";
				}
				else
				{
					$pr = "<div class='etc'>...</div>";
				}
			}
		$main .= $pr;
		}
		$main .= "<div class='clear'></div><td></tr></table></div>";
		return "<div class='navigationWrap'><div class='navigation'>".$next.$main."</div></div>";
	}
}

/* --- // --- */


/* --- Замена алфавита на транслит --- */

function rus_to_eng($text)
{
$text = trim($text);
$text = str_replace(array('А','а','Б','б','В','в','Г','г','Д','д','Е','е','Ё','ё','Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о','П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ч','ч','Ъ','ъ','Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я','Ш','ш','Щ','щ'),
		    array('a','a','b','b','v','v','g','g','d','d','e','e','e','e','zh','zh','z','z','i','i','y','y','k','k','l','l','m','m','n','n','o','o','p','p','r','r','s','s','t','t','u','u','f','f','h','h','c','c','ch','ch','','','i','i','','','e','e','u','u','ya','ya','sh','sh','sch','sch'),
		   $text);
$text = preg_replace("|[^a-z0-9\s]|i", "", $text);
$text = preg_replace("|\s|", "-", $text);
$text = str_replace("quot", "", $text);
$text = mb_strtolower($text);
return $text;
}

/* --- // --- */


/* --- Замена алфавита на транслит --- */

function rus_to_eng_old($text)
{
$text = trim($text);
$text = str_replace(array('А','а','Б','б','В','в','Г','г','Д','д','Е','е','Ё','ё','Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о','П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ч','ч','Ъ','ъ','Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я','Ш','ш','Щ','щ'),
		    array('a','a','b','b','v','v','g','g','d','d','e','e','e','e','Zh','zh','z','z','i','i','y','y','k','k','l','l','m','m','n','n','o','o','p','p','r','r','s','s','t','t','u','u','f','f','h','h','c','c','ch','ch','','','i','i','','','e','e','u','u','ya','ya','sh','sh','sch','sch'),
		   $text);
$text = preg_replace("|[^a-z0-9\s]|i", "", $text);
$text = preg_replace("|\s|", "_", $text);
return $text;
}

/* --- // --- */


/* --- Работа с присланными данными пользователя --- */

function dataprocessing ($value)
{
	$value = trim($value);
	$value = preg_replace("/[\r\n]{3,}/i","\r\n\r\n", $value);
	$value = stripslashes($value);
	$value = strip_tags($value);
	$value = htmlspecialchars($value);
	$value = mysql_real_escape_string($value);
	return $value;
}
function adataprocessing ($value) {
	$value = trim($value);
	$value = preg_replace("/[\r\n]{3,}/i", "\r\n\r\n", $value);
	$value = stripslashes($value);
	$value = mysql_real_escape_string($value);
	return $value;
}

/* --- // --- */


/* --- Псевдо УРЛ --- */

function Clear_array($array) {
	$c=sizeof($array);
	$tmp_array=array();
	for($i=0; $i<$c; $i++)
	{
		if (!(trim($array[$i])==""))
		{
			$a = $array[$i];
			$arr = explode("?", $a);
			$a = $arr[0];
			$tmp_array[]=$a;
		}
	}
	return $tmp_array;
}

/* --- // --- */


/* --- Файл --- */

function filebox($name) {
	$fn = "<div class='file'>
		<div class='fileBox'>
			<input type='file' name='".$name."' />
			<div class='fileAdd'>Выберите файл</div>
		</div>
		<div class='fileName'>(файл не выбран)</div>
	</div>";
	return $fn;
}

/* --- // --- */


/* --- Checkbox --- */

function checkbox($name, $ch, $val = 1, $class = "") {
	$fn = "<label class='labelCheck'>
		<input type='checkbox' ".$ch." name='".$name."' class='checkbox {$class}' value='".$val."'><span></span>
	</label>";
	return $fn;
}

/* --- // --- */



/* --- Textbox --- */

function textbox($name, $val, $head, $height = 400) {
	$fn = "<div class='formbox'>
		<div class='label'>".$head."</div>
		<div class='row'>
			<textarea name='".$name."' id='".$name."'>".$val."</textarea>
			<script>CKEDITOR.replace('".$name."', { height: ".$height." });</script>
		</div>
		<div class='clear'></div>
	</div>";
	return $fn;
}

/* --- // --- */


/* --- Textarea --- */

function textarea($name, $val, $label, $height = 50, $cl = "", $required = "") {
	$fn = "<div class='formbox'>
		<div class='label ".$cl."'>".$label."</div>
		<textarea class='input' style='height: ".$height."px;' name='".$name."' {$required}>".$val."</textarea>
	</div>";
	return $fn;
}

/* --- // --- */


/* --- Input --- */

function input($name, $val, $label, $required = "", $class = "", $small = "") {
	$fn = "<div class='formbox'>
		<div class='label ".$class."''>".$label."</div>
		<input type='text' name='".$name."' value='".$val."' class='input' maxlength='255' ".$required." />
		<div class='label-small'>".$small."</div>
	</div>";
	return $fn;
}

/* --- // --- */


/* --- Input date --- */

function input_date($name, $val, $label, $required = "", $class = "", $small = "") {
	$fn = "<div class='formbox'>
		<div class='label ".$class."''>".$label."</div>
		<input type='date' name='".$name."' value='".$val."' class='input' maxlength='255' ".$required." />
		<div class='label-small'>".$small."</div>
	</div>";
	return $fn;
}

/* --- // --- */


/* --- Галерея --- */

function gallbox($type, $id, $head = 'Фотогалерея:') {

	$name = 'file';

	$fn .= "<div class='formbox'>
		<div class='label'>{$head}</div>
		<div class='row'>
			<div class='rowWidth sortable-gallbox'>
				<div class='imgsBox'>
					<input type='file' name='".$name."[]' class='input' multiple='true' min='1' max='999' />
					<div class='imgsAdd'><span>+</span>Добавить</div>
					<div class='imgsFilename'></div>
				</div>";
				$j = 2;

				if (!empty($id)) {
					$res = mysql_query("SELECT * FROM gallery WHERE type='".$type."' AND ids='".$id."'
					ORDER BY rate DESC, id ASC");
					if(mysql_num_rows($res)) {
						while($row = mysql_fetch_array($res)) {

							$cl = "";
							//if ($j % 4 == 0) $cl = "imgItem4";

							$fn .= "<div class='imgItem ".$cl." filter' id='imgItem".$row['id']."' data-id='".$row['id']."' title='Перетащите для сортировки'>
								<div class='imgPath contain' style='background: url(/public/images/".$type."/gallery/".$row['path_middle'].") center center no-repeat #DADADA;'></div>
								<div class='imgInfo'>
									<input type='hidden' name='img_rate[]' value='".($row['rate'] == 0 ? "" : $row['rate'])."' style='width: 83px; margin-bottom: 4px;' class='input' placeholder='Рейтинг' />
									<input type='hidden' name='img_id[]' value='".$row['id']."' />
									<input type='checkbox' name='img[]' id='imgDelete".$row['id']."' value='".$row['id']."' />
								</div>
								<div class='imgDel' title='Удалить' data-id='".$row['id']."'></div>
								<a target='_blank' href='/public/images/".$type."/gallery/".$row['path']."' class='imgShow' title='Смотреть' data-id='".$row['id']."'></a>
							</div>";
							$j++;
						}
						$fn .= "<div style='clear: both'></div>";
					}
				}

				$fn .= "</div>
			</div>
		<div class='clear'></div>
	</div>";

	return $fn;
}

/* --- // --- */


/* --- Gallsave --- */

function gallsave($w, $h, $type, $id, $resize_type = '') {

	image_dir("/public/images/{$type}/gallery/");

	$count = time();

	$count_field = preg_replace("/[^0-9]/", '', $type.$id);
	$count += $count_field;

	$img = $_POST['img'];
	if(isset($img))
	{
		foreach($img as $imgs)
		{
			$result = mysql_query("SELECT * FROM gallery WHERE id='".$imgs."' LIMIT 1");
			if(mysql_num_rows($result) <>0)
			{
				$row = mysql_fetch_array($result);
				unlink(trim($row['path']));
				unlink(trim($row['path_small']));
				unlink(trim($row['path_middle']));
				mysql_query("DELETE FROM gallery WHERE id='".$imgs."'");
			}
		}
	}

	$img = $_POST['img_id'];
	$img_num = $_POST['img_num'];
	$img_rate = $_POST['img_rate'];
	if(isset($img))
	{
		$i = 0;
		foreach($img as $imgs)
		{
			//mysql_query("UPDATE gallery SET rate='".$img_num[$i]."', rate='".$img_rate[$i]."'  WHERE id='".$imgs."' LIMIT 1");
			//echo "UPDATE gallery SET rate='".$img_num[$i]."', rate='".$img_rate[$i]."'  WHERE id='".$imgs."' LIMIT 1";
			$i++;
		}
	}

	$num = count($_FILES['file']['name']);
	for($i=0;$i<$num;$i++)
	{
		$count++;
		$filename = $_FILES['file']['name'][$i];
		$path_info = pathinfo($filename);
		$extension = strtolower($path_info['extension']);
		$path = $count.".".$extension;
		$path_middle = $count."_middle.".$extension;
		$path_small = $count."_small.".$extension;

		if (is_uploaded_file($_FILES['file']['tmp_name'][$i])) {
			move_uploaded_file($_FILES['file']['tmp_name'][$i], $path);
			copy($path, $path_small);
			copy($path, $path_middle);

			//крупная
			exec_resize($path, 1280, 1280, 2);

			//средняя
			exec_resize($path_middle, $w, $h, $resize_type);

			//мелкая
			exec_resize($path_small, 66, 47, $resize_type);

			mysql_query("INSERT INTO gallery SET
				type='".$type."'
				, ids='".$id."'
				, path='".$path."'
				, path_middle='".$path_middle."'
				, path_small='".$path_small."'
			");
		}
	}
}

/* --- // --- */


/* --- Обрезка под макс. размеры --- */

function exec_resize($path, $w, $h, $resize_type = '') {

	$nwidth1 = $w;
	$nheight1 = $h;

	$imageinfo = getimagesize($path);
	$width = $imageinfo[0];
	$height = $imageinfo[1];

	//тип 2
	if ($resize_type == 2) {
		if($height > $nheight1) {
			$nheight = $nheight1;
			$nwidth = ($nheight/$height)*$width;

			exec("convert -resize ".round($nwidth)."x".round($nheight)." -quality 90 ".$path." ".$path."");
		}

		$imageinfo = getimagesize($path);

		$width = $imageinfo[0];
		$height = $imageinfo[1];

		if($width > $nwidth1) {
			$nwidth = $nwidth1;
			$nheight = ($nwidth/$width)*$height;

			exec("convert -resize ".round($nwidth)."x".round($nheight)." -quality 90 ".$path." ".$path."");
		}
	}
	//тип 1
	else {
		$nheight = $nheight1;
		$nwidth = ($nheight/$height)*$width;

		if ($nwidth < $nwidth1)
		{
			$nwidth = $nwidth1;
			$nheight = ($nwidth/$width)*$height;
		}
		else if ($nheight < $nheight1)
		{
			$nheight = $nheight1;
			$nwidth = ($nheight/$height)*$width;
		}

		exec("convert -resize ".round($nwidth)."x".round($nheight)." -quality 90 ".$path." ".$path."");
		exec("convert -gravity Center -crop ".$nwidth1."x".$nheight1."+0+0 -quality 90 ".$path." ".$path."");
	}

	return;
}

/* --- // --- */


/* --- HEAD --- */

function heads($name, $text = "") {

	if (!empty($text)) $text = " ".$text;

	if (isset($_GET['add'])) $head = "Добавление".$text;
	else $head = "Редактирование".$text.": ".$name;

	return $head;
}

/* --- // --- */


/* --- SHOW --- */

function show($ch) {

	$fn .= "<div class='formbox'>
		<div class='label'>На сайте:</div>
		<div class='row'>
			".checkbox('show', $ch)."
			Показывать
		</div>
		<div class='clear'></div>
	</div>";

	return $fn;
}

/* --- // --- */


/* ---  --- */

function check($label, $name, $ch, $text, $class = "") {

	$fn .= "<div class='formbox'>
		<div class='label {$class}'>".$label."</div>
		<div class='row'>
			".checkbox($name, $ch)."
			".$text."
		</div>
	</div>";

	return $fn;
}

/* --- // --- */


/* --- Дата словами --- */

function date_str($date) {
	$fn = "";

	$date = date('d.n.Y', strtotime($date));
	$arr_date = explode(".", $date);

	$month = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');

	$fn .= $arr_date[0]." ".$month[$arr_date[1]-1]." ".$arr_date[2];

	return $fn;
}

/* --- // --- */


/* --- Вывод переменных --- */

function p($val) {
	$fn = "<pre>";
	print_r($val);
	$fn .= "</pre>";
}

/* --- // --- */


/* --- Кнопки --- */

function btns($table, $row, $php_self) {

	$cl = "";
	if($row['show'] == 1) $cl = "pageViewAct";

	$fn = "<div class='admins'>
		<div class='pageDel' title='Удалить' data-id='".$row['id']."' data-table='".$table."'></div>
		<div class='pageEdit' title='Редактировать' data-href='".$php_self."?edit&amp;id=".$row['id']."'></div>
		<div class='pageView ".$cl."' title='Показывать на сайте' data-id='".$row['id']."' data-table='".$table."'></div>
	</div>";

	if ($_SERVER['PHP_SELF'] == $php_self && $_GET['id'] == $row['id']) {
		$fn .= "<div class='pageArrow'></div>";
	}

	return $fn;
}

/* --- // --- */


/* --- Показ разделов --- */

function part_show($name) {

	if ($_SESSION['admin_structure_'.$name] == '1') $fn .= "display: block;";
	else $fn .= "";

	return $fn;
}

/* --- // --- */


/* --- Показ ссылок --- */

function page_link_class($name) {

	if ($_SESSION['admin_structure_'.$name] == '1') $fn .= "pageLinkShow";
	else $fn .= "";

	return $fn;
}

/* --- // --- */


/* --- Активность --- */

function page_link_act($id, $php_self) {

	$fn = "";
	if ($_SERVER['PHP_SELF'] == $php_self && $_GET['id'] == $id) {
		$fn .= " pageLinkAct";
	}

	return $fn;
}

/* --- // --- */


/* --- Загрузка --- */

function upload($table, $file, $width, $height, $field, $type = "", $id = "") {
	$fn = "";

	$count = time();

	$count_field = preg_replace("/[^0-9]/", '', $field);
	$count += $count_field;

	if (is_uploaded_file($_FILES[$file]['tmp_name']))
	{
		$filename = $_FILES[$file]['name'];
		$path_info = pathinfo($filename);
		$extension = $path_info['extension'];

		$count++;
		$path = $count.".".$extension;
		move_uploaded_file($_FILES[$file]['tmp_name'], $path);

		$nwidth1 = $width;
		$nheight1 = $height;

		$imageinfo = getimagesize($path);

		$width = $imageinfo[0];
		$height = $imageinfo[1];

		if ($width > $nwidth1 || $height > $nheight1) {

			//тип 2
			if ($type == 2) {
				if($height > $nheight1) {
					$nheight = $nheight1;
					$nwidth = ($nheight/$height)*$width;

					exec("convert -resize ".round($nwidth)."x".round($nheight)." -quality 95 ".$path." ".$path."");
				}

				$imageinfo = getimagesize($path);

				$width = $imageinfo[0];
				$height = $imageinfo[1];

				if($width > $nwidth1) {
					$nwidth = $nwidth1;
					$nheight = ($nwidth/$width)*$height;

					exec("convert -resize ".round($nwidth)."x".round($nheight)." -quality 95 ".$path." ".$path."");
				}
			}
			//тип 1
			else {
				$nheight = $nheight1;
				$nwidth = ($nheight/$height)*$width;

				if ($nwidth < $nwidth1)
				{
					$nwidth = $nwidth1;
					$nheight = ($nwidth/$width)*$height;
				}
				else if ($nheight < $nheight1)
				{
					$nheight = $nheight1;
					$nwidth = ($nheight/$height)*$width;
				}

				exec("convert -resize ".round($nwidth)."x".round($nheight)." -quality 90 ".$path." ".$path."");
				exec("convert -gravity Center -crop ".$nwidth1."x".$nheight1."+0+0 -quality 90 ".$path." ".$path."");
			}
		}

		$ress = mysql_query("SELECT * FROM `".$table."` WHERE id='".$id."' LIMIT 1");
		$rows = mysql_fetch_array($ress);
		unlink(trim($rows[$field]));

		$fn = ", `".$field."`='".$path."' ";
	}

	return $fn;
}

/* --- // --- */


/* --- Загрузка файла --- */

function upload_file($table, $file, $field) {
	$fn = "";

	$count = time();

	if (is_uploaded_file($_FILES[$file]['tmp_name']))
	{
		$filename = $_FILES[$file]['name'];
		$path_info = pathinfo($filename);
		$extension = $path_info['extension'];

		$count++;
		$path = $count.".".$extension;
		//$name = $path_info['filename'];
		//$path = $filename;
		move_uploaded_file($_FILES[$file]['tmp_name'], $path);

		$ress = mysql_query("SELECT * FROM `".$table."` WHERE id='".$id."' LIMIT 1");
		$rows = mysql_fetch_array($ress);
		unlink(trim($rows[$field]));

		$fn = ", `".$field."`='".$path."' ";
	}

	return $fn;

	//$arr['fn'] = $fn;
	//$arr['name'] = $name;
	//return $arr;
}

/* --- // --- */


/* --- Анимация --- */

function anime() {

	$fn = "anime0";
	if(!empty($_SESSION['notice'])) $fn = "anime111111";

	return $fn;
}

/* --- // --- */


/* --- H1 автоматом --- */

function h1() {
	global $modules;
	global $params;
	global $references;
	global $sends;

	$page = $params[2];

	$i = 0;
	foreach($modules['links'] AS $item) {

		if ($item == $page) return $modules['names'][$i];

		$i++;
	}

	$i = 0;
	foreach($references['links'] AS $item) {

		if ($item == $page) return $references['names'][$i];

		$i++;
	}

	$i = 0;
	foreach($sends['links'] AS $item) {

		if ($item == $page) return $sends['names'][$i];

		$i++;
	}

	return $fn;
}

/* --- // --- */


/* --- TABLE автоматом --- */

function table() {
	global $modules;
	global $params;
	global $references;

	$page = $params[2];

	$table = "";

	$i = 0;
	foreach($modules['links'] AS $item) {

		if ($item == $page) {
			$table = $item;
			$table = str_replace('.php', '', $table);
			return $table;
		}

		$i++;
	}

	$i = 0;
	foreach($references['links'] AS $item) {

		if ($item == $page) {
			$table = $item;
			$table = str_replace('.php', '', $table);
			return $table;
		}

		$i++;
	}

	return $table;
}

/* --- // --- */


/* --- Структура. Ссылка --- */

function page_list($href, $table, $name, $part) {
	$fn = "";

	$fn .= "<div class='wpage'>
		<div class='page'>
			<div class='pageLink ".page_link_class('part'.$part)."' data-part='part".$part."'>".$name."</div>
		</div>
		<div data-href='".$href."' class='pageEdit pageEdit2' title='Редактировать'></div>
		<div class='clear'></div>
	</div>
	<div class='parts part".$part."' style='".part_show('part'.$part)."'>";
		$res = mysql_query("SELECT * FROM `".$table."` WHERE 1=1 ORDER BY name ASC");
		while ($row = mysql_fetch_array($res)) {
			$page_end = "wpageEnd";

			$fn .= "<div class='wpage wpage2 ".$page_end."' data-part='part".$part.$row['id']."'>
				<div class='page'>
					<div class='pageLink ".page_link_act($row['id'], $href)."'>";
						if ($table == 'partner') {
							$fn .= "<div style='height: 30px; width: 75px; height: 32px; background: url(/public/images/partner/".$row['path'].") no-repeat center center #171717; background-size: contain;'></div>";
						}
						else if ($table == 'partner2') {
							$fn .= "<div style='height: 30px; width: 75px; height: 32px; background: url(/public/images/partner2/".$row['path'].") no-repeat center center #171717; background-size: contain;'></div>";
						}
						else {
							$fn .= "".$row['name']."";
						}
					$fn .= "</div>
				</div>
				".btns($table, $row, $href)."
				<div class='clear'></div>
			</div>";
		}
		$fn .= "<a href='".$href."?add' class='pageAddLink'><span class='pageAdd'>Добавить</span></a>";
	$fn .= "</div>";

	return $fn;
}

/* --- // --- */


/* --- Multi --- */

function multibox($label, $table, $field, $order = "", $where = "") {
	global $row;
	$fn = "";

	$fn .= "<div class='formbox'>
		<div class='label label3'>".$label."</div>
		<div class='row'>";

		$arr = explode(",", $row[$field]);
		$rres = mysql_query("SELECT * FROM ".$table." WHERE 1=1 {$where} ORDER BY {$order} rate DESC, id ASC");
		if (mysql_num_rows($rres) <> 0) {
			$fn .= "<div class='mainMultiSel mainMultiBlock'>";
				while ($rrow = mysql_fetch_array($rres)) {

					$ch = "";
					if (in_array($rrow['id'], $arr)) $ch = "checked='checked'";

					$fn .= "<div class='check'>
						<label class='labelCheck checkLabel'>
							<input type='checkbox' name='".$field."[]' class='checkbox' value='".$rrow['id']."' ".$ch."><span></span>
						</label>
						<div class='checkText'>".$rrow['name']."</div>
						<div class='clear'></div>
					</div>";
				}
			$fn .= "</div>";
		}

	$fn .= "</div>
	</div>";

	return $fn;
}

/* --- // --- */


/* --- Multi set --- */

function multiset($label, $set) {
	global $row;
	$fn = "";

	$fn .= "<div class='formbox'>
		<div class='label label3'>".$label."</div>
		<div class='row'>";

		$mres = mysql_query("SELECT t.*, s.id s_id, s.weight s_weight FROM `catalog` t
			LEFT JOIN `catalog_set` s ON s.catalog = t.id AND s.set = '{$set}'
			WHERE 1=1 AND `type`=1 ORDER BY t.name ASC, t.rate DESC, t.id ASC");
		if (mysql_num_rows($mres) <> 0) {
			$fn .= "<div class='mainMultiSel mainMultiBlock'>";
				while ($mrow = mysql_fetch_array($mres)) {

					$weight = $mrow['s_weight'];

					$ch = "";
					if (!empty($mrow['s_id'])) $ch = "checked='checked'";

					if (empty($weight)) $weight = $mrow['weight'];

					$fn .= "<div class='check'>
						<label class='labelCheck checkLabel'>
							<input type='checkbox' name='catalog[]' class='checkbox' value='{$mrow['id']}' ".$ch."><span></span>
						</label>
						<div class='checkText'>{$mrow['name']}</div>
						<input type='text' name='weight{$mrow['id']}' class='small-text' value='{$weight}' placeholder='Вес'>
						<div class='clear'></div>
					</div>";
				}
			$fn .= "</div>";
		}

	$fn .= "</div>
	</div>";

	return $fn;
}

/* --- // --- */


/* --- Select --- */

function select($name, $val, $label, $required = "", $and = "", $table = "", $order = "", $class = "") {
	$table = $table == "" ? $name : $table;
	$fn = "<div class='formbox'>
		<div class='label {$class}'>".$label."</div>
		<div class='select select-wrap'>
			<select name='".$name."' class='input chosen' ".$required.">";

				$option = "Не выбрано";

				if ($table <> 'projects_status') $fn .= "<option value='0'>{$option}</option>";

				$order = "ORDER BY {$order} name ASC";
				if ($table == 'region') $order = "ORDER BY rate DESC, name ASC";
				if ($table == 'user') $order = "ORDER BY login ASC, name ASC, lastname ASC";

				$ores = mysql_query("SELECT * FROM `".$table."` WHERE 1=1 {$and} ".$order);
				while($orow = mysql_fetch_array($ores)) {
					$sl = "";
					if ($val == $orow['id']) $sl = "selected='selected'";

					$oname = $orow['name'];
					if ($table == 'user') {
						$oname = $orow['login'];
						if (!empty($orow['name'])) $oname .= " (".$orow['name']." ".$orow['lastname'].")";
					}

					$fn .= "<option value='".$orow['id']."' ".$sl.">".$oname."</option>";
				}
			$fn .= "</select>
		</div>
	</div>";

	return $fn;
}

/* --- // --- */


/* --- Select filt --- */

function select_filt($field, $val, $label, $and = "", $table = "") {

	if (empty($table)) $table = $field;

	$fn .= "<div class='formbox'>
		<div class='label'>{$label}</div>";
		$rres = mysql_query("SELECT * FROM `{$table}` WHERE 1=1 {$and} ORDER BY name ASC");
		if (mysql_num_rows($rres) <> 0) {
			$fn .= "<select name='{$field}' class='input filt-all chosen'>
				<option value='0'>Не выбрано</option>";
				while ($rrow = mysql_fetch_array($rres)) {
					$sl = "";
					if ($rrow['id'] == $val) $sl = "selected='selected'";

					$name = $rrow['name'];
					if ($table == 'user') $name = $rrow['name'] <> "" ? $rrow['name'] : $rrow['login'];

					$fn .= "<option value='".$rrow['id']."' ".$sl.">".$name."</option>";
				}
			$fn .= "</select>";
		}
		$fn .= "
	</div>";

	return $fn;
}

/* --- // --- */


/* --- Image --- */

function image($i = 1, $label, $size, $row, $table) {
	$fn = "";

	$del = "";
	if($row['path'.$i] <> "") {
		$del = "<div class='formbox'>
			<div class='image-wrap'>
				<a href='/public/images/{$table}/".$row['path'.$i]."' target='_blank'>
					<img class='image' src='/public/images/{$table}/".$row['path'.$i]."' alt='' style='max-width: 170px;' />
				</a>
			</div>
			Удалить
			".checkbox('img_del'.$i, '', $row['id'])."
		</div>";
	}

	$fn .= "<div class='formbox'>
		<div class='label label2'>{$label}<br>({$size}):</div>
		<div class='row'>
			".filebox('myfile'.$i)."
			".$del."
		</div>
		<div class='clear'></div>
	</div>";

	return $fn;
}

/* --- // --- */



/* --- Image upload --- */

function image_upload($i, $table, $width, $height, $type = "", $id = "") {
	$fn = "";

	image_dir("/public/images/{$table}/");

	$del = $_POST['img_del'.$i];
	if(!empty($del)) {
		$res = mysql_query("SELECT * FROM {$table} WHERE id='".$del."' LIMIT 1");
		$row = mysql_fetch_array($res);
		unlink(trim($row['path'.$i]));
		mysql_query("UPDATE {$table} SET path{$i}='' WHERE id='".$del."'");
	}
	$img = upload($table, 'myfile'.$i, $width, $height, 'path'.$i, $type, $id);

	return $img;
}

/* --- // --- */


/* --- Рейтинг --- */

function rate($val) {
	if (!empty($val)) return $val;
}

/* --- // --- */


/* --- Нули --- */

function emp($val) {
	if (!empty($val)) return $val;
}

/* --- // --- */


/* --- GET pagination --- */

function get(){
	$uri = $_SERVER['REQUEST_URI'];
	$arr_uri = explode('?', $uri);
	$uri = $arr_uri[1];
	$page = dataprocessing($_GET['page']);
	$uri = str_replace('page='.$page, '', $uri);
	if (!empty($uri)) $uri = '&'.$uri;
	return $uri;
}

/* --- // --- */


/* --- GOOGLE coods --- */

function coords($address) {

	$city = 'г.';
	$pos = strripos($address, $city);
	if ($pos === false) {
		$address = 'г.Санкт-Петербург,'.$address;
	}

	$params = array(
	    'address' => $address, // адрес
	    'format'  => 'json',   // формат ответа
	    'results' => 1,        // количество выводимых результатов
	    'key'     => 'AIzaSyBEYD9wzZvKAsTf-QSfd_hysSkevIN2dp4',
	);
	$http = 'https://maps.google.com/maps/api/geocode/json?' . http_build_query($params, '', '&');
	$response = json_decode(file_get_contents($http));

	$lat = $response->results[0]->geometry->location->lat;
	$lng = $response->results[0]->geometry->location->lng;
	if (!empty($lat) && !empty($lng)) {
		$coords = $lat.','.$lng;
	}

	return $coords;
}

/* --- // --- */


/* --- Yandex coods --- */

function ya_coords($address, $city) {

	$key = '6d0b3a07-e7f2-4778-aaca-9667a1894d8a';

	$city_name = "";
	if (!empty($city)) {
		$res = mysql_query("SELECT * FROM `city` WHERE id = '{$city}' LIMIT 1");
		if (mysql_num_rows($res) <> 0) {
			$row = mysql_fetch_array($res);
			$city_name = $row['name'];
		}
	}
	$address = str_replace($city_name, '', $address);
	if (!empty($city_name)) {
		$address = $city_name." ".$address;
	}
	$address = urlencode($address);

	$http = "http://geocode-maps.yandex.ru/1.x/?apikey={$key}&format=json&geocode=".$address;
	$response = json_decode(file_get_contents($http));

	$coords = (string)$response->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;
	if (!empty($coords)) {
		$arr = explode(' ', $coords);
		$coords = $arr[1].','.$arr[0];
	}

	return $coords;
}

/* --- // --- */



/* --- CBX --- */

function cbx($label, $name, $row, $text, $class = "") {

	$ch = "";
	if ($row[$name] == 1) $ch = "checked='checked'";

	$fn = "<div class='formbox'>
		<div class='label {$class}'>".$label."</div>
		<div class='row'>
			".checkbox($name, $ch)."
			".$text."
		</div>
	</div>";

	return $fn;
}

/* --- // --- */


/* --- RBX --- */

function rbx($label, $name, $row, $val) {

	$ch = "";
	if ($row[$name] == $val) $ch = "checked='checked'";

	$fn = '<div class="radio-wrap">
		<label class="radio-label">
			<input type="radio" name="'.$name.'" '.$ch.' class="input" value="'.$val.'">
			<span></span>
		</label>
		<span class="radio-text">'.$label.'</span>
		<span class="clear"></span>
	</div>';

	return $fn;
}

/* --- // --- */


/* --- RBX --- */

function radio($label, $name, $row, $field = 'name') {

	$fn .= "<div class='formbox'>
		<div class='label label2'>{$label}</div>";
		$tres = mysql_query("SELECT * FROM {$name} ORDER BY id ASC");
		while ($trow = mysql_fetch_array($tres)) {
			$fn .= rbx($trow[$field], $name, $row, $trow['id']);
		}
	$fn .= "</div>";

	return $fn;
}

/* --- // --- */


/* --- URL --- */

function urls($table, $id, $url, $name) {

	if (empty($table)) return;

	$res = mysql_query("SELECT * FROM `{$table}` WHERE id <> '".$id."' AND url = '".$url."' LIMIT 1");
	if (mysql_num_rows($res) <> 0) {
		$url = rus_to_eng($name)."-".$id;
		mysql_query("UPDATE `{$table}` SET url = '".$url."' WHERE id = '".$id."'");
	}
}

/* --- // --- */


/* --- Zakaz kol --- */

function zakaz_kol() {
	$zres = mysql_query("SELECT count(*) AS kol FROM `zakaz` WHERE `read` = 0 AND del = 0");
	$zrow = mysql_fetch_array($zres);
	$zkol = $zrow['kol'];
	if (!empty($zkol)) $zkol = " (".$zkol.")";
	else $zkol = "";
	return $zkol;
}

/* --- // --- */


/* --- Subs kol --- */

function subs_kol() {
	$zres = mysql_query("SELECT count(*) AS kol FROM `subs` WHERE `read` = 0 AND del = 0");
	$zrow = mysql_fetch_array($zres);
	$zkol = $zrow['kol'];
	if (!empty($zkol)) $zkol = " (".$zkol.")";
	else $zkol = "";
	return $zkol;
}

/* --- // --- */


/* --- Review kol --- */

function review_kol() {
	$zres = mysql_query("SELECT count(*) AS kol FROM `reviews` WHERE `read` = 0");
	$zrow = mysql_fetch_array($zres);
	$zkol = $zrow['kol'];
	if (!empty($zkol)) $zkol = " (".$zkol.")";
	else $zkol = "";
	return $zkol;
}

/* --- // --- */


/* --- Services --- */

function services($id) {
	$res = mysql_query("SELECT * FROM `services` WHERE `id` = '{$id}'");
	if (mysql_num_rows($res) <> 0) {
		$row = mysql_fetch_array($res);
		return $row['name'];
	}
	return '—';
}

/* --- // --- */


/* --- EDITS --- */

function edits($table, $row) {

	$id = $row['id'];

	$cl = "";
	if($row['show'] == 1) $cl = "admin_show_act";

	$fn = "<div style='min-width: 96px;'>
		<a class='admin_del delete-all' href='".$_SERVER['PHP_SELF']."?delete&id={$id}'></a>
		<a class='admin_edit' title='Редактировать' href='".$_SERVER['PHP_SELF']."?edit&id={$id}'></a>
		<div class='admin_show {$cl}' title='Показывать на сайте' data-id='{$id}' data-table='".$table."'></div>
	</div>";

	return $fn;
}

/* --- // --- */


/* --- Search --- */

function search($search) {

	$fn .= "<div class='formbox'>
		<input type='text' name='search' value='{$search}' class='input input-all input-all-50 filt-all' maxlength='255' placeholder='Введите название' />
		<input type='submit' name='submit' class='button submit-all' value='Поиск' />
		<div class='clear'></div>
	</div>";

	return $fn;
}

/* --- // --- */


/* --- DIR --- */

function image_dir($dir) {

	$dir = $_SERVER['DOCUMENT_ROOT'].$dir;

	if(!is_dir($dir)) {
	    mkdir($dir, 0777, true);
	}

	chdir($dir);
}

/* --- // --- */


/* --- Image del --- */

function image_del($id, $table, $path) {

	image_dir("/public/images/{$table}/");

	$res = mysql_query("SELECT * FROM `{$table}` WHERE `id` = '{$id}'");
	if (mysql_num_rows($res) <> 0) {
		$row = mysql_fetch_array($res);
		unlink($row[$path]);
	}
}

/* --- // --- */


/* --- Image view --- */

function image_view($table, $path) {

	$img = "";
	if (!empty($path)) $img = "<img src='/images/{$table}/{$path}' style='max-width: 82px; max-height: 80px;'>";

	return $img;
}

/* --- // --- */


/* --- Date field --- */

function date_field($date) {

	if (empty($date)) return;

	$date = explode("-",dataprocessing($date));
	$day = $date[2];
	$month = $date[1];
	$year = $date[0];
	$dates = mktime(0,0,0, $month, $day, $year);

	return $dates;
}

/* --- // --- */


/* ---Input rate --- */

function input_rate($table, $id, $value) {

	if (empty($value)) $value = '';

	$fn = "<input class='inputRate' class='inputRate' data-id='{$id}' data-table='{$table}' value='{$value}' />";

	return $fn;
}

/* --- // --- */


/* --- File Wrap --- */

function files($i, $label, $row, $table, $folder = '') {
	$fn = "";

	if (empty($folder)) $folder = $table;

	$del = "";
	if($row['path'.$i] <> "") {

		$video = '';
		if ($table == 'banners') $video = "<video class='video-detail' preload='' loop muted playsinline><source src='/public/files/{$folder}/{$row['path'.$i]}' type='video/mp4'></video>";

		$del = "<div class='formbox'>
			<a class='files' href='/public/files/{$folder}/".$row['path'.$i]."' target='_blank'>{$row['path'.$i]}</a>
			{$video}
			<br />Удалить
			".checkbox('img_del'.$i, '', $row['id'])."
		</div>";
	}

	if (!empty($size)) $size = "<div class='size'>{$size}</div>";

	$fn .= "<div class='formbox'>
		<div class='label label2'>{$label}:</div>
		<div class='row'>
			{$size}
			".filebox('myfile'.$i)."
			".$del."
		</div>
	</div>";

	return $fn;
}

/* --- // --- */


/* --- File upload --- */

function file_upload($i, $table, $id = "", $folder = "") {

	if (empty($folder)) $folder = $table;

	image_dir("/public/files/{$folder}/");

	$del = $_POST['img_del'.$i];
	if(!empty($del)) {
		$res = mysql_query("SELECT * FROM {$table} WHERE id='".$del."' LIMIT 1");
		$row = mysql_fetch_array($res);
		unlink(trim($row['path'.$i]));
		mysql_query("UPDATE {$table} SET path{$i}='' WHERE id='".$del."'");
	}

	$fn = uploads($table, 'myfile'.$i, 'path'.$i, $id);

	return $fn;
}

/* --- // --- */


/* --- Загрузка файла --- */

function uploads($table, $file, $field, $id) {
	$fn = "";

	$count = time();

	$count_field = preg_replace("/[^0-9]/", '', $field);
	$count += $count_field;

	if (is_uploaded_file($_FILES[$file]['tmp_name']))
	{
		$filename = $_FILES[$file]['name'];
		$path_info = pathinfo($filename);
		$extension = strtolower($path_info['extension']);

		$count++;
		$path = $count.".".$extension;
		move_uploaded_file($_FILES[$file]['tmp_name'], $path);

		$ress = mysql_query("SELECT * FROM `".$table."` WHERE id='".$id."' LIMIT 1");
		$rows = mysql_fetch_array($ress);
		unlink(trim($rows[$field]));

		$fn = ", `".$field."`='".$path."' ";
	}

	return $fn;
}

/* --- // --- */


/* --- Items --- */

function items($type, $id) {

	$res = mysql_query("SELECT * FROM `items` WHERE `type` = '{$type}' AND `ids` = '{$id}'");
	while ($row = mysql_fetch_array($res)) {
		switch ($row['type']) {
			default:
				$fn .= "<div class='item' id='item{$row['id']}'>
					<div class='item-cols'>
						<div class='item-col item-col4'>
							<input type='text' class='input items-input' value='{$row['name']}' data-id='{$row['id']}' data-field='name'>
						</div>
						<div class='item-col item-col4'>
							<input type='text' class='input items-input' value='{$row['name2']}' data-id='{$row['id']}' data-field='name2'>
						</div>
						<div class='clear'></div>
					</div>
					<div class='items-del' data-id='{$row['id']}'></div>
				</div>";
				break;
			case 'history_tab1':
			case 'history_tab2':
				$fn .= "<div class='item' id='item{$row['id']}'>
					<div class='item-cols'>
						<div class='item-col'>
							<input type='text' class='input items-input' value='{$row['name']}' data-id='{$row['id']}' data-field='name'>
						</div>
						<div class='item-col'>
							<input type='text' class='input items-input' value='{$row['name2']}' data-id='{$row['id']}' data-field='name2'>
						</div>
						<div class='item-col'>
							<input type='text' class='input items-input' value='{$row['name3']}' data-id='{$row['id']}' data-field='name3'>
						</div>
						<div class='clear'></div>
						<textarea class='input items-input items-textarea' data-id='{$row['id']}' data-field='text'>{$row['text']}</textarea>
					</div>
					<div class='items-del' data-id='{$row['id']}'></div>
				</div>";
			case 'epc':
				$fn .= "<div class='item' id='item{$row['id']}'>
					<div class='item-cols'>
						<div class='item-col item-col4'>
							<input type='text' class='input items-input' value='{$row['name']}' data-id='{$row['id']}' data-field='name'>
						</div>
						<div class='item-col item-col4'>
							<input type='text' class='input items-input' value='{$row['name2']}' data-id='{$row['id']}' data-field='name2'>
						</div>
						<div class='clear'></div>
					</div>
					<div class='items-del' data-id='{$row['id']}'></div>
				</div>";
			case 'project_items':
				$fn .= "<div class='item' id='item{$row['id']}'>
					<input type='text' class='input items-input items-input-small items-input-head' value='{$row['text']}' data-id='{$row['id']}' data-field='text' placeholder='Подзаголовок'>
					<div class='item-cols'>
						<div class='item-col item-col4'>
							<input type='text' class='input items-input' value='{$row['name']}' data-id='{$row['id']}' data-field='name'>
						</div>
						<div class='item-col item-col4'>
							<input type='text' class='input items-input' value='{$row['name2']}' data-id='{$row['id']}' data-field='name2'>
						</div>
						<div class='clear'></div>
					</div>
					<div class='items-del' data-id='{$row['id']}'></div>
				</div>";
			case 'project_plus':
				$fn .= "<div class='item' id='item{$row['id']}'>
					<textarea class='input items-input items-textarea items-textarea-full' data-id='{$row['id']}' data-field='text'>{$row['text']}</textarea>
					<div class='items-del' data-id='{$row['id']}'></div>
				</div>";
				break;
		}
	}

	return $fn;
}

/* --- // --- */


/* --- Plus --- */

function plus($head, $type, $id) {

	if (isset($_GET['add'])) return;

	$fn .= "<fieldset>
		<legend>{$head}</legend>
		<div class='items-wrap'>
			<div class='items'>".items($type, $id)."</div>
			<div class='items-add' data-type='{$type}' data-ids='{$id}'>
				+ Добавить
			</div>
		</div>
	</fieldset>";

	return $fn;
}

/* --- // --- */


?>
