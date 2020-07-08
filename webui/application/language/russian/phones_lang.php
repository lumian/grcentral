<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//
// Список телефонов
//

$lang['phones_title']						= "Телефоны";
$lang['phones_description']					= "В данном разделе осуществляется управление телефонными аппаратами.<br />Управление SIP аккаунтами производится по кнопке \"Инфо\".<br />Примечание: Отключенные аппараты не получают настроек от сервера.";

// Кнопки
$lang['phones_btn_new']						= "Новый телефон";
$lang['phones_btn_activate']				= "Активировать";
$lang['phones_btn_info']					= "Инфо";

// Таблица
$lang['phones_table_descr']					= "Описание";
$lang['phones_table_mac_addr']				= "MAC адрес";
$lang['phones_table_ip_addr']				= "IP адрес";
$lang['phones_table_ip_addr_linktitle']		= "Перейти в WEB интерфейс аппарата";
$lang['phones_table_model']					= "Модель";
$lang['phones_table_model_na']				= "Не определена";
$lang['phones_table_accounts']				= "Аккаунты";
$lang['phones_table_accounts_na']			= "N/A";
$lang['phones_table_fwversion']				= "Версия FW";
$lang['phones_table_fwversion_na']			= "N/A";
$lang['phones_table_fwversionpinned_help']	= "Прошивка закреплена";

// Модальные окна
$lang['phones_modal_title_add']				= "Создание нового телефона";
$lang['phones_modal_title_edit']			= "Редактирование телефона";
$lang['phones_modal_title_del']				= "Удаление телефона";
$lang['phones_modal_title_activate']		= "Активация телефона";
$lang['phones_modal_mac_addr']				= "MAC адрес";
$lang['phones_modal_mac_addr_help']			= "Укажите MAC адрес телефона.";
$lang['phones_modal_ip_addr']				= "IP адрес";
$lang['phones_modal_ip_addr_help']			= "Укажите IP адрес телефона";
$lang['phones_modal_model']					= "Модель аппарата";
$lang['phones_modal_model_help']			= "Выберете модель телефона из списка.";
$lang['phones_modal_model_na']				= "Не определена";
$lang['phones_modal_descr']					= "Описание";
$lang['phones_modal_descr_help']			= "Произвольное описание.";
$lang['phones_modal_status_active']			= "Активность";
$lang['phones_modal_status_active_help']	= "Включить или выключить работу с указанным аппаратом.";
$lang['phones_modal_status_active_on']		= "Активирован";
$lang['phones_modal_status_active_off']		= "Не активирован";
$lang['phones_modal_fwversionpinned']		= "Закрепить прошивку";
$lang['phones_modal_fwversionpinned_help']	= "Укажите прошивку, которую необходимо закрепить за данным аппаратом. Закрепленная прошивка должна быть равна или выше уже установленной.";
$lang['phones_modal_fwversionpinned_off']	= "Без закрепления - на общих условиях";
$lang['phones_modal_confirm_del']			= "Вы действительно хотите удалить телефон?";

// Сообщения
$lang['phones_flashdata_addsuccess']		= "Телефон успешно создан.";
$lang['phones_flashdata_adderror']			= "Телефон не создан.";
$lang['phones_flashdata_editsuccess']		= "Телефон успешно отредактирован.";
$lang['phones_flashdata_editerror']			= "Телефон не отредактирован.";
$lang['phones_flashdata_delsuccess']		= "Телефон успешно удален.";

//
// Страница информации о телефоне
//

$lang['phones_info_title']					= "Информация об аппарате";
$lang['phones_info_model']					= "Модель аппарата";
$lang['phones_info_ipaddr']					= "IP адрес";
$lang['phones_info_macaddr']				= "MAC адрес";
$lang['phones_info_statusonline']			= "Онлайн";
$lang['phones_info_statusonline_on']		= "В сети";
$lang['phones_info_statusonline_off']		= "Не в сети";
$lang['phones_info_statusactive']			= "Активность";
$lang['phones_info_statusactive_on']		= "Активирован";
$lang['phones_info_statusactive_off']		= "Не активирован";
$lang['phones_info_descr']					= "Описание";
$lang['phones_accounts_title']				= "Аккаунты";
$lang['phones_accounts_description']		= "Кол-во аккаунтов ограничено 4 штуками, в зависимости от модели аппарата будет использоваться от 1 до 4 штук.";
$lang['phones_actions_title']				= "Действия";

// Кнопки
$lang['phones_accounts_btn_edit']			= "Редактировать аккаунты";
$lang['phones_actions_btn_reboot']			= "Перезагрузка";

// Таблица (аккаунты)
$lang['phones_accounts_table_name']			= "Наименование";
$lang['phones_accounts_table_position']		= "#";
$lang['phones_accounts_table_voipsrv1']		= "Сервер #1";
$lang['phones_accounts_table_voipsrv2']		= "Сервер #2";
$lang['phones_accounts_table_voipsrv_na']	= "N/A";
$lang['phones_accounts_table_userid']		= "UserID";
$lang['phones_accounts_table_authid']		= "AuthID";
$lang['phones_accounts_table_password']		= "Пароль";

// Модальные окна
$lang['phones_accounts_modal_title_edit']	= "Редактирование аккаунтов";
$lang['phones_accounts_modal_account']		= "Аккаунт";
$lang['phones_accounts_modal_mustbefilled']	= "обязательно";
$lang['phones_accounts_modal_name']			= "Произвольное наименование";
$lang['phones_accounts_modal_active']		= "Укажите статус аккаунта";
$lang['phones_accounts_modal_active_on']	= "Включен";
$lang['phones_accounts_modal_active_off']	= "Выключен";
$lang['phones_accounts_modal_voipsrv1']		= "Укажите основной сервер";
$lang['phones_accounts_modal_voipsrv2']		= "Укажите дополнительный сервер";
$lang['phones_accounts_modal_userid']		= "UserID";
$lang['phones_accounts_modal_authid']		= "AuthID";
$lang['phones_accounts_modal_password']		= "Пароль";

// Сообщения
$lang['phones_flashdata_account_editsuccess']	= "Редактирование аккаунтов успешно выполнено.";
$lang['phones_flashdata_account_editerror']		= "Редактирование аккаунтов не выполнено.";
