# GRCentral
Web UI для управления телефонами Grandstream

## Основа:
* Language: PHP
* PHP framework: Codeigniter 3.1.11
* WebUI: Bootstrap 4.5

## Описание функционала (реализованный):
* Управление прошивками телефонов: 
  * Загрузка бинарных файлов через web-интерфейс
  * Возможность активации/деактивации прошивок
  * Последовательная установка на аппараты (напр. версия 1.2 будет устанавливаться только на версию 1.1)
* Управление параметрами телефонов:
  * Разные шаблоны параметров для разных моделей телефонов
  * Возможность создания нескольких шаблонов для быстрого переключения
* Управление группами моделей телефонов для привязки к одному шаблону параметров
* Возможность использования нескольких VoIP серверов
* Управление аппаратами:
  * Автоматическое добавление аппаратов при обращении к серверу (без отдачи конфигурационных файлов)
  * Возможность указания до четырех SIP аккаунтов (каждый аккаунт может быть привязан к разным VoIP серверам)
  
## Планируемый функционал:
* Добавление авторизации в панели
* Реализация телефонной книги
* Управление рингтонами (перекодирование в нужный формат средствами GRCentral)
* Оптимизация юзабилити
* Полный перевод на английский язык
* Поддержка работы с аппаратами через CTI (Computer Telephony Integration) Grandstream
* Поддержка получения логов с аппаратов посредством ActionURL

## Процесс установки и настройки
* application\config\config.php
  ```php
  // Указать URL адрес
  $config['base_url'] = "http://www.example.com/";
  // Указать язык (на данный момент доступен только russian)
  $config['language'] = "russian";
  ```
* application\config\grcentral.php
```php
// Автоматическое добавление аппаратов в базу данных при обращении к серверу (TRUE или FALSE)
$config['provisioning']['auto_add_devices'] = TRUE;
```
* application\config\database.php
```php
// Настройки базы данных, указать hostname, username, password, database.
$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '',
	'username' => '',
	'password' => '',
	'database' => '',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8mb4_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
```
* Залить дамп из директории sql\install.sql в базу данных
