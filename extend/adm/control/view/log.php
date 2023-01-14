<?php
/*
Sort:3
icons:si si-pie-chart
Hidden:false
Name:操作日志
Url:control_log
*/
if ( !isset($islogin)) header("Location: /");//非法访问
$nums = $db::table('web_log')->count();
$page = isset($_GET[ 'page' ]) ? intval($_GET[ 'page' ]) : 1;
$url = "./?control_log&page=";
$ENUMS = PAGES; // 每页条数
$bnums = ( $page - 1 ) * $ENUMS;
?>
<style>
    td {
        white-space: nowrap;
    }
</style>
<div class="col-12">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">操作日志</h3>
        </div>
    </div>
</div>

<div class="col-xl-12">
    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">操作日志 <small>每页展示<?php
                    echo PAGES; ?>条数据</small>
            </h3>
        </div>
        <div class="block-content block-content-full">
            <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive  no-footer dtr-inline"
                               id="task-logs-list" data-type="sport"
                               aria-describedby="task-logs-list_info">
                            <thead>
                            <tr>
                                <th style="width: 10px;text-align: center;">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="all"
                                               onclick="checkAll();" />
                                    </div>
                                </th>
                                <th style="text-align: center;" rowspan="1" colspan="1">
                                    IP
                                </th>
                                <th style="text-align: center" rowspan="1" colspan="1">详细地址</th>
                                <th style="text-align: center;" rowspan="1" colspan="1">
                                    事件
                                </th>
                                <th style="text-align: center;" rowspan="1" colspan="1">
                                    时间
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $res = Db::table('web_log')->order('id ASC')->limit($bnums , $ENUMS)->select();
                            if (json_encode($res) == '[]') {
                                if ( !empty($_GET[ 'page' ])) {
                                    $url = ( ( $_SERVER[ 'SERVER_PORT' ] == 443 ) ? 'https' : 'http' ) . '://' . $_SERVER[ 'HTTP_HOST' ] . str_replace($_SERVER[ 'DOCUMENT_ROOT' ] , ( substr($_SERVER[ 'DOCUMENT_ROOT' ] , -1) == '/' ) ? '/' : '' , dirname($_SERVER[ 'SCRIPT_FILENAME' ]));
                                    $js = '<script>window.location="' . $url . '/?user_edit&id=' . $user_info[ 'id' ] . '"</script>';
                                    echo $js;
                                }
                                echo '<td style="text-align: center;" colspan="5" class="dataTables_empty"><i class="si si-drawer fa-2x"></i><p class="text-muted fs-sm">暂无数据</p></td>';
                            }
                            foreach ($res as $k => $v) {
                                $row = $res[ $k ];
                                ?>
                                <tr class="odd">
                                    <td style="text-align: center;" class="fs-sm">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="ids[]"
                                                   value="<?php
                                                   echo $row[ 'id' ]; ?>" id="<?php
                                            echo 'check_' . $row[ 'id' ]; ?>">
                                            <label class="custom-control-label" for="<?php
                                            echo 'check_' . $row[ 'id' ]; ?>"></label>
                                        </div>
                                    </td>

                                    <td style="text-align: center;" class="fs-sm">
                                        <?php
                                        echo $row[ 'ip' ]; ?>
                                    </td>
                                    <td style="text-align: center">
                                        <?php
                                        echo getIPAddress($row[ 'ip' ]) ?>
                                    </td>
                                    <td style="text-align: center;" class="fs-sm">
                                        <?php
                                        echo $row[ 'event' ]; ?>
                                    </td>
                                    <td style="text-align: center;" class="fs-sm">
                                        <?php
                                        echo $row[ 'time' ];
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!--分页-->
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="task-logs-list_info" role="status" aria-live="polite">
                            选中项：<a href="javascript:void(0);" onclick="delSelect()">删除</a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_full_numbers" id="task-logs-list_paginate">
                            <?php
                            echo pagination($nums , $ENUMS , $page , $url); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function checkAll ()
    {
        let code_Values = document.getElementsByTagName("input");
        let all = document.getElementById("all");
        if (code_Values.length) {
            for (let i = 0; i < code_Values.length; i++) {
                if (code_Values[i].type === "checkbox") {
                    code_Values[i].checked = all.checked;
                }
            }
        } else {
            if (code_Values.type === "checkbox") {
                code_Values.checked = all.checked;
            }
        }
    }

    function delSelect ()
    {
        let id_array = [];
        //获取界面复选框的所有值
        $("input[name='ids[]']:checked").each(function () {
            //向数组中添加元素
            id_array.push($(this).val());
        });
        x.del('ajax.php?act=control_web_delCheck', {
            id: id_array
        }, ((data) => {
            if (200 === data.code) {
                x.notify(data.msg, 'success')
                setTimeout(() => {
                    x.pjax('?control_log');
                }, 1200)
            } else {
                x.notify(data.msg, 'warning')
            }
        }), '你确定要删除选中的内容吗?')
    }

</script>
