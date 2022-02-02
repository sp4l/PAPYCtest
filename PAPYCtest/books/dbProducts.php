<?php
const SERVER = "localhost";
const DB = "publishing_house";
const LOGIN = "root";
const PASS = "";

$connect = mysqli_connect(SERVER, LOGIN, PASS, DB);

if ($_POST) {
    $bookTitle = trim(strip_tags($_POST['bookTitle']));
    $isbn = trim(strip_tags($_POST['isbn']));
    $page_counts = (int)trim(strip_tags($_POST['page_counts']));
    $date = (int)trim(strip_tags($_POST['date']));
    $surname = trim(strip_tags($_POST['surname']));
    $name = trim(strip_tags($_POST['name']));
    $genreTitle = trim(strip_tags($_POST['genreTitle']));

    $id_book = bookAdd($connect, $isbn, $bookTitle, $page_counts, $date);
    $id_author = authorAdd($connect, $name, $surname);
    $id_genre = genreAdd($connect, $genreTitle);
    foreign($connect, $id_book, $id_author, $id_genre);
}

function productGet($connect)
{
    //жанр Фантастика
    $query = "SELECT books.title, authors.name, authors.surname FROM genre JOIN catalog ON catalog.id_genre = genre.id_genre JOIN books ON books.id_book = catalog.id_book JOIN authorship ON authorship.id_book = books.id_book JOIN authors ON authors.id_author = authorship.id_author WHERE genre.title = 'Фантастика'";

    //Автор с наибольшим кол-вом книг
    // $query = "SELECT authors.name, authors.surname FROM authors WHERE authors.id_author = (SELECT MAX(authorship.id_author) as Name FROM authorship GROUP BY (authorship.id_author) limit 1)";

    $res = mysqli_query($connect, $query);

    if (!$res) {
        die(mysqli_error($connect));
    }

    $products = [];
    $n = mysqli_num_rows($res);

    for ($i = 0; $i < $n; $i++) {
        $data = mysqli_fetch_assoc($res);
        $products[] = $data;
    }

    return $products;
}

function bookAdd($connect, $isbn, $bookTitle, $page_counts, $date)
{
    $sql = "SELECT id_book FROM books WHERE ISBN = '%s' AND title = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($connect, $isbn), mysqli_real_escape_string($connect, $bookTitle));
    $res = mysqli_fetch_assoc(mysqli_query($connect, $query));

    if (!$res) {
        $sql = "INSERT INTO books (ISBN, title, page_counts, date) VALUES ('%s', '%s', '%s', '%s')";
        $query = sprintf($sql, mysqli_real_escape_string($connect, $isbn), mysqli_real_escape_string($connect, $bookTitle), mysqli_real_escape_string($connect, $page_counts), mysqli_real_escape_string($connect, $date));
        $res = mysqli_query($connect, $query);
        if (!$res) {
            die(mysqli_error($connect));
        }
        $sql = "SELECT id_book FROM books WHERE ISBN = '%s' AND title = '%s'";
        $query = sprintf($sql, mysqli_real_escape_string($connect, $isbn), mysqli_real_escape_string($connect, $bookTitle));
        $res = mysqli_fetch_assoc(mysqli_query($connect, $query));
    }
    return $res['id_book'];
}

function authorAdd($connect, $name, $surname)
{
    $sql = "SELECT id_author FROM authors WHERE name = '%s' AND surname = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($connect, $name), mysqli_real_escape_string($connect, $surname));
    $res = mysqli_fetch_assoc(mysqli_query($connect, $query));

    if (!$res) {
        $sql = "INSERT INTO authors (name, surname) VALUES ('%s','%s')";
        $query = sprintf($sql, mysqli_real_escape_string($connect, $name), mysqli_real_escape_string($connect, $surname));
        $res = mysqli_query($connect, $query);
        if (!$res) {
            die(mysqli_error($connect));
        }
        $sql = "SELECT id_author FROM authors WHERE name = '%s' AND surname = '%s'";
        $query = sprintf($sql, mysqli_real_escape_string($connect, $name), mysqli_real_escape_string($connect, $surname));
        $res = mysqli_fetch_assoc(mysqli_query($connect, $query));
    }
    return $res['id_author'];
}

function genreAdd($connect, $genreTitle)
{
    $sql = "SELECT id_genre FROM genre WHERE title = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($connect, $genreTitle));
    $res = mysqli_fetch_assoc(mysqli_query($connect, $query));

    if (!$res) {
        $sql = "INSERT INTO genre (title) VALUES ('%s')";
        $query = sprintf($sql, mysqli_real_escape_string($connect, $genreTitle));
        $res = mysqli_query($connect, $query);
        if (!$res) {
            die(mysqli_error($connect));
        }
        $sql = "SELECT id_genre FROM genre WHERE title = '%s'";
        $query = sprintf($sql, mysqli_real_escape_string($connect, $genreTitle));
        $res = mysqli_fetch_assoc(mysqli_query($connect, $query));
    }
    return $res['id_genre'];
}

//Обновляет таблицы с внешними ключами
function foreign($connect, $id_book, $id_author, $id_genre)
{
    $sql = "SELECT * FROM authorship WHERE id_book = '%s' AND id_author = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($connect, $id_book), mysqli_real_escape_string($connect, $id_author));
    $res = mysqli_fetch_assoc(mysqli_query($connect, $query));
    print_r($res);
    if (!$res) {
        $sql = "INSERT INTO authorship (id_book, id_author) VALUES ('%s', '%s')";
        $query = sprintf($sql, mysqli_real_escape_string($connect, $id_book), mysqli_real_escape_string($connect, $id_author));
        $res = mysqli_query($connect, $query);
        if (!$res) {
            die(mysqli_error($connect));
        }
    }

    $sql = "SELECT * FROM genre WHERE id_book = '%s' AND id_genre = '%s'";
    $query = sprintf($sql, mysqli_real_escape_string($connect, $id_book), mysqli_real_escape_string($connect, $id_genre));
    $res = mysqli_query($connect, $query);

    if (!$res) {
        $sql = "INSERT INTO catalog (id_book, id_genre) VALUES ('%s', '%s')";
        $query = sprintf($sql, mysqli_real_escape_string($connect, $id_book), mysqli_real_escape_string($connect, $id_genre));
        $res = mysqli_query($connect, $query);
        if (!$res) {
            die(mysqli_error($connect));
        }
    }
}
