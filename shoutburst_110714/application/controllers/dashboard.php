<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$data['title'] = TITLE.' | Dashboard';
		$this->load->model('Reports_model', 'reports');
		$this->load->model('Dashboards_model', 'dashboards');
		
		# get session variable
		$this->user_id = $this->session->userdata['user_id'];
		$this->comp_id = $this->session->userdata['comp_id'];
		$this->access = $this->session->userdata['access'];
		
		$this->load->vars($data);
		
		if( ! isset($this->session->userdata['user_id']) )
			redirect('login');
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	index
	 */
	public function index()
	{
		$data = array();
		
		# Get my dashboard
		$data['dashboard'] = $this->dashboards->my_dashboard($this->user_id, $this->comp_id);
		
		# set report_query variables for qdr_1,qdr_2,qdr_3,qdr_4
		if (!empty($data['dashboard']))
		{
			for ($d=1; $d<=4; $d++)
			{
				$report_id = $data['dashboard']['qdr_'.$d];
				if ($report_id > 0)
				{
					$data['report_id'][$d] = $report_id;
				
					# is report allowed for dashboard & what's privacy set
					$the_report = $this->reports->get_report($report_id);
					if (!empty($the_report) )
					{
						$data['report_name'][$d] = $the_report['report_name'];
						$data['is_dashboard'][$d] = $the_report['dashboard'];
						$data['privacy'][$d] = $the_report['privacy'];
										
						# get fields to render reports
						$report_query = $this->reports->dashboard_report($report_id);
						#var_debug($report_query);exit();
						
						if (isset($report_query['report_query'])){
							$data['qdr'][$d] = $report_query['report_query'];
						} else {
							$data['qdr'][$d] = 0;
						}
					} else {
						$data['report_id'][$d] = 0;
						$data['is_dashboard'][$d] = 0;
						$data['privacy'][$d] = 0;
					}
				} else {
					$data['report_id'][$d] = 0;
					$data['is_dashboard'][$d] = 0;
					$data['privacy'][$d] = 0;
				}
			}
		#var_debug($data);exit;
		}
				
		# redirect to respective Dashboard
		switch ($this->access){
			case SUPER_ADMIN:
				$this->load->template('dashboard/super-admin/index', $data);
			break;
			
			case COMP_ADMIN:
				$this->load->template('dashboard/admin/index', $data);
			break;
			
			case COMP_MANAGER:
				$this->load->template('dashboard/manager/index', $data);
			break;
			
			case COMP_AGENT:
				$this->load->template('dashboard/agent/index', $data);
			break;
		}
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	arrange_dashboard
	 */
	public function arrange_dashboard()
	{
		$update = array();
		#var_debug($_POST);
		$r_ids = explode(",", str_replace(",,", ",", $_POST['reports_id']) );
		#var_debug($r_ids);exit;
		$update['qdr_1'] = $r_ids[0];
		$update['qdr_2'] = $r_ids[1];
		$update['qdr_3'] = $r_ids[2];
		$update['qdr_4'] = $r_ids[3];
		$this->db->where('db_id', $_POST['db_id']);
		$this->db->where('user_id', $this->user_id);
		$this->db->where('comp_id', $this->comp_id);
		$this->db->update('dashboards', $update);
		$affected_rows = $this->db->affected_rows();
		if ($affected_rows === 1){
			echo 'Update';
		} else {
			echo "Error";
		}
	}
}