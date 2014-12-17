<?php

/**
 * 首页
 * @version 2013-08-24
 */

class IndexAction extends HomeAction {

    

    //框架页

    public function index() {

        C('SHOW_PAGE_TRACE', true);

        $this->assign('channel', $this->_getChannel());

        $this->assign('menu',    $this->_getMenu());

        $this->display();

    }



    /**
     * 首页
     */

    public function main() {

        echo '<h2>这里是后台首页</h2>';

        $this->display();

    }



    /**
     * 头部菜单
     */

    protected function _getChannel() {

        return array(

            'index'   => '我的首页',

        );

    }



    /**
     * 左侧菜单
     */

    protected function _getMenu() {

        $menu = array();

        //注意顺序！！



        // 后台管理首页

        $menu['index'] = array(

            '网站信息' => array(

                '设置信息' => U('Home/Setting/set'),
                '修改密码' => U('Home/Setting/pwd'),

            ),

            '文章管理' => array(
                '文章列表' => U('Home/Article/ls'),
                '模版列表' => U('Home/Tpl/ls'),
            ),

            '新闻管理' => array(
                '新闻列表' =>  U('Home/News/ls'),
                '新闻分类' =>  U('Home/NewsTpl/ls'),
            ),
            
            '幻灯片管理' => array(
                '幻灯片列表' => U('Home/PowerPoint/ls'),
                '幻灯片分类' =>  U('Home/PPType/ls'),
            ),

            '留言管理' => array(
                '留言列表' => U('Home/Message/ls'),
            ),

            '微信管理' => array(
                '关键字列表' => U('Home/Route/ls'),
                '文本回复列表' => U('Home/Text/ls'),
                '图文回复列表' => U('Home/Txp/ls'),
            ),

        );

        return $menu;

    }

}

