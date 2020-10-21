$(document).ready(function () {
    var username="";
    $("#btnSubmit").attr("disabled", true);
    $("#txtUsername").keyup(function () {
        username = $("#txtUsername").val();
        $.post("http://localhost/foodanddrink/users/kiemTraDangKi",{username:username},function (data) {
            $("#kqktUser").html(data);
            if (data.length == 0){
                $("#btnSubmit").attr("disabled", false);
            }else{
                $("#btnSubmit").attr("disabled", true);
            }
        })
    });
    $("#btnSubmit").attr("disabled", true);
    $("#txtPassword").keyup(function () {
        var txtpassword = $("#txtPassword").val();
        if (txtpassword.length <=5){
            $("#kqktUser").html("Mật khẩu phải lớn hơn 5 kí tự");
        }else{
            $("#kqktUser").html("");
            $("#btnSubmit").attr("disabled", true);
        }
    })
});