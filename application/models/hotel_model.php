<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotel_model extends CI_Model {
	const DB_LISTING_PLANS = 'tbllistingplans';
	const DB_EVENT_TYPES = 'tbleventtypes';
	const DB_AMENITIES = 'tblamenities';
	const DB_VENUES = 'tblvenues';
	const DB_VENUE_AMENITIES = 'tblvenueamenities';
	const DB_VENUE_TYPES = 'tblvenuetypes';
	const DB_CITIES = 'tblcities';
	const DB_VENUE_PAYMENTS = 'tblvenuepayments';

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
			$this->db->where('EventTypeID',$id);
		}
		$result = $this->db->get(self::DB_EVENT_TYPES);
		
		return $result->result_array();
	}

	public function venue_types($id = false)
	{
		if($id)
		{
			$this->db->where('VenueTypeID',$id);
		}
		$result = $this->db->get(self::DB_VENUE_TYPES);

		return $result->result_array();
	}
	
	public function amenities($id = false)
	{
		if($id)
		{
			$this->db->where('AmenityID',$id);
		}
		$result = $this->db->get(self::DB_AMENITIES);
		
		return $result->result_array();
	}

	/*public function register($args)
	{
		//create the venue
		$venue = array(
				'UserAccountID'=>$args['user_id'],
				'VenueTypeID'=>$args['venue_type_id'],
				'CityID'=>$args['city_id'],
				'VenueName'=>$args['venue_name'],
				'Location'=>$args['venue_details'],
				'LocationMap'=>null,
				'MaximumOccupancy'=>null,
				'MinimumBookingRequired'=>null,
				'Ammenities'=>$args['ammenities'],
				'VenueDescription'=>$args['venue_descriptions'],
				'DepositAndFees'=>null,
				'MinimumPackageRate'=>$args['minimum_rate'],
				'MaximumPackageRate'=>$args['maximum_rate']
			);
	}*/

	public function save_venue($args)
	{
		if($this->db->insert(self::DB_VENUES,$args))
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}

	public function save_amenities($venue_id,$amenities)
	{
		$insert_array = array();

		foreach($amenities as $amentity)
		{
			$insert_array[] = array(
					'VenueID'=>$venue_id,
					'AmenityID'=>$amenity
				);
		}

		if(count($insert_array))
		{
			$this->db->insert_batch(self::DB_VENUE_AMENITIES,$insert_array);
			return true;
		}
		return false;
	}	

	public function save_payment($args)
	{
		if($this->db->insert(self::DB_VENUE_PAYMENTS,$args))
		{
			return $this->db->insert_id();
		}
		return false;
	}
	
	public function cities($id = false, $code = false)
	{
		if($id)
		{
			$this->db->where('CountryID',$id);
		}
		if($code)
		{
			$this->db->where('Country',$code);
		}
		$result = $this->db->get(self::DB_CITIES);

		return $result->result_array();
	}
}

/* End of file base_model.php */
/* Location: ./application/controllers/base_model.php */
