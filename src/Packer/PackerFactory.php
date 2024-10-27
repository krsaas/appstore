<?php
// +----------------------------------------------------------------------
// | 狂人saas
// +----------------------------------------------------------------------
// | Copyright (c) 2021~2024 https://www.krsaas.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed KRSAAS并不是自由软件，未经许可不能去掉异步科技相关版权
// +----------------------------------------------------------------------
// | Author: 异步科技 <help@krsaas.com>
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace Krsaas\Appstore\Packer;

/**
 *
 * Class PackerFactory
 * @package Krsaas\Appstore\Packer
 * @Author: 4ngle
 */
final class PackerFactory
{
    public function get(string $type = 'json'): PackerInterface
    {
        return match ($type) {
            'json' => new JsonPacker(),
            default => throw new \RuntimeException(\sprintf('%s Packer type not found', $type)),
        };
    }
}
