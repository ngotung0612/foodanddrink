<?php

class IndexController extends ControllerBase
{
    public function onConstruct(){
        parent::onConstruct();
    }
    public function indexAction()
    {
        header('location: http://localhost/foodanddrink/menu');
        $data = Sanpham::find([
            'offset'=>0,
            'limit' => 18,
        ])->toArray();
//        var_dump($data);
        $this->view->setVar("data",$data);
    }
    public function testAction(){
    }
    public function showAction(){

    }
}

