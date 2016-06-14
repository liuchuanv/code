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
         <div class="page_title">
             <h2 class="fl">节点列表</h2>
         </div>
         <table class="table">
             <tr>
                 <th>权限id--权限排序</th>
                 <th>中文名称</th>
                 <th>英文名称</th>
                 <th>类型</th>
                 <th>描述</th>
                 <th>操作</th>
             </tr>
             <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                 <td><?php echo ($vo["id"]); ?>--<?php echo ($vo["sort"]); ?></td>
                 <td style="text-align:left;text-indent:<?php echo ($vo['level']*20-20); ?>px">|- <?php echo ($vo["title"]); ?></td>
                 <td><?php echo ($vo["name"]); ?></td>
                 <td class="c-<?php echo ($vo["type"]); ?>"><?php if(($vo["type"] == 1)): ?>项目<?php elseif(($vo["type"] == 2)): ?>模块<?php elseif(($vo["type"] == 3)): ?>操作<?php elseif(($vo["type"] == 4)): ?>功能<?php endif; ?></td>
                 <td style="width:265px;"><div class="cut_title ellipsis"><?php echo ($vo["remark"]); ?></div></td>
                 <td>
                     <a href="/index.php/Admin/Rbac/addNode?id=<?php echo ($vo["id"]); ?>">编辑</a>
                     <a href="/index.php/Admin/Rbac/deleteNodeHandler?id=<?php echo ($vo["id"]); ?>">删除</a>
                 </td>
             </tr><?php endforeach; endif; else: echo "" ;endif; ?>
         </table>

         <aside class="paging">
             <?php echo ($page); ?>
         </aside>
     </section>
     <!--结束：以下内容则可删除，仅为素材引用参考-->
 </div>
</section>


</body>
</html>