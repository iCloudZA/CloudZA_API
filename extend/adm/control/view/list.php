<?php
    /*
    Sort:1
    Hidden:false
    Name:接口列表
    Url:control_list
    */


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
            <div id="task-logs-list_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="task-logs-list_length">
                            <label>
                                <select name="task-logs-list_length" aria-controls="task-logs-list" class="form-select">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="task-logs-list_filter" class="dataTables_filter">
                            <label>
                                <input type="search" class="form-control" placeholder="输入关键词进行搜索"
                                       aria-controls="task-logs-list">
                            </label>
                        </div>
                    </div>
                </div>

                <?php
                    $data = Db::table('api_list');
                    $res = $data->select();
                ?>

                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive dataTable no-footer dtr-inline"
                               id="task-logs-list" data-type="sport" data-user_id="1080467425"
                               aria-describedby="task-logs-list_info">
                            <thead>
                            <tr>
                                <th class="sorting_disabled" rowspan="1" colspan="1">ID</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">API名称</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">API介绍</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">添加时间</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">调用次数</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="odd">
                                <?php
                                    if (json_encode($res) == '[]') {
                                        if(!empty($_GET['page'])){
                                            $url = (($_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], (substr($_SERVER['DOCUMENT_ROOT'], -1) == '/') ? '/' : '', dirname($_SERVER['SCRIPT_FILENAME']));
                                            $js = '<script>window.location="'.$url.'/?user_edit&id='.$user_info['id'].'"</script>';
                                            echo $js;
                                        }
                                        echo '<td colspan="6" class="dataTables_empty"><i class="si si-drawer fa-2x"></i><p class="text-muted fs-sm">暂无数据</p></td>';
                                    }
                                    foreach ($res as $k => $v){
                                        $row = $res[$k];

                                ?>
                                        <td>
                                            <?php echo $row['id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['des']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['add_time'];?>
                                        </td>
                                        <td>
                                            324
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-alt-primary me-1">
                                                修改
                                            </button>
                                            <button type="button" class="btn btn-sm btn-alt-primary me-1" onclick="del('<?php echo $row['name']?>',<?php echo $row['id'] ?>)">
                                                删除
                                            </button>
                                        </td>
                                <?php } ?>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="task-logs-list_info" role="status" aria-live="polite"></div>
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

<script>
    /**
     * @param name 名称
     * @param id ID
     */
    function del(name,id){
        x.del('ajax.php?act=control_delApi',{
            id:id
        },'你确定要删除【'+name+'】吗?')
    }
</script>