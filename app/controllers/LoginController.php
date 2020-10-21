<?php


class LoginController extends ControllerBase
{
    public function indexAction(){
        $username =$this->cookies->get('username');
        $password =$this->cookies->get('password');
        $this->view->setVar('kq',"ok");
        if (strlen($username >0 && strlen($password)>0)){
            $dataCheck=Users::findFirst("username= '$username'")->toArray();
            if ($dataCheck["password"] == $password){
                $this->view->setVar('kq',"da dn");
                header('location: http://localhost/foodanddrink');
            }

        }
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
                header('location: http://localhost/foodanddrink');
            }else{
                $dataAdmin=admin::find("username='$username'")->toArray();
                if ($password == $dataAdmin[0]['password']){
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
                    header('location: http://localhost/foodanddrink');
                }else{
                    $this->view->setVar('ketQua',"Tài khoản hoặc mật khẩu không chính xác");
                }
            }
        }
    }

}