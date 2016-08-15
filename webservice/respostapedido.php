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

  if($resposta == 1)
    $trans_data_finalizada = $data;

 $stmt = $con->prepare("UPDATE transacoes 
                          SET trans_resposta_pedido = :resposta, trans_data_finalizada = :data
                          WHERE trans_id = :trans_id"); 
  $stmt-> execute(array(
    ':resposta' => $resposta,
    ':data' => $trans_data_finalizada,
    ':trans_id' => $trans_id,
  ));
  $stmt->execute();

  echo "ok";
}
?>
