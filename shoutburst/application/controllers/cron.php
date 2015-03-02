<?php

class Cron extends CI_Controller {
    public function hourly() {
        echo "\r\nHourly cronjob\r\n";
        $this->load->model('surveys_model');
        $this->load->model('alert_model');
        $this->surveys_model->insert_rand_surveys(2,100);
        $hourlyAlerts = $this->alert_model->getHourly();
        foreach ($hourlyAlerts as $hourlyAlert) {
            echo "condition report {$hourlyAlert['filter_conditions']} sent to {$hourlyAlert['email_addresses']} \r\n";
            $this->alert_model->process($hourlyAlert['alert_id']);
        }
    }
}