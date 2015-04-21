<?php

/**
 * Class SB_ScriptManagerCSS
 * @property SB_Script_JS[] $scripts
 * @property SB_Priority $priority
 */
class SB_ScriptManagerCSS extends SB_ScriptManager
{
    protected function _init()
    {
        parent::_init();
        $this->root = '/css/';
    }

    protected function _makeScript($name, $path)
    {
        $this->scripts[$name] = new SB_Script_CSS(array(
            'name'  => $name,
            'path'  => $this->root . $path
        ));
    }

    /**
     * @param $item - selector
     * @param $value - attributes
     * @return $this
     */
    public function localizeNow($item, $value = array())
    {
        echo "<style>" . $this->newl;
        echo $item . $this->newl . '{';

        $value = (array) $value;
        foreach ($value as $attr)
        {
            echo $this->indent . $attr . $this->newl;
        }

        echo '}' . $this->newl;
        echo "</style>" . $this->newl;
        return $this;
    }
}









