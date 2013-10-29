<?php ob_start();
    session_start();
   error_reporting(0);
/**
 * Database host for mysql server
 * @var constant DB_HOST
 * @uses Use to connect to the database
 */
define('DB_HOST','localhost');

/**
 * Database user for mysql server
 * @var constant DB_USER
 * @uses Use to connect to the database
 */
define('DB_USER', 'root');

/**
 * Database passord for mysql server
 * @var constant DB_PASSWORD
 * @uses Use to connect to the database
 */
define('DB_PASS', '');

/**
 * Database name for mysql server
 * @var constant DB_NAME
 * @uses Use to connect to the database
 */
define('DB_NAME', 'mis');
/**
 * Base DIR path plugin
 **/
define('_DIRPATH_','D:/xampp/htdocs/misreport/plugins/');
/**
 * Base DIR path plugin lib
 **/
define('_DIRPATHLIB_','D:/xampp/htdocs/misreport/lib/');

/**
 * Base DIR path Excel lib
 **/
define('_DIRPATHLIBEXCEL_','D:/xampp/htdocs/misreport/');
/**
 * Base path
 **/
define('_PATH_','http://localhost/misreport/');

/*error data*/
define('PASSWORD_INCORRECT','Username and Password Incorrect');



?>
