<?php
/**
 * 新闻控制器
 */
class NewsAction extends HomeAction
{

    /**
     * get Tpl list
     */
    private function get_type_list()
    {
        $list = D('Newstype')->select();
        return $list;
    }

    /**
     * ls
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
        if(IS_POST){
            $search = $this->_post('search');
        }
        if($search){
            $map['title'] = array('like',"%{$search}%");
        }
        //分页
        $obj = D('News');
        $count = $obj->count();
        $page = page($count, 5);
        
        $list = D('News')->where($map)->order($sort)->limit($page->firstRow, $page->listRows)->select();
        
        $this->assign('list', $list);
        $this->assign('pages', $page->show());
        $this->display();
    }

    /**
     * display add news view
     */
    public function addNews(){
        $this->assign('typeList', $this->get_type_list());
        $this->display();
    }
    /**
     * do add news
     */
    public function doAddNews(){
        $data = $_POST;
        $data['time_add'] = $data['time_modify'] = time();
        $result = D('News')->add($data);
        if(!empty($result)){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }
    /**
     * display update news view 
     */
    public function updateNews(){
        $id = intval($_GET['id']);
        $info = D('News')->where('id='.$id)->find();
        $this->assign('info', $info);
        $this->assign('typeList', $this->get_type_list());
        $this->display();
    }
    /**
     * do update news
     */
    public function doUpdateNews(){
        $data = $_POST;
        $data['time_modify'] = time();
        $result = D('News')->save($data);
        if(!empty($result)){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
    }
    /**
     * info
     */
    public function info()
    {
        $obj = D('News');
        if(empty($_POST)){
            $id = $this->_get('id');
            if(!empty($id)){
                $info = $obj->where('id='.$id)->find();
                $pid = $info['pid'];
                $this->assign('info', $info);
            }else{
                $pid = $this->_get('pid');
            }
            
            $this->assign('typeList', $this->get_type_list());
            $this->assign('pid', $pid);
            $this->display();
            exit;
        }

        $data = $this->_post();

        $data['time_modify'] = time();
        if(empty($data['id'])){
            $obj->add($data);
            $data['time_add'] = time();
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
        $result = D('News')->where($map)->delete();
		if(!empty($result)){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}

}
