$(document).ready(function () {
    $('.imggiohang').hover(function () {
        $.get("http://localhost/foodanddrink/admin/thongbao",{},function (dataTB) {
            $(".thongbaoshow").html(dataTB);
        });
    })
});
var slTang=0;
var socket = io("http://localhost:3000");
socket.emit("admin");
socket.on("user-mua-hang",function(data){
    $.get("http://localhost/foodanddrink/admin/tangsltb",{username:data},function (data1) {
        $(".sltb").html(data1);
    });
});