<?php defined('InShopNC') or exit('Access Invalid!');?>

<form method="post" name="form1" id="form1" action="<?php echo urlSCMClient('cancel_order', 'order_cancel');?>">
  <input type="hidden" name="form_submit" value="ok" />
  <input type="hidden" value="<?php echo $output["order_no"];?>" name="order_no">
  <input type="hidden" value="<?php echo $output["common_info"]["goods_barcode"];?>" name="goods_barcode">
  <div class="ncap-form-default">
  <dl class="row">
      <dt class="tit">订单编号</dt><dd class="opt"><?php echo $output['order_no'];?></dd></dl>
      <dl class="row">
      <dt class="tit">供应商编号</dt><dd class="opt"><?php echo $output['common_info']['supp_id'];?></dd></dl>
      <dl class="row">
      <dt class="tit">供应商名称</dt><dd class="opt"><?php echo $output['supplier_info']['supp_ch_name'];?></dd></dl>
      <dl class="row">
      <dt class="tit">订单日期</dt><dd class="opt"><?php echo $output['common_info']['order_date'];?></dd></dl>

    <div class="bot"><a href="javascript:void(0);" class="ncap-btn-big ncap-btn-green" nctype="btn_submit"><?php echo $lang['nc_submit'];?></a></div>
  </div>
</form>
<script>
$(function(){
    $('a[nctype="btn_submit"]').click(function(){
        ajaxpost('form1', '', '', 'onerror');
    });
});
</script>