## Utils 工具集

Utils 常用工具集合，此服务必须安装 `kain/think-extra`， 安装后服务将自动注册可通过依赖注入使用

```php
use think\extra\contract\UtilsInterface;

class Index extends BaseController
{
    public function index(UtilsInterface $utils)
    {
        return $utils
            ->jump('提交成功', 'index/index')
            ->success();
    }
}
```

#### jump(string $msg, string $url = '', string $type = 'html'): Jump

- **msg** `string` 跳转信息
- **url** `string` 回调Url
- **type** `int` 返回类型 `html` 或`json`

跳转回调工具

```php
use think\support\facade\Utils;

class Index extends BaseController
{
    public function index()
    {
        return Utils::jump('提交成功', 'index/index')
            ->success();
    }
}
```