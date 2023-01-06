-- 网站设置
DROP TABLE IF EXISTS `webset`;
CREATE TABLE `webset` (
                          `title` varchar(255) not null comment '网站标题',
                          `des` varchar(255) not null comment '网站描述',
                          `key` varchar(255) not null comment '网站关键词',
                          `beian` varchar(255) not null comment '网站备案号',
                          `ban` varchar(1024) not null comment '网站底部版权',
                          `page_nums` varchar(255) not null comment '每页条数'
)ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO public_api.webset (title, des, `key`, beian, ban, page_nums) VALUES ('云之安API', '云之安API,提供API数据接口调用服务平台 - 我们致力于为用户提供稳定、快速的免费API数据接口服务。', 'PI,聚合数据,API数据接口,免费API数据调用,', '京ICP备88888888号-8', 'CloudZA', '10')

