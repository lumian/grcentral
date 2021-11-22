<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\config\grcentral.php
	Description:	System settings config
	
	2021 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

//
// General settings
//

// ENG:
// RUS:
$config['system_installed'] = FALSE;

// ENG: The main title that will be added to all pages
// RUS: Главный тайтл который будет добавляться ко всем страницам
$config['grcentral']['site_title'] 				= 'GRCentral';
// ENG: GRCentral version
// RUS: Версия GRCentral
$config['grcentral']['version'] 				= '0.3';
// ENG: Path to the file storage
// RUS: Путь к хранилищу файлов
$config['grcentral']['storage_path']			= $_SERVER['DOCUMENT_ROOT'].'storage/';

// ENG: Authorization
// RUS: Авторизация
$config['auth']['login']						= 'admin';
$config['auth']['password'] 					= 'admin';

//
// Cron settings
//

// ENG: How many days to store logs?
// RUS: Сколько дней хранить логи
$config['cron']['keep_logs'] 					= '7';

//
// System update
//
// ENG: URL for checking the relevance of GRCentral
// RUS: URL для проверки актуальности GRCentral
$config['update']['url_version_file']			= 'https://raw.githubusercontent.com/lumian/grcentral/master/notify/version.json';

//
// API auth
//
$config['api']['users'][] = array('id'=>'1', 'ip'=>'192.168.1.1', 'name'=>'User1');
//$config['api']['users'][] = array('id'=>'2', 'ip'=>'192.168.1.2', 'name'=>'User2');
