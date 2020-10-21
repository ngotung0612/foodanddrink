<?php
class DonhangController extends ControllerBase{
    public function chuyenTTAction(){
        $this->view->disable();
        $maDonHang = $_GET['maDonHang'];
        $trangThai = $_GET['tt'];
        $data = Donhang::findFirst("maDonHang = '$maDonHang'")->toArray();
        $datanew = array(
            'maDonHang'=>$maDonHang,
            'username'=>$data['username'],
            'tongTien'=>$data['tongTien'],
            'ngayGiao'=>$data['ngayGiao'],
            'trangThai'=>$trangThai,
            'diaChi'=>$data['diaChi']
        );
        $dh = new Donhang();
        if ($dh->save($datanew)){
            echo $trangThai;
            $username = $this->cookies->get('username');
            if (Admin::findFirst("username='$username'")){
                header('location: http://localhost/foodanddrink/admin/donHang?tt=all&page=1');
            }else{
                header('location: http://localhost/foodanddrink/users/donhang?tt=all&page=1');
            }
        }else{
            echo 'Thất bại';
        }
    }
}