<?php
/**
 * 路由控制器
 */
class RouteAction extends HomeAction
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

        //分页
        $count = D('Route')->where($map)->count();
        $page = page($count, 5);
        

        $list = D('Route')->where($map)->limit($page->firstRow, $page->listRows)->select();
        //print_r(D('Article')->getLastSQL());

        $this->assign('list', $list);
        $this->assign('pages', $page->show());
        $this->display();
    }

    /**
     * info
     */
    public function info()
    {
        $obj = D('Route');
        if(empty($_POST)){
            $id = $this->_get('id');
            if(!empty($id)){
                $info = $obj->where('id='.$id)->find();
                $this->assign('info', $info);
            }
            $this->display();
            exit;
        }
        
        $data = $this->_post();    
        if(empty($data['id'])){
            $obj->add($data);
        }else{
            $obj->save($data);
        }

        $this->success('操作成功');

        
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
        $arrMap['id'] = array('in', $delIds);
        if(D('Route')->where($arrMap)->delete()){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

}
