<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

define('ORGANIZATION', 'NextGenI');
define('TITLE', 'SHOUTBURST');
define('SUPER_ADMIN', 1);
define('COMP_ADMIN', 2);
define('COMP_MANAGER', 3);
define('COMP_AGENT', 4);
define('USER_PHOTO', 'photos/user_photo');
define('WB_PHOTO', 'photos/wallboard_logo');

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */


define('COMP_LOGO', 'company_logo');
define('LOG_FOLDER', 'logs');
define('SECURITYCODE_LENGTH',12);
define('SALT','7XryE48NboQ');

/**Chart Using Constant*/

define('LIVE_INTERVAL',					'300'); //currently set 5 min i.e get last 5 min data 5*60=300
define('LIVE_CHART_UPDATE_DURATION',	'10'); //every 10 Second
define('CHART_UPDATE_COUNTER_SHOW',		0); //every 10 Second


define('SCREEN_DELAY',20*1000);

/* Location: ./application/config/constants.php */