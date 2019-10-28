<?php
	//iniciar a sessao
	session_start();

	//verificar se existe o id na sessao - logado
	if ( !isset( $_SESSION["admin"]["id"] ) ) {
		//direcionar para o index
		header( "Location: index.php" );
	}

	//incluir o arquivo para conectar no banco
	include "../config/conecta.php";

	$locacao = $filme = "";

	if ( isset ( $_GET["locacao"] ) )
		$locacao = trim ( $_GET["locacao"] );
	if ( isset ( $_GET["filme"] ) )
		$filme = trim ( $_GET["filme"] );


	if ( empty ( $locacao ) ) {
		echo "<script>alert('Locação não encontrada');history.back();</script>";
	} else if ( empty ( $filme ) ) {
		echo "<script>alert('Filme não encontrado');history.back();</script>";
	} else {

		$sql = "update filme_locacao set devolucao = NOW(), status = 'Devolvido'
			where locacao_id = ? 
			and filme_id = ? 
			limit 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $locacao);
		$consulta->bindParam(2, $filme);

		if ( $consulta->execute() ) {
			echo "<script>location.href='adicionar.php?locacao_id=$locacao';</script>";
		} else {
			echo "<script>alert('Erro ao devolver filme da locação');history.back();</script>";
		}
	}
