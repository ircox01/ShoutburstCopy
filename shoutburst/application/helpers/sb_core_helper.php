<?php

abstract class SB_Singleton
{
    private static $instances;

    protected function _init() {}

    final protected function __construct()
    {
        $this->_init();
    }

    final private function __clone() {}

    final public static function getInstance()
    {
        $class = get_called_class();
        if (!isset(self::$instances[$class]))
        {
            self::$instances[$class] = new $class;
        }
        return self::$instances[$class];
    }

    public function __call($name, $params)
    {
        $clname = __CLASS__;
        if (isset($clname::$name) && is_callable($clname::$name))
        {
            $clname::$name();
        }
    }
}