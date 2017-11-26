<?php
	//definindo que o arquivo será um json
	header("Content-type:application/json");
	//javascript object notation

	//conectar ao banco
	include "../config/conecta.php";

	//selecionar todos os clientes
	$sql = "select id,nome,cpf from cliente order by nome";
	$consulta = $pdo->prepare($sql);
	$consulta->execute();

	while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

		$dados->nome = $dados->nome." ".$dados->cpf;
		$array[] = $dados;

	}

	//print_r( $array );
	echo json_encode( $array );

