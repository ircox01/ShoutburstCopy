<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$data['title'] = TITLE.' | Dashboard';
		$this->load->model('Reports_model', 'reports_model');
		$this->load->model('Dashboards_model', 'dashboards');
		$this->load->library('../controllers/Reports');
		
		# get session variable
		$this->user_id = $this->session->userdata['user_id'];
		$this->comp_id = $this->session->userdata['comp_id'];
		$this->acc_id = $this->session->userdata['access'];
		
		$this->load->vars($data);
		
		if( ! isset($this->session->userdata['user_id']) )
			redirect('login/index');
	}
	
	/*
	 * @author:	Muhammad Sajid
	 * @name:	index
	 */
	public function index()
	{
		$rep_obj = new Reports();
		$data = array();
		
		# Get my dashboard
		$data['dashboard'] = $this->dashboards->my_dashboard($this->user_id, $this->comp_id);
		
//		$data['js_chart'] = '<script type="text/javascript" src="<?php echo base_url(); ? >js/jquery-1.7.2.min.js"></script>';
		
		# set report_query variables for qdr_1,qdr_2,qdr_3,qdr_4
		if (!empty($data['dashboard']))
		{
			for ($d=1; $d<=4; $d++)
			{
				$report_id = $data['dashboard']['qdr_'.$d];
				$data['report_html'][$d] = $report_id;
				# get fields to render reports
//				$report_query = $this->reports_model->dashboard_report($report_id);
//				var_debug($report_query);exit();
				
//				if (isset($report_query['report_query'])){
//					$data['qdr'][$d] = $report_query['report_query'];
//					$query = $data['qdr'][$d];
//					$report_type = $report_query['report_type'];
//					$x_axis_label = $report_query['x_axis_label'];
//					$y_axis_label = $report_query['y_axis_label'];
//					$background_color = $report_query['background_color'];
//					$report_period = $report_query['report_period'];
//					$report_interval = $report_query['report_interval'];
//					$report_name = $report_query['report_name'];
//					
//					$data['report_html'][$d] = $report_id;
//				} else {
//					$data['qdr'][$d] = 0;
//					$data['report_html'][$d] = '';
//				}
			}
		
		}
				
		# redirect to respective Dashboard
		switch ($this->acc_id){
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
		
		$r_ids = explode(",", $_POST['reports_id']);
		
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