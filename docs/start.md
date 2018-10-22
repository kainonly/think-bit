# 快速开始

##### 定义主继承控制器

```php
<?php
namespace app\sys\controller;
use think\bit\common\BitController;

class Base extends BitController
{
    protected $middleware = ['cors', 'jwt'];
}
```

##### 定义一个api控制器，并引入需要的特性萃取

```php
<?php
namespace app\sys\controller;
use think\bit\traits\AddModel;
use think\bit\traits\DeleteModel;
use think\bit\traits\EditModel;
use think\bit\traits\GetModel;
use think\bit\traits\ListsModel;

class Any extends Base
{
    use ListsModel, AddModel, GetModel, EditModel, DeleteModel;
    protected $model = 'any';
}
```

> `model`是数据表的名称，这样就可以满足一个模块的通用接口了，比如你用POST请求分别测试`/sys/any/get`、`/sys/any/add`、`/sys/any/lists`等，这些将在下面的章节逐步描述。

##### 引入了特性萃取，如何自定义？

> 大多数情况下，我们需要的不仅仅是简单的通用请求处理，更多的是要进行特殊的处理，那么为了让代码可读性更高、维护性更好，我们不使用重写，而使用生命周期式的接口继承来实现

例如对管理员类的处理，在新增时我们需要对管理员密码加密，在新增成功时我们生产一个Hash缓存

```php
<?php
namespace app\sys\controller;
use think\bit\traits\AddModel;
use think\bit\lifecycle\AddBeforeHooks;
use think\bit\lifecycle\AddAfterHooks;

class Admin extends Base implements AddBeforeHooks, AddAfterHooks
{
    use AddModel;
    protected $model = 'admin';

    public function __addBeforeHooks()
    {
        $this->post['password'] = password_hash($this->post['password'], PASSWORD_ARGON2I);
        return true;
    }

    public function __addAfterHooks($pk)
    {
        $admin = new \any\Admin();
        return $admin->factory($pk);
    }
}
```

> `__addBeforeHooks` 则是前置处理，它既可以做特殊验证也可以做前置逻辑处理，当调用它时需要返回`true`或`false`，如果返回`false`接口则会在前置处理时结束并返回请求。

##### 我想在新增中使用ThinkPHP的验证器

> 其实在引入特性萃取是就已被定义，这里只需要创建文件`admin.php`至所属命名空间的验证器内，新增的验证需要定义场景名`add`

```php
<?php
namespace app\sys\validate;
use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'username' => 'require|length:4,20',
        'password' => 'require|length:8,18',
    ];

    protected $scene = [
        'add' => ['username', 'password'],
    ];
}
```