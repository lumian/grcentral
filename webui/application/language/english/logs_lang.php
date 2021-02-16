<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\language\english\logs_lang.php
	Description:	Language file for "Logs" controller.
	Laguage:		English
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

//
// Tabs
//
$lang['logs_tabs_title_provisioning']							= "Provisioning";
$lang['logs_tabs_title_api']									= "API query";
$lang['logs_tabs_title_system']									= "System";
//
// Page Provisioning
//
$lang['logs_provisioning_description_text']						= "This section contains the provisioning log (CFG/FW/PB requests).";

// Page Provisioning: Table
$lang['logs_provisioning_table_datetime']						= "Date and time";
$lang['logs_provisioning_table_device']							= "Device";
$lang['logs_provisioning_table_device_linktitle']				= "Go to the device page";
$lang['logs_provisioning_table_type']							= "Type of query";
$lang['logs_provisioning_table_type_device_get_cfg']			= "Config request";
$lang['logs_provisioning_table_type_device_get_fw']				= "Firmware request";
$lang['logs_provisioning_table_type_device_get_pb']				= "Phonebook request";
$lang['logs_provisioning_table_fwversion']						= "Firmware version";

//
// Page "System"
//
$lang['logs_system_description_text']							= "In this section there are logs of system operation.";
$lang['logs_system_underconstruction']							= "This section is under development.";

//
// Page "API query"
//
$lang['logs_api_description_text']								= "В данном разделе расположены логи запросов к API.";

// Page "API query": Table
$lang['logs_api_table_datetime']								= "Date and time";
$lang['logs_api_table_user']									= "User";
$lang['logs_api_table_query_type']								= "Query type";
$lang['logs_api_table_query']									= "Query";
$lang['logs_api_table_error']									= "Result";
$lang['logs_api_table_error_true']								= "Error";
$lang['logs_api_table_error_false']								= "Success";