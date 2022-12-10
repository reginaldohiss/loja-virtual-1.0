<?php
class categoriasController extends controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
    	$dados = array();

    	$cat = new Categorias();
    	$dados['categorias'] = $cat->getCategorias();

    	$this->loadTemplate('categorias', $dados);
    }

    public function add() {
    	$dados = array();

    	if(isset($_POST['titulo']) && !empty($_POST['titulo'])) {

    		$cat = new Categorias();
    		$cat->addCategoria($_POST['titulo']);

    		header("Location: /painel/categorias");
    	}

    	$this->loadTemplate('categorias_add', $dados);
    }

    public function edit($id) {
    	$dados = array();

    	$cat = new Categorias();

    	if(isset($_POST['titulo']) && !empty($_POST['titulo'])){    		
    		$cat->editCategoria($_POST['titulo'], $id);

    		header("Location: /painel/categorias");
    	}

    	$dados['categoria'] = $cat->getCategoria($id);

    	$this->loadTemplate('categorias_edit', $dados);
    }

    public function remove($id) {

    	if(!empty($id)) {

    		$cat = new Categorias();
    		$cat->removeCategoria($id);

    		header("Location: /painel/categorias");

    	}

    }
}
?>