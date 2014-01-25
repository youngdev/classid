<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends Base_Controller {
	const BASIC_INFORMATION 	= 'basic_information';
	const LISTING_PLAN 			= 'listing_plan';
	const VENUE_DETAILS 		= 'venue_details';
	const INSERT_PHOTOS 		= 'insert_photos';
	const PAYMENT 				= 'payment';
	
	private $basic_information_rules;

	public function __construct (){
		parent::__construct();
		$this->load->library(array('form_validation', 'email'));
		$this->load->helper('form');
		$this->load->model('user_model');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger margin-bottom_10px data-validated">','</div>');
		$this->basic_information_rules = array(
				array(
						'field'=>'venue_name',
						'label'=>'Venue Name',
						'rules'=>'trim|required'
					),
				array(
						'field'=>'venue_type',
						'label'=>'Venue Type',
						'rules'=>'trim|required'
					),
				array(
						'field'=>'venue_description',
						'label'=>'Venue Description',
						'rules'=>'trim|required'
					),
				array(
						'field'=>'name',
						'label'=>'Name',
						'rules'=>'trim|required'
					),
				array(
						'field'=>'email',
						'label'=>'Email',
						'rules'=>'trim|required|valid_email'
					),
				array(
						'field'=>'contact_no',
						'label'=>'Contact No.',
						'rules'=>'trim|required'
					),
				array(
						'field'=>'password',
						'label'=>'Password',
						'rules'=>'trim|required|md5'
					),
				array(
						'field'=>'confirm_password',
						'label'=>'Re-enter Password',
						'rules'=>'trim|required|matches[password]|md5'
					)
			);
	}
	
	public function index(){
		$type = $this->input->get('t');
		if($type==P_SIGNUP_HOTEL)
		{
			$page = $this->input->get('p');
			switch($page)
			{
				case self::LISTING_PLAN:
					//listing plan was requested
					break;
				case self::BASIC_INFORMATION:
					//basic information page was requested
				default:
					//if no specific page was requested
					$this->hotel_basic_information();
			}
		}
		elseif($type==P_SIGNUP_USER)
		{
			$this->user_registration();	
		}
	}
	
	private function hotel_basic_information(){
		$this->form_validation->set_rules($this->basic_information_rules);
		//Run for PHP validation
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('signup/hotel/basic_information',$this->vars);
		}
		else
		{
			//if form was successfully validated
			redirect('signup/index?t='.P_SIGNUP_HOTEL.'&p='.self::LISTING_PLAN);
		}
		
	}

	private function user_registration(){
		// Let's reuse rules variable used by hotel signup instead of creating a new variable
		$this->basic_information_rules = array(
			array(
				'field'=>'firstname',
				'label'=>'First Name',
				'rules'=>'trim|required'
			),
			array(
				'field'=>'middlename',
				'label'=>'Middle Name',
				'rules'=>'trim|required'
			),
			array(
				'field'=>'lastname',
				'label'=>'Last Name',
				'rules'=>'trim|required'
			),
			array(
				'field'=>'email',
				'label'=>'Email',
				'rules'=>'trim|required|valid_email'
			),
			array(
				'field'=>'password',
				'label'=>'Password',
				'rules'=>'trim|required|md5'
			),
			array(
				'field'=>'confirm_password',
				'label'=>'Re-enter Password',
				'rules'=>'trim|required|matches[password]|md5'
			),
			array(
				'field'=>'address',
				'label'=>'Address',
				'rules'=>'trim|required'
			),
			array(
				'field'=>'nationality',
				'label'=>'Nationality',
				'rules'=>'trim|required'
			)
		);
	
		$this->form_validation->set_rules($this->basic_information_rules);
		
		// Run for PHP validation
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('signup/user/registration',$this->vars);
		}
		else 
		{
			// Save to database
			$user_id = $this->user_model->save_user(array(
				'FirstName'		=> $this->input->post('firstname'),
				'MiddleName'	=> $this->input->post('middlename'),
				'LastName '		=> $this->input->post('lastname'),
				'EmailAddress'	=> $this->input->post('email'),
				'Password'		=> $this->input->post('password'),
				'Address'		=> $this->input->post('address'),
				'Nationality'	=> $this->input->post('nationality'),
				'Type'			=> P_TYPE_USER
			));
			
			// Send confirmation email (no confirmation link since we don't have that detail on our table)
			$this->email->from('admin@partyquire.com');
			$this->email->to($this->input->post('email'));
			$this->email->subject('[Partyquire] Your registration is successful!');
			$this->email->message('Congratulations! Your account has been successfully registered!');
			
			$this->email->send();
			
			if($user_id)
			{
				$user_id = base64_encode($user_id);
				$user_id = str_replace("=", "", $user_id);
				
				// Redirect to user's profile page
				redirect('/user/profile/'.$user_id, 'refresh');
			}
			else 
			{
				// Redirect to homepage
				redirect('/main', 'refresh');
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */