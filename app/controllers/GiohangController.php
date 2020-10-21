<?php


class GiohangController extends ControllerBase
{
    public function onConstruct()
    {
        parent::onConstruct(); // TODO: Change the autogenerated stub
    }

    public function indexAction() {
        if ($this->cookies->has("login-action")) {
            // Get the cookie
            $loginCookie = $this->cookies->get("login-action");

            // Get the cookie's value
            $value = $loginCookie->getValue();
            echo($value);
        }
        $this->cookies->set(
            "login-action",
            "abc",'a',
            time() + 15 * 86400
        );
    }
    public function showDropDownAction(){
        $this->view->setRenderLevel(1);
        $username =$this->cookies->get('username');
        $data = Chitietgiohang::find("username='$username'")->toArray();
        $listSanPham=array();
        $i=0;
        foreach ($data as $x){
            $maSP = $x['maSP'];
            $listSanPham[$i] = Sanpham::findFirst("maSP ='$maSP'")->toArray();
            $i++;
        }
        $this->view->setVar("data",$listSanPham);
    }
    public function showAction(){
        $this->assets->addCss('css/giohang.css');
        $this->assets->addJs('http://localhost:3000/socket.io/socket.io.js', false);
        $username=$this->cookies->get('username');
        $data = Chitietgiohang::find("username='$username'")->toArray();
        $listSanPham=array();
        $i=0;
        $tongTien=0;
        foreach ($data as $x){
            $maSP = $x['maSP'];
            $sanPham =Sanpham::findFirst("maSP ='$maSP'")->toArray();
            $listSanPham[$i] = array(
                'hinhAnh' => $sanPham['hinhAnh'],
                'tenSP' => $sanPham['tenSP'],
                'maSP' => $x['maSP'],
                'gia' => $sanPham['gia'],
                'soLuong' => $x['soLuong'],
                'thanhTien' => $x['tongTien'],
            );
            $i++;
            $tongTien=$tongTien+(int)$sanPham['gia']*$x['soLuong'];
        }
        $this->view->setVar("tongTien",$tongTien);
        $this->view->setVar("listSanPham",$listSanPham);
    }
    public function xacNhanDonAction(){
        $this->assets->addJs('http://localhost:3000/socket.io/socket.io.js', false);
        $username =$this->cookies->get('username');
        $data = Chitietgiohang::find("username='$username'")->toArray();
        $this->view->setVar("data",$data);

        $dataUser = Users::findFirst("username = '$username'")->toArray();
        $this->view->setVar("dataUser",$dataUser);
    }
//    public function addAction(){
//        $maSP = $_GET['maSP'];
//        $data = Sanpham::findFirst("maSP='$maSP'")->toArray();
//        $maGioHang = "giohang_".$this->cookies->get('username');
//
//        echo $maGioHang;
//        var_dump($data);
//    }
}