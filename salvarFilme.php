<?php

	include "menu.php";

	//verificar se foi post
	if ( $_POST ) {
		
		//copiar o arquivo

		//print_r( $_FILES["imagem"] );

		//inicia o nome da imagem com vazio 
		$nome = "";

		if ( ! empty ($_FILES["imagem"]["name"] ) ) {

			$tipo = $_FILES["imagem"]["type"];
			$tamanho = $_FILES["imagem"]["size"];

			// bytes em kbytes
			$tamanho = $tamanho / 1024;

			//formatar o tamanho
			$tamanho = number_format( 
				$tamanho, 
				3, 
				".", 
				"" 
			);

			//verificar se é um arquivo JPG
			if ( $tipo != "image/jpeg" ) {
				echo "<script>alert('Você pode enviar somente arquivos JPG. Formato enviado $tipo.');history.back();</script>";
			} else if ( $tamanho > 1024 ) {

				echo "<script>alert('Envie imagens de até 1 MB. Tamanho da imagem atual $tamanho Kb');history.back();</script>";
			} else if ( !copy( 
				$_FILES["imagem"]["tmp_name"], 
				"../fotos/" . $_FILES["imagem"]["name"] ) ) {

				echo "<script>alert('Erro ao copiar arquivo');history.back();</script>";
			} else {

				//incluir o arquivo com a funcao
				include "../config/imagem.php";
				
				$pastaFotos = "../fotos/";
				$imagem = $pastaFotos . $_FILES["imagem"]["name"];
				$nome = time();
				
				//echo $nome;

				LoadImg($imagem,$nome,$pastaFotos);

			}
		} else if ( !empty ( $_POST["imagem"] ) ){

			$nome = trim ( $_POST["imagem"] );

		} 

		//salvar no banco de dados
		$id = trim ( $_POST["id"] );
		$titulo = trim ( $_POST["titulo"] );
		$original = trim ( $_POST["original"] );
		$ano = trim ( $_POST["ano"] );
		$sinopse = trim ( $_POST["sinopse"] );
		$ativo = trim ( $_POST["ativo"] );
		$classe_id = trim ( $_POST["classe_id"] );
		$categoria_id = trim ( $_POST["categoria_id"] );
		$imagem = $nome;

		if ( empty ( $id ) ) {
			//inserir
			$sql = "insert into filme (id, titulo, original, ano, sinopse, imagem, ativo, classe_id, categoria_id)
			values (NULL, ?, ?, ?, ?, ?, ?, ?, ?)";
			$consulta = $pdo->prepare( $sql );
			$consulta->bindParam( 1, $titulo );
			$consulta->bindParam( 2, $original );
			$consulta->bindParam( 3, $ano );
			$consulta->bindParam( 4, $sinopse );
			$consulta->bindParam( 5, $imagem );
			$consulta->bindParam( 6, $ativo );
			$consulta->bindParam( 7, $classe_id );
			$consulta->bindParam( 8, $categoria_id );
		} else {
			//atualizar

			$sql = "update filme set titulo = ?, original = ?, ano = ?, sinopse = ?, ativo = ?,
			classe_id = ?, categoria_id = ?, imagem = ? where id = ? limit 1";
			$consulta = $pdo->prepare( $sql );
			$consulta->bindParam( 1, $titulo );
			$consulta->bindParam( 2, $original );
			$consulta->bindParam( 3, $ano );
			$consulta->bindParam( 4, $sinopse );
			$consulta->bindParam( 5, $ativo );
			$consulta->bindParam( 6, $classe_id );
			$consulta->bindParam( 7, $categoria_id );
			$consulta->bindParam( 8, $imagem );
			$consulta->bindParam( 9, $id );

		}


		if ( $consulta->execute() ) {
			echo "<script>alert('Registro salvo');location.href='listarFilme.php';</script>";
		} else {
			echo "<script>alert('Erro ao salvar');history.back();</script>";
		}
	}




