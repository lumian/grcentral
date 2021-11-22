# GRCentral
Web UI для управления телефонами Grandstream

## Основа:
* Code language: PHP 7.3
* PHP framework: Codeigniter 3.1.11
* WebUI: Bootstrap 5.1 + jQuery 3.6.0 + Font Awesome icons 5.15.4
* UI Languages: Russian, English (начиная с v0.3).

## Примечание:
Система разрабатывается и тестируется на аппаратах Grandstream GXP1610, GXP1620 и HT802, но подойдет практически для любых телефонных аппаратов фирмы Grandstream за счет практически полного отсутствия привязки к конкретным параметрам (P-Value) конфигов тех или иных устройств. В коде присутствует привязка только к параметрам аккаунтов, индексы которых, на всех аппаратах идентичны.

## Описание текущего функционала (v0.3):
* Два варианта локализации из коробки:
   * Русский язык;
   * Английский язык.
* Базовый Web-инсталлятор для подготовки системы к первому использованию;
* Управление устройствами:
   * Создание/редактирование/удаление;
   * Управление SIP аккаунтами (до 4х штук);
   * Просмотр логов обращения к GRCentral по устройству;
   * Возможность автоматического добавления новых устройств при обращении к серверу конфигурации - включается и отключается в системных настройках.
* Управление моделями и группами моделей устройств:
   * Создание/Редактирование/Удаление
* Управление прошивками устройств:
   * Группировка прошивок по группам моделей устройств;
   * Добавление новых прошивок;
   * Удаление прошивок;
   * Возможность отключения выдачи прошивок устройствам - чекбокс в системных настройках;
   * Возможность обновлять только устройства, добавленные в БД ("дружественные") или любые - чекбокс в системных настройках.
* Управление параметрами устройств:
   * Возможность указания групповых настроек (на группу моделей);
   * Возможность указания частных настроек на конкретное устройство.
* Управление списками VoIP серверов для удобства управления SIP аккаунтами на устройствах.
* Генерация XML файла телефонной книги:
   * Возможность автоматического сбора данных (Фамилия, Имя, Телефон) из подключенных SIP аккаунтов на устройствах в базе данных - отключается в системных настройках;
   * Возможность добавления контактов вручную (Фамилия, Имя, Телефон). Имеют приоритет над автоматически добавленными;
   * Возможность отключения выдачи phonebook.xml устройствам - чекбокс в системных настройках.
* Логирование запросов от устройств:
   * Логирование запросов на сервер GRCentral от устройств;
   * Логирование запросов к API;
   * Автоочистка логов по расписанию (при добавлении записи в кронтаб).
* Функционал API:
   * Получение информации об устройствах
   * Получение контактов из телефонной книги
* Мониторинг устройств:
  * Возможность мониторить доступность устройств в сети (простой ping) - включается и отключается в системных настройках.
  
## Планы на развитие:
* [Запланированные изменения](https://github.com/lumian/grcentral/issues?q=is%3Aissue+is%3Aopen+label%3A%22Type%3A+Planned+improvement%22)
* [Идеи к функционалу, без планов на реализацию](https://github.com/lumian/grcentral/issues?q=is%3Aissue+is%3Aopen+label%3A%22Type%3A+Good+idea%22)

## Процесс установки и настройки
* [Установка GRCentral](https://github.com/lumian/grcentral/wiki/%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0-GRCentral)
* [Другие статьи в Wiki...](https://github.com/lumian/grcentral/wiki/)

## Скриншоты
* [см. на github](https://github.com/lumian/grcentral/tree/master/docs/screenshots/v.0.3)

## Авторские права
Все зарегистрированные товарные знаки и торговые марки, упомянутые в текстах и изображениях в данном репозитории, а также названия продуктов и предприятий, являются собственностью их законных владельцев.
