<?php
/**
 * @property Surveys_model $surveys_model
 */
class Surveys extends CI_Controller {

    public function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->model('surveys_model');
    }

    public function addRandom($num) {
        echo "ADDING  $num random surveys \n\r";
        $this->surveys_model->insert_rand_surveys(2, $num);
    }

}