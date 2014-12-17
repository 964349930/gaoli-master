<?php
/**
 * 文章控制器
 */
class PowerPointAction extends HomeAction
{

    /**
     * 获取幻灯片分类列表
     * @return array $list
     */
    private function get_type_list(){
        $list = D('Powerpointtype')->select();
        return $list;
    }

    /**
     * 幻灯片列表
     */
    public function ls()
    {
        $list = D('Powerpoint')->select();
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * 幻灯片详情操作
     */
    public function info()
    {
        $obj = D('Powerpoint');
        if(empty($_POST)){
            $id = $this->_get('id');
            if(!empty($id)){
                $info = $obj->where('id='.$id)->find();
                $this->assign('info', $info);
            }
            $this->assign('typeList', $this->get_type_list());
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
            $this->error('请选择您要删除的幻灯片');
        }
		$arrMap['id'] = array('in', $delIds);
		if(D('PowerPoint')->where($arrMap)->delete()){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}

}
