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
        white-space:nowrap;
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
                                <input type="search" class="form-control" placeholder="输入关键词进行搜索" aria-controls="task-logs-list">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive dataTable no-footer dtr-inline" id="task-logs-list" data-type="sport" data-user_id="1080467425" aria-describedby="task-logs-list_info">
                            <thead>
                            <tr>
                                <th class="sorting_disabled" rowspan="1" colspan="1">ID</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">API名称</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">API介绍</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">添加时间</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">调用次数</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1">是否启用</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="odd">
                                <td valign="top" colspan="6" class="dataTables_empty">
                                    <i class="si si-drawer fa-2x"></i>
                                    <p class="text-muted fs-sm">暂无数据</p>
                                </td>
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
                                    <a href="#" aria-controls="task-logs-list" data-dt-idx="0" tabindex="0" class="page-link">
                                        <i class="fa fa-angle-double-left"></i>
                                    </a>
                                </li>
                                <li class="paginate_button page-item previous disabled" id="task-logs-list_previous">
                                    <a href="#" aria-controls="task-logs-list" data-dt-idx="1" tabindex="0" class="page-link">
                                        <i class="fa fa-angle-left"></i>
                                    </a>
                                </li>
                                <li class="paginate_button page-item next disabled" id="task-logs-list_next">
                                    <a href="#" aria-controls="task-logs-list" data-dt-idx="2" tabindex="0" class="page-link">
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                                <li class="paginate_button page-item last disabled" id="task-logs-list_last">
                                    <a href="#" aria-controls="task-logs-list" data-dt-idx="3" tabindex="0" class="page-link">
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
