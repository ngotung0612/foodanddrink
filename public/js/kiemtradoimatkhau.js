$(document).ready(function () {
    $("#btnSubmit").attr("disabled", true);
    $("#txtPasswordMoi2").keyup(function () {
        $passwordMoi = $("#txtPasswordMoi").val();
        $passwordMoi2 = $("#txtPasswordMoi2").val();
        if ($passwordMoi2 != $passwordMoi){
            $("#ketQuaKT").html("*Nhập lại mật khẩu chưa đúng");
            $("#btnSubmit").attr("disabled", true);
        }else{
            $("#ketQuaKT").html("");
            $("#btnSubmit").attr("disabled", false);
        }
    })
})