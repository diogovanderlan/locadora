<?php
	
	include "menu.php";

?>
<div class="container">
	<div class="well">
		<h1>Listar Locações</h1>

		<a href="locacao.php" 
		class="btn btn-success pull-right">
			<i class="glyphicon glyphicon-file"></i>
			Novo Cadastro
		</a>

		<div class="clearfix"></div>

		<table class="table table-hover table-bordered table-striped">
			<thead>
				<tr>
					<td>ID</td>
					<td>Nome do Cliente</td>
					<td>Data</td>
					<td>Status</td>
					<td>Opções</td>
				</tr>
			</thead>
			<tbody>
				<?php 

					$sql = "select l.id, c.nome, l.status, 
						date_format(l.data, '%d/%m/%Y') data
						from locacao l
						inner join cliente c on 
						(c.id = l.cliente_id)
						order by l.data desc";
					$consulta = $pdo->prepare($sql);
					$consulta->execute();

					while ( $dados = $consulta->fetch(PDO::FETCH_OBJ)) {

						$id = $dados->id;
						$nome = $dados->nome;
						$status = $dados->status;
						$data = $dados->data;

						echo "<tr>
						<td>$id</td>
						<td>$nome</td>
						<td>$data</td>
						<td>$status</td>
			<td>
				<a href='locacao.php?id=$id'
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
			</tbody>
		</table>
			
		</table>

	</div>
</div>

<script type="text/javascript">
	//funcao para perguntar se quer deletar
	function deletar(id) {
		if ( confirm("Deseja mesmo excluir?") ) {
			//enviar o id para uma locação
			location.href = "excluirLocacao.php?id="+id;
		}
	}
	$(".table").dataTable();
</script>




