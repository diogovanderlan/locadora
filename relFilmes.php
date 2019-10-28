<?php


	include "menu.php";

?>

<div class="container">
	<div class="well">
		<h1>Relatorio de Filme</h1>

		<form name="form1" method="post" action="imprimirFilme.php" class="form-inline">
			<label for="status">Selecione um Status:</label>
			<select name="status" class="form-control">
				<option value="T">Todos</option>
				<option value="L">Locados</option>
				<option value="D">Disponiveis</option>
			</select>
			<button type="submit" class="btn bnt-success">Buscar</button>
		</form>

	</div>
</div>