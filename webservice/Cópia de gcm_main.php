
<?php
require_once 'config.php';
include "../conexao/conexao.php";

//////////////Do some validation First//////////////
$error = 0;

if(isset($_POST['gcm_push']) && $_POST['gcm_push'] == 'gcm_push'){

	$id_user = $_POST['id_user_logado'];
	$nome_user_logado = $_POST['nome_user_logado'];
	$id_user2 = $_POST['id_user2'];
	$valor = $_POST['valor'];
	$trans_id = $_POST['trans_id'];
	$trans_dias = $_POST['dias'];

	$rs_usu2 = $con->query("SELECT usu_token_gcm FROM usuarios WHERE usu_id_face =".$id_user2);
	$gcmRegIds = $rs_usu2->fetchColumn();

	$rs_usu2 = $con->query("SELECT trans_resposta_pedido,trans_resposta_pagamento FROM transacoes WHERE trans_id =".$trans_id);
	//$trans_vencimento = $rs_usu2->fetchColumn();

	$result = $rs_usu2->fetch(PDO::FETCH_ASSOC);
	$trans_resposta_pedido = $result['trans_resposta_pedido'];
	$trans_resposta_pagamento = $result['trans_resposta_pagamento'];

}




function sendPushNotification($registration_ids, $message,$nome_user_logado,$valor,$trans_vencimento,$trans_id,$trans_resposta_pedido,$trans_resposta_pagamento) {

	$url = GOOGLE_API_URL;

	$fields2 = array('to'=>"/topics/global",'data'=>array('registration_ids' => $registration_ids, 'message' => $message, 'nome_user' => $nome_user_logado, 'tipo'=> 'envio_pedido', 'valor'=> $valor,'trans_dias'=>$trans_vencimento,'trans_id'=>$trans_id,'trans_resposta_pedido'=>$trans_resposta_pedido,'trans_resposta_pagamento'=>$trans_resposta_pagamento));
	
	//$fields = array('registration_ids' => $registration_ids, 'message' => $message, );

	$headers = array('Authorization:key=' . GOOGLE_API_KEY, 'Content-Type: application/json');
	echo json_encode($fields);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields2));

	$result = curl_exec($ch);
	if ($result === false)
		die('Curl failed ' . curl_error());

	curl_close($ch);
	return $result;

}

$pushStatus = '';

/*$query = "SELECT gcm_regid FROM gcm_users";
if ($query_run = mysqli_query($GLOBALS['mysqli_connection'], $query)) {

	$gcmRegIds = array();
	while ($query_row = mysqli_fetch_assoc($query_run)) {

		array_push($gcmRegIds, $query_row['gcm_regid']);

	}

}
*/      

if (isset($id_user)) {

	$pushMessage = "Voce recebeu um pedido de emprestimo de seu amigo ".$nome_user_logado." no valor de R$".$valor;

	//$gcmRegIds = "dGqt4m0S4eI:APA91bH2oCEXxrgVttMfq1i6AbbRNSqu8Gbsgb7ARkC1-S_VwSsI6Bbqd2HCk3x0ea-O-VaF0J47MgO8nVkm5li-mUBC7iV0ARrpzkIuseTlvFES0SPCsQnT1cSJ_hslrEKJ9-xNSVIG";
	$pushStatus = sendPushNotification($gcmRegIds, $pushMessage,$nome_user_logado,$valor,$trans_dias,$trans_id,$trans_resposta_pedido,$trans_resposta_pagamento);

	//redirect(PWD); //Comment this if you do not want to be redirected to previous page
} else {
	echo "Unknown error occured, contact your Push Notification Service Provider";

	exit ;
}
?>

