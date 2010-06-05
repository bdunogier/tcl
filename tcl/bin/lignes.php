<?php
include 'config.php';

$parserLigne = new tclLignes();
$res = $parserLigne->get();

print_r( array_slice( $res, 0, 10 ) );
?>