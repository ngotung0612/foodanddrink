<?php
use Phalcon\Http\Response\Cookies;
use function Sodium\randombytes_buf;

class UsersController extends ControllerBase
{
    public function sigupAction(){
        $post = $this->request->getPost();

        if (isset($post['btnSubmit'])){
            $user = new Users();
            $username = $post['username'];
            if (!Users::findFirst("username='$username'")){
                $password = $user->maHoaMK($post['password']);
                $taiKhoan = array(
                    "username" => $post['username'],
                    "password" => $password,
                    "hoTen" => $post['hoTen'],
                    "sdt" => $post['sdt'],
                    "email" => $post['email']
                );
                if ($user->save($taiKhoan)){
                    $this->view->setVar('ketQua',"Đăng kí thành công");
                }else{
                    $this->view->setVar('ketQua',"*Có lỗi bất ngờ xảy ra!");
                }
            }else{
                $this->view->setVar('ketQua',"* Phải nhập đầy đủ thông tin");
            }
        }
    }
    public function loginAction(){
        if (isset($_POST['btnSubmit'])){
            $user = new Users();
            $post = $this->request->getPost();
            $username = $post['username'];
            $password = $user->maHoaMK($post['password']);
            $dataUsers=Users::find("username= '$username'")->toArray();
            if ($password == $dataUsers[0]["password"]){
                $this->view->setVar('kq',"Thanh cong (user)");
                $this->cookies->set(
                    'username',
                    $username,
                    time() +43200
                );
                $this->cookies->set(
                    'password',
                    $password,
                    time() +43200
                );
                $this->cookies->send();
//                setcookie('username',$username,time()+43200);
//                setcookie('password',$password,time()+43200);
            }else{
                $dataAdmin=admin::find("username='$username'")->toArray();
                if ($password == $dataAdmin[0]['password']){
                    $this->view->setVar('kq',"Thanh cong (admin)");
//                    header('location: http://localhost/foodanddrink/sigup');
                }else{
                    $this->view->setVar('kq',$password);
                }
            }
        }
    }
    public function changePasswordAction(){
        if (isset($_POST['btnSubmit'])){
            $post = $this->request->getPost();
            $user = new Users();
            $passwordCu = $user->maHoaMK($post['passwordCu']);
            if ($post['passwordMoi'] === $post['passwordMoi2']){
                $username = $_COOKIE['username'];
                $passwordMoi = $user->maHoaMK($post['passwordMoi']);
                $data = Users::findFirst("username = '$username'")->toArray();
                $this->view->setVar('kq',$data);
                if ($data['password'] === $passwordCu){
                    $this->view->setVar('kq',"Trong if");
                    $dataNew=array(
                        'username' =>$data['username'],
                        'password' =>$passwordMoi,
                        'quyen' => $data['quyen'],
                        'hoTen' => $data['hoTen'],
                        'gioiTinh' => $data['gioiTinh'],
                        'namSinh' => $data['namSinh'],
                        'sdt' => $data['sdt'],
                        'email' => $data['email'],
                        'diaChi' => $data['diaChi']
                    );
                    if ($user->save($dataNew)){
                        $this->cookies->set(
                            'username',
                            $data['username'],
                            time() +43200
                        );
                        $this->cookies->set(
                            'password',
                            $passwordMoi,
                            time() +43200
                        );
                        $this->cookies->send();
                        $this->view->setVar('ketQua',"*Đổi mật khẩu thành công!");
                    }else{
                        $this->view->setVar('ketQua',"*Oop! Có lỗi bất ngờ xảy ra!");
                    }
                }else{
                    $this->view->setVar('ketQua',"*Mật khẩu cũ không đúng!");
                }

            }
        }
    }
    public function logoutAction(){
        $this->cookies->set(
            'username',
            '',
            time() -43200
        );
        $this->cookies->set(
            'password',
            '',
            time() -43200
        );
        $this->cookies->set(
            'slsp',
            '',
            time() -43200
        );
        header('location: http://localhost/foodanddrink');
    }
    public function updateAction(){
        $username = $this->cookies->get('username');
        $data = Users::findFirst("username ='$username'")->toArray();
        $this->view->setVar("data",$data);
        if (isset($_POST['btnSubmit'])){
            $post = $this->request->getPost();
            $dataNew=array(
                'username' =>$data['username'],
                'password' =>$data['password'],
                'quyen' => $data['quyen'],
                'hoTen' => $post['hoTen'],
                'gioiTinh' => $post['gioiTinh'],
                'namSinh' => $post['namSinh'],
                'sdt' => $post['sdt'],
                'email' => $post['email'],
                'diaChi' => $post['diaChi']
            );
            $user = new Users();
            if ($user->save($dataNew)){
                $this->view->setVar('ketQua',"Cập nhật thông tin thành công!");
            }else{
                $this->view->setVar('ketQua',"Thất bại! Họ tên, số điện thoại và email là những thông tin bắt buộc.");
            }
        }
    }

