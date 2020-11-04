<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.2
	File:			application\language\russian\settings_lang.php
	Description:	Language file for "Settings" controller.
	Laguage:		Russian
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

// Табы
$lang['settings_tabs_title_main']							= "Главная";
$lang['settings_tabs_title_models']							= "Модели";
$lang['settings_tabs_title_fw']								= "Прошивки";
$lang['settings_tabs_title_params']							= "Параметры";
$lang['settings_tabs_title_servers']						= "VoIP серверы";
$lang['settings_tabs_title_syssettings']							= "Система";
//
// Главная страница
//
$lang['settings_index_head']								= "Настройки сервера GRCentral";
$lang['settings_index_text']								= "В данном разделе вы можете настроить модели устройств, доступных для управления на сервере, загрузить для них файлы прошивок (обновлений), настроить параметры для автонастройки, а так же настроить доступные VoIP серверы.";
$lang['settings_index_urls']								= "Для настройки, используйте следующие URL в интерфейсе устройства";
//
// Страница "Модели"
//
$lang['settings_models_pagetitle']							= "Модели устройств";
$lang['settings_models_description_text']					= "Модели устройств формируются в группы и используются для более точной настройки, а так же для привязки к ним файлов обновлений, доступных на сервере. Для использования, сначала создайте группу, а затем модель.";
// Страница "Модели": Кнопки
$lang['settings_models_btn_new']							= "Добавить модель";
$lang['settings_models_btn_newgroup']						= "Добавить группу";
// Страница "Модели": Таблица
$lang['settings_models_table_techname']						= "Техническое имя";
$lang['settings_models_table_friendlyname']					= "Дружественное имя";
$lang['settings_models_table_params']						= "Шаблон параметров";
$lang['settings_models_table_noitemsingroup']				= "Нет моделей в данной группе.";
// Страница "Модели": Модальное окно "Редактирование/Создание группы"
$lang['settings_models_modal_addeditgroup_titleadd']		= "Создание новой группы";
$lang['settings_models_modal_addeditgroup_titleedit']		= "Редактирование группы";
$lang['settings_models_modal_addeditgroup_groupname']		= "Имя группы";
$lang['settings_models_modal_addeditgroup_groupname_help']	= "Введите произвольное имя группы";
$lang['settings_models_modal_addeditgroup_paramgroup']		= "Шаблон настроек";
$lang['settings_models_modal_addeditgroup_paramgroup_no']	= "Не выбрано";
$lang['settings_models_modal_addeditgroup_paramgroup_help']	= "Укажите шаблон настроек, который будет применяться для указанной группы моделей.";
// Страница "Модели": Модальное окно "Удаление группы"
$lang['settings_models_modal_delgroup_title']				= "Удаление группы";
$lang['settings_models_modal_delgroup_confirm']				= "Действительно удалить указанную группу?";
// Страница "Модели": Модальное окно "Редактирование/Создание модели"
$lang['settings_models_modal_addedit_titleadd']				= "Создание новой модели телефона";
$lang['settings_models_modal_addedit_titleedit']			= "Редактирование модели телефона";
$lang['settings_models_modal_addedit_techname']				= "Техническое имя модели";
$lang['settings_models_modal_addedit_techname_help']		= "Техническое имя - это имя, по которому система распознает телефон.";
$lang['settings_models_modal_addedit_friendlyname']			= "Дружественное имя";
$lang['settings_models_modal_addedit_friendlyname_help']	= "Произвольное имя модели телефона.";
$lang['settings_models_modal_addedit_group']				= "Группа моделей";
$lang['settings_models_modal_addedit_group_help']			= "Укажите группу моделей, для их группировки";
// Страница "Модели": Модальное окно "Удаление модели"
$lang['settings_models_modal_del_title']					= "Удаление модели телефона";
$lang['settings_models_modal_del_confirm']					= "Действительно удалить указанную модель?";
// Страница "Модели": Сообщения
$lang['settings_models_flashdata_addsuccess']				= "Создание модели выполнено.";
$lang['settings_models_flashdata_adderror']					= "Создание модели не выполнено.";
$lang['settings_models_flashdata_editsuccess']				= "Модель успешно отредактирована.";
$lang['settings_models_flashdata_editerror']				= "Модель не отредактирована.";
$lang['settings_models_flashdata_delsuccess']				= "Модель успешно удалена.";
$lang['settings_models_flashdata_delerror']					= "Модель не удалена.";
$lang['settings_models_flashdata_addgroupsuccess']			= "Создание группы выполнено.";
$lang['settings_models_flashdata_addgrouperror']			= "Создание группы не выполнено.";
$lang['settings_models_flashdata_editgroupsuccess']			= "Группа успешно отредактирована.";
$lang['settings_models_flashdata_editgrouperror']			= "Группа не отредактирована.";
$lang['settings_models_flashdata_delgroupsuccess']			= "Группа успешно удалена.";
$lang['settings_models_flashdata_delgrouperror']			= "Группа не удалена, т.к. используется в моделях устройств или обновлениях.";
//
// Страница "Обновление прошивки"
//
$lang['settings_fw_pagetitle']								= "Прошивки";
$lang['settings_fw_description_text']						= "В данном разделе производится управление файлами прошивок для различных моделей устройств. <br />Прошивки отдаются устройствам исключительно в заданной последовательности с помощью поля \"Пред. версия\" (укажите \"0\" для выбора стартовой прошивки).<br />Для использования, сначала создайте группу моделей в <a href='".site_url('/settings/models/')."'>соответствующем разделе</a>, а затем закачайте прошивку. Только активные прошивки отдаются аппаратам на загрузку.";
// Страница "Обновление прошивки": Кнопки
$lang['settings_fw_btn_new']								= "Новая прошивка";
// Страница "Обновление прошивки": Таблица
$lang['settings_fw_table_version']							= "Новая версия";
$lang['settings_fw_table_previousversion']					= "Пред. версия";
$lang['settings_fw_table_startversion']						= "Стартовая";
$lang['settings_fw_table_filename']							= "Имя файла";
$lang['settings_fw_table_filename_real']					= "Реальное имя файла";
$lang['settings_fw_table_status']							= "Статус";
$lang['settings_fw_table_status_on']						= "Активна";
$lang['settings_fw_table_status_off']						= "Не активна";
$lang['settings_fw_table_status_descr']						= "Нажмите для изменения текущего статуса";
$lang['settings_fw_table_noitemsingroup']					= "Нет прошивок в данной группе.";
// Страница "Обновление прошивки": Модальное окно "Редактирование/Создание прошивки"
$lang['settings_fw_modal_addedit_title_add']				= "Создание новой прошивки";
$lang['settings_fw_modal_addedit_version']					= "Версия прошивки";
$lang['settings_fw_modal_addedit_version_help']				= "Введите версию прошивки";
$lang['settings_fw_modal_addedit_previous_version']			= "Предыдущая версия прошивки";
$lang['settings_fw_modal_addedit_previous_version_help']	= "Введите версию прошивки, на которую необходимо устанавливать текущее обновление.";
$lang['settings_fw_modal_addedit_group']					= "Группа моделей";
$lang['settings_fw_modal_addedit_group_help']				= "Укажите группу моделей устройств, для которой загружаете прошивку.";
$lang['settings_fw_modal_addedit_status']					= "Статус прошивки";
$lang['settings_fw_modal_addedit_status_help']				= "Укажите статус прошивки (необходимо ли распространение)";
$lang['settings_fw_modal_addedit_status_on']				= "Активна";
$lang['settings_fw_modal_addedit_status_off']				= "Не активна";
$lang['settings_fw_modal_addedit_file']						= "Файл прошивки";
$lang['settings_fw_modal_addedit_file_help']				= "Укажите бинарный файл для загрузки (Расширение .bin).";
// Страница "Обновление прошивки": Модальное окно "Изменение статуса прошивки"
$lang['settings_fw_modal_changestatus_title']				= "Изменение статуса прошивки";
$lang['settings_fw_modal_changestatus_confirm']				= "Действительно изменить статус прошивки?";
// Страница "Обновление прошивки": Модальное окно "Удаление прошивки"
$lang['settings_fw_modal_del_title']						= "Удаление прошивки";
$lang['settings_fw_modal_del_confirm']						= "Действительно удалить прошивку?";
// Страница "Обновление прошивки": Сообщения
$lang['settings_fw_flashdata_addsuccess']					= "Прошивка загружена.";
$lang['settings_fw_flashdata_adderror']						= "Загрузка прошивки не выполнена.";
$lang['settings_fw_flashdata_delsuccess']					= "Прошивка успешно удалена";
$lang['settings_fw_flashdata_change_status_success']		= "Изменение статуса успешно выполнено";
//
// Раздел "Параметры"
//
$lang['settings_params_pagetitle']							= "Параметры";
$lang['settings_params_description_text']					= "В данном разделе производится непосредственное управление настройками устройств (P-Value). Настройки объединяются в шаблоны. <br />Для применения шаблона, его необходимо выбрать в разделе <a href='".site_url('settings/models')."'>Модели телефонов</a> у каждой группы моделей.";
// Раздел "Параметры": Кнопки
$lang['settings_params_btn_new']							= "Новый шаблон";
$lang['settings_params_btn_hideshow']						= "Свернуть/Развернуть";
$lang['settings_params_btn_hide']							= "Свернуть";
// Раздел "Параметры": Таблица
$lang['settings_params_table_name']							= "Наименование";
$lang['settings_params_table_description']					= "Описание";

