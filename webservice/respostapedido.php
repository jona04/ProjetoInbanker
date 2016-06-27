<?php
require_once 'config.php';
include "../conexao/conexao.php";

// mudamos o timezone para nao termos problema com datas
date_default_timezone_set('America/Sao_Paulo');

// ------------------ atualiza transacao ---------------- ////
if(isset($_POST['resposta']) && ($_POST["resposta"] != "")) {  

  $resposta = ($_POST['resposta']);
  $trans_id = ($_POST['trans_id']);

  $data = date("Y-m-d H:i:s");

 $stmt = $con->prepare("UPDATE transacoes 
                          SET trans_resposta_pedido = :resposta
                          WHERE trans_id = :trans_id"); 
  $stmt-> execute(array(
    ':resposta' => $resposta,
    ':trans_id' => $trans_id,
  ));
  $stmt->execute();

  echo "ok";
}
?>
