$('.content-show').hide();

$("#closr_x").click(function () {
  $('.content-show').hide(300);
})

function sendEmail() {
  var name = $("#username");
  var email = $("#email");
  var cause = $("#cause");
  var password_new = $("#new_password");
  var header = $("#header");

  if (isNotEmpty(name) && isNotEmpty(email) && isNotEmpty(cause) && isNotEmpty(password_new)) {
    $.ajax({
      url: 'sendEmail.php',
      method: 'POST',
      dataType: 'json',
      data: {
        name: name.val(),
        email: email.val(),
        cause: cause.val(),
        password_new: password_new.val(),
        header: header.val()
      },
      success: function (response) {
        console.log(response);
        $('#myform')[0].reset();
        $('.content-show').show(100);
        $('.msg').text("✅✅ request send successfully");
      }
    });
  }
}


function isNotEmpty(caller) {
  if (caller.val() == "") {
    caller.css('border', '1px solid red');
    return false;
  } else caller.css('border', '');

  return true;
}