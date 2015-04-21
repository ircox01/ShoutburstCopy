<?php

/**
 * Class r_RESTfullApi
 * @property CI_Loader $load
 * @property CI_DB_mysql_driver $db
 * @property CI_Input $input
 */
class r_RESTfullApi extends CI_Controller
{
    protected $data         = array();
    protected $response     = array();
    protected $method       = 'GET';

    public function __construct()
    {
        parent::__construct();

        $this->data['get']      = $this->input->get();
        $this->data['post']     = $this->input->post();
        $this->method           = $this->input->server('REQUEST_METHOD');
    }

    public function getJsonData()
    {
        $resp = array_values($this->data['get']);

        if (count($resp) < 1) return false;

        return json_decode($resp[0], true);
    }

    public function response($resp = null)
    {
        $resp = ($resp) ? $resp : $this->response;
        die(json_encode($resp));
    }

    public function index()
    {
        $m_name = 'rest_'.strtolower($this->method);

        if (method_exists($this, $m_name))
        {
            $this->{$m_name}(func_get_args());
        }
    }
}

/**
 * class Surveys
 * @property Surveys_model $surveys_model
 * @property Rest_survey_model $rest_model
 */
class Surveys extends r_RESTfullApi
{
    public function __construct()
    {
        error_reporting(0);
        parent::__construct();
        $this->load->model('surveys_model');
        $this->load->model('rest_survey_model', 'rest_model');
    }

    public function rest_get()
    {
        $resp = $this->rest_model->get($this->data['get']);
        $this->response($resp);
    }

    public function rest_post()
    {
        $this->response($this->rest_model->store($this->data['post']));
    }

    public function rest_put()
    {
        $this->response($this->rest_model->update($this->getJsonData()));
    }

    public function rest_delete()
    {
        $this->response($this->rest_model->delete($this->getJsonData()));
    }

    public function testData()
    {
        testDataAjaxGET();
    }

    /**
     * @param int $num
     * add records for test
     */
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

function testDataAjaxGET()
{
    ?>

    <script src="/js/jquery/jquery-1.11.2.js"></script>

    <button onclick="goAjax()">go Ajax</button>

    <div id="response"></div>

    <script>

        function goAjax()
        {

            var data = {
                where: [
                    {
                        fields  : {
                            sur_id  : 9614
                        },
                        operator: '>=',
                        type    : 'and'
                    },
                    {
                        fields  : {
                            q1      : 5,
                            q2      : 5

                        },
                        operator: '>',
                        type    : 'or'
                    }
                ]
            };

            $.ajax({
                url: 'http://shoutburst/surveys/index',
                method: 'GET',
                dataType: 'json',
                data: data,
                success: function(msg)
                {
                    console.log(msg);
                    //$('#response').html(JSON.stringify(msg));
                }
            });

        }

    </script>

<?php
}

function testDataAjaxDELETE()
{
    ?>

    <script src="/js/jquery/jquery-1.11.2.js"></script>

    <button onclick="goAjax()">go Ajax</button>

    <div id="response"></div>

    <script>

        function goAjax()
        {

            var data = {
                where: [
                    {
                        fields  : {
                            sur_id  : 9624
                        }
                    },
                 ]
            };

            $.ajax({
                url: 'http://shoutburst/surveys/index?D=' + JSON.stringify(data),
                method: 'DELETE',
                dataType: 'json',
                success: function(msg)
                {
                    console.log(msg);
                    //$('#response').html(JSON.stringify(msg));
                }
            });

        }

    </script>

<?php
}

function testDataAjaxUPDATE()
{
    ?>

    <script src="/js/jquery/jquery-1.11.2.js"></script>

    <button onclick="goAjax()">go Ajax</button>

    <div id="response"></div>

    <script>

        function goAjax()
        {

            var data = {
                where: [
                    {
                        fields : {
                            sur_id : 9624
                        },
                        operator : '>='
                    }
                ],
                values: {
                    q2: 55,
                    q3: 91
                }
            };

            $.ajax({
                url: 'http://shoutburst/surveys/index?U=' + JSON.stringify(data),
                method: 'PUT',
                dataType: 'json',
                success: function(msg)
                {
                    console.log(msg);
                }
            });

        }

    </script>

<?php
}

function testDataAjaxPOST()
{
    ?>

    <script src="/js/jquery/jquery-1.11.2.js"></script>

    <button onclick="goAjax()">go Ajax</button>

    <div id="response"></div>

    <script>

        function goAjax()
        {

            var data = {
                surveys : [
                    {
                        q1: 5,
                        q2: 5,
                        q3: 5,
                        q4: 5,
                        q5: 5
                    },
                    {
                        q1: 3,
                        q2: 3,
                        q3: 3,
                        q4: 3,
                        q5: 3
                    }
                ]
            };

            $.ajax({
                url: 'http://shoutburst/surveys/index',
                method: 'POST',
                dataType: 'json',
                data: data,
                success: function(msg)
                {
                    console.log(msg);
                    //$('#response').html(JSON.stringify(msg));
                }
            });

        }

    </script>

<?php
}
