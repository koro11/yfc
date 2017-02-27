<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 热门菜</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">

    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">

    <link href="css/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">

    <link href="css/plugins/cropper/cropper.min.css" rel="stylesheet">

    <link href="css/plugins/switchery/switchery.css" rel="stylesheet">

    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">

    <link href="css/plugins/nouslider/jquery.nouislider.css" rel="stylesheet">

    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <link href="css/plugins/ionRangeSlider/ion.rangeSlider.css" rel="stylesheet">
    <link href="css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css" rel="stylesheet">

    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">

    <link href="css/plugins/clockpicker/clockpicker.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=4.1.0" rel="stylesheet">
    <style>
    span{
        cursor: pointer;
    }
    </style>
    <script src="js/jquery.min.js"></script>
</head>

<body>
    <div class="col-sm-7" align="center">
        <div class="ibox float-e-margins" style="width:1050px;">
            <div class="ibox-title">
                <h5>热门菜<small>展示</small></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="form_advanced.html#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="form_advanced.html#">选项1</a>
                        </li>
                        <li><a href="form_advanced.html#">选项2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <h3>展示</h3>
                <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>热门菜</th>
                                    <th>搜索次数</th>
                                    <th>显示状态</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($hot_food as $v) : ?>
                                <tr align="center">
                                    <td word_id="<?=$v['word_id']?>">
                                        <input type="text" value="<?=$v['word_id']?>" class="sort" size="1" style="text-align:center;border:1px solid #007500;background:#AFAF61;color:     #FF2D2D">
                                    </td>
                                    <td><?=$v['hot_word']?></td>
                                    <td><?=$v['hot_length']?></td>
                                    <td class="updateStatus">
                                        <?php if($v['show_status'] == 0){ ?>
                                        <span status="<?=$v['show_status']?>" word_id="<?=$v['word_id']?>">
                                            显示
                                        </span>
                                        <?php }else{ ?>
                                         <span status="<?=$v['show_status']?>" word_id="<?=$v['word_id']?>">
                                            隐藏
                                        </span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-w-m btn-danger" word_id="<?=$v['word_id']?>" id="delPic" url="?r=hotword/del_hotfood">删除</button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                            <script>
                                //删除
                                    $(document).on('click','#delPic',function(){
                                        var _this = $(this);
                                        var word_id = _this.attr('word_id');
                                        var url = _this.attr('url');
                                        if (confirm("确认删除吗")) {
                                            $.ajax({
                                                type:'post',
                                                data:{word_id:word_id},
                                                url:url,
                                                success:function(msg){
                                                //alert(msg);
                                                    if (msg == 'ok') {
                                                        _this.parent().parent().remove();
                                                    }else{
                                                        alert('删除失败');
                                                    }

                                                }
                                            })
                                        }
                                    })
                                
                                //在前台是否显示的即点即改
                                    $(document).on('click','.updateStatus',function(){
                                        var _this = $(this);
                                        var is_show = _this.children().attr('status');
                                        var word_id = _this.children().attr('word_id');
                                        $.ajax({
                                            dataType:"json",
                                            url:"?r=hotword/hotfood_status",
                                            data:{is_show:is_show,word_id:word_id},
                                            type:"post",
                                            success:function(msg){
                                                if (msg.show_status == 0) {
                                                    _this.html('<span status="'+msg.show_status+'" word_id="'+msg.word_id+'">显示</span>');
                                                }else{
                                                    _this.html('<span status="'+msg.show_status+'" word_id="'+msg.word_id+'">隐藏</span>');
                                                }
                                            }
                                        })
                                        
                                    })

                                </script>
                            <tfoot>
                            </tfoot>
                        </table>

                    </div>
            </div>
        </div>
    </div>
</body>

</html>
