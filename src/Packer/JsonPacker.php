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

use JsonException;

/**
 *
 * Class JsonPacker
 * @package Krsaas\Appstore\Packer
 * @Author: 4ngle
 */
class JsonPacker implements PackerInterface
{
    /**
     * @throws JsonException
     */
    public function unpack(string $body): array
    {
        return json_decode($body, true, 512, \JSON_THROW_ON_ERROR);
    }

    /**
     * @throws JsonException
     */
    public function pack(array $body): string
    {
        return json_encode($body, \JSON_THROW_ON_ERROR | \JSON_UNESCAPED_UNICODE);
    }
}
