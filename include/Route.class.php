<?php
/*
 * @LastEditors: CloudZA(云之安) <admin@osuu.cc>
 * @hitokoto: 一场秋雨一场凉，秋心酌满泪为霜。
 * Copyright (c) 2022 by CloudZA, All Rights Reserved.
 */
class Route
{
    public function __construct ()
    {
        $uri = $_SERVER[ 'REQUEST_URI' ];
        if (str_contains($uri , '/api/')) {
            $this->handleApiRoute($uri);
        }
        if (str_contains($uri , DESCURI)) {
            $this->handleDocRoute($uri);
        }
    }

    private function handleApiRoute ($uri): void
    {
        $uri_parts = explode('/' , $uri);
        $uri_parts = explode('?' , $uri_parts[ 2 ]);
        if ($uri_parts[ 0 ]) {
            $table = Db::table('api_list');
            $sign = $table->where('sign' , $uri_parts[ 0 ])->find();
            // 判断数据库中&&本地接口是否存在
            if ($sign && file_exists(FCPATH . API_EXTEND_MULU . $uri_parts[ 0 ] . '/index.php')) {
                // 判断接口是否正常
                if ($sign[ 'state' ] === 'on') {
                    require FCPATH . API_EXTEND_MULU . $uri_parts[ 0 ] . '/index.php';
                    if ( !callApiLog($sign[ 'name' ] , $uri_parts[ 0 ] , $sign[ 'pv' ])) {
                        exit(ReturnError('Sever Error'));
                    }
                } else {
                    exit(ReturnError('接口维护中'));
                }
                exit;
            } else {
                exit(ReturnError('暂无此接口'));
            }
        }
    }

    private function handleDocRoute ($uri): void
    {
        $uri_parts = explode('-' , $uri);
        $uri_parts = explode('.' , $uri_parts[ 1 ]);
        define("DOC_SIGN" , $uri_parts[ 0 ]);
        require 'extend/docView.php';
        exit;
    }
}
