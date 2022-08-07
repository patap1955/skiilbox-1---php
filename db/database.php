<?php

namespace database;

use mysqli;

include $_SERVER['DOCUMENT_ROOT'] . '/db/config.php';

/**
 * Функия создает соединение с базой данных
 * @return mysqli - соединение с базой данных
 */
function connect(): mysqli
{
    static $connect = null;
    if (null === $connect) {
        $connect = mysqli_connect(HOST, USER, PASSWORD, DB_NAME);
        if (!$connect) {
            echo 'Код ошибки errno: ' . mysqli_connect_errno();
            exit;
        }
    }
    return $connect;
}

/**
 * Закрывает соединение с базой данных
 * @param $connect - соединение, которое нужно закрыть
 */
function closeConnect(mysqli $connect): void
{
    mysqli_close($connect);
}

/**
 * Получение данных из ответа от базы данных
 * @param $result - результат выполнения запроса
 * @return array - массив с данными
 */
function getResult($result): array
{
    if ($result && mysqli_num_rows($result) === 1) {
        return mysqli_fetch_assoc($result);
    } elseif ($result && mysqli_num_rows($result) > 1) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return [];
}

/**
 * Возвращает массив с пунктами меню и ссылками
 * @return array - массив с меню
 */
function getMainMenu(): array
{
    $result = mysqli_query(
        connect(),
        "SELECT name, url FROM menu"
    );

    return getResult($result);
}

/**
 * Возвращает массив с пунктами меню для админа
 * @return array - массив с меню
 */
function getAdminMenu(): array
{
    $result = mysqli_query(
        connect(),
        "SELECT name, url FROM admin_menu"
    );

    return getResult($result);
}

/**
 * Возвращает список категорий
 * @return array - список категорий
 */
function getCategory(): array
{
    return getResult(mysqli_query(connect(), "SELECT id, name, url FROM categories"));
}

/**
 * @return bool - это распродажа?
 */
function isSale(): bool
{
    return isset($_GET['sale']) && $_GET['sale'] === 'on';
}

/**
 * @return bool - это новинка?
 */
function isNew(): bool
{
    return isset($_GET['new']) && $_GET['new'] === 'on';
}

/**
 * Возварщает минимальную цену
 * @param $price - массив с ценами или массив GET
 * @return int - минимальная цена
 */
function getMinPrice($price): int
{
    return $_GET['min'] ?? $price['min'];
}

/**
 * Возварщает максимальную цену
 * @param $price - массив с ценами или массив GET
 * @return int - максимальная цена
 */
function getMaxPrice($price): int
{
    return $_GET['max'] ?? $price['max'];
}

/**
 * Возвращает количество товаров в категории
 * @param string $uri
 * @param array $price
 * @return int - количество товаров в категории
 */
function getCount(string $uri, array $price): int
{
    $uri = explode('?', mysqli_real_escape_string(connect(), $uri));
    $sale = isSale();
    $new = isNew();
    $min = ($price['min'] === null) ? 1 : getMinPrice($price);
    $max = ($price['max'] === null) ? 32000 : getMaxPrice($price);

    if ($uri[0] === '/' && empty($_GET)) {
        $query = "SELECT COUNT(name) AS count FROM goods";
    } elseif ($uri[0] !== '/' && empty($_GET)) {
        $query = "SELECT COUNT(g.name) AS count FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        WHERE cat.url='$uri[0]'";
    } elseif ($uri[0] === '/' && !$sale && $new) {
        $query = "SELECT COUNT(name) AS count FROM goods
        WHERE new=true && price>='$min' && price<='$max'";
    } elseif ($uri[0] === '/' && $sale && $new) {
        $query = "SELECT COUNT(name) AS count FROM goods
        WHERE sale=true && new=true && price>='$min' && price<='$max'";
    } elseif ($uri[0] === '/' && $sale && !$new) {
        $query = "SELECT COUNT(name) AS count FROM goods
        WHERE sale=true && price>='$min' && price<='$max'";
    } elseif ($uri[0] !== '/' && $sale && !$new) {
        $query = "SELECT COUNT(g.name) AS count FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        WHERE cat.url='$uri[0]' && sale=true && price>='$min' && price<='$max'";
    } elseif ($uri[0] !== '/' && $sale && $new) {
        $query = "SELECT COUNT(g.name) AS count FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        WHERE cat.url='$uri[0]' && sale=true && new=true && price>='$min' && price<='$max'";
    } elseif ($uri[0] !== '/' && !$sale && $new) {
        $query = "SELECT COUNT(g.name) AS count FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        WHERE cat.url='$uri[0]' && new=true && price>=$min && price<=$max";
    } elseif ($uri[0] === '/' && !empty($_GET)) {
        $query = "SELECT COUNT(name) AS count FROM goods
        WHERE price>='$min' && price<='$max'";
    } else {
        $query = "SELECT COUNT(g.name) AS count FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        WHERE cat.url='$uri[0]' && price>='$min' && price<='$max'";
    }
    $result = mysqli_query(
        connect(),
        $query
    );
    return (int)mysqli_fetch_assoc($result)['count'];
}

