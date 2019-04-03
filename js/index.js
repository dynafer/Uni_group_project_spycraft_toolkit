var form = $('.form');
var btn = $('#submit');
var topbar = $('.topbar');
var input = $('#password');
var article =$('.article');
var tries = 0;
var h = input.height();
$('.spanColor').height(h+23);
input.on('focus',function(){
  topbar.removeClass('error success');
  input.text('');
});
btn.on('click',function(){
  if(tries<=2){
    var uname = $('#username').val();
    var pass = $('#password').val();
    console.log(pass);
    var datas, xhr;
    datas = new FormData();
    datas.append( 'username', uname );
    datas.append( 'password', pass );
    $.ajax({
      url: "./login.php",
      contentType: 'multipart/form-data',
      type: 'POST',
      data: datas,
      dataType: 'json',
      mimeType: 'multipart/form-data',
      success: function (data) {
        if(data.checkLog !== false) {
          setTimeout(function(){
            btn.text('Success!');
            top.location.reload();
          },250);
          topbar.addClass('success');
          form.addClass('goAway');
          tries=0;
        } else {
          if(data.error === "denied") {
            tries = 3;
          } else {
            tries++;
          }
          topbar.addClass('error');
          switch(tries){
            case 0:
              btn.text('Login');
              break;
              case 1:
              setTimeout(function(){
              btn.text('Wrong User Info');
              },300);
              break;
            case 2:
              setTimeout(function(){
              btn.text('Wrong User Info Again');
              },300);
              break;
            case 3:
              setTimeout(function(){
              btn.text('Access Denied');
              },300);
              input.prop('disabled',true);
              topbar.removeClass('error');
              input.addClass('disabled');
              btn.addClass('recover');
              break;
             defaut:
              btn.text('Login');
              break;
          }
        }
      },
      error : function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR);
      },
      cache: false,
      contentType: false,
      processData: false
    });
  }
  else{
    topbar.addClass('disabled');
  }

});

$('.form').keypress(function(e){
   if(e.keyCode==13)
   submit.click();
});
input.keypress(function(){
  topbar.removeClass('success error');
});
