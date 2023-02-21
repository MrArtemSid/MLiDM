<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <h1>Лабораторная работа №3</h1>
        <h2>Вариант №14: матрица NxN</h2>
        <form action="" method="POST">
            Введите множество X через пробел<br>
            <input type="text" name="masX" id="id_masX" value=""><br>
            Введите множество Y через пробел<br>
            <input type="text" name="masY" id="id_masY" value=""><br>
            Введите матрицу смежности<br>(X - строки, Y - столбцы):<br>
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

