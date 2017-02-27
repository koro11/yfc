<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 商家</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=4.1.0" rel="stylesheet">
</head>
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="height:70px;">
                        <h5>商家基本 <small>信息</small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
                        <div class="ibox-tools"  style="height:70px;margin-top:10px;">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="table_data_tables.html#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="table_data_tables.html#">选项1</a>
                                </li>
                                <li><a href="table_data_tables.html#">选项2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>店名</th>
                                    <th>商家地址</th>
                                    <th>商家联系方式</th>
                                    <th>商家入驻时间</th>
                                    <th>商家运营状态</th>
                                    <th>商家特色</th>
                                    <th>商家简介</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($merchant as $v) { ?>
                                <tr>
                                    <td><?=$v['mer_name']?></td>
                                    <td><?=$v['mer_address']?></td>
                                    <td><?=$v['mer_phone']?></td>
                                    <td><?=$v['mer_register_time']?></td>
                                    <td >
                                    <?php if($v['mer_status'] == 0){?>
                                        <a href="javascript:void(0);" class="updateStatus"><span status="<?=$v['mer_status']?>" mer_id="<?=$v['mer_id']?>">运营</span></a>
                                    <?php }else{ ?>
                                        <a href="javascript:void(0);" class="updateStatus"><span status="<?=$v['mer_status']?>" mer_id="<?=$v['mer_id']?>">歇业</span></a>
                                    <?php } ?>
                                    </td>
                                    <td><?=$v['info_specialty']?></td>
                                    <td><?=$v['info_desc']?></td>
                                    <td>
                                        <button class="btn btn-info btn-rounded" mer_id="<?=$v['mer_id']?>" id="delPic" url="?r=user/shop_del">删除</button><br/>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 全局js -->
    <script src="js/jquery.min.js?v=2.1.4"></script>
    <script src="js/bootstrap.min.js?v=3.3.6"></script>



    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- 自定义js -->
    <script src="js/content.js?v=1.0.0"></script>


    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function () {
            $('.dataTables-example').dataTable();

            /* Init DataTables */
            var oTable = $('#editable').dataTable();

            /* Apply the jEditable handlers to the table */
            oTable.$('td').editable('../example_ajax.php', {
                "callback": function (sValue, y) {
                    var aPos = oTable.fnGetPosition(this);
                    oTable.fnUpdate(sValue, aPos[0], aPos[1]);
                },
                "submitdata": function (value, settings) {
                    return {
                        "row_id": this.parentNode.getAttribute('id'),
                        "column": oTable.fnGetPosition(this)[2]
                    };
                },

                "width": "90%",
                "height": "100%"
            });


        });

        function fnClickAddRow() {
            $('#editable').dataTable().fnAddData([
                "Custom row",
                "New row",
                "New row",
                "New row",
                "New row"]);

        }
    </script>

    
    

</body>

</html>
<script>
    //商家运营状态修改
    $(document).on('click','.updateStatus',function(){
        var _this = $(this);
        var is_show = _this.children().attr('status');
        var mer_id = _this.children().attr('mer_id');
        $.ajax({
            dataType:"json",
            url:"?r=user/shop_status",
            data:{is_show:is_show,mer_id:mer_id},
            type:"post",
            success:function(msg){
                if (msg.mer_status == 0) {
                    _this.html('<span status="'+msg.mer_status+'" mer_id="'+msg.mer_id+'">运营</span>');
                }else{
                    _this.html('<span status="'+msg.mer_status+'" mer_id="'+msg.mer_id+'">歇业</span>');
                }
            }
        })
        
    })

    //删除停业店铺
    $(document).on('click','#delPic',function(){
        var _this = $(this);
        var mer_id = _this.attr('mer_id');
        var url = _this.attr('url');
        if (confirm("确认删除吗")) {
            $.ajax({
                type:'post',
                data:{mer_id:mer_id},
                url:url,
                success:function(msg){
                //alert(msg);return false;
                    if (msg == 'yes') {
                        _this.parent().parent().remove();
                    }else{
                        alert('商铺处于正常营业状态，请勿删除');
                    }
                }
            })
        }
    })
</script>