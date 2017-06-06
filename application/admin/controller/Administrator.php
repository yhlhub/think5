<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Administrator extends Controller
{
	public function lit()
	{
		$db=\think\Db::name('user')->select();
		$this->assign('db',$db);
		return $this->fetch('lit');
	}
	public function creat()
	{
		return $this->fetch('add');
	}
	public function save()
	{
		if(request()->isPost())
		{
			$data=[
				'username'=>input('username'),
				'password'=>input('password'),	
			];

			$validate = \think\Loader::validate('Admin');
			
			if(!$validate->scene('add')->check($data))
			{
			   $this->error($validate->getError());
			}
			$username=Db::name('user')->find();
			if($username['username']==$data['username']) return $this->error('用户已存在');
			$data['password'] = md5($data['password']);

			if(Db::name('user')->insert($data))
			{
				return $this->success('添加成功','Administrator/lit');
			}
		}
		return $this->error('添加失败');
	}
	public function edit($id)
	{
		$uname=\think\Db::name('user')->where('id',$id)->find();
		$this->assign('db',$uname);
		return $this->fetch('edit');
	}
	public function update($id)
	{
		if(!$id)  $this->error('错误');
			
		if(request()->isPost())
		{
			$username=trim(input('sort'));

			if(!$username) return $this->error('用户名不能为空');
			
			$user=Db::name('user')->where('id',$id)->find();
			
			if($user && ($user['username']==$username  || Db::name('user')->where('id',$id)->setField('username',$username)))
			{
				return $this->success('修改成功','Administrator/lit');
			}
			
		}
		return $this->error('修改失败');
	}
	public function delete($id)
	{
		if(!$id)  $this->error('错误');
		$res=Db::name('user')->where('id',$id)->delete();
		if($res) return $this->success('删除成功','Administrator/lit');
		return $this->error('删除失败');
	}
	public function fet()
	{
		return $this->fetch('Public/base');
	}
}