<?php 
$data = '';
$title = '<table>
	<tr>
    	<td colspan="2" align="right">Date :</td>
		<td colspan="2" align="left">'. date('Y-m-d'). '</td>
		<td colspan="3" align="right">Title :</td>
        <td colspan="3" align="left">'.$this->config->item('site_title').$heading.' Bookings Details</td>
        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';	

$header = $title.'<table border="1"><tr><th>Sno</th>';

$field_count = (array) $users_detail[0];
$field_count=count($field_count);
 foreach ($users_detail[0] as $table_field=>$field_value)
    {
 $field_count--;
 $header .= '<th>'.str_replace('_',' ',$table_field).'</th>';
 if($field_count==0)
 {
 $header .= '</tr>';
 }
    } $i=1;
 foreach ($users_detail as $field_name=>$field_values)
		{
		$data .= '<tr><td>'.$i.'</td>';
		foreach ($field_values as $field=>$field_value)
		{
		if($field=="booking_time")
		{
			if($field_value==1){ $t= "Morning";}elseif($field_value==2){ $t="Afternoon";}elseif($field_value==3){ $t= "Evening";}else { $t="Flexible";}
			$data .= '<td style="text-align:left">'.$t.'</td>';
		}
		else if($field=="booking_no")
		{
			
			$data .= '<td style="text-align:left">SR000'.$field_value.'</td>';
		}
		else
		{ $data .= '<td style="text-align:left">'.$field_value.'</td>';
			
		}				
		}
		$data .='</tr>'; $i++;
       } 
		$data =$header.$data;
		
if ( $data == "" )
{
    $data = "\nNo Record(s) Found!\n";                        
} 

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Service_rabbit_".$heading."_list.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$data";
?>