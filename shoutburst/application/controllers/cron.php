<?php

class Cron extends CI_Controller {
    public function hourly() {
        echo "\r\nHourly cronjob\r\n";
        $this->load->model('alert_model');
        $hourlyAlerts = $this->alert_model->getHourly();

        foreach ($hourlyAlerts as $hourlyAlert) {
            echo "condition report {$hourlyAlert['filter_conditions']} sent to {$hourlyAlert['email_addresses']} \r\n";
            $this->alert_model->process($hourlyAlert['alert_id']);

        }
    }
}