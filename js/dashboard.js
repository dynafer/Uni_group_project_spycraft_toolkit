var form = $('.form');
var btn = $('#submit');
var topbar = $('.topbar');
var current_password = $('#current_password');
var change_passw = $('#change_password');
var change_passw_check = $('#change_password_check');
var article =$('.article');
var status_update = $('#status_update');
btn.on('click',function(){
  var cupass = current_password.val();
  var chpass = change_passw.val();
  var chpass_check = change_passw_check.val();
  if(cupass == "" || chpass == "" || chpass_check == "") {
    if(cupass == "") {
      status_update.html("You need to enter the current password.");
    }
    if(chpass == "") {
      status_update.html("You need to enter the change password.");
    }
    if(chpass_check == "") {
      status_update.html("You need to enter the confirm password.");
    }
    //$('#status').html("Fill the all blanks.");
  } else if(chpass !== chpass_check) {
    status_update.html("Change Password and Confirm Password are different.");
  } else {
    var datas;
    datas = new FormData();
    datas.append( 'password', cupass );
    datas.append( 'updatePass', chpass );
    datas.append( 'updatePasscheck', chpass_check );
    $.ajax({
      url: "./update_password.php",
      contentType: 'multipart/form-data',
      type: 'POST',
      data: datas,
      dataType: 'json',
      mimeType: 'multipart/form-data',
      success: function (data) {
        if(data.success === true) {
          alert('Re-login, please.');
          location.href="./logout.php";
        } else {
          if(data.error === 0) {
            status_update.html("You entered wrong current password.");
          } else if(data.error === 1) {
            status_update.html("An error occured during updating.");
          } else if(data.error === 2) {
            status_update.html("Change Password must be ranging from 8 to 60.");
          } else if(data.error === 3) {
            status_update.html("Change Password and Confirm Password are different.");
          }
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
current_password.on('keydown', function() {
  status_update.html('');
});
change_passw.on('keydown', function() {
  status_update.html('');
});
change_passw_check.on('keydown', function() {
  status_update.html('');
});
/*
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
*/
