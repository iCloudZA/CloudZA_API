<?php
    if($act = 'delSelect'){
        exit(ReturnSuccess('删除成功，但并没有执行SQL'));
    }
    if($act = 'delApi'){
        exit(ReturnSuccess('执行成功，但并没有删除'));
    }