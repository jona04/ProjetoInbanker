
<?php
require_once 'config.php';
include "../conexao/conexao.php";

if(isset($_POST['gcm_push']) && $_POST['gcm_push'] == 'gcm_push'){

	//$id_user = $_POST['id_user_logado'];
	//$nome_user_logado = $_POST['nome_user_logado'];
	$id_user2 = $_POST['id_user2'];
	//$valor = $_POST['valor'];
	$trans_id = $_POST['trans_id'];
	//$trans_dias = $_POST['dias'];

	$rs_usu2 = $con->query("SELECT usu_token_gcm FROM usuarios WHERE usu_id_face =".$id_user2);
	$gcmRegIds = $rs_usu2->fetchColumn();

	$rs_trans = $con->query("SELECT * FROM transacoes WHERE trans_id =".$trans_id);
	$row_trans = $rs_trans->fetch(PDO::FETCH_OBJ);

	$lista_transacoes = array(
			'trans_id' => $row_trans->trans_id,
			'trans_id_user1' => $row_trans->trans_id_user1,
			'trans_id_user2' => $row_trans->trans_id_user2,
			'trans_nome_user1' => $row_trans->trans_nome_user1,
			'trans_nome_user2' => $row_trans->trans_nome_user2,
			'trans_valor' => $row_trans->trans_valor,
			'trans_vencimento' => $row_trans->trans_vencimento,
			'trans_data_pedido' => $row_trans->trans_data,
			'trans_dias' => $row_trans->trans_dias,
			'trans_dia_pago' => $row_trans->trans_dia_pago,
			'trans_resposta_pedido' => $row_trans->trans_resposta_pedido,
			'trans_resposta_pagamento' => $row_trans->trans_resposta_pagamento,
			'trans_recebimento_empre' => $row_trans->trans_recebimento_empre,
		);
    
    if($lista_transacoes){
    	//echo "ok";
    	$o_json = json_encode($lista_transacoes);

    	$pushMessage = "Voce recebeu um pedido de emprestimo de seu amigo ".$lista_transacoes['trans_nome_user1']." no valor de R$".$lista_transacoes['trans_valor'];

		//$gcmRegIds = "dGqt4m0S4eI:APA91bH2oCEXxrgVttMfq1i6AbbRNSqu8Gbsgb7ARkC1-S_VwSsI6Bbqd2HCk3x0ea-O-VaF0J47MgO8nVkm5li-mUBC7iV0ARrpzkIuseTlvFES0SPCsQnT1cSJ_hslrEKJ9-xNSVIG";
		$pushStatus = sendPushNotification($gcmRegIds, $pushMessage,$o_json);

	}else{
		echo "menor - ";
		echo "Unknown error occured, contact your Push Notification Service Provider";
	}

}




function sendPushNotification($registration_ids, $message,$o_json) {

	$url = GOOGLE_API_URL;

	$fields2 = array('to'=>"/topics/global",
					'data'=>array('registration_ids' => $registration_ids, 'message' => $message,'tipo'=> 'envio_pedido','transacao'=> $o_json));
	
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

/*
if (isset($id_user)) {

	$pushMessage = "Voce recebeu um pedido de emprestimo de seu amigo ".$nome_user_logado." no valor de R$".$valor;

	//$gcmRegIds = "dGqt4m0S4eI:APA91bH2oCEXxrgVttMfq1i6AbbRNSqu8Gbsgb7ARkC1-S_VwSsI6Bbqd2HCk3x0ea-O-VaF0J47MgO8nVkm5li-mUBC7iV0ARrpzkIuseTlvFES0SPCsQnT1cSJ_hslrEKJ9-xNSVIG";
	$pushStatus = sendPushNotification($gcmRegIds, $pushMessage,$nome_user_logado,$valor,$trans_dias,$trans_id,$trans_resposta_pedido,$trans_resposta_pagamento);

	//redirect(PWD); //Comment this if you do not want to be redirected to previous page
} else {
	echo "Unknown error occured, contact your Push Notification Service Provider";

	exit ;
}
*/
?>

