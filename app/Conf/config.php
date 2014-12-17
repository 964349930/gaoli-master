<?php
/**
 * 配置文件
 * @author chen
 * @version 2014-03-20
 */
return array(
        'URL_MODEL' => 0,
        'DB_TYPE'=>'mysql',
        'DB_HOST'=>'localhost',
        'DB_NAME'=>'gaoli',
        'DB_USER'=>'root',
        'DB_PWD'=>'',
        'DB_PORT'=>'3306',
        'DB_PREFIX'=>'0509_',

        'TMPL_L_DELIM' => '{',
        'TMPL_R_DELIM' => '}',

        'APP_AUTOLOAD_PATH'=>'@.TagLib',

        'APP_GROUP_LIST'=>'Home, Mobile',
        'DEFAULT_GROUP'=>'Home',
        'SHOW_PAGE_TRACE'=>false,

);
?>
