<?php
if(isset($_POST['button1'])) {
    echo "Результат выполнения:<br><br>";
    main();
}

class edge {
    public int $from, $to, $weight;
    public function __construct($from, $to, $weight)
    {
        $this->from = $from;
        $this->to = $to;
        $this->weight = $weight;
    }
};

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
            if (!is_numeric($masTmp[$j])) {
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
        echo "Матрица смежности может содержать только числа<br>";

    return $res;
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

    $g = array();

    for ($i = 0; $i < sizeof($mas); ++$i) {
        if ($mas[$i] == $start)
            $start = $i;
        if ($mas[$i] == $end)
            $end = $i;
        $masTmp = explode(" ", $masOfMas[$i]);
        for ($j = 0; $j < sizeof($mas); ++$j) {
            $g[] = new \Ds\Vector();
			if ($i != $j) {
                $g[$i][] = new edge($i, $j, $masTmp[$j]);
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
        echo "Не существует путей между этими вершинами";
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
}
?>