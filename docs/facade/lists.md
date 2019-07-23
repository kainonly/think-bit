## Lists 列表数组

ArrayLists 列表数组操作类，安装操作库

```shell
composer require kain/think-lists
```

#### data($lists)

列表数组初始化

- **lists** `array` 传入初始化的数组
- **Return** `BitLists`

```php
$lists = Lists::data([1, 2, 3, 4, 5, 6]);

dump($lists->toArray());
// array (size=6)
//   0 => int 1
//   1 => int 2
//   2 => int 3
//   3 => int 4
//   4 => int 5
//   5 => int 6
```

#### size()

获取数组大小

- **Return** `int`

```php
$lists = Lists::data([1, 2, 3, 4, 5, 6]);
$size = $lists->size();

dump($size);
// 6
```

#### set($key, $value)

设置键值

- **key** `string` 键名
- **value** `string` 键值

```php
$lists = Lists::data([1, 2, 3, 4, 5, 6]);
$lists->set('name', 'test');

dump($lists->toArray());
// array (size=7)
//   0 => int 1
//   1 => int 2
//   2 => int 3
//   3 => int 4
//   4 => int 5
//   5 => int 6
//   'name' => string 'test' (length=4)
```

#### add(...$data)

数组加入元素

- **data** `mixed` 加入的元素

```php
$lists = Lists::data([1, 2, 3, 4, 5, 6]);
$lists->add(7, 8, 9);

dump($lists->toArray());
// array (size=9)
//   0 => int 1
//   1 => int 2
//   2 => int 3
//   3 => int 4
//   4 => int 5
//   5 => int 6
//   6 => int 7
//   7 => int 8
//   8 => int 9
```

#### unshift(...$data)

向前数组加入元素

- **data** `mixed` 加入的元素

```php
$lists = Lists::data([1, 2, 3, 4, 5, 6]);
 $lists->unshift(-1, 0);

dump($lists->toArray());
// array (size=8)
//   0 => int -1
//   1 => int 0
//   2 => int 1
//   3 => int 2
//   4 => int 3
//   5 => int 4
//   6 => int 5
//   7 => int 6
```

#### isEmpty()

数组是否为空

- **Return** `boolean`

```php
$lists = Lists::data([]);

dump($lists->isEmpty());
// true
```

#### has($key)

判断是否存在键名

- **key** `string` 键名
- **Return** `boolean`

```php
$lists = Lists::data([
    'name' => 'test'
]);

dump($lists->has('name'));
// true
```

#### contains($value)

判断是否存在键值

- **value** `mixed` 键值
- **Return** `boolean`

```php
$lists = Lists::data([
    'name' => 'test'
]);

dump($lists->contains('test'));
// true
```

#### get($key)

获取键值

- **key** `mixed` 键名
- **Return** `mixed`

```php
$lists = Lists::data([
    'name' => 'test'
]);

dump($lists->get('name'));
// test
```

#### delete($key)

移除键值

- **key** `mixed` 键名

```php
$lists = Lists::data([
    'name' => 'test'
]);
$lists->delete('name');

dump($lists->toArray());
// array (size=0)
```

#### shift()

数组开头的单元移出元素

- **Return** `mixed` 移出的元素

```php
$lists = Lists::data([1, 2, 3]);
$lists->shift();

dump($lists->toArray());
// array (size=2)
//   0 => int 2
//   1 => int 3
```

#### pop()

数组出栈

- **Return** `mixed` 出栈的元素

```php
$lists = Lists::data([1, 2, 3]);
$lists->pop();

dump($lists->toArray());
// array (size=2)
//   0 => int 1
//   1 => int 2
```

#### unique()

去除重复

```php
$lists = Lists::data([1, 1, 2, 2, 3]);
$lists->unique();

dump($lists->toArray());
// array (size=3)
//   0 => int 1
//   2 => int 2
//   4 => int 3
```

#### clear()

清除数据

```php
$lists = Lists::data([1, 1, 2, 2, 3]);
$lists->clear();

dump($lists->toArray());
// array (size=0)
```

#### keys()

返回键名

- **Return** `array` 所有键名

```php
$lists = Lists::data([
    'name' => 'van',
    'age' => 100,
    'sex' => 0
]);

dump($lists->keys());
// array (size=3)
//   0 => string 'name' (length=4)
//   1 => string 'age' (length=3)
//   2 => string 'sex' (length=3)
```

#### values()

返回键值

- **Return** `array` 所有键值

```php
$lists = Lists::data([
    'name' => 'van',
    'age' => 100,
    'sex' => 0
]);

dump($lists->values());
// array (size=3)
//   0 => string 'van' (length=3)
//   1 => int 100
//   2 => int 0
```

