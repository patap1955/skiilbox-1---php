'use strict';

const toggleHidden = (...fields) => {

    fields.forEach((field) => {

        field.hidden = field.hidden !== true;
    });
};

const labelHidden = (form) => {

    form.addEventListener('focusout', (evt) => {

        const field = evt.target;
        const label = field.nextElementSibling;

        if (field.tagName === 'INPUT' && field.value && label) {

            label.hidden = true;

        } else if (label) {

            label.hidden = false;

        }
    });
};

const toggleDelivery = (elem) => {

    const delivery = elem.querySelector('.js-radio');
    const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
    const deliveryNo = elem.querySelector('.shop-page__delivery--no');
    const fields = deliveryYes.querySelectorAll('.custom-form__input');

    delivery.addEventListener('change', (evt) => {

        if (evt.target.id === 'dev-no') {

            fields.forEach(inp => {
                if (inp.required === true) {
                    inp.required = false;
                }
            });


            toggleHidden(deliveryYes, deliveryNo);

            deliveryNo.classList.add('fade');
            setTimeout(() => {
                deliveryNo.classList.remove('fade');
            }, 1000);

        } else {

            fields.forEach(inp => {
                if (inp.required === false) {
                    inp.required = true;
                }
            });

            toggleHidden(deliveryYes, deliveryNo);

            deliveryYes.classList.add('fade');
            setTimeout(() => {
                deliveryYes.classList.remove('fade');
            }, 1000);
        }
    });
};

/**
 * CATEGORIES
 */
const filterWrapper = document.querySelector('.filter__list');
if (filterWrapper) {

    filterWrapper.addEventListener('click', evt => {

        const filterList = filterWrapper.querySelectorAll('.filter__list-item');

        filterList.forEach(filter => {

            if (filter.classList.contains('active')) {

                filter.classList.remove('active');

            }

        });

        const filter = evt.target;

        filter.classList.add('active');

    });

}

/**
 * ITEMS
 */
const shopList = document.querySelector('.shop__list');
if (shopList) {

    shopList.addEventListener('click', (evt) => {

        const prod = evt.path || (evt.composedPath && evt.composedPath());

        if (prod.some(pathItem => pathItem.classList && pathItem.classList.contains('shop__item'))) {

            const shopOrder = document.querySelector('.shop-page__order');

            toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

            window.scroll(0, 0);

            shopOrder.classList.add('fade');
            setTimeout(() => shopOrder.classList.remove('fade'), 1000);

            const form = shopOrder.querySelector('.custom-form');
            labelHidden(form);

            toggleDelivery(shopOrder);

            const buttonOrder = shopOrder.querySelector('.button');
            const popupEnd = document.querySelector('.shop-page__popup-end');

            buttonOrder.addEventListener('click', (evt) => {

                form.noValidate = true;

                const inputs = Array.from(shopOrder.querySelectorAll('[required]'));

                inputs.forEach(inp => {

                    if (!!inp.value) {

                        if (inp.classList.contains('custom-form__input--error')) {
                            inp.classList.remove('custom-form__input--error');
                        }

                    } else {

                        inp.classList.add('custom-form__input--error');

                    }
                });

                if (inputs.every(inp => !!inp.value)) {

                    evt.preventDefault();

                    toggleHidden(shopOrder, popupEnd);

                    popupEnd.classList.add('fade');
                    setTimeout(() => popupEnd.classList.remove('fade'), 1000);

                    window.scroll(0, 0);

                    const buttonEnd = popupEnd.querySelector('.button');

                    buttonEnd.addEventListener('click', () => {


                        popupEnd.classList.add('fade-reverse');

                        setTimeout(() => {

                            popupEnd.classList.remove('fade-reverse');

                            toggleHidden(
                                popupEnd,
                                document.querySelector('.intro'),
                                document.querySelector('.shop')
                            );

                        }, 1000);

                    });

                } else {
                    window.scroll(0, 0);
                    evt.preventDefault();
                }
            });
        }
    });
}

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

    pageOrderList.addEventListener('click', evt => {


        if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
            var path = evt.path || (evt.composedPath && evt.composedPath());
            Array.from(path).forEach(element => {

                if (element.classList && element.classList.contains('page-order__item')) {

                    element.classList.toggle('order-item--active');

                }

            });

            evt.target.classList.toggle('order-item__toggle--active');

        }

        if (evt.target.classList && evt.target.classList.contains('order-item__btn')) {

            const status = evt.target.previousElementSibling;

            if (status.classList && status.classList.contains('order-item__info--no')) {
                let id = $(evt.target).parents('.order-item.page-order__item').data('id');
                changeStatusAjax(true, id);
                status.textContent = 'Выполнено';
            } else {
                let id = $(evt.target).parents('.order-item.page-order__item').data('id');
                changeStatusAjax(false, id);
                status.textContent = 'Не выполнено';
            }

            status.classList.toggle('order-item__info--no');
            status.classList.toggle('order-item__info--yes');

        }

    });

}

