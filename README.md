# GRCentral
Система управления VoIP устройствами Grandstream в удобном Web интерфейсе.

## Основа:
* Code language: PHP 7.4
* PHP framework: Codeigniter 3.1.13
* WebUI: Bootstrap 5.1.3 + jQuery 3.6.0 + Font Awesome icons 5.15.4
* UI Languages: Russian, English.

## Примечание:
Система разрабатывается и тестируется на аппаратах Grandstream GXP1610, GXP1620 и HT802, но подойдет практически для любых телефонных аппаратов фирмы Grandstream за счет практически полного отсутствия привязки к конкретным параметрам (P-Value) конфигов тех или иных устройств. В коде присутствует привязка только к параметрам аккаунтов, индексы которых, на всех аппаратах идентичны.

## Описание текущего функционала (v0.3):
* Общее:
   * Наличие простого web-инсталлятора.
   * Возможность работы с двумя языками: Русский и Английский.
   * Все разделы и настройки подробно описаны в документации на [github wiki продукта](https://github.com/lumian/grcentral/wiki).
* Управление устройствами:
   * Создание/редактирование/удаление.
   * Возможность автоматического создания новых устройств при обращении к серверу конфигурации.
   * Управление SIP аккаунтами (до 4х штук).
   * Просмотр логов обращения устройства к GRCentral.
   * Группировка устройств по модели и группам моделей для упрощения настройки.
   * Управление параметрами устройств:
      * Возможность редактирования и привязки различных шаблонов параметров к различным группам моделей устройств.
      * Возможность указания частных параметров для каждого конкретного устройства
   * Возможность создания общего справочника VoIP серверов для их дальнейшего использования при настройке SIP аккаунтов.
* Распространение прошивок:
   * Добавление/Удаление/Активация/Деактивация прошивок.
   * Привязка прошивок к группам моделей устройств.
   * Возможность включения или отключения выдачи прошивок устройствам.
   * Возможность обновлять как добавленные в базу данных устройства, так и любые другие без добавления в БД.
* Генерация XML файла телефонного справочника:
   * Система позволяет управлять телефонным справочником как вручную (создание контакта с заполнением полей), так и автоматически на основе подключенных к устройствам SIP аккаунтов.
* API функционал:
   * Получение информации об устройствах
   * Получение контактов из телефонной книги
* Мониторинг устройств:
   * Система может производить периодическую проверку доступности устройств посредством системной команды ping и отображать данные по доступности как в общем списке устройств, так и на странице устройства.
* Логирование действий:
   * Система позволяет вести логи обращений всех устройств, а так же логирование API запросов.
   * Логи можно посмотреть как в общем журнале, так и отфильтрованные по выбранному устройству на странице с информацией об устройстве.

## Планы на развитие:
* [Запланированные изменения](https://github.com/lumian/grcentral/issues?q=is%3Aissue+is%3Aopen+label%3A%22Type%3A+Planned+improvement%22)
* [Идеи к функционалу, без планов на реализацию](https://github.com/lumian/grcentral/issues?q=is%3Aissue+is%3Aopen+label%3A%22Type%3A+Good+idea%22)

## Процесс установки и настройки
* [Установка GRCentral](https://github.com/lumian/grcentral/wiki/%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0-GRCentral)
* [Другие статьи в Wiki...](https://github.com/lumian/grcentral/wiki/)

## Полезные ссылки
* Скриншоты [смотри на github](https://github.com/lumian/grcentral/tree/master/docs/screenshots/v.0.3)
* Демоверсия интерфейса доступна на сайте [grc-demo.hionline.ru](http://grc-demo.hionline.ru/)
* Любые обсуждения можно вести на github в [разделе Discussions](https://github.com/lumian/grcentral/discussions)

## Авторские права
Все зарегистрированные товарные знаки и торговые марки, упомянутые в текстах и изображениях в данном репозитории, а также названия продуктов и предприятий, являются собственностью их законных владельцев.
