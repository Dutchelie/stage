<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['libraries'] = array('database', 'upload', 'session', 'user_agent', 'pagination', 'email', 'encryption', 'twitteroauth', 'recaptchalib');
$autoload['helper'] = array('xml', 'text', 'url', 'file', 'global', 'security', 'global_helper');
$autoload['config'] = array('sys_setting');
$autoload['language'] = array();
$autoload['model'] = array(
    'system/app_log_model',
    'system/ajaxck_model',
    'access/login_model',
    'access/register_model',
    'access/wachtwoord_model',
    'access/vergeten_model',
    'access/access_check_model',
    'user/user_model',
    'user/user_gender_model',
    'user/user_group_model'
);
