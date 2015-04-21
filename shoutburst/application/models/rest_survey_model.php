<?php

/**
 * Class Rest_survey_model
 * @property CI_DB_active_record $db
 */
class Rest_survey_model extends CI_Model
{
    private $tabName = 'surveys';

    public function __construct()
    {
        parent::__construct();
    }

    protected function buildWhere($where)
    {
        foreach ($where as $item)
        {
            $operator = _ran_rinnk($item, 'operator', '=');
            $type = strtolower(_ran_rinnk($item, 'type', 'and'));
            $type = ($type == 'or') ? 'or_' : '';

            foreach ($item['fields'] as $key => $value)
            {
                $this->db->{$type . 'where'}($key.' '.$operator, $value);
            }
        }
    }

    public function get(array $options = array())
    {
        $where = _ran_rinnk($options, 'where');

        $this->db->from($this->tabName);

        if ($where) $this->buildWhere($where);

        return $this->db->get()->result_array();
    }

    public function store(array $options = array())
    {
        $fields = _ran_rinnk($options, 'surveys');

        if (!$fields)
        {
            return false;
        }
        else
        {
            foreach($fields as $values)
            {
                $this->db->from($this->tabName);
                $this->db->set($values);
                $this->db->insert();
            }
        }

        return true;
    }

    public function update(array $options)
    {
        $where = _ran_rinnk($options, 'where');
        $values = _ran_rinnk($options, 'values');

        if (!$where || !$values) return false;

        $this->db->from($this->tabName);

        if ($where) $this->buildWhere($where);

        foreach ($values as $key => $value)
        {
            $this->db->set($key, $value);
        }

        return $this->db->update();
    }

    public function delete(array $options)
    {
        $where = _ran_rinnk($options, 'where');

        $this->db->from($this->tabName);

        if (!$where)
        {
            return false;
        }
        else
        {
            $this->buildWhere($where);
        }

        return $this->db->delete();
    }

}












