<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.4
	File:			application\language\russian\devices_lang.php
	Description:	Language file for "Devices" controller.
	Laguage:		Russian
	
	2020-2021 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

//
// Табы
//
$lang['devices_tabs_title_main']							= "Устройства";
$lang['devices_tabs_title_info']							= "Информация об устройстве";
//
// Главная страница
//
$lang['devices_index_description_text']						= "В данном разделе осуществляется управление устройствами. Управление SIP аккаунтами производится по кнопке \"Инфо\".<br />Примечание: Отключенные устройства не получают настроек/прошивок от сервера.";
// Главная страница: Таблица
$lang['devices_index_table_descr']							= "Описание";
$lang['devices_index_table_macaddr']						= "MAC адрес";
$lang['devices_index_table_ipaddr']							= "IP адрес";
$lang['devices_index_table_ipaddr_linktitle']				= "Перейти в WEB интерфейс";
$lang['devices_index_table_status']							= "Статус";
$lang['devices_index_table_status_online_on']				= "Устройство в сети";
$lang['devices_index_table_status_online_off']				= "Устройство не в сети";
$lang['devices_index_table_status_private_params_yes']		= "Устройство имеет частные параметры";
$lang['devices_index_table_model']							= "Модель";
$lang['devices_index_table_model_na']						= "Не определена";
$lang['devices_index_table_accounts']						= "Аккаунты";
$lang['devices_index_table_accounts_na']					= "N/A";
$lang['devices_index_table_fwversion']						= "FW";
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
$lang['devices_index_modaladdedit_model']					= "Модель устройства";
$lang['devices_index_modaladdedit_model_help']				= "Выберете модель устройства из списка.";
$lang['devices_index_modaladdedit_model_na']				= "Не определена";
$lang['devices_index_modaladdedit_descr']					= "Описание";
$lang['devices_index_modaladdedit_descr_help']				= "Произвольное описание.";
$lang['devices_index_modaladdedit_statusactive']			= "Активность";
$lang['devices_index_modaladdedit_statusactive_help']		= "Включить или выключить работу с указанным устройством.";
$lang['devices_index_modaladdedit_statusactive_on']			= "Активирован";
$lang['devices_index_modaladdedit_statusactive_off']		= "Не активирован";
$lang['devices_index_modaladdedit_fwversionpinned']			= "Закрепить прошивку";
$lang['devices_index_modaladdedit_fwversionpinned_def']		= "Сначала укажите модель";
$lang['devices_index_modaladdedit_fwversionpinned_help']	= "Укажите прошивку, которую необходимо закрепить за данным устройством.";
$lang['devices_index_modaladdedit_fwversionpinned_off']		= "Без закрепления";
$lang['devices_index_modaladdedit_params']					= "Параметры";
$lang['devices_index_modaladdedit_params_help']				= "Впишите параметры в это поле. Один параметр на строку. Допускается комментирование символом # в начале строки. Указанные тут параметры имеют приоритет над групповыми параметрами.";
// Главная страница: Модальное окно "Удаление устройства"
$lang['devices_index_modal_del_title']						= "Удаление устройства";
$lang['devices_index_modal_del_confirm']					= "Действительно удалить устройство?";
// Главная страница: Модальное окно "Логи устройства"
$lang['devices_index_modallogs_title']						= "Логи устройства";
$lang['devices_index_modallogs_descr']						= "Ниже представлены логи обращений выбранного устройства к GRCentral.";
$lang['devices_index_modallogs_table_date']					= "Дата и время";
$lang['devices_index_modallogs_table_type']					= "Тип запроса";
$lang['devices_index_modallogs_table_fwversion']			= "Версия прошивки";
$lang['devices_index_modallogs_table_nodata']				= "Нет данных";
// Главная страница: Сообщения
$lang['devices_index_flashdata_addsuccess']					= "Устройство успешно создано.";
$lang['devices_index_flashdata_adderror']					= "Устройство не создано.";
$lang['devices_index_flashdata_editsuccess']				= "Устройство успешно отредактировано.";
$lang['devices_index_flashdata_editerror']					= "Устройство не отредактировано.";
$lang['devices_index_flashdata_delsuccess']					= "Устройство успешно удалено.";
//
// Страница "Информация об устройстве"
//
$lang['devices_info_pagetitle']								= "Информация об устройстве";
// Страница "Информация об устройстве": Панель "Общая информация"
$lang['devices_info_panel_about_title']						= "Общая информация об устройстве";
$lang['devices_info_panel_about_model']						= "Модель устройства";
$lang['devices_info_panel_about_ipaddr']					= "IP адрес";
$lang['devices_info_panel_about_ipaddr_linktitle']			= "Перейти в WEB интерфейс";
$lang['devices_info_panel_about_macaddr']					= "MAC адрес";
$lang['devices_info_panel_about_descr']						= "Описание";
// Страница "Информация об устройстве": Панель "Действия"
$lang['devices_info_panel_actions_title']					= "Действия с устройством";
$lang['devices_info_panel_actions_reboot_na_error']			= "Возможность перезапуска недоступна.";
$lang['devices_info_panel_actions_reboot_na_descr']			= "В шаблоне настроек для данного устройства не найден пароль администратора (P2 value). Перезагрузка устройства недоступна.";
// Страница "Информация об устройстве": Панель "Состояние"
$lang['devices_info_panel_status_title']					= "Состояние устройства";
$lang['devices_info_panel_status_online_title']				= "Онлайн";
$lang['devices_info_panel_status_online_changetime']		= "По состоянию на";
$lang['devices_info_panel_status_online_on']				= "В сети";
$lang['devices_info_panel_status_online_off']				= "Не в сети";
$lang['devices_info_panel_status_active_title']				= "Активность";
$lang['devices_info_panel_status_active_on']				= "Активировано";
$lang['devices_info_panel_status_active_off']				= "Не активировано";
$lang['devices_info_panel_status_privateparams_title']		= "Параметры";
$lang['devices_info_panel_status_privateparams_yes']		= "Установлены";
$lang['devices_info_panel_status_privateparams_no']			= "Не установлены";
$lang['devices_info_panel_status_fw_title']					= "Прошивка";
$lang['devices_info_panel_status_fw_pinned']				= "Прошивка закреплена";
// Страница "Информация об устройстве": Панель "SIP аккаунты"
$lang['devices_info_panel_accounts_title']					= "SIP аккаунты";
$lang['devices_info_panel_accounts_description']			= "Кол-во аккаунтов ограничено 4 штуками, в зависимости от модели устройства, будет использоваться от 1 до 4 штук.";
// Страница "Информация об устройстве": Кнопки
$lang['devices_info_btn_accounts_edit']						= "Редактировать SIP аккаунты";
$lang['devices_info_btn_logs']								= "Просмотр логов";
$lang['devices_info_btn_cti_reboot']						= "Перезагрузка";
// Страница "Информация об устройстве": Таблица с SIP аккаунтами
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
// Страница "Информация об устройстве": Модальное окно "Редактирование SIP аккаунтов"
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
// Страница "Информация об устройстве": Модальные окна "Перезапуск устройства"
$lang['devices_info_modal_reboot_title']					= "Перезапуск устройства";
$lang['devices_info_modal_reboot_confirm']					= "Действительно перезапустить устройство?";
$lang['devices_info_modal_reboot_querysuccess']				= "Запрос на перезапуск устройства успешно отправлен.";
$lang['devices_info_modal_reboot_queryerror']				= "Произошла ошибка. Запрос на перезапуск устройства не выполнен.";
// Страница "Информация об устройстве": Сообщения
$lang['devices_info_flashdata_account_editsuccess']			= "Редактирование аккаунтов успешно выполнено.";
$lang['devices_info_flashdata_account_editerror']			= "Редактирование аккаунтов не выполнено.";