// Раздел "Параметры": Модальное окно "Редактирование/создание шаблона"
$lang['settings_params_modal_eddedit_title_add']			= "Создание нового шаблона";
$lang['settings_params_modal_eddedit_title_edit']			= "Редактирование шаблона";
$lang['settings_params_modal_eddedit_groupname']			= "Имя шаблона";
$lang['settings_params_modal_eddedit_groupname_help']		= "Введите произвольное имя шаблона";
$lang['settings_params_modal_eddedit_description']			= "Краткое описание шаблона";
$lang['settings_params_modal_eddedit_description_help']		= "Введите произвольное описание шаблона";
$lang['settings_params_modal_eddedit_params']				= "Параметры";
$lang['settings_params_modal_eddedit_params_help']			= "Впишите параметры в это поле. Один параметр на строку. Допускается комментирование символом # в начале строки.";
// Раздел "Параметры": Модальное окно "Удаление шаблона"
$lang['settings_params_modal_del_title']					= "Удаление шаблона";
$lang['settings_params_modal_del_confirm']					= "Действительно удалить указанный шаблон?";
// Раздел "Параметры": Сообщения
$lang['settings_params_flashdata_addsuccess']				= "Создание шаблона выполнено.";
$lang['settings_params_flashdata_adderror']					= "Создание шаблона не выполнено.";
$lang['settings_params_flashdata_editsuccess']				= "Шаблон успешно отредактирован.";
$lang['settings_params_flashdata_editerror']				= "Шаблон не отредактирован.";
$lang['settings_params_flashdata_delsuccess']				= "Шаблон успешно удален.";
$lang['settings_params_flashdata_delerror']					= "Шаблон не удален, т.к. используется в моделях устройств.";
//
// Раздел "Серверы"
//
$lang['settings_servers_pagetitle']							= "VoIP серверы";
$lang['settings_servers_description_text']					= "В данном разделе настраиваются VoIP серверы к которым будут подключаться устройства.";
// Раздел "Серверы": Кнопки
$lang['settings_servers_btn_new']							= "Новый сервер";
// Раздел "Серверы": Таблица
$lang['settings_servers_table_name']						= "Имя сервера";
$lang['settings_servers_table_description']					= "Описание";
$lang['settings_servers_table_server']						= "Сервер";
$lang['settings_servers_table_voicemailnumber']				= "Голосовая почта";
// Раздел "Серверы": Модальное окно "Редактирование/создание сервера"
$lang['settings_servers_modal_addedit_title_add']			= "Создание нового сервера";
$lang['settings_servers_modal_addedit_title_edit']			= "Редактирование сервера";
$lang['settings_servers_modal_addedit_name']				= "Имя сервера";
$lang['settings_servers_modal_addedit_name_help']			= "Введите произвольное имя сервера";
$lang['settings_servers_modal_addedit_description']			= "Описание";
$lang['settings_servers_modal_addedit_description_help']	= "Введите произвольное описание сервера";
$lang['settings_servers_modal_addedit_server']				= "Адрес сервера";
$lang['settings_servers_modal_addedit_server_help']			= "Введите hostname или IP адрес VoIP сервера";
$lang['settings_servers_modal_addedit_voicemailnumber']		= "Номер голосовой почты";
$lang['settings_servers_modal_addedit_voicemailnumber_help']	= "Введите номер голосовой почты, актуальный для данного VoIP сервера.";
// Раздел "Серверы": Модальное окно "Удаление сервера"
$lang['settings_servers_modal_del_title']					= "Удаление сервера";
$lang['settings_servers_modal_del_confirm']					= "Действительно удалить указанный сервер?";
// Раздел "Серверы": Сообщения
$lang['settings_servers_flashdata_addsuccess']				= "Создание сервера выполнено.";
$lang['settings_servers_flashdata_adderror']				= "Создание сервера не выполнено.";
$lang['settings_servers_flashdata_editsuccess']				= "Сервер успешно отредактирован.";
$lang['settings_servers_flashdata_editerror']				= "Сервер не отредактирован.";
$lang['settings_servers_flashdata_delsuccess']				= "Сервер успешно удален.";
$lang['settings_servers_flashdata_delerror']				= "Сервер не удален, т.к. указан в настройках устройств.";

//
// Раздел Системные настройки
//
$lang['settings_syssettings_pagetitle']						= "Системные настройки";
$lang['settings_syssettings_description_text']				= "Описание для системных настроек";
// Раздел "Системные настройки": Описание настроек
$lang['settings_syssettings_title_provisioning']			= "Настройки распространения";
$lang['settings_syssettings_auto_add_devices_name']			= "Автоматическое добавление устройств";
$lang['settings_syssettings_auto_add_devices_help']			= "Автоматическое добавление девайсов в базу данных при обращении к серверу (CFG запрос)";
$lang['settings_syssettings_fw_update_only_friend_name']	= "Обновление только дружественных устройств";
$lang['settings_syssettings_fw_update_only_friend_help']	= "Обновлять аппараты только если они присутствуют в БД и активированы";
// Раздел "Системные настройки": Сообщения
$lang['settings_syssettings_flashdata_editsuccess']			= "Настройки успешно обновлены";
$lang['settings_syssettings_flashdata_editerror']			= "Произошла ошибка. Настройки не обновлены.";
