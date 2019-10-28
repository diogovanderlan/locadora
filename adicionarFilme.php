<?php
	include "menu.php";

	//recuperar o id - url - $_GET
	if ( isset ( $_GET["locacao"] ) ) {

		$locacao = trim ( $_GET["locacao"] );

		$sql = "select l.id, c.nome, l.status, 
			date_format(l.data, '%d/%m/%Y') data
			from locacao l
			inner join cliente c on 
			(c.id = l.cliente_id)
			where l.id = ? limit 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $locacao);
		$consulta->execute();
		//recuperar os dados da consulta
		$dados = $consulta->fetch(PDO::FETCH_OBJ);
		$nome = $dados->nome;
		$status = $dados->status;
		$data = $dados->data;

		if ( $status == "Pago" ) {
			//escrever em verde
			$status = "<span class='alert alert-success'>Pago</span>";
		} else {
			//escrever em vermelho
			$status = "<span class='alert alert-danger'>à Pagar</span>";
		}


	} else {

		echo "<script>alert('Requisição inválida');history.back();</script>";
		exit;

	}
?>
<div class="container">
	<div class="well">
		<h1>Processo de Locação</h1>

		<div class="thumbnail">
			<p><strong>Nome do Cliente:</strong>
			<?=$nome;?>
			<br>
			<strong>Data da Locação:</strong>
			<?=$data;?>
			<strong>Status do Pagamento:</strong>
			<?=$status;?>
			</p>
		</div>
	</div>
	<br>
	<div class="well">
		<form name="form1" method="post" action="adicionar.php" class="form-inline"
		target="iframe">

			<input type="hidden" name="locacao_id" value="<?=$locacao;?>">

			<label for="filme_id">ID Filme:
			<input type="text" name="filme_id"
			id="filme_id" class="form-control"
			readonly required>
			</label>

			<label for="filme">Filme:
			<input type="text" name="filme" id="filme" class="form-control"
			placeholder="Digite o nome do filme">
			</label>

			<button type="submit" class="btn btn-success">Adicionar</button>

		</form>

		<iframe name="iframe" src="adicionar.php?locacao_id=<?=$locacao;?>"
		width="100%" height="300px" 
		class="thumbnail"></iframe>

		<div id="total">
			R$ 0,00
		</div>

	</div> <!-- well -->
</div> <!-- container -->

<script type="text/javascript" src="../js/jquery.easy-autocomplete.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/easy-autocomplete.min.css">


<script type="text/javascript">
	//configurar as opcoes da busca do autocomplete
	options = {
		url : "filmes.php", //arquivo a consultar
		getValue: function ( element ) {
			return element.titulo; 
			//objeto de pesquisa - titulo do filme
		},
		list : {
			maxNumberOfElements : 5,
			//numero maximo de resultados da busca
			match : {
				enabled : true
				//trazer somente os resultados iguais
			},
			onSelectItemEvent: function() {
				//jogar o id do nome selecionado no campo filme_id
				item = $("#filme").getSelectedItemData().id;
				//jogar o valor no campo
				$("#filme_id").val(item).trigger("change");
			}
		}
	};
	//adicionar a funcao ao campo
	$("#filme").easyAutocomplete(options);
</script>



