
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
INSERT INTO public_api.webset (title, des, `key`, beian, ban, page_nums) VALUES ('云之安API', '云之安API,提供API数据接口调用服务平台 - 我们致力于为用户提供稳定、快速的免费API数据接口服务。', 'PI,聚合数据,API数据接口,免费API数据调用,', '京ICP备88888888号-8', 'CloudZA', '10');

-- 管理员账号密码设置
DROP TABLE IF EXISTS `admin`;
    CREATE TABLE `admin` (
        `user` varchar(32) not null comment '管理员账号',
        `password` varchar(32) not null comment '管理员密码',
        `cookie` varchar(32) not null comment 'Cookie'
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO public_api.admin (user, password, cookie) VALUES ('admin', '123456', '5844a8e587c353ce2dfbca3def069981');
-- API接口列表
DROP TABLE IF EXISTS `api_list`;
    CREATE TABLE `api_list` (
        `id` int primary key auto_increment comment '主键',
        `name` text comment '名称',
        `api_url` text comment '接口地址',
        `des` text comment '描述',
        `key` text comment '关键词',  -- ['key1','key2','key3']
        `http_mode` text comment '请求方法',
        `params` text comment '请求参数', -- ['params1','params2','params3']
        `return_format` text comment '返回格式',
        `return_params` text comment '返回参数',
        `return_case` text comment '返回示例',
        `demo_code` text comment '代码演示',
        `pv` int(10) not null comment '浏览量',
        `add_time` datetime not null comment '添加时间'
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- API调用统计
DROP TABLE IF EXISTS `api_count`;
    CREATE TABLE `api_count` (
        `id` int primary key auto_increment comment '主键',
        `api_id` int not null comment 'API_ID',
        `call_num` int not null comment '调用次数',
        `ip` varchar(32) not null comment 'IP',
        `address` varchar(32) not null comment '地址',
        `datetime` datetime not null comment '时间'
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- API黑名单
DROP TABLE IF EXISTS `blacklist`;
    CREATE TABLE `blacklist` (
        `id` int primary key auto_increment comment '主键',
        `api_id` int not null comment 'API_ID',
        `ip` varchar(32) not null comment 'IP',
        `date` datetime not null comment '时间'
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
