<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 添加轮播图</title>
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
</head>

<body>
    <div class="col-sm-7" align="center">
        <div class="ibox float-e-margins" style="width:1050px;">
            <div class="ibox-title">
                <h5>轮播图<small>添加</small></h5>
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
                <h3>
                    添加轮播图
                </h3>
                <form class="form-horizontal m-t-md" action="?r=shuffing/shuffing_add" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">添加图片</label>
                        <div class="col-sm-10">
                            <input type="file" name="file" placeholder="" value="">

                            <input type="hidden" id="_csrf" name="<?php echo Yii::$app->request->csrfParam;?>" value="<?php echo yii::$app->request->csrfToken?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary ">确认添加</button>
                        <a href="dataBase"><button class="btn btn-primary ">返回</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>