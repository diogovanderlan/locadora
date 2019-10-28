<?php
	//iniciar a sessao
	session_start();

	if ( !isset( $_SESSION["admin"]["id"] ) ) {
		//direcionar para o index
		header( "Location: index.php" );
	}

	//incluir o arquivo para conectar no banco
	include "../config/conecta.php";

  //funcao para formatar o valor
  function formatarvalor($valor) {
    $valor = str_replace( ".", "", $valor);
    //busca - valor para substituir - variavel
    
    $valor = str_replace( ",", ".", $valor);
    
    //retornar um valor
    return $valor;
  }


  //funcao para formatar datas
  function formatardata($data) {
    // 29/09/2017 -> 2017-09-29
    $data = explode( "/", $data );
    $data = $data[2]."-".$data[1]."-".$data[0];
    return $data;
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Vandersystem</title>
	<meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" 
	href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" 
	href="../css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" 
	href="../css/admin.css">

  <link rel="stylesheet" type="text/css" href="../css/summernote.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.min.css">

	<script type="text/javascript"
	src="../js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript"
	src="../js/bootstrap.min.js"></script>
	<script type="text/javascript"
	src="../js/bootstrap-inputmask.min.js"></script>
	<script type="text/javascript"
	src="../js/jqBootstrapValidation.js"></script>
	<script type="text/javascript"
	src="../js/jquery.maskMoney.min.js"></script>

  <script type="text/javascript" src="../js/summernote.min.js"></script>
  <script type="text/javascript" src="../lang/summernote-pt-BR.js"></script>
  <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

	<script>
  	$(function () { 
      //validação dos campos
  		$("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); 
      //colocar a máscara nos campos .valor - classes
      $(".valor").maskMoney({
          thousands : ".",
          decimal: ","
      });
  	} );
	</script>
</head>
<body>
    <div class="container">

    <div class="row">
      <div class="col-md-3">
        <h1>Vardersystem</h1>
      </div>
      <div class="col-md-9">
        <p class="text-center">
          <strong>VanderSystem - sua melhor Locadora</strong>
            <br>
            av brasil. 1680
            <br>
            Alto piquiri - pr
           </p>
        </div>  
      </div>

      <table class="table table-striped table-bordered">
        <thead bgcolor="#ccc">
          <tr>
            <td>ID</td>
            <td>Nome do Cliente</td>
            <td>Status</td>
            <td>Data da Locação</td>
          </tr>
        </thead>
        <?php

          $datai = $_POST["datai"];
          $dataf = $_POST["dataf"];
          //formartar as dadas 

          $datai = formatardata($datai);
          $dataf = formatardata($dataf);

          //verificar se a data final e menor que a inicial
          if ( strtotime( $datai )  > strtotime( $dataf ) ){
            
            echo "<script>alert('A data inicial nao pode ser maior que a data final');history.back();</script>";

          } else {

            $sql = "select c.nome, l.id, l.status, l.data from locacao l inner join cliente c on (c.id = l.cliente_id) where l.data >= ? and l.data <= ? order by l.data";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(1,$datai);
            $consulta->bindParam(2,$dataf);
            $consulta->execute();

            while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
              $nome   = $dados->nome;
              $status = $dados->status;
              $id     = $dados->id;
              $data   = $dados->data;

              echo "<tr>
                <td>$id</td>
                <td>$nome</td>
                <td>$status</td>
                <td>$data</td>
                </tr>";
            }
          }

        ?>

</body>
</html>