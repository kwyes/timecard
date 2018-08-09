$(document).ready(function () {

    $('.num').click(function () {
        var num = $(this);
        var text = $.trim(num.find('.txt').clone().children().remove().end().text());
        var telNumber = $('#telNumber');
        if(text == '<'){
          removeTextTag();
          return;
        } else if (text == 'C') {
          clearTextTag();
          return;
        }
        $(telNumber).val(telNumber.val() + text);
    });
    $('.phone-chk').click(function () {
      check();
    });

});


function removeTextTag()
{
  var telNumber_val = $('#telNumber').val();
  $('#telNumber').val(telNumber_val.substring(0,telNumber_val.length-1));
}
function clearTextTag(){
  $('#telNumber').val('');
}
function check(){
  var telNumber_val = $('#telNumber').val();
  alert(telNumber_val);
}
