<?php
/**
 * 淘宝接口
 *
 *
 *
 *
 * @copyright  Copyright (c) 2007-2015 共铸商城  Inc. (http://www.gongzhuying.com)
 * @license    http://www.gongzhuying.com
 * @link       http://www.gongzhuying.com
 * @since      File available since Release v1.1
 */

use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');
class taobao_apiControl extends SCMControl{

    public function __construct(){
        parent::__construct();
    }

    public function indexOp() {
        $this->taobao_api_settingOp();
    }

    public function taobao_api_settingOp() {
        $model_setting = Model('setting');
        $setting_list = $model_setting->getListSetting();
        Tpl::output('setting',$setting_list);
        Tpl::showpage('taobao_api');
    }

    public function taobao_api_saveOp() {
        $model_setting = Model('setting');

        $update_array['taobao_api_isuse'] = intval($_POST['taobao_api_isuse']);
        $update_array['taobao_app_key'] = $_POST['taobao_app_key'];
        $update_array['taobao_secret_key'] = $_POST['taobao_secret_key'];

        $result = $model_setting->updateSetting($update_array);
        if ($result === true){
            $this->log('淘宝接口保存', 1);
            showMessage(Language::get('nc_common_save_succ'));
        }else {
            $this->log('淘宝接口保存', 0);
            showMessage(Language::get('nc_common_save_fail'));
        }
    }
}
