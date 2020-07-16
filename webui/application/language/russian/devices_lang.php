<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.1
	File:			application\language\russian\devices_lang.php
	Description:	Language file for "Devices" controller.
	Laguage:		Russian
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

//
// Табы
//
$lang['devices_tabs_title_main']							= "Устройства";
$lang['devices_tabs_title_info']							= "Информация об устройстве";

//
// Главная страница (Список устройств)
//

$lang['devices_index_description_text']						= "В данном разделе осуществляется управление устройствами.<br />Управление SIP аккаунтами производится по кнопке \"Инфо\".<br />Примечание: Отключенные устройства не получают настроек от сервера.";
// Главная страница: Таблица
$lang['devices_index_table_descr']							= "Описание";
$lang['devices_index_table_macaddr']						= "MAC адрес";
$lang['devices_index_table_ipaddr']							= "IP адрес";
$lang['devices_index_table_ipaddr_linktitle']				= "Перейти в WEB интерфейс";
$lang['devices_index_table_model']							= "Модель";
$lang['devices_index_table_model_na']						= "Не определена";
$lang['devices_index_table_accounts']						= "Аккаунты";
$lang['devices_index_table_accounts_na']					= "N/A";
$lang['devices_index_table_fwversion']						= "Версия FW";
$lang['devices_index_table_fwversion_na']					= "N/A";
$lang['devices_index_table_fwversionpinned_help']			= "Прошивка закреплена";
// Главная страница: Кнопки
$lang['devices_index_btn_new']								= "Новое устройство";
$lang['devices_index_btn_infotitle']						= "Инфо";
// Главная страница: Модальное окно "Добавление/Редактирование" устройства
$lang['devices_index_modaladdedit_titleadd']				= "Создание нового устройства";
$lang['devices_index_modaladdedit_titleedit']				= "Редактирование устройства";
$lang['devices_index_modaladdedit_mac_addr']				= "MAC адрес";
$lang['devices_index_modaladdedit_mac_addr_help']			= "Укажите MAC адрес устройства.";
$lang['devices_index_modaladdedit_ip_addr']					= "IP адрес";
$lang['devices_index_modaladdedit_ip_addr_help']			= "Укажите IP адрес устройства";
$lang['devices_index_modaladdedit_model']					= "Модель аппарата";
$lang['devices_index_modaladdedit_model_help']				= "Выберете модель устройства из списка.";
$lang['devices_index_modaladdedit_model_na']				= "Не определена";
$lang['devices_index_modaladdedit_descr']					= "Описание";
$lang['devices_index_modaladdedit_descr_help']				= "Произвольное описание.";
$lang['devices_index_modaladdedit_statusactive']			= "Активность";
$lang['devices_index_modaladdedit_statusactive_help']		= "Включить или выключить работу с указанным устройством.";
$lang['devices_index_modaladdedit_statusactive_on']			= "Активирован";
$lang['devices_index_modaladdedit_statusactive_off']		= "Не активирован";
$lang['devices_index_modaladdedit_fwversionpinned']			= "Закрепить прошивку";
$lang['devices_index_modaladdedit_fwversionpinned_help']	= "Укажите прошивку, которую необходимо закрепить за данным устройством. Закрепленная прошивка должна быть равна или выше уже установленной.";
$lang['devices_index_modaladdedit_fwversionpinned_off']		= "Без закрепления - на общих условиях";
// Главная страница: Модальное окно "Удаление устройства"
$lang['devices_index_modaldel_title']						= "Удаление устройства";
$lang['devices_index_modaldel_confirm']						= "Вы действительно хотите удалить устройство?";
// Главная страница: Сообщения
$lang['devices_index_flashdata_addsuccess']					= "Устройство успешно создано.";
$lang['devices_index_flashdata_adderror']					= "Устройство не создано.";
$lang['devices_index_flashdata_editsuccess']				= "Устройство успешно отредактировано.";
$lang['devices_index_flashdata_editerror']					= "Устройство не отредактировано.";
$lang['devices_index_flashdata_delsuccess']					= "Устройство успешно удалено.";

