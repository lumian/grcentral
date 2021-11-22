<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
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
$lang['settings_tabs_title_syssettings']					= "Система";
//
// Главная страница
//
$lang['settings_index_head']								= "Настройки сервера GRCentral";
$lang['settings_index_text']								= "В данном разделе вы можете настроить модели устройств, доступных для управления на сервере, загрузить для них файлы прошивок (обновлений), настроить параметры для автонастройки, настроить доступные VoIP серверы, а так же отредактировать настройки системы.";
$lang['settings_index_service_state']						= "Статус работы GRCentral";
$lang['settings_index_service_table_name']					= "Сервис";
$lang['settings_index_service_table_status']				= "Статус сервиса";
$lang['settings_index_service_table_info']					= "Дополнительная информация";
$lang['settings_index_status_on']							= "Включено";
$lang['settings_index_status_off']							= "Отключено";
$lang['settings_index_status_off_descr']					= "Функция отключена в системных настройках.";
$lang['settings_index_update_title']						= "Проверка обновлений системы";
$lang['settings_index_update_current_version']				= "Текущая версия";
$lang['settings_index_update_actual_version']				= "Доступная версия";
$lang['settings_index_update_last_check']					= "Последняя проверка";
$lang['settings_index_update_need_update_yes']				= "Требуется обновление";
$lang['settings_index_update_need_update_no']				= "Система в актуальном состоянии.";
$lang['settings_index_update_not_start']					= "Проверка обновлений ранее не выполнялась. Информация недоступна.";
$lang['settings_index_update_release_date']					= "Дата резила";
$lang['settings_index_update_release_url']					= "Ссылка на релиз";
$lang['settings_index_update_btn_start_check']				= "Проверить обновления";
$lang['settings_index_update_alert_ok']						= "Проверка обновлений завершена успешно.";
$lang['settings_index_update_alert_error']					= "Ошибка проверки обновлений.<br />Не удалось получить данные.";
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
$lang['settings_models_modal_addeditgroup_titlebase']		= "Базовые параметры группы";
$lang['settings_models_modal_addeditgroup_titlesettings']	= "Настройки конфигурационных параметров";
$lang['settings_models_modal_addeditgroup_titlesettings_help']	= "Укажите наименование параметров конфига (P-Value) для указанных опций для всех аккаунтов через запятую (Например: 'P1,P2,P3,P4'). Укажите 'P0' для отключения контроля выбранного параметра у указанного аккаунта (Например: 'P0,P0,P0,P0').";
$lang['settings_models_modal_addeditgroup_groupname']		= "Имя группы";
$lang['settings_models_modal_addeditgroup_groupname_help']	= "Введите произвольное имя группы";
$lang['settings_models_modal_addeditgroup_paramgroup']		= "Шаблон настроек";
$lang['settings_models_modal_addeditgroup_paramgroup_no']	= "Не выбрано";
$lang['settings_models_modal_addeditgroup_paramgroup_help']	= "Укажите шаблон настроек, который будет применяться для указанной группы моделей.";
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
// Страница "Модели": Модальное окно "Удаление группы"
$lang['settings_models_modal_delgroup_title']				= "Удаление группы";
$lang['settings_models_modal_delgroup_confirm']				= "Действительно удалить указанную группу?";
// Страница "Модели": Модальное окно "Редактирование/Создание модели"
$lang['settings_models_modal_addedit_titleadd']				= "Создание новой модели устройства";
$lang['settings_models_modal_addedit_titleedit']			= "Редактирование модели устройства";
$lang['settings_models_modal_addedit_techname']				= "Техническое имя модели";
$lang['settings_models_modal_addedit_techname_help']		= "Техническое имя - это имя, по которому система распознает устройство.";
$lang['settings_models_modal_addedit_friendlyname']			= "Дружественное имя";
$lang['settings_models_modal_addedit_friendlyname_help']	= "Произвольное имя модели устройства.";
$lang['settings_models_modal_addedit_group']				= "Группа моделей";
$lang['settings_models_modal_addedit_group_help']			= "Укажите группу моделей, для их группировки";
// Страница "Модели": Модальное окно "Удаление модели"
$lang['settings_models_modal_del_title']					= "Удаление модели устройства";
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
$lang['settings_fw_description_text']						= "В данном разделе производится управление файлами прошивок для различных моделей устройств.<br />Для распространения на устройства выбранной прошивки, переведите её статус в 'Активна'. В каждой группе может быть только одна активная прошивка.<br />Для использования, сначала создайте группу моделей в <a href='".site_url('/settings/models/')."'>соответствующем разделе</a>, а затем закачайте прошивку.";
// Страница "Обновление прошивки": Кнопки
$lang['settings_fw_btn_new']								= "Новая прошивка";
// Страница "Обновление прошивки": Таблица
$lang['settings_fw_table_version']							= "Версия";
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
$lang['settings_fw_modal_addedit_version_help']				= "Введите версию загружаемой прошивки";
$lang['settings_fw_modal_addedit_group']					= "Группа моделей";
$lang['settings_fw_modal_addedit_group_help']				= "Укажите группу моделей устройств, для которой загружаете прошивку.";
$lang['settings_fw_modal_addedit_file']						= "Файл прошивки";
$lang['settings_fw_modal_addedit_file_help']				= "Укажите бинарный файл для загрузки (Макс. размер: %s MB).";
// Страница "Обновление прошивки": Модальное окно "Изменение статуса прошивки"
$lang['settings_fw_modal_changestatus_title']				= "Изменение статуса прошивки";
$lang['settings_fw_modal_changestatus_confirm']				= "Вы действительно хотите изменить статус прошивки?";
// Страница "Обновление прошивки": Модальное окно "Удаление прошивки"
$lang['settings_fw_modal_del_title']						= "Удаление прошивки";
$lang['settings_fw_modal_del_confirm']						= "Действительно удалить прошивку?";
// Страница "Обновление прошивки": Сообщения
$lang['settings_fw_flashdata_addsuccess']					= "Прошивка загружена.";
$lang['settings_fw_flashdata_adderror']						= "Загрузка прошивки не выполнена.";
$lang['settings_fw_flashdata_delsuccess']					= "Прошивка успешно удалена";
$lang['settings_fw_flashdata_change_status_success']		= "Изменение статуса успешно выполнено";
$lang['settings_fw_flashdata_minimum_requirements']			= "Значения, указанные в настройках вашего сервера, слишком малы для правильной работы функции загрузки прошивок.<br />Пожалуйста, прочтите <a href='https://github.com/lumian/grcentral/wiki/%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0-GRCentral' target='_blank'>документацию по установке</a> для подробной информации.";
//
// Страница "Параметры"
//
$lang['settings_params_pagetitle']							= "Параметры";
$lang['settings_params_description_text']					= "В данном разделе производится непосредственное управление настройками устройств (P-Value). Настройки объединяются в шаблоны. <br />Для применения шаблона, его необходимо выбрать в разделе <a href='".site_url('settings/models')."'>Модели устройств</a> у каждой группы моделей.";
// Страница "Параметры": Кнопки
$lang['settings_params_btn_new']							= "Новый шаблон";
$lang['settings_params_btn_hideshow']						= "Свернуть/Развернуть";
$lang['settings_params_btn_hide']							= "Свернуть";
// Страница "Параметры": Таблица
$lang['settings_params_table_name']							= "Наименование";
$lang['settings_params_table_description']					= "Описание";
// Страница "Параметры": Модальное окно "Редактирование/создание шаблона"
$lang['settings_params_modal_eddedit_title_add']			= "Создание нового шаблона";
$lang['settings_params_modal_eddedit_title_edit']			= "Редактирование шаблона";
$lang['settings_params_modal_eddedit_groupname']			= "Имя шаблона";
$lang['settings_params_modal_eddedit_groupname_help']		= "Введите произвольное имя шаблона";
$lang['settings_params_modal_eddedit_description']			= "Краткое описание шаблона";
$lang['settings_params_modal_eddedit_description_help']		= "Введите произвольное описание шаблона";
$lang['settings_params_modal_eddedit_params']				= "Параметры";
$lang['settings_params_modal_eddedit_params_help']			= "Впишите параметры в это поле. Один параметр на строку. Допускается комментирование символом # в начале строки.";
// Страница "Параметры": Модальное окно "Удаление шаблона"
$lang['settings_params_modal_del_title']					= "Удаление шаблона";
$lang['settings_params_modal_del_confirm']					= "Действительно удалить указанный шаблон?";
// Страница "Параметры": Сообщения
$lang['settings_params_flashdata_addsuccess']				= "Создание шаблона выполнено.";
$lang['settings_params_flashdata_adderror']					= "Создание шаблона не выполнено.";
$lang['settings_params_flashdata_editsuccess']				= "Шаблон успешно отредактирован.";
$lang['settings_params_flashdata_editerror']				= "Шаблон не отредактирован.";
$lang['settings_params_flashdata_delsuccess']				= "Шаблон успешно удален.";
$lang['settings_params_flashdata_delerror']					= "Шаблон не удален, т.к. используется в моделях устройств.";
//
// Страница "Серверы"
//
$lang['settings_servers_pagetitle']							= "VoIP серверы";
$lang['settings_servers_description_text']					= "В данном разделе настраиваются VoIP серверы к которым будут подключаться устройства.";
// Страница "Серверы": Кнопки
$lang['settings_servers_btn_new']							= "Новый сервер";
// Страница "Серверы": Таблица
$lang['settings_servers_table_name']						= "Имя сервера";
$lang['settings_servers_table_description']					= "Описание";
$lang['settings_servers_table_server']						= "Сервер";
$lang['settings_servers_table_voicemailnumber']				= "Голосовая почта";
// Страница "Серверы": Модальное окно "Редактирование/создание сервера"
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
// Страница "Серверы": Модальное окно "Удаление сервера"
$lang['settings_servers_modal_del_title']					= "Удаление сервера";
$lang['settings_servers_modal_del_confirm']					= "Действительно удалить указанный сервер?";
// Страница "Серверы": Сообщения
$lang['settings_servers_flashdata_addsuccess']				= "Создание сервера выполнено.";
$lang['settings_servers_flashdata_adderror']				= "Создание сервера не выполнено.";
$lang['settings_servers_flashdata_editsuccess']				= "Сервер успешно отредактирован.";
$lang['settings_servers_flashdata_editerror']				= "Сервер не отредактирован.";
$lang['settings_servers_flashdata_delsuccess']				= "Сервер успешно удален.";
$lang['settings_servers_flashdata_delerror']				= "Сервер не удален, т.к. указан в настройках устройств.";
//
// Страница "Системные настройки"
//
$lang['settings_syssettings_pagetitle']						= "Системные настройки";
$lang['settings_syssettings_description_text']				= "В данном разделе вы можете настроить некоторые важные опции системы GRCentral. <br />Не забудьте сохранить настройки после внесения изменений.";
// Страница "Системные настройки": Описание настроек
$lang['settings_syssettings_table_title_setting']			= "Настройка / Описание";
$lang['settings_syssettings_table_title_status']			= "Статус";
$lang['settings_syssettings_title_general']					= "Общие настройки";
$lang['settings_syssettings_access_device_by_ip_name']		= "Использовать IP адрес для авторизации";
$lang['settings_syssettings_access_device_by_ip_help']		= "Дополнительно (кроме MAC адреса) использовать IP адрес для авторизации устройств при обращении к серверу. Настройка не имеет смысла при активации функции автообновления IP адресов.";
$lang['settings_syssettings_auto_update_ip_addr_name']		= "Автообновление IP адреса устройства";
$lang['settings_syssettings_auto_update_ip_addr_help']		= "Автоматически обновлять IP адрес в базе данных при обращении устройства к серверу с нового адреса. Может быть полезно для динамических адресов на устройствах.";
$lang['settings_syssettings_hide_help_header_msg_name']		= "Отключить помощь по разделам";
$lang['settings_syssettings_hide_help_header_msg_help']		= "При включении данной настройки, сообщения с описанием раздела не будут отображаться в интерфейсе системы.";
$lang['settings_syssettings_monitoring_enable_name']		= "Включить мониторинг устройств";
$lang['settings_syssettings_monitoring_enable_help']		= "При включении данной функции, в интерфейсе отобразятся статусы мониторинга устройств, а так же будет возможно выполнение крон-сценария мониторинга.";
$lang['settings_syssettings_title_cfg_server']				= "Сервер конфигураций";
$lang['settings_syssettings_cfg_enable_get_name']			= "Включить возможность получения CFG файлов";
$lang['settings_syssettings_cfg_enable_get_help']			= "В случае отключения, устройствам всегда будет отдаваться ошибка 404 на запрос нового CFG файла.";
$lang['settings_syssettings_auto_add_devices_name']			= "Автоматическое добавление устройств";
$lang['settings_syssettings_auto_add_devices_help']			= "Автоматическое добавление устройств в базу данных при обращении к серверу (CFG запрос).";
$lang['settings_syssettings_title_fw_server']				= "Сервер обновления прошивок";
$lang['settings_syssettings_fw_enable_update_name']			= "Включить возможность обновления прошивок";
$lang['settings_syssettings_fw_enable_update_help']			= "В случае отключения, устройствам всегда будет отдаваться ошибка 404 на запрос о получении прошивки.";
$lang['settings_syssettings_fw_update_only_friend_name']	= "Обновление только дружественных устройств";
$lang['settings_syssettings_fw_update_only_friend_help']	= "Если включено, то обновлять устройства только если они присутствуют в БД и активированы.";
$lang['settings_syssettings_title_pb_server']				= "Сервер справочника";
$lang['settings_syssettings_pb_generate_enable_name']		= "Включить функцию генерации XML файла справочника";
$lang['settings_syssettings_pb_generate_enable_help']		= "При включении данной функции, будет доступна возможность генерации и получения Phonebook XML файлов устройствами. При отключении данной функции, раздел справочника отключен не будет, а вместо phonebook xml файла, будет отдаваться ошибка 404.";
$lang['settings_syssettings_pb_collect_accounts_name']		= "Собирать информацию об аккаунтах в справочник";
$lang['settings_syssettings_pb_collect_accounts_help']		= "Во время применения настроек будет собрана информация об аккаунтах (Наименование и UserID) и интегрирована с телефонным справочником.";
$lang['settings_syssettings_title_api']						= "API";
$lang['settings_syssettings_api_enable_name']				= "Включить API";
$lang['settings_syssettings_api_enable_help']				= "Включение возможности использования API.";
// Страница "Системные настройки": Сообщения
$lang['settings_syssettings_flashdata_editsuccess']			= "Настройки успешно обновлены";
$lang['settings_syssettings_flashdata_editerror']			= "Произошла ошибка. Настройки не обновлены.";
$lang['settings_syssettings_flashdata_resetsuccess']		= "Все системные настройки успешно сброшены в режим \"По-умолчанию\".";
$lang['settings_syssettings_flashdata_reseterror']			= "Произошла ошибка. Настройки не сброшены.";
// Страница "Системные настройки": Кнопки
$lang['settings_syssettings_btn_reset_settings']			= "Сбросить настройки";
// Страница "Системные настройки": Модальное окно "Сброс настроек"
$lang['settings_syssettings_modal_reset_title']				= "Сброс настроек в режим \"По-умолчанию\"";
$lang['settings_syssettings_modal_reset_confirm']			= "Подтвердите сброс настроек. Все системные настройки будут сброшены в режим \"По-умолчанию\".";