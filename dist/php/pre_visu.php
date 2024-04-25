<?php
include "ini.php";

$arquivo = $_GET['arq'];

$leitura = file_get_contents("../relatorios/$arquivo");

echo json_encode($leitura);