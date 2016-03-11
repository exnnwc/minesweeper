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
				});
		}
	</script>
</head>
<body>



<?php
require_once("Board.php");
define("BOARD_SIZE", 29);
define("BOMB_PERCENT", 10);
$board = new Board(BOARD_SIZE);

for ($y = 0; $y<BOARD_SIZE; $y++){
	echo "<div class='row'>";
    for ($x=0; $x<BOARD_SIZE; $x++){
		echo "<div class='cell";
        if (!$board->visible[$x][$y]){
            echo " hidden";
        } else if (!$board->visible[$x][$y]){
			if (isset($board->bombs[$x][$y])){
				echo " bomb"; 
			} else {
				echo " ";
			}
		}
		echo "' onclick=\" moveTo($x,$y);\">&nbsp;</div>";
    }
	echo "<div>";
}

?>

</body>
</html>

