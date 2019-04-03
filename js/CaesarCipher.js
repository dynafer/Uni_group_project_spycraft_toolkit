var alphabet = "abcdefghijklmnopqrstuvwxyz";
var fullAlphabet = alphabet + alphabet + alphabet;

function runCipher(){
  var cipherText = $('#plaintextMessage').val();
  var cipherShift = $('#shift').val();
  cipherShift = (cipherShift % alphabet.length);
  var cipherFinish = '';

  for(i=0; i<cipherText.length; i++){
     var letter = cipherText[i];
     var upper = (letter == letter.toUpperCase());
     letter = letter.toLowerCase();
    
     var index = alphabet.indexOf(letter);
     if(index == -1){
       cipherFinish += letter;
     } else {
       index = ((index + cipherShift) + alphabet.length);
       var nextLetter = fullAlphabet[index];
       if(upper) nextLetter = nextLetter.toUpperCase();
       cipherFinish += nextLetter;
     }
  }
    
  $('#encryptedMessage').val(cipherFinish);
}

$(document).ready(function() {
  $('#plaintextMessage').keypress(function(){
    setTimeout(function(){ runCipher(); },20);
  });
  $('#plaintextMessage').blur(function(){
    runCipher();
  });
  $('#shift').change(function(){
    setTimeout(runCipher(),20);
  });
  
});