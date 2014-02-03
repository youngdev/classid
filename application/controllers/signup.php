<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends Base_Controller {
	const BASIC_INFORMATION 	= 'basic_information';
	const LISTING_PLAN 			= 'listing_plan';
	const VENUE_DETAILS 		= 'venue_details';
	const INSERT_PHOTOS 		= 'insert_photos';
	const PAYMENT 				= 'payment';
	
	private $basic_information_rules;
	private $listing_plan_rules;
	private $venue_details_rules;
	private $insert_photos_rules;
	private $payment_rules;
	private $user_registration_rules;

	public function __construct (){
		parent::__construct();
		$this->load->library(array('form_validation', 'email'));
		$this->load->helper(array('form', 'cookie'));
		$this->load->model(array('user_model', 'hotel_model'));
		
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
		$this->listing_plan_rules = array(
				array(
						'field'=>'plan',
						'label'=>'Plan',
						'rules'=>'required'
					)
			);
		$this->venue_details_rules = array(
				array(
						'field'=>'street',
						'label'=>'Street',
						'rules'=>'trim|required'
					),
				array(
						'field'=>'city',
						'label'=>'City/Emirate',
						'rules'=>'trim|required'
					),
				array(
						'field'=>'minimum',
						'label'=>'Minimum',
						'rules'=>'trim|required|numeric'
					),
				array(
						'field'=>'event[]',
						'label'=>'Event',
						'rules'=>'trim|numeric'
					),
				array(
						'field'=>'amenity[]',
						'label'=>'Amenity',
						'rules'=>'trim|numeric'
					),
				array(
						'field'=>'square_footage',
						'label'=>'Square Footage',
						'rules'=>'trim|numeric'
					),
				array(
						'field'=>'max_occupancy',
						'label'=>'Max Occupancy',
						'rules'=>'trim|numeric'
					)
			);
		$this->insert_photos_rules = array(
				array(
						'field'=>'terms',
						'label'=>'Terms of use',
						'rules'=>'trim|required'
					)
			);
		$this->payment_rules = array(
				array(
						'field'=>'first_name',
						'label'=>'First Name',
						'rules'=>'trim|required'
					),
				array(
						'field'=>'last_name',
						'label'=>'Last Name',
						'rules'=>'trim|required'
					),
				array(
						'field'=>'personal_email',
						'label'=>'Personal Email',
						'rules'=>'trim|required|valid_email'
					)
			);
		$this->user_registration_rules = array(
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
	}
	
	public function index(){
		$type = $this->input->get('t');
		if($type==P_SIGNUP_HOTEL)
		{
			$page = $this->input->get('p');
			switch($page)
			{
				case self::PAYMENT:
					//payment was requested
					$this->payment();
					break;
				case self::INSERT_PHOTOS:
					//inserting of photos was requested
					$this->insert_photos();
					break;
				case self::VENUE_DETAILS:
					//venue details was requested
					$this->venue_details();
					break;
				case self::LISTING_PLAN:
					//listing plan was requested
					$this->hotel_listing_plan();
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
			//save details ...
			$details = array(
					'venue_name' => $this->input->post('venue_name'),
					'venue_details' => $this->input->post('venue_type'),
					'venue_description' => $this->input->post('venue_description'),
					'name' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'contact_no' => $this->input->post('contact_no'),
					'password'=> $this->input->post('password')
				);
			$this->session->set_userdata(self::BASIC_INFORMATION);
			//if form was successfully validated
			redirect('signup/index?t='.P_SIGNUP_HOTEL.'&p='.self::LISTING_PLAN);
		}
	}
	
	private function hotel_listing_plan()
	{
		$this->form_validation->set_rules($this->listing_plan_rules);
		//Run for PHP validation
		if($this->form_validation->run() == FALSE)
		{
			$this->vars['plans'] = $this->hotel_model->listing_plans();
			$this->load->view('signup/hotel/listing_plan',$this->vars);	
		}
		else 
		{
			//save details ...
			$details = array(
					'plan' => $this->input->post('plan')
				);
			$this->session->set_userdata(self::LISTING_PLAN,$details);
			//if form was successfully validation
			redirect('signup/index?t='.P_SIGNUP_HOTEL.'&p='.self::VENUE_DETAILS);
		}
	}
	
	private function venue_details()
	{
		$this->form_validation->set_rules($this->venue_details_rules);
		//Run for PHP validation
		if($this->form_validation->run() == false)
		{
			$this->vars['events'] = $this->hotel_model->event_types();
			$this->vars['amenities'] = $this->hotel_model->amenities();
			$this->load->view('signup/hotel/venue_details',$this->vars);
		}
		else 
		{
			//save details ...
			$details = array(
					'street' => $this->input->post('street'),
					'city' => $this->input->post('city'),
					'minimum' => $this->input->post('minimum'),
					'event' => $this->input->post('event'),
					'amenity' => $this->input->post('amenity'),
					'square_footage' => $this->input->post('square_footage'),
					'max_occupancy' => $this->input->post('max_occupancy'),
				);
			$this->session->set_userdata(self::VENUE_DETAILS,$details);
			//if form was successfully validation
			redirect('signup/index?t='.P_SIGNUP_HOTEL.'&p='.self::INSERT_PHOTOS);
		}
		
	}

	private function insert_photos()
	{
		$this->form_validation->set_rules($this->insert_photos_rules);
		//Run for PHP validation
		if($this->form_validation->run() == false)
		{
			$this->load->view('signup/hotel/insert_photos',$this->vars);
		}
		else 
		{
			//save details ...
			$details = array(
					'photos' => $this->input->post('images')
				);
			$this->session->set_userdata(self::INSERT_PHOTOS,$details);
			//if form was successfully validation
			redirect('signup/index?t='.P_SIGNUP_HOTEL.'&p='.self::PAYMENT);
		}
	}
	
	private function payment()
	{
		$this->form_validation->set_rules($this->payment_rules);
		//Run for PHP validation
		if($this->form_validation->run() == false)
		{
			$listing_plan_details = $this->session->userdata(self::LISTING_PLAN);
			$listing_plan = $this->hotel_model->listing_plans($listing_plan_details['plan']);
			$this->vars['listing_plan_details'] = $listing_plan[0];
			$this->load->view('signup/hotel/payment',$this->vars);
		}
		else
		{
			//save to database ...
			$basic_information = $this->session->userdata(self::BASIC_INFORMATION);
			$venue_details = $this->session->userdata(self::VENUE_DETAILS);
			$listing_plan = $this->session->userdata(self::LISTING_PLAN);
			$photos = $this->session->userdata(self::INSERT_PHOTOS);
			$payment = $this->session->userdata(self::PAYMENT);
			
			
		}
	}
	
	public function upload()
	{
		$this->load->library('upload_handler');
	}
	
	//for paypal usage
	public function ipn_listener()
	{
		
		// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
		// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
		// Set this to 0 once you go live or don't require logging.
		define("DEBUG", 1);
		
		// Set to 0 once you're ready to go live
		define("USE_SANDBOX", 1);
		
		
		define("LOG_FILE", "./ipn.log");
		
		
		// Read POST data
		// reading posted data directly from $_POST causes serialization
		// issues with array data in POST. Reading raw POST data from input stream instead.
		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval) {
			$keyval = explode ('=', $keyval);
			if (count($keyval) == 2)
				$myPost[$keyval[0]] = urldecode($keyval[1]);
		}
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		if(function_exists('get_magic_quotes_gpc')) {
			$get_magic_quotes_exists = true;
		}
		foreach ($myPost as $key => $value) {
			if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
				$value = urlencode(stripslashes($value));
			} else {
				$value = urlencode($value);
			}
			$req .= "&$key=$value";
		}
		
		// Post IPN data back to PayPal to validate the IPN data is genuine
		// Without this step anyone can fake IPN data
		
		if(USE_SANDBOX == true) {
			$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		} else {
			$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
		}
		
		$ch = curl_init($paypal_url);
		if ($ch == FALSE) {
			return FALSE;
		}
		
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		
		if(DEBUG == true) {
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
		}
		
		// CONFIG: Optional proxy configuration
		//curl_setopt($ch, CURLOPT_PROXY, $proxy);
		//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		
		// Set TCP timeout to 30 seconds
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		
		// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
		// of the certificate as shown below. Ensure the file is readable by the webserver.
		// This is mandatory for some environments.
		
		//$cert = __DIR__ . "./cacert.pem";
		//curl_setopt($ch, CURLOPT_CAINFO, $cert);
		
		$res = curl_exec($ch);
		if (curl_errno($ch) != 0) // cURL error
			{
			if(DEBUG == true) {	
				error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
			}
			curl_close($ch);
			exit;
		
		} else {
				// Log the entire HTTP response if debug is switched on.
				if(DEBUG == true) {
					error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
					error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
		
					// Split response headers and payload
					list($headers, $res) = explode("\r\n\r\n", $res, 2);
				}
				curl_close($ch);
		}
		
		// Inspect IPN validation result and act accordingly
		
		if (strcmp ($res, "VERIFIED") == 0) {
			// check whether the payment_status is Completed
			// check that txn_id has not been previously processed
			// check that receiver_email is your PayPal email
			// check that payment_amount/payment_currency are correct
			// process payment and mark item as paid.
		
			// assign posted variables to local variables
			//$item_name = $_POST['item_name'];
			//$item_number = $_POST['item_number'];
			//$payment_status = $_POST['payment_status'];
			//$payment_amount = $_POST['mc_gross'];
			//$payment_currency = $_POST['mc_currency'];
			//$txn_id = $_POST['txn_id'];
			//$receiver_email = $_POST['receiver_email'];
			//$payer_email = $_POST['payer_email'];
		
			if(DEBUG == true) {
				error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
			}
		} else if (strcmp ($res, "INVALID") == 0) {
			// log for manual investigation
			// Add business logic here which deals with invalid IPN messages
			if(DEBUG == true) {
				error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
			}
		}
	}	

	private function user_registration(){
		// And let there be form validation
		$this->form_validation->set_rules($this->user_registration_rules);
		
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
				$user_data = $this->user_model->get_user_details(array('UserAccountID'=>$user_id));

				// FIXME add error handling
				if (count($user_data) < 1) redirect('/main', 'refresh');

				// Signin User
				$session_data = array(
					'is_logged_in'=>true,
					'user_account_id'=>$user_data[0]['UserAccountID'],
					'first_name'=>$user_data[0]['FirstName'],
					'middle_name'=>$user_data[0]['MiddleName'],
					'last_name'=>$user_data[0]['LastName'],
					'email_address'=>$user_data[0]['EmailAddress']
				);

				$this->session->set_userdata($session_data);

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