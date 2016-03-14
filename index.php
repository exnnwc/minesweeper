<html>
<head>
    <style>
		body{
			margin:0px;
		}
        table, tr, td{
            border:1px black solid;
            text-align:center;
        }
		.hidden{
			background-color:black;
		}
		.bomb{
			background-color:red;
		}
        .cell{
			float:left;
			border:1px grey solid;
            width:20px;
            height:20px;			
            
        }
		.row{
			
			clear:both;
		}
		.hand {
			cursor:pointer;
		}
    </style>
	<script src="http://code.jquery.com/jquery-1.12.1.min.js"></script>
	<script>
		function moveTo(x, y){
			$.ajax({
				method:"POST",
				url:"move.php",
				data:{x:x, y:y}				
			})
				.done(function (result){
					console.log(result);
                    window.location.reload();
				});
		}
        function restart(){
            $.ajax({
                method:"POST",
                url:"reset.php"
            })
                .done(function (result){
                    console.log(result);
                    window.location.reload();
                });
        }
	</script>
</head>
<body>
<input type='button' onclick="restart();" value="New Game" />


<?php
require_once("Board.php");
define("BOMB_PERCENT", 100);
session_start();

if (!isset($_SESSION['board'])){
    $board = new Board();
    $_SESSION['board']=serialize($board);
} else if (isset($_SESSION['board'])){ 
    $board = unserialize($_SESSION['board']);
}

$stop = (isset($_SESSION["GAME_OVER"]) || $board->only_bombs_left());
?>
<h1>
<?php
if (isset($_SESSION["GAME_OVER"])){
	echo "You lost. Game over.";
} else if ($board->only_bombs_left()){
	echo "You won. Congrats!";
}
?>
</h1>
<PRE>
<?php

?>
</PRE>
<?php
for ($y = 0; $y<$board::SIZE; $y++){
	echo "<div class='row'>";
    for ($x=0; $x<$board::SIZE; $x++){
		//var_dump($board->bombs[$x][$y]);
		echo "<div title='($x, $y)' class='cell";
		
        if (!$board->visible[$x][$y]){
            echo " hidden";
		if (!$stop){
				echo " hand";
		}
        } else if ($board->visible[$x][$y]){
			
			if ($board->bombs[$x][$y]==true){
				echo " bomb"; 
			} else {
				echo " ";
			}
		}
		echo "'";
		if (!$stop && !$board->visible[$x][$y]){
			echo " onclick=\" moveTo($x,$y);\"";
		}
		echo ">";
		$num_of_bombs = $board->num_of_bombs_adjacent($x, $y);
		echo ($num_of_bombs>0 && !$board->bombs[$x][$y])
			? $num_of_bombs
			: "&nbsp;";
		echo $board->bombs[$x][$y]
			? "X"
			: "";
		echo "</div>";
    }
	echo "<div>";
}

?>

</body>
</html>

