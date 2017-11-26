<?php
  try { // 
    $servidor = "localhost";// servidor 
    $banco = "locadora"; // nome do banco de dados 
    $usuario = "root"; // usuario do banco 
    $senha = ""; //senha do banco de dados 

    $pdo = new PDO ("mysql:host=$servidor;dbname=$banco;charset=utf8","$usuario","$senha");

  } catch (PDOException $e) { // tratamento do erro 
    echo "Erro de Conexão " . $e->getMessage();
    exit;
  }