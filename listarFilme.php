<?php
	include "menu.php";
?>
	<div class="well container">
		<h1>Lista de Filmes</h1>

		<a href="filme.php" title="Cadastro de Filme" class="btn btn-success pull-right">
			<i class="glyphicon glyphicon-file"></i>
			Novo Cadastro
		</a>

		<div class="clearfix"></div>

		
		<?php
			
			//fazer o sql
			$sql = "select f.id, f.titulo, f.ano, f.imagem, c.classe, c.valor, 
				ca.categoria 
				from filme f
				inner join classe c on
				( c.id = f.classe_id )
				inner join categoria ca on
				( ca.id = f.categoria_id )
				order by f.titulo ";
			
			$consulta = $pdo->prepare( $sql );
			$consulta->execute();

		?>
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<td width="10%">ID</td>
					<td>Capa</td>
					<td>Nome do Filme</td>
					<td>Categoria</td>
					<td>Classe</td>
					<td>Valor</td>
					<td width="15%">Opções</td>
				</tr>
			</thead>
			<?php

			while ( $dados = $consulta->fetch( PDO::FETCH_OBJ ) ) {

				$id = $dados->id;
				$imagem = $dados->imagem;
				$titulo= $dados->titulo;
				$classe = $dados->classe;
				$categoria = $dados->categoria;
				$valor = number_format( $dados->valor, 2, ",", "." );

				//12345 -> 12345p.jpg
				$imagem = $imagem . "p.jpg";
				$img = "<img src='../fotos/$imagem'
				width='100'>";

				echo "<tr>
					<td>$id</td>
					<td>$img</td>
					<td>$titulo</td>
					<td>$categoria</td>
					<td>$classe</td>
					<td>R$ $valor</td>
					<td>
						<a href='filme.php?id=$id'
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
				location.href = "excluirFilme.php?id="+id;
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









