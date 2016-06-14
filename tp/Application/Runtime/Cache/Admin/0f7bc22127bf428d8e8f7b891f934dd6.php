<?php if (!defined('THINK_PATH')) exit();?><!-- 模板-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>后台管理系统</title>
    <meta name="author" content="DeathGhost" />
    <link rel="stylesheet" type="text/css" href="/Public/assets/css/style.css" />
    <!--[if lt IE 9]>
    <script src="/Public/assets/js/html5.js"></script>
    <![endif]-->
    <script src="/Public/assets/js/jquery.js"></script>
    <script src="/Public/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script>
        (function($){
            $(window).load(function(){

                $("a[rel='load-content']").click(function(e){
                    e.preventDefault();
                    var url=$(this).attr("href");
                    $.get(url,function(data){
                        $(".content .mCSB_container").append(data); //load new content inside .mCSB_container
                        //scroll-to appended content
                        $(".content").mCustomScrollbar("scrollTo","h2:last");
                    });
                });

                $(".content").delegate("a[href='top']","click",function(e){
                    e.preventDefault();
                    $(".content").mCustomScrollbar("scrollTo",$(this).attr("href"));
                });

            });
        })(jQuery);
    </script>
</head>
<body>
<!--header-->
<header>
    <h1><img src="/Public/assets/images/admin_logo.png"/></h1>
    <ul class="rt_nav">
        <li><a href="http://www.baidu.com" target="_blank" class="website_icon">站点首页</a></li>
        <li><a href="#" class="admin_icon"><?php echo ($_SESSION['username']); ?></a></li>
        <li><a href="#" class="set_icon">账号设置</a></li>
        <li><a href="<?php echo U('Login/logOut');?>" class="quit_icon">安全退出</a></li>
    </ul>
</header>

<!--aside nav-->
<aside class="lt_aside_nav content mCustomScrollbar">
    <h2><a href="index.php">起始页</a></h2>
    <ul>
        <?php if(is_array($nodeList)): $i = 0; $__LIST__ = $nodeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
            <dl>
                <dt><?php echo ($vo["title"]); ?></dt>
                <!--当前链接则添加class:active-->
                <?php if(is_array($vo["nodes"])): $i = 0; $__LIST__ = $vo["nodes"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$svo): $mod = ($i % 2 );++$i; if(($vo["name"] == $controller_name) and ($svo["name"] == $action_name)): ?><dd><a href="/index.php/Admin/<?php echo ($vo["name"]); ?>/<?php echo ($svo["name"]); ?>" class="active"><?php echo ($svo["title"]); ?></a></dd>
                        <?php else: ?>
                        <dd><a href="/index.php/Admin/<?php echo ($vo["name"]); ?>/<?php echo ($svo["name"]); ?>"><?php echo ($svo["title"]); ?></a></dd><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </dl>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
        <li>
            <dl>
                <dt>会员管理</dt>
                <dd><a href="#">会员列表</a></dd>
                <dd><a href="#">添加会员</a></dd>
                <dd><a href="#">会员等级</a></dd>
                <dd><a href="#">资金管理</a></dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>基础设置</dt>
                <dd><a href="#">站点基础设置</a></dd>
                <dd><a href="#">SEO设置</a></dd>
                <dd><a href="#">SQL语句查询</a></dd>
                <dd><a href="#">模板管理</a></dd>
            </dl>
        </li>
    </ul>
</aside>


<section class="rt_wrap content mCustomScrollbar">
 <div class="rt_content">
     <!--开始：以下内容则可删除，仅为素材引用参考-->
     <section>
         <h2><strong style="color:grey;">编辑权限</strong></h2>
         <ul class="ulColumn2">
             <form action="/index.php/Admin/Rbac/addNodeHandler" method="post">
                 <input type="hidden" name="id" value="<?php echo ($item["id"]); ?>" />
                 <li>
                     <span class="item_name" style="width:120px;">权限英文名称：</span>
                     <input type="text" class="textbox textbox_225" name="name" value="<?php echo ($item["name"]); ?>"/>
                 </li>
                 <li>
                     <span class="item_name" style="width:120px;">权限中文名称：</span>
                     <input type="text" class="textbox textbox_225" name="title" value="<?php echo ($item["title"]); ?>"/>
                 </li>
                 <li>
                     <span class="item_name" style="width:120px;">是否启用：</span>
                     <label class="single_selection"><input type="radio" name="status" value="1" checked/>启用</label>
                     <label class="single_selection"><input type="radio" name="status" value="0" <?php if(($item["status"]) == "0"): ?>checked<?php endif; ?>/>禁用</label>

                 </li>
                 <li>
                     <span class="item_name" style="width:120px;">类型：</span>
                     <select class="select textbox_100" name="type" style="width:100px">
                         <option value="1">项目</option>
                         <option value="2">模块</option>
                         <option value="3">操作</option>
                         <option value="4">功能</option>
                     </select>
                 </li>
                 <li>
                     <span class="item_name" style="width:120px;">父级：</span>
                     <select class="select textbox_100" name="pid">
                         <option value="0">根节点</option>
                         <?php if(is_array($node)): $i = 0; $__LIST__ = $node;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>">
                                 <?php $__FOR_START_26901__=1;$__FOR_END_26901__=$vo['level'];for($i=$__FOR_START_26901__;$i < $__FOR_END_26901__;$i+=1){ ?>&nbsp;&nbsp;<?php } ?>
                                 |- <?php echo ($vo["title"]); ?>
                             </option><?php endforeach; endif; else: echo "" ;endif; ?>
                     </select>
                 </li>

                 <li>
                     <span class="item_name" style="width:120px;">描述：</span>
                     <input type="text" class="textbox textbox_225" name="remark" value="<?php echo ($item["remark"]); ?>"/>
                 </li>
                 <li>
                     <span class="item_name" style="width:120px;">排序：</span>
                     <input type="text" class="textbox textbox_100" name="sort" value="<?php echo ($item["sort"]); ?>"/>
                 </li>
                 <li>
                     <span class="item_name" style="width:120px;"></span>
                     <input type="submit" class="link_btn" value="保存"/>
                 </li>
             </form>
         </ul>
     </section>
     <!--结束：以下内容则可删除，仅为素材引用参考-->
 </div>
</section>


</body>
</html>