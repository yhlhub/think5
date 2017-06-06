<?php
namespace app\admin\controller;
use think\Controller;
class Index extends Controller{
	public function index(){
		$title="首页";
		$this->assign('title',$title);
		return $this->fetch();
	}
}
?>