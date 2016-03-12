<?php
require_once("Board.php");
session_start();
var_dump($_POST["x"], $_POST["y"]);
$x= $_POST['x'];
$y = $_POST['y'];
$board=unserialize($_SESSION['board']);

$board->visible[$x][$y]=true;


if ($board->num_of_bombs_adjacent($x, $y)==0){
	search_and_unveil($x, $y, []);	
} else if ($board->bombs[$x][$y]){
	//$_SESSION['GAME_OVER']=true;	
	
} 
$_SESSION['board']=serialize($board);

function search_and_unveil($x, $y, $history){
	global $board;
	$history[] = ["x"=>$x, "y"=>$y];
	var_dump($history);
	$neighbors = $board->neighbors($x, $y);
	foreach ($neighbors as $neighbor){
		
		if ($board->num_of_bombs_adjacent($neighbor["x"], $neighbor["y"])==0 && !has_this_been_searched($neighbor["x"], $neighbor["y"], $history)){
			$board->visible[$neighbor["x"]][$neighbor["y"]]=true;
			search_and_unveil($neighbor["x"], $neighbor["y"], $history);
		}
	}
}

function has_this_been_searched($x, $y, $history){
	foreach ($history as $past){
		if ($past["x"]==$x && $past["y"]==$y){
			return true;
		}
	}
	return false;
}
/*
function search_and_unveil($home_x, $home_y, $range){
	global $board;
	$range++;
	for ($x=($home_x-$range);$x<=($home_x+$range);$x++){
		for ($y=($home_y-$range);$y<=($home_y+$range);$y++){				
			if (!($x==$home_x && $y==$home_y) && $x>=0 && $y>=0 && $x<=29 && $y<=29){
				$board->visible[$x][$y]=true;
			}		
		}
	}
}


*/