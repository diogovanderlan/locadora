<?php
	include "menu.php";

	if ( $_POST ) {

		//recuperar os dados
		$id = trim ( $_POST["id"] );
		$status = trim ( $_POST["status"] );
		$data = trim ( $_POST["data"] );
		$cliente_id = trim ( $_POST["cliente_id"] );
		$usuario_id = trim ( $_POST["usuario_id"] );

		$data = formatardata( $data );

		//verificar se tem id
		if ( empty ( $id ) ) {
			//insert no banco de dados
			$sql = "insert into locacao 
			(id, data, status, cliente_id,
			usuario_id) values 
			(NULL, ?, ?, ?, ?)";
			$consulta = $pdo->prepare($sql);
			$consulta->bindParam(1, $data);
			$consulta->bindParam(2, $status);
			$consulta->bindParam(3, $cliente_id);
			$consulta->bindParam(4, $usuario_id);

			//executa o sql
			if ( $consulta->execute() ) {
				//se executar

				$id = $pdo->lastInsertId();

				echo "<script>location.href='adicionarFilme.php?locacao=$id';</script>";
				exit;

			} else {
				//se der erro
				$erro = $consulta->errorInfo()[2];
				echo "<script>alert('Erro ao salvar: $erro');history.back();</script>";
			}


		} else {
			//update no banco de dados

			$sql = "update locacao set data = ?, status = ?, cliente_id = ? 
				where id = ? limit 1";
			$consulta = $pdo->prepare($sql);
			$consulta->bindParam(1,$data);
			$consulta->bindParam(2,$status);
			$consulta->bindParam(3,$cliente_id);
			$consulta->bindParam(4,$id);

			if ( $consulta->execute() ) {
				echo "<script>location.href='adicionarFilme.php?locacao=$id';</script>";
			} else {
				echo "<script>alert('Erro ao atualizar');history.back();</script>";
				exit;
			}
		}

	} else {

		echo "<div class='alert alert-danger'>Requisição inválida</div>";

	}