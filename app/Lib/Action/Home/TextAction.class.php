<?php
/**
 * 文本回复控制器
 */
class TextAction extends HomeAction
{

    /**
     * ls
     */
    public function ls()
    {
        //搜索
        $map = array();
        //IS_POST 当前是否POST请求
        if (IS_POST) {
           $search = $this->_post('search');
        }       
        if($search){
            $map['content'] = array('like',"%{$search}%");
        }

        //分页
        $count = D('Text')->where($map)->count();
        $page = page($count, 5);
        

        $list = D('Text')->where($map)->limit($page->firstRow, $page->listRows)->select();
        foreach($list as $k=>$v){
            $map['obj_type'] = array('eq', 'text');
            $map['obj_id'] = array('eq', $v['id']);
            $list[$k]['keyword'] = D('Route')->where($map)->getField('keyword');
        }
        //print_r(D('Article')->getLastSQL());

        $this->assign('list', $list);
        $this->assign('pages', $page->show());
        $this->display();
    }

    /**
     * add text
     */
    public function doAdd()
    {
        $keyword = trim($_POST['keyword']);
        $content = trim($_POST['content']);
        $id = D('Text')->add(array('content'=>$content));
        $data['keyword'] = $keyword;
        $data['obj_type'] = 'text';
        $data['obj_id'] = $id;
        $result = D('Route')->add($data);
        $this->success('添加成功');
    }

    /**
     * edit html
     */
    public function edit()
    {
        $id = intval($_GET['id']);
        $info = D('Text')->where('id='.$id)->find();
        $map['obj_type'] = array('eq', 'text');
        $map['obj_id'] = array('eq', $id);
        $routeInfo = D('Route')->where($map)->find();
        $this->assign('info', $info);
        $this->assign('routeInfo', $routeInfo);
        $this->display();
    }

    /**
     * do edit
     */
    public function doEdit()
    {
        $id = intval($_POST['id']);
        $route_id = intval($_POST['route_id']);
        $keyword = trim($_POST['keyword']);
        $content = trim($_POST['content']);
        D('Text')->where('id='.$id)->setField('content', $content);
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
        $map['id'] = $routeMap['obj_id'] = array('in', $delIds);
        $routeMap['obj_type'] = array('eq', 'text');
        if(D('Text')->where($map)->delete()){
            D('Route')->where($routeMap)->delete();
            $this->success('删除成功',U('Text/ls'));
        }else{
            $this->error('删除失败');
        }
    }

}
