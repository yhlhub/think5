<?php
namespace app\admin\controller;
use think\Controller;
class Login extends Controller{
	public function index(){
		return $this->fetch('login');
	}
	public function login(){
		if(request()->isPost()){
			$data=[
				'username'=>input('username'),
				'password'=>input('password'),	
			];
			$validate = \think\Loader::validate('Admin');
			if(!$validate->scene('add')->check($data)){
			   $this->error($validate->getError()); die;
			}
			
			$data['password'] = md5($data['password']);

			$db=\think\Db::name('user')->where('username','=',$data['username'])->find();
			if($db){
				if($db['password']==$data['password']){
					session('username',$data['username']);
					return $this->success('登录成功','Index/index');
				}else{
					return $this->error('密码错误');
				}
			}else{
				return $this->error('用户不存在');
			}
		}
	}
	public function logout(){
		session('username',null);
		session('[destroy]');
		return $this->success('退出成功','Login/index');
	}

}