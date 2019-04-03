
var Vigenere = (function(){
  var AcharCode = 'A'.charCodeAt(0);
  var ZcharCode = 'Z'.charCodeAt(0);
  var AZlen = ZcharCode - AcharCode + 1;
  
  function encrypt( text, key, reverse, keepspaces ){    
    var plaintext = keepspaces ? text : text.replace( /\s+/g, '' );
    var messageLen = plaintext.length;
    var keyLen = key.length;
    var enctext = '';
    var encriptionDir = reverse ? ( -1 * AZlen ) : 0;
    
    for( var i = 0; i < messageLen; i++ ){
      var plainLetter = plaintext.charAt(i).toUpperCase();
      if( plainLetter.match(/\s/) ){
        enctext += plainLetter;
        continue;
      }
      
      var keyLetter = key.charAt( i % keyLen ).toUpperCase();
      var vigenereOffset = keyLetter.charCodeAt(0) - AcharCode;
      var encLetterOffset =  ( plainLetter.charCodeAt(0) - AcharCode + Math.abs( encriptionDir + vigenereOffset ) ) % AZlen;
      
      enctext +=  String.fromCharCode( AcharCode + encLetterOffset );          
    }  
    
    return enctext;
  }
  
  return {
    encrypt : function( text, key,keepspaces ){
      return encrypt( text, key, false, keepspaces );
    },
    
    decrypt : function( text, key, keepspaces ){
      return encrypt( text, key, true, keepspaces );
    }
  };  
})();



// For the UI
(function(){
  var $key = document.getElementById('key');
  var $plaintext = document.getElementById('plaintext');
  var $encryptedText = document.getElementById('encryptedText');
  
  var $btnEncrypt = document.getElementById('btn-encrypt');
  var $btnDecrypt = document.getElementById('btn-decrypt');
  
  
  $btnEncrypt.addEventListener( 'click', function(){
    var text = Vigenere.encrypt( $plaintext.value, $key.value , true );
    $encryptedText.value = text;
  });
  
  $btnDecrypt.addEventListener( 'click', function(){
    var text = Vigenere.decrypt( $encryptedText.value, $key.value , true );
    $plaintext.value = text;
  });
})();