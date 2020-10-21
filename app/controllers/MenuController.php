<?php


class MenuController extends ControllerBase
{
    public function indexAction(){
        if (isset($_GET['timKiem'])){
            $timKiem = $_GET['timKiem'];
            if (isset($_GET['page'])){
                $page = $_GET['page'];
            }else{
                $page =1;
            }
            $this->search($timKiem,$page);
        }else{
            if (isset($_GET['phanloai'])){
                $phanloai = $_GET['phanloai'];
                if (isset($_GET['page'])){
                    $page = $_GET['page'];
                }else{
                    $page =1;
                }
                $this->phanloai($phanloai,$page);
            }else{
                $start=0;
                if (isset($_GET['page'])){
                    $page = $_GET['page'];
                    $start=($page-1)*18;
                    $this->view->setVar('page',$page);
                }else{
                    $this->view->setVar('page',1);
                }
                $data = Sanpham::find([
                    'offset'=>$start,
                    'limit' => 18,
                ])->toArray();
                $this->view->setVar("data",$data);
            }
        }
    }
    public function pageAction(){
        $page =$_GET['id'];
//        $batdau = ($page-1)*18;
        $batdau=0;
        $data = Sanpham::find([
            'offset'=>$batdau,
            'limit' => 18,
        ])->toArray();
        $this->view->setVar('page',$page);
        $this->view->setVar('data',$data);
    }
    public function search($noiDungTK, $pageNumber){
        $timKiem = $noiDungTK;
        $start=0;
        $page = $pageNumber;
        $start= ($page-1)*18;
        $data = Sanpham::find([
            'conditions' => "tenSP LIKE '%$timKiem%'",
            'offset' => $start,
            'limit' => 18,
        ])->toArray();
        $this->view->setVar("tem","timKiem=".$timKiem."&");
        $this->view->setVar("page",$page);
        $this->view->setVar("data",$data);
    }
    public function phanloai($phanloai, $pageNumber){
        $phanLoai=$phanloai;
        $phanLoai= trim($phanLoai);
        $page = $pageNumber;
        $start = ($page -1)*18;
        $data = Sanpham::find([
            'conditions' => "loai LIKE '%$phanLoai%'",
            'offset' => $start,
            'limit' => 18,
        ])->toArray();
        $this->view->setVar("tem","phanloai=".$phanLoai."&");
        $this->view->setVar("page",$page);
        $this->view->setVar("data",$data);
    }
}