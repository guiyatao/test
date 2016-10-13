<?php
/**
 * 交易管理
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
class online_order_detailControl extends SCMControl{
    /**
     * 每次导出订单数量
     * @var int
     */
    const EXPORT_SIZE = 1000;
    protected $user_info;


    public function __construct(){
        parent::__construct();
        Language::read('trade');
        $this->user_info = SCMModel('scm_user')->getUserInfo($this->admin_info['id']);
    }

    public function indexOp(){
        Tpl::showpage('accepted_order.index');
    }

    public function get_xmlOp(){
        $model_order = SCMModel('scm_online_order');
        $condition  = array();
        $condition['clie_id'] = array('eq', $this->user_info['supp_clie_id']);
        //订单状态：0(已取消)10(默认):未付款;20:已付款;30:已发货;40:已收货;50:已接单;60已弃单
        $condition['order_state'] = 50;
        $this->_get_condition($condition);

        $sort_fields = array('order_id','order_no','clie_id','supp_id','goods_barcode','goods_nm','goods_price','goods_discount','goods_discount_price','order_num','order_pay','goods_rate','goods_tax','goods_stock','goods_low_stock','gift_barcode','gift_nm','gift_num','order_date','valid_date','out_date','in_date','pay_date','cycle_flag','cycle_num','warn_flag','order_flag','out_flag','in_flag','pay_flag','comments');
        if ($_POST['sortorder'] != '' && in_array($_POST['sortname'],$sort_fields)) {
            $order = $_POST['sortname'].' '.$_POST['sortorder'];
        }

        $order_list = $model_order->getOrderList($condition,$_POST['rp'],'*',$order);
        $data = array();
        $data['now_page'] = $model_order->shownowpage();
        $data['total_num'] = $model_order->gettotalnum();
        foreach ($order_list as $order_id => $order_info) {
//            $order_info['if_system_cancel'] = $model_order->getOrderOperateState('system_cancel',$order_info);
//            $order_info['if_system_receive_pay'] = $model_order->getOrderOperateState('system_receive_pay',$order_info);
//            $order_info['state_desc'] = orderState($order_info);

            //取得订单其它扩展信息
//            $model_order->getOrderExtendInfo($order_info);
            $list = array();$operation_detail = '';
            // $list['operation'] = "<a class='btn green' href='javascript:void(0);' onclick=\"fg_accept_order('" . $order_info['order_id'] . "')\"><i class='fa fa-list-alt'></i>接单</a>";
            $list['operation'] = "<a class=\"btn green\" href=\"index.php?act=online_order&op=show_order&order_id={$order_info['order_id']}\"><i class=\"fa fa-list-alt\"></i>查看</a>";
            // $list['operation'] .= "<a class='btn red' href='javascript:void(0);' onclick=\"fg_abandon_order('" . $order_info['order_id'] . "')\"><i class='fa fa-ban'></i>弃单</a>";
//            if ($order_info['if_system_cancel']) {
               // $operation_detail .= "<li><a href=\"javascript:void(0);\" onclick=\"fg_cancel({$order_info['order_no']}, {$order_info['goods_barcode']})\">取消订单</a></li>";
//            }
//            if ($order_info['if_system_receive_pay']) {
//                $op_name = $order_info['system_receive_pay_op_name'] ? $order_info['system_receive_pay_op_name'] : '收到货款';
//                $operation_detail .= "<li><a href=\"index.php?act=order&op=change_state&state_type=receive_pay&order_id={$order_info['order_id']}\">{$op_name}</a></li>";
//            }
           // if ($operation_detail) {
           //     $list['operation'] .= "<span class='btn'><em><i class='fa fa-cog'></i>设置 <i class='arrow'></i></em><ul>{$operation_detail}</ul>";
           // }
//            $list['order_sn'] = $order_info['order_sn'].str_replace(array(1,2,3), array(null,' [预定]','[门店自提]'), $order_info['order_type']);
//            $list['order_from'] = str_replace(array(1,2), array('PC端','移动端'),$order_info['order_from']);
//            $list['add_times'] = date('Y-m-d H:i:s',$order_info['add_time']);
//			$list['order_amount'] = ncPriceFormat($order_info['order_amount']);
//			if ($order_info['shipping_fee']) {
//			    $list['order_amount'] .= '(含运费'.ncPriceFormat($order_info['shipping_fee']).')';
//			}
//			$list['order_state'] = $order_info['state_desc'];
//            $list['pay_sn'] = empty($order_info['pay_sn']) ? '' : $order_info['pay_sn'];
//			$list['payment_code'] = orderPaymentName($order_info['payment_code']);
//			$list['payment_time'] = !empty($order_info['payment_time']) ? (intval(date('His',$order_info['payment_time'])) ? date('Y-m-d H:i:s',$order_info['payment_time']) : date('Y-m-d',$order_info['payment_time'])) : '';
//            $list['rcb_amount'] = ncPriceFormat($order_info['rcb_amount']);
//            $list['pd_amount'] = ncPriceFormat($order_info['pd_amount']);
//            $list['shipping_code'] = $order_info['shipping_code'];
//            $list['refund_amount'] = ncPriceFormat($order_info['refund_amount']);
//			$list['finnshed_time'] = !empty($order_info['finnshed_time']) ? date('Y-m-d H:i:s',$order_info['finnshed_time']) : '';
//			$list['evaluation_state'] = str_replace(array(0,1,2), array('未评价','已评价','未评价'),$order_info['evaluation_state']);
            // $list['order_id'] = $order_info['order_id'];
            $list['order_sn'] = $order_info['order_sn'];
            $list['clie_id'] = $order_info['clie_id'];
            $list['buyer_name'] = $order_info['buyer_name'];
            $list['buyer_phone'] = $order_info['buyer_phone'];
            $list['buyer_address'] = $order_info['buyer_address'];
            // $list['goods_price'] = ncPriceFormat($order_info['goods_price']);
            // $list['goods_discount'] = $order_info['goods_discount'];
            // $list['goods_discount_price'] = $order_info['goods_discount_price'];
            // $list['order_num'] = $order_info['order_num'];
            // $list['order_pay'] = ncPriceFormat($order_info['order_pay']);
            // $list['goods_rate'] = $order_info['goods_rate'];
            // $list['goods_tax'] = ncPriceFormat($order_info['goods_tax']);
            // $list['goods_stock'] = $order_info['goods_stock'];
            // $list['goods_low_stock'] = $order_info['goods_low_stock'];
            // $list['gift_barcode'] = $order_info['gift_barcode'];
            // $list['gift_nm'] = $order_info['gift_nm'];
            // $list['gift_num'] = $order_info['gift_num'];
            $list['add_time'] = date("Y-m-d H:i:s", $order_info['add_time']);
            $list['payment_code'] = $order_info['payment_code'];
            $list['order_amount'] = $order_info['order_amount'];
            $list['order_state'] = Order::getShopOrderStatusByID($order_info['order_state']);
   //          $list['valid_date'] = $order_info['valid_date'];
   //          $list['out_date'] = $order_info['out_date'];
   //          $list['in_date'] = $order_info['in_date'];
   //          $list['pay_date'] = $order_info['pay_date'];
   //          $list['cycle_flag'] = $order_info['cycle_flag'];
   //          $list['cycle_num'] = $order_info['cycle_num'];
   //          $list['warn_flag'] = $order_info['warn_flag'];
   //          $list['order_flag'] = $order_info['order_flag'];
   //          $list['out_flag'] = $order_info['out_flag'];
			// $list['in_flag'] = $order_info['in_flag'];
			// $list['pay_flag'] = $order_info['pay_flag'];
			// $list['comments'] = $order_info['comments'];
			$data['list'][] = $list;
        }
        exit(Tpl::flexigridXML($data));
    }

    /**
     * 接受商品订单
     */
    public function order_acceptOp() {
        $model_order = SCMModel('scm_online_order');
        if (chksubmit()) {
            $update = array();
            $update['order_state'] = 50;

            $where = array();
            $where['order_id'] = $_POST['order_id'];
            $where['clie_id'] = $this->user_info['supp_clie_id'];

            $model_order->editOrder($update, $where);
            $goods_array = $model_order->getOrderGoodsList(array('order_id'=>$_POST['order_id']), array('goods_num', 'goods_barcode'));
            foreach ($goods_array as $goods) {
                $model_order->editStock($goods, '-', $this->user_info['supp_clie_id']);
            }
            showDialog(L('nc_common_op_succ'), '', 'succ', '$("#flexigrid").flexReload();CUR_DIALOG.close()');
        }
        $common_info = $model_order->getOrderGoodsInfoByID($_GET['order_id']);
        if ($common_info) {
            $common_info['add_time'] = date("Y-m-d H:i:s", $common_info['add_time']);
            Tpl::output('common_info', $common_info);
            Tpl::showpage('order_accept.close_remark', 'null_layout');
        }
    }

    /**
     * 放弃商品订单
     */
    public function order_abandonOp() {
        $model_order = SCMModel('scm_online_order');

        $model_wx = SCMModel('scm_wechat');
        
$client = 'cail';
$msg = 'test ok';

$model_wx->wxMsgSend($client, $msg, 'o1KiwwzsnIPMOUXIp0EdyUCpSn4k');
        if (chksubmit()) {
            $update = array();
            $update['order_state'] = 60;

            $where = array();
            $where['order_id'] = $_POST['order_id'];
            $where['clie_id'] = $this->user_info['supp_clie_id'];

            $model_order->editOrder($update, $where);

            //todo 弃单操作
            showDialog(L('nc_common_op_succ'), '', 'succ', '$("#flexigrid").flexReload();CUR_DIALOG.close()');
        }
        $common_info = $model_order->getOrderGoodsInfoByID($_GET['order_id']);
        
        Tpl::output('common_info', $common_info);
        Tpl::showpage('order_abandon.close_remark', 'null_layout');
    }

    /**
     * 平台订单状态操作
     *
     */
    public function change_stateOp() {
        $order_id = intval($_GET['order_id']);
        if($order_id <= 0){
            showMessage(L('miss_order_number'),$_POST['ref_url'],'html','error');
        }
        $model_order = Model('order');

        //获取订单详细
        $condition = array();
        $condition['order_id'] = $order_id;
        $order_info = $model_order->getOrderInfo($condition);

        //取得其它订单类型的信息
        $model_order->getOrderExtendInfo($order_info);

        if ($_GET['state_type'] == 'cancel') {
            $result = $this->_order_cancel($order_info);
        } elseif ($_GET['state_type'] == 'receive_pay') {
            $result = $this->_order_receive_pay($order_info,$_POST);
        }
        if (!$result['state']) {
            showMessage($result['msg'],$_POST['ref_url'],'html','error');
        } else {
            showMessage($result['msg'],$_POST['ref_url']);
        }
    }

    /**
     * 系统取消订单
     */
    private function _order_cancel($order_info) {
        $order_id = $order_info['order_id'];
        $model_order = Model('order');
        $logic_order = Logic('order');
        $if_allow = $model_order->getOrderOperateState('system_cancel',$order_info);
        if (!$if_allow) {
            return callback(false,'无权操作');
        }
        if (TIMESTAMP - 86400 < $order_info['api_pay_time']) {
            $_hour = ceil(($order_info['api_pay_time']+86400-TIMESTAMP)/3600);
            exit(json_encode(array('state'=>false,'msg'=>'该订单曾尝试使用第三方支付平台支付，须在'.$_hour.'小时以后才可取消')));
        }
        if ($order_info['order_type'] == 2) {
            //预定订单
            $result = Logic('order_book')->changeOrderStateCancel($order_info, 'admin', $this->admin_info['name']);
        } else {
            $cancel_condition = array();
            if ($order_info['payment_code'] != 'offline') {
                $cancel_condition['order_state'] = ORDER_STATE_NEW;
            }
            $result =  $logic_order->changeOrderStateCancel($order_info,'admin', $this->admin_info['name'],'',true,$c);
        }
        if ($result['state']) {
            $this->log(L('order_log_cancel').','.L('order_number').':'.$order_info['order_sn'],1);
        }
        if ($result['state']) {
            exit(json_encode(array('state'=>true,'msg'=>'取消成功')));
        } else {
            exit(json_encode(array('state'=>false,'msg'=>'取消失败')));
        }
    }

    /**
     * 系统收到货款
     * @throws Exception
     */
    private function _order_receive_pay($order_info, $post) {
        $order_id = $order_info['order_id'];
        $model_order = Model('order');
        $logic_order = Logic('order');
        $order_info['if_system_receive_pay'] = $model_order->getOrderOperateState('system_receive_pay',$order_info);

        if (!$order_info['if_system_receive_pay']) {
            return callback(false,'无权操作');
        }

        if (!chksubmit()) {
            Tpl::output('order_info',$order_info);
            //显示支付接口列表
            $payment_list = Model('payment')->getPaymentOpenList();
            //去掉预存款和货到付款
            foreach ($payment_list as $key => $value){
                if ($value['payment_code'] == 'predeposit' || $value['payment_code'] == 'offline') {
                   unset($payment_list[$key]);
                }
            }
            Tpl::output('payment_list',$payment_list);
            Tpl::showpage('order.receive_pay');
            exit();
        }
        //预定支付尾款时需要用到已经支付的状态
        $order_list = $model_order->getOrderList(array('pay_sn'=>$order_info['pay_sn'],'order_state'=>array('in',array(ORDER_STATE_NEW,ORDER_STATE_PAY))));

        //取订单其它扩展信息
        $result = Logic('payment')->getOrderExtendList($order_list,'admin');
        if (!$result['state']) {
            return $result;
        }
        $result = $logic_order->changeOrderReceivePay($order_list,'admin',$this->admin_info['name'],$post);
        if ($result['state']) {
            $this->log('将订单改为已收款状态,'.L('order_number').':'.$order_info['order_sn'],1);
            //记录消费日志
            $api_pay_amount = $order_info['order_amount'] - $order_info['pd_amount'] - $order_info['rcb_amount'];
            QueueClient::push('addConsume', array('member_id'=>$order_info['buyer_id'],'member_name'=>$order_info['buyer_name'],
            'consume_amount'=>$api_pay_amount,'consume_time'=>TIMESTAMP,'consume_remark'=>'管理员更改订单为已收款状态，订单号：'.$order_info['order_sn']));
        }
        return $result;
    }

    /**
     * 查看订单
     *
     */
    public function show_orderOp(){
        $order_id = intval($_GET['order_id']);
        if($order_id <= 0 ){
            showMessage(L('miss_order_number'));
        }
        $model_order = SCMModel('scm_online_order');
        $condition  = array();
        $condition['order_id']  = $order_id;
        $condition['clie_id']  = $_GET['clie_id'];
        $order_info = $model_order->getOrderInfo($condition, array('order_goods','order_common'));

        foreach ($order_info['extend_order_goods'] as $value) {
            $value['image_60_url'] = cthumb($value['goods_image'], 60, $value['store_id']);
            $value['image_240_url'] = cthumb($value['goods_image'], 240, $value['store_id']);
            $value['goods_type_cn'] = orderGoodsType($value['goods_type']);
            $value['goods_url'] = urlShop('goods','index',array('goods_id'=>$value['goods_id']));
            if ($value['goods_type'] == 5) {
                $order_info['zengpin_list'][] = $value;
            } else {
                $order_info['goods_list'][] = $value;
            }
        }

        Tpl::output('order_info',$order_info);
        Tpl::output('order_id',$order_id);
        Tpl::showpage('accepted_order.view');
    }

    /**
     * 导出
     *
     */
    public function export_step1Op(){
        $lang   = Language::getLangContent();

        $model_order = Model('order');
        $condition  = array();
        if (preg_match('/^[\d,]+$/', $_GET['order_id'])) {
            $_GET['order_id'] = explode(',',trim($_GET['order_id'],','));
            $condition['order_id'] = array('in',$_GET['order_id']);
        }
        $this->_get_condition($condition);
        $sort_fields = array('buyer_name','store_name','order_id','payment_code','order_state','order_amount','order_from','pay_sn','rcb_amount','pd_amount','payment_time','finnshed_time','evaluation_state','refund_amount','buyer_id','store_id');
        if ($_POST['sortorder'] != '' && in_array($_POST['sortname'],$sort_fields)) {
            $order = $_POST['sortname'].' '.$_POST['sortorder'];
        } else {
            $order = 'order_id desc';
        }

        if (!is_numeric($_GET['curpage'])){
            $count = $model_order->getOrderCount($condition);
            $array = array();
            if ($count > self::EXPORT_SIZE ){   //显示下载链接
                $page = ceil($count/self::EXPORT_SIZE);
                for ($i=1;$i<=$page;$i++){
                    $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
                    $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
                    $array[$i] = $limit1.' ~ '.$limit2 ;
                }
                Tpl::output('list',$array);
                Tpl::output('murl','index.php?act=order&op=index');
                Tpl::showpage('export.excel');
            }else{  //如果数量小，直接下载
                $data = $model_order->getOrderList($condition,'','*',$order,self::EXPORT_SIZE);
                $this->createExcel($data);
            }
        }else{  //下载
            $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $model_order->getOrderList($condition,'','*',$order,"{$limit1},{$limit2}");
            $this->createExcel($data);
        }
    }

    /**
     * 生成excel
     *
     * @param array $data
     */
    private function createExcel($data = array()){
        Language::read('export');
        import('libraries.excel');
        $excel_obj = new Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
        //header
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单编号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单来源');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'下单时间');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单金额(元)');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单状态');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付单号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付方式');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付时间');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'充值卡支付(元)');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'预存款支付(元)');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'发货物流单号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'退款金额(元)');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单完成时间');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'是否评价');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'店铺ID');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'店铺名称');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'买家ID');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'买家账号');
        //data
        foreach ((array)$data as $k=>$order_info){
            $order_info['state_desc'] = orderState($order_info);
            $list = array();
            $list['order_sn'] = $order_info['order_sn'].str_replace(array(1,2,3), array(null,' [预定]','[门店自提]'), $order_info['order_type']);
            $list['order_from'] = str_replace(array(1,2), array('PC端','移动端'),$order_info['order_from']);
            $list['add_time'] = date('Y-m-d H:i:s',$order_info['add_time']);
            $list['order_amount'] = ncPriceFormat($order_info['order_amount']);
            if ($order_info['shipping_fee']) {
                $list['order_amount'] .= '(含运费'.ncPriceFormat($order_info['shipping_fee']).')';
            }
            $list['order_state'] = $order_info['state_desc'];
            $list['pay_sn'] = empty($order_info['pay_sn']) ? '' : $order_info['pay_sn'];
            $list['payment_code'] = orderPaymentName($order_info['payment_code']);
            $list['payment_time'] = !empty($order_info['payment_time']) ? (intval(date('His',$order_info['payment_time'])) ? date('Y-m-d H:i:s',$order_info['payment_time']) : date('Y-m-d',$order_info['payment_time'])) : '';
            $list['rcb_amount'] = ncPriceFormat($order_info['rcb_amount']);
            $list['pd_amount'] = ncPriceFormat($order_info['pd_amount']);
            $list['shipping_code'] = $order_info['shipping_code'];
            $list['refund_amount'] = ncPriceFormat($order_info['refund_amount']);
            $list['finnshed_time'] = !empty($order_info['finnshed_time']) ? date('Y-m-d H:i:s',$order_info['finnshed_time']) : '';
            $list['evaluation_state'] = str_replace(array(0,1,2), array('未评价','已评价','未评价'),$order_info['evaluation_state']);
            $list['store_id'] = $order_info['store_id'];
            $list['store_name'] = $order_info['store_name'];
            $list['buyer_id'] = $order_info['buyer_id'];
            $list['buyer_name'] = $order_info['buyer_name'];

            $tmp = array();
            $tmp[] = array('data'=>$list['order_sn']);
			$tmp[] = array('data'=>$list['order_from']);
            $tmp[] = array('data'=>$list['add_time']);
            $tmp[] = array('data'=>$list['order_amount']);
            $tmp[] = array('data'=>$list['order_state']);
			$tmp[] = array('data'=>$list['pay_sn']);
            $tmp[] = array('data'=>$list['payment_code']);
			$tmp[] = array('data'=>$list['payment_time']);
            $tmp[] = array('data'=>$list['rcb_amount']);
            $tmp[] = array('data'=>$list['pd_amount']);
            $tmp[] = array('data'=>$list['shipping_code']);
            $tmp[] = array('data'=>$list['refund_amount']);
            $tmp[] = array('data'=>$list['finnshed_time']);
            $tmp[] = array('data'=>$list['evaluation_state']);
            $tmp[] = array('data'=>$list['store_id']);
            $tmp[] = array('data'=>$list['store_name']);
            $tmp[] = array('data'=>$list['buyer_id']);
            $tmp[] = array('data'=>$list['buyer_name']);
            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset(L('exp_od_order'),CHARSET));
        $excel_obj->generateXML('order-'.$_GET['curpage'].'-'.date('Y-m-d-H',time()));
    }

    /**
     * 处理搜索条件
     */
    private function _get_condition(& $condition) {
        if ($_REQUEST['query'] != '' && in_array($_REQUEST['qtype'],array('order_sn','buyer_name','goods_nm','buyer_phone'))) {
            $condition[$_REQUEST['qtype']] = array('like',"%{$_REQUEST['query']}%");
        }
    }

}
