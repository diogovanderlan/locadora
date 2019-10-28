<?php

	include "menu.php";

	$id = "";
	//recuperar o id enviado por GET
	if ( isset ( $_GET["id"] ) ) {
		$id = trim ( $_GET["id"] );
	}

	//verificar se existe um filme com esta categoria
	$sql = "select * from filme_locacao
		where filme_id = ? limit 1";

	$consulta = $pdo->prepare($sql);
	$consulta->bindParam(1, $id);
	$consulta->execute();

	$dados = $consulta->fetch(PDO::FETCH_OBJ);

	//verificar se trouxe o registro
	if ( empty($dados->filme_id) ) {
		//excluir

		$sql = "delete from filme 
			where id = ? limit 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $id);
		//verificar se executou corretamente
		if ( $consulta->execute() ) {
			//apagar as imagens 


			//enviar para a listagem
			echo "<script>location.href='listarFilme.php';</script>";
		} else {
			//deu erro avisar
			echo "<script>alert('Erro ao excluir registro!');history.back();</script>";
		}

	} else {
		//mensagem de erro
		echo "<script>alert('Não é possível excluir, pois existe uma locação com este filme. Você pode deixá-lo inativo');history.back();</script>";

	}
