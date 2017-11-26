<?php
	//incluir o menu
	include "menu.php";

	$id = $classe = $valor = "";

	//verificar se está editando
	if ( isset ( $_GET["id"] ) ) {

		//recuperar o id por get
		$id = trim( $_GET["id"] );
		//selecionar os dados do banco
		$sql = "select * from classe where id = ? limit 1";
		//prepare
		$consulta = $pdo->prepare( $sql );
		//passar um parametro
		$consulta->bindParam( 1, $id );
		//executa
		$consulta->execute();
		//separar os dados
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

		$id = $dados->id;
		$classe = $dados->classe;
		$valor = $dados->valor;

		//formatar o valor - passar p formato R$
		$valor = number_format( $valor, 2, "," , ".");

	}


?>

<div class="container">
	<div class="well">
		<h1>Cadastro de Classes</h1>

		<a href="classe.php" 
		class="btn btn-success pull-right">
			<i class="glyphicon glyphicon-file"></i>
			Novo Cadastro
		</a>
		<a href="listarClasse.php" 
		class="btn btn-primary pull-right">
			<i class="glyphicon glyphicon-search"></i> Listar Cadastros
		</a>

		<div class="clearfix"></div>

		<form name="formcadastro" method="post" action="salvarClasse.php" novalidate>
			<fieldset>
				<legend>Preencha os campos:</legend>

				<div class="control-group">
					<label for="id">ID:</label>
					<div class="controls">
						<input type="text" name="id"
						class="form-control"
						readonly
						value="<?=$id;?>">
					</div>
				</div>

				<div class="control-group">
					<label for="classe">
					Classe:</label>
					<div class="controls">
						<input type="text" 
						name="classe"
						class="form-control"
						required
						data-validation-required-message="Preencha a classe"
						value="<?=$classe;?>">
					</div>
				</div>

				<div class="control-group">
					<label for="classe">
					Valor:</label>
					<div class="controls">
						<input type="text" 
						name="valor"
						class="form-control valor"
						required
						data-validation-required-message="Preencha o valor"
						value="<?=$valor;?>">
					</div>
				</div>

				<button type="submit" class="btn btn-success">Salvar Dados</button>


			</fieldset>
		</form>

	</div>
</div>

</body>
</html>






