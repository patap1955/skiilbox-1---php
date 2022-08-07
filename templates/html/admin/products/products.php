<main class="page-products">
    <h1 class="h h--1">Товары</h1>
    <form action="">
        <ul>
            <li>
                <label for="min_sum">Минимальная сумма заказа</label>
                <input id="min_sum" name="min_sum" type="number" value="<?= $config['min_dilevery']; ?>">
            </li>
            <li>
                <label for="price_delivery">Стоимость доставки</label>
                <input id="price_delivery" name="price_delivery" type="number" value="<?= $config['cost_delivery']; ?>">
            </li>
        </ul>
        <input id="changeDelivery" type="submit" value="Изменить">
    </form>
    <a class="page-products__button button" href="/admin/products/add/">Добавить товар</a>
    <div class="page-products__header">
        <span class="page-products__header-field">Название товара</span>
        <span class="page-products__header-field">ID</span>
        <span class="page-products__header-field">Цена</span>
        <span class="page-products__header-field">Категория</span>
        <span class="page-products__header-field">Новинка</span>
    </div>

    <?php $products = database\getAdminProducts();
    render\renderAdminProductsList($products); ?>
</main>
