<?php
/**
 * 入口文件
 *
 * 统一入口，进行初始化信息
 *
 *
 * @copyright  Copyright (c) 2007-2015 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net/
 * @link       http://www.shopnc.net/
 * @since      File available since Release v1.1
 */
define('BASE_PATH', str_replace('\\', '/', dirname(__FILE__)));
require __DIR__ . '/../shopnc.php';

$config = Shopnc\Core::getConfigs();
$site_url = $config['shop_site_url'];
$version = $config['version'];
$setup_date = $config['setup_date'];
$gip = $config['gip'];
$dbtype = $config['dbdriver'];
$dbcharset = $config['db']['master']['dbcharset'];
$dbserver = $config['db']['master']['dbhost'];
$dbserver_port = $config['db']['master']['dbport'];
$dbname = $config['db']['master']['dbname'];
$db_pre = $config['tablepre'];
$dbuser = $config['db']['master']['dbuser'];
$dbpasswd = $config['db']['master']['dbpwd'];
$lang_type = $config['lang_type'];
$cookie_pre = $config['cookie_pre'];
unset($config);

if($_GET['act'] == 'adv'){
    define('ATTACH_ADV','shop/adv');
    //define('SHOP_SITE_URL',$site_url);
    $advshow_classfile = BASE_PATH.DS.'control/adv.php';
    if(is_file($advshow_classfile)){
        include_once ($advshow_classfile);
        $advshow = new advControl();
        $advshow->advshowOp();
    }else{
        echo "Adv System Inner Error!";
    }
}elseif ($_GET['act'] == 'get_session'){
    //session_start();
    $key = $_GET['key'];
    $val = '';
    if (!empty($_SESSION[$key])) $val = $_SESSION[$key];
    echo $val;
    exit;
}elseif ($_GET['act'] == 'sharebind'){
    //define('SHOP_SITE_URL',$site_url);
    if($_GET['type'] == 'qqzone'){
        include BASE_DATA_PATH.DS.'api/snsapi/qqzone/oauth/qq_login.php';
    }elseif ($_GET['type'] == 'sinaweibo'){
        include BASE_DATA_PATH.DS.'api/snsapi/sinaweibo/index.php';
    }elseif ($_GET['type'] == 'qqweibo'){
        include BASE_DATA_PATH.DS.'api/snsapi/qqweibo/index.php';
    }
}
