<?php use \yii\helpers\Url;?>
 <article class="U-article Overflow">
  <!--user Account-->
  <section class="AccManage Overflow">
   <span class="AMTitle Block Font14 FontW Lineheight35">账户管理</span>
   <p>登陆邮箱：<?=$user['user_email']?>
   <p>手机号码：<?=$user['users']['user_phone']?>  </p>
   <p>上次登陆：<?=date("Y年m月d日 H:i:s",$user['users']['last_logintime'])?>( *如非本人登陆，请立即修改您的密码！ )</p>
   <form action="<?=Url::to('user/up_account')?>" method="post" enctype="multipart/form-data">
    <table>
    <tr>
    <td width="30%" align="right">*修改头像：</td>
    <td><input name="myfile" type="file"></td>
    </tr>
    <input type="hidden" name="user_id" value="<?php echo $user['user_id']?>">
    <tr>
    <td width="30%" align="right">*昵称：</td>
    <td><input type="text" name="user_name" value="<?php echo $user['user_name']?>"></td>
    </tr>
    <tr>
    <td width="30%" align="right">*邮箱：</td>
    <td><input type="email" name="user_email" value="<?php echo $user['user_email']?>"></td>
    </tr>
    <tr>
    <td width="30%" align="right">*性别：</td>
    <td><input type="radio" name="user_sex" value="男">男
        <input type="radio" name="user_sex" value="女">女
    </td>
    </tr>
    <tr>
    <td width="30%" align="right">*手机：</td>
    <td><input type="tel" name="user_phone" value="<?php echo $user['users']['user_phone']?>"></td>
    </tr>
     <tr>
    <td width="30%" align="right">*密码：</td>
    <td><input type="password" name="user_password" value="<?php echo $user['users']['user_password']?>"></td>
    </tr>
    <tr>
    <td></td>
    <td><input type="submit"  value="保 存"></td>
    </tr>
    </table>
   </form>
  </section>
 </article>
</section>
<!--End content-->

