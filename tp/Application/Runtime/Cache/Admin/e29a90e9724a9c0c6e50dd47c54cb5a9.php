<?php if (!defined('THINK_PATH')) exit();?><!-- 模板-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>后台管理系统</title>
    <meta name="author" content="DeathGhost" />
    <link rel="stylesheet" type="text/css" href="/tp/Public/assets/css/style.css" />
    <!--[if lt IE 9]>
    <script src="/tp/Public/assets/js/html5.js"></script>
    <![endif]-->
    <script src="/tp/Public/assets/js/jquery.js"></script>
    <script src="/tp/Public/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
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
    <h1><img src="/tp/Public/assets/images/admin_logo.png"/></h1>
    <ul class="rt_nav">
        <li><a href="http://www.baidu.com" target="_blank" class="website_icon">站点首页</a></li>
        <li><a href="#" class="admin_icon">DeathGhost</a></li>
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
                <?php if(is_array($vo["nodes"])): $i = 0; $__LIST__ = $vo["nodes"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$svo): $mod = ($i % 2 );++$i; if(($vo["name"] == $controller_name) and ($svo["name"] == $action_name)): ?><dd><a href="/tp/index.php/Admin/<?php echo ($vo["name"]); ?>/<?php echo ($svo["name"]); ?>" class="active"><?php echo ($svo["title"]); ?></a></dd>
                        <?php else: ?>
                        <dd><a href="/tp/index.php/Admin/<?php echo ($vo["name"]); ?>/<?php echo ($svo["name"]); ?>"><?php echo ($svo["title"]); ?></a></dd><?php endif; endforeach; endif; else: echo "" ;endif; ?>
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
<link rel="stylesheet" href="/tp/Public/assets/js/zTree/zTreeStyle.css" />
<script src="/tp/Public/assets/js/zTree/jquery.ztree.core.js"></script>
<script src="/tp/Public/assets/js/zTree/jquery.ztree.excheck.js"></script>

<script>
    var setting = {
        view: {
            showIcon: false
        },
        check: {
            enable: true
        },
        data: {
            simpleData: {
                enable: true,
                pIdKey : 'pid'
            }
        }
    };

    var zNodes = <?php echo ($nodeJsonStr); ?>;

    var code;

    function setCheck() {
        var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
                py = "p",
                sy = "s",
                pn = "p",
                sn = "s",
                type = { "Y":py + sy, "N":pn + sn};
        zTree.setting.check.chkboxType = type;
        showCode('setting.check.chkboxType = { "Y" : "' + type.Y + '", "N" : "' + type.N + '" };');
    }
    function showCode(str) {
        if (!code) code = $("#code");
        code.empty();
        code.append("<li>"+str+"</li>");
    }

    $(document).ready(function(){
        $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        setCheck();
        $("#py").bind("change", setCheck);
        $("#sy").bind("change", setCheck);
        $("#pn").bind("change", setCheck);
        $("#sn").bind("change", setCheck);

        //
        $("#saveBtn").click(function(){
            $(".loading_area").fadeIn();
            var nodes = $.fn.zTree.getZTreeObj("treeDemo").getCheckedNodes(true);
            var access = [];
            $.each(nodes, function(i){
                access.push(nodes[i].id);
            });
            $.post("/tp/index.php/Admin/Rbac/accessHandler", {"access" : access, "rid" : $("#rid").val() }, function(data){
                $(".loading_area").fadeOut(1500);
                $(".pop_bg .pop_cont h3").text("提示信息");
                $(".pop_bg .pop_cont .pop_cont_text").text(data.message);
                $(".pop_bg").fadeIn();
                setTimeout(function(){
                    $(".pop_bg").fadeOut();
                    window.location.reload();
                },2000);
            });
        });
    });

</script>
<section class="rt_wrap content mCustomScrollbar">
 <div class="rt_content">
     <!--开始：以下内容则可删除，仅为素材引用参考-->
     <section>
         <h2><strong style="color:grey;">正在给【<?php echo ($role["name"]); ?>】配置权限</strong></h2>
         <div class="checkWrap" style="margin-left : 100px;">
             <input type="hidden" name="rid" id="rid" value="<?php echo ($role["id"]); ?>" />
             <ul id="treeDemo" class="ztree" style="margin-bottom:20px;"></ul>
             <input type="submit" class="link_btn" id="saveBtn" value="保存"/>
         </div>

     </section>

     <section class="loading_area">
         <div class="loading_cont">
             <div class="loading_icon"><i></i><i></i><i></i><i></i><i></i></div>
             <div class="loading_txt"><mark>数据正在加载，请稍后！</mark></div>
         </div>
     </section>
     <section class="pop_bg">
         <div class="pop_cont">
             <!--title-->
             <h3><!--标题--></h3>
             <div class="pop_cont_text">
                 <!--内容-->
             </div>
         </div>
     </section>
    <!--结束：以下内容则可删除，仅为素材引用参考-->
 </div>
</section>


</body>
</html>