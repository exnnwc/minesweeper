<?php
require_once("Board.php");
define("MAX_LEVEL", 6);
session_start();
var_dump($_POST["x"], $_POST["y"]);
$x= $_POST['x'];
$y = $_POST['y'];
$board=unserialize($_SESSION['board']);

$board->visible[$x][$y]=true;
if ($board->bombs[$x][$y]){
	$_SESSION['GAME_OVER']=true;		
} else if ($board->num_of_bombs_adjacent($x, $y)==0){
	unveil_neighbors($x, $y);
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
	
	while ($left>=0 && $board->num_of_bombs_adjacent($left, $y)==0){
		$left--;
		if ($board->num_of_bombs_adjacent($left, $y)==0){
			unveil_neighbors($left, $y);
		}
		if ($level<MAX_LEVEL){
			search_vertically_and_unveil($left, $y, $level);
		}
	}
	$right=$x;
	while ($board->num_of_bombs_adjacent($right, $y)==0 && $right<$board::SIZE){
		$right++;
		if ($board->num_of_bombs_adjacent($right, $y)==0){
			unveil_neighbors($right, $y);
		}	
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
		if ($board->num_of_bombs_adjacent($x, $up)==0){
			unveil_neighbors($x, $up);
		}
		if ($level<MAX_LEVEL){
			search_diagnolly_and_unveil($x, $up, $level);
		}
	}
	$down=$y;
	while ($board->num_of_bombs_adjacent($x, $down)==0 && $down<$board::SIZE){
		$down++;
		if ($board->num_of_bombs_adjacent($x, $down)==0){
			unveil_neighbors($x, $down);
		}
		if ($level<MAX_LEVEL){
			search_diagnolly_and_unveil($x, $down, $level);
		}
	}	
}

function unveil_neighbors($x, $y){
	global $board;
	$board->visible[$x][$y]=true;
	$neighbors = $board->neighbors($x, $y);
	foreach ($neighbors as $neighbor){
		var_dump($neighbor);
		if (!$board->visible[$neighbor["x"]][$neighbor["y"]] && $board->num_of_bombs_adjacent($neighbor["x"], $neighbor["y"])>0){
			$board->visible[$neighbor["x"]][$neighbor["y"]]=true;
		}
	}
}