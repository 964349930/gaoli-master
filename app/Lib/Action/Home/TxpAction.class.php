<?php
/**
 * 图文回复控制器
 */
class TxpAction extends HomeAction
{

    /**
     * ls
     */
    public function ls()
    {

        //搜索
        $map = array();
        if (IS_POST) {
           $search = $this->_post('search');
        }       
        if($search){
            $map['keyword'] = array('like',"%{$search}%");
        }

        $fid = intval($_GET['fid']);
        $map['fid'] = array('eq', $fid);
        //分页
        $count = D('Txp')->where($map)->count();
        $page = page($count, 10);
        

        $list = D('Txp')->where($map)->limit($page->firstRow, $page->listRows)->select();
        foreach($list as $k=>$v){
            $routeMap['obj_type'] = array('eq', 'txp');
            $routeMap['obj_id'] = array('eq', $v['id']);
            $list[$k]['keyword'] = D('Route')->where($routeMap)->getField('keyword');
        }
        //print_r(D('Article')->getLastSQL());

        $this->assign('fid', $fid);
        $this->assign('list', $list);
        $this->assign('pages', $page->show());
        $this->display();
    }

    /**
     * add 
     */
    public function add()
    {
        $fid = intval($_GET['fid']);
        $this->assign('fid', $fid);
        $this->display();
    }
    /**
     * add
     */
    public function doAdd()
    {
        $keyword = trim($_POST['keyword']);
        $data = $_POST;
        $id = D('Txp')->add($data);
        $route['keyword'] = $keyword;
        $route['obj_type'] = 'txp';
        $route['obj_id'] = $id;
        D('Route')->add($route);
        $this->success('添加成功');
    }

    /**
     * edit
     */
    public function edit()
    {
        $id = intval($_GET['id']);
        $info = D('Txp')->where('id='.$id)->find();
        $map['obj_type'] = array('eq', 'txp');
        $map['obj_id'] = array('eq', $id);
        $routeInfo = D('Route')->where($map)->find();
        $this->assign('info', $info);
        $this->assign('routeInfo', $routeInfo);
        $this->display();
    }

    /**
     * doEdit
     */
    public function doEdit()
    {
        $id = intval($_POST['id']);
        $route_id = intval($_POST['route_id']);
        $keyword = trim($_POST['keyword']);
        $data = $_POST;
        D('Txp')->where('id='.$id)->save($data);
        D('Route')->where('id='.$route_id)->setField('keyword', $keyword);
        $this->success('更新成功');
    }
    
    public function del(){
        $delIds = array();
        $postIds = $this->_post('id');
        if (!empty($postIds)) {
            $delIds = $postIds;
        }
        $getId = intval($this->_get('id'));
        if (!empty($getId)) {
            $delIds[] = $getId;
        }
        if (empty($delIds)) {
            $this->error('请选择您要删除的关键字');
        }
        $map['id'] = $fmap['fid'] = array('in', $delIds);
        if(D('Txp')->where($map)->delete()){
            $ids = D('Txp')->where($fmap)->getField('id', true);
            $ids = array_merge($ids, $delIds);

            $routeMap['obj_id'] = array('in', $ids);
            D('Txp')->where($fmap)->delete();
            $routeMap['obj_type'] = array('eq', 'txp');
            D('Route')->where($routeMap)->delete();
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

}
