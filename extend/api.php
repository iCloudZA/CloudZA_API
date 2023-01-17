<?php
/*
 * @LastEditors: CloudZA(云之安) <admin@osuu.cc>
 * @hitokoto: 一场秋雨一场凉，秋心酌满泪为霜。
 * Copyright (c) 2022 by CloudZA, All Rights Reserved.
 */

$a = [
    ['title'=>'标题1','desc'=>'介绍1','pv'=>rand(10,999),'state'=>'on','stateInfo'=>'正常','uri'=>'xxx1'],
    ['title'=>'标题2','desc'=>'介绍2','pv'=>rand(10,999),'state'=>'off','stateInfo'=>'维护','uri'=>'xxx2'],
    ['title'=>'标题2','desc'=>'介绍2','pv'=>rand(10,999),'state'=>'on','stateInfo'=>'正常','uri'=>'xxx3']
];

echo json_encode($a);