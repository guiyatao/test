<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3><?php echo "合作终端店";?></h3>
                <h5><?=$output['subject']?></h5>
            </div>
        </div>
    </div>
    <!-- 操作说明 -->
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
            <h4 title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
            <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span>
        </div>
        <ul>
            <li><?=$output['explanation']?></li>
            <li>终端店电话:<span style="color: red;font-size: large;font-size: large"><?=$output['client_info']['clie_tel']?></span></li>
            <li>终端店手机:<span style="color: red;font-size: large;font-size: large"><?=$output['client_info']['clie_mobile']?></span></li>
            <li><?=$output['explanation_1']?></li>
        </ul>
    </div>
    <div id="flexigrid"></div>

</div>

<script>
    $(function(){
        $('#flexigrid').flexigrid({
            url:'index.php?act=client&op=unsalable_warn_xml&clie_id=<?=$output['clie_id']?>',
            colModel:[
                {display: '序号', name : 'number', width : 50, sortable : false, align: 'center'},
                {display: '终端店ID', name : 'clie_id', width : 120, sortable : true, align: 'center'},
                {display: '终端店名称', name : 'clie_ch_name', width : 180, sortable : true, align: 'center'},
                {display: '商品条码', name : 'goods_barcode', width : 120, sortable : true, align: 'center'},
                {display: '商品名称', name : 'goods_nm', width : 180, sortable : true, align: 'left'},
                {display: '库存单位', name : 'goods_unit', width : 50, sortable : false, align: 'center'},
                {display: '库存', name : 'goods_stock', width : 50, sortable : false, align: 'center'},
                {display: '商品规格', name : 'goods_spec', width : 80, sortable : false, align: 'center'},
                {display: '滞销提醒天数', name : 'drug_remind', width : 100, sortable : false, align: 'center'},
                {display: '最后一次进货时间', name : 'last_time', width : 150, sortable : false, align: 'center'},
                {display: '生产厂家', name : 'produce_company', width : 150, sortable : false, align: 'center'},
            ],
            buttons:[
                {display: '<i class="fa fa-file-excel-o"></i>导出数据', name : 'csv', bclass : 'csv', title : '将选定行数据导出Excel文件', onpress : fg_operation },
            ],
            title:"<?=$output['title']?>",
        });

    });

    function fg_operation(name, bDiv) {
        if (name == 'csv') {
            if ($('.trSelected', bDiv).length == 0) {
                if (!confirm('您确定要下载全部数据吗？')) {
                    return false;
                }
            }
            var itemids = new Array();
            $('.trSelected', bDiv).each(function(i){
                itemids[i] = $(this).attr('data-id');
            });
            fg_csv(itemids);
        }else if(name == 'confirm'){
            $("#order_detail_form").submit();
        }
    }

    function fg_csv(ids) {
        id = ids.join(',');
        window.location.href = $("#flexigrid").flexSimpleSearchQueryString()+'&op=export_unsalable_warn_csv&id=' + id +'&clie_id=<?=$output['clie_id']?>';
    }

</script>