<?php

/**
 * Class C_Retails
 * @property MY_Loader $load
 * @property CI_URI $uri
 * @property CI_Session $session
 * @property SB_ScriptManagerCSS manager_css
 * @property SB_ScriptManagerJS manager_js
 * @property LoaderExt loaderext
 */
class Retails extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array(
            'SB_Core',
            'SB_Priority',
            'SB_Script'
        ));

        $this->load->library('loaderExt');

        $this->loaderext->singlton(LoaderExt::LIBRARY, array(
            'class' 		=> 'SB_ScriptManagerJS',
            'object_name'	=> 'manager_js'
        ));
        $this->loaderext->singlton(LoaderExt::LIBRARY, array(
            'class' 		=> 'SB_ScriptManagerCSS',
            'object_name'	=> 'manager_css'
        ));

        # get session variable
        $this->user_id = $this->session->userdata['user_id'];
        $this->comp_id = $this->session->userdata['comp_id'];
        $this->access  = $this->session->userdata['access'];

        if( !isset($this->session->userdata['user_id']) )
        {
            redirect('login');
        }
    }

    public function index()
    {
        if ($this->access != COMP_RETAIL)
        {
            redirect('login');
        }

        $this->manager_js
            ->add('jquery', 'jquery/jquery-1.11.2.js')
            ->add('bootstrap', 'bootstrap/bootstrap.js');

        $this->manager_css
            ->add('bootstrap', 'bootstrap/bootstrap.css');

        $this->loaderext->template('retails/index.php');
    }
}