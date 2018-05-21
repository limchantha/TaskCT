<?php
function langdata()
{
	$ci=& get_instance();
	$ci->load->database(); 
	
	$sql 	= "SELECT * FROM lang WHERE status='Active'"; 
	$query 	= $ci->db->query($sql);
	$row 	= $query->result_array();
	return $row;
}

function langdata_default()
{
	$ci=& get_instance();
	$ci->load->database(); 
	
	$sql 	= "SELECT * FROM lang WHERE status='Active' AND default_lang='default'"; 
	$query 	= $ci->db->query($sql);
	$row 	= $query->result_array();
	return $row;
}

?>