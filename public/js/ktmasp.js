$(document).ready(function () {
    $('#btnSubmit').attr("disabled", true);
    function kiemTra(){

    }

    $('#maSP').keyup(function () {
        var maSP=$('#maSP').val();
        $.post("http://localhost/foodanddrink/admin/kiemTraMaSP",{maSP:maSP},function (data) {
            if (data.length == 0){
                $(".thongBao").html("");
                $('#btnSubmit').attr("disabled", false);
            }else{
                $(".thongBao").html(data);
                $('#btnSubmit').attr("disabled", true);
            }
        });
    })

})