/**
 * Возвращает значение максимальной и минимальной цены товаров в категории
 * @param string $uri - uri категории
 * @return array - массив с минимальной и максимальной ценой
 */
function getMaxMin(string $uri): array
{
    $uri = explode('?', mysqli_real_escape_string(connect(), $uri));
    $sale = isSale();
    $new = isNew();

    if (!$new && !$sale && $uri[0] === '/') {
        $query = "SELECT MIN(price) AS min, MAX(price) AS max FROM goods";
    } elseif (!$new && !$sale && $uri[0] !== '/') {
        $query = "SELECT MIN(price) AS min, MAX(price) AS max FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods ON goods.id=good_id
        WHERE cat.url='$uri[0]'";
    } elseif ($new && $sale && $uri[0] === '/') {
        $query = "SELECT MIN(price) AS min, MAX(price) AS max FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods ON goods.id=good_id
        WHERE new=true && sale=true";
    } elseif ($new === 'on' && $sale === 'on' && $uri[0] !== '/') {
        $query = "SELECT MIN(price) AS min, MAX(price) AS max FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods ON goods.id=good_id
        WHERE cat.url='$uri[0]' && new=true && sale=true ";
    } elseif (!$new && $sale && $uri[0] === '/') {
        $query = "SELECT MIN(price) AS min, MAX(price) AS max FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods ON goods.id=good_id
        WHERE sale=true ";
    } elseif (!$new && $sale === 'on' && $uri[0] !== '/') {
        $query = "SELECT MIN(price) AS min, MAX(price) AS max FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods ON goods.id=good_id
        WHERE cat.url='$uri[0]' && sale=true";
    } elseif ($new && !$sale && $uri[0] === '/') {
        $query = "SELECT MIN(price) AS min, MAX(price) AS max FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods ON goods.id=good_id
        WHERE sale=true ";
    } else {
        $query = "SELECT MIN(price) AS min, MAX(price) AS max FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods ON goods.id=good_id
        WHERE cat.url='$uri[0]' && sale=true";
    }
    return getResult(mysqli_query(connect(), $query));
}

/**
 * Возвращаеphpт массив товаров
 * @param string $uri - текущая страница
 * @param array $price - массив, содержащий максимальную и минимальную цену в категории
 * @return array - массив товаров
 */
function getGoods(string $uri, array $price): array
{
    if (isset($_GET['page']) && $_GET['page'] !== '') {
        $pos = ($_GET['page'] - 1) * 9;
    } else {
        $pos = 0;
    }
    $limit = PER_PAGE;
    $uri = explode('?', mysqli_real_escape_string(connect(), $uri));
    if (empty($_GET) && $uri[0] === '/') {
        $query = "SELECT goods.id, name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link FROM goods
        LEFT JOIN good_image ON good_id=id
        LEFT JOIN images AS i ON i.id=image_id
        GROUP BY id LIMIT $pos, $limit";
    } elseif (empty($_GET) && $uri[0] !== '/') {
        $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE cat.url='$uri[0]'
        GROUP BY g.id LIMIT $pos, $limit";
    } else {
        $query = getQueryFilter($uri, $price, $pos);
    }

    if ($query === '') {
        return [];
    }

    $result = mysqli_query(connect(), $query);
    return getResult($result);
}

/**
 * Возвращает строку для query запроса с учетом фильтров
 * @param array $uri - текущая страница
 * @param array $price - массив, содержащий максимальную и минимальную цену в категории
 * @param int $pos - номер элемента, с которого начать
 * @return string - строка для запроса
 */