    public function kiemTraDangKiAction(){
        $this->view->disable();
        $post = $this->request->getPost();
        $username = $post['username'];
        if (strlen($username)<4){
            echo "*Username phải lớn hơn 4 kí tự";
        }
        if ($data = Users::findFirst("username='$username'"))
            echo "*Tài khoản đã tồn tại";
    }
    public function tinhTongSP(){
        $username = $this->cookies->get('username');
        $temp = Chitietgiohang::find("username ='$username'")->toArray();
        $tong=0;
        foreach ($temp as $x){
            $tong = $tong+$x['soLuong'];
        }
        $this->cookies->set(
            'slsp',
            $tong,
            time() +43200
        );
        return $tong;
    }
    public function addSPAction(){
        $this->view->disable();
        $maSP = $_GET['maSP'];
        $username = $this->cookies->get('username');
        $dataCheck= Chitietgiohang::findFirst("username=" . '"'.$username.'"' . " and maSP=" . '"'.$maSP.'"' );
        $data = Sanpham::findFirst("maSP = '$maSP'")->toArray();
        if ($dataCheck){
            $temp =$dataCheck->toArray();
            $STT = $temp['STT'];
            $soLuong= $temp['soLuong'];
            $soLuong++;
            $chiTietGioHang= array(
                'STT'=>$STT,
                'username'=>$username,
                'maSP' => $maSP,
                'tenSP'=> $data['tenSP'],
                'gia'=>$data['gia'],
                'soLuong'=>$soLuong,
                'tongTien'=>$soLuong*$data['gia']
            );
            $ctgd = new Chitietgiohang();
            $ctgd->save($chiTietGioHang);

        }else{
            $chiTietGioHang= array(
                'username'=>$username,
                'maSP' => $maSP,
                'tenSP'=> $data['tenSP'],
                'gia'=>$data['gia'],
                'soLuong'=>1,
                'tongTien'=>$data['gia']
            );
            $ctgd = new Chitietgiohang();
            $ctgd->save($chiTietGioHang);
        }
        $tong = $this->tinhTongSP();
        echo $tong;
    }
    public function xoaSPAction(){
        $maSP=$_GET['maSP'];
        $username = $this->cookies->get('username');
        $SPXoa= Chitietgiohang::findFirst("username=" . '"'.$username.'"' . " and maSP=" . '"'.$maSP.'"' );
        $SPXoa->delete();
        $this->tinhTongSP();
        header("location: http://localhost/foodanddrink/giohang/show");
    }
    public function donHangAction(){
        $trangThai=$_GET['tt'];
        $page = $_GET['page'];
        $start = ($page-1)*15;
        $username = $this->cookies->get('username');
        if ($trangThai == "all"){
            $data = Donhang::find([
                "username='$username'",
                'order' => 'ngayGiao DESC',
                'offset' => $start,
                'limit'=>15
            ])->toArray();
        }else{
            $data = Donhang::find([
                "username=" . '"'.$username.'"' . " and trangThai=" . '"'.$trangThai.'"',
                'order' => 'ngayGiao DESC',
                'offset' => $start,
                'limit'=>15
            ] )->toArray();
        }
        $this->view->setVar("data",$data);
        $listSanPham=array();
        $i=0;
        foreach ($data as $x){
            $maDonHang = $x['maDonHang'];
            $listSanPham[$i]= Chitietdonhang::find("maDonHang='$maDonHang'")->toArray();
            $i++;
        }
        $this->view->setVar("listSanPham",$listSanPham);
        $this->view->setVar("tt",$trangThai);
        $this->view->setVar("page",$page);
    }
    public function muaHangAction(){
        $username = $this->cookies->get('username');
        $this->view->disable();
        $post =$this->request->getPost();
        $diaChi="";
        if (strlen($post['diaChi'])>0){
            $diaChi= $post['diaChi'];
        }else{
            $dataUser= Users::findFirst("username ='$username'")->toArray();
            $diaChi= $dataUser['diaChi'];
        }
        if (strlen($diaChi)<=10){
            header('location: http://localhost/foodanddrink/giohang/xacNhanDon');
        }

        $data = Chitietgiohang::find("username ='$username'")->toArray();
        $tongTien=0;
        foreach ($data as $x){
            $tongTien= $tongTien+ $x['tongTien'];
        }
        $allC="0123456789abcdefghijklmnopqrstuvwxyz";
        $maDonHang="";
        while (true){
            $maDonHang=$username."_".substr(str_shuffle($allC), 0, 10);
            if (!Donhang::findFirst("maDonHang='$maDonHang'")){
                break;
            }
        }
        $donHang=array(
            'maDonHang'=> $maDonHang,
            'username'=>$username,
            'tongTien'=>$tongTien,
            'trangThai'=>"cho",
            'diaChi'=> $diaChi
        );
        $dh = new Donhang();
        if (!$dh->save($donHang)){
            echo "Thất bại";
        }else{
            foreach ($data as $x){
                $ctDonHang=array(
                    'maDonHang'=>$maDonHang,
                    'tenSP'=>$x['tenSP'],
                    'soLuong'=>$x['soLuong'],
                    'gia'=>$x['gia'],
                );
                $ct = new Chitietdonhang();
                $ct->save($ctDonHang);
            }
            header('location:http://localhost/foodanddrink/users/donhang?tt=all&page=1');
        }
    }
    public function updateSLSPAction(){
        $this->view->disable();
        $maSP=$_GET['maSP'];
        $soLuong=$_GET['soLuong'];
        $username = $this->cookies->get('username');
        $data = Chitietgiohang::findFirst("username=" . '"'.$username.'"' . " and maSP=" . '"'.$maSP.'"' )->toArray();
        $dataNew = array(
            'STT'=>$data['STT'],
            'username'=>$data['username'],
            'maSP'=>$data['maSP'],
            'tenSP'=>$data['tenSP'],
            'gia'=>$data['gia'],
            'soLuong'=>$soLuong,
            'tongTien'=>$soLuong*$data['gia'],
        );
        $ctgh = new Chitietgiohang();
        if ($ctgh->save($dataNew)){
            $temp = Chitietgiohang::find("username ='$username'")->toArray();
            $tongTien=0;
            foreach ($temp as $x){
                $tongTien=$tongTien+$x['tongTien'];
            }
            echo $tongTien;
            $this->tinhTongSP();
        }else{
            echo "Có lỗi !!";
        }
    }
    public function chitietdonhangAction(){
        $maDonHang = $_GET['maDonHang'];
        $data = Chitietdonhang::find("maDonHang = '$maDonHang'")->toArray();
        $this->view->setVar("data",$data);

        $temp = Donhang::findFirst("maDonHang='$maDonHang'")->toArray();
        $username = $temp['username'];
        $dataUser= Users::findFirst("username='$username'")->toArray();
        $ttNguoiNhan = array(
            'hoTen'=> $dataUser['hoTen'],
            'sdt'=>$dataUser['sdt'],
            'diaChi'=>$temp['diaChi'],
        );
        $this->view->setVar("ttNguoiNhan",$ttNguoiNhan);
    }

    public function datbanAction(){
        $trangThai=$_GET['tt'];
        $page = $_GET['page'];
        $start = ($page-1)*15;
        $username = $this->cookies->get('username');
        if ($trangThai == "all"){
            $data = Datban::find([
                "username='$username'",
                'order' => 'thoiGian DESC',
                'offset' => $start,
                'limit'=>15
            ])->toArray();
        }else{
            $data = Datban::find([
                "username=" . '"'.$username.'"' . " and trangThai=" . '"'.$trangThai.'"',
                'order' => 'thoiGian DESC',
                'offset' => $start,
                'limit'=>15
            ] )->toArray();
        }
        $this->view->setVar("data",$data);
        $this->view->setVar("tt",$trangThai);
        $this->view->setVar("page",$page);
    }

}