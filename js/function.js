$(document).ready(function () {

    $('.num').click(function () {
        var num = $(this);
        var text = $.trim(num.find('.txt').clone().children().remove().end().text());
        var telNumber = $('#telNumber');
        $('#telName').val('');
        $('.phone-chk').html('CHECK');
        if(text == '<'){
          removeTextTag();
          return;
        } else if (text == 'C') {
          clearTextTag();
          $('.timecard_list').html('');
          return;
        }
        $(telNumber).val(telNumber.val() + text);
    });

      $("#telNumber").keypress(function(e){
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
         // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) ||
         // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
             // let it happen, don't do anything
             return;
        }
        var charValue = String.fromCharCode(e.keyCode)
            , valid = /^[0-9]+$/.test(charValue);
        if (!valid) {
            e.preventDefault();
        }

        $('#telName').val('');
        $('.phone-chk').html('CHECK');
      });

     $("#telNumber").change(function(){
       $('#telName').val('');
       $('.phone-chk').html('CHECK');
     });

    $('.phone-chk').click(function () {
      var telName = $('#telName').val();
      if(telName == ''){
        login_process();
      } else {
        insert_timecard_detail();
      }
    });

    $('.btn-update').click(function () {
      update_company_info();
    });

    $('.btn-type-register').click(function () {
      register_timecard_type();
    });

    $('.btn-utype-register').click(function () {
      register_user_type();
    });

    $('.btn-member-register').click(function () {
      register_user();
    });

    $('.user-register-table').on('click', 'tbody tr', function() {
      var mId = $(this).find('input').val();
      $("#userRegister_select option").removeAttr("selected");
      fetch_timecard_member_detail(mId);
    });

    $('.btn-user-add').click(function () {
      $("#userRegisterModal").modal();
      $("#userRegisterModal .form-group input").val('');
      $("#userRegisterModal .form-group textarea").val('');
      $("#userRegister_select option").removeAttr("selected");
      $("#userRegister_select option[value=0]").attr('selected', 'selected');
      $(".btn-member-delete").css("display","none");
      $(".btn-member-update").css("display","none");
      $(".btn-member-register").css("display","inline-block");
    });

    $('.btn-member-update').click(function () {
      update_user();
    });

    $('.btn-member-delete').click(function () {
      delete_user();
    });

    $('.login').click(function () {
      // alert('test');
      admin_login_process();
    });

    $('#usertable #userModalClose').click(function () {
      clearTextTag();
    });

    $('.btn-userchoose').click(function () {
      console.log('test');
    });

});

function removeTextTag()  {
  var telNumber_val = $('#telNumber').val();
  $('#telNumber').val(telNumber_val.substring(0,telNumber_val.length-1));
}
function clearTextTag() {
  $('#telNumber').val('');
  $('#telName').val('');
  $('.phone-chk').html('CHECK');
}
function check(){
  var telNumber_val = $('#telNumber').val();
  alert(telNumber_val);
}

function login_process() {
  var telNumber_val = $('#telNumber').val();
  if(telNumber_val == '') {
    alert('No Number');
    return;
  }
  $.ajax({
          url:'includes/timecard_function.php?function=login_process',
          type:'POST',
          data:{
            telNumber : telNumber_val
          },
          dataType: 'json',
          success:function(data){
            var status = data["status"];
            if(status == 'noname'){
              $('.timecard_list').html('Wrong Number');
            } else if (status == 'more') {
              $('#usertable').modal('toggle');
              var name = data['name'];
              var mId = data['mId'];
              var html_text = '';
              for (var i = 0; i < name.length; i++) {
                html_text += "<tr><td class='tdname'>"+name[i]+"<input type='hidden' class='tdmId' value='"+mId[i]+"'></td><td align='right'><button class='btn btn-default btn-userchoose' onclick='setMidName(this)'><span class='glyphicon glyphicon-ok'></span></button></td></tr>";
              }
              var html = "<table class='table'>"+html_text+"</table>";
              $('#usertable .modal-body').html(html);
            } else {
              var name = data["name"];
              var mId = data["mId"];
              // alert(status+name[1]);
              $('.timecard_list').html('');
              $('.phone-chk').html('SUBMIT');
              $('#telName').val(name);
              $('#mId').val(mId);
            }
          }
  });
}

