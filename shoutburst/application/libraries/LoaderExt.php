<?php

/**
 * Class LoaderExt
 */
class LoaderExt extends CI_Loader
{
    const LIBRARY   = 1;
    const MODEL     = 2;

    public function template($name, $vars = array(), $return = FALSE)
    {
        $content = false;

        $header = _ran_rinnk($vars, '_tmp_header', 'templates/retail_header');
        $footer = _ran_rinnk($vars, '_tmp_footer', 'templates/retail_footer');

        if ($return)
        {
            $content  = $this->view($header, $vars, 1);
            $content .= $this->view($name, $vars, 1);
            $content .= $this->view($footer, $vars, 1);
        }
        else
        {
            $this->view($header, $vars);
            $this->view($name, $vars);
            $this->view($footer, $vars);
        }
        return $content;
    }

    public function singlton($type, $options = array())
    {
        switch ($type)
        {
            case self::LIBRARY :
                $this->singleton_lib($options);
                break;

            case self::MODEL :
                break;
        }
    }

    protected function singleton_lib($options = array())
    {
        $class = $options['class'];
        $params = _ran_rinnk($options, 'params');
        $object_name = _ran_rinnk($options, 'object_name');
        $method = _ran_rinnk($options, '$method');

        // Get the class name, and while we're at it trim any slashes.
        // The directory path can be included as part of the class name,
        // but we don't want a leading slash
        $class = str_replace('.php', '', trim($class, '/'));

        // Was the path included with the class name?
        // We look for a slash to determine this
        $subdir = '';
        if (($last_slash = strrpos($class, '/')) !== FALSE)
        {
            // Extract the path
            $subdir = substr($class, 0, $last_slash + 1);

            // Get the filename from the path
            $class = substr($class, $last_slash + 1);
        }

        // We'll test for both lowercase and capitalized versions of the file name
        foreach (array(ucfirst($class), strtolower($class)) as $class)
        {
            $subclass = APPPATH.'libraries/'.$subdir.config_item('subclass_prefix').$class.'.php';

            // Is this a class extension request?
            if (file_exists($subclass))
            {
                $baseclass = BASEPATH.'libraries/'.ucfirst($class).'.php';

                if ( ! file_exists($baseclass))
                {
                    log_message('error', "Unable to load the requested class: ".$class);
                    show_error("Unable to load the requested class: ".$class);
                }

                // Safety:  Was the class already loaded by a previous call?
                if (in_array($subclass, $this->_ci_loaded_files))
                {
                    // Before we deem this to be a duplicate request, let's see
                    // if a custom object name is being supplied.  If so, we'll
                    // return a new instance of the object
                    if ( ! is_null($object_name))
                    {
                        $CI =& get_instance();
                        if ( ! isset($CI->$object_name))
                        {
                            return $this->singlton_init(array(
                                'class'     => $class,
                                'prefix'    => config_item('subclass_prefix'),
                                'params'    => $params,
                                'object_name'   => $object_name));
                        }
                    }

                    $is_duplicate = TRUE;
                    log_message('debug', $class." class already loaded. Second attempt ignored.");
                    return;
                }

                include_once($baseclass);
                include_once($subclass);
                $this->_ci_loaded_files[] = $subclass;

                return $this->singlton_init(array(
                    'class'     => $class,
                    'prefix'    => config_item('subclass_prefix'),
                    'params'    => $params,
                    'object_name'   => $object_name));
            }

            // Lets search for the requested library file and load it.
            $is_duplicate = FALSE;
            foreach ($this->_ci_library_paths as $path)
            {
                $filepath = $path.'libraries/'.$subdir.$class.'.php';

                // Does the file exist?  No?  Bummer...
                if ( ! file_exists($filepath))
                {
                    continue;
                }

                // Safety:  Was the class already loaded by a previous call?
                if (in_array($filepath, $this->_ci_loaded_files))
                {
                    // Before we deem this to be a duplicate request, let's see
                    // if a custom object name is being supplied.  If so, we'll
                    // return a new instance of the object
                    if (!is_null($object_name))
                    {
                        $CI =& get_instance();
                        if ( ! isset($CI->$object_name))
                        {
                            return $this->singlton_init(array(
                                'class'     => $class,
                                'params'    => $params,
                                'object_name'   => $object_name));
                        }
                    }

                    $is_duplicate = TRUE;
                    log_message('debug', $class." class already loaded. Second attempt ignored.");
                    return;
                }

                include_once($filepath);
                $this->_ci_loaded_files[] = $filepath;
                return $this->singlton_init(array(
                    'class'     => $class,
                    'params'    => $params,
                    'object_name'   => $object_name));
            }

        } // END FOREACH

        // One last attempt.  Maybe the library is in a subdirectory, but it wasn't specified?
        if ($subdir == '')
        {
            $path = strtolower($class).'/'.$class;
            return $this->singleton_lib(array(
                'class'     => $path,
                'params'    => $params
            ));
        }

        // If we got this far we were unable to find the requested class.
        // We do not issue errors if the load call failed due to a duplicate request
        if ($is_duplicate == FALSE)
        {
            log_message('error', "Unable to load the requested class: ".$class);
            show_error("Unable to load the requested class: ".$class);
        }
    }

