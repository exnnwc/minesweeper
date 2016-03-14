<?php
session_start();
unset ($_SESSION['board']);
unset ($_SESSION["GAME_OVER"]);
var_dump($_SESSION);