function setMidName(e) {
  var name = $(e).closest("tr").find(".tdname").text();
  var mId = $(e).closest("tr").find(".tdmId").val();
  $('.timecard_list').html('');
  $('.phone-chk').html('SUBMIT');
  $('#telName').val(name);
  $('#mId').val(mId);
  $('#usertable').modal('toggle');
}

function insert_timecard_detail() {
  var telNumber_val = $('#telNumber').val();
  var mId_val = $('#mId').val();
  $.ajax({
          url:'includes/timecard_function.php?function=insert_timecard_detail',
          type:'POST',
          data:{
            telNumber : telNumber_val,
            mId : mId_val
          },
          dataType: 'json',
          success:function(data){
            var status = data["status"];
            var date = data["date"];
            var phone = data["phone"];
            var name = data["name"];
            var chk = data["chk"];
            var timecard_date = data["timecard_date"];

            if(status == 'success'){
              if(chk == '0') {
                var icon = '<i class="fas fa-sign-in-alt pull-right"></i>';
                var icon_text = 'SIGN IN';
                var icon_text2 = 'SignIn';
              } else {
                var icon = '<i class="fas fa-sign-out-alt pull-right"></i>';
                var icon_text = 'SIGN OUT';
                var icon_text2 = 'SignOut';
              }
              var html =
              '<div class="thumbnail">'+
                '<div class="caption">'+
                  '<div class="col-lg-12">'+
                      '<span class="glyphicon glyphicon-calendar"></span>'+
                      icon +
                  '</div>'+
                  '<div class="col-lg-12 well well-add-card">'+
                      '<h3>'+ name +'</h3>'+
                  '</div>'+
                  '<div class="col-lg-12">'+
                      '<p>'+phone+'</p>'+
                      '<p class"text-muted">'+timecard_date+'</p>'+
                  '</div>'+
                  '<div>'+icon_text+'</div>'
                  '<span class="glyphicon glyphicon-exclamation-sign text-danger pull-right icon-style"></span>'+
                '</div>'+
              '</div>';
              toggle_loader(icon_text2);
              // $('.loader-wrapper .loader-text').html('');
            }
            $('.timecard_list').html(html);
            clearTextTag();
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function insert_timecard_detail2(){
  var telNumber_val = $('#telNumber').val();
  $.ajax({
          url:'includes/timecard_function.php?function=insert_timecard_detail',
          type:'POST',
          data:{
            telNumber : telNumber_val
          },
          success:function(data){
            $('.timecard_list').append(data);
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function toggle_loader(icon_text2) {
  $('.loader-wrapper').css("display","block");
  $('.loader-wrapper .loader-text').html(icon_text2);
  $('.loader-wrapper').delay(1500).fadeOut('slow');
}
function update_company_info(){
  var company_name = $('#company_name').val();
  var company_phone = $('#company_phone').val();
  var company_address = $('#company_address').val();
  var company_type_id = $('#tType :selected').val();

  $.ajax({
          url:'../includes/timecard_function.php?function=update_company_info',
          type:'POST',
          data:{
            company_name : company_name,
            company_phone : company_phone,
            company_address : company_address,
            company_type_id : company_type_id
          },
          success:function(data){
            alert('Success');
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function fetch_company_info(){
  $.ajax({
          url:'../includes/timecard_function.php?function=fetch_company_info',
          dataType: 'json',
          success:function(data){
            var companyName = data['companyName'];
            var companyPhone = data['companyPhone'];
            var companyAddress = data['companyAddress'];
            var timecardType = data['timecardType'];
            $('#company_name').val(companyName);
            $('#company_phone').val(companyPhone);
            $('#company_address').val(companyAddress);
            fetch_timecard_type(timecardType);
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function fetch_timecard_type(timecardType){
  $.ajax({
          url:'../includes/timecard_function.php?function=fetch_timecard_type',
          type:'POST',
          data:{
            timecardType : timecardType
          },
          success:function(data){
            $('#tType').html(data);
            // $('#tType_select').html(data);
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function fetch_timecard_type_register(){
  $.ajax({
          url:'../includes/timecard_function.php?function=fetch_timecard_type_register',
          type:'POST',
          success:function(data){
            $('#tType_select').html(data);
            // $('#tType_select').html(data);
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function fetch_user_type_register(chk){
  $.ajax({
          url:'../includes/timecard_function.php?function=fetch_user_type_register',
          type:'POST',
          success:function(data){
            if(chk == '1'){
              $('#uType_select').html(data);
            } else {
              $('#userRegister_select').html(data);
            }
          },
          data:{
            chk : chk
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function fetch_timecard_member(){
  $.ajax({
          url:'../includes/timecard_function.php?function=fetch_timecard_member',
          type:'POST',
          success:function(data){
            $('.user-register-table tbody').html(data);
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function register_timecard_type(){
  var tType_value = $('#tType_register').val();
  $.ajax({
          url:'../includes/timecard_function.php?function=register_timecard_type',
          type:'POST',
          data:{
            tType_value : tType_value
          },
          success:function(data){
            $('#tType_select').append(data);
          },
          error : function(){
            alert('Contact IT');
          }
  });
}


function delete_timecard_type(typeID){
  $.ajax({
          url:'../includes/timecard_function.php?function=delete_timecard_type',
          type:'POST',
          data:{
            typeID : typeID
          },
          success:function(data){
            alert('success');
            $('.t-li-'+typeID).css({"display": "none"});
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function delete_user_type(typeID){
  $.ajax({
          url:'../includes/timecard_function.php?function=delete_user_type',
          type:'POST',
          data:{
            typeID : typeID
          },
          success:function(data){
            // alert(data);
            alert('success');
            $('.u-li-'+typeID).css({"display": "none"});
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function register_user_type(){
  var uType_value = $('#uType_register').val();
  $.ajax({
          url:'../includes/timecard_function.php?function=register_user_type',
          type:'POST',
          data:{
            uType_value : uType_value
          },
          success:function(data){
            $('#uType_select').append(data);
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function register_user(){

  var member_name = $('.member_name').val();
  var member_age = $('.member_age').val();
  var member_school = $('.member_school').val();
  var member_address = $('.member_address').val();
  var member_emergencyname = $('.member_emergencyname').val();
  var member_emergencycontact = $('.member_emergencycontact').val();
  var member_contact = $('.member_contact').val();
  var member_msp = $('.member_msp').val();
  var userRegister_select = $('#userRegister_select :selected').val();
  var member_allergy = $('.member_allergy').val();
  var member_memo = $('.member_memo').val();

  if(member_name == '' || member_contact == ''){
    alert("Name, Contact are required to put");
    return;
  }

  $.ajax({
          url:'../includes/timecard_function.php?function=register_user',
          type:'POST',
          data:{
            member_name : member_name,
            member_age : member_age,
            member_school : member_school,
            member_address : member_address,
            member_emergencyname : member_emergencyname,
            member_emergencycontact : member_emergencycontact,
            member_contact : member_contact,
            member_msp : member_msp,
            userRegister_select : userRegister_select,
            member_allergy : member_allergy,
            member_memo : member_memo
          },
          success:function(data){
            if(data == 'success') {
              var html = "<tr><td>"+member_name+"</td><td>"+member_contact+"</td></tr>";
              $('.user-register-table tbody').append(html);
              $('#userRegisterModal').modal('toggle');
            }
          },
          error : function(){
            alert('Contact IT');
          }
  });
}


function update_user(){
  var member_mId = $('.member_mId').val();
  var member_name = $('.member_name').val();
  var member_age = $('.member_age').val();
  var member_school = $('.member_school').val();
  var member_address = $('.member_address').val();
  var member_emergencyname = $('.member_emergencyname').val();
  var member_emergencycontact = $('.member_emergencycontact').val();
  var member_contact = $('.member_contact').val();
  var member_msp = $('.member_msp').val();
  var userRegister_select = $('#userRegister_select :selected').val();
  var member_allergy = $('.member_allergy').val();
  var member_memo = $('.member_memo').val();

  if(member_name == '' || member_contact == ''){
    alert("Name, Contact are required to put");
    return;
  }
  $.ajax({
          url:'../includes/timecard_function.php?function=update_user',
          type:'POST',
          data:{
            member_mId : member_mId,
            member_name : member_name,
            member_age : member_age,
            member_school : member_school,
            member_address : member_address,
            member_emergencyname : member_emergencyname,
            member_emergencycontact : member_emergencycontact,
            member_contact : member_contact,
            member_msp : member_msp,
            userRegister_select : userRegister_select,
            member_allergy : member_allergy,
            member_memo : member_memo
          },
          success:function(data){
            alert(data);
            $('#userRegisterModal').modal('toggle');
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function delete_user(){
  var member_mId = $('.member_mId').val();
  $.ajax({
          url:'../includes/timecard_function.php?function=delete_user',
          type:'POST',
          data:{
            member_mId : member_mId
          },
          success:function(data){
            alert('Deleted');
            $('#userRegisterModal').modal('toggle');
            location.reload();
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function fetch_timecard_member_detail(mId){
  $.ajax({
          url:'../includes/timecard_function.php?function=fetch_timecard_member_detail',
          type:'POST',
          data:{
            mId : mId
          },
          dataType: 'json',
          success:function(data) {
            var mmId = data['mId'];
            var name = data['name'];
            var age = data['age'];
            var school = data['school'];
            var address = data['address'];
            var eName = data['emergencyname'];
            var eContact = data['emergencycontact'];
            var contact = data['contact'];
            var allergy = data['allergy'];
            var msp = data['msp'];
            var mType = data['memberType'];
            var memo = data['memo'];
            $("#userRegisterModal").modal();
            $('.member_mId').val(mmId);
            $('.member_name').val(name);
            $('.member_age').val(age);
            $('.member_school').val(school);
            $('.member_address').val(address);
            $('.member_emergencyname').val(eName);
            $('.member_emergencycontact').val(eContact);
            $('.member_contact').val(contact);
            $('.member_allergy').val(allergy);
            $('.member_msp').val(msp);
            $("#userRegister_select option[value="+mType+"]").attr('selected', 'selected');
            $('.member_memo').val(memo);
            $(".btn-member-delete").css("display","inline-block");
            $(".btn-member-update").css("display","inline-block");
            $(".btn-member-register").css("display","none");
          },
          error : function(){
            alert('Contact IT');
          }
  });
}

function admin_login_process(){
  var username = $('#m_username').val();
  var password = $('#m_password').val();
  // alert(username+password);
  $.ajax({
          url:'../includes/timecard_function.php?function=admin_login_process',
          type:'POST',
          data:{
            username : username,
            password : password
          },
          success:function(data){
            location.href = '?page=dashboard';
          },
          error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
          }
  });
}

function fetch_reports(){
  var today = $('#today_date').val();
  // alert(today);
  // var password = $('#m_password').val();
  // alert(username+password);
  $('#reports_table tbody').html('');

  $.ajax({
          url:'../includes/timecard_function.php?function=fetch_reports',
          type:'POST',
          data:{
            today : today
          },
          success:function(data){
            // alert(data);
            $('#reports_table tbody').html(data);
          },
          error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
          }
  });
}

function reports_get_number(){
  var today = $('#today_date').val();
  $.ajax({
          url:'../includes/timecard_function.php?function=reports_get_number',
          type:'POST',
          data:{
            today : today
          },
          dataType: 'json',
          success:function(data){
            var total = data['total'];
            var rest = data['rest'];
            var incount = data['incount'];
            var query = data['query'];
            $('.report-total').val(total);
            $('.report-in').val(incount);
            $('.report-rest').val(rest);
            // alert(total+rest+incount);
          },
          error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
          }
  });
}

function signout()  {
  location.href = "?page=logout";
}
