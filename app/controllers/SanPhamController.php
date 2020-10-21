<?php
class SanPhamController extends ControllerBase{
    public function addAction(){
        if (isset($_POST['themSP'])){
            $post = $this->request->getPost();

            $this->view->setVar("post",$post);
            $this->view->setVar("anh",$_FILES['fileHinhSP']);
            $name= $_FILES['fileHinhSP']["name"];
            var_dump($_FILES['fileHinhSP']);
            move_uploaded_file(
                $_FILES['fileHinhSP']['tmp_name'],
                "files/anhsp/$name"
            );

            $data = array(
                'maSP'=> $post['txtMaSP'],
                'tenSP'=> $post['txtTenSP'],
                'loai'=> $post['txtLoaiSP'],
                'hinhAnh'=>$name,
                'moTa'=> $post['txtMoTa'],
                'gia'=>(int)$post['txtGiaSP']
            );
            $sanPham = new Sanpham();
            if ($sanPham->save($data)){
                $this->view->setVar('kq',"Thanh Cong");
            }else{
                $this->view->setVar('kq',"Thai bai");
            }
        }
    }
    public function editAction(){
        $maSP  = $_GET['maSP'];
        $data = Sanpham::findFirst("maSP='$maSP'")->toArray();
        $this->view->setVar("data",$data);
        if (isset($_POST['editSP'])){
            $post = $this->request->getPost();
            $name= $_FILES['fileHinhSP']["name"];
            if (strlen($name)>0){
                $nameIMG = $name;
            }else{
                $nameIMG = $data['hinhAnh'];
            }
            $this->view->setVar('anh',$_FILES['fileHinhSP'] ["error"]);
            $dataNew = array(
                'maSP'=> $data['maSP'],
                'tenSP'=> $post['txtTenSP'],
                'loai'=> $post['txtLoaiSP'],
                'hinhAnh'=>$nameIMG,
                'moTa'=> $post['txtMoTa'],
                'gia'=>(int)$post['txtGiaSP']
            );
            $sanPham = new Sanpham();
            if ($sanPham->save($dataNew)){
                move_uploaded_file(
                    $_FILES['fileHinhSP']['tmp_name'],
                    "files/anhsp/$nameIMG"
                );
                $this->view->setVar('kq',"Thanh Cong");
            }else{
                $this->view->setVar('kq',"Thai bai");
            }
        }
    }
    public function showAllAction(){
//        $start = ($page-1)*20;
        $data = Users::find([
            'offset'=>0,
            'limit' => 10,
        ])->toArray();
        var_dump($data);
//        $this->view->setVar($data);
    }
    public function searchAction(){
        echo __FUNCTION__;
    }
}