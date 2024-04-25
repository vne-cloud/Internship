<?php
require_once('../config.php');

if(ADMIN <> "true" && MODER <> "true" && PARTNER <> "true")
{
	header("location: /admin");
	exit;
}

if(isset($_GET['delete']) && isset($_GET['id']))
{
	$id = dataprocessing($_GET['id']);

	//mysql_query("DELETE FROM sends WHERE id='".$id."'");

	$_SESSION['notice'] = "Удалено";

	header("location: ".$_SERVER['PHP_SELF']."");
}
else {
	echo $HEADER;

	$search = $where = "";

	//архив
	$arhiv = (int)adataprocessing($_GET['arhiv']);
	if($arhiv == 1) {
		$where .= " AND s.arhiv = '1'";
		echo "<h1>Архив заявок</h1>";
		echo "<a href='".$_SERVER['PHP_SELF']."' class='button button-arhiv'>Новые</a>";
	}
	else {
		$where .= " AND s.arhiv = '0'";
		echo "<h1>".h1()."</h1>";
		echo "<a href='".$_SERVER['PHP_SELF']."?arhiv=1' class='button button-arhiv'>Архив</a>";
	}

	//поиск
	if(!empty($_GET['search'])) {
		$search = adataprocessing($_GET['search']);
		$where .= " AND (s.name LIKE '%".$search."%' OR s.phone LIKE '%".$search."%')";
	}

	$colors = array('#4461ad', '#424243', '#e62a2a');

	echo "<div class='filter'>
		<div class='filterHead'>Фильтр</div>
		<form name='' action='".$_SERVER['PHP_SELF']."' method='GET'>
			<div class='formbox-left'>
				<div class='formbox'>
					<input type='text' name='search' value='".$search."' class='input input-all input-all-50 filt-all' maxlength='255' placeholder='Поиск' style='width: 319px !important;' autocomplete='off' />
					<input type='submit' name='submit' class='button submit-all' value='Поиск' />
					<div class='clear'></div>
				</div>
			</div>
			<div class='clear'></div>
			<input type='hidden' name='arhiv' value='{$arhiv}'>
		</form>
	</div>";

	echo "<div class='listContent'>";

		$query = "SELECT s.*, t.name t_name
		FROM sends s
		LEFT JOIN sends_type t ON t.id = s.type
		WHERE 1=1 ".$where;

		$sq=mysql_query($query);
		$all=mysql_num_rows($sq);
		if ($all)
		{
			echo "<table class='table tablesorter'>
				<thead>
					<tr>
						<th class='tr-hide'>ID</th>
						<th>Тип</th>
						<th>Дата</th>
						<th>Имя</th>
						<th>Телефон</th>
						<th>Текст</th>
						<th></th>
					</tr>
				</thead>
				<tbody>";

				$pnumber = 100;
				$n = new Navigator($all, $pnumber, "");
				$q=mysql_query($query." ORDER BY s.id DESC LIMIT ".$n->start().",$pnumber");
				while ($row=mysql_fetch_array($q))
				{
					$id = $row['id'];
					$status = $row['status'];

					$st = "";
					if ($row['read'] == 0) $st = "background: #feffea;";

					echo "<tr id='sends".$row['id']."' style='".$st."'>
						<td class='tr-hide'>{$row['id']}</td>
						<td><strong>".$row['type']."</strong></td>
						<td><div class='tr-hide'>{$row['date']}</div><div class='send-date'>".date("d.m.Y H:i", $row['date'])."</div></td>
						<td>".$row['name']."</td>
						<td>".$row['phone']."</td>
						<td>".nl2br($row['text'])."</td>
						<td>";
							if ($arhiv == 1) echo "<span class='sends-status' data-id='{$row['id']}' data-status='0'>в новые</span>";
							else echo "<span class='sends-status' data-id='{$row['id']}' data-status='1'>в архив</span>";
						echo "</td>
					</tr>";

					mysql_query("UPDATE sends SET `read` = 1 WHERE id = '".$row['id']."'");
				}

				echo "</tbody>
			</table>";
		}
		else {
			echo "<div class='formbox_show'>Ничего не найдено</div>";
		}

	echo "</div>";

	if ($all > 0) echo $n->navi();

	echo $FOOTER;
}

?>
