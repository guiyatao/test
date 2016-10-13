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
class client_storageControl extends SCMControl{
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
        Tpl::showpage('client_storage.index');
    }

    public function get_xmlOp(){
        $model_order = SCMModel('scm_client_order');
        $condition  = array();
        $condition['clie_id'] = $this->user_info['supp_clie_id'];
        $condition['order_status'] = array('eq', 0);
        $condition['out_flag'] = array('eq', 1);
        $condition['in_flag'] = array('neq', 1);
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
            if($order_info['refund_flag'] != 1){
                $list['operation'] = "<a class='btn green' href='javascript:void(0);' onclick=\"fg_storage_order('" . $order_info['id'] . "','" . $order_info['order_no']."')\"><i class='fa fa-list-alt'></i>入库</a>";
                $list['operation'] .= "<a class='btn red' href='javascript:void(0);' onclick=\"fg_refund_order('" . $order_info['order_no'] . "')\"><i class='fa fa-ban'></i>退货</a>";
            }
            $list['operation'] .= "<a class=\"btn green\" href=\"index.php?act=client_storage&op=show_order&order_id={$order_info['id']}\"><i class=\"fa fa-list-alt\"></i>查看</a>";
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
            $list['order_no'] = $order_info['order_no'];
            $list['clie_id'] = $order_info['clie_id'];
            $list['supp_id'] = $order_info['supp_id'];
            $list['order_pay'] = ncPriceFormat($order_info['order_pay']);
            $list['order_date'] = $order_info['order_date'];
            $list['out_date'] = $order_info['out_date'];
            if($order_info['refund_flag'] == 1){
                $list['refund_flag'] = "已申请退货";
            }else{
                $list['refund_flag'] = "未申请退货";
            }
			$list['comments'] = $order_info['comments'];
            $data['list'][$order_info['id']] = $list;
        }
        exit(Tpl::flexigridXML($data));
    }

    /**
     * 入库商品
     */
    public function storage_confirmOp() {
        $model_order = SCMModel('scm_client_order');
        if (chksubmit()) {
            $update = array();
            $update['in_flag'] = 1;
            $update['order_status'] = 1;
            $now = date("Y-m-d H:i:s",time());
            $update['in_date'] = $now;
            $update['pay_start_time'] = $now;
            $where = array();
            $where['id'] = $_POST['order_id'];
            $state = $model_order->editOrder($update, $where);
            if ($state) {
                $model_stock = SCMModel('scm_client_stock');
                $model_instock_info = SCMModel('scm_instock_info');
                $order_info = $model_order->getOrderGoodsList(array('order_id'=>$_POST['order_id']));
                foreach ($order_info as $good){
                    if($model_stock->getGoodExist($good['goods_barcode'],$this->user_info['supp_clie_id'] )) {
                        $model_stock->editStock($good, '+', $this->user_info['supp_clie_id']);
                        //修改库存信息，设置生产日期，保质期，有效期，有效期提醒天数
                        $condition = array(
                            'goods_barcode'=> $good['goods_barcode'],
                            'clie_id' => $this->user_info['supp_clie_id'],
                            'production_date' =>  $good['production_date'],
                            'shelf_life' => $good['shelf_life'],
                            'goods_nm' => $good['goods_nm'],
                            'goods_price' => $good['goods_price'],
                            'goods_discount' => $good['goods_discount'],
                            'goods_unit' => $good['goods_unit'],
                            'goods_spec' => $good['goods_spec'],
                            'supp_id' => $good['supp_id'],
                        );
                        $model_stock->editStockInfo($condition);
                    } else {
                      $model_stock->addNewGoodsToClientStock($good);

                    }
                    $model_instock_info->addInstockInfo($good, $update['in_date']);
                }
                showDialog(L('nc_common_op_succ'), '', 'succ', '$("#flexigrid").flexReload();CUR_DIALOG.close()');
            }
        }
        $common_info = $model_order->getOrderGoodsInfoByID($_GET['order_no']);
        $supp_list = SCMModel('scm_supplier')->getList(array('supp_id'=>$common_info['supp_id']));
        Tpl::output('common_info', $common_info);
        Tpl::output('supplier_info', $supp_list[0]);
        Tpl::showpage('client_storage.close_remark', 'null_layout');
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
        $model_order = SCMModel('scm_client_order');
        $order_info = $model_order->getOrderInfo(array('id'=>$order_id), array('order_goods'));

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
        
       if (empty($order_info['zengpin_list'])) {
           $order_info['goods_count'] = count($order_info['goods_list']);
       } else {
           $order_info['goods_count'] = count($order_info['goods_list']) + 1;
       }

        //取得订单其它扩展信息
//        $model_order->getOrderExtendInfo($order_info);

        //订单变更日志
//        $log_list   = $model_order->getOrderLogList(array('order_id'=>$order_info['order_id']));
//        Tpl::output('order_log',$log_list);

        //退款退货信息
//        $model_refund = Model('refund_return');
//        $condition = array();
//        $condition['order_id'] = $order_info['order_id'];
//        $condition['seller_state'] = 2;
//        $condition['admin_time'] = array('gt',0);
//        $return_list = $model_refund->getReturnList($condition);
//        Tpl::output('return_list',$return_list);

        //退款信息
//        $refund_list = $model_refund->getRefundList($condition);
//        Tpl::output('refund_list',$refund_list);

        //商家信息
//        $store_info = Model('store')->getStoreInfo(array('store_id'=>$order_info['store_id']));
//       Tpl::output('store_info',$store_info);
        $client_info = SCMModel('scm_client')->getClientInfo(array('clie_id'=>$order_info['clie_id']));
        $supplier = SCMModel('scm_supp_client')->getSuppInfo(array('supp_id'=>$order_info['supp_id']));
        Tpl::output('order_info',$order_info);
        Tpl::output('client_info',$client_info);
        Tpl::output('supplier_info',$supplier[0]);
        Tpl::showpage('client_order.view');
    }


    /**
     * 商品订单退货
     */
    public function order_refundOp() {
        $model_order = SCMModel('scm_client_order');
        if (chksubmit()) {
            $update = array();
            $update['refund_flag'] = 1;

            $where = array();
            $where['order_no'] = $_POST['order_no'];

            $model_order->editOrder($update, $where);
            showDialog(L('nc_common_op_succ'), '', 'succ', '$("#flexigrid").flexReload();CUR_DIALOG.close()');
        }
        $common_info = $model_order->getOrderGoodsInfoByID($_GET['order_no']);
        $supp_list = SCMModel('scm_supplier')->getList(array('supp_id'=>$common_info['supp_id']));
        Tpl::output('common_info', $common_info);
        Tpl::output('supplier_info', $supp_list[0]);
        Tpl::output('order_no', $_GET['order_no']);
        Tpl::showpage('order_refund.close_remark', 'null_layout');
    }

    /**
     * 导出
     *
     */
    public function export_step1Op(){
        $model_order = SCMModel('scm_client_order');
        $condition  = array();
        $condition['clie_id'] = $this->user_info['supp_clie_id'];
        $condition['order_status'] = array('eq', 0);
        $condition['out_flag'] = array('eq', 1);
        $condition['in_flag'] = array('neq', 1);
        $this->_get_condition($condition);
        $sort_fields = array('order_id','order_no','clie_id','supp_id','goods_barcode','goods_nm','goods_price','goods_discount','goods_discount_price','order_num','order_pay','goods_rate','goods_tax','goods_stock','goods_low_stock','gift_barcode','gift_nm','gift_num','order_date','valid_date','out_date','in_date','pay_date','cycle_flag','cycle_num','warn_flag','order_flag','out_flag','in_flag','pay_flag','comments');
        if ($_POST['sortorder'] != '' && in_array($_POST['sortname'],$sort_fields)) {
            $order = $_POST['sortname'].' '.$_POST['sortorder'];
        }else{
            $order = "order_date desc";
        }
        if (preg_match('/^[\d,]+$/', $_GET['order_id'])) {
            $_GET['order_id'] = explode(',',trim($_GET['order_id'],','));
            $condition['id'] = array('in',$_GET['order_id']);
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
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'终端店编号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'供应商编号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'付款金额');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单日期');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'出货日期');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'退货状态');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'备注');
        //data
        foreach ((array)$data as $k=>$order_info){
            $tmp = array();
            $tmp[] = array('data'=>$order_info['order_no']);
            $tmp[] = array('data'=>$order_info['clie_id']);
            $tmp[] = array('data'=>$order_info['supp_id']);
            $tmp[] = array('data'=>$order_info['order_pay']);
            $tmp[] = array('data'=>$order_info['order_date']);
            $tmp[] = array('data'=>$order_info['out_date']);
            $tmp[] = array('data'=> $order_info['refund_flag'] ? '已申请退货' : '未申请退货');
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
        if ($_REQUEST['query'] != '' && in_array($_REQUEST['qtype'],array('order_no','goods_barcode','goods_nm','supp_id'))) {
            $condition[$_REQUEST['qtype']] = array('like',"%{$_REQUEST['query']}%");
        }
    }

}
