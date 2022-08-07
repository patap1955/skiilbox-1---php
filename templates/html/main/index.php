<?php
$category = database\getCategory();
$price = database\getMaxMin($_SERVER['REQUEST_URI']);
$count = database\getCount($_SERVER['REQUEST_URI'], $price);
$goods = database\getGoods($_SERVER['REQUEST_URI'], $price);
?>

<main class="shop-page">
    <header class="intro">
        <div class="intro__wrapper">
            <h1 class=" intro__title">COATS</h1>
            <p class="intro__info">Collection <?= date('Y') ?></p>
        </div>
    </header>
    <section class="shop container">
        <section class="shop__filter filter">
            <form method="get">
                <div class="filter__wrapper">
                    <b class="filter__title">Категории</b>
                    <?php render\renderMenu($category, 'filter__list', 'filter__list-item', 'active'); ?>
                </div>
                <div class="filter__wrapper">
                    <b class="filter__title">Фильтры</b>
                    <div class="filter__range range">
                        <span class="range__info">Цена</span>
                        <input
                            name="min"
                            id="min"
                            type="text"
                            data-min="<?= $price['min']; ?>"
                            value="<?= isset($_GET['min']) ? $_GET['min'] : $price['min']; ?>">
                        <input
                            name="max"
                            id="max"
                            type="text"
                            data-max="<?= $price['max']; ?>"
                            value="<?= isset($_GET['max']) ? $_GET['max'] : $price['max']; ?>">
                        <div class="range__line" aria-label="Range Line"></div>
                        <div class="range__res">
                            <span class="range__res-item min-price">
                                <?php
                                    if (isset($_GET['min'])) {
                                        echo number_format($_GET['min']);
                                    } else {
                                        echo ($price['min'] === null) ? 1 : number_format(
                                            $price['min'], 0, ',', ' ');
                                    }
                                ?> руб.
                            </span>
                            <span class="range__res-item max-price">
                                <?php
                                if (isset($_GET['max'])) {
                                    echo number_format($_GET['max']);
                                } else {
                                    echo ($price['max'] === null) ? 32000 : number_format(
                                        $price['max'], 0, ',', ' ');
                                }
                                ?> руб.
                            </span>
                        </div>
                    </div>
                </div>
                <fieldset class="custom-form__group">
                    <input type="checkbox"
                           name="new"
                           id="new"
                        <?php if (isset($_GET['new']) && $_GET['new'] === 'on'): ?>
                            checked
                        <?php endif; ?>
                           class="custom-form__checkbox">
                    <label
                        for="new"
                        class="custom-form__checkbox-label custom-form__info"
                        style="display: block;">Новинка</label>

                    <input
                        type="checkbox"
                        name="sale"
                        id="sale"
                        <?php if (isset($_GET['sale']) && $_GET['sale'] === 'on'): ?>
                            checked
                        <?php endif; ?>
                        class="custom-form__checkbox">
                    <label
                        for="sale"
                        class="custom-form__checkbox-label custom-form__info"
                        style="display: block;">Распродажа</label>
                </fieldset>
                <button class="button submit_filter" type="submit" style="width: 100%">Применить</button>
            </form>
        </section>

        <div class="shop__wrapper">
            <section class="shop__sorting">
                <div class="shop__sorting-item custom-form__select-wrapper">
                    <label>
                        <select class="custom-form__select" id="sort" name="category">
                            <option hidden="">Сортировка</option>
                            <option
                                <?php if (isset($_GET['sort']) && $_GET['sort'] === 'price'): ?>
                                    selected
                                <?php endif; ?>
                                value="price">По цене
                            </option>
                            <option
                                <?php if (isset($_GET['sort']) && $_GET['sort'] === 'name'): ?>
                                    selected
                                <?php endif; ?>
                                value="name">По названию
                            </option>
                        </select>
                    </label>
                </div>
                <div class="shop__sorting-item custom-form__select-wrapper">
                    <label>
                        <select class="custom-form__select" id="typeSort" name="prices">
                            <option hidden="">Порядок</option>
                            <option
                                <?php if (isset($_GET['type']) && $_GET['type'] === 'asc'): ?>
                                    selected
                                <?php endif; ?>
                                value="asc">По возрастанию
                            </option>
                            <option
                                <?php if (isset($_GET['type']) && $_GET['type'] === 'desc'): ?>
                                    selected
                                <?php endif; ?>
                                value="desc">По убыванию
                            </option>
                        </select>
                    </label>
                </div>
                <p class="shop__sorting-res">Найдено
                    <span class="res-sort">
                        <?= $count ?>
                    </span> моделей</p>
            </section>
            <section data-delivery="<?= $config['cost_delivery'] ?>" data-min="<?= $config['min_dilevery'] ?>" class="shop__list">
                <?php echo (isset($goods['id']) !== null) ? render\renderGoodsList($goods) : null ?>
            </section>
            <ul class="shop__paginator paginator">
                <?= render\renderPagination($count); ?>
            </ul>
        </div>
    </section>
    <section class="shop-page__order" hidden="">
        <div class="shop-page__wrapper">
            <h2 class="h h--1">Оформление заказа</h2>
            <p class="order__price"></p>
            <p class="order__error"></p>
            <form action="#" method="post" class="custom-form js-order">
                <fieldset class="custom-form__group">
                    <legend class="custom-form__title">Укажите свои личные данные</legend>
                    <p class="custom-form__info">
                        <span class="req">*</span> поля обязательные для заполнения
                    </p>
                    <div class="custom-form__column">
                        <label class="custom-form__input-wrapper" for="surname">
                            <input id="surname" class="custom-form__input" type="text" name="surname" required="">
                            <span class="custom-form__input-label">Фамилия <span class="req">*</span></span>
                        </label>
                        <label class="custom-form__input-wrapper" for="name">
                            <input id="name" class="custom-form__input" type="text" name="name" required="">
                            <span class="custom-form__input-label">Имя <span class="req">*</span></span>
                        </label>
                        <label class="custom-form__input-wrapper" for="thirdName">
                            <input id="thirdName" class="custom-form__input" type="text" name="thirdName">
                            <span class="custom-form__input-label">Отчество</span>
                        </label>
                        <label class="custom-form__input-wrapper" for="phone">
                            <input id="phone" class="custom-form__input" type="tel" name="phone" required="">
                            <span class="custom-form__input-label">Телефон <span class="req">*</span></span>
                        </label>
                        <label class="custom-form__input-wrapper" for="email">
                            <input id="email" class="custom-form__input" type="email" name="email" required="">
                            <span class="custom-form__input-label">Почта <span class="req">*</span></span>
                        </label>
                    </div>
                </fieldset>
                <fieldset class="custom-form__group js-radio">
                    <legend class="custom-form__title custom-form__title--radio">Способ доставки</legend>
                    <input id="dev-no" class="custom-form__radio" type="radio" name="delivery" value="dev-no"
                           checked="">
                    <label for="dev-no" class="custom-form__radio-label">Самовывоз</label>
                    <input id="dev-yes" class="custom-form__radio" type="radio" name="delivery" value="dev-yes">
                    <label for="dev-yes" class="custom-form__radio-label">Курьерная доставка</label>
                </fieldset>
                <div class="shop-page__delivery shop-page__delivery--no">
                    <table class="custom-table">
                        <caption class="custom-table__title">Пункт самовывоза</caption>
                        <tr>
                            <td class="custom-table__head">Адрес:</td>
                            <td>Москва г, Тверская ул,<br> 4 Метро «Охотный ряд»</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Время работы:</td>
                            <td>пн-вс 09:00-22:00</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Оплата:</td>
                            <td>Наличными или банковской картой</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Срок доставки:</td>
                            <td class="date">13 декабря—15 декабря</td>
                        </tr>
                    </table>
                </div>
                <div class="shop-page__delivery shop-page__delivery--yes" hidden="">
                    <fieldset class="custom-form__group">
                        <legend class="custom-form__title">Адрес</legend>
                        <p class="custom-form__info">
                            <span class="req">*</span> поля обязательные для заполнения
                        </p>
                        <div class="custom-form__row">
                            <label class="custom-form__input-wrapper" for="city">
                                <input id="city" class="custom-form__input" type="text" name="city">
                                <span class="custom-form__input-label">Город <span class="req">*</span></span>
                            </label>
                            <label class="custom-form__input-wrapper" for="street">
                                <input id="street" class="custom-form__input" type="text" name="street">
                                <span class="custom-form__input-label">Улица <span class="req">*</span></span>
                            </label>
                            <label class="custom-form__input-wrapper" for="home">
                                <input id="home" class="custom-form__input custom-form__input--small" type="text"
                                       name="home">
                                <span class="custom-form__input-label">Дом <span class="req">*</span></span>
                            </label>
                            <label class="custom-form__input-wrapper" for="aprt">
                                <input id="aprt" class="custom-form__input custom-form__input--small" type="text"
                                       name="aprt">
                                <span class="custom-form__input-label">Квартира <span class="req">*</span></span>
                            </label>
                        </div>
                    </fieldset>
                </div>
                <fieldset class="custom-form__group shop-page__pay">
                    <legend class="custom-form__title custom-form__title--radio">Способ оплаты</legend>
                    <input id="cash" class="custom-form__radio" type="radio" name="pay" value="cash">
                    <label for="cash" class="custom-form__radio-label">Наличные</label>
                    <input id="card" class="custom-form__radio" type="radio" name="pay" value="card" checked="">
                    <label for="card" class="custom-form__radio-label">Банковской картой</label>
                </fieldset>
                <fieldset class="custom-form__group shop-page__comment">
                    <legend class="custom-form__title custom-form__title--comment">Комментарии к заказу</legend>
                    <label>
                        <textarea class="custom-form__textarea" name="comment"></textarea>
                    </label>
                </fieldset>
                <button class="button" type="submit">Отправить заказ</button>
            </form>
        </div>
    </section>
    <section class="shop-page__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
            <h2 class="h h--1 h--icon shop-page__end-title">Спасибо за заказ!</h2>
            <p class="shop-page__end-message">Ваш заказ успешно оформлен, с вами свяжутся в ближайшее время</p>
            <button class="button">Продолжить покупки</button>
        </div>
    </section>
</main>
