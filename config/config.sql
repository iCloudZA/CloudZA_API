
-- 网站设置
DROP TABLE IF EXISTS `webset`;
    CREATE TABLE `webset` (
        `title` varchar(255) not null comment '网站标题',
        `des` varchar(255) not null comment '网站描述',
        `key` varchar(255) not null comment '网站关键词',
        `beian` varchar(255) not null comment '网站备案号',
        `ban` varchar(1024) not null comment '网站底部版权',
        `page_nums` varchar(255) not null comment '每页条数'
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO public_api.webset (title, des, `key`, beian, ban, page_nums) VALUES ('云之安API', '云之安API,提供API数据接口调用服务平台 - 我们致力于为用户提供稳定、快速的免费API数据接口服务。', 'PI,聚合数据,API数据接口,免费API数据调用,', '京ICP备88888888号-8', 'CloudZA', '10')

-- 管理员账号密码设置
DROP TABLE IF EXISTS `admin`;
    CREATE TABLE `admin` (
        `user` varchar(32) not null comment '管理员账号',
        `password` varchar(32) not null comment '管理员密码',
        `cooke` varchar(32) not null comment 'Cookie'
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- API接口列表
DROP TABLE IF EXISTS `api_list`;
    CREATE TABLE `api_list` (
        `id` int primary key auto_increment comment '主键',
        `name` varchar(32) not null comment '名称',
        `des` varchar(128) not null comment '描述',
        `key` varchar(128) not null comment '关键词',  -- ['key1','key2','key3']
        `return` varchar(32) not null comment '返回格式',
        `params` varchar(255) not null comment '请求参数', -- ['params1','params2','params3']
        `return_params` varchar(255) not null comment '返回参数',
        `return_example` varchar(255) not null comment '返回示例',
        `error_code` varchar(128) not null comment '服务错误码',
        `system_code` varchar(128) not null comment '系统错误码',
        `code_format` varchar(128) not null comment '错误码格式',
        `code_demo` varchar(255) not null comment '代码演示'
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

