<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <h1>Лабораторная работа №3</h1>
        <h2>Вариант №14: матрица NxN</h2>
        <form action="" method="POST">
            Введите множество A через пробел<br>
            <input type="text" name="masA" id="id_masA" value=""><br>
            Введите множество B через пробел<br>
            <input type="text" name="masB" id="id_masB" value=""><br>
            Введите матрицу смежности<br>(A - строки, B - столбцы):<br>
            <textarea type="text" name="masOfMas" id="id_masOfMas" value=""></textarea><br>
            <br>
            <input type="button" onClick="main()" value="Рассчитать значения">
        </form>
        <br><br>
        <div id="result">

        </div>
        <script src="/scripts/functions.js" type="text/javascript"></script>
    </body>
<html>

