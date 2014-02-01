<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotel_model extends CI_Model {
	const DB_LISTING_PLANS = 'tbllistingplans';
	const DB_EVENT_TYPES = 'tbleventtypes';
	const DB_AMENITIES = 'tblamenities';

	public function __construct ()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function listing_plans($id = false)
	{
		if($id)
		{
			$this->db->where('PlanID',$id);
		}
		$result = $this->db->get(self::DB_LISTING_PLANS);
		
		return $result->result_array();
	}
	
	public function event_types($id = false)
	{
		if($id)
		{
			$this->db->where('EventTypeID');
		}
		$result = $this->db->get(self::DB_EVENT_TYPES);
		
		return $result->result_array();
	}
	
	public function amenities($id = false)
	{
		if($id)
		{
			$this->db->where('AmenityID');
		}
		$result = $this->db->get(self::DB_AMENITIES);
		
		return $result->result_array();
	}
	
	
}

/* End of file base_model.php */
/* Location: ./application/controllers/base_model.php */