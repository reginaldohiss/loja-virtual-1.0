<?php
class vendas extends model {

	public function __construct() {
		parent::__construct();
	}

	public function getPedido($id, $id_usuario) {
		$array = array();

		$sql = "SELECT *, (select pagamentos.nome from pagamentos where pagamentos.id = vendas.forma_pg) as tipopgto FROM vendas WHERE id = '$id' AND id_usuario = '$id_usuario'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetch();

			$array['produtos'] = $this->getProdutosDoPedido($id);

		}

		return $array;
	}

	public function getProdutosDoPedido($id) {
		$array = array();

		$sql = "SELECT
			vendas_produtos.quantidade,
			vendas_produtos.id_produto,
			produtos.nome,
			produtos.imagem,
			produtos.preco
		FROM vendas_produtos 
		LEFT JOIN produtos ON vendas_produtos.id_produto = produtos.id
		WHERE vendas_produtos.id_venda = '$id'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getPedidosDoUsuario($id_usuario) {
		$array = array();

		if(!empty($id_usuario)) {

			$sql = "SELECT *, (select pagamentos.nome from pagamentos where pagamentos.id = vendas.forma_pg) as tipopgto FROM vendas WHERE id_usuario = '$id_usuario'";
			$sql = $this->db->query($sql);

			if($sql->rowCount() > 0) {
				$array = $sql->fetchAll();
			}

		}

		return $array;
	}

	public function verificarVendas() {
		require 'libraries/PagSeguroLibrary/PagSeguroLibrary.php';

		$code = '';
		$type = '';

		if(isset($_POST['notificationCode']) && isset($_POST['notificationType'])) {
			$code = trim($_POST['notificationCode']);
			$type = trim($_POST['notificationType']);

			$notificationType = new PagSeguroNotificationType($type);
			$strType = $notificationType->getTypeFromValue();

			$credentials = PagseguroConfig::getAccountCredentials();

			try {
				$transaction = PagSeguroNotificationService::checkTransaction($credentials, $code);
				$ref = $transaction->getReference();
				$status = $transaction->getStatus()->getValue();

				$novoStatus = 0;
				switch($status) {
					case '1': // Aguardando Pgto.
					case '2': // Em análise
						$novoStatus = '1';
						break;
					case '3': // Paga
					case '4': // Disponível
						$novoStatus = '2';
					case '6': // Devolvida
					case '7': // Cancelada
						$novoStatus = '3';
						break;
				}

				$this->db->query("UPDATE vendas SET status_pg = '$novoStatus' WHERE id = '$ref'");

			} catch(PagSeguroServiceException $e) {
				echo "FALHA: ".$e->getMessage();
			}
		}
	}

	public function setVenda($uid, $endereco, $valor, $pg, $prods) {

		/*
		1 => Aguardando Pgto.
		2 => Aprovado
		3 => Cancelado
		*/
		$status = '1';
		$link = '';

		$sql = "INSERT INTO vendas SET id_usuario = '$uid', endereco = '$endereco', valor = '$valor', forma_pg = '$pg', status_pg = '$status', pg_link = '$link'";
		$this->db->query($sql);
		$id_venda = $this->db->lastInsertId();

		if($pg == '1') {
			$status = '2';
			$link = '/carrinho/obrigado';

			$this->db->query("UPDATE vendas SET status_pg = '$status' WHERE id = '".$id_venda."'");
			
		} elseif($pg == '2') {
			// Pagseguro
			require 'libraries/PagSeguroLibrary/PagSeguroLibrary.php';
			
			$paymentRequest = new PagSeguroPaymentRequest();
			foreach($prods as $prod) {
				$paymentRequest->addItem($prod['id'], $prod['nome'], 1, $prod['preco']);
			}
			$paymentRequest->setCurrency("BRL");
			$paymentRequest->setReference($id_venda);
			$paymentRequest->setRedirectURL("http://projetoloja.phpdozeroaoprofissional.com.br/carrinho/obrigado");
			$paymentRequest->addParameter("notificationURL", "http://projetoloja.phpdozeroaoprofissional.com.br/carrinho/notificacao");

			try {

				$cred = PagSeguroConfig::getAccountCredentials();
				$link = $paymentRequest->register($cred);

			} catch(PagSeguroServiceException $e) {
				echo $e->getMessage();
			}

		}

		foreach($prods as $prod) {
			$sql = "INSERT INTO vendas_produtos SET id_venda = '$id_venda', id_produto = '".($prod['id'])."', quantidade = '1'";
			$this->db->query($sql);
		}

		unset($_SESSION['carrinho']);

		return $link;

	}

	public function setVendaCkTransparente($params, $uid, $sessionId, $prods, $subtotal) {

		require 'libraries/PagSeguroLibrary/PagSeguroLibrary.php';

		/*
		1 => Aguardando Pgto.
		2 => Aprovado
		3 => Cancelado
		*/
		$status = '1';
		$link = '';

		$endereco = implode(', ', $params['endereco']);

		$sql = "INSERT INTO vendas SET id_usuario = '$uid', endereco = '$endereco', valor = '$subtotal', forma_pg = '6', status_pg = '$status', pg_link = '$sessionId'";
		$this->db->query($sql);
		$id_venda = $this->db->lastInsertId();

		foreach($prods as $prod) {
			$sql = "INSERT INTO vendas_produtos SET id_venda = '$id_venda', id_produto = '".($prod['id'])."', quantidade = '1'";
			$this->db->query($sql);
		}

		unset($_SESSION['carrinho']);

		$directPaymentRequest = new PagSeguroDirectPaymentRequest();
		$directPaymentRequest->setPaymentMode('DEFAULT');
		$directPaymentRequest->setPaymentMethod($params['pg_form']);
		$directPaymentRequest->setReference($id_venda);
		$directPaymentRequest->setCurrency("BRL");
		$directPaymentRequest->addParameter("notificationURL", "http://projetoloja.phpdozeroaoprofissional.com.br/carrinho/notificacao");

		foreach($prods as $prod) {
			$directPaymentRequest->addItem($prod['id'], $prod['nome'], 1, $prod['preco']);
		}

		$directPaymentRequest->setSender(
			$params['nome'],
			$params['email'],
			$params['ddd'],
			$params['telefone'],
			'CPF',
			$params['c_cpf']
		);

		$directPaymentRequest->setSenderHash($params['shash']);

		$directPaymentRequest->setShippingType(3);
		$directPaymentRequest->setShippingCost(0);
		$directPaymentRequest->setShippingAddress(
			$params['endereco']['cep'],
			$params['endereco']['rua'],
			$params['endereco']['numero'],
			$params['endereco']['comp'],
			$params['endereco']['bairro'],
			$params['endereco']['cidade'],
			$params['endereco']['estado'],
			'BRA'
		);

		$billingAddress = new PagSeguroBilling(
			array(
				'postalCode' => $params['endereco']['cep'],
				'street' => $params['endereco']['rua'],
				'number' => $params['endereco']['numero'],
				'complement' => $params['endereco']['comp'],
				'district' => $params['endereco']['bairro'],
				'city' => $params['endereco']['cidade'],
				'state' => $params['endereco']['estado'],
				'country' => 'BRA'
			)
		);

		if($params['pg_form'] == 'CREDIT_CARD') {
			$parc = explode(';', $params['parc']);

			$installments = new PagSeguroInstallment(
				'',
				$parc[0],
				$parc[1],
				'',
				''
			);

			$creditCardData = new PagSeguroCreditCardCheckout(
				array(
					'token' => $params['ctoken'],
					'installment' => $installments,
					'billing' => $billingAddress,
					'holder' => new PagSeguroCreditCardHolder(
						array(
							'name' => $params['c_titular'],
							'birthDate' => date('01/10/1979'),
							'areaCode' => $params['ddd'],
							'number' => $params['telefone'],
							'documents' => array(
								'type' => 'CPF',
								'value' => $params['c_cpf']
							)
						)
					)
				)
			);

			$directPaymentRequest->setCreditCard($creditCardData);
		}

		try {
			$credentials = PagSeguroConfig::getAccountCredentials();
			$r = $directPaymentRequest->register($credentials);

			return $r;
		} catch(PagSeguroServiceException $e) {
			die($e->getMessage());
		}

	}

	public function setLinkBySession($link, $sessionId) {
		$this->db->query("UPDATE vendas SET pg_link = '$link' WHERE pg_link = '$sessionId'");
	}















}