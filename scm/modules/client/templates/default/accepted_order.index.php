<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>已接受订单</h3>
        <h5>终端店已经接受商城分过来的订单</h5>
      </div>
    </div>
  </div>
  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li>终端店已经接受的订单列表</li>
    </ul>
  </div>
  <div id="flexigrid"></div>
</div>
<script type="text/javascript">
$(function(){
    $("#flexigrid").flexigrid({
        url: 'index.php?act=online_order&op=get_xml',
        colModel : [
            {display: '操作', name : 'operation', width : 120, sortable : false, align: 'center'},
            {display: '订单号', name : 'order_sn', width : 120, sortable : false, align: 'center'},
            {display: '终端店编号', name : 'clie_id', width : 120, sortable : true, align : 'center'},
            {display: '买家姓名', name : 'buyer_name', width : 80, sortable : true, align: 'center'},
            {display: '买家电话', name : 'buyer_phone', width : 100, sortable : true, align: 'center'},
            {display: '买家地址', name : 'buyer_address', width : 180, sortable : true, align: 'center'},
            {display: '订单日期', name : 'add_time', width : 120, sortable : true, align: 'center'},
            {display: '支付方式', name : 'payment_code', width : 100, sortable : true, align: 'center'},
            {display: '送货方式', name : 'pickup_mode', width : 80, sortable : true, align: 'center'},
            {display: '订单金额', name : 'order_amount', width : 100, sortable : true, align: 'center'},
            {display: '订单状态', name : 'order_state', width : 100, sortable : true, align: 'center'},
            ],
        buttons : [
            {display: '<i class="fa fa-file-excel-o"></i>导出数据', name : 'csv', bclass : 'csv', title : '将选定行数据导出excel文件,如果不选中行，将导出列表所有数据', onpress : fg_operate }
        ],
        searchitems : [
                       {display: '订单编号', name : 'order_sn', isdefault: true},
                       {display: '买家姓名', name : 'buyer_name'},
                       {display: '买家电话', name : 'buyer_phone'}
            ],
        sortname: "order_id",
        sortorder: "desc",
        title: '已接受订单列表'
    });
});
function fg_operate(name, grid) {
    if (name == 'csv') {
    	var itemlist = new Array();
        if($('.trSelected',grid).length>0){
            $('.trSelected',grid).each(function(){
            	itemlist.push($(this).attr('data-id'));
            });
        }
        fg_csv(itemlist);
    }
}
function fg_csv(ids) {
    id = ids.join(',');
    window.location.href = $("#flexigrid").flexSimpleSearchQueryString()+'&op=export_step1&order_id=' + id;
}

function fg_accept_order(order_id) {
    _uri = "index.php?act=accept_order&op=order_accept&order_id=" + order_id;
    CUR_DIALOG = ajax_form('accept_order', '接受订单', _uri, 640);
}

function fg_abandon_order(order_id) {
    _uri = "index.php?act=accept_order&op=order_abandon&order_id=" + order_id;
    CUR_DIALOG = ajax_form('cancel_order', '放弃订单', _uri, 640);
}

function fg_cancel(id) {
	if (typeof id == 'number') {
    	var id = new Array(id.toString());
	};
	if(confirm('取消后将不能恢复，确认取消这 ' + id.length + ' 项吗？')){
		id = id.join(',');
	} else {
        return false;
    }
	$.ajax({
        type: "GET",
        dataType: "json",
        url: "index.php?act=order&op=change_state&state_type=cancel",
        data: "order_id="+id,
        success: function(data){
            if (data.state){
                $("#flexigrid").flexReload();
            } else {
            	alert(data.msg);
            }
        }
    });
}
</script> 
