<?php
include "../conexao/conexao.php";

// mudamos o timezone para nao termos problema com datas
date_default_timezone_set('America/Sao_Paulo');


// ------------------ ADICIONA VIDEO ---------------- ////
if(isset($_POST['usu_id_face']) && ($_POST["usu_id_face"] != "")) { 


  $usu_id_face = ($_POST['usu_id_face']);

  //$res = $con->query('SELECT COUNT(*) FROM usuarios WHERE usu_id_face ='.$usu_id_face);
  //$res = $res -> rowCount();
  //if($res == 0){

  $res = $con->query('SELECT usu_nome FROM usuarios WHERE usu_id_face ='.$usu_id_face);
  $usu_nome = $res->fetchColumn();

  if($usu_nome == ""){
    $usu_nome = ($_POST['usu_nome']);
    $usu_token = ($_POST['usu_token']);
    $usu_img = ($_POST['usu_img']);

    $data = date("Y-m-d H:i:s");

    $stmt = $con->prepare("INSERT INTO usuarios(usu_id_face,usu_nome,usu_imagem,usu_token_gcm,data) 
                VALUES(?,?,?,?,?)"); 
    $stmt->bindParam(1,$usu_id_face); 
    $stmt->bindParam(2,$usu_nome); 
    $stmt->bindParam(3,$usu_img); 
    $stmt->bindParam(4,$usu_token);
    $stmt->bindParam(5,$data); 
    $stmt->execute();

    echo 'bagulho adicionado';

  }else{
    echo 'bagulho ja foi adicionado ---- ok';
  }
  
}

?>
