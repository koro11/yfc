<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 个人</title>
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
                        <h5>个人基本 <small>信息</small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
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
                                    <th>用户名</th>
                                    <th>用户联系方式</th>
                                    <th>用户注册时间</th>
                                    <th>用户状态</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($user as $v) { ?>
                                <tr>
                                    <td><?=$v['user_name']?></td>
                                    <td><?=$v['user_phone']?></td>
                                    <td><?=$v['register_time']?></td>
                                    <td>
                                    <?php if($v['user_status'] == 0){?>
                                        <a href="javascript:void(0);" class="updateStatus"><span status="<?=$v['user_status']?>" user_id="<?=$v['user_id']?>">正常</span></a>
                                    <?php }else{ ?>
                                        <a href="javascript:void(0);" class="updateStatus"><span status="<?=$v['user_status']?>" user_id="<?=$v['user_id']?>">锁定</span></a>
                                    <?php } ?>
                                    </td>
    
                                    <td>
                                        <button class="btn btn-info btn-rounded" user_id="<?=$v['user_id']?>" id="delPic" url="?r=user/user_del">删除</button><br/>
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
    //用户状态修改
    $(document).on('click','.updateStatus',function(){
        var _this = $(this);
        var is_show = _this.children().attr('status');
        var user_id = _this.children().attr('user_id');
        $.ajax({
            dataType:"json",
            url:"?r=user/user_status",
            data:{is_show:is_show,user_id:user_id},
            type:"post",
            success:function(msg){
                if (msg.user_status == 0) {
                    _this.html('<span status="'+msg.user_status+'" user_id="'+msg.user_id+'">正常</span>');
                }else{
                    _this.html('<span status="'+msg.user_status+'" user_id="'+msg.user_id+'">锁定</span>');
                }
            }
        })
        
    })

    //删除锁定用户
    $(document).on('click','#delPic',function(){
        var _this = $(this);
        var user_id = _this.attr('user_id');
        var url = _this.attr('url');
        if (confirm("确认删除吗")) {
            $.ajax({
                type:'post',
                data:{user_id:user_id},
                url:url,
                success:function(msg){
                //alert(msg);return false;
                    if (msg == 'yes') {
                        _this.parent().parent().remove();
                    }else{
                        alert('用户处于正常状态，请勿删除');
                    }
                }
            })
        }
    })
</script>