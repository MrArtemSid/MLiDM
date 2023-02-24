<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <h1>Лабораторная работа №4: нахождение кратчайшего пути в графе</h1>
        <h2>Вариант №14: неориентированный, матрицей</h2>
        <form action="" method="POST">
            Введите множество вершин через пробел<br>
            <input type="text" name="mas" value=""><br>
            Введите начальную вершину<br>
            <input type="text" name="start" value=""><br>
            Введите конечную вершину<br>
            <input type="text" name="end" value=""><br>
            Введите матрицу смежности:<br>
            <textarea type="text" name="masOfMas" id="id_masOfMas" value=""></textarea><br>
            <br>
            <input type="submit" name="button1" class="button" value="Рассчитать значения" />
            <input type="submit" name="button2" class="button" value="Очистить" />
        </form>
        <br><br>
        <div id="result">
            <?php
            include('scripts/functions.php');
            ?>
        </div>
    </body>
<html>