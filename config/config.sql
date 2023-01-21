-- 网站设置
DROP TABLE IF EXISTS `webset`;
CREATE TABLE `webset`
(
    `web_title`     text        not null comment '网站标题',
    `web_titleDesc` text        not null comment '标题描述',
    `web_des`       text        not null comment '网站描述',
    `web_key`       text        not null comment '网站关键词',
    `web_qq`        varchar(12) not null comment 'QQ号',
    `web_beian`     text        not null comment '网站备案号',
    `web_ban`       text        not null comment '网站底部版权',
    `web_page_nums` int default '10' comment '每页条数'
) ENGINE = INNODB
  DEFAULT CHARSET = utf8;
INSERT INTO public_api.webset (web_title, web_titleDesc, web_des, web_key, web_qq, web_beian, web_ban, web_page_nums)
VALUES ('CloudZA-API', '一款开源的API系统', 'CloudZA-API， 我们致力于为用户提供稳定、快速的免费API数据接口服务。',
        'API,云之安,API内容管理,免费API', '2922619853', '京ICP备8888888号', '云之安', 10);

-- 管理员账号密码设置
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`
(
    `user`     varchar(32) not null comment '管理员账号',
    `password` varchar(32) not null comment '管理员密码',
    `cookie`   varchar(32) not null comment 'Cookie'
) ENGINE = INNODB
  DEFAULT CHARSET = utf8;
INSERT INTO public_api.admin (user, password, cookie)
VALUES ('admin', '123456', '5844a8e587c353ce2dfbca3def069981');

-- 操作日志
DROP TABLE IF EXISTS `web_log`;
CREATE TABLE `web_log`
(
    `id`       int primary key auto_increment comment '主键',
    `ip`       varchar(32) not null comment 'ip',
    `time`     datetime    not null comment '时间',
    `event`    text        not null comment '事件',
    `detailed` text        not null comment '地址'
) ENGINE = INNODB
  DEFAULT CHARSET = utf8;

-- API接口列表
DROP TABLE IF EXISTS `api_list`;
CREATE TABLE `api_list`
(
    `id`            int(10)      NOT NULL auto_increment comment '主键',
    `name`          text comment '名称',
    `api_url`       text comment '接口地址',
    `des`           text comment '描述',
    `http_mode`     text comment '请求方法',
    `http_case`     text comment '请求示例',
    `return_format` text comment '返回格式',
    `http_param`    text comment '请求参数',
    `return_param`  text comment '返回参数',
    `return_case`   text comment '返回示例',
    `code_case`     text comment '代码示例',
    `sign`          varchar(255) not null comment 'API标识',
    `type`          varchar(12)  not null comment '类型', -- 本地||外部
    `state`         enum ('on','off') comment 'API状态',  -- 正常/维护
    `pv`            int(10)      not null default '0' comment '浏览量',
    `add_time`      datetime     not null comment '添加时间',
    primary key (`sign`),
    KEY `id` (`id`)
) ENGINE = INNODB
  DEFAULT CHARSET = utf8;

-- API调用统计
DROP TABLE IF EXISTS `api_count`;
CREATE TABLE `api_count`
(
    `id`       int primary key auto_increment comment '主键',
    `name`     text         not null comment 'API名称',
    `ip`       varchar(32)  not null comment 'IP',
    `address`  varchar(32)  not null comment '地址',
    `datetime` datetime     not null comment '时间',
    `sign`     varchar(255) NOT NULL COMMENT 'API_ID',
    FOREIGN KEY (sign)
        REFERENCES api_list (sign)
        ON DELETE CASCADE

) ENGINE = INNODB
  DEFAULT CHARSET = utf8;

-- API黑名单
DROP TABLE IF EXISTS `blacklist`;
CREATE TABLE `blacklist`
(
    `id`     int primary key auto_increment comment '主键',
    `api_id` int         not null comment 'API_ID',
    `ip`     varchar(32) not null comment 'IP',
    `date`   datetime    not null comment '时间'
) ENGINE = INNODB
  DEFAULT CHARSET = utf8;
