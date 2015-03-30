<?php

abstract class SB_Script
{
    public $name;
    public $path;
    public $loaded;
    public $data;

    public $newl = "\n";
    public $indent = "\t";

    public function __construct($options)
    {
        $this->name = _ran_rinnk($options, 'name', 'script');
        $this->path = _ran_rinnk($options, 'path', '/js/'.$this->name.'.js');
        $this->loaded = _ran_rinnk($options, 'loaded', false);
        $this->data = _ran_rinnk($options, 'data', array());
    }

    abstract protected function _do_localize();
    final public function localize()
    {
        if (empty($this->data)) return false;
        $this->_do_localize();
    }

    abstract protected function _do_script();
    final public function run($reload = false)
    {
        if ($this->loaded && !$reload) return false;

        $this->localize();
        $this->_do_script();
        $this->loaded = true;
    }
}

class SB_Script_JS extends SB_Script
{
    public function __construct($options)
    {
        parent::__construct($options);
    }

    protected function _do_localize()
    {
        echo '<script>' . $this->newl;
        foreach ($this->data as $key => $item)
        {
            if (is_array($item) || is_object($item))
            {
                $item = "JSON.parse('" . addslashes(json_encode($item)) . "')";
            }
            else
            {
                $item = "'".$item;
            }
            echo $this->indent . $key.' = ' . $item . ";" . $this->newl;
        }
        echo '</script>' . $this->newl;
    }

    protected function _do_script()
    {
        echo "<script src='".$this->path."'></script>" . $this->newl;
    }

}

class SB_Script_CSS extends SB_Script
{
    public function __construct($options)
    {
        parent::__construct($options);
        $this->path = _ran_rinnk($options, 'path', '/css/'.$this->name.'.css');
    }

    /**
     * $key - selector
     * $item - attributes
     */
    protected function _do_localize()
    {
        echo '<style>';
        foreach ($this->data as $key => $item)
        {
            echo $key . $this->newl . '{';
            $item = (array) $item;

            foreach ($item as $attr)
            {
                echo $this->indent . $item . $this->newl;

            }
            echo '}' . $this->newl;
        }
        echo '</style>';
    }

    protected function _do_script()
    {
        echo "<link rel='stylesheet' href='".$this->path."'/>" . $this->newl;
    }
}

/**
 * Class SB_ScriptManager
 * @property SB_Priority $priority
 * @property SB_Script[] $scripts
 */
abstract class SB_ScriptManager extends SB_Singleton
{
    public $priority;
    public $newl = "\n";
    public $indent = "\t";

    protected $scripts = array();
    protected $root;

    protected function _init()
    {
        $this->priority = new SB_Priority();
    }

    public function getInfo($name)
    {
        return $this->scripts[$name];
    }

    abstract protected function _makeScript($name, $path);
    final public function add($name, $path)
    {
        $this->_makeScript($name, $path);
        $this->priority->add($name);
        return $this;
    }

    public function localize($name, $item, $value)
    {
        $this->scripts[$name]->data[$item] = $value;
        return $this;
    }

    public function run($name)
    {
        $this->scripts[$name]->run();
        return $this;
    }

    public function reload($name)
    {
        $this->scripts[$name]->run(true);
        return $this;
    }

    public function runAll()
    {
        foreach ($this->priority->getChain() as $name)
        {
            $this->scripts[$name]->run();
        }
        return $this;
    }

    abstract public function localizeNow($item, $value);
}











