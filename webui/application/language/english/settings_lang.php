<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\language\english\settings_lang.php
	Description:	Language file for "Settings" controller.
	Laguage:		English
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

// Tabs
$lang['settings_tabs_title_main']							= "Main";
$lang['settings_tabs_title_models']							= "Models";
$lang['settings_tabs_title_fw']								= "Firmware";
$lang['settings_tabs_title_params']							= "Parameters";
$lang['settings_tabs_title_servers']						= "VoIP servers";
$lang['settings_tabs_title_syssettings']					= "System";
//
// Main page
//
$lang['settings_index_head']								= "GRCentral server settings";
$lang['settings_index_text']								= "In this section, you can configure the models of devices available for management on the server, upload firmware files (upgrades) for them, configure settings for auto-configuration, configure available VoIP servers, and edit system settings.";
$lang['settings_index_service_state']						= "GRCentral Status";
$lang['settings_index_service_table_name']					= "Service name";
$lang['settings_index_service_table_status']				= "Service status";
$lang['settings_index_service_table_info']					= "Additional information";
$lang['settings_index_status_on']							= "Active";
$lang['settings_index_status_off']							= "Not active";
$lang['settings_index_status_off_descr']					= "This feature is disabled in system settings.";
$lang['settings_index_update_title']						= "Checking for system updates";
$lang['settings_index_update_current_version']				= "Current version";
$lang['settings_index_update_actual_version']				= "Available version";
$lang['settings_index_update_last_check']					= "Last check";
$lang['settings_index_update_need_update_yes']				= "Update required";
$lang['settings_index_update_need_update_no']				= "The system is up to date.";
$lang['settings_index_update_not_start']					= "The update check has not been performed before. Information is not available.";
$lang['settings_index_update_release_date']					= "Release date";
$lang['settings_index_update_release_url']					= "Link to the release";
$lang['settings_index_update_btn_start_check']				= "Check for updates";
$lang['settings_index_update_alert_ok']						= "The update check was completed successfully.";
$lang['settings_index_update_alert_error']					= "Error checking for updates.<br />Data could not be retrieved.";
//
// Page "Models"
//
$lang['settings_models_pagetitle']							= "Device model";
$lang['settings_models_description_text']					= "Device models are grouped and used for more precise configuration, as well as for linking upgrade files available on the server to them. To use it, first create a group and then a model.";
// Page "Models": Buttons
$lang['settings_models_btn_new']							= "New model";
$lang['settings_models_btn_newgroup']						= "New group";
// Page "Models": Table
$lang['settings_models_table_techname']						= "Technical name";
$lang['settings_models_table_friendlyname']					= "Friendly name";
$lang['settings_models_table_params']						= "Parameter template";
$lang['settings_models_table_noitemsingroup']				= "There are no models in this group.";
// Page "Models": Modal window "Editing or creating a group"
$lang['settings_models_modal_addeditgroup_titleadd']		= "Creating a new group";
$lang['settings_models_modal_addeditgroup_titleedit']		= "Editing a group";
$lang['settings_models_modal_addeditgroup_titlebase']		= "Basic group parameters";
$lang['settings_models_modal_addeditgroup_titlesettings']	= "Settings of configuration parameters";
$lang['settings_models_modal_addeditgroup_titlesettings_help']	= "Specify the name of the config parameters (P-Value) for the specified options for all accounts separated by commas (for example: 'P1,P2,P3,P4'). Specify ' P0 'to disable control of the selected parameter for the specified account (for example:'P0,P0,P0,P0').";
$lang['settings_models_modal_addeditgroup_groupname']		= "Group name";
$lang['settings_models_modal_addeditgroup_groupname_help']	= "Enter a custom group name";
$lang['settings_models_modal_addeditgroup_paramgroup']		= "Settings template";
$lang['settings_models_modal_addeditgroup_paramgroup_no']	= "Not selected";
$lang['settings_models_modal_addeditgroup_paramgroup_help']	= "Specify the settings template that will be applied for the specified model group.";
$lang['settings_models_modal_addeditgroup_params_conf_acc_atatus']	= "Account Active";
$lang['settings_models_modal_addeditgroup_params_conf_acc_name']	= "Account Name";
$lang['settings_models_modal_addeditgroup_params_conf_srv_main']	= "Primary SIP Server";
$lang['settings_models_modal_addeditgroup_params_conf_srv_reserve']	= "Secondary (or Failover) SIP Server";
$lang['settings_models_modal_addeditgroup_params_conf_sip_userid']	= "SIP User ID";
$lang['settings_models_modal_addeditgroup_params_conf_sip_authid']	= "Authenticate ID";
$lang['settings_models_modal_addeditgroup_params_conf_sip_passwd']	= "Authenticate Password";
$lang['settings_models_modal_addeditgroup_params_conf_show_name']	= "Name";
$lang['settings_models_modal_addeditgroup_params_conf_acc_display']	= "Account Display";
$lang['settings_models_modal_addeditgroup_params_conf_voicemail']	= "Voicemail number";
// Page "Models": Modal window "Delete a group"
$lang['settings_models_modal_delgroup_title']				= "Delete a group";
$lang['settings_models_modal_delgroup_confirm']				= "Do you really want to delete the specified group?";
// Page "Models": Modal window "Editing or creating device model"
$lang['settings_models_modal_addedit_titleadd']				= "Creating a new device model";
$lang['settings_models_modal_addedit_titleedit']			= "Editing the device model";
$lang['settings_models_modal_addedit_techname']				= "Technical name of the model";
$lang['settings_models_modal_addedit_techname_help']		= "The technical name is the name by which the system recognizes the device.";
$lang['settings_models_modal_addedit_friendlyname']			= "Friendly name";
$lang['settings_models_modal_addedit_friendlyname_help']	= "Custom name of the device model.";
$lang['settings_models_modal_addedit_group']				= "Model group";
$lang['settings_models_modal_addedit_group_help']			= "Specify a group of models to group them";
// Page "Models": Modal window "Deleting a device model"
$lang['settings_models_modal_del_title']					= "Deleting a device model";
$lang['settings_models_modal_del_confirm']					= "Do you really want to delete the specified model?";
// Page "Models": Messages
$lang['settings_models_flashdata_addsuccess']				= "The model was created successfully.";
$lang['settings_models_flashdata_adderror']					= "Model creation failed.";
$lang['settings_models_flashdata_editsuccess']				= "The model was successfully edited.";
$lang['settings_models_flashdata_editerror']				= "The model has not been edited.";
$lang['settings_models_flashdata_delsuccess']				= "The model was successfully deleted.";
$lang['settings_models_flashdata_delerror']					= "The model was not deleted.";
$lang['settings_models_flashdata_addgroupsuccess']			= "The group was created.";
$lang['settings_models_flashdata_addgrouperror']			= "Group creation failed.";
$lang['settings_models_flashdata_editgroupsuccess']			= "The group successfully edited.";
$lang['settings_models_flashdata_editgrouperror']			= "The group has not been edited.";
$lang['settings_models_flashdata_delgroupsuccess']			= "The group was successfully deleted.";
$lang['settings_models_flashdata_delgrouperror']			= "The group was not deleted because it is used in device models or updates.";
//
// Page "Firmware"
//
$lang['settings_fw_pagetitle']								= "Firmware";
$lang['settings_fw_description_text']						= "In this section, you can manage the firmware files for different device models. <br />To distribute the selected firmware to devices, set the status to 'Active'. Each group can have only one active firmware.<br />To use it, first create a group of models in <a href='".site_url('/settings/models/')."'>the corresponding section</a>, and then upload the firmware.";
// Page "Firmware": Buttons
$lang['settings_fw_btn_new']								= "New firmware";
// Page "Firmware": Table
$lang['settings_fw_table_version']							= "Version";
$lang['settings_fw_table_startversion']						= "Starting";
$lang['settings_fw_table_filename']							= "File name";
$lang['settings_fw_table_filename_real']					= "The real file name";
$lang['settings_fw_table_status']							= "Status";
$lang['settings_fw_table_status_on']						= "Active";
$lang['settings_fw_table_status_off']						= "Not active";
$lang['settings_fw_table_status_descr']						= "Click to change the current status";
$lang['settings_fw_table_noitemsingroup']					= "There is no firmware in this group.";
// Page "Firmware": Modal window "Editing / Adding firmware"
$lang['settings_fw_modal_addedit_title_add']				= "Adding firmware";
$lang['settings_fw_modal_addedit_version']					= "Firmware version";
$lang['settings_fw_modal_addedit_version_help']				= "Enter the firmware version to upload";
$lang['settings_fw_modal_addedit_group']					= "Model group";
$lang['settings_fw_modal_addedit_group_help']				= "Specify the group of device models for which you are uploading the firmware.";
$lang['settings_fw_modal_addedit_file']						= "Firmware file";
$lang['settings_fw_modal_addedit_file_help']				= "Specify the binary file to download (Max size: %s MB).";
// Page "Firmware": Modal window "Changing the status of the firmware"
$lang['settings_fw_modal_changestatus_title']				= "Changing the status of the firmware";
$lang['settings_fw_modal_changestatus_confirm']				= "Do you really want to change the firmware status?";
// Page "Firmware": Modal window "Deleting the firmware"
$lang['settings_fw_modal_del_title']						= "Deleting the firmware";
$lang['settings_fw_modal_del_confirm']						= "Do you really want to delete the firmware?";
// Page "Firmware": Messages
$lang['settings_fw_flashdata_addsuccess']					= "Firmware uploaded successfully!";
$lang['settings_fw_flashdata_adderror']						= "The upload of the firmware failed.";
$lang['settings_fw_flashdata_delsuccess']					= "Firmware successfully removed!";
$lang['settings_fw_flashdata_change_status_success']		= "Status change completed successfully!";
$lang['settings_fw_flashdata_minimum_requirements']			= "The values specified in your server settings are too small for the firmware download function to work correctly.<br />Please <a href='https://github.com/lumian/grcentral/wiki/%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0-GRCentral' target='_blank'>read the installation documentation</a> for details.";
//
// Page "Parameters"
//
$lang['settings_params_pagetitle']							= "Parameters";
$lang['settings_params_description_text']					= "In this section, you can directly manage device settings (P-Value). Settings are combined into templates. <br />To apply a template, select it in the <a href='".site_url('settings/models')."'>device models</a> section for each model group.";
// Page "Parameters": Buttons
$lang['settings_params_btn_new']							= "New template";
$lang['settings_params_btn_hideshow']						= "Hide / Show";
$lang['settings_params_btn_hide']							= "Hide";
// Page "Parameters": Table
$lang['settings_params_table_name']							= "Name";
$lang['settings_params_table_description']					= "Description";
// Page "Parameters": Modal window "Editing/Create a template"
$lang['settings_params_modal_eddedit_title_add']			= "Create a template";
$lang['settings_params_modal_eddedit_title_edit']			= "Editing a template";
$lang['settings_params_modal_eddedit_groupname']			= "Template name";
$lang['settings_params_modal_eddedit_groupname_help']		= "Enter a custom template name";
$lang['settings_params_modal_eddedit_description']			= "Short description of the template";
$lang['settings_params_modal_eddedit_description_help']		= "Enter a custom template description";
$lang['settings_params_modal_eddedit_params']				= "Parameters";
$lang['settings_params_modal_eddedit_params_help']			= "Enter the parameters in this field. One parameter per line. You can comment with the # symbol at the beginning of the line.";
// Page "Parameters": Modal window "Delete template"
$lang['settings_params_modal_del_title']					= "Delete template";
$lang['settings_params_modal_del_confirm']					= "Do you really want to delete the specified template?";
// Page "Parameters": Messages
$lang['settings_params_flashdata_addsuccess']				= "Template creation was successful!";
$lang['settings_params_flashdata_adderror']					= "Template creation failed.";
$lang['settings_params_flashdata_editsuccess']				= "The template was successfully edited.";
$lang['settings_params_flashdata_editerror']				= "The template was not edited.";
$lang['settings_params_flashdata_delsuccess']				= "Template was successfully deleted!";
$lang['settings_params_flashdata_delerror']					= "The template was not deleted because it is used in device models.";
//
// Page "VoIP Servers"
//
$lang['settings_servers_pagetitle']							= "VoIP Servers";
$lang['settings_servers_description_text']					= "This section configures the VoIP servers that the devices will connect to.";
// Page "VoIP Servers": Buttons
$lang['settings_servers_btn_new']							= "New server";
// Page "VoIP Servers": Table
$lang['settings_servers_table_name']						= "Server name";
$lang['settings_servers_table_description']					= "Description";
$lang['settings_servers_table_server']						= "Server address";
$lang['settings_servers_table_voicemailnumber']				= "Voice mail number";
// Page "VoIP Servers": Modal window "Editing/Creating a server"
$lang['settings_servers_modal_addedit_title_add']			= "Creating a server";
$lang['settings_servers_modal_addedit_title_edit']			= "Editing a server";
$lang['settings_servers_modal_addedit_name']				= "Server name";
$lang['settings_servers_modal_addedit_name_help']			= "Enter a custom server name";
$lang['settings_servers_modal_addedit_description']			= "Description";
$lang['settings_servers_modal_addedit_description_help']	= "Enter a custom description of the server";
$lang['settings_servers_modal_addedit_server']				= "Server adddress";
$lang['settings_servers_modal_addedit_server_help']			= "Enter the hostname or IP address of the VoIP server";
$lang['settings_servers_modal_addedit_voicemailnumber']		= "Voice mail number";
$lang['settings_servers_modal_addedit_voicemailnumber_help']	= "Enter the voice mail phone number that is relevant for this VoIP server.";
// Page "VoIP Servers": Modal window "Delete server"
$lang['settings_servers_modal_del_title']					= "Delete server";
$lang['settings_servers_modal_del_confirm']					= "Do you really want to delete the specified server?";
// Page "VoIP Servers": Messages
$lang['settings_servers_flashdata_addsuccess']				= "The creation of server completed successfully!";
$lang['settings_servers_flashdata_adderror']				= "Server creation failed.";
$lang['settings_servers_flashdata_editsuccess']				= "The server was successfully edited!";
$lang['settings_servers_flashdata_editerror']				= "The server was edited unsuccessfully.";
$lang['settings_servers_flashdata_delsuccess']				= "The server was successfully deleted.";
$lang['settings_servers_flashdata_delerror']				= "The server was not deleted because it was specified in the device settings.";
//
// Page "System settings"
//
$lang['settings_syssettings_pagetitle']						= "System settings";
$lang['settings_syssettings_description_text']				= "In this section, you can configure some important options for the GRCentral system. <br />Don't forget to save your settings after making changes.";
// Page "System settings": Descriptions
$lang['settings_syssettings_table_title_setting']			= "Setting / Description";
$lang['settings_syssettings_table_title_status']			= "Status";
$lang['settings_syssettings_title_general']					= "General settings";
$lang['settings_syssettings_access_device_by_ip_name']		= "Use IP address for authorization";
$lang['settings_syssettings_access_device_by_ip_help']		= "Additionally (other than the MAC address), use the IP address to authorize devices when accessing the server. This setting does not make sense when activating the auto-update IP addresses feature.";
$lang['settings_syssettings_auto_update_ip_addr_name']		= "Auto-update the device's IP address";
$lang['settings_syssettings_auto_update_ip_addr_help']		= "Automatically update the IP address in the database when the device accesses the server from a new address. It can be useful for dynamic addresses on devices.";
$lang['settings_syssettings_hide_help_header_msg_name']		= "Disable help by section";
$lang['settings_syssettings_hide_help_header_msg_help']		= "When this setting is enabled, messages with the section description will not be displayed in the system interface.";
$lang['settings_syssettings_monitoring_enable_name']		= "Enable device monitoring";
$lang['settings_syssettings_monitoring_enable_help']		= "When this function is enabled, the device monitoring statuses will be displayed in the interface, and it will also be possible to run a cron-script for monitoring.";
$lang['settings_syssettings_title_cfg_server']				= "Config server";
$lang['settings_syssettings_cfg_enable_get_name']			= "Enable the ability to get CFG files";
$lang['settings_syssettings_cfg_enable_get_help']			= "If this option is disabled, the devices will always get a 404 error when requesting a new CFG file.";
$lang['settings_syssettings_auto_add_devices_name']			= "Automatically adding devices";
$lang['settings_syssettings_auto_add_devices_help']			= "Automatically adding devices to the database when accessing the server (CFG request)";
$lang['settings_syssettings_title_fw_server']				= "Firmware update server";
$lang['settings_syssettings_fw_enable_update_name']			= "Allow firmware updates.";
$lang['settings_syssettings_fw_enable_update_help']			= "If this option is disabled, the devices will always receive a 404 error when requesting an update.";
$lang['settings_syssettings_fw_update_only_friend_name']	= "Update user-friendly devices only";
$lang['settings_syssettings_fw_update_only_friend_help']	= "Update devices only if they are present in the database and activated";
$lang['settings_syssettings_title_pb_server']				= "Phonebook server";
$lang['settings_syssettings_pb_generate_enable_name']		= "Enable the function of generating an XML phonebook file";
$lang['settings_syssettings_pb_generate_enable_help']		= "If you enable this option, you will be able to generate and receive Phonebook XML files by devices. If you disable this option, the phonebook section will not be disabled, and instead of the phonebook xml file, the error 404 (Not found) will be returned.";
$lang['settings_syssettings_pb_collect_accounts_name']		= "Collect information about accounts in phonebook.";
$lang['settings_syssettings_pb_collect_accounts_help']		= "In the process of applying the settings, information about phone accounts (Name and UserID) will be collected and integrated with the phonebook.";
$lang['settings_syssettings_title_api']						= "API";
$lang['settings_syssettings_api_enable_name']				= "Enable API";
$lang['settings_syssettings_api_enable_help']				= "Enabling the ability to use the API.";
// Page "System settings": Messages
$lang['settings_syssettings_flashdata_editsuccess']			= "Settings updated successfully";
$lang['settings_syssettings_flashdata_editerror']			= "An error occurred. Settings have not been updated.";
$lang['settings_syssettings_flashdata_resetsuccess']		= "All system settings have been successfully reset to \"Default\" mode.";
$lang['settings_syssettings_flashdata_reseterror']			= "An error occurred. The settings have not been reset.";
// Page "System settings": Buttons
$lang['settings_syssettings_btn_reset_settings']			= "Reset settings";
// Page "System settings": Modal window "Reset settings"
$lang['settings_syssettings_modal_reset_title']				= "Reset settings to \"Default\" mode";
$lang['settings_syssettings_modal_reset_confirm']			= "Confirm the reset. All system settings will be reset to \"Default\" mode.";
