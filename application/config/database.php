<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

if( ENVIRONMENT == 'production' ) {
    $active_group = 'production_db';
} else if( ENVIRONMENT == 'demo' ) {
    $active_group = 'demo_db';
} else {
    $active_group = 'local_db';
}
$active_record = TRUE;

$db['local_db']['hostname'] = 'localhost';
$db['local_db']['username'] = 'root';
$db['local_db']['password'] = 'LogicXor0110SQL';
$db['local_db']['database'] = 'hotshi';
$db['local_db']['dbdriver'] = 'mysqli';
$db['local_db']['dbprefix'] = '';
$db['local_db']['pconnect'] = TRUE;
$db['local_db']['db_debug'] = TRUE;
$db['local_db']['cache_on'] = FALSE;
$db['local_db']['cachedir'] = '';
$db['local_db']['char_set'] = 'utf8';
$db['local_db']['dbcollat'] = 'utf8_general_ci';
$db['local_db']['swap_pre'] = '';
$db['local_db']['autoinit'] = TRUE;
$db['local_db']['stricton'] = FALSE;


$db['production_db']['hostname'] = 'localhost';
$db['production_db']['username'] = 'root';
$db['production_db']['password'] = 'L*gicXor0110SQLH';
$db['production_db']['database'] = 'hotshi';
$db['production_db']['dbdriver'] = 'mysqli';
$db['production_db']['dbprefix'] = '';
$db['production_db']['pconnect'] = TRUE;
$db['production_db']['db_debug'] = TRUE;
$db['production_db']['cache_on'] = FALSE;
$db['production_db']['cachedir'] = '';
$db['production_db']['char_set'] = 'utf8';
$db['production_db']['dbcollat'] = 'utf8_general_ci';
$db['production_db']['swap_pre'] = '';
$db['production_db']['autoinit'] = TRUE;
$db['production_db']['stricton'] = FALSE;

$db['demo_db']['hostname'] = 'localhost';
$db['demo_db']['username'] = 'root';
$db['demo_db']['password'] = 'L*gicXor0110SQLH';
$db['demo_db']['database'] = 'hotshi';
$db['demo_db']['dbdriver'] = 'mysqli';
$db['demo_db']['dbprefix'] = '';
$db['demo_db']['pconnect'] = TRUE;
$db['demo_db']['db_debug'] = TRUE;
$db['demo_db']['cache_on'] = FALSE;
$db['demo_db']['cachedir'] = '';
$db['demo_db']['char_set'] = 'utf8';
$db['demo_db']['dbcollat'] = 'utf8_general_ci';
$db['demo_db']['swap_pre'] = '';
$db['demo_db']['autoinit'] = TRUE;
$db['demo_db']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */