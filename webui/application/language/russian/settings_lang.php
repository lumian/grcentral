<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
	Русский языковой файл для контроллера "Settings"
*/

//
// Заглавная страница
//
$lang['settings_main_title']						= "Главная";
$lang['settings_main_head']							= "Настройки сервера GRCentral";
$lang['settings_main_text']							= "В данном разделе вы можете настроить модели телефонов, доступные для управления на сервере, загрузить для них файлы обновлений, настроить параметры для настройки телефонов, а так же настроить доступные VoIP серверы.";
$lang['settings_main_urls']							= "Для настройки телефонов, используйте следующие URL";
//
// Раздел "Модели телефонов"
//
// Основное
$lang['settings_models_title']						= "Модели телефонов";
$lang['settings_models_description']				= "Модели телефонов формируются в группы и используются для более точной настройки аппаратов, а так же для привязки к ним файлов обновлений, доступных на сервере. Для использования, сначала создайте группу, а затем модель.";
// Кнопки
$lang['settings_models_btn_new']					= "Добавить модель";
$lang['settings_modelsgroup_btn_new']				= "Добавить группу";
// Заголовки таблицы
$lang['settings_models_table_techname']				= "Техническое имя";
$lang['settings_models_table_friendlyname']			= "Дружественное имя";
$lang['settings_models_table_params']				= "Шаблон параметров";
// Элементы модальных окон (редактирование/создание/удаление)
$lang['settings_models_modal_title_add']			= "Создание новой модели телефона";
$lang['settings_models_modal_title_edit']			= "Редактирование модели телефона";
$lang['settings_models_modal_title_del']			= "Удаление модели телефона";
$lang['settings_models_modal_techname']				= "Техническое имя модели";
$lang['settings_models_modal_techname_help']		= "Техническое имя - это имя, по которому система распознает телефон.";
$lang['settings_models_modal_friendlyname']			= "Дружественное имя";
$lang['settings_models_modal_friendlyname_help']	= "Произвольное имя модели телефона.";
$lang['settings_models_modal_group']				= "Группа моделей";
$lang['settings_models_modal_group_help']			= "Укажите группу моделей, для их группировки";
$lang['settings_models_modal_confirm_del']			= "Действительно удалить указанную модель?";
$lang['settings_modelsgroup_modal_title_add']		= "Создание новой группы";
$lang['settings_modelsgroup_modal_title_edit']		= "Редактирование группы";
$lang['settings_modelsgroup_modal_title_del']		= "Удаление группы";
$lang['settings_modelsgroup_modal_paramgroup']		= "Шаблон настроек";
$lang['settings_modelsgroup_modal_paramgroup_no']	= "Не выбрано";
$lang['settings_modelsgroup_modal_paramgroup_help']	= "Укажите шаблон настроек, который будет применяться для указанной группы моделей.";
$lang['settings_modelsgroup_modal_groupname']		= "Имя группы";
$lang['settings_modelsgroup_modal_groupname_help']	= "Введите произвольное имя группы";
$lang['settings_modelsgroup_modal_confirm_del']		= "Действительно удалить указанную группу?";
// Сообщения
$lang['settings_models_table_noitemsingroup']		= "Нет моделей в данной группе.";
$lang['settings_models_flashdata_addsuccess']		= "Создание модели выполнено.";
$lang['settings_models_flashdata_adderror']			= "Создание модели не выполнено.";
$lang['settings_models_flashdata_editsuccess']		= "Модель успешно отредактирована.";
$lang['settings_models_flashdata_editerror']		= "Модель не отредактирована.";
$lang['settings_models_flashdata_delsuccess']		= "Модель успешно удалена.";
$lang['settings_models_flashdata_delerror']			= "Модель не удалена.";
$lang['settings_modelsgroup_flashdata_addsuccess']	= "Создание группы выполнено.";
$lang['settings_modelsgroup_flashdata_adderror']	= "Создание группы не выполнено.";
$lang['settings_modelsgroup_flashdata_editsuccess']	= "Группа успешно отредактирована.";
$lang['settings_modelsgroup_flashdata_editerror']	= "Группа не отредактирована.";
$lang['settings_modelsgroup_flashdata_delsuccess']	= "Группа успешно удалена.";
$lang['settings_modelsgroup_flashdata_delerror']	= "Группа не удалена, т.к. используется в моделях телефонов или обновлениях.";

//
// Раздел "Обновление прошивки"
//
// Основное
$lang['settings_fw_title']							= "Прошивки";
$lang['settings_fw_description']					= "Прошивки используются для автоматического обновления телефонов. В данном разделе производится управление файлами прошивок для различных моделей телефонов. Прошивки отдаются телефонам исключительно в заданной последовательности с помощью поля \"Пред. версия\" (укажите \"0\" для выбора стартовой прошивки).<br />Для использования, сначала создайте группу моделей в <a href='/settings/models/'>соответствующем разделе</a>, а затем закачайте прошивку.<br />Только активные прошивки отдаются аппаратам на загрузку.";
// Кнопки
$lang['settings_fw_btn_new']						= "Новая прошивка";
// Заголовки таблицы
$lang['settings_fw_table_version']					= "Новая версия";
$lang['settings_fw_table_previousversion']			= "Пред. версия";
$lang['settings_fw_table_startversion']				= "Стартовая";
$lang['settings_fw_table_filename']					= "Имя файла";
$lang['settings_fw_table_filename_real']			= "Реальное имя файла";
$lang['settings_fw_table_status']					= "Статус";
$lang['settings_fw_table_status_descr']				= "Нажмите для изменения текущего статуса";
// Элементы модальных окон (редактирование/создание/удаление)
$lang['settings_fw_modal_title_add']				= "Создание новой прошивки";
$lang['settings_fw_modal_title_edit']				= "Редактирование прошивки";
$lang['settings_fw_modal_title_del']				= "Удаление прошивки";
$lang['settings_fw_modal_title_changestatus']		= "Изменение статуса прошивки";
$lang['settings_fw_modal_version']					= "Версия прошивки";
$lang['settings_fw_modal_version_help']				= "Введите версию прошивки";
$lang['settings_fw_modal_previous_version']			= "Предыдущая версия прошивки";
$lang['settings_fw_modal_previous_version_help']	= "Введите версию прошивки, на которую необходимо устанавливать текущее обновление.";
$lang['settings_fw_modal_group']					= "Группа моделей";
$lang['settings_fw_modal_group_help']				= "Укажите группу моделей телефонов, для которой загружаете прошивку.";
$lang['settings_fw_modal_status']					= "Статус прошивки";
$lang['settings_fw_modal_status_descr']				= "Укажите статус прошивки (необходимо ли распространение)";
$lang['settings_fw_modal_status_on']				= "Активна";
$lang['settings_fw_modal_status_off']				= "Не активна";
$lang['settings_fw_modal_file']						= "Файл прошивки";
$lang['settings_fw_modal_file_help']				= "Укажите бинарный файл для загрузки (Расширение .bin).";
$lang['settings_fw_modal_confirm_del']				= "Действительно удалить прошивку?";
$lang['settings_fw_modal_confirm_changestatus']		= "Действительно изменить статус прошивки?";
// Сообщения
$lang['settings_fw_table_noitemsingroup']			= "Нет прошивок в данной группе.";
$lang['settings_fw_flashdata_addsuccess']			= "Прошивка загружена.";
$lang['settings_fw_flashdata_adderror']				= "Загрузка прошивки не выполнена.";
$lang['settings_fw_flashdata_delsuccess']			= "Прошивка успешно удалена";
$lang['settings_fw_flashdata_change_status_success']= "Изменение статуса успешно выполнено";
//
// Раздел Параметры
//
// Основное
$lang['settings_params_title']						= "Параметры";
$lang['settings_params_description']				= "В данном разделе производится непосредственное управление настройками телефонов (P-Value). Настройки объединяются в шаблоны. <br />Для применения шаблона, его необходимо выбрать в разделе <a href='/settings/models/'>Модели телефонов</a> у каждой группы моделей.";
// Кнопки
$lang['settings_params_btn_new']					= "Новый шаблон";
$lang['settings_params_btn_hideshow']				= "Свернуть/Развернуть";
$lang['settings_params_btn_hide']					= "Свернуть";
// Заголовки таблицы
$lang['settings_params_table_description']			= "Описание";
$lang['settings_params_table_group']				= "Шаблон";
// Элементы модальных окон (редактирование/создание/удаление)
$lang['settings_params_modal_title_add']			= "Создание нового шаблона";
$lang['settings_params_modal_title_edit']			= "Редактирование шаблона";
$lang['settings_params_modal_title_del']			= "Удаление шаблона";
$lang['settings_params_modal_groupname']			= "Имя шаблона";
$lang['settings_params_modal_groupname_help']		= "Введите произвольное имя шаблона";
$lang['settings_params_modal_description']			= "Краткое описание шаблона";
$lang['settings_params_modal_description_help']		= "Введите произвольное описание шаблона";
$lang['settings_params_modal_params']				= "Параметры";
$lang['settings_params_modal_params_help']			= "Впишите параметры в это поле. Один параметр на строку. Допускается комментирование символом # в начале строки.";
$lang['settings_params_modal_confirm_del']			= "Действительно удалить указанный шаблон?";
// Сообщения
$lang['settings_params_flashdata_addsuccess']		= "Создание шаблона выполнено.";
$lang['settings_params_flashdata_adderror']			= "Создание шаблона не выполнено.";
$lang['settings_params_flashdata_editsuccess']		= "Шаблон успешно отредактирован.";
$lang['settings_params_flashdata_editerror']		= "Шаблон не отредактирован.";
$lang['settings_params_flashdata_delsuccess']		= "Шаблон успешно удален.";
$lang['settings_params_flashdata_delerror']			= "Шаблон не удален, т.к. используется в моделях телефонов.";