    protected function singlton_init($options = array())
    {
        $class = $options['class'];
        $prefix = _ran_rinnk($options, 'prefix', '');
        $config = _ran_rinnk($options, 'params', false);
        $object_name = _ran_rinnk($options, 'object_name');
        $method = _ran_rinnk($options, 'method', 'getInstance');

        // Is there an associated config file for this class?  Note: these should always be lowercase
        if ($config === NULL)
        {
            // Fetch the config paths containing any package paths
            $config_component = $this->_ci_get_component('config');

            if (is_array($config_component->_config_paths))
            {
                // Break on the first found file, thus package files
                // are not overridden by default paths
                foreach ($config_component->_config_paths as $path)
                {
                    // We test for both uppercase and lowercase, for servers that
                    // are case-sensitive with regard to file names. Check for environment
                    // first, global next
                    if (defined('ENVIRONMENT') AND file_exists($path .'config/'.ENVIRONMENT.'/'.strtolower($class).'.php'))
                    {
                        include($path .'config/'.ENVIRONMENT.'/'.strtolower($class).'.php');
                        break;
                    }
                    elseif (defined('ENVIRONMENT') AND file_exists($path .'config/'.ENVIRONMENT.'/'.ucfirst(strtolower($class)).'.php'))
                    {
                        include($path .'config/'.ENVIRONMENT.'/'.ucfirst(strtolower($class)).'.php');
                        break;
                    }
                    elseif (file_exists($path .'config/'.strtolower($class).'.php'))
                    {
                        include($path .'config/'.strtolower($class).'.php');
                        break;
                    }
                    elseif (file_exists($path .'config/'.ucfirst(strtolower($class)).'.php'))
                    {
                        include($path .'config/'.ucfirst(strtolower($class)).'.php');
                        break;
                    }
                }
            }
        }

        if ($prefix == '')
        {
            if (class_exists('CI_'.$class))
            {
                $name = 'CI_'.$class;
            }
            elseif (class_exists(config_item('subclass_prefix').$class))
            {
                $name = config_item('subclass_prefix').$class;
            }
            else
            {
                $name = $class;
            }
        }
        else
        {
            $name = $prefix.$class;
        }

        // Is the class name valid?
        if ( ! class_exists($name))
        {
            log_message('error', "Non-existent class: ".$name);
            show_error("Non-existent class: ".$class);
        }

        // Set the variable name we will assign the class to
        // Was a custom class name supplied?  If so we'll use it
        $class = strtolower($class);

        if (is_null($object_name))
        {
            $classvar = ( ! isset($this->_ci_varmap[$class])) ? $class : $this->_ci_varmap[$class];
        }
        else
        {
            $classvar = $object_name;
        }

        // Save the class name and object name
        $this->_ci_classes[$class] = $classvar;

        // Instantiate the class
        $CI =& get_instance();

        if (!$method)
        {
            if ($config !== NULL)
            {
                $CI->$classvar = new $name($config);
            }
            else
            {
                $CI->$classvar = new $name;
            }
        }
        else
        {
            $CI->$classvar = $name::$method();
        }
    }
}

























