<?php
	//incluir o menu
	include "menu.php";
?>
	<div class="well container">
		<h1>Lista de Clientes</h1>

		<a href="cliente.php" title="Cadastro de Clientes" class="btn btn-success pull-right">
			<i class="glyphicon glyphicon-file"></i>
			Novo Cadastro
		</a>

		<div class="clearfix"></div>

		
		<?php

			
			//buscar da categoria
			$sql = "select * from cliente order by nome";
			$consulta = $pdo->prepare($sql);
			$consulta->bindParam(1, $palavra);
			//executar o sql
			$consulta->execute();

			//conta as linhas de resultado
			$conta = $consulta->rowCount();

			echo "<p>Foram encontrados $conta  cadastros:</p>";

		?>

		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<td width="10%">ID</td>
					<td>Nome</td>
					<td>CPF</td>
					<td width="15%">Opções</td>
				</tr>
			</thead>
			<?php
			//mostrar os resultados da busca
			while ( $dados = $consulta->fetch( PDO::FETCH_OBJ ) ) {

				//separar os dados do banco de dados
				$id = $dados->id;
				$nome = $dados->nome;
				$cpf = $dados->cpf;

				echo "<tr>
					<td>$id</td>
					<td>$nome</td>
					<td>$cpf</td>
					<td>
						<a href='cliente.php?id=$id'
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
				location.href = "excluirCliente.php?id="+id;
			}
		}

		$(document).ready( function(){
			//aplicar o dataTable na tabela
			$(".table").dataTable({
				"language": {
		            "lengthMenu": "Mostrando _MENU_ registros por página",
		            "zeroRecords": "Nenhum dado encontrado - sorry",
		            "info": "Mostrando _PAGE_ de _PAGES_",
		            "infoEmpty": "Nenhum dado",
		            "infoFiltered": "(filtrado de _MAX_ total)",
		            "search": "Busca: ",
		            "paginate": {
				      "previous": "Anterior",
				      "next": "Próxima"
				    }
		        }
			});
		})
	</script>

</body>
</html>






