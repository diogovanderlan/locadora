<?php

	include "menu.php";

	$id = $nome = $cpf = $email = $datanascimento = $telefone = "";

	if ( isset ($_GET["id"] ) ) {

		$id = trim ( $_GET["id"] );
		$sql = "select *, 
			date_format(datanascimento,'%d/%m/%Y') dt 
			from cliente where id = ? limit 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $id);
		if ( !$consulta->execute() ) {
			//trazer uma mensagem de erro
			echo $consulta->errorInfo()[2];

		} else {
			$dados = $consulta->fetch(PDO::FETCH_OBJ);

			$nome = $dados->nome;
			$cpf = $dados->cpf;
			$datanascimento = $dados->dt;
			$email = $dados->email;
			$telefone = $dados->telefone;
		}

	}


?>
<div class="container">
	<div class="well">
		<h1>Cadastro de Clientes</h1>

		<a href="cliente.php" 
		class="btn btn-success pull-right">
			<i class="glyphicon glyphicon-file"></i>
			Novo Cadastro
		</a>
		<a href="listarCliente.php" 
		class="btn btn-primary pull-right">
			<i class="glyphicon glyphicon-search"></i> Listar Cadastros
		</a>

		<div class="clearfix"></div>

		<form name="form1" method="post" 
		action="salvarCliente.php" 
		enctype="multipart/form-data"
		novalidate>

			<div class="control-group">
				<label for="id">ID</label>
				<div class="controls">
					<input type="text" readonly 
					name="id" id="id" 
					class="form-control"
					value="<?=$id;?>">
				</div>
			</div>

			<div class="control-group">
				<label for="nome">Nome</label>
				<div class="controls">
					<input type="text" name="nome"
					required data-validation-required-message="Preencha seu nome completo"
					class="form-control"
					placeholder="Nome Completo"
					value="<?=$nome;?>">
				</div>
			</div>

			<div class="control-group">
				<label for="email">E-mail</label>
				<div class="controls">
					<input type="email" name="email"
					required data-validation-required-message="Preencha seu e-mail"
					data-validation-email-message="Digite um e-mail válido"
					class="form-control"
					placeholder="E-mail válido"
					value="<?=$email;?>">
				</div>
			</div>

			<div class="control-group">
				<label for="cpf">CPF</label>
				<div class="controls">
					<input type="text" name="cpf"
					id="cpf" required
					data-validation-required-message="Preencha seu CPF" class="form-control" placeholder="Digite somente número"
					data-mask="999.999.999-99"
					value="<?=$cpf;?>" onblur="verificaCpf(this.value)">

					<div id="msgcpf"></div>
				</div>
			</div>

			<div class="control-group">
				<label for="datanascimento">Data de Nascimento:</label>
				<div class="controls">
					<input type="text" name="datanascimento" 
					id="datanascimento" 
					required
					data-validation-required-message="Digite sua data de nascimento"
					data-mask="99/99/9999"
					onblur="verificaData(this.value)"
					value="<?=$datanascimento;?>"
					class="form-control">
				</div>
			</div>

			<div class="control-group">
				<label for="telefone">Telefone:</label>
				<div class="controls">
					<input type="text" name="telefone"
					required
					data-validation-required-message="Digite um telefone"
					data-mask="(99) 9999-9999?9"
					value="<?=$telefone;?>"
					class="form-control">
				</div>
			</div>

			<button type="submit" class="btn btn-success">Salvar/Atualizar</button>

			<script type="text/javascript">
				function verificaCpf(cpf) {
					//console.log( cpf );
					//mostrar a mascara
					$("#mascara").show();

					id = $("#id").val();

					if ( cpf == "___.___.___-__" ) {

						alert("Preencha o CPF");
						$("#cpf").focus();


					} else {

						$.get("verificaCpf.php",
						{cpf:cpf, id:id},
						function(dados) {
							if ( dados != "ok" ) {
								alert( dados );
								//focar no campo

								$("#cpf").focus();
								$("#cpf").val("");
							}
							
						})
					}
					$("#mascara").hide();
				}

				//funcao para verificar a data
				function verificaData( data ) {
					//mostrar a mascara
					$("#mascara").show("fast");

					if ( data != "") {
						//ajax
						$.get("data.php",
							{data:data},
							function(dados){

							if ( dados != "ok" ) {
								alert(dados);
								$("#datanascimento").focus();
								$("#datanascimento").val('');
							}
						})
					}
					$("#mascara").hide("fast");
				}
			</script>







