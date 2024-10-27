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
 * Interface PackerInterface
 * @package Krsaas\Appstore\Packer
 */
interface PackerInterface
{
    public function unpack(string $body): array;

    public function pack(array $body): string;
}
