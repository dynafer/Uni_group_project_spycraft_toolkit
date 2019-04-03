var form = $('.form');
var btn = $('#submit');
var topbar = $('.topbar');
var username = $('#username');
var passw = $('#password');
var passw_check = $('#password_check');
var article =$('.article');
btn.on('click',function(){
  var uname = username.val();
  var pass = passw.val();
  var pass_check = passw_check.val();
  if(uname == "" || pass == "" || pass_check == "") {
    if(uname == "") {
      topbar.addClass('error');
    }
    if(pass == "") {
      topbar.addClass('error1');
    }
    if(pass_check == "") {
      topbar.addClass('error2');
    }
    $('#status').html("Fill the all blanks.");
  } else if(pass !== pass_check) {
    topbar.addClass('error1');
    topbar.addClass('error2');
    $('#status').html("Password and Confirm Password are different.");
  } else {
    var datas;
    datas = new FormData();
    datas.append( 'username', uname );
    $.ajax({
      url: "./register_check.php",
      contentType: 'multipart/form-data',
      type: 'POST',
      data: datas,
      dataType: 'json',
      mimeType: 'multipart/form-data',
      success: function (data) {
        if(data.success === true) {
          var datas2;
          datas2 = new FormData();
          datas2.append( 'desired_username', uname );
          datas2.append( 'desired_password', pass );
          datas2.append( 'desired_password_check', pass_check );
          $.ajax({
            url: "./register.php",
            contentType: 'multipart/form-data',
            type: 'POST',
            data: datas2,
            dataType: 'json',
            mimeType: 'multipart/form-data',
            success: function (data2) {
              if(data2.success === true) {
                top.location.href = "./index.php";
              } else {
                if(data2.error === 1) {
                  topbar.addClass('error');
                  topbar.addClass('error1');
                  topbar.addClass('error2');
                  $('#status').html("Fill the all blanks.");
                } else if(data2.error === 2) {
                  topbar.addClass('error');
                  topbar.addClass('error1');
                  $('#status').html("Password can't be the same as username.");
                } else if(data2.error === 3) {
                  topbar.addClass('error');
                  $('#status').html("The username has already taken.");
                } else if(data2.error === 4) {
                  topbar.addClass('error1');
                  topbar.addClass('error2');
                  $('#status').html("Password must be ranging from 8 to 60.");
                } else if(data2.error === 5) {
                  topbar.addClass('error1');
                  topbar.addClass('error2');
                  $('#status').html("Password and Confirm Password are different.");
                } else if(data2.error === 6) {
                  $('#status').html("Error.");
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
        } else {
          topbar.addClass('error');
          $('#status').html("The username has already taken.");
        }
      },
      error : function (jqXHR, textStatus, errorThrown) {
      },
      cache: false,
      contentType: false,
      processData: false
    });
  }
});

username.on('keydown', function() {
  topbar.removeClass('error');
  $('#status').html("&nbsp;");
});
passw.on('keydown', function() {
  topbar.removeClass('error1');
  topbar.removeClass('error2');
  $('#status').html("&nbsp;");
});
passw_check.on('keydown', function() {
  topbar.removeClass('error1');
  topbar.removeClass('error2');
  $('#status').html("&nbsp;");
});
