<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @author: Muhammad Sajid
 * @name: Users_model
 */
class Users_model extends CI_Model {

	public function __construct()
	{

	}
	
	/*
	 * @name:	validate
	 * 
	 */
	public function validate()
	{
        // grab user input
        #$username = $this->security->xss_clean($this->input->post('email'));
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
 
        // Prep the query
        $this->db->from('users u');
		$this->db->join('user_companies uc', 'uc.user_id = u.user_id');
		$this->db->where('lower(u.user_name)', strtolower($username));
        $this->db->where('u.password', md5($password));
        $this->db->where('u.status',1 );
		
        // Run the query
        $query = $this->db->get();

        // Let's check if there are any results
        if($query->num_rows() == 1)
        {
            // If there is a user, then create session data
            $row = $query->row();
            $data = array(
                    'user_id' => $row->user_id,
            		'comp_id' => $row->comp_id,
            		'access' => $row->acc_id,
            		'full_name' => $row->full_name,
                    'user_name' => $row->user_name,
                    'email' => $row->email,
            		'transcriber' => $row->transcriber,
					'photo' => $row->photo,
                    'validated' => true,
            		'user_data' => true
                    );
            $this->session->set_userdata($data);
            return true;
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }
	
    /*
     * @author:	Muhammad Sajid
     * @name:	get_users
     */
    public function get_users($comp_id, $access=null)
    {
    	if ($access == null || $access == 'null'){
    		$this->db->where('uc.acc_id >', COMP_ADMIN);
    	} else {
    		$this->db->where('uc.acc_id', $access);
    	}

    	$this->db->from('users u');
		$this->db->join('user_companies uc', 'uc.user_id = u.user_id');
		$this->db->where('uc.comp_id', $comp_id);
		
		$result = $this->db->get()->result();
		return $result;
    }
    
	/*
	 * @author:	Muhammad Sajid
	 * @name:	get_teams
	 */
    public function get_teams($comp_id)
    {
    	if (!empty($comp_id))
    	{
    		$this->db->select('t.team_id');
    		$this->db->select('t.team_title');
    		$this->db->from('teams t');
    		$this->db->join('team_map tm', 't.team_id = tm.team_id', 'left');
    		$this->db->where('tm.comp_id', $comp_id);
    		$this->db->group_by('tm.team_id');
    		$teams = $this->db->get()->result();
    		return $teams;
    	} else {
    		return 0;
    	}
    }
	
	
	/*
	 * @name:	if_exists
	 * 1- Check if user exists w.r.t email_id (while adding new user)
	 * 2- Check if user exists w.r.t email_id but not
	 * having specified user_id (while editing existing user)
	 */
	/*public function if_exists($email, $userId = FALSE)
	{
		if ( $user_id === FALSE )
		{
			$query = $this->db->get_where('users', array('email' => $email));
			
		} else {
			
			$query = $this->db->query("SELECT fname FROM users WHERE email_id = '$email_id' && user_id != $user_id");
		}
		
		return $query->row_array();
	}*/
	
	/*
	 * @name:	get_all_where
	 */
	/*public function get_all_where($where)
	{
		$query = $this->db->query("SELECT * FROM users WHERE $where");
		return $query->result_array();
	}*/
    
    /*
     * @author:		Shumaila.S
     * @modifier:	Muhammad Sajid
     * @TODO:		As per client request: Email ref# Re: 'User pin' on 23 April 2014
     * 				"i really need to be able to see myself in the users table when giving the demo,
     * 				and also be able to add the pin so i can collect data to put into reports. 
     * 				Would it be possible to have this issue resolved shortly?"
     * 
     * 				MSj -> we will revert these change after client Demo.
     * 
     * @name:		getUsers
     */
    public function getUsers( $comp_id="" )
    {
    	$user_id =$this->session->userdata['user_id'];
    	$data =$this->db->query("SELECT u.user_id,u.status,u.full_name,u.user_name,u.email, uc.user_pin, GROUP_CONCAT(uc.acc_id) AS acc_id
    							FROM users u LEFT JOIN user_companies uc ON u.user_id=uc.user_id
    							WHERE uc.comp_id={$comp_id} AND uc.acc_id >".SUPER_ADMIN." AND u.user_id!=".$user_id." GROUP BY u.user_id ")->result();
    	return $data;
    }
    
    public function getAccessList()
    {
    	$data = $this->db->get_where('access_levels', array('acc_id >'=>SUPER_ADMIN))->result();
    	return $data;
    }
    
    /*
     * @author:	Muhammad Sajid
     * @name:	check_pin
     */
    public function check_pin($user_pin, $accessArr)
    {
    	if ($accessArr == COMP_AGENT)
    	{
	    	$this->db->where('comp_id', $this->comp_id);
	    	$this->db->where('user_pin', $user_pin);
	    	$row = $this->db->get('user_companies')->row_array();
	    	if (!empty($row)){
	    		return true;
	    	} else {
	    		return false;
	    	}
    	}else{
    		return false;
    	}
    }
    
    /*
     * @author:	Muhammad Sajid
     * @name:	add_tags
     */
    public function add_tags($comp_id, $user_id, $tags)
    {
    	if (!empty($tags))
    	{
    		$batch = array();
    		$i = 0;
    		foreach ($tags as $k)
    		{
    			$batch[$i]['comp_id'] = $comp_id;
    			$batch[$i]['user_id'] = $user_id;
    			$batch[$i]['tag_id'] = $k;
    			$i++;
    		}
    		$this->db->insert_batch('user_tags', $batch);
    	}
    }
    
	/*
     * @author:	Muhammad Sajid
     * @name:	remove_tags
     */
    public function remove_tags($comp_id, $user_id)
    {
    	$this->db->where('comp_id', $comp_id);
    	$this->db->where('user_id', $user_id);
		$this->db->delete('user_tags');
    }
    
    /*
     * @author:	Muhammad Sajid
     * @name:	my_tags($user_id)
     */
    public function my_tags($user_id)
    {
    	$tags = array();
    	$my_tags = $this->db->query("SELECT tag_id FROM user_tags WHERE user_id = {$user_id}")->result_array();
    	foreach ($my_tags as $k){
    		$tags[] = $k['tag_id'];
    	}
    	return $tags;
    }
    
    public function checkUser($comp_id,$user_email)
    {
    	$this->db->from('users u');
    	$this->db->join('user_companies uc', 'uc.user_id = u.user_id');
    	$this->db->where('uc.comp_id', $comp_id);
    	$this->db->where('u.email', $user_email);
    	//	$this->db->where('u.user_pin', $user_pin);
    	$return = $this->db->get('users')->row_array();
    	
    	return $return;
    }
    
    public function addUser( $insert_agent =array())
    {
    	$query = $this->db->query("SELECT user_name FROM users WHERE lower(user_name)='".strtolower($insert_agent['user_name'])."'");
    	if( $query->num_rows() <= 0 )
    	{
    		$this->db->insert('users', $insert_agent);
    		$insert_id = $this->db->insert_id();
    		return $insert_id;
    	}else
    		return 0;
    }
    
    public function addUserComp($insert_id , $access , $comp_id , $user_pin="" , $transcribe )
    {
		$insert_uc['user_id'] = $insert_id;
    	$insert_uc['comp_id'] = $comp_id;
    	$insert_uc['acc_id'] = $access;
    	$insert_uc['user_pin'] = $user_pin;
    	$insert_uc["transcriber"]=$transcribe;
    		
    	$this->db->insert('user_companies', $insert_uc);   	
    	
    	# insert into dashboard
    	$insert_dashboard['user_id'] = $insert_id;
    	$insert_dashboard['comp_id'] = $comp_id;
    	 
    	$reports = $this->db->query("SELECT report_id FROM reports WHERE published=1 AND comp_id=".$comp_id)->result_array();
		
		$index=1;
    	for ($i = 0; $i < 4; $i++){
			if($reports[$i]!='')
    		{
    			$insert_dashboard['qdr_'.$index] = $reports[$i]['report_id'];
			}else 
    		{
    			$insert_dashboard['qdr_'.$index] = 0;
			}    
    		$index++;
		}$this->db->insert('dashboards', $insert_dashboard);   	
    }
    
    public function add( $user_id , $comp_id , $access ,$user_pin )
    {
	    # insert into user_companies
	    //foreach ($accessArr as $access)
	   // {
		    $insert_uc['user_id'] = $user_id;
		    $insert_uc['comp_id'] = $comp_id;
		    $insert_uc['acc_id'] = $access;
	    	$insert_uc['user_pin'] = $user_pin;
    		$this->db->insert('user_companies', $insert_uc);    	
	  //  } 
	    
    	# insert into dashboard
    	$insert_dashboard['user_id'] = $insert_id;
    	$insert_dashboard['comp_id'] = $comp_id;
    	 
    	$reports = $this->db->query("SELECT report_id FROM reports WHERE published=1 AND comp_id=".$comp_id)->result_array();
		
    		//$insert_dashboard['qdr_'.$i] = '';
    		//$this->db->insert('dashboards', $insert_dashboard);
    		$index=1;
    		for ($i = 0; $i < 4; $i++){
    			if($reports[$i]!='')
    			{
    				$insert_dashboard['qdr_'.$index] = $reports[$i]['report_id'];
    			}else 
    			{
    				$insert_dashboard['qdr_'.$index] = 0;
    			}    			
    			$index++;
    		}$this->db->insert('dashboards', $insert_dashboard);
	    return 1;
    }
    
    public function delete($agent_id,$statusUpdate)
    {
    	$this->db->where('user_id', $agent_id);
    	//$this->db->where('comp_id', $comp_id);
    	$this->db->update('users', array('status' => $statusUpdate));    	
    }
    
    /**
     * set password for user one time activity
     * @param array $data
     * @return affected rows
     */
    public function setPassword( $data=array() )
    {    	
    	$query = $this->db->query("SELECT user_id FROM users WHERE security_code='".$data['security_code']."'");
    	if($query->num_rows() > 0)
    	{
    		$this->db->where('security_code', $data['security_code']);
    		$this->db->update('users', array('password' => md5($data['password']), 'security_code'=>''));
    		return $this->db->affected_rows();
    	}else
    	return 0; 
    }
    
    /**
     * Change password for user
     * @param unknown $data
     * @return number
     */
    public function resetPassword( $data=array() )
    {
    	$query = $this->db->query("SELECT user_id FROM users WHERE user_id='".$data['user_id']."'");
    
    	if($query->num_rows() > 0)
    	{
    		$this->db->where('user_id', $data['user_id']);
    		if(isset($data['password']))
    		{
    			$this->db->update('users', array('password' => md5($data['password']), 'security_code'=>''));
    		}
    		else if(isset($data['security_code'])) 
    		{
    			$this->db->update('users', array('security_code' => $data['security_code']));
    		}
    		return $this->db->affected_rows();
    	}else
    		return 0;
    }
    
    /**
     * check if provided email exist to send new temporary password to user
     */
    public function verifyEmail($data='')
    {
    	$data=trim($data);
    	$query = $this->db->query("SELECT user_id ,full_name FROM users WHERE lower(email)='".strtolower($data)."' OR lower(user_name)='".strtolower($data)."'");
    	$result=array();
    	if($query->num_rows() > 0)
    	{
    		$result = $query->result_array();
    		return $result;
    	}
    	else return 0;
    }
    
    /**
     * verify user login name is unique
     * @param string $user_login
     * @return unknown
     */
    public function checkUsername($user_login='')
    {
    	$result = $this->db->query("SELECT user_id FROM users WHERE lower(user_name)='".strtolower($user_login)."'")->row_array();
    	return $result;
    }
    
    /**
     * verify user email address is unique
     * @param string $user_email
     * @return unknown
     */
    public function checkEmail($user_email='')
    {
    	$result =$this->db->query("SELECT user_id FROM users WHERE email='{$user_email}'")->row_array();
    	return $result;
    }
    
	
}