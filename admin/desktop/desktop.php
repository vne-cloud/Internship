<?
require_once('../config.php');
echo $HEADER;

if(ADMIN <> "true" && MODER <> "true" && MODER2 <> "true")
{
	header("location: /admin");
	exit;
}


echo "<h1>Рабочий стол</h1>"; 



echo '<div class="desk">
	<table id="calendar">
	  <thead>
		<tr><td>‹<td colspan="5"><td>›
		<tr><td>Пн<td>Вт<td>Ср<td>Чт<td>Пт<td>Сб<td>Вс
	  <tbody>
	</table>';

	echo '<div id="clockbox">
		<div id="clocks">
			<ul id="clock">
				<li id="sec" style="transform: rotate(282deg); display: block;"></li>
				<li id="hour" style="transform: rotate(94deg); display: block;"></li>
				<li id="min" style="transform: rotate(48deg); display: block;"></li>
				<li id="knob" style="display: block;"></li>
			</ul>
		</div>
	</div>
</div>
<div class="clear"></div>';

echo "<script src='/admin/js/clock.js?".rand()."'></script>";

echo $FOOTER;
?>