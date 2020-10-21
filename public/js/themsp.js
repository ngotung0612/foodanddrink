$(document).ready(function () {

    $(".btnmua").click(function () {
        // alert("ok");
        var parent =$(this).parents('.col-sm-6');
        var maSP = parent.find('input').val();
        var src = parent.find('img').attr('src');
        $.get("http://localhost/foodanddrink/users/addSP",{maSP:maSP},function (data) {
            var sl = $(document).find('.slsp').html(data);
        })

    })
});