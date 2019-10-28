<?php
	//incluir o menu
	include "menu.php";

	$id = $titulo = $original = $ano = $imagem = 
	$sinopse = $classe_id = $categoria_id = 
	$ativo = $valor = "";

	//verificar se está editando
	if ( isset ( $_GET["id"] ) ) {

		//recuperar o id por get
		$id = trim( $_GET["id"] );
		//selecionar os dados do banco
		$sql = "select * from filme where id = ? limit 1";
		//prepare
		$consulta = $pdo->prepare( $sql );
		//passar um parametro
		$consulta->bindParam( 1, $id );
		//executa
		$consulta->execute();
		//separar os dados
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

		$id = $dados->id;
		$titulo = $dados->titulo;
		$original = $dados->original;
		$ano = $dados->ano;
		$imagem = $dados->imagem;
		$sinopse = $dados->sinopse;
		$classe_id = $dados->classe_id;
		$categoria_id = $dados->categoria_id;
		$ativo = $dados->ativo;


	}
?>
<div class="container">
	<div class="well">
		<h1>Cadastro de Filmes</h1>

		<a href="filme.php" 
		class="btn btn-success pull-right">
			<i class="glyphicon glyphicon-file"></i>
			Novo Cadastro
		</a>
		<a href="listarFilme.php" 
		class="btn btn-primary pull-right">
			<i class="glyphicon glyphicon-search"></i> Listar Cadastros
		</a>

		<div class="clearfix"></div>

		<form name="form1" method="post" 
		action="salvarFilme.php" 
		enctype="multipart/form-data"
		novalidate>

			<div class="control-group">
				<label for="id">ID</label>
				<div class="controls">
					<input type="text" readonly 
					name="id" class="form-control"
					value="<?=$id;?>">
				</div>
			</div>

			<div class="control-group">
				<label for="titulo">Título do Filme:
				</label>
				<div class="controls">
					<input type="text" name="titulo"
					class="form-control" 
					value="<?=$titulo;?>" required
					data-validation-required-message="Preencha o Título do filme">
				</div>
			</div>

			<div class="control-group">
				<label for="original">
				Título Original:
				</label>
				<div class="controls">
					<input type="text" name="original"
					class="form-control"
					required value="<?=$original;?>"
					data-validation-required-message="Preencha o título original">
				</div>
			</div>

			<div class="control-group">
				<label for="ano">Ano:</label>
				<div class="controls">
					<input type="text" 
					name="ano"
					class="form-control"
					required value="<?=$ano;?>"
					data-validation-required-message="Preencha o ano"
					data-mask="9999">
				</div>
			</div>

			<div class="control-group">
				<label for="sinopse">
				Sinopse:
				</label>
				<div class="controls">
					<textarea name="sinopse"
					class="form-control"
					required
					data-validation-required-message="Preencha a Sinopse"
					rows="5"><?=$sinopse;?></textarea>
				</div>
			</div>

			<div class="control-group">
				<label for="imagem">
				Imagem (Foto JPG com largura mínima de 800px):
				</label>
				<div class="controls">
					
					<input type="file"
					name="imagem"
					class="form-control"
					>
					<input type="hidden"
					name="imagem"
					value="<?=$imagem;?>">


				</div>
			</div>

			<div class="control-group">
				<label for="ativo">
				Ativo:
				</label>
				<div class="controls">
					<input type="radio"
					name="ativo"
					value="Sim"
					checked
					id="ativosim"
					required
					data-validation-required-message="Selecione uma opção"
					> Sim
					<input type="radio"
					name="ativo"
					id="ativonao"
					value="Não"
					required
					data-validation-required-message="Selecione uma opção"> Não
				</div>
				<script type="text/javascript">
				<?php
					if ( $ativo == "Não" ) {
						echo "$('#ativonao').prop('checked',true)";
					} else {
						echo "$('#ativosim').prop('checked',true)";
					}
				?>
				</script>
			</div>


			<div class="control-group">
				<label for="classe_id">
				Selecione a Classe
				</label>
				<div class="controls">
					<select name="classe_id"
					class="form-control"
					required id="classe_id"
					data-validation-required-message="Selecione uma Classe">
						<option value="">Selecione uma classe</option>
						<?php
						//selecionar todas as classes
						$sql = "select * from classe
							order by classe";
						//preparar o sql
						$consulta = $pdo->prepare($sql);
						//executar o sql
						$consulta->execute();
						//laço para pegar registro por registro
						while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
							//separar os dados
							$id = $dados->id;
							$classe = $dados->classe;
							echo "<option value='$id'>
							$classe</option>";
						}
						?>
					</select>
					<script type="text/javascript">
						$("#classe_id").val('<?=$classe_id;?>');
					</script>
				</div>
			</div>

			<div class="control-group">
				<label for="categoria_id">
				Selecione a Categoria
				</label>
				<div class="controls">
					<select name="categoria_id"
					class="form-control"
					required id="categoria_id"
					data-validation-required-message="Selecione uma Categoria">
						<option value="">
							Selecione uma Categoria
						</option>
						<?php
						//selecionar as categorias
						$sql = "select * from categoria order by categoria";
						//preparar o sql e executar
						$consulta = $pdo->prepare($sql);
						$consulta->execute();

						while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {

							$id = $dados->id;
							$categoria = $dados->categoria;

							echo "<option value='$id'>$categoria</option>";

						}
						?>
					</select>
					<script type="text/javascript">
						$("#categoria_id").val('<?=$categoria_id;?>');
					</script>
				</div>
			</div>


			<button type="submit" class="btn btn-success">Gravar Dados</button>


			<script type="text/javascript">
				$(document).ready( function () {
					$("textarea").summernote({
						height: 200,
						lang: "pt-BR"
					})
				})
			</script>







