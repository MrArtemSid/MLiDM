/**
 * Валидация параметров ввода
 */
function validateElement(element)
{
    return ((element[0]>='a' &&  element[0]<='z')  &&
             (element[1] % 2 == 0)  &&
             (element[2]>=0 && element[2]<=9) &&
             (element[3]>='a' &&  element[3]<='z') );
}


/**
 * Объединение массивов
 * @param elementsArray1
 * @param elementsArray2
 * @param is_text
 * @returns {string}
 */
function unionArray(elementsArray1, elementsArray2, is_text)
{
    let res = ""
    let resultArray = [];
    for(let i=0; i< Math.max(elementsArray1.length, elementsArray2.length); ++i) {
        if (i < elementsArray1.length && resultArray.includes(elementsArray1[i]) == 0)
            resultArray[resultArray.length] = elementsArray1[i];
        if (i < elementsArray2.length && resultArray.includes(elementsArray2[i]) == 0)
            resultArray[resultArray.length] = elementsArray2[i];
    }
    if (is_text == 1)
        res = "Объединение массивов: [" + resultArray.join(", ") + "]"
    else
        res = resultArray
    return res
}

/**
 * Пересечение массивов
 * @param elementsArray1
 * @param elementsArray2
 * @returns {string}
 */
function intersectionArray(elementsArray1, elementsArray2)
{
    let resultArray = [];
    for (let i = 0; i < elementsArray1.length; ++i) {
        if (elementsArray2.includes(elementsArray1[i]) != 0)
            resultArray[resultArray.length] = elementsArray1[i];
    }
    return "Пересечение массивов: [" + resultArray + "]"
}

/**
 * Разность массивов
 * @param elementsArray1
 * @param elementsArray2
 * @param type
 * @returns {*[]}
 */
function diffArray(elementsArray1, elementsArray2, type)
{
    let resultArray = []
    let tmp = ""
    let res = ""
    if (type == 0) {
        tmp += "A/B"
    }
    else {
        tmp += "B/A"
    }
    for (let i = 0; i < elementsArray1.length; ++i) {
        if (elementsArray2.includes(elementsArray1[i]) == 0)
            resultArray[resultArray.length] = elementsArray1[i];
    }
    return resultArray
}

/**
 * Основная функция
 */
function main()
{
    let mas1 = document.getElementById("id_mas1").value
    let mas2 = document.getElementById("id_mas2").value
    let strError = "";
    mas1 = mas1.split(" ")
    mas2 = mas2.split(" ")
    for(let i=0; i<mas1.length; i++)
    {
        if(!validateElement(mas1[i])) {
            strError += "Ошибка в " + (i + 1) + " элементе первого массива <br>"
        }
    }

    for(let i=0; i<mas2.length; i++)
    {
        if(!validateElement(mas2[i]))
            strError += "Ошибка в " + (i + 1) + " элементе второго массива <br>"
    }

    if(strError == "")
    {
        document.getElementById('result').innerHTML = "Результат рассчета:<br>"
        document.getElementById('result').innerHTML += unionArray(mas1, mas2, 1) + "<br>"
        document.getElementById('result').innerHTML += intersectionArray(mas2, mas2) + "<br>"
        diffAB = diffArray(mas1, mas2, 0)
        diffBA = diffArray(mas2, mas1, 1)
        document.getElementById('result').innerHTML += "Разность массива типа " + "A/B" + ": [" + diffAB + "]" + "<br>"
        document.getElementById('result').innerHTML += "Разность массива типа " + "B/A" + ": [" + diffBA + "]" + "<br>"
        document.getElementById('result').innerHTML += "Симметрическая разность массивов: [" + unionArray(diffAB, diffBA, 0) + "] <br>"
    }
    else {
        document.getElementById('result').innerHTML = strError
    }

}