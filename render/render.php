<?php

namespace render;

/**
 * Отвечает за вывод меню из массива
 * @param array $menu - массив с меню
 * @param string $listClass - класс для родителя
 * @param string $itemClass - класс для элемента
 * @param string $activeClass - класс для активного элемента
 */
function renderMenu(array $menu, string $listClass = '', string $itemClass = '', string $activeClass = ''): void
{
    ?>
    <ul class="<?= $listClass ?>">
        <?php
        foreach ($menu as $elem): ?>
            <li>
                <a class="<?= $itemClass ?> <?= stristr($_SERVER['REQUEST_URI'], '?', TRUE) === $elem['url'] ? $activeClass : '' ?>"
                   href="<?= $elem['url'] ?>"><?= $elem['name'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
}

/**
 * Отвечает за вывод товаров на странице
 * @param array $items - массив с товарами
 * @return string - отрисованный список товаров
 */
function renderGoodsList(array $items): string
{
    $goodsList = '';
    foreach ($items as $item) {
        if (is_array($item)) {
            $new = (bool)$item['new'] ? '<p class="label">NEW!</p>' : '';
            $sale = (bool)$item['sale'] ? '<p class="label">SALE!</p>' : '';
            $goodsList .=
                '<article data-id="' . $item['id'] . '" data-price="' . $item['price'] . '" class="shop__item product" tabindex="0">
                    <div class="product__image">
                        <img src="' . explode(', ', $item['link'])[0] . '" alt="product-name">
                        <div class="product__image__labels">
                           ' . $new . $sale . '
                        </div>
                    </div>
                    <p class="product__name">' . $item['name'] . '</p>
                    <span class="product__price">' . number_format($item['price'], 0, ',', ' ') . ' руб.</span>
                </article>';
        } elseif ($items['name'] !== null) {
            $new = (bool)$items['new'] ? '<p class="label">NEW!</p>' : '';
            $sale = (bool)$items['sale'] ? '<p class="label">SALE!</p>' : '';
            $goodsList .=
                '<article data-price="' . $items['price'] . '" class="shop__item product" tabindex="0">
                <div class="product__image">
                    <img src="' . explode(', ', $items['link'])[0] . '" alt="product-name">
                    <div class="product__image__labels">
                        ' . $new . $sale . '
                    </div>
                </div>
                <p class="product__name">' . $items['name'] . '</p>
                <span class="product__price">' . number_format($items['price'], 0, ',', ' ') . ' руб.</span>
            </article>';
            return $goodsList;
        }
    }
    return $goodsList;
}

/**
 * Функция для рендера кнопок пагинации
 * @param int $countGoods - число товаров
 * @return string - html верстка списка
 */
function renderPagination(int $countGoods): string
{
    $countPages = ceil($countGoods / PER_PAGE);
    $pagination = '';
    if ($countPages > 1) {
        for ($i = 1; $i <= $countPages; $i++) {
            if (
                isset($_GET['page']) && (int)$_GET['page'] !== $i ||
                !isset($_GET['page']) && $i !== 1
            ) {
                $href = 'href="page=' . $i . '"';
                $page = '';
            } else {
                $href = '';
                $page = 'active';
            }
            $pagination .=
                '<li>
                    <a ' . $href . $page . ' class="paginator__item ' . $page . '">' . $i . '</a>
                </li>';
        }
    }
    return $pagination;
}

/**
 * Отрисовывает вывод списка заказов
 * @param array $orders - массив с заказами
 */
function renderOrdersList(array $orders): void
{
    ?>
    <ul class="page-order__list">
        <?php if (!empty($orders)) {
            foreach ($orders as $order) {
                if (is_array($order)) {
                    renderOrder($order);
                } else {
                    renderOrder($orders);
                }
            }
        } ?>
    </ul>
    <?php
}

/**
 * Отрисовывает заказы
 * @param array $order - массив с данными по одному заказу
 */
function renderOrder(array $order): void
{
    ?>
    <li data-id="<?= $order['id'] ?>" class="order-item page-order__item">
        <div class="order-item__wrapper">
            <div class="order-item__group order-item__group--id">
                <span class="order-item__title">Номер заказа</span>
                <span class="order-item__info order-item__info--id"><?= $order['id'] ?></span>
            </div>
            <div class="order-item__group">
                <span class="order-item__title">Сумма заказа</span>
                <?= number_format($order['sum'], 0, '', ' '); ?>
            </div>
            <button class="order-item__toggle"></button>
        </div>
        <div class="order-item__wrapper">
            <div class="order-item__group order-item__group--margin">
                <span class="order-item__title">Заказчик</span>
                <span
                    class="order-item__info"><?= $order['surname'] . ' ' . $order['name'] . ' ' . $order['patronymic']; ?></span>
            </div>
            <div class="order-item__group">
                <span class="order-item__title">Номер телефона</span>
                <span class="order-item__info"><?= $order['phone']; ?></span>
            </div>
            <div class="order-item__group">
                <span class="order-item__title">Способ доставки</span>
                <span class="order-item__info"><?= $order['delivery']; ?></span>
            </div>
            <div class="order-item__group">
                <span class="order-item__title">Способ оплаты</span>
                <span class="order-item__info"><?= $order['payment']; ?></span>
            </div>
            <div class="order-item__group order-item__group--status">
                <span class="order-item__title">Статус заказа</span>
                <span
                    class="order-item__info <?= (bool)$order['completed'] ? 'order-item__info--yes' : 'order-item__info--no'; ?>"><?= (bool)$order['completed'] ? 'Выполнено' : 'Не выполнено'; ?></span>
                <button class="order-item__btn">Изменить</button>
            </div>
        </div>
        <?php if ($order['city'] !== null): ?>
            <div class="order-item__wrapper">
                <div class="order-item__group">
                    <span class="order-item__title">Адрес доставки</span>
                    <span
                        class="order-item__info"><?= 'г. ' . $order['city'] . ', ул. ' . $order['street'] . ', д.' . $order['home'] . ', кв. ' . $order['app'] . ''; ?></span>
                </div>
            </div>
        <?php endif; ?>
        <div class="order-item__wrapper">
            <div class="order-item__group">
                <span class="order-item__title">Комментарий к заказу</span>
                <span class="order-item__info"><?= $order['comment']; ?></span>
            </div>
        </div>
        <div class="order-item__wrapper">
            <div class="order-item__group">
                <span class="order-item__title">Дата заказа</span>
                <span class="order-item__info"><?= $order['date']; ?></span>
            </div>
        </div>
    </li>
    <?php
}

/**
 * Отрисовывает вывод списка товаров в админке
 * @param array $products - массив с товарами
 */
function renderAdminProductsList(array $products): void
{
    ?>
    <ul class="page-products__list">
        <?php foreach ($products as $product) {
            if (is_array($product)) {
                renderAdminProduct($product);
            } else {
                renderAdminProduct($products);
            }
        }
        ?>
    </ul>
    <?php
}

/**
 * Отрисовывает отдельные товары в админке
 * @param array $product - массив с данными по одному товару
 */
function renderAdminProduct(array $product): void
{
    ?>
    <li class="product-item page-products__item">
        <b class="product-item__name"><?= $product['name']; ?></b>
        <span class="product-item__field"><?= $product['id']; ?></span>
        <span class="product-item__field"><?= number_format($product['price'], 0, '', ' '); ?> руб.</span>
        <span class="product-item__field"><?= $product['category']; ?></span>
        <span class="product-item__field"><?= (bool)$product['new'] ? 'Да' : 'Нет'; ?></span>
        <a href="/admin/products/add/?id=<?= $product['id']; ?>" class="product-item__edit" aria-label="Редактировать"></a>
        <button data-id="<?= $product['id']; ?>" class="product-item__delete"></button>
    </li>
    <?php
}
