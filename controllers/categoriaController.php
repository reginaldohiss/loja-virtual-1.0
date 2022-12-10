<?php
class categoriaController extends controller {

	public function __construct() {
		parent::__construct();
	}

	public function ver($id) {
		if(!empty($id)) {
			$dados = array(
				'categoria' => '',
				'produtos' => array()
			);

			$produtos = new produtos();
			$dados['produtos'] = $produtos->listar_categoria($id);

			$cat = new categorias();
			$dados['categoria'] = $cat->getNome($id);

			$this->loadTemplate("categoria", $dados);
		} else {
			echo "ID não existente de categoria";
		}
	}

}
?>