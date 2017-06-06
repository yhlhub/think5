<?php

namespace app\admin\controller;
use think\Db;
use think\Controller;
use think\Request;
use app\admin\model\Column as ColumnModel;
class Column extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $lit=ColumnModel::paginate(3);
        $catename=Db::name('Column')->select();
        $this->assign('lit',$lit);
        $this->assign('catename',$catename);
        return $this->fetch('lit');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return $this->fetch('add');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save()
    {
        if(request()->isPost())
        {
            $data['catename']=input('username');
            if($data['catename']==null) return $this->error('请输入栏目名称');
            $username=Db::name('Column')->find();
            if($username['catename']==$data['catename']) return $this->error('栏目已存在');

            if(Db::name('Column')->insert($data))
            {
                return $this->success('添加栏目成功','Column/index');
            }
        }
        return $this->error('添加失败');
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $catename=Db::name('Column')->where('id',$id)->find();
        $this->assign('catename',$catename);
        return $this->fetch('edit');
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update($id)
    {
        if(!$id)  $this->error('错误');
            
        if(request()->isPost())
        {
            $username=trim(input('title'));

            if(!$username) return $this->error('栏目名称不能为空');
            
            $user=Db::name('Column')->where('id',$id)->find();
            
            if($user && ($user['catename']==$username  || Db::name('Column')->where('id',$id)->setField('catename',$username)))
            {
                return $this->success('修改成功','Column/index');
            }
            
        }
        return $this->error('修改失败');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        if(!$id) return $this->error('错误');
        $del=Db::name('Column')->where('id',$id)->delete();
        if($del){
            return $this->success('删除成功','Column/index');
        }else{
            return $this->error('删除失败');
        }
    }
}
