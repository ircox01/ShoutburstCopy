<?php
/**
 * class Surveys
 * @property Surveys_model $surveys_model
 */
class Surveys extends CI_Controller
{

    public function __construct()
    {
        error_reporting(0);
        parent::__construct();
        $this->load->model('surveys_model');
    }

    public function addRandom($num = 1)
    {
        $users = $this->surveys_model->getUsersByAccess(4, 30);
        $camp = $this->surveys_model->getCampaigns();

        for ($i = 0; $i < $num; $i++)
        {
            $rand_user = $users[rand(0, count($users) - 1)];
            $rand_camp = $camp[rand(0, count($camp) - 1)];
            $this->surveys_model->insertRandomSurvey($rand_user->comp_id, $rand_user->user_id, $rand_camp->camp_id);
        }
    }

}