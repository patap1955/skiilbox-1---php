<?php
$edit = isset($_GET['id']);
if ($edit) {
    $product = database\getItem($_GET['id']);
    $categoriesId = explode(', ', $product['category_id']);
}
$categories = database\getCategory();
?>
<main class="page-add">
    <h1 class="h h--1"><?= $edit ? 'Изменение товара' : 'Добавление товара'; ?></h1>
    <form class="custom-form add_product__form" action="#" method="post">
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
            <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
                <input
                    type="text"
                    class="custom-form__input"
                    name="product-name" id="product-name"
                    placeholder="Название товара"
                    value="<?= $edit ? $product['name'] : ''; ?>">
            </label>
            <label for="product-price" class="custom-form__input-wrapper">
                <input
                    type="text"
                    class="custom-form__input"
                    name="product-price" id="product-price"
                    placeholder="Цена товара"
                    value="<?= $edit ? number_format($product['price'], 0, '', ' ') : ''; ?>">
            </label>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
            <?php if ($edit && isset($product['image']) && $product['image'] !== ''): ?>
                <ul class="image-list">
                    <?php foreach (explode(', ', $product['image']) as $image): ?>
                        <li>
                            <img src="<?= $image; ?>" alt="image">
                            <a
                                class="removeImage"
                                data-uri="<?= $image; ?>" href="#">Удалить</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <ul class="add-list">
                <li class="add-list__item add-list__item--add">
                    <input type="file" name="product-photo" id="product-photo" hidden=""
                           accept="image/png, image/jpeg, image/jpg">
                    <label for="product-photo">Добавить фотографию</label>
                </li>
            </ul>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Раздел</legend>
            <div class="page-add__select">
                <label>
                    <select name="category" class="custom-form__select" multiple="multiple" required>
                        <?php foreach ($categories as $category):
                            if ($category['url'] !== '/'):
                                if (isset($categoriesId)): ?>
                                    <option
                                        <?= in_array($category['id'], $categoriesId) ? 'selected' : ''; ?>
                                        value="<?= $category['id']; ?>">
                                        <?= $category['name']; ?>
                                    </option>
                                <?php else: ?>
                                    <option value="<?= $category['id']; ?>">
                                        <?= $category['name']; ?>
                                    </option>
                                <?php endif;
                            endif;
                        endforeach; ?>
                    </select>
                </label>
            </div>
            <input
                <?= $edit && (bool)$product['new'] || !$edit ? 'checked' : '' ?>
                type="checkbox"
                name="new"
                id="new"
                class="custom-form__checkbox">
            <label
                for="new"
                class="custom-form__checkbox-label">Новинка</label>
            <input
                <?= $edit && (bool)$product['sale'] ? 'checked' : '' ?>
                type="checkbox"
                name="sale"
                id="sale"
                class="custom-form__checkbox">
            <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
        </fieldset>
        <button
            data-edit="<?= $edit ? 'edit' : 'add'; ?>"
            <?php if ($edit): ?>
                data-id="<?= $_GET['id']; ?>"
            <?php endif; ?>
            class="button"
            type="submit">
            <?= $edit ? 'Изменить товар' : 'Добавить товар'; ?>
        </button>
    </form>
    <section class="shop-page__popup-end page-add__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
            <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно <?= $edit ? 'изменен' : 'добавлен'; ?></h2>
        </div>
    </section>
</main>
