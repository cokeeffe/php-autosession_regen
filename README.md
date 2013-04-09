php-autosession_regen
=====================

PHP Source modification to regenerate session ID's automatically, with an ini control tweek also. [Safer] PHP sessions 'out-of-the-box'. Why? Session Fixation (as well as other attacks).

<h2>Session Fixation</h2>
A known method of attacking a session within a PHP application is session fixation. As an ID uniquely identifies sessions, these are the key to access session information. During a session fixation, more than one party can view
a session by using the session ID. Taking an example of Alice and Bob. Alice accesses our website, www.mysite.com and logins using her username and password. Bob is interested in what information lies within Alices login area.
When Alice logins in, a session ID is created, for argument sake we will say ABC123. When Alice accesses www.mysite.com/index.php?PHPSESSID=ABC123 she can see her own page. However, if Bob, on the other side of the internet opens the exact same URL, he can see what Alice sees, and Alice does
not even know. This is a very simple example of a session fixation.

<h2>Solution</h2>
The default PHP session extension deploys a relatively simple implemen- tation of stateful sessions. To overcome the problem of session fixation, it is recommended to use the session regenerate id() function in PHP scripts. However, for new developers or inexperienced developers, this is not a com- mon practice. To overcome this problem and to improve the overall default out of the box security of php sessions, implementing the session regenerate id() function within the PHP engine itself and providing an INI entry to turn this feature on and off can simply be deployed in PHP, without a programmer even knowing, therefore helping reduce the possibility of a session fixation attack. The code has been tested on PHP-5.2.0 source code.

<h2>What is happening</h2>
The main two scripts that need to be altered are the session.c and session.h scripts located in the ext/session folder. In the php session.h script, we need to add an INI entry. This INI entry allows administrators to turn on or off the auto regenerate feature we are about to add. Within the structure,
php ps globals , on line 131, add the following:
zend_bool regenerate_id;
This allows us to set a true or false value for the global regenerate id. Open the session.c file. This is where most of the work is done. Within the PHP INI BEGIN(), we need to add the INI entry. On line 202, add the following:
STD_PHP_INI_BOOLEAN( "session.auto_regenerate",  "1", PHP_INI_ALL,
OnUpdateBool, regenerate_id, php_ps_globals, ps_globals)
This will add the INI entry, which we call regenerate id to the INI table. By default it will be set to true. Next we need to add the regenerate function to the session start() function. This will mean every time session start() is called in a script, a new session id is generate. On line 1279 we will add the following:
if( PS(regenerate_id) == 1 )
   {
  PS(id) = PS(mod)->s_create_sid(&PS(mod_data), NULL TSRMLS_CC);
   }
This reads the value of or INI entry, regenerate id. If it is true , a new session ID is created and replaces the current session id. Next we need to add the option setting to the php.ini file. Open the php.ini file and at line 893 add the following:
; Use automatic regenerate ID
session.auto_regenerate = 1

After these changes have been made, we can recompile PHP, restart Apache and test our changes. The test_session.php code will display the current session ID and set values for the SESSION. Clicking on the link button will regenerate our id as can be seen on the webpage.

<h2>Questions</h2>
cokeeffe A\T\ gmail D\0\T\ com 
