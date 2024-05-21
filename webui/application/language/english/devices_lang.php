<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.4
	File:			application\language\english\devices_lang.php
	Description:	Language file for "Devices" controller.
	Laguage:		English
	
	2020-2024 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

//
// Tabs
//
$lang['devices_tabs_title_main']							= "Devices";
$lang['devices_tabs_title_info']							= "Device information";
//
// Main page
//
$lang['devices_index_description_text']						= "This section provides device management. SIP accounts are managed using the \"info\" button. <br />Note: Disabled devices do not receive settings/firmware from the server. <br />To use it, first add the device models in the <a href='".site_url('settings/models')."'>Settings -> Models</a> section";
// Main page: Table
$lang['devices_index_table_descr']							= "Description";
$lang['devices_index_table_macaddr']						= "MAC address";
$lang['devices_index_table_ipaddr']							= "IP address";
$lang['devices_index_table_ipaddr_linktitle']				= "Go to the WEB interface";
$lang['devices_index_table_status']							= "Status";
$lang['devices_index_table_status_online_on']				= "The device is online";
$lang['devices_index_table_status_online_off']				= "The device is offline";
$lang['devices_index_table_status_private_params_yes']		= "The device has private parameters";
$lang['devices_index_table_model']							= "Model";
$lang['devices_index_table_model_na']						= "Not defined";
$lang['devices_index_table_accounts']						= "Accounts";
$lang['devices_index_table_accounts_na']					= "N/A";
$lang['devices_index_table_fwversion']						= "FW version";
$lang['devices_index_table_fwversion_na']					= "N/A";
$lang['devices_index_table_fwversionpinned_help']			= "Pinned firmware";
// Main page: Buttons
$lang['devices_index_btn_new']								= "New device";
$lang['devices_index_btn_import']							= "Import devices";
$lang['devices_index_btn_infotitle']						= "Info";
// Главная страница: Модальное окно "Импорт устройств"
$lang['devices_index_modalimport_title']					= "Import devices";
$lang['devices_index_modalimport_csv']						= "CSV body";
$lang['devices_index_modalimport_csv_help']					= "Information about devices in CSV format. <br />For more information about the data format, see the project wiki on github.";
// Main page: A modal window "Add/Edit" device
$lang['devices_index_modaladdedit_titleadd']				= "Creating a new device";
$lang['devices_index_modaladdedit_titleedit']				= "Editing a device";
$lang['devices_index_modaladdedit_mac_addr']				= "MAC address";
$lang['devices_index_modaladdedit_mac_addr_help']			= "Specify the device's MAC address.";
$lang['devices_index_modaladdedit_ip_addr']					= "IP address";
$lang['devices_index_modaladdedit_ip_addr_help']			= "Enter the device's IP address";
$lang['devices_index_modaladdedit_model']					= "Device model";
$lang['devices_index_modaladdedit_model_help']				= "Select the device model from the list.";
$lang['devices_index_modaladdedit_model_na']				= "Not defined";
$lang['devices_index_modaladdedit_descr']					= "Description";
$lang['devices_index_modaladdedit_descr_help']				= "Custom description.";
$lang['devices_index_modaladdedit_statusactive']			= "Activity";
$lang['devices_index_modaladdedit_statusactive_help']		= "Enable or disable working with the specified device.";
$lang['devices_index_modaladdedit_statusactive_on']			= "Activated";
$lang['devices_index_modaladdedit_statusactive_off']		= "Not activated";
$lang['devices_index_modaladdedit_fwversionpinned']			= "Pin the firmware";
$lang['devices_index_modaladdedit_fwversionpinned_def']		= "First, specify the device model";
$lang['devices_index_modaladdedit_fwversionpinned_help']	= "Specify the firmware that you want to attach to this device.";
$lang['devices_index_modaladdedit_fwversionpinned_off']		= "Without pinning";
$lang['devices_index_modaladdedit_params']					= "Parameters";
$lang['devices_index_modaladdedit_params_help']				= "Enter the parameters in this field. One parameter per line. You can comment with the # symbol at the beginning of the line. The parameters specified here take precedence over the group parameters.";
// Main page: A modal window "Deleting a device"
$lang['devices_index_modal_del_title']						= "Deleting a device";
$lang['devices_index_modal_del_confirm']					= "Really delete the device?";
// Main page: A modal window "Device logs"
$lang['devices_index_modallogs_title']						= "Device logs";
$lang['devices_index_modallogs_descr']						= "The logs of the selected device's calls to GRCentral are shown below.";
$lang['devices_index_modallogs_table_date']					= "Date and time";
$lang['devices_index_modallogs_table_type']					= "Type of query";
$lang['devices_index_modallogs_table_fwversion']			= "FW version";
$lang['devices_index_modallogs_table_nodata']				= "No data";
// Main page: Messages
$lang['devices_index_flashdata_addsuccess']					= "The device was successfully created.";
$lang['devices_index_flashdata_adderror']					= "The device is not created.";
$lang['devices_index_flashdata_editsuccess']				= "The device was successfully edited.";
$lang['devices_index_flashdata_editerror']					= "The device is not edited.";
$lang['devices_index_flashdata_delsuccess']					= "The device was successfully deleted.";
$lang['devices_index_flashdata_import_title_error']			= "Import error";
$lang['devices_index_flashdata_import_1ststring_error']		= "the title bar does not match the reference one, check the template and try again.";
$lang['devices_index_flashdata_import_1staccdis_error']		= "account №1 on the device is disabled in line";
$lang['devices_index_flashdata_import_collectdata_error']	= "failed to collect account data for the device in line";
$lang['devices_index_flashdata_import_model_error']			= "the device model could not be determined in the line";
$lang['devices_index_flashdata_import_convert_error']		= "it was not possible to convert data from CSV to a data array. Check the correctness of the entered data.";
$lang['devices_index_flashdata_import_form_error']			= "no data was received from the form.";
$lang['devices_index_flashdata_import_success']				= "The device import was successful. Imported devices:";
//
// Page "Device information"
//
$lang['devices_info_pagetitle']								= "Device information";
// Page "Device information": Panel "General information"
$lang['devices_info_panel_about_title']						= "General information about the device";
$lang['devices_info_panel_about_model']						= "Device model";
$lang['devices_info_panel_about_ipaddr']					= "IP address";
$lang['devices_info_panel_about_ipaddr_linktitle']			= "Go to the WEB interface";
$lang['devices_info_panel_about_macaddr']					= "MAC address";
$lang['devices_info_panel_about_descr']						= "Description";
// Page "Device information": Panel "Actions with the device"
$lang['devices_info_panel_actions_title']					= "Actions with the device";
$lang['devices_info_panel_actions_reboot_na_error']			= "Reboot action is not available.";
$lang['devices_info_panel_actions_reboot_na_descr']			= "The administrator password (P2 value) was not found in the settings template for this device. Device reboot is not available.";
// Page "Device information": Panel "State"
$lang['devices_info_panel_status_title']					= "Device status";
$lang['devices_info_panel_status_online_title']				= "Availability";
$lang['devices_info_panel_status_online_changetime']		= "As of";
$lang['devices_info_panel_status_online_on']				= "Online";
$lang['devices_info_panel_status_online_off']				= "Offline";
$lang['devices_info_panel_status_active_title']				= "Activity";
$lang['devices_info_panel_status_active_on']				= "Activated";
$lang['devices_info_panel_status_active_off']				= "Not activated";
$lang['devices_info_panel_status_privateparams_title']		= "Parameters";
$lang['devices_info_panel_status_privateparams_yes']		= "Set";
$lang['devices_info_panel_status_privateparams_no']			= "Not set";
$lang['devices_info_panel_status_fw_title']					= "Firmware";
$lang['devices_info_panel_status_fw_pinned']				= "Pinned firmware";
// Page "Device information": Panel "Device monitoring"
$lang['devices_info_panel_monitoring_title']				= "Device monitoring";
$lang['devices_info_panel_monitoring_online']				= "online";
$lang['devices_info_panel_monitoring_offline']				= "offline";
$lang['devices_info_panel_monitoring_available_descr']		= "Device availability";
// Page "Device information": Panel "SIP accounts"
$lang['devices_info_panel_accounts_title']					= "SIP accounts";
$lang['devices_info_panel_accounts_description']			= "The number of accounts is limited to 4 pieces, depending on the device model, from 1 to 4 pieces will be used.";
// Page "Device information": Buttons
$lang['devices_info_btn_accounts_edit']						= "Edit SIP accounts";
$lang['devices_info_btn_logs']								= "Viewing logs";
$lang['devices_info_btn_cti_reboot']						= "Device reboot";
// Page "Device information": Table with SIP accounts
$lang['devices_info_table_accounts_position']				= "#";
$lang['devices_info_table_accounts_name']					= "Name";
$lang['devices_info_table_accounts_userid']					= "UserID";
$lang['devices_info_table_accounts_authid']					= "AuthID";
$lang['devices_info_table_accounts_password']				= "Password";
$lang['devices_info_table_accounts_voipsrv1']				= "Server #1";
$lang['devices_info_table_accounts_voipsrv2']				= "Server #2";
$lang['devices_info_table_accounts_voipsrv_na']				= "N/A";
$lang['devices_info_table_accounts_status']					= "Status";
$lang['devices_info_table_accounts_status_on']				= "On";
$lang['devices_info_table_accounts_status_off']				= "Off";
// Page "Device information": Modal window "Editing SIP accounts"
$lang['devices_info_modal_accounts_title']					= "Editing SIP accounts";
$lang['devices_info_modal_accounts_account']				= "Account";
$lang['devices_info_modal_accounts_mustbefilled']			= "necessarily";
$lang['devices_info_modal_accounts_active']					= "Specify the status of an account";
$lang['devices_info_modal_accounts_active_on']				= "On";
$lang['devices_info_modal_accounts_active_off']				= "Off";
$lang['devices_info_modal_accounts_name']					= "Custom name";
$lang['devices_info_modal_accounts_voipsrv1']				= "Specify the primary server";
$lang['devices_info_modal_accounts_voipsrv2']				= "Specify an additional server";
$lang['devices_info_modal_accounts_userid']					= "UserID";
$lang['devices_info_modal_accounts_authid']					= "AuthID";
$lang['devices_info_modal_accounts_password']				= "Password";
// Page "Device information": Modal window "Reboot device"
$lang['devices_info_modal_reboot_title']					= "Reboot device";
$lang['devices_info_modal_reboot_confirm']					= "Really reboot the device?";
$lang['devices_info_modal_reboot_querysuccess']				= "The request to reboot the device has been successfully sent.";
$lang['devices_info_modal_reboot_queryerror']				= "An error has occurred. The request to reboot the device was not executed.";
// Page "Device information": Messages
$lang['devices_info_flashdata_account_editsuccess']			= "Account editing was completed successfully.";
$lang['devices_info_flashdata_account_editerror']			= "Edit the accounts are not made.";
