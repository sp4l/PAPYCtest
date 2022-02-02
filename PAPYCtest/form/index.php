<form action="server.php" method="post" enctype="multipart/form-data">
    <p><textarea rows="10" name="comment" placeholder="Комментарий"></textarea></p>
    <p><input type="text" name="surname" placeholder="Фамилия" required></p>
    <p><input type="text" name="firstname" placeholder="Имя" required></p>
    <p><input type="text" name="secondname" placeholder="Отчество" required></p>
    <p><input type="text" name="address" placeholder="Адрес"></p>
    <p><input type="email" name="email" placeholder="Email"></p>
    <p><input type="text" name="phone" placeholder="Мобильный телефон" required></p>
    <p><input type="file" name="file"></p>
    <input type="submit" name="button">
</form>

<?php
if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "ok": ?>
            <h3>Все ОК!</h3>
        <?php break;
        case "email": ?>
            <h3>Регистрация пользователей с таким почтовым адресом невозможна</h3>
        <?php break;
        case "fio": ?>
            <h3>Поля ФИО и мобильный телефон обязательны к заполнению</h3>
<?php break;
    }
}
