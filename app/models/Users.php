<?php
    class Users extends \Phalcon\Mvc\Model
    {
        private $stt=0;
        private $username="";
        private $password="";
        private $hoTen="";
        private $gioiTinh="";
        private $namSinh;
        private $sdt="";
        private $email="";

        public function maHoaMK($passRaw){
            $password = md5($passRaw);
            return $password;
        }
        public function kiemTra($user, $listUsers){
            foreach ($listUsers as $x){
                if ($x === $user){
                    return false;
                    break;
                }
            }
            return true;
        }

    }