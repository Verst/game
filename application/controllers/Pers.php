<?
class Pers extends CI_Controller {

	function index(){
		$this->perslib->show_pers();
    	$this->perslib->show_modif();		
	}
}