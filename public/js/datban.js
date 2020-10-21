$(document).ready(function () {
    var socket = io("http://localhost:3000");
    $(".btnmuahang").click(function () {
        var username =$(".username").html();
        socket.emit("mua-hang",username);
    })
});