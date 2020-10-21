<?php
class DatbanController extends ControllerBase{
    public function chuyenTTAction(){
        $this->view->disable();
        $maDatBan = $_GET['maDatBan'];
        $trangThai = $_GET['tt'];
        $data = Datban::findFirst("maDatBan = '$maDatBan'")->toArray();
        $datanew = array(
            'maDatBan'=>$maDatBan,
            'username'=>$data['username'],
            'soNguoi'=>$data['soNguoi'],
            'thoiGian'=>$data['thoiGian'],
            'trangThai'=>$trangThai
        );
        $dh = new Datban();
        if ($dh->save($datanew)){
            echo $trangThai;
            $username = $this->cookies->get('username');
            if (Admin::findFirst("username='$username'")){
                header('location: http://localhost/foodanddrink/admin/datban?tt=all&page=1');
            }else{
                header('location: http://localhost/foodanddrink/users/datban?tt=all&page=1');
            }
        }else{
            echo 'Thất bại';
        }
    }
}