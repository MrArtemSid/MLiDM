<?php
if(isset($_POST['button1'])) {
    echo "Результат выполнения:<br><br>";
    main();
}

function validation($mas, $masOfMas, $start, $end): bool {
    $res = true;
    $isNum = true;

    if(sizeof($mas) != sizeof(array_unique($mas))) {
        $res = false;
        echo "В множестве вершин обнаружены повторяющиеся элементы<br>";
    }

    for ($i = 0; $i < sizeof($mas); ++$i) {
        $masTmp = explode(" ", $masOfMas[$i]);
        for ($j = 0; $j < sizeof($masTmp); ++$j) {
            if (!is_numeric($masTmp[$j]) || $masTmp[$j] < -1) {
                $isNum = false;
                $res = false;
            }
        }
        if (sizeof($masTmp) != sizeof($mas)) {
            echo "Неверное количество элементов в ", ($i + 1), " строке <br>";
            $res = false;
        }
    }

    if (!$isNum)
        echo "Матрица смежности может содержать только числа [-1; +inf) <br>";

    return $res;
}

function dijkstra($mas, $masOfMas, $start, $end): void {

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

    for ($i = 0; $i < sizeof($mas); ++$i) {
        if ($mas[$i] == $start)
            $start = $i;
        if ($mas[$i] == $end)
            $end = $i;
        $masTmp = explode(" ", $masOfMas[$i]);
        for ($j = 0; $j < sizeof($mas); ++$j) {
            $g[] = new \Ds\Vector();
            if ($masTmp[$j] != -1 && $i != $j) {
                $g[$i][] = new edge($i, $j, $masTmp[$j]);
                $g[$j][] = new edge($j, $i, $masTmp[$j]);
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
    echo "Стоимость кратчайшего пути:<br>", $dist[$end], "<br>";
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
    echo "<br>";
}

$comps = array();
$used = array();

function dfs($v, $graph): void {
    global $comps;
    global $used;
    $used[$v] = true;
    $comps[sizeof($comps) - 1][] = $v;
    for ($u = 0; $u < sizeof($graph); ++$u) {
        if (!$used[$u] && ($graph[$v][$u] > 0 || $graph[$u][$v] > 0)) {
            dfs($u, $graph);
        }
    }
}

function find_comps($graph): void {
    global $comps;
    global $used;
    $used = array_fill(0, sizeof($graph), 0);
    $ans = array();
    for ($i = 0; $i < sizeof($graph); ++$i) {
        if (!$used[$i]) {
            $comps[] = [];
            dfs($i, $graph);
        }
        $ans[] = array();
    }

    foreach ($comps as $comp) {
        $tmp = array_fill(0, sizeof($graph), 0);
        foreach ($comp as $v) {
            $tmp[$v] = 1;
        }
        foreach ($comp as $v) {
            $ans[$v] = $tmp;
            $ans[$v][$v] = 0;
        }
    }
    echo "Матрица достижимости:<br>";
    for ($i = 0; $i < sizeof($graph); $i++) {
        for ($j = 0; $j < sizeof($graph); $j++) {
            echo $ans[$i][$j], " ";
        }
        echo "<br>";
    }
}

function main(): void
{
    $mas = $_POST['mas'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $mas = explode(" ", $mas);
    $masOfMas = $_POST['masOfMas'];
    $masOfMas = explode("\n", $masOfMas);

    if (!validation($mas, $masOfMas, $start, $end))
        return;

    dijkstra($mas, $masOfMas, $start, $end);
    find_comps($masOfMas);

    unset($mas, $masOfMas, $start, $end, $comps, $used);
}
?>