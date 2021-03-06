<?php

	include "menu.php";

	$id = "";
	//recuperar o id enviado por GET
	if ( isset ( $_GET["id"] ) ) {
		$id = trim ( $_GET["id"] );
	}

	//verificar se existe um filme com esta categoria
	$sql = "select * from filme
		where classe_id = ? limit 1";

	$consulta = $pdo->prepare($sql);
	$consulta->bindParam(1, $id);
	$consulta->execute();

	$dados = $consulta->fetch(PDO::FETCH_OBJ);

	//verificar se trouxe o registro
	if ( empty($dados->classe_id) ) {
		//excluir

		$sql = "delete from classe 
			where id = ? limit 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $id);
		//verificar se executou corretamente
		if ( $consulta->execute() ) {
			//enviar para a listagem
			echo "<script>location.href='listarClasse.php';</script>";
		} else {
			//deu erro avisar
			echo "<script>alert('Erro ao excluir registro!');history.back();</script>";
		}

	} else {
		//mensagem de erro
		echo "<script>alert('Não é possível excluir, pois existe um filme cadastrado com esta classe');history.back();</script>";

	}
