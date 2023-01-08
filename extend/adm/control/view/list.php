<?php
/*
Sort:1
Hidden:false
Name:接口列表
Url:control_list
*/


$nums = $db::table('api_list')->count();
$page = isset($_GET[ 'page' ]) ? intval($_GET[ 'page' ]) : 1;
$url = "./?control_list&page=";
$ENUMS = '10'; // 每页条数
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
            <h3 class="block-title">API接口列表</h3>
        </div>
    </div>
</div>

<div class="col-xl-12">
    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">已经添加的API <small>每页展示10条数据</small>
            </h3>
        </div>
        <div class="block-content block-content-full">
            <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="row mb-2">
                    <div class="col-3">
                        <button type="button" class="btn btn-sm btn-alt-primary me-1" data-bs-toggle="modal" data-bs-target="#modal-top">添加API</button>
                    </div>
                    <div class="col-9">
                        <div class="dataTables_filter">
                            <form action="" method="post">
                                <div class="input-group-sm">
                                    <input type="search" class="form-control form-control-alt"
                                           placeholder="输入关键词进行搜索"
                                           name="so"
                                           value='<?php
                                           echo $so; ?>'
                                           aria-controls="task-logs-list">
                                    <button type="submit" class="btn btn-alt-info">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <?php
                $data = Db::table('api_list');
                if ($so != '') {
                    $list = $data->where('name' , 'like' , "%$so%")->whereOr('key' , 'like' , "%$so%");
                } else {
                    $list = $data->order('id ASC')->limit($bnums , $ENUMS);
                }
                $res = $list->select();
                ?>

                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive dataTable no-footer dtr-inline"
                               id="task-logs-list" data-type="sport"
                               aria-describedby="task-logs-list_info">
                            <thead>
                            <tr>
                                <th style="width: 10px">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="all"
                                               onclick="checkAll();" />
                                    </div>
                                </th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">ID</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">API名称</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">API介绍</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">添加时间</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">调用次数</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">操作</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            if (json_encode($res) == '[]') {
                                if ( !empty($_GET[ 'page' ])) {
                                    $url = ( ( $_SERVER[ 'SERVER_PORT' ] == 443 ) ? 'https' : 'http' ) . '://' . $_SERVER[ 'HTTP_HOST' ] . str_replace($_SERVER[ 'DOCUMENT_ROOT' ] , ( substr($_SERVER[ 'DOCUMENT_ROOT' ] , -1) == '/' ) ? '/' : '' , dirname($_SERVER[ 'SCRIPT_FILENAME' ]));
                                    $js = '<script>window.location="' . $url . '/?user_edit&id=' . $user_info[ 'id' ] . '"</script>';
                                    echo $js;
                                }
                                echo '<td colspan="7" class="dataTables_empty"><i class="si si-drawer fa-2x"></i><p class="text-muted fs-sm">暂无数据</p></td>';
                            }
                            foreach ($res as $k => $v) {
                                $row = $res[ $k ];

                                ?>
                                <tr class="odd">
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="ids[]"
                                                   value="<?php
                                                   echo $row[ 'id' ]; ?>" id="<?php
                                            echo 'check_' . $row[ 'id' ]; ?>">
                                            <label class="custom-control-label" for="<?php
                                            echo 'check_' . $row[ 'id' ]; ?>"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        echo $row[ 'id' ]; ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $row[ 'name' ]; ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $row[ 'des' ]; ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $row[ 'add_time' ]; ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $row[ 'pv' ];
                                        ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-alt-primary me-1">
                                            修改
                                        </button>
                                        <button type="button" class="btn btn-sm btn-alt-primary me-1"
                                                onclick="del('<?php
                                                echo $row[ 'name' ] ?>',<?php
                                                echo $row[ 'id' ] ?>)">
                                            删除
                                        </button>
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
                            <ul class="pagination">
                                <li class="paginate_button page-item first disabled" id="task-logs-list_first">
                                    <a href="#" aria-controls="task-logs-list" data-dt-idx="0" tabindex="0"
                                       class="page-link">
                                        <i class="fa fa-angle-double-left"></i>
                                    </a>
                                </li>
                                <li class="paginate_button page-item previous disabled" id="task-logs-list_previous">
                                    <a href="#" aria-controls="task-logs-list" data-dt-idx="1" tabindex="0"
                                       class="page-link">
                                        <i class="fa fa-angle-left"></i>
                                    </a>
                                </li>
                                <li class="paginate_button page-item next disabled" id="task-logs-list_next">
                                    <a href="#" aria-controls="task-logs-list" data-dt-idx="2" tabindex="0"
                                       class="page-link">
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                                <li class="paginate_button page-item last disabled" id="task-logs-list_last">
                                    <a href="#" aria-controls="task-logs-list" data-dt-idx="3" tabindex="0"
                                       class="page-link">
                                        <i class="fa fa-angle-double-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--模态框-->
<div class="modal fade" id="modal-top" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded shadow-none mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title">新增API</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="block-content fs-sm">
                    <div class="mb-4">
                        <label class="form-label">API名称</label>
                        <input type="text" class="form-control fs-sm" name="api_name" placeholder="例如：短网址生成" value="">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">API地址</label>
                        <input type="text" class="form-control fs-sm" name="api_url" placeholder="https://abc.com/api/dome" value="">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="example-textarea-input">API介绍</label>
                        <textarea class="form-control fs-sm "name="api_dec" rows="2" placeholder="例如：将长网址进行缩短，支持百度、新浪、腾讯短网址等等..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">关键词</label>
                        <input type="text" class="form-control fs-sm" name="api_key" placeholder="用英文逗号分开例如：短网址,短链接" value="">
                    </div>
                </div>

                <div class="block-content block-content-full block-content-sm text-end border-top">
                    <button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal">
                        取消
                    </button>
                    <button type="button" class="btn btn-alt-primary" data-bs-dismiss="modal">
                        提交
                    </button>
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
        //把复选框的值以数组形式存放
        let chapterstr = id_array.join(',');
        if (chapterstr.length <= 0) {
            x.notify('请选择要删除的项目', 'warning')
            return false;
        }
        console.log(chapterstr)
        x.del('ajax.php?act=control_delSelect', {
            chapterstr: chapterstr
        }, '你确定要删除选中的内容吗?')
    }

    /**
     * @param name 名称
     * @param id ID
     */
    function del (name, id)
    {
        x.del('ajax.php?act=control_delapi', {
            id: id
        }, (name.length <= 5) ? '你确定要删除【' + name + '】吗?' : '你确定要删除【' + name.substring(0, 5) + "..." + '】吗?')
    }
</script>