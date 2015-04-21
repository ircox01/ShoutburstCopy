<?php

/**
 * Class SB_JS
 * @property SB_Script_JS[] $scripts
 * @property SB_Priority $priority
 */
class SB_ScriptManagerJS extends SB_ScriptManager
{
    protected function _init()
    {
        parent::_init();
        $this->root = '/js/';
    }

    protected function _makeScript($name, $path)
    {
        $this->scripts[$name] = new SB_Script_JS(array(
            'name'  => $name,
            'path'  => $this->root . $path
        ));
    }

    public function localizeNow($item, $value)
    {
        echo "<script>" . $this->newl;
        if (is_array($value) || is_object($value))
        {
            $value = "JSON.parse('" . addslashes(json_encode($value)) . "');" . $this->newl;
        }
        else
        {
            $value = "'" . $value."';" . $this->newl;
        }
        echo $this->indent . $item . ' = ' . $value;
        echo "</script>" . $this->newl;
        return $this;
    }
}


















