$('#go').click(function() {
    var key1 = $('#key1').val();
    var key2 = $('#key2').val();
    var key3 = $('#key3').val();
    var lines = $('#inputText').val().split(" ");
    var output = [];
    var outputText = [];
    for (var i = 0; i < lines.length; i++) {
        // only push this line if it contains a non whitespace character.
        if (/\S/.test(lines[i])) {
            outputText.push($.trim(lines[i]));
            output.push($.trim(lines[i]));
        }
    }
    $('#inputText').val(outputText[key1] +" "+ outputText[key2]+" "+ outputText[key3]);
})


