# Tools

Tools 是负责处理杂项的助手门面

#### listToTree($list = [], $pk = 'id', $pid = 'parent', $child = 'children', $root = 0)

把返回的数据集转换成Tree

- `list` 列表数据
- `pk` 主索引
- `pid` 父级索引
- `child` 子集命名
- `root` 最高级默认值

#### uuid($version = 'v4', $namespace = null, $name = null)

生成uuid

> 需要安装依赖 `composer require ramsey/uuid`

- `version` 为uuid型号，其中包含 `v1`、`v3`、`v4`、`v5`
- `namespace` 命名空间，使用在 `v3`、`v5`
- `name` 名称，使用在 `v3`、`v5`

```php
use think\bit\facade\Tools;
dump(Tools::uuid());
```

#### random()

随机数16位

> 需要安装依赖 `composer require ajaxray/short-code`

```php
use think\bit\facade\Tools;
dump(Tools::random());
```

#### randomShort()

随机数8位

> 需要安装依赖 `composer require ajaxray/short-code`

```php
use think\bit\facade\Tools;
dump(Tools::randomShort());
```