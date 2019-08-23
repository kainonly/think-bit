## OSS 对象存储上传

OSS 可以将上传文件直接上传至阿里云 OSS 对象存储中，不做本地的间接上传

#### put(string $name)

上传至阿里云对象存储

- **name** `string` File 请求文件
- **Return** `string` 对象名称

```php
public function uploads()
{
    try {
        $saveName = Oss::put('image');
        return [
            'error' => 0,
            'data' => [
                'savename' => $saveName,
            ]
        ];
    } catch (\Exception $e) {
        return [
            'error' => 1,
            'msg' => $e->getMessage()
        ];
    }
}
```