//
// Раздел "Серверы"
//
$lang['settings_servers_title']						= "VoIP серверы";
$lang['settings_servers_description']				= "В данном разделе настраиваются VoIP серверы к которым будут подключаться телефоны.";
// Кнопки
$lang['settings_servers_btn_new']					= "Новый сервер";
// Заголовки таблицы
$lang['settings_servers_table_name']				= "Имя сервера";
$lang['settings_servers_table_description']			= "Описание";
$lang['settings_servers_table_server']				= "Сервер";
// Элементы модальных окон (редактирование/создание/удаление)
$lang['settings_servers_modal_title_add']			= "Создание нового сервера";
$lang['settings_servers_modal_title_edit']			= "Редактирование сервера";
$lang['settings_servers_modal_title_del']			= "Удаление сервера";
$lang['settings_servers_modal_name']				= "Имя сервера";
$lang['settings_servers_modal_name_help']			= "Введите произвольное имя сервера";
$lang['settings_servers_modal_description']			= "Описание";
$lang['settings_servers_modal_description_help']	= "Введите произвольное описание сервера";
$lang['settings_servers_modal_server']				= "Адрес сервера";
$lang['settings_servers_modal_server_help']			= "Введите hostname или IP адрес VoIP сервера";
$lang['settings_servers_modal_confirm_del']			= "Действительно удалить указанный сервер?";
// Сообщения
$lang['settings_servers_flashdata_addsuccess']		= "Создание сервера выполнено.";
$lang['settings_servers_flashdata_adderror']		= "Создание сервера не выполнено.";
$lang['settings_servers_flashdata_editsuccess']		= "Сервер успешно отредактирован.";
$lang['settings_servers_flashdata_editerror']		= "Сервер не отредактирован.";
$lang['settings_servers_flashdata_delsuccess']		= "Сервер успешно удален.";
$lang['settings_servers_flashdata_delerror']		= "Сервер не удален, т.к. указан в настройках телефонов.";