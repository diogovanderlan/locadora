<?php
	//incluir o menu
	include "menu.php";
?>
	<div class="well container">
		<h1>Lista de Classes</h1>

		<a href="classe.php" title="Cadastro de Classes" class="btn btn-success pull-right">
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
			$sql = "select * from classe 
				where classe like ?
				order by classe";
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
					<td>Classe</td>
					<td>Valor</td>
					<td width="15%">Opções</td>
				</tr>
			</thead>
			<?php
			//mostrar os resultados da busca
			while ( $dados = $consulta->fetch( PDO::FETCH_OBJ ) ) {

				//separar os dados do banco de dados
				$id = $dados->id;
				$classe = $dados->classe;
				$valor = $dados->valor;
				//formatar o valor
				$valor = number_format( $valor , 2 , 
					"," , "." ); 
				//number_format ( valor, nr casas decimais, separador de decimais, separador de milhares )

				echo "<tr>
					<td>$id</td>
					<td>$classe</td>
					<td>R$ $valor</td>
					<td>
						<a href='classe.php?id=$id'
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
				location.href = "excluirClasse.php?id="+id;
			}
		}
	</script>

</body>
</html>






