<?php

include 'dbProducts.php';
// genreAdd($connect, 123, 'Библиотека программиста');
// genreAdd($connect, '978-5-4461-0985-2', 'Фэнтези2');
// authorshipAdd($connect, '978-5-4461-0985-2', 'Тестовое имя', 'Тестовая фамилия');
// productNew($connect, 'ISBN', 'название новой книги', 200, 2022, 'Самое новое имя автора', 'Фамилия тож автора', 'жанр');
?>

<form method="post">
    <h2>Все поля обязательны к заполнению</h2>
    <p><input type="text" name="bookTitle" placeholder="Название книги" required></p>
    <p><input type="text" name="isbn" placeholder="ISBN" required></p>
    <p><input type="text" name="page_counts" placeholder="Кол-во страниц" required></p>
    <p><input type="text" name="date" placeholder="Год издания" required></p>
    <p><input type="text" name="surname" placeholder="Фамилия автора" required></p>
    <p><input type="text" name="name" placeholder="Имя автора" required></p>
    <p><input type="text" name="genreTitle" placeholder="жанр" required></p>
    <input type="submit" name="button">
</form>
<br>
<hr><br>
<?php

$products = productGet($connect);

if ($products) {
    foreach ($products as $product) : ?>
        <h2 class="main__card_text"><?= $product['title'] ?></h2>
        <p class="main__card_price">Автор: <?= $product['surname'] ?> <?= $product['name'] ?></p>

        <p class="main__card_price"><?= $product['Name'] ?></p>
        <p class="main__card_price"><?= $product['Count'] ?></p>
        <p class="main__card_price"><?= $product['id_author'] ?></p>
        <p class="main__card_price"><?= $product['count'] ?></p>
        <hr>
<?php
    endforeach;
} ?>