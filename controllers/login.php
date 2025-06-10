<?php

require("conexao.php");

if(!isset($_SESSION)){
    session_start();
}

if($_SESSION['token'])

?>