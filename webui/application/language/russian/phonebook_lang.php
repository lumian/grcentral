<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.2
	File:			application\language\russian\phonebook.php
	Description:	Language file for "Phonebook" controller.
	Laguage:		Russian
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

//
// Табы
//
$lang['phonebook_tabs_title_abonents']							= "Абоненты";
//
// Страница абоненты
//
$lang['phonebook_abonents_description_text']					= "В данном разделе вы можете просмотреть справочник абонентов, сформированный на основе ваших данных. Редактирование возможно только для добавленных вручную абонентов. Внимание! Файл справочника отдается только активированным и добавленным в базу аппаратам.";
// Страница абоненты: Таблица
$lang['phonebook_abonents_table_firstname']						= "Фамилия";
$lang['phonebook_abonents_table_lastname']						= "Имя";
$lang['phonebook_abonents_table_phonework']						= "Телефон";
$lang['phonebook_abonents_table_datasource']					= "Источник данных";
$lang['phonebook_abonents_table_datasource_']					= "N/A";
$lang['phonebook_abonents_table_datasource_transform']			= "Преобразовать в";
$lang['phonebook_abonents_table_datasource_manual']				= "Внутренний: Создан вручную";
$lang['phonebook_abonents_table_datasource_accounts']			= "Внутренний: VoIP аккаунты";
$lang['phonebook_abonents_table_datasource_ldap']				= "Внешний: LDAP";
$lang['phonebook_abonents_table_status']						= "Статус";
$lang['phonebook_abonents_table_status_on']						= "Активен";
$lang['phonebook_abonents_table_status_off']					= "Не активен";
$lang['phonebook_abonents_table_status_descr_manual']			= "Нажмите, для изменения статуса";
$lang['phonebook_abonents_table_status_descr_external']			= "Переключение статуса возможно только для абонентов добавленных вручную.";
// Страница абоненты: Кнопки
$lang['phonebook_abonents_btn_new']								= "Новый абонент";
$lang['phonebook_abonents_btn_infotitle']						= "Инфо";
$lang['phonebook_abonents_btn_gotodevice']						= "Открыть аппарат с указанным аккаунтом";
$lang['phonebook_abonents_btn_action_na']						= "Нет доступных действий. Редактирование выполняется во внешней БД.";
// Страница абоненты: Модальное окно "Изменение статуса"
$lang['phonebook_abonents_modal_changestatus_title']			= "Изменение статуса абонента";
$lang['phonebook_abonents_modal_changestatus_confirm']			= "Вы действительно хотите изменить статус абонента?<br /><i>Примечание: только активные абоненты выгружаются в адресную книгу на аппараты.</i>";
// Страница абоненты: Модальное окно "Преобразование источника данных"
$lang['phonebook_abonents_modal_transformsource_title']		= "Преобразование источника данных";
$lang['phonebook_abonents_modal_transformsource_confirm']		= "Вы действительно хотите изменить источник данных на ручной?";
// Страница абоненты: Модальное окно "Удаление абонента"
$lang['phonebook_abonents_modal_delabonent_title']				= "Удаление абонента";
$lang['phonebook_abonents_modal_delabonent_confirm']			= "Вы действительно хотите удалить выбранного абонента из справочника?";
// Страница абоненты: Модальное окно "Добавление/Редактирование" абонента
$lang['phonebook_abonents_modal_addeditabonent_title_add']		= "Создание нового абонента";
$lang['phonebook_abonents_modal_addeditabonent_title_edit']		= "Редактирование абонента";
$lang['phonebook_abonents_modal_addeditabonent_firstname']		= "Фамилия";
$lang['phonebook_abonents_modal_addeditabonent_firstname_help']	= "Укажите фамилию абонента";
$lang['phonebook_abonents_modal_addeditabonent_lastname']		= "Имя";
$lang['phonebook_abonents_modal_addeditabonent_lastname_help']	= "Укажите имя абонента";
$lang['phonebook_abonents_modal_addeditabonent_phonework']		= "Номер телефона";
$lang['phonebook_abonents_modal_addeditabonent_phonework_help']	= "Введите номер телефона";
$lang['phonebook_abonents_modal_addeditabonent_status']			= "Статус";
$lang['phonebook_abonents_modal_addeditabonent_status_help']	= "Только активные абоненты выгружаются в адресную книгу на устройства";
$lang['phonebook_abonents_modal_addeditabonent_status_on']		= "Активен";
$lang['phonebook_abonents_modal_addeditabonent_status_off']		= "Не активен";
// Страница абоненты: Сообщения
$lang['phonebook_abonents_flashdata_changestatus_success']		= "Изменение статуса успешно выполнено.";
$lang['phonebook_abonents_flashdata_transformsource_success']	= "Изменение источника данных успешно выполнено.";
$lang['phonebook_abonents_flashdata_addabonent_success']		= "Новый абонент успешно добавлен в справочник.";
$lang['phonebook_abonents_flashdata_addabonent_error']			= "Ошибка. Абонент не добавлен.";
$lang['phonebook_abonents_flashdata_addabonent_error_phoneuse']	= "Номер абонента уже используется.";
$lang['phonebook_abonents_flashdata_editabonent_success']		= "Данные об абоненте успешно отредактированы.";
$lang['phonebook_abonents_flashdata_editabonent_error']			= "Ошибка. Данные об абоненте не отредактированы.";
$lang['phonebook_abonents_flashdata_delabonent_success']		= "Удаление абонента успешно выполнено.";