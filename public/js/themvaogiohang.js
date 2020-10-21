$(document).ready(function () {
   $('.btnMua').click(function (e) {
       e.preventDefault();
      var parent =$(this).parents('.khung');
      var maSP= parent.find('.maSP').val();
      alert(maSP);
   });
});