//
// Страница информации об устройстве
//

// Страница информации: Панель "Общая информация"
$lang['devices_info_panel_about_title']						= "Общая информация";
$lang['devices_info_panel_about_model']						= "Модель устройства";
$lang['devices_info_panel_about_ipaddr']					= "IP адрес";
$lang['devices_info_panel_about_macaddr']					= "MAC адрес";
$lang['devices_info_panel_about_statusonline']				= "Онлайн";
$lang['devices_info_panel_about_statusonline_on']			= "В сети";
$lang['devices_info_panel_about_statusonline_off']			= "Не в сети";
$lang['devices_info_panel_about_statusactive']				= "Активность";
$lang['devices_info_panel_about_statusactive_on']			= "Активировано";
$lang['devices_info_panel_about_statusactive_off']			= "Не активировано";
$lang['devices_info_panel_about_descr']						= "Описание";
// Страница информации: Панель "CTI интеграция"
$lang['devices_info_panel_cti_title']						= "CTI интеграция";
$lang['devices_info_panel_cti_notavailable']				= "CTI интеграция недоступна. В шаблоне настроек для данного устройства, не найден пароль администратора (P2 value)";
// Страница информации: Панель "SIP аккаунты"
$lang['devices_info_panel_accounts_title']					= "SIP аккаунты";
$lang['devices_info_panel_accounts_description']			= "Кол-во аккаунтов ограничено 4 штуками, в зависимости от модели устройства, будет использоваться от 1 до 4 штук.";
// Страница информации: Кнопки
$lang['devices_info_btn_accounts_edit']						= "Редактировать SIP аккаунты";
$lang['devices_info_btn_cti_reboot']						= "Перезагрузка";
// Страница информации: Таблица с SIP аккаунтами
$lang['devices_info_table_accounts_position']				= "#";
$lang['devices_info_table_accounts_name']					= "Наименование";
$lang['devices_info_table_accounts_userid']					= "UserID";
$lang['devices_info_table_accounts_authid']					= "AuthID";
$lang['devices_info_table_accounts_password']				= "Пароль";
$lang['devices_info_table_accounts_voipsrv1']				= "Сервер #1";
$lang['devices_info_table_accounts_voipsrv2']				= "Сервер #2";
$lang['devices_info_table_accounts_voipsrv_na']				= "N/A";
$lang['devices_info_table_accounts_status']					= "Статус";
$lang['devices_info_table_accounts_status_on']				= "Включен";
$lang['devices_info_table_accounts_status_off']				= "Отключен";
// Страница информации: Модальное окно "Редактирование SIP аккаунтов"
$lang['devices_info_modal_accounts_title']					= "Редактирование SIP аккаунтов";
$lang['devices_info_modal_accounts_account']				= "Аккаунт";
$lang['devices_info_modal_accounts_mustbefilled']			= "обязательно";
$lang['devices_info_modal_accounts_active']					= "Укажите статус аккаунта";
$lang['devices_info_modal_accounts_active_on']				= "Включен";
$lang['devices_info_modal_accounts_active_off']				= "Выключен";
$lang['devices_info_modal_accounts_name']					= "Произвольное наименование";
$lang['devices_info_modal_accounts_voipsrv1']				= "Укажите основной сервер";
$lang['devices_info_modal_accounts_voipsrv2']				= "Укажите дополнительный сервер";
$lang['devices_info_modal_accounts_userid']					= "UserID";
$lang['devices_info_modal_accounts_authid']					= "AuthID";
$lang['devices_info_modal_accounts_password']				= "Пароль";
// Страница информации: Сообщения
$lang['devices_info_flashdata_account_editsuccess']			= "Редактирование аккаунтов успешно выполнено.";
$lang['devices_info_flashdata_account_editerror']			= "Редактирование аккаунтов не выполнено.";
