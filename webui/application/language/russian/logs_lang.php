<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\language\russian\logs_lang.php
	Description:	Language file for "Logs" controller.
	Laguage:		Russian
	
	2021 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

//
// Табы
//
$lang['logs_tabs_title_provisioning']							= "Распространение";
$lang['logs_tabs_title_api']									= "Запросы к API";
$lang['logs_tabs_title_system']									= "Система";
//
// Страница "Распространение"
//
$lang['logs_provisioning_description_text']						= "В данном разделе расположены логи распространения (CFG/FW/PB запросы).";
// Страница "Распространение": Таблица
$lang['logs_provisioning_table_datetime']						= "Дата и время";
$lang['logs_provisioning_table_device']							= "Устройство";
$lang['logs_provisioning_table_device_linktitle']				= "Перейти к странице устройства";
$lang['logs_provisioning_table_type']							= "Тип запроса";
$lang['logs_provisioning_table_type_device_get_cfg']			= "Запрос конфига";
$lang['logs_provisioning_table_type_device_get_fw']				= "Запрос прошивки";
$lang['logs_provisioning_table_type_device_get_pb']				= "Запрос справочника";
$lang['logs_provisioning_table_fwversion']						= "Версия прошивки";
//
// Страница "Система"
//
$lang['logs_system_description_text']							= "В данном разделе расположены логи работы системы.";
$lang['logs_system_underconstruction']							= "Раздел находится в разработке.";
//
// Страница "Запросы к API"
//
$lang['logs_api_description_text']								= "В данном разделе расположены логи запросов к API.";
// Страница "Запросы к API": Таблица
$lang['logs_api_table_datetime']								= "Дата и время";
$lang['logs_api_table_user']									= "Пользователь";
$lang['logs_api_table_query_type']								= "Тип запроса";
$lang['logs_api_table_query']									= "Запрос";
$lang['logs_api_table_error']									= "Результат";
$lang['logs_api_table_error_true']								= "Ошибка запроса";
$lang['logs_api_table_error_false']								= "Успешный запрос";