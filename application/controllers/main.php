<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends Base_Controller {

	public function __construct (){
		parent::__construct();
		// Get session
		$this->vars['is_logged_in']  = $this->session->userdata('is_logged_in');
	}
	
	public function index(){
		$this->load->view('homepage/index.php',$this->vars);
	}
	
	public function home(){
		echo "Page Under Construction";
	}
	
	public function dashboard(){
		echo "Page Under Construction";
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */