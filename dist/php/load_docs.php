<?php
include "ini.php";
include "./array.php";

$search = addslashes($_GET['search']);
$search_mai = strtoupper($search);
$search_min = strtolower($search);

$path = "../relatorios/";
$diretorio = dir($path);

$ok = array();

#LEITURA DE ARQUIVOS NO DIRETORIO
$i = 0;
while($arquivo = $diretorio -> read()) {
	if ( !$search ) {
		if ( $arquivo!='.' && $arquivo!='..' ) {
			foreach ( $arr as $a ) {
				if ( strrpos($arquivo, $a['rel']) !== FALSE ) {
					$ok[$i]['arquivo'] = $arquivo;
					$ok[$i]['title'] = $a['relt'];
					$ok[$i]['tit'] = $a['rel'];
					//
					if ( $arquivo == "Cupom" ) {
						$ok[$i]['tipo'] = "cupom";
					}
					//
					if ( substr( $arquivo, -4 ) == ".pdf" ) {
						$ok[$i]['tipo'] = "pdf";
					}
				}
			}
			$i++;
		}
	} else {
		if ( $arquivo!='.' && $arquivo!='..' && $arquivo == strpos($arquivo, $search) || $arquivo!='.' && $arquivo!='..' && $arquivo == strpos($arquivo, $search_mai) || $arquivo!='.' && $arquivo!='..' && $arquivo == strpos($arquivo, $search_min) ) {
			foreach ( $arr as $a ) {
				if ( strrpos($arquivo, $a['rel']) !== FALSE ) {
					$ok[$i]['arquivo'] = $arquivo;
					$ok[$i]['title'] = $a['relt'];
					$ok[$i]['tit'] = $a['rel'];
					if ( substr( $arquivo, -4 ) == ".pdf" ) {
						$ok[$i]['tipo'] = "pdf";
					}
				}
			}
			$i++;
		}
	}
}

sort($ok);

echo json_encode($ok);

$diretorio -> close();