/**
 * Валидация параметров ввода
 */
function validateElement(masX, masY, masOfMas)
{
    let is_valid = true;

    if (masX.length != masY.length) {
        document.getElementById("result").innerHTML += "Количество элементов массива X не соответствует количеству массива Y <br>";
        is_valid = false;
    }

    if (masX.length != new Set(masX).size) {
        document.getElementById("result").innerHTML += "Массив X содержит повторения <br>";
        is_valid = false;
    }

    if (masY.length != new Set(masY).size) {
        document.getElementById("result").innerHTML += "Массив Y содержит повторения <br>";
        is_valid = false;
    }

    if (masOfMas.length != masY.length || masOfMas.length != masX.length) {
        document.getElementById("result").innerHTML += "Матрица смежностей не соответсвует массивам <br>";
        is_valid = false;
    }

    return is_valid;
}

/**
 * Основная функция
 */
function main() {
    let masX = document.getElementById("id_masX").value
    let masY = document.getElementById("id_masY").value
    let masOfMas = document.getElementById("id_masOfMas").value
    document.getElementById("result").innerHTML = "Результат: <br>";
    masX = masX.split(" ");
    masY = masY.split(" ");
    masOfMas = masOfMas.split("\n");
    let isErr = false;

    if (!validateElement(masX, masY, masOfMas)) {
        return;
    }

    let mp = new Map();
    let is_function = true;
    for (let i = 0; i < masOfMas.length; ++i) {
        let elem = masOfMas[i].split(" ");
        if (elem.length != masX.length) {
            document.getElementById("result").innerHTML += "Неверное количество элементов в " + i + " строке <br>";
            isErr = true;
            continue;
        }
        for (let j = 0; j < elem.length; ++j) {
            if (elem[j] == 1) {
                if (mp.has(masX[i]) == 0)
                    mp.set(masX[i], new Set());
                mp.get(masX[i]).add(masY[j]);
                if (mp.get(masX[i]).size > 1) {
                    is_function = false;
                }
            }
        }
    }

    if (isErr) {
        return;
    }

    if (mp.size < masY.length)
        is_function = false;

    if (is_function)
        for (let elem of mp.keys()) {
            if (mp.get(elem).size != 1)
                is_function = false
            break;
        }


    document.getElementById("result").innerHTML = "Данные отношения ";
    if (!is_function)
        document.getElementById("result").innerHTML += "не ";
    document.getElementById("result").innerHTML += "являются функцией";
}