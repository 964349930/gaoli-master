<?php
/**
 * 文章模版控制器
 */
class PPTypeAction extends HomeAction
{
    /**
     * ls
     */
    public function ls()
    {
        $list = D('Powerpointtype')->select();
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * info
     */
    public function info()
    {
        $obj = D('Powerpointtype');
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
        $data['time_modify'] = time();
        $id = $this->_post('id');
        if(empty($id)){
            $data['time_add'] = time();
            $obj->add($data);
        }else{
            $obj->save($data);
        }
        $this->success('操作成功');
    }

    public function del(){
        //删除的ID的数组
        $delIds = array();

        //POST方法删除的ID，批量删除的ID
        $postIds = $this->_post('id');
        if (!empty($postIds)) {
            $delIds = $postIds;
        }

        //GET方法删除
        //trim
        $getId = intval($this->_get('id'));
        if (!empty($getId)) {
            $delIds[] = $getId;
        }

        //判断是否为空
        if (empty($delIds)) {
            $this->error('请选择您要删除的新闻');
        }

        $map['id'] = array('in', $delIds);
        $result = D('Powerpointtype')->where($map)->delete();
        if(!empty($result)){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

}

?>
