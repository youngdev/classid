<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Base_Controller
{
	/**
	 * Constructor
	 * - Self explanatory dude
	 * @return null
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model('user_model');
		$this->load->helper(array('file', 'directory'));

		$this->vars['nav_menu'] = array(
			'Home'			=> base_url(),
			'UAE Cities'	=> '',
			'Hotel Venue & Packages'=> '',
			'Restaurant Venue Packages'=> '',
			'Meetings Venue Packages'=> ''
		);
	}

	/**
	 * Profile
	 * - User Profile page, with all the niff naffs with it
	 * @return Boolean
	 */
	public function profile(){
		$user_details 	= Array();
		$venue_details	= Array();
		$filename 		= Array();
		$activities = Array(
			'Messages'		=> Array(),
			'ViewedVenue'	=> Array(),
			'BookedVenue'	=> Array(),
		);

		// Get URI
		$user_id = $this->uri->segment(3);

		if($user_id)
		{
			$this->vars['UserID'] = $user_id;
			$this->vars['CurrentUserID'] = $this->session->userdata('user_account_id');
			$user_id = base64_decode($user_id);

			// Get user details
			$user_details = $this->user_model->get_user_details(array('tbluseraccounts.UserAccountID'=>$user_id));

			if (count($user_details) > 0)
			{
				// Get messages details
				$activities['Messages'] = $this->user_model->get_activity_details(array(
					'ActivityName'	=> 'Requested Quotation',
					'UserAccountID'	=> $user_id
				));

				// Get venues viewed
				$activities['ViewedVenue'] = $this->user_model->get_activity_details(array(
					'ActivityName'	=> 'View Venue Details',
					'UserAccountID'	=> $user_id
				));

				// Get venues booked
				$activities['BookedVenue'] = $this->user_model->get_activity_details(array(
					'ActivityName'	=> 'Book Venue',
					'UserAccountID'	=> $user_id
				));

				// Check if user has profile image uploaded to the server
				$files = get_filenames('./assets/profile/' . $this->vars['UserID'] . '/');

				if($files)
				{
					$filename = preg_grep('/profile\.(png|jpg|gif)/', $files);
				}

				if(count($filename) > 0)
				{
					$this->vars['ProfileImage'] = base_url() . 'assets/profile/' . $this->vars['UserID'] . '/' . $filename[0];
				}
				else
				{
					$this->vars['ProfileImage'] = base_url() . 'images/default.png';
				}

				if(count($user_details) > 0)
				{
					$this->vars['Name']			= $user_details[0]['FirstName'].' '.$user_details[0]['MiddleName'].' '.$user_details[0]['LastName'];
					$this->vars['Address']		= $user_details[0]['Address'];
					$this->vars['Languages']	= $user_details[0]['Languages'];
					$this->vars['QuotesCount']	= count($activities['Messages']);
					$this->vars['ViewedCount']	= count($activities['ViewedVenue']);
					$this->vars['BookedCount']	= count($activities['BookedVenue']);
					$this->vars['VenuesViewed'] = Array();

					// Fetch Venues visited
					if($this->vars['ViewedCount'] > 0)
					{
						foreach($activities as $indx=>$activity)
						{
							if($indx > 2)
							{
								break;
							}

							array_push($venue_details, $activity['ActivityDescription']);
						}

						$viewed_venues = $this->user_model->get_venue_details(array(
							'IsMultiple'	=> true,
							'VenueIDs'		=> $venue_details
						));

						if(count($viewed_venues) > 0)
						{
							$this->vars['VenuesViewed'] = $viewed_venues;
						}
					}
				}

				$this->load->view('user/profile', $this->vars);
				return true;
			}
		}

		// Redirect to Error 404
		show_404('page');
		return false;
	}

	/**
	 * Messaging module
	 * - Includes inbox along with filtering, and message sending
	 * @return null
	 */
	public function message()
	{
		$action = $this->input->get('a');
		$to_user = $this->input->get('u');
		$offset = $this->input->get('p');
		$user_id = $this->session->userdata('user_account_id');

		// Check if current user is to_user
		if($user_id == base64_decode($to_user))
		{
			$args = array(
				'Recipients'	=> $user_id,
				'limit'			=> 10
			);

			if ($offset)
			{
				array_push($args, array('offset' => $offset));
			}

			if ($action)
			{
				array_push($args, array('filter' => $action));
			}

			$this->var['inbox'] = $this->user_model->get_message_details($args);

			$this->load->view('user/inbox', $this->vars);
		}
		// Sending message to some other guy
		elseif($user_id && $to_user)
		{
			$middleInitial = '';

			// Fetch the to_user's user details
			$user_details = $this->user_model->get_user_details(array('tbluseraccounts.UserAccountID'=>base64_decode($to_user)));

			// Fetch Messaging types
			$this->vars['MessageTypes'] = $this->user_model->get_message_types();

			if (count($user_details) > 0)
			{
				if($this->input->post('message'))
				{
					// Save message to database
					$insert = $this->user_model->save_message(array(
							'MessageTypeID'	=> 1,
							'SenderID'		=> $user_id,
							'Message'		=> $this->input->post('message'),
							'Recipients'	=> base64_decode($to_user),
							'DateTimeLogged'=> date('Y-m-d h:i:s'),
							'DateTimeModified'=> date('Y-m-d h:i:s'),
							'DateTimeSent'	=> date('Y-m-d h:i:s')
						));

					if($insert)
					{
						// Display message sent page
					}
					else
					{
						// Display error page
					}
				}
				else
				{
					if (isset($user_details[0]['MiddleName']) && $user_details[0]['MiddleName'] != '')
					{
						$middleInitial = substr($user_details[0]['MiddleName'], 0, 1) . '.';
					}

					$this->vars['UserDetails'] = $user_details;
					$this->vars['RecipientName'] = $user_details[0]['FirstName'] . ' ' . $middleInitial . ' ' . $user_details[0]['LastName'];
					$this->vars['UserID'] = $to_user;

					// Show message form
					$this->load->view('user/message', $this->vars);
				}
			}
			else
			{
				redirect('/main', 'refresh');
			}
		}
	}

	public function test_page()
	{
		// Insert view here :D
		$this->load->view('user/quote', $this->vars);
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */