## 前言
祝大家新年快乐，欢迎使用本程序(CloudZA API)

----

## 教程
> 以下是本程序的安装教程
### 环境支持
- PHP版本 8.0
- Mysql 5.6及以上
- Windows/Linux

## 安装
1. 将程序上传到网站目录配置伪静态规则
2. 访问domain或者domain/install进入到安装指引
3. 安装数据库/配置管理员账号以及密码即安装完成

## 添加API
> 本地API在目录`extend/api/`中添加文件即可，主文件以`index.php`命名
> 然后在后台添加API，类型有`本地`和`外部`，如果是`extend/api/`中的就选择本地API，如果是外链就选外部API

## 伪静态
```nginx
if (!-e $request_filename)
{
    rewrite ^(.*)$ /index.php$1 last;
}
```
## 发电
欢迎来交♂易，大家的支持就是我继续开发的动力！

制作不易，如果觉得好用，可以捐赠我，我会将您的捐赠信息制作成表格展示在下方

WeChat & Alipay：
![img_2.png](donation.png)
爱发电 https://afdian.net/a/cloudza

## 联系我

Email：admin#osuu.cc <@>

QQ：2922619853
