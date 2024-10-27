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

namespace Krsaas\Appstore\Exception;

/**
 *
 * Class PluginNotFoundException
 * @package Krsaas\Appstore\Exception
 * @Author: 4ngle
 */
class PluginNotFoundException extends \Exception
{
    public function __construct($path)
    {
        parent::__construct(\sprintf('The given directory [%s] is not a valid plugin, probably because it is already installed or the directory is not standardized.', $path));
    }
}
