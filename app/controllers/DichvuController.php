<?php
class DichvuController extends ControllerBase{
    public function datbanAction(){
        $this->assets->addJs('http://localhost:3000/socket.io/socket.io.js', false);
        $post = $this->request->getPost();

        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $min = date('Y-m-d')." 00:00:00";
        $max = date('Y-m-d')." 23:59:59";
        $dataDB = Datban::find("thoiGian > '$min' AND thoiGian <'$max'")->toArray();
        $soBanDaDat=0;
        foreach ($dataDB as $x){
            if ($x['soNguoi']<=4){
                $soBanDaDat++;
            }else{
                if ($x['soNguoi']%4 ==0){
                    $soBanDaDat =(int)($soBanDaDat+$x['soNguoi']/4);
                }else{
                    $soBanDaDat =(int)($soBanDaDat+$x['soNguoi']/4+1);
                }
            }
        }
        if($soBanDaDat >=30){
            $this->view->setVar("ketQua","Rất xin lỗi bạn! Số lượng bàn đã được đặt hết.");
            return 0;
        }

        if (isset($post['btnDatBan'])){
            $username=$this->cookies->get("username")->getValue();

            $allC="0123456789abcdefghijklmnopqrstuvwxyz";
            $maDatBan="";
            while (true){
                $maDatBan=$username."_datban_".substr(str_shuffle($allC), 0, 10);
                if (!datban::findFirst("maDatBan='$maDatBan'")){
                    break;
                }
            }

            $gio = $post['gio'];
            if (strlen($gio)>0){
                $s = substr($gio,strlen($gio)-2,2);
                if ($s == "PM"){
                    $temp= explode(":",$gio);
                    $h = (int)$temp[0]+12;
                    $gio=$h.":".substr($temp[1],0,strlen($temp[1])-3);
                }else{
                    $gio=substr($gio,0,strlen($gio)-3);
                }
            }else{
                $this->view->setVar("ketQua","Thất bại! Bạn chưa chọn thời gian.");
                return 0;
            }
            if (strlen($post['ngay'])<=0){
                $this->view->setVar("ketQua","Thất bại! Bạn chưa chọn thời gian.");
                return 0;
            }
            $thoiGian=$post['ngay']." ".$gio;
            $temp = explode('/',$post['ngay']);
            $temp1 = explode(':',$gio);
            $tempTime = array(
                'year' => $temp[0],
                'mon' => $temp[1],
                'mday' => $temp[2],
                'hours' => $temp1[0],
                'minutes'=>$temp1[1],
                'seconds'=>$temp1[2],
            );
            $n=getdate();
            if ($n['hours'] < 11){
                $n['hours'] = $n['hours']+1;
            }
            $stringTime1 = $n['year']."/".$n['mon']."/".$n['mday']." ".$n['hours'].":".$n['minutes'].":".$n['seconds'];
            $intTime1 = strtotime($stringTime1);
            $now=date('Y-m-d h:i:s',$intTime1);

            $stringTime = $tempTime['year']."/".$tempTime['mon']."/".$tempTime['mday']." ".$tempTime['hours'].":".$tempTime['minutes'].":00";
            $intTime = strtotime($stringTime);
            $day=date('Y-m-d H:i:s',$intTime);
            if ($now > $day){
                $this->view->setVar("ketQua","Thất bại! Thời gian đặt phải lớn hơn thời gian hiện tại 1h.".$day);
                return 1;
            }else{
                $this->view->setVar("ketQua","");
            }

            $n=getdate();
            $stringTime1 = $n['year']."-".$n['mon']."-".$n['mday'];
            $now=date_create($stringTime1);
            $a= date_modify($now, "+30 days");
            $ngayMax=date_format($a, "Y/m/d h:i:s");
            $intTime = strtotime($ngayMax);
            $ngayMax=date('Y-m-d',$intTime);
            if ($day > $ngayMax){
                $this->view->setVar("ketQua","Thất bại! Thời gian đặt trước tối đa là 30 ngày (tối đa ".$ngayMax.").");
                return 1;
            }
            $stringTimeMax = $tempTime['year']."/".$tempTime['mon']."/".$tempTime['mday']." "."23:00:00";
            $timeMax = date('Y-m-d H:i:s',strtotime($stringTimeMax));
            $stringTimeMin = $tempTime['year']."/".$tempTime['mon']."/".$tempTime['mday']." "."06:30:00";
            $timeMin = date('Y-m-d H:i:s',strtotime($stringTimeMin));
            if ($day>= $timeMax || $day <= $timeMin){
                $this->view->setVar("ketQua","Thất bại! Khoảng thời gian đặt bàn phải từ 6:31 đến 22:59!".$day);
                return 1;
            }

            $data = array(
                'maDatBan'=>$maDatBan,
                'username'=>$username,
                'soNguoi'=>$post['soNguoi'],
                'thoiGian'=>$thoiGian,
                'trangThai'=>'cho'
            );
            $datBan = new Datban();
            if ($datBan->save($data)){
                $this->view->setVar("ketQua","Chúc mừng! Bạn đã đặt bàn thành công.");
            }else{
                $this->view->setVar("ketQua","Thất bại! Bạn cần nhập đầy đủ thông tin.");
            }
            $this->view->setVar("data",$thoiGian);
        }


    }
}