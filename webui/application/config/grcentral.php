<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral
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
$config['grcentral']['version'] 				= '0.2';
// ENG: Path to the file storage
// RUS: Путь к хранилищу файлов
$config['grcentral']['storage_path']			= $_SERVER['DOCUMENT_ROOT'].'storage/';

// ENG: Authorization
// RUS: Авторизация
$config['auth']['login']		= 'admin';
$config['auth']['password'] 	= 'admin';
