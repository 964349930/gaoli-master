<?php
/**
 * 文章控制器
 */
class ArticleAction extends HomeAction
{

    /**
     * import data
     */
    public function importData()
    {
        $url = 'http://weixin.d-bluesoft.com/index.php?g=Admin&m=Public&a=exportData';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        foreach($result as $k=>$v){
            D('Article')->add($v);
        }
    }

    /**
     * get tpl list
     */
    private function get_tpl_list()
    {
        $list = D('Tpl')->select();
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
        if (IS_POST) {
           $search = $this->_post('search');
        }       
        if($search){
            $map['title'] = array('like',"%{$search}%");
        }

        $pid = $this->_get('pid');
        $pid = ($pid) ? $pid : '0';
        $map['pid'] = array('eq', $pid);

        //分页
        $count = D('Article')->where($map)->count();
        $page = page($count, 5);
        

        $list = D('Article')->where($map)->order($sort)->limit($page->firstRow, $page->listRows)->select();
        //print_r(D('Article')->getLastSQL());

        $this->assign('list', $list);
        $this->assign('pages', $page->show());
        $this->assign('pid', $pid);
        $this->display();
    }

    /**
     * info
     */
    public function info()
    {
        $obj = D('Article');
        if(empty($_POST)){
            $id = $this->_get('id');
            if(!empty($id)){
                $info = $obj->where('id='.$id)->find();
                $pid = $info['pid'];
                $this->assign('info', $info);
            }else{
                $pid = $this->_get('pid');
            }
            $this->assign('tplList', $this->get_tpl_list());
            $this->assign('pid', $pid);
            $this->display();
            exit;
        }
        $data = $this->_post();
        if(!empty($_FILES['pic']['name'])){
            $picList = uploadPic();
            if($picList['code'] != 'error'){
                $data['cover'] = $picList['pic']['savename'];
            }
        }
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
            $this->error('请选择您要删除的文章');
        }
        $arrMap['id'] = array('in', $delIds);
        if(D('Article')->where($arrMap)->delete()){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

}
