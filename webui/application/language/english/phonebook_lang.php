<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\language\english\phonebook.php
	Description:	Language file for "Phonebook" controller.
	Laguage:		English
	
	2021 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

//
// Tabs
//
$lang['phonebook_tabs_title_abonents']							= "Subscribers";
//
// Page "Subscribers"
//
$lang['phonebook_abonents_description_text']					= "In this section, you can view the directory of subscribers generated based on your data. Editing is only possible for manually added subscribers. Attention! The directory file is given only to activated and added to the database devices.";
// Page "Subscribers": table
$lang['phonebook_abonents_table_firstname']						= "Surname";
$lang['phonebook_abonents_table_lastname']						= "Name";
$lang['phonebook_abonents_table_phonework']						= "Phone number";
$lang['phonebook_abonents_table_datasource']					= "Data source";
$lang['phonebook_abonents_table_datasource_']					= "N/A";
$lang['phonebook_abonents_table_datasource_transform']			= "Transform to";
$lang['phonebook_abonents_table_datasource_manual']				= "Internal: created manually";
$lang['phonebook_abonents_table_datasource_accounts']			= "Internal: VoIP accounts";
$lang['phonebook_abonents_table_datasource_ldap']				= "External: LDAP";
$lang['phonebook_abonents_table_status']						= "Status";
$lang['phonebook_abonents_table_status_on']						= "Active";
$lang['phonebook_abonents_table_status_off']					= "Not active";
$lang['phonebook_abonents_table_status_descr_manual']			= "Click to change the status";
$lang['phonebook_abonents_table_status_descr_external']			= "Switching the status is only possible for subscribers added manually.";
// Page "Subscribers": Buttons
$lang['phonebook_abonents_btn_new']								= "New subscriber";
$lang['phonebook_abonents_btn_infotitle']						= "Info";
$lang['phonebook_abonents_btn_gotodevice']						= "Open the device with the specified account";
$lang['phonebook_abonents_btn_action_na']						= "No actions available. Editing is performed in an external database.";
// Page "Subscribers": Modal window "Change the status of the subscriber"
$lang['phonebook_abonents_modal_changestatus_title']			= "Change the status of the subscriber";
$lang['phonebook_abonents_modal_changestatus_confirm']			= "Do you really want to change the subscriber status?<br /><i>Note: only active subscribers are uploaded to the address book on the devices.</i>";
// Page "Subscribers": Modal window "Transforming a data source"
$lang['phonebook_abonents_modal_transformsource_title']			= "Transforming a data source";
$lang['phonebook_abonents_modal_transformsource_confirm']		= "Do you really want to change the data source to manual?";
// Page "Subscribers": Modal window "Delete the subscriber"
$lang['phonebook_abonents_modal_delabonent_title']				= "Delete the subscriber";
$lang['phonebook_abonents_modal_delabonent_confirm']			= "Do you really want to delete the selected subscriber from the directory?";
// Page "Subscribers": Modal window "Adding / Editing a subscriber"
$lang['phonebook_abonents_modal_addeditabonent_title_add']		= "Creating a new subscriber";
$lang['phonebook_abonents_modal_addeditabonent_title_edit']		= "Editing a subscriber";
$lang['phonebook_abonents_modal_addeditabonent_firstname']		= "Surname";
$lang['phonebook_abonents_modal_addeditabonent_firstname_help']	= "Enter the subscriber's last name";
$lang['phonebook_abonents_modal_addeditabonent_lastname']		= "Name";
$lang['phonebook_abonents_modal_addeditabonent_lastname_help']	= "Enter the subscriber's name";
$lang['phonebook_abonents_modal_addeditabonent_phonework']		= "Phone number";
$lang['phonebook_abonents_modal_addeditabonent_phonework_help']	= "Enter phone number";
$lang['phonebook_abonents_modal_addeditabonent_status']			= "Status";
$lang['phonebook_abonents_modal_addeditabonent_status_help']	= "Only active subscribers are uploaded to the directory on devices";
$lang['phonebook_abonents_modal_addeditabonent_status_on']		= "Active";
$lang['phonebook_abonents_modal_addeditabonent_status_off']		= "Not active";
// Page "Subscribers": Messages
$lang['phonebook_abonents_flashdata_changestatus_success']		= "Status change completed successfully.";
$lang['phonebook_abonents_flashdata_transformsource_success']	= "The data source was changed successfully.";
$lang['phonebook_abonents_flashdata_addabonent_success']		= "The new subscriber was successfully added to the directory.";
$lang['phonebook_abonents_flashdata_addabonent_error']			= "Error. The subscriber is not added.";
$lang['phonebook_abonents_flashdata_addabonent_error_phoneuse']	= "The subscriber number is already in use.";
$lang['phonebook_abonents_flashdata_editabonent_success']		= "Subscriber data was successfully edited.";
$lang['phonebook_abonents_flashdata_editabonent_error']			= "Error. Subscriber data is not edited.";
$lang['phonebook_abonents_flashdata_delabonent_success']		= "Subscriber deletion was completed successfully.";