<?php

   //iniciando conexão com o banco de dados
   $con = mysqli_connect("localhost", "root", ""); 
   if (!$con) die("falha ao conectar");
   $dbname = 'captura';
   
   $con->select_db("captura");//'captura' é o nome do DB

   //deletar os dados das tabelas no banco
   $sqldel = "TRUNCATE TABLE captura";
   $con->query($sqldel) or die(mysql_error());


   //Abrindo e lendo o arquivo csv
   $file = "a.csv";
   $objeto= fopen($file, "r");
   $row = 1;
   //';' indica que o parametro para capturar os dados, faz percorer o conteudo da planinha
   while (($dados = fgetcsv($objeto, 1000, ";"))!==FALSE){ 
      $re = '/\d{2}\/\d{2}\/\d{4}/m'; //regex para capturar uma data caso a data venha com dd/mm/yy e a hora de criação
      preg_match ($re,$dados[0],$str);
      $dados[0]=str_replace($re, $dados[0], $str[0]);

      //Query para inserir dados no DB
      $sql = "INSERT INTO CAPTURA (nome, cpf, cargo, data, partido) VALUES ('$dados[6]','$dados[7]','$dados[5]', '$dados[0]', '$dados[3]')";
      $con->query($sql) or die(mysql_error());


      

      
      //print_r($str[0]);
      
   }

   print_r("Dados salvos");
   fclose($objeto);