function getQueryFilter(array $uri, array $price, int $pos): string
{
    $limit = PER_PAGE;
    if (
        !isset($price['min']) && !isset($_GET['min']) ||
        !isset($price['max']) && !isset($_GET['max'])
    ) {
        return '';
    }

    $sale = isSale();
    $new = isNew();
    $min = getMinPrice($price);
    $max = getMaxPrice($price);

    if (!isset($_GET['sort']) || !isset($_GET['type'])) {
        if ($uri[0] === '/' && $sale && !$new) {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE sale=true && price>=$min && price<=$max
        GROUP BY id LIMIT $pos, $limit";
        } elseif ($uri[0] === '/' && $sale && $new) {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE sale=true && new=true && price>=$min && price<=$max
        GROUP BY id LIMIT $pos, $limit";
        } elseif ($uri[0] === '/' && !$sale && $new) {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE new=true && price>=$min && price<=$max
        GROUP BY id LIMIT $pos, $limit";
        } elseif ($uri[0] !== '/' && $sale && !$new) {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE cat.url='$uri[0]' && sale=true && price>=$min && price<=$max
        GROUP BY id LIMIT $pos, $limit";
        } elseif ($uri[0] !== '/' && $sale && $new) {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE cat.url='$uri[0]' && sale=true && new=true && price>=$min && price<=$max
        GROUP BY id LIMIT $pos, $limit";
        } elseif ($uri[0] !== '/' && !$sale && $new) {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE cat.url='$uri[0]' && new=true && price>=$min && price<=$max
        GROUP BY id LIMIT $pos, $limit";
        } elseif ($uri[0] === '/') {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE price>=$min && price<=$max
        GROUP BY id LIMIT $pos, $limit";
        } else {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE cat.url='$uri[0]' && price>=$min && price<=$max
        GROUP BY id LIMIT $pos, $limit";
        }
    } else {
        $sort = $_GET['sort'];
        $type = $_GET['type'] === 'asc' ? 'ASC' : 'DESC';
        if ($uri[0] === '/' && $sale && !$new) {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE sale=true && price>=$min && price<=$max
        GROUP BY g.id, $sort
        ORDER BY $sort $type LIMIT $pos, $limit";
        } elseif ($uri[0] === '/' && $sale && $new) {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE sale=true && new=true && price>=$min && price<=$max
        GROUP BY g.id, $sort
        ORDER BY $sort $type LIMIT $pos, $limit";
        } elseif ($uri[0] === '/' && !$sale && $new) {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE new=true && price>=$min && price<=$max
        GROUP BY g.id, $sort
        ORDER BY $sort $type LIMIT $pos, $limit";
        } elseif ($uri[0] !== '/' && $sale && !$new) {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE cat.url='$uri[0]' && sale=true && price>=$min && price<=$max
        GROUP BY g.id, $sort
        ORDER BY $sort $type LIMIT $pos, $limit";
        } elseif ($uri[0] !== '/' && $sale && $new) {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE cat.url='$uri[0]' && sale=true && new=true && price>=$min && price<=$max
        GROUP BY g.id, $sort
        ORDER BY $sort $type LIMIT $pos, $limit";
        } elseif ($uri[0] !== '/' && !$sale && $new) {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE cat.url='$uri[0]' && new=true && price>=$min && price<=$max
        GROUP BY g.id, $sort
        ORDER BY $sort $type LIMIT $pos, $limit";
        } elseif ($uri[0] === '/') {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE price>=$min && price<=$max
        GROUP BY g.id, $sort
        ORDER BY $sort $type LIMIT $pos, $limit";
        } else {
            $query = "SELECT g.id, g.name, 'desc', price, sale, new, GROUP_CONCAT(link SEPARATOR ', ') AS link 
        FROM categories AS cat
        LEFT JOIN good_category ON category_id=cat.id
        LEFT JOIN goods AS g ON g.id=good_id
        LEFT JOIN good_image ON good_image.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE cat.url='$uri[0]' && price>='$min' && price<='$max'
        GROUP BY g.id, $sort
        ORDER BY $sort $type LIMIT $pos, $limit";
        }
    }

    return $query;
}

/**
 * Возвращает массив общих настроек сайта
 * @return array - массив с настройками сайта
 */
function getConfig(): array
{
    $result = mysqli_query(
        connect(),
        "SELECT name, value, link FROM config
        LEFT JOIN images ON id=image_id"
    );
    $data = mysqli_fetch_all($result);
    $config = [];
    if (mysqli_num_rows($result) > 0) {
        foreach ($data as $item) {
            $config[$item[0]] = $item[1] ?? $item[2];
        }
    }
    return $config;
}

/**
 * Возвращает массив заказов
 * @return array - массив с заказами
 */
function getOrders(): array
{
    $result = mysqli_query(
        connect(),
        "SELECT o.id, surname, o.name, patronymic, sum, phone, d.type AS delivery, p.type AS payment, completed,
        city, street, home, app, comment, date FROM orders AS o
        LEFT JOIN delivery AS d ON d.id=delivery_id
        LEFT JOIN payment AS p ON p.id=payment_id
        ORDER BY completed ASC, date DESC"
    );
    return getResult($result);
}

/**
 * Возвращает массив товаров
 * @return array - массив с товарами
 */
function getAdminProducts(): array
{
    $result = mysqli_query(
        connect(),
        "SELECT g.name, g.id, price, GROUP_CONCAT(cat.name SEPARATOR ', ') AS category, new FROM goods AS g
        LEFT JOIN good_category AS gc ON good_id=g.id
        LEFT JOIN categories AS cat ON cat.id=category_id
        GROUP BY g.id"
    );
    return getResult($result);
}

/**
 * Возвращает массив с данными по конкертному товару
 * @param int $id - id товара, который нужно получить
 * @return array - массив с данными
 */
function getItem(int $id): array
{
    $result = mysqli_query(
        connect(),
        "SELECT g.id, g.name, price, GROUP_CONCAT(DISTINCT cat.name SEPARATOR ', ') AS category, 
        GROUP_CONCAT(DISTINCT cat.id SEPARATOR ', ') AS category_id,
        GROUP_CONCAT(DISTINCT i.link SEPARATOR ', ') AS image, g.id AS image_id, new, sale
        FROM goods AS g
        LEFT JOIN good_category AS gc ON gc.good_id=g.id
        LEFT JOIN categories AS cat ON cat.id=category_id
        LEFT JOIN good_image AS gi ON gi.good_id=g.id
        LEFT JOIN images AS i ON i.id=image_id
        WHERE g.id=$id
        GROUP BY g.name"
    );
    return getResult($result);
}
