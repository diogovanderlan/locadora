<?php
	//incluir o menu
	include "menu.php";
?>
	<div class="well container">
		<h1>Lista de Usuarios</h1>

		<a href="usuario.php" title="Cadastro de Usuário" class="btn btn-success pull-right">
			<i class="glyphicon glyphicon-file"></i>
			Novo Cadastro
		</a>

		<div class="clearfix"></div>

		<form name="formpesquisa" method="get"
		class="form-inline text-center">
			<label for="palavra">Palavra-chave:
			<input type="text" name="palavra"
			required placeholder="Digite uma palavra"
			class="form-control">
			</label>
			<button type="submit" class="btn btn-success">
				<i class="glyphicon glyphicon-search">
				</i>
			</button>
		</form>

		<?php
			$palavra = "";
			//verificar se esta realizando
			//substituir o $palavra por $_GET["palavra"]
			if ( isset ( $_GET["palavra"] ) ) {
				$palavra = trim ( $_GET["palavra"] );
			}

			//adicionar as %
			$palavra = "%$palavra%";

			//buscar da categoria
			$sql = "select * from usuario 
				where nome like ?
				order by nome";
			$consulta = $pdo->prepare($sql);
			//passar o parametro
			$consulta->bindParam(1,$palavra);
			//executar o sql
			$consulta->execute();

			//conta as linhas de resultado
			$conta = $consulta->rowCount();

			echo "<p>Foram encontrados $conta 
			cadastros:</p>";

		?>

		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<td width="10%">ID</td>
					<td>Nome</td>
					<td>Login</td>
					<td>Ativo</td>
					<td width="15%">Opções</td>
				</tr>
			</thead>
			<?php
			//mostrar os resultados da busca
			while ( $dados = $consulta->fetch( PDO::FETCH_OBJ ) ) {

				//separar os dados do banco de dados
				$id = $dados->id;
				$nome = $dados->nome;
				$login = $dados->login;
				$ativo = $dados->ativo;
				

				echo "<tr>
					<td>$id</td>
					<td>$nome</td>
					<td>$login</td>
					<td>$ativo</td>
					<td>
						<a href='usuario.php?id=$id'
						class='btn btn-primary'>
							<i class='glyphicon glyphicon-pencil'></i>
						</a>
						<a href='javascript:deletar($id)' 
						class='btn btn-danger'>
							<i class='glyphicon glyphicon-trash'></i>
						</a>
					</td>
				</tr>";

			}

			?>
		</table>

	</div>
	<script type="text/javascript">
		//funcao para perguntar se quer deletar
		function deletar(id) {
			if ( confirm("Deseja mesmo excluir?") ) {
				//enviar o id para uma página
				location.href = "excluirUsuario.php?id="+id;
			}
		}
	</script>

</body>
</html>






