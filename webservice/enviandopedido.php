<?php
include "../conexao/conexao.php";

// mudamos o timezone para nao termos problema com datas
date_default_timezone_set('America/Sao_Paulo');

// ------------------ ADICIONA VIDEO ---------------- ////
if(isset($_POST['id_user_logado']) && ($_POST["id_user_logado"] != "")) {  

  $id_user = ($_POST['id_user_logado']);
  $id_user2 = ($_POST['id_user2']);

  $nome_user1 = ($_POST['nome_user1']);
  $nome_user2 = ($_POST['nome_user2']);

  $trans_dias = ($_POST['dias']);

  $data_vencimento = strtotime($_POST['data']);
  $data_vencimento = date('Y-m-d',$data_vencimento);

  $valor = ($_POST['valor']);

  $data = date("Y-m-d H:i:s");

  $stmt = $con->prepare("INSERT INTO transacoes(trans_id_user1,trans_nome_user1,trans_id_user2,trans_nome_user2,trans_valor,trans_vencimento,trans_data,trans_dias) 
              VALUES(?,?,?,?,?,?,?,?)"); 
  $stmt->bindParam(1,$id_user); 
  $stmt->bindParam(2,$nome_user1);
  $stmt->bindParam(3,$id_user2);
  $stmt->bindParam(4,$nome_user2); 
  $stmt->bindParam(5,$valor); 
  $stmt->bindParam(6,$data_vencimento);
  $stmt->bindParam(7,$data);
  $stmt->bindParam(8,$trans_dias); 

  $stmt->execute();
  $lastId = $con->lastInsertId();
  echo "ok,".$lastId;
}

?>
