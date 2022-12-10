<?php
class naoencontradoController extends controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->loadTemplate("naoencontrado", array());
	}

}
?>