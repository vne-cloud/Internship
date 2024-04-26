<?php
/* --- Чтение .env для базы --- */

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Dotenv;

$dotenv = Dotenv\Dotenv::create($_SERVER['DOCUMENT_ROOT'], '.env');
$dotenv->load();

/* --- // --- */


/* --- Сессия --- */

ob_start();
session_start();

/* --- // --- */


/* --- Соединение с базой MYSQL --- */

$dblocation = env('DB_HOST', 'localhost');
$dbname = env('DB_DATABASE');
$dbuser = env('DB_USERNAME');
$dbpass = env('DB_PASSWORD');


$mysqli = new mysqli($dblocation, $dbuser, $dbpass, $dbname);
if ($mysqli->connect_errno) {
	echo "Сервер базы данных недоступен, повторите попытку позже";
	exit();
}

$mysqli->query("set character_set_results=utf8");
$mysqli->query("set character_set_connection=utf8");
$mysqli->query("set character_set_client=utf8");
$mysqli->query("set character_set_database=utf8");

/* --- // --- */


/* --- PHP 5 TO PHP 7 --- */

function mysql_query($query)
{
	global $mysqli;
	return $mysqli->query($query);
}
function mysql_fetch_array($res)
{
	if (empty($res)) return "";
	$row = $res->fetch_array(MYSQLI_ASSOC);
	return $row;
}
function mysql_num_rows($res)
{
	return $res->num_rows;
}
function mysql_insert_id()
{
	global $mysqli;
	return $mysqli->insert_id;
}
function mysql_real_escape_string($value)
{
	global $mysqli;
	return $value = $mysqli->real_escape_string($value);
}
function mysql_escape_string($value)
{
	global $mysqli;
	return $value = $mysqli->real_escape_string($value);
}

/* --- // --- */