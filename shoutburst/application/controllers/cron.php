<?php

class Cron extends CI_Controller {
    public $alert_model;
    public $surveys_model;

    public function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->model('surveys_model');
        $this->load->model('alert_model');
    }

    public function hourly() {
        echo "Hourly cronjob\r\n";
        //$this->surveys_model->insert_rand_surveys(2,100);
        //$this->surveys_model->insert_rand_surveys(30,1);
        $hourlyAlerts = $this->alert_model->getHourly();
        foreach ($hourlyAlerts as $hourlyAlert) {
          //  echo "condition report {$hourlyAlert['filter_conditions']} sent to {$hourlyAlert['email_addresses']} \r\n";
            $this->alert_model->process($hourlyAlert['alert_id']);
        }
    }

    public function daily() {
        echo "Daily cronjob\r\n";
        $dailyAlerts = $this->alert_model->getDaily();
        foreach ($dailyAlerts as $alert) {
            $this->alert_model->process($alert['alert_id']);
        }
    }
}