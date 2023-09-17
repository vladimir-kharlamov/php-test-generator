**Тестирование работы оператора yield.**

Рабочая среда
docker-compose up -d --build

Адрес mysql прописать в /src/MyUtils.php
```console
docker inspect tools_php-mysql | grep "IPAddress"
```

**1. Создать таблицу через консоль или phpMyadmin**
файл /db/create_table.sql

Консоль контейнера MySql 
```console
docker exec -it tools_php-mysql mysql -u root -p
```

phpMyAdmin http://localhost:8081

**2. Регистрация процедуры и запуск для заполнения таблицы тестовыми данными.**
Файл /db/commands.sql
Запись 300 тысяч строк может занять более 5 минут. Проверить статус заполнения данными налету в консоли - обычным COUNT запросом.

**3. Очередность запуска скриптов**
В контейнер: 
```console
docker exec -it tools_php-app /bin/sh 
```

**3.1 Выборка всего массива за один запрос.**
```console
php src/public/fetchAll.php
```

**3.2 Чтение результата построчно**
```console
php src/public/fetchByRow.php
```
Оптимизации использования памяти нет, т/к результат запроса по сути уже в объекте $stmt полностью.
В запросе присутствует оператор LIMIT на случай, если система не выделит достаточно памяти, и лень настраивать конфигурацию.

**3.3 Пейджинг с размером страницы в $pageSize**
```console
php src/public/byLimit.php
```

**3.4 Также пейджинг но с возможностью передачи результата запроса.** 
```console
# php src/public/byLimitReturn.php
```
Рабочий пример дублирования переменной и неэффективного использования памяти, когда необходимо передать данные в другую часть программы - . возврат значения. Относится к Legacy-коду. Не высокоуровневый дизайн с объектами, как на фреймворках, где объекты выступают в роли условных глобальных переменных.

Возможный результат
при $pageSize = 100000;

```console
page 0 - 12.17 MB
page 1 - 62.72 MB
page 2 - 113.26 MB

Fatal error: Allowed memory size of 134217728 bytes exhausted (tried to allocate 20480 bytes) in /var/www/src/public/byLimitReturn.php on line 33
```
**3.5 Генератор**
```console
php src/public/generator.php

page 0 - 12.18 MB
page 1 - 12.18 MB
page 2 - 12.18 MB
Execution time 0.95099997520447 sec.
```