const checkList = (list, btn) => {

    btn.hidden = list.children.length !== 1;

};
const addList = document.querySelector('.add-list');
const form = document.querySelector('.custom-form');
const popupEnd = document.querySelector('.page-add__popup-end');
if (addList) {

    labelHidden(form);

    const addButton = addList.querySelector('.add-list__item--add');
    const addInput = addList.querySelector('#product-photo');

    checkList(addList, addButton);

    addInput.addEventListener('change', evt => {

        const template = document.createElement('LI');
        const img = document.createElement('IMG');

        template.className = 'add-list__item add-list__item--active';
        template.addEventListener('click', evt => {
            addList.removeChild(evt.target);
            addInput.value = '';
            checkList(addList, addButton);
        });

        const file = evt.target.files[0];
        const reader = new FileReader();

        reader.onload = (evt) => {
            img.src = evt.target.result;
            template.appendChild(img);
            addList.appendChild(template);
            checkList(addList, addButton);
        };

        reader.readAsDataURL(file);

        let data = new FormData();

        let files = $(addInput).prop('files');
        $.each(files, (key, item) => {
            data.append(key, item);
        });

        $.ajax({
            url: '/data/uploadImage.php',
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: (response) => {
                $('.add_product__form button.button').attr('data-image-id', response)
            }
        })

    });

    const button = document.querySelector('.button');

    button.addEventListener('click', (evt) => {

        evt.preventDefault();

        // form.hidden = true;
        // popupEnd.hidden = false;

    });

}

// jquery range maxmin
let param = window.location.search.replace('?', '').split('&');
let data = [];
param.forEach((item) => {
    item = item.split('=');
    data[item[0]] = item[1];
});

let pMin = $('#min').data('min');
let pMax = $('#max').data('max');
let min = data['min'] ? data['min'] : pMin;
let max = data['max'] ? data['max'] : pMax;
if (document.querySelector('.shop-page')) {
    let rangeLine = $('.range__line');
    rangeLine.slider({
        min: pMin,
        max: pMax,
        values: [min, max],
        range: true,
        stop: function () {
            $('.min-price').text(rangeLine.slider('values', 0).toLocaleString('ru-RU') + ' руб.');
            $('.max-price').text(rangeLine.slider('values', 1).toLocaleString('ru-RU') + ' руб.');

            $('#min').val(rangeLine.slider('values', 0));
            $('#max').val(rangeLine.slider('values', 1));
        },
        slide: function () {

            $('.min-price').text(rangeLine.slider('values', 0).toLocaleString('ru-RU') + ' руб.');
            $('.max-price').text(rangeLine.slider('values', 1).toLocaleString('ru-RU') + ' руб.');
        }
    });
}

let changeStatusAjax = (completed, id) => {
    let param = 'status=' + completed + '&id=' + id;
    $.ajax({
        url: '/db/changeOrderStatus.php',
        type: 'POST',
        data: param
    });
}

