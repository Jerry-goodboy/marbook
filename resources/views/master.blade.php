<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/weui.css">
    <link rel="stylesheet" href="/css/book.css">
</head>
<body>
    <div class="page">
        @yield('content')
    </div>

    <!-- tooltips -->
    <div class="bk_toptips"><span></span></div>
    <div id="global_menu" onclick="onMenuClick();">
        <div></div>
    </div>

    <!--BEGIN actionSheet-->
    <div id="actionSheet_wrap">
        <div class="weui_mask_transition" id="mask"></div>
        <div class="weui_actionsheet" id="weui_actionsheet">
            <div class="weui_actionsheet_menu">
                <div class="weui_actionsheet_cell" onclick="onMenuItemClick(1)">用户中心</div>
                <div class="weui_actionsheet_cell" onclick="onMenuItemClick(2)">选择套餐</div>
                <div class="weui_actionsheet_cell" onclick="onMenuItemClick(3)">周边油站</div>
                <div class="weui_actionsheet_cell" onclick="onMenuItemClick(4)">常见问题</div>
            </div>
            <div class="weui_actionsheet_action">
                <div class="weui_actionsheet_cell" id="actionsheet_cancel">取消</div>
            </div>
        </div>
    </div>
</body>
<script src="/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
function hideActionSheet(weuiActionsheet, mask) {

}
</script>

@yield('my-js')
</html>