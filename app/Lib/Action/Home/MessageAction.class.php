<?php
/**
 * 留言控制器
 */
class MessageAction extends HomeAction
{

    /**
     * 获取留言列表
     */
    public function ls()
    {
        //排序
        if(!empty($_GET['sort'])){
            if($_GET['type'] == '1'){
                $type = 'asc';
                $type_num = '0';
            }else{
                $type = 'desc';
                $type_num = '1';
            }
            $sort = $_GET['sort'].' '.$type;
            $this->assign('type', $type_num);
        }else{
            $sort = 'id desc';
            $this->assign('type', '1');
        }

        //搜索
        $map = array();
        
        if (IS_POST) {
           $search = $this->_post('search');
        }       
        if($search){
            $map['username|usertel'] = array('like',"%{$search}%");
        }
        //分页
        $obj = D('Message');
        $count = $obj->count();
        $page = page($count, 5);
        
        $list = D('Message')->where($map)->order($sort)->limit($page->firstRow, $page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('pages', $page->show());
        $this->display();
    }


    /**
     * info
     */
    public function info()
    {
        $obj = D('Message'); 
        
        if(empty($_POST)){
            $id = $this->_get('id');
            $username = $this->_get('username');
            if(!empty($id)){
                $info = $obj->where('id='.$id)->find();
                $this->assign('info', $info);
            }
            if(!empty($username)){
                $info = $obj->where('username'.$username)->find();
                $this->assign('info',$info);
            }
            if(!empty($uertel)){
                $info = $obj->where('usertel'.$usertel)->find();
                $this->assign('info',$info);
            }

            $this->display();
            exit;
        }

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
            $this->error('请选择您要删除的留言');
        }
        $arrMap['id'] = array('in', $delIds);
        if(D('Message')->where($arrMap)->delete()){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

}
