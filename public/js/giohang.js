$(document).ready(function () {
    $(".imggiohang").hover(function () {
        $.post("http://localhost/foodanddrink/giohang/showDropDown",function (data) {
            $(".giohangpopup").html(data);
        })
    })
})