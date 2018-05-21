<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Search_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function property_search($condition = ''){
	
		$select_qry = "select p.*,
						u.id as userid,u.first_name,u.photo as userphoto,pt.list_value,
						pp.img_name from ".PROPERTY." p 
		LEFT JOIN ".PROPERTY_PHOTO." pp on pp.p_id=p.id
		LEFT JOIN ".PROPERTY_TYPE_VALUES." pt on p.property_type=pt.id
		LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
			
	}
	public function get_PriceMaxMin($condition = ''){
	
		$select_qry = ' select MAX(p.price) as MaxPrice,MIN(p.price) as MinPrice from '.PROPERTY.' p  where '.$condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	
	
	
}