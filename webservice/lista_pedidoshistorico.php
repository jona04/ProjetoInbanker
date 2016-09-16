<?php
require_once 'config.php';
include "../conexao/conexao.php";

if(isset($_POST['user_id']) && $_POST['user_id'] != ''){

	$user_id = $_POST['user_id'];

	$rs_trans = $con->query("SELECT * FROM transacoes WHERE (trans_id_user1 = '$user_id' OR trans_id_user2 = '$user_id') AND trans_resposta_pagamento = 3 OR (trans_resposta_pedido = 1 AND trans_recebimento_empre = 0)");

	$lista_transacoes = array();
	while($row_trans = $rs_trans->fetch(PDO::FETCH_OBJ)){   
        $lista_transacoes[] = array(
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
			'trans_data_finalizada' => $row_trans->trans_data_finalizada,
		);
    }
    if(sizeof($lista_transacoes) > 0){
    	//echo "ok";
    	echo $o_json = json_encode($lista_transacoes);
	}else{
		echo "menor";
	}

}


?>