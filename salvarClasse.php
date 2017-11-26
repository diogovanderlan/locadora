<?php

	include "menu.php";

	if ( $_POST ) {

		//recuperar os dados do formulário
		//print_r( $_POST );
		$id = trim( $_POST["id"] );
		$classe = trim( $_POST["classe"] );
		$valor = trim( $_POST["valor"] );

		// 1.499,90 -> 1499.90

		$valor = formatarvalor($valor);

		//verificar se o campo esta em branco
		if ( empty( $classe ) ) {
			//mensagem com o javascript
			echo "<script>alert('Preencha a classe');history.back();</script>";
		} else if ( empty( $valor ) ) {
			//mensagem com o javascript
			echo "<script>alert('Preencha o valor');history.back();</script>";
		} else {

			//verificar se o registro já existe
			$sql = "select * from classe
			where classe = ? and id <> ? limit 1";
			$consulta = $pdo->prepare($sql);
			$consulta->bindParam(1, $classe);
			$consulta->bindParam(2, $id);
			$consulta->execute();
			$dados = $consulta->fetch(PDO::FETCH_OBJ);

			if ( !empty( $dados->classe ) ) {
				//já existe um registro cadastrado
				echo "<script>alert('Já existe um cadastro com esta classe');history.back();</script>";
				exit;

			}

			//verificar se o id esta vazio - insert
			if ( empty ( $id ) ) {
				//gravar no banco de dados
				$sql = "insert into classe (id, classe, valor)
				values (NULL, ? , ? )";
				$consulta = $pdo->prepare($sql);
				//passar o parametro
				$consulta->bindParam(1, $classe);
				$consulta->bindParam(2, $valor);
			} else {
				//dar update
				$sql = "update classe 
					set classe = ? , valor = ?
					where id = ? 
					limit 1";
				$consulta = $pdo->prepare( $sql );
				$consulta->bindParam( 1, $classe );
				$consulta->bindParam( 2, $valor);
				$consulta->bindParam( 3, $id );

			}

			//verificar se executou corretamente
			if ( $consulta->execute() ) {

				echo "<script>alert('Registro Salvo');location.href='listarClasse.php';</script>";

			} else {

				echo "<script>alert('Erro ao Salvar');history.back();</script>";

			}
		}
	} else {

		//mensagem de erro ao acessar diretamente o arquivo
		echo "<div class='alert alert-danger container'>
		ERRO: tentativa inválida</div>";

	}

?>

</body>
</html>