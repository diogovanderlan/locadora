
<?php


	include "menu.php";

?>

<div class="container">
	<div class="well">
		<h1>Relatorio de Locações</h1>

		<form name="form1" method="post" action="imprimirLocacao.php" class="form-inline">
			<label for="datai">Data Inicial:</label>
			<input type="text" name="datai" class="form-control" required data-mask="99/99/9999">

			<label for="dataf">Data Final:</label>
			<input type="text" name="dataf" class="form-control" required data-mask="99/99/9999">
			<button type="submit" class="btn bnt-success">Buscar</button>
		</form>

	</div>
</div>