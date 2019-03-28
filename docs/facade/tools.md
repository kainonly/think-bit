## Tools 工具

#### pack($array) 

数组二进制序列化

- **array** `array` 数组
- **Return** 二进制

#### unpack($byte) 

二进制反序列化数组

- **byte** 二进制
- **Return** 数组

#### uuid($version, $namespace, $name)

生成 uuid

- **version** `string` 为uuid型号，其中包含 `v1`、`v3`、`v4`、`v5`，默认 `v4`
- **namespace** `string` 命名空间，使用在 `v3`、`v5`
- **name** `string` 名称，使用在 `v3`、`v5`
- **Return** `string`

```php
dump(Tools::uuid());
// '4f38cd10-3518-4656-95a3-9cbb4d5a8f25'
dump(Tools::uuid('v1'));
// '3fe018b6-1f89-11e9-863d-aa151017e551'
dump(Tools::uuid('v3', Uuid::NAMESPACE_DNS, 'van'));
// '88124da6-a376-3c77-8fb1-456250a33254'
dump(Tools::uuid('v5', Uuid::NAMESPACE_DNS, 'van'));
// '72ca19ff-6897-5a8e-80c4-ed5d3b753115'
```

| UUID Version | 说明                   |
| ------------ | ---------------------- |
| v1           | 基于时间的UUID         |
| v3           | 基于名字的UUID（MD5）  |
| v4           | 随机UUID               |
| v5           | 基于名字的UUID（SHA1） |

#### orderNumber($service_code, $product_code, $user_code)

生产订单号

- **service_code** `string` 业务码
- **product_code** `string` 产品码
- **user_code** `string` 用户码
- **Return** `string`

```php
dump(Tools::orderNumber('2', '100', '555'));

// 28100154830173082555
```

#### random()

随机数16位

```php
dump(Tools::random());

// 3nnoIk3XbVphym4k
```

#### randomShort()

随机数8位

```php
dump(Tools::randomShort());

// 2maJYwas
```