#### indexOf($value)

搜索给定的值，返回键名

- **value** `mixed` 键值
- **Return** `string` 键名

```php
$lists = Lists::data([
    'name' => 'van',
    'age' => 100,
    'sex' => 0
]);

dump($lists->indexOf('van'));
// name
```

#### map(Closure $closure)

数组遍历返回

- **closure** `Closure` 闭包函数
- **Return** `array`

```php
$lists = Lists::data([
    [
        'product' => 'test1',
        'price' => 10
    ],
    [
        'product' => 'test2',
        'price' => 20
    ]
]);

$other_lists = $lists->map(function ($v) {
    $v['price'] += 10;
    return $v;
});

dump($other_lists);
// array (size=2)
//   0 => 
//     array (size=2)
//       'product' => string 'test1' (length=5)
//       'price' => int 20
//   1 => 
//     array (size=2)
//       'product' => string 'test2' (length=5)
//       'price' => int 30
```

#### filter(Closure $closure)

数组过滤

- **closure** `Closure` 闭包函数
- **Return** `array`

```php
$lists = Lists::data([
    [
        'product' => 'test1',
        'price' => 10
    ],
    [
        'product' => 'test2',
        'price' => 20
    ],
    [
        'product' => 'test3',
        'price' => 30
    ]
]);

$other_lists = $lists->filter(function ($v) {
    return $v['price'] > 10;
});

dump($other_lists);
// array (size=2)
//   1 => 
//     array (size=2)
//       'product' => string 'test2' (length=5)
//       'price' => int 20
//   2 => 
//     array (size=2)
//       'product' => string 'test3' (length=5)
//       'price' => int 30
```

#### slice($offset, $length)

数组切片

- **offset** `int` 起始
- **length** `int` 长度
- **Return** `array`

```php
$lists = Lists::data([1, 2, 3, 4, 5]);

dump($lists->slice(1, 3));
// array (size=3)
//   0 => int 2
//   1 => int 3
//   2 => int 4
```

#### toArray()

获取数组

- **Return** `array`

```php
$lists = Lists::data([
    [
        'product' => 'test1',
        'price' => 10
    ],
    [
        'product' => 'test2',
        'price' => 20
    ],
    [
        'product' => 'test3',
        'price' => 30
    ]
]);

dump($lists->toArray());
// array (size=3)
//   0 => 
//     array (size=2)
//       'product' => string 'test1' (length=5)
//       'price' => int 10
//   1 => 
//     array (size=2)
//       'product' => string 'test2' (length=5)
//       'price' => int 20
//   2 => 
//     array (size=2)
//       'product' => string 'test3' (length=5)
//       'price' => int 30
```

#### toJson()

转为Json

- **Return** `string`

```php
$lists = Lists::data([
    [
        'product' => 'test1',
        'price' => 10
    ],
    [
        'product' => 'test2',
        'price' => 20
    ],
    [
        'product' => 'test3',
        'price' => 30
    ]
]);

dump($lists->toJson());
// [{"product":"test1","price":10},{"product":"test2","price":20},{"product":"test3","price":30}]
```

#### toBinary()

转为二进制

- **Return** `string`

```php
$lists = Lists::data([
    [
        'product' => 'test1',
        'price' => 10
    ],
    [
        'product' => 'test2',
        'price' => 20
    ],
    [
        'product' => 'test3',
        'price' => 30
    ]
]);

dump($lists->toBinary());
// ���product�test1�price
// ��product�test2�price��product�test3�price
```

#### toTree($id_name = 'id', $parent_name = 'parent', $child_name = 'children', $top_parent = 0) :id=to_tree

转为树形结构

- **id_name** `string` 数组主键名称
- **parent_name** `string` 数组父级关联名称
- **child_name** `string` 树形子集名称定义
- **top_parent** `int|string` 最高级父级
- **Return** `array`

```php
$lists = Lists::data([
    [
        'id' => 1,
        'name' => 'node1',
        'parent' => 0
    ],
    [
        'id' => 2,
        'name' => 'node2',
        'parent' => 0
    ],
    [
        'id' => 3,
        'name' => 'node3',
        'parent' => 1
    ],
    [
        'id' => 4,
        'name' => 'node4',
        'parent' => 1
    ],
    [
        'id' => 5,
        'name' => 'node5',
        'parent' => 4
    ],
    [
        'id' => 6,
        'name' => 'node6',
        'parent' => 2
    ],
]);

$tree = $lists->toTree();
```
