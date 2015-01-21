<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @author: Muhammad Sajid
 * @name: Utility_model
 */
class Utility_model extends CI_Model {

	public function __construct()
	{

	}
	
	/*
	 * @name:	remove_img_server
	 */
	public function remove_img_server($dir, $img_name)
	{
		if (file_exists(PUBPATH.$dir.'/'.$img_name))
		{
			chmod(PUBPATH.$dir.'/'.$img_name, 0777);	// change rights
			unlink(PUBPATH.$dir.'/'.$img_name);
		}
	}
	
	/*
	 * @name:	loadAll
	 */
	public function loadAll($query)
	{
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	/*
	 * @name:	get_result_where
	 */
	public function get_result_where($table, $where)
	{
		$query = $this->db->get_where($table, $where);
		return $query->result_array();
	}
	
	/*
	 * @name:	remove
	 */
	public function remove($table, $where)
	{
		return $this->db->delete($table, $where);
	}
	
	/*
	 * @name:	set
	 * Add new record
	 */
	public function set($table, $values)
	{
		$this->db->insert($table, $values);
		return $this->db->insert_id();
	}
	
	/*
	 * @name:	load_all
	 */
	public function load_all($table)
	{
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	/*
	 * @name:	get_row_where
	 * Get row w.r.t values
	 */
	public function get_row_where($table, $values)
	{
		$query = $this->db->get_where($table, $values);
		return $query->row_array();
	}
	
	/*
	 * @name:	get_row_query
	 * 
	 */
	public function get_row_query($query)
	{
		$query = $this->db->query($query);
		return $query->row_array();
	}
	
	/*
	 * @name:	update
	 * Edit row w.r.t values
	 */
	public function update($table, $values, $where)
	{
		$this->db->where($where);
		return $this->db->update($table, $values);
	}
	
	/*
	 * @name:	if_exists
	 * @peram:	table			table name
	 * 			value_column_name	value column name
	 * 			value			value
	 * 			id				pk of the table {FALSE while add new record} {TRUE while edit existing record}
	 * 			pk_column		pk column name of the table {FALSE while add new record} {TRUE while edit existing record}
	 * 
	 * @return:	row
	 * @desc:	1- Check if value exists w.r.t column name (while adding new record)
	 * 			2- Check if value exists w.r.t column name but not having specified id (while editing existing record)
	 */
	public function if_exists($table, $value_column_name, $value, $pk_column = FALSE, $id = FALSE)
	{
		if ( $id === FALSE )
		{
			$query = $this->db->get_where($table, array($value_column_name => $value));
			
		} else {
			
			$query = $this->db->query("SELECT * FROM $table WHERE $value_column_name = '$value' && $pk_column != $id");
		}
		
		return $query->row_array();
	}
	
	/*
	 * @name:	check_isvalidated
	 * This method will check logged in user.
	 */
	public function check_isvalidated()
	{
        if(! $this->session->userdata('validated')){
            redirect('login');
        }
    }
    
    /*
     * @name:	do_logout
     */
	public function do_logout()
	{
        $this->session->sess_destroy();   
       	unset($_COOKIE['autologin']);   
        redirect(base_url());
    }
    
	/*
	 * @name:	rendom
	 * @desc:	Generate unique string
	 * @perams:	$l: string length
	 */
	public function rendom($l=32)
	{
		$src = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz0987654321aeiou';
		$len = strlen($src) - 1;
		$str = '';
		for($i=0; $i<$l; $i++) {
			$x = rand(0,$len);
			$str .= $src[$x];
		}
		return $str;
	}
	
	/*
	 * @name:	upload_file
	 * @desc:	Upload file to given directory
	 * @perams:	$ext: file extention, $tmp_name: $_FILES['tmp_name'], $dir: destination folder
	 */
	public function upload_file($ext, $tmp_name, $dir)
	{
		if(!is_dir($dir))
			mkdir($dir);
	
		$file_name = $this->rendom() .'.'. strtolower($ext);
		$file = $dir .'/'. $file_name;
		move_uploaded_file($tmp_name, $file);
		return $file_name;
	}
	
	/*
	 * @name:	date_time
	 * @desc:	Change date/time format w.r.t (PST)
	 * @perams: $my_date - If $my_date is empty then generate (PST) date/time but with actual MySQL Date/Time format (Y-m-d H:i:s) to store in DB
	 * 					 - If $my_date is !empty then transform $my_date in to (PST) to display
	 */
	public function date_time($my_date = '')
	{
		// set time zone
		$timezone = "Asia/Riyadh";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		
		if ($my_date != '')
		{
			$return = date('Y-m-d H:i:s', strtotime("$my_date"));
			
		} else {
			$date = date('Y-m-d H:i:s');
			$return = date('Y-m-d H:i:s', strtotime("$date + 2 hours"));
		}
		
		return $return;
	}
}