let goodsContainer = $('.shop__list');
let sendAjax = (params) => {
    $.ajax({
        url: '/render/renderAjax.php',
        type: 'GET',
        data: params,
        success: (response) => {
            response = $.parseJSON(response);
            goodsContainer.empty();
            goodsContainer.html(response['goods']);
            $('.res-sort').text(response['count']);
            $('.shop__paginator.paginator').html(response['pages']);

            paginationClick();
            itemClick();
        }
    });
}

let changeUrl = (currentPage = '') => {
    let newPage = currentPage !== '' ? currentPage : $('.paginator__item.active').text();
    let page = 'page=' + newPage + '&';
    let isNewChecked = $('#new:checked').length === 1 ? 'new=on&' : '';
    let isSaleChecked = $('#sale:checked').length === 1 ? 'sale=on&' : '';
    let min = 'min=' + $('#min').val() + '&';
    let max = 'max=' + $('#max').val() + '&';
    let sortSelect = $('#sort option:selected').val();
    let typeSortSelect = $('#typeSort option:selected').val();
    let sort,
        sortCol;
    if (sortSelect === 'price' || sortSelect === 'name') {
        sort = 'sort=' + sortSelect + '&';
    } else {
        sort = ''
    }
    if (typeSortSelect === 'asc' || typeSortSelect === 'desc') {
        sortCol = 'type=' + typeSortSelect + '&';
    } else {
        sortCol = '';
    }
    let params = page + isNewChecked + isSaleChecked + min + max + sort + sortCol;

    let baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
    let newUrl = baseUrl + '?' + params;
    history.pushState(null, null, newUrl);

    sendAjax(params);
}

let paginationClick = () => {
    $('.paginator__item').on('click', (e) => {
        e.preventDefault();
        if (!$(e.target).hasClass('active')) {
            if (window.location.search.indexOf('new=on') === -1) {
                $('#new').prop('checked', false);
            }
            if (window.location.search.indexOf('sale=on') === -1) {
                $('#sale').prop('checked', false);
            }
            changeUrl(e.target.innerText);
        }
    });
}

let deliverySelector = $('#dev-yes');
let itemClick = () => {
    let price;
    let id;
    let orderSum = $('.order__price');
    $('.shop__item.product').on('click', (e) => {
        let item;
        if (!$(e.target).hasClass('shop__item')) {
            item = $(e.target).parents('.shop__item');
        } else {
            item = $(e.target);
        }
        let container = $(item).parents('.shop__list');
        let delivery = parseInt(container.data('delivery'));
        let min = parseInt(container.data('min'));
        price = parseInt(item.data('price'));
        let sum = price;
        id = parseInt(item.data('id'));
        if (sum < min && deliverySelector.attr('checked') === 'checked') {
            sum += delivery;
            orderSum.text(price + ' руб. Стоимость доставки - ' + delivery + '. Всего ' + sum + ' руб.');
        } else {
            orderSum.text('Всего ' + sum + ' руб.')
        }

        let buy = $('.custom-form .button');
        buy.attr('data-sum', price);
        buy.attr('data-id', id);

        orderSum.attr('data-sum', sum);
        orderSum.attr('data-del', delivery);
        orderSum.attr('data-min', min);
        orderSum.attr('data-price', price);
    });
}

let ajaxAdd = (params) => {
    $.ajax({
        url: '/db/addProduct.php',
        type: 'POST',
        data: params,
        success: (response) => {
            if (response === 'success') {
                form.hidden = true;
                popupEnd.hidden = false;
            } else {
                alert('Произошла ошибка, проверьте введенные данные!')
            }
        }
    });
}

$(document).ready(() => {
    $('#dev-yes').on('change', (e) => {
        let orderSum = $('.order__price');
        let container = $(e.target).parents('.shop-page__order');
        let prices = container.find('.order__price');
        let price = prices.data('price');
        let delivery = prices.data('del');
        let min = prices.data('min');
        let sum = prices.data('sum');

        if (price < min) {
            sum = price + delivery;

            prices.attr('data-sum', sum);

            orderSum.text(price + ' руб. Стоимость доставки - ' + delivery + '. Всего ' + sum + ' руб.');

            $('.custom-form.js-order button[type="submit"]').attr('data-sum', sum);
        } else {
            orderSum.text(price + ' руб. Стоимость доставки - ' + 0 + '. Всего ' + sum + ' руб.');
        }


    });
    $('#dev-no').on('change', (e) => {
        let orderSum = $('.order__price');
        let container = $(e.target).parents('.shop-page__order');
        let prices = container.find('.order__price');
        let price = prices.data('price');
        prices.attr('data-sum', prices);
        orderSum.text('Всего ' + price + ' руб.')

        $('.custom-form.js-order button[type="submit"]').attr('data-sum', price);
    });

    $('.removeImage').on('click', (e) => {
        e.preventDefault();
        let uri = $(e.target).data('uri');
        let params = 'uri=' + uri;
        $.ajax({
            url: '/db/deleteImage.php',
            type: 'POST',
            data: params,
            success: (response) => {
                if (response === 'success') {
                    $(e.target).parents('li').remove();
                }
            }
        })
    });

    $('.add_product__form button.button').on('click', (e) => {
        e.preventDefault();

        let name = $('#product-name').val();
        let price = $('#product-price').val().replace(/\s+/g, '');
        let categories = $('.custom-form__select option:selected');
        let catId = '';
        for (let i = 0; i < categories.length; i++) {
            if (i === 0) {
                catId = categories[i].value;
            } else {
                catId += ',' + categories[i].value;
            }
        }
        let isNew = '';
        if ($('#new').prop('checked')) {
            isNew = '&new=on';
        }
        let isSale = '';
        if ($('#sale').prop('checked')) {
            isSale = '&sale=on';
        }

        let type = $(e.target).data('edit');
        let itemId = '';
        if (type === 'edit') {
            itemId = '&item=' + $(e.target).data('id');
        }
        let imageId = $(e.target).data('image-id');
        imageId = imageId === undefined ? '' : '&image=' + imageId;
        let params = 'name=' + name + '&price=' + price + '&categories=' + catId + isNew + isSale + '&type=' + type + imageId + itemId;
        ajaxAdd(params);
    });


    $('.product-item__delete').on('click', (e) => {
        let id = $(e.target).data('id');
        let params = 'id=' + id;
        $.ajax({
            url: '/db/removeGoods.php',
            type: 'POST',
            data: params,
            success: (response) => {
                if (response === 'success') {
                    $(e.target).parents('.product-item').remove();
                }
            }
        })
    });

    itemClick();

    $('.custom-form.js-order button[type="submit"]').on('click', (e) => {
        e.preventDefault();
        let inputs = $('.custom-form.js-order').serializeArray();
        let sum = $(e.target).data('sum');
        let id = $(e.target).data('id');
        let params = $.param(inputs);
        params += '&id=' + id + '&sum=' + sum;
        $.ajax({
            url: '/data/validateForm.php',
            type: 'POST',
            data: params,
            success: (response) => {
                if (response === 'error') {
                    $('.order__error').text('Необходимо заполнить поля отмеченные звездочкой');
                } else {
                    $('.shop-page__wrapper').html(response);
                }
            }
        });
    });

    paginationClick();

    $('#sort').on('change', () => {
        changeUrl(1);
    });

    $('#typeSort').on('change', () => {
        changeUrl(1);
    });

    $('.submit_filter').on('click', (e) => {
        e.preventDefault();
        changeUrl(1);
    });

    $('#changeDelivery').on('click', (e) => {
        e.preventDefault();
        let form = $(e.target).parents('form');
        let delivery = form.find('#price_delivery').val();
        let minSum = form.find('#min_sum').val();
        let params = 'delivery=' + delivery + '&minSum=' + minSum;
        $.ajax({
            url: '/data/changeDelivery.php',
            type: 'POST',
            data: params
        })
    });
});
