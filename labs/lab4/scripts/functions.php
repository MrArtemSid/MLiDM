<?php
/**
 * Запуск скрипта от нажатия кнопки
 */
if(isset($_POST['button1'])) {
    echo "Результат выполнения:<br><br>";
    main();
}

$masOfMas = array();
$comps = array();
$used = array();

/**
 * Валидация параметров ввода
 * @param $mas
 * @param $start
 * @param $end
 * @return bool
 */
function validation($mas, $start, $end): bool {
    $res = true;
    $isNum = true;
    $isZero = true;
    global $masOfMas;

    if(sizeof($mas) != sizeof(array_unique($mas))) {
        $res = false;
        echo "В множестве вершин обнаружены повторяющиеся элементы<br>";
    }

    for ($i = 0; $i < sizeof($mas); ++$i) {
        $masOfMas[$i] = explode(" ", $masOfMas[$i]);
        if ($masOfMas[$i][$i]) {
            $isZero = false;
            $res = false;
        }
        for ($j = 0; $j < sizeof($masOfMas[$i]); ++$j) {
            if (!is_numeric($masOfMas[$i][$j]) || $masOfMas[$i][$j] < -1) {
                $isNum = false;
                $res = false;
            }
        }
        if (sizeof($masOfMas[$i]) != sizeof($mas)) {
            echo "Неверное количество элементов в ", ($i + 1), " строке <br>";
            $res = false;
        }
    }

    if (!$isNum)
        echo "Матрица смежности может содержать только числа [-1; +inf) <br>";

    if (!$isZero)
        echo "Главная диагональ матрицы может иметь только нули<br>";

    return $res;
}

/**
 * Применение алгоритма дейкстры для нахождения кратчейшего пути в графе и его стоимости
 * @param $mas
 * @param $start
 * @param $end
 * @return void
 */
function dijkstra($mas, $start, $end): void {

    class edge {
        public int $from, $to, $weight;
        public function __construct($from, $to, $weight)
        {
            $this->from = $from;
            $this->to = $to;
            $this->weight = $weight;
        }
    };

    $g = array();
    global $masOfMas;

    for ($i = 0; $i < sizeof($mas); ++$i) {
        if ($mas[$i] == $start)
            $start = $i;
        if ($mas[$i] == $end)
            $end = $i;
        for ($j = 0; $j < sizeof($mas); ++$j) {
            if ($masOfMas[$i][$j] != -1 && $i != $j) {
                $g[$i][] = new edge($i, $j, $masOfMas[$i][$j]);
                $g[$j][] = new edge($j, $i, $masOfMas[$i][$j]);
            }
        }
    }

    $empty = INF;
    $dist = array_fill(0, sizeof($mas), $empty);
    $parent = array_fill(0, sizeof($mas), 0);
    $used = array_fill(0, sizeof($mas), 0);

    $dist[$start] = 0;
    $parent[$start] = -1;
    for ($ind = 0; $ind < sizeof($mas); ++$ind) {
        $v = -1;
        for ($i = 0; $i < sizeof($mas); ++$i) {
            if (!$used[$i] && ($v == -1 || $dist[$i] < $dist[$v])) {
                $v = $i;
            }
        }
        if ($dist[$v] == $empty) {
            break;
        }
        $used[$v] = 1;
        foreach ($g[$v] as $i) {
            if ($dist[$v] + $i->weight < $dist[$i->to]) {
                $dist[$i->to] = $dist[$v] + $i->weight;
                $parent[$i->to] = $v;
            }
        }
    }

    if ($dist[$end] == $empty) {
        echo "Не существует путей между этими вершинами<br><br>";
        return;
    }
    echo "Стоимость кратчайшего пути:<br>", $dist[$end], "<br><br>";
    echo "Путь из ", $mas[$start], " в ", $mas[$end], ":<br>";
    $way = array();
    while ($end != -1) {
        $way[] = $end;
        $end = $parent[$end];
    }

    for($i = sizeof($way) - 1; $i >= 0; --$i){
        if ($i != sizeof($way) - 1)
            echo " -> ";
        echo ($mas[$way[$i]]);
    }
    echo "<br><br>";
}

/**
 * Обход графа в глубину с добавлением вершин в компоненту связности
 * @param $v
 * @return void
 */
function dfs($v): void {
    global $masOfMas;
    global $comps;
    global $used;
    $used[$v] = true;
    $comps[sizeof($comps) - 1][] = $v;
    for ($u = 0; $u < sizeof($masOfMas); ++$u) {
        if (!$used[$u] && ($masOfMas[$v][$u] > 0 || $masOfMas[$u][$v] > 0)) {
            dfs($u);
        }
    }
}

/**
 * Нахождение компонент связности через DFS и построение на них матрицы достижимости
 * @return void
 */
function find_comps(): void {
    global $masOfMas;
    global $comps;
    global $used;
    $used = array_fill(0, sizeof($masOfMas), 0);
    $ans = array();
    for ($i = 0; $i < sizeof($masOfMas); ++$i) {
        if (!$used[$i]) {
            $comps[] = [];
            dfs($i);
        }
        $ans[] = array();
    }

    foreach ($comps as $comp) {
        $tmp = array_fill(0, sizeof($masOfMas), 0);
        foreach ($comp as $v) {
            $tmp[$v] = 1;
        }
        foreach ($comp as $v) {
            $ans[$v] = $tmp;
        }
    }
    echo "Матрица достижимости:<br>";
    for ($i = 0; $i < sizeof($masOfMas); $i++) {
        for ($j = 0; $j < sizeof($masOfMas); $j++) {
            echo $ans[$i][$j], " ";
        }
        echo "<br>";
    }
}

/**
 * Основная функция
 * @return void
 */
function main(): void
{
    $mas = $_POST['mas'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $mas = explode(" ", $mas);
    global $masOfMas;
    $masOfMas = $_POST['masOfMas'];
    $masOfMas = explode("\n", $masOfMas);

    if (!validation($mas, $start, $end))
        return;

    dijkstra($mas, $start, $end);
    find_comps();

    unset($mas, $masOfMas, $start, $end, $comps, $used);
}
?>