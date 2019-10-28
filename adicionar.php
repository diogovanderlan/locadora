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

	if( isset( $_GET["locacao_id"] ) ) {
		$locacao_id = trim( $_GET["locacao_id"] );
	}

	//verificar se foi dado post
	if ( $_POST ){

		$locacao_id = $_POST["locacao_id"];
		$filme_id = $_POST["filme_id"];

		//Verificar se o filme está locado
		$sql 			= "SELECT * FROM filme_locacao WHERE status = 'Locado' AND filme_id = ? LIMIT 1";
		$consulta		= $pdo->prepare( $sql );
		$consulta		->bindParam( 1, $filme_id );
		$consulta		->execute();
		$dados			= $consulta->fetch( PDO::FETCH_OBJ );

		//Se existir filme dar mensagem
		if( isset( $dados->status ) ) {
			echo "<p class='alert alert-danger'>Este filme já está locado. Locação: $dados->locacao_id</p>";
		}else {

			//pegar o valor do filme da tabela classe
			$sql 			= "select c.valor from filme f 
				inner join classe c on (c.id = f.classe_id)
				where f.id = ? limit 1";
			$consulta 		= $pdo->prepare($sql);
			//passar o parametro - ?
			$consulta		->bindParam(1, $filme_id);
			$consulta		->execute();
			$dados 			= $consulta->fetch(PDO::FETCH_OBJ);
			$valor 			= $dados->valor;

			$datadevolucao 	= date('Y-m-d', strtotime('+2 days'));

			$status = "Locado";

			//Sql para inserir o filme na locação
			$sql 		= "INSERT INTO filme_locacao (locacao_id, filme_id, valor, datadevolucao, status) VALUES (?, ?, ?, ?, ?)";
			$consulta 	= $pdo->prepare( $sql );
			$consulta	->bindParam(1, $locacao_id );
			$consulta	->bindParam(2, $filme_id );
			$consulta	->bindParam(3, $valor );
			$consulta	->bindParam(4, $datadevolucao );
			$consulta	->bindParam(5, $status );

			if( $consulta->execute() ) {
				echo "<p class='alert alert-success'>Filme Adicionado com Sucesso ! </p>";
			} else {
				$erro = $consulta->errorInfo()[2];
				echo "<p class='alert alert-danger'>Erro ao Adicionar Filme : $erro </p>";
			}
		}	
		
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Adicionar Filme</title>
	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">

	<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
</head>
<body>
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<td>Foto</td>
				<td>Título do Filme</td>
				<td class='text-center'>Valor</td>
				<td>Data de Devolução</td>
				<td>Status</td>
				<td>Excluir</td>
			</tr>
		</thead>

		<?php
			$sql 		= "SELECT f.id, f.titulo, f.ano, f.imagem, l.valor, date_format(l.datadevolucao, '%d/%m/%Y')
				datadevolucao, l.devolucao FROM filme_locacao l
				INNER JOIN filme f ON ( f.id = l.filme_id )
				WHERE l.locacao_id = ? ORDER BY f.titulo";

			$consulta 	= $pdo->prepare( $sql );
			$consulta	->bindParam( 1, $locacao_id );
			$consulta	->execute();
			$total 		= 0;

			while( $dados = $consulta->fetch( PDO::FETCH_OBJ ) ) {

				$id 			= $dados->id;
				$titulo 		= $dados->titulo;
				$valor 			= $dados->valor;
				$datadevolucao 	= $dados->datadevolucao;
				$imagem 		= $dados->imagem;
				//Nome da pasta / nome da imagem / p.jpg
				$imagem 		= "<img src='../fotos/".$imagem."p.jpg' width='30%' class='thumbnail'>";
				$ano 			= $dados->ano;
				
				$total 			+= $valor;
				$valor 			= number_format($valor, 2, ",",".");

				if (empty($dados->devolucao)) {
					$status = "Locado";
				} else {
					$status = "Devolvido";
				}

				echo "
				<tr>
					<td>$imagem</td>
					<td>$titulo</td>
					<td class='text-center'>$valor</td>
					<td>$datadevolucao</td>
					<td>$status</td>
					<td>
						<a href='javascript:excluir($locacao_id,$id)' class='btn btn-danger'>
							<i class='glyphicon glyphicon-trash'></i>
						</a>
						<a href='javascript:devolver($locacao_id,$id)' class='btn btn-warning'>
							<i class='glyphicon glyphicon-retweet'></i>
						</a>
					</td>
				</tr>
				";	

			}

			//Formatar o Valor Total
			$total 			= number_format($total, 2, ",",".");
			$total 			= "R$ ".$total;
		?>
	</table>
	<script type="text/javascript">
		//ADicionar valor Total ao valor total fora do IFRAME
		top.$("#total").html("<?=$total;?>");

		//funcao para excluir
		function excluir(locacao,filme) {
			//perguntar se deseja mesmo excluir
			if ( confirm ("Deseja mesmo excluir?") ) {
				location.href="excluirItem.php?locacao="+locacao+"&filme="+filme;
			}
		}

		//funcao para devolver o filme
		function devolver(locacao,filme) {
			//perguntar se deseja mesmo devolver
			if ( confirm ("Deseja mesmo devolver?") ) {
				location.href="devolverItem.php?locacao="+locacao+"&filme="+filme;
			}
		}
	</script>
</body>
</html>