<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct ()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function authenticate_user($login_data = '')
	{
		$query = "
			SELECT
				UserAccountID,
				FirstName,
				MiddleName,
				LastName,
				EmailAddress
			FROM
				tbluseraccounts
			WHERE
				EmailAddress = '".$login_data['EmailAddress']."'
				AND
				Password = '".$login_data['Password']."'
			";
		$result = $this->db->query($query);
		if($result->num_rows){
			$results = $result->result_array();
			return $results[0];
		}
		return false;
	}
	
	public function save_user($args = '')
	{
		$query		= '';
		$user_type	= P_TYPE_USER;	// Let's just assume new users are not venue owners
		
		if(is_array($args))
		{
			if(isset($args['Type']))
			{
				$user_type = $args['Type'];
				unset($args['Type']);
			}
			
			$this->db->insert('tbluseraccounts', $args);
			
			$user_id = $this->db->insert_id();
			
			$this->db->insert('tbluseraccountpriviledges', array(
				'UserAccountID'	=> $user_id,
				'PriviledgeID'	=> $user_type
			));
			
			return $user_id;
		}
		else 
		{
			return false;
		}
	}
	
	public function get_user_details($args = '')
	{
		$query = '';
		
		$this->db->select('*');
		
		if(is_array($args))
		{
			$this->db->where($args);
		}
		else 
		{
			return array();
		}
		
		$query = $this->db->get('tbluseraccounts');
		
		return $query->result_array();
	}
	
	public function get_activity_details($args = '')
	{
		$query = '';
		
		$this->db->select('*');
		$this->db->from('tbluseraccountactivitylogs useractivity');
		
		if(is_array($args))
		{
			if(isset($args['ActivityName']))
			{
				// Join with Message Types table
				$this->db->join('tblactivities', 'tblactivities.ActivityID = useractivity.ActivityID');
				$this->db->where('tblactivities.ActivityName', $args['ActivityName']);
				
				unset($args['ActivityName']);
			}

			$this->db->where($args);
		}
		else 
		{
			return array();
		}
		
		$query = $this->db->get();
		
		return $query->result_array();
	}

	public function get_venue_details($args = '')
	{
		$query = '';

		$this->db->select('*');
		$this->db->from('tblvenues');

		if(is_array($args))
		{
			if(isset($args['IsMultiple']) && $args['IsMultiple'] == TRUE)
			{
				$this->db->where_in('VenueID', $args['VenueIDs']);
			}
			else
			{
				$this->db->where($args);
			}
		}
		else
		{
			return array();
		}

		$query = $this->db->get();

		return $query->result_array();
	}
	
	public function get_message_details($args = '')
	{
		$query = '';
		
		$this->db->select('*');
		$this->db->from('tblmessages');
		
		if(is_array($args))
		{
			// Get Message Type
			if(isset($args['MessageType']))
			{
				// Join with Message Types table
				$this->db->join('tblmessagetypes', 'tblmessages.MessageTypeID = tblmessagetypes.MessageTypeID');
				$this->db->where('tblmessagetypes.MessageTypeName', $arg['MessageType']);
				
				unset($args['MessageType']);
			}

			// Get Message Status
			if(isset($args['MessageStatus']))
			{
				// Join with Message Status table
				$this->db->join('tbluseraccountmessages', 'tblmessages.MessageID = tbluseraccountmessages.MessageID');
				$this->db->where('tbluseraccountmessages.MessageStatusID', $args['MessageStatus']);

				unset($args['MessageStatus']);
			}
			
			// Limit was set
			if(isset($args['limit']) && isset($args['offset']))
			{
				$this->db->limit($args['limit'], $args['offset']);
				
				unset($args['limit']);
				unset($args['offset']);
			}
			elseif(isset($args['limit']))
			{
				$this->db->limit($args['limit']);
				
				unset($args['limit']);
			}

			$this->db->where($args);
		}
		else 
		{
			return array();
		}
		
		$query = $this->db->get();
		
		return $query->result_array();
	}
}

/* End of file base_model.php */
/* Location: ./application/controllers/base_model.php */