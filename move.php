<?php
require_once("Board.php");
define("MAX_LEVEL", 8);
session_start();
var_dump($_POST["x"], $_POST["y"]);
$x= $_POST['x'];
$y = $_POST['y'];
$board=unserialize($_SESSION['board']);

$board->visible[$x][$y]=true;

if ($board->bombs[$x][$y]){
	//$_SESSION['GAME_OVER']=true;	
	
} else if ($board->num_of_bombs_adjacent($x, $y)==0){
	search_diagnolly_and_unveil($x, $y, 0);
}  
$_SESSION['board']=serialize($board);



function search_diagnolly_and_unveil($x, $y, $level){
	global $board;
	$level++;
	$left=$x;
	if ($level<MAX_LEVEL){
		search_vertically_and_unveil($x, $y, $level);
	}
	
	while ($left>-1 && $board->num_of_bombs_adjacent($left, $y)==0){
		$left--;
		$board->visible[$left][$y]=true;
		if ($level<MAX_LEVEL){
			search_vertically_and_unveil($left, $y, $level);
		}
	}
	$right=$x;
	while ($board->num_of_bombs_adjacent($right, $y)==0 && $right<30){
		$right++;
		$board->visible[$right][$y]=true;
		if ($level<MAX_LEVEL){
			search_vertically_and_unveil ($right, $y, $level);
		}
	}
}

function search_vertically_and_unveil($x, $y, $level){
	global $board;
	$level++;
	$up=$y;
	if ($level<MAX_LEVEL){
		search_diagnolly_and_unveil($x, $y, $level);
	}
	while ($up>-1 && $board->num_of_bombs_adjacent($x, $up)==0){
		$up--;
		$board->visible[$x][$up]=true;
		if ($level<MAX_LEVEL){
			search_diagnolly_and_unveil($x, $up, $level);
		}
	}
	$down=$y;
	while ($board->num_of_bombs_adjacent($x, $down)==0 && $down<30){
		$down++;
		$board->visible[$x][$down]=true;
		if ($level<MAX_LEVEL){
			search_diagnolly_and_unveil($x, $down, $level);
		}
	}	
}