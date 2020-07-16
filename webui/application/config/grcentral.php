<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.1
	File:			application\config\grcentral.php
	Description:	System settings config
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

//
// General settings
//
// ENG: The main title that will be added to all pages
// RUS: Главный тайтл который будет добавляться ко всем страницам
$config['grcentral']['site_title'] 				= 'GRCentral';
// ENG: GRCentral version
// RUS: Версия GRCentral
$config['grcentral']['version'] 				= '0.1';
// ENG: Path to the file storage
// RUS: Путь к хранилищу файлов
$config['grcentral']['storage_path']			= $_SERVER['DOCUMENT_ROOT'].'storage/';

//
// Provisioning
//
// ENG: Automatically adding devices to the database when accessing the server (CFG request)
// RUS: Автоматическое добавление девайсов в базу данных при обращении к серверу (CFG запрос)
$config['provisioning']['auto_add_devices']		= TRUE; // TRUE or FALSE
// ENG: Update devices only if they are present in the database and activated
// RUS: Обновлять аппараты только если они присутствуют в БД и активированы
$config['provisioning']['fw_update_only_friend']	= TRUE; // TRUE or FALSE
// ENG: Authorization
// RUS: Авторизация
$config['auth']['login']		= 'admin';
$config['auth']['password'] 	= 'admin';
