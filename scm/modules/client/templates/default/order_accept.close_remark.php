<?php defined('InShopNC') or exit('Access Invalid!');?>

<form method="post" name="form1" id="form1" action="<?php echo urlSCMClient('accept_order', 'order_accept');?>">
  <input type="hidden" name="form_submit" value="ok" />
  <input type="hidden" value="<?php echo $output['common_info']['order_id'];?>" name="order_id">
  <div class="ncap-form-default">
  <dl class="row">
      <dt class="tit">订单编号</dt><dd class="opt"><?php echo $output['common_info']['order_sn'];?></dd></dl>
      <dl class="row">
      <dt class="tit">买家姓名</dt><dd class="opt"><?php echo $output['common_info']['buyer_name'];?></dd></dl>
      <dl class="row">
      <dt class="tit">买家电话</dt><dd class="opt"><?php echo $output['common_info']['buyer_phone'];?></dd></dl>
      <dl class="row">
      <dt class="tit">买家地址</dt><dd class="opt"><?php echo $output['common_info']['buyer_address'];?></dd></dl>
      <dl class="row">
      <dt class="tit">订单日期</dt><dd class="opt"><?php echo $output['common_info']['add_time'];?></dd></dl>

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