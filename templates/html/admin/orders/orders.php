<?php $orders = database\getOrders(); ?>

<main class="page-order">
  <h1 class="h h--1">Список заказов</h1>
    <?php render\renderOrdersList($orders); ?>
</main>
