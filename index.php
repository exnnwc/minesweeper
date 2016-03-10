<?php
require_once("Board.php");
define("BOARD_SIZE", 25);
define("BOMB_PERCENT", 10);

?>
<html>
<head>
    <style>
        table, tr, td{
            border:1px black solid;
            text-align:center;
        }
        td{
            width:25px;
            height:25px;
        }
    </style>
</head>
<body>

<table>

<?php
$board = new Board(BOARD_SIZE);


for ($y = 0; $y<BOARD_SIZE; $y++){
    echo "<tr>";
    for ($x=0; $x<BOARD_SIZE; $x++){
        echo "<td";
        if (!$board->visible){
            echo " style='background-color:black'>";
        } else if (isset($board->bombs[$x][$y])){
            echo ">x"; 
        }
        echo "</td>";
    }
    echo "</tr>";
}

?>
</table>
</body>
</html>

<?php
