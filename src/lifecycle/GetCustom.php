<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

/**
 * Interface GetCustom
 * @package think\bit\lifecycle
 * @deprecated
 */
interface GetCustom
{
    /**
     * 自定义返回
     * @param array $data
     * @return array
     */
    public function getCustomReturn(array $data): array;
}