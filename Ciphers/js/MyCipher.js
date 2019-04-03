function letterValue(str){
    var letNum={
        a: 1, b: 2, c: 3, d: 4, e: 5, f: 6, g: 7, h: 8, i: 9, j: 10, k: 11,
        l: 12, m: 13, n: 14,o: 15, p: 16, q: 17, r: 18, s: 19, t: 20,
        u: 21, v: 22, w: 23, x: 24, y: 25, z: 26

    }
    if(str.length == 1) return letNum[str] || ' ';
    var array = str.split('').map(letterValue);
    return array
}
function keyValue(array) {
    array = array.filter(function(str) {
        return /\S/.test(str);
    });
    var total=0;
    for(var i in array){total += array[i];}
    return total;
}

function encryptVal(array, b){
    for (var i in array){
        if (array[i] == 0){
            array[i] = " ";
        }
        else (array[i] += b)}
    return array;
}

function decryptVal(str, key) {
    var array = str.split(",");
    for (var i in array){
        if (array[i] == 0){
            array[i] = " ";
        }
        else (array[i] -= key)}
    for (var i in array){
        array[i] = String.fromCharCode(64 + array[i]);
        if (array[i] == "@"){
            array[i] = " ";
        }
    }
    var message = array.join("");
    return message;


}

// For the UI

(function(){
    var $plaintextMes = document.getElementById('plaintextMes');
    var $cipherKey = document.getElementById('cipherKey')
    var $encryptedOutput = document.getElementById('encryptedOutput');

    var $encryptMine = document.getElementById('encrypt-mine');
    var $decryptMine = document.getElementById('decrypt-mine');


    $encryptMine.addEventListener("click", function() {
        var text = letterValue($plaintextMes.value);
        //$encryptedOutput.value = text;
        var key = keyValue(text);
        $cipherKey.value = key;
        var message = encryptVal(text, key)
        $encryptedOutput.value = message;
    })
    $decryptMine.addEventListener( 'click', function(){
        var step1 = decryptVal($plaintextMes.value, $cipherKey.value);
        $encryptedOutput.value = step1;
    })



})();
