<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2016-12-21 09:42:54 --> Severity: Notice --> Array to string conversion C:\Intel\WebServer\www\musicapp\system\database\DB_query_builder.php 669
ERROR - 2016-12-21 09:42:54 --> Query error: Unknown column 'Array' in 'where clause' - Invalid query: SELECT *
FROM `user`
WHERE 244 = `Array`
ERROR - 2016-12-21 10:14:59 --> Severity: Notice --> Array to string conversion C:\Intel\WebServer\www\musicapp\system\database\DB_query_builder.php 669
ERROR - 2016-12-21 10:14:59 --> Query error: Unknown column 'Array' in 'where clause' - Invalid query: SELECT `is_active`
FROM `user`
WHERE `user_id` = `Array`
ERROR - 2016-12-21 10:16:41 --> Severity: Warning --> Illegal string offset 'user_id' C:\Intel\WebServer\www\musicapp\application\models\access\Register_model.php 22
ERROR - 2016-12-21 10:18:56 --> Severity: Notice --> Array to string conversion C:\Intel\WebServer\www\musicapp\system\database\DB_query_builder.php 669
ERROR - 2016-12-21 10:18:56 --> Query error: Unknown column 'Array' in 'where clause' - Invalid query: SELECT `is_active`
FROM `user`
WHERE `user_id` = `Array`
ERROR - 2016-12-21 10:22:20 --> Severity: Notice --> Use of undefined constant console - assumed 'console' C:\Intel\WebServer\www\musicapp\application\models\access\Register_model.php 18
ERROR - 2016-12-21 10:51:49 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `user_login` (`user_id`, `username`) VALUES (NULL, 'test@gmail.com')
ERROR - 2016-12-21 10:54:11 --> Query error: Duplicate entry '245' for key 'PRIMARY' - Invalid query: INSERT INTO `user_login` (`user_id`, `username`) VALUES ('245', 'test@gmail.com')
ERROR - 2016-12-21 11:05:27 --> Severity: error --> Exception: Call to undefined method Register_model::get_login_mail() C:\Intel\WebServer\www\musicapp\application\controllers\Register.php 260
ERROR - 2016-12-21 11:06:16 --> Query error: Unknown column 'emailaddress' in 'where clause' - Invalid query: SELECT *
FROM `user_login`
WHERE `emailaddress` = 'test@gmail.com'
ERROR - 2016-12-21 11:30:02 --> Severity: Warning --> Missing argument 1 for Login::login_action(), called in C:\Intel\WebServer\www\musicapp\application\controllers\Login.php on line 15 and defined C:\Intel\WebServer\www\musicapp\application\controllers\Login.php 26
ERROR - 2016-12-21 11:30:02 --> Severity: Notice --> Undefined variable: fout C:\Intel\WebServer\www\musicapp\application\controllers\Login.php 40
ERROR - 2016-12-21 11:30:02 --> Severity: Notice --> Undefined variable: fout C:\Intel\WebServer\www\musicapp\application\controllers\Login.php 42
ERROR - 2016-12-21 11:31:53 --> Severity: Warning --> Missing argument 1 for Login::login_action(), called in C:\Intel\WebServer\www\musicapp\application\controllers\Login.php on line 15 and defined C:\Intel\WebServer\www\musicapp\application\controllers\Login.php 26
ERROR - 2016-12-21 12:13:16 --> Severity: Notice --> Undefined variable: plus C:\Intel\WebServer\www\musicapp\application\controllers\Login.php 37
ERROR - 2016-12-21 13:05:13 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '1) VALUES ('')' at line 1 - Invalid query: INSERT INTO `number` (1) VALUES ('')
ERROR - 2016-12-21 13:09:46 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '1) VALUES ('')' at line 1 - Invalid query: INSERT INTO `number` (1) VALUES ('')
ERROR - 2016-12-21 13:53:00 --> Query error: Duplicate entry '' for key 'PRIMARY' - Invalid query: INSERT INTO `login_fails` (`number`) VALUES (1)
ERROR - 2016-12-21 14:01:38 --> Query error: Duplicate entry '0' for key 'PRIMARY' - Invalid query: INSERT INTO `login_fails` (`number`) VALUES (1)
ERROR - 2016-12-21 14:42:01 --> Query error: Unknown column 'ip_address' in 'where clause' - Invalid query: UPDATE `user` SET `ip_address` = '192.168.16.38', `number` = 1
WHERE `ip_address` = '192.168.16.38'
ERROR - 2016-12-21 15:05:51 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '0 = ''
WHERE `ip_address` = '192.168.16.38'' at line 1 - Invalid query: UPDATE `login_fails` SET 0 = ''
WHERE `ip_address` = '192.168.16.38'
ERROR - 2016-12-21 15:25:33 --> Severity: Notice --> Undefined offset: 1 C:\Intel\WebServer\www\musicapp\application\controllers\Login.php 73
ERROR - 2016-12-21 15:27:23 --> Severity: Notice --> Undefined offset: 1 C:\Intel\WebServer\www\musicapp\application\controllers\Login.php 73
ERROR - 2016-12-21 15:37:03 --> Severity: Notice --> Undefined offset: 1 C:\Intel\WebServer\www\musicapp\application\controllers\Login.php 73
ERROR - 2016-12-21 15:37:53 --> Severity: Notice --> Undefined offset: 1 C:\Intel\WebServer\www\musicapp\application\controllers\Login.php 73
ERROR - 2016-12-21 16:23:38 --> Severity: error --> Exception: Cannot use object of type CI_Session as array C:\Intel\WebServer\www\musicapp\application\controllers\Login.php 58
ERROR - 2016-12-21 16:29:48 --> Query error: Table 'muziekwebsite.number' doesn't exist - Invalid query: INSERT INTO `number` (`ip_address`, `number`) VALUES ('192.168.16.38', 0)
ERROR - 2016-12-21 16:31:54 --> Query error: Table 'muziekwebsite.number' doesn't exist - Invalid query: INSERT INTO `number` (`ip_address`, `number`) VALUES ('192.168.16.38', 0)
ERROR - 2016-12-21 16:40:33 --> Query error: Table 'muziekwebsite.number' doesn't exist - Invalid query: INSERT INTO `number` (`ip_address`, `number`) VALUES ('192.168.16.38', 0)
