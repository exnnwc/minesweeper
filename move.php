<?php
require_once("Board.php");
session_start();
var_dump($_POST["x"], $_POST["y"]);
$x= $_POST['x'];
$y = $_POST['y'];
$board=unserialize($_SESSION['board']);
$board->visible[$x][$y]=true;

$_SESSION['board']=serialize($board);
