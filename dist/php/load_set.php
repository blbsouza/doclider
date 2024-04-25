<?php
$relat = addslashes($_GET["relat"]);
$divid = addslashes($_GET["divid"]);
$relat = file_get_contents("../relatorios/$relat");

echo "<option value=''>Setor</option>";

$exp = explode("RELATORIO DE ENTRADA DE MERCADORIAS", $relat);


$i = 1;
foreach ( $exp as $ex ) {
	if ( $ex!= "                                             " ) {
		$setor_after = explode("SETOR LOJA    :",$ex);
		$setor_before = explode( "-", $setor_after[1] );
		$setor = trim($setor_before[0]);
		echo "<option value='                                             RELATORIO DE ENTRADA DE MERCADORIAS$ex'>$setor</option>";
	}
	$i++;
}