<?php
use yii\widgets\LinkPager; 
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 轮播列表</title>
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
    .pagination{margin:20px 0; overflow:hidden;line-height:30px;list-style:none;}
    .pagination a,.pagination span{height:30px; line-height:30px;margin:0 10px 10px 0; float:left;padding:0 10px; color:#fff; background:#91cebe;-webkit-transition: .2s;-moz-transition: .2s;transition: .2s;}
    .pagination a:hover,.pagination span:hover{background:#009875;-webkit-transition: .2s;-moz-transition: .2s;transition: .2s;}
    .pagination a.current,.pagination span.current,.pagination span.disabled{background:#009875;cursor:pointer;}
    .pagination input{border:1px solid #cbcbcb;margin:0 5px; height:28px;font-size:16px;line-height:28px;}
    </style>
    <script src="js/jquery.min.js"></script>
</head>

<body>
    <div class="col-sm-7" align="center">
        <div class="ibox float-e-margins" style="width:1050px;">
            <div class="ibox-title">
                <h5>轮播图<small>展示</small></h5>
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
                                    <th>排序</th>
                                    <th>效果图</th>
                                    <th>是否显示</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($shuffing_img as $v) : ?>
                                <tr align="center">
                                    <td pic_id="<?=$v['pic_id']?>">
                                        <input type="text" value="<?=$v['sort']?>" class="sort" size="1" style="text-align:center;border:1px solid #007500;background:#AFAF61;color:     #FF2D2D">
                                    </td>
                                    <td><img src="<?=$v['path']?>" width="200"></td>
                                    <td class="updateStatus">
                                        <?php if($v['is_show'] == 0){ ?>
                                        <span status="<?=$v['is_show']?>" pic_id="<?=$v['pic_id']?>">
                                            显示
                                        </span>
                                        <?php }else{ ?>
                                         <span status="<?=$v['is_show']?>" pic_id="<?=$v['pic_id']?>">
                                            隐藏
                                        </span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-w-m btn-danger" pic_id="<?=$v['pic_id']?>" id="delPic" url="?r=shuffing/del_shuffing">删除</button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                            <script>
                                //删除库中图片并删除上传的文件
                                    $(document).on('click','#delPic',function(){
                                        var _this = $(this);
                                        var pic_id = _this.attr('pic_id');
                                        var url = _this.attr('url');
                                        if (confirm("确认删除吗")) {
                                            $.ajax({
                                                type:'post',
                                                data:{pic_id:pic_id},
                                                url:url,
                                                success:function(msg){
                                            
                                                    if (msg == 'ok') {
                                                        _this.parent().parent().remove();
                                                    }else{
                                                        alert('删除失败');
                                                    }

                                                }
                                            })
                                        }
                                    })
                                
                                //图片在前台是否显示的即点即改
                                    $(document).on('click','.updateStatus',function(){
                                        var _this = $(this);
                                        var is_show = _this.children().attr('status');
                                        var pic_id = _this.children().attr('pic_id');
                                        $.ajax({
                                            dataType:"json",
                                            url:"?r=shuffing/shuffing_status",
                                            data:{is_show:is_show,pic_id:pic_id},
                                            type:"post",
                                            success:function(msg){
                                                if (msg.is_show == 0) {
                                                    _this.html('<span status="'+msg.is_show+'" pic_id="'+msg.pic_id+'">显示</span>');
                                                }else{
                                                    _this.html('<span status="'+msg.is_show+'" pic_id="'+msg.pic_id+'">隐藏</span>');
                                                }
                                            }
                                        })
                                        
                                    })

                                //即点即改  排序
                                    $(document).on('blur','.sort',function(){
                                      var sort=$(this).val();
                                      //alert(sort);
                                      var pic_id=$(this).parent().attr('pic_id');
                                      obj=$(this);
                                      $.ajax({
                                       type: "POST",
                                       url: "?r=shuffing/shuffing_sort",
                                       data: {
                                            sort:sort,
                                            pic_id:pic_id
                                       },
                                       dataType:'json',
                                       success: function(msg){
                                        //alert(msg);return false;
                                        obj.parent().html('<input type="text" value="'+msg.sort+'" size="1" style="text-align:center;border:1px solid #007500;background:#AFAF61;color:     #FF2D2D">');   
                                       }
                                    })
                                  })  
                                </script>
                            <tfoot>
                            </tfoot>
                        </table>
<?php
echo LinkPager::widget([
    'pagination' => $pages,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
    'firstPageLabel'=>'首页',
    'lastPageLabel'=>'尾页'
 ]);?>
                    </div>
            </div>
        </div>
    </div>
</body>

</html>
