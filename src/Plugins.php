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

namespace Krsaas\Appstore;

use Hyperf\Support\Composer;
use Krsaas\Appstore\Exception\PluginNotFoundException;
use Krsaas\Appstore\Packer\PackerFactory;
use Krsaas\Appstore\Packer\PackerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 *
 * Class Plugins
 * @package Krsaas\Appstore
 * @Author: 4ngle
 */
class Plugins
{
    public const PLUGIN_PREFIX = 'plugin';

    /**
     * File flags for successful plugin installation.
     */
    public const INSTALL_LOCK_FILE = 'install.lock';

    /**
     * Plugin root directory.
     */
    public const PLUGIN_PATH = BASE_PATH . '/' . self::PLUGIN_PREFIX;

    private static array $appJsonPaths = [];

    public static function init(): void
    {
        // Initialize to load all plugin information into memory
        $mineJsons = self::getPluginJsonPaths();

        foreach ($mineJsons as $mine) {
            // If the plugin identifies itself as installed, load the psr4 psr0 classMap in memory
            $mineInfo = self::read($mine->getRelativePath());

            if (file_exists($mine->getPath() . '/' . self::INSTALL_LOCK_FILE)) {
                self::loadPlugin($mineInfo, $mine);
            }
        }
    }

    /**
     * Get information about all local plugins.
     * @return SplFileInfo[]
     */
    public static function getPluginJsonPaths(): array
    {
        if (self::$appJsonPaths) {
            return self::$appJsonPaths;
        }
        $mines = Finder::create()
            ->in(self::PLUGIN_PATH)
            ->name('mine.json')
            ->sortByChangedTime();
        foreach ($mines as $jsonFile) {
            self::$appJsonPaths[] = $jsonFile;
        }
        return self::$appJsonPaths;
    }

    public static function getPacker(): PackerInterface
    {
        return (new PackerFactory())->get();
    }

    /**
     * Query plugin information based on a given catalog.
     * @return array<string,mixed>
     * @throws PluginNotFoundException
     */
    public static function read(string $path): array
    {
        $jsonPaths = self::getPluginJsonPaths();
        foreach ($jsonPaths as $jsonPath) {
            if ($jsonPath->getRelativePath() === $path) {
                $info = self::getPacker()->unpack(file_get_contents($jsonPath->getRealPath()));
                $info['status'] = is_file($jsonPath->getPath() . '/' . self::INSTALL_LOCK_FILE);
                return $info;
            }
        }
        throw new PluginNotFoundException($path);
    }

    private static function loadPlugin(array $mineInfo, SplFileInfo $mine): void
    {
        $loader = Composer::getLoader();
        // psr-4
        if (! empty($mineInfo['composer']['psr-4'])) {
            foreach ($mineInfo['composer']['psr-4'] as $namespace => $src) {
                $src = realpath($mine->getPath() . '/' . $src);
                $loader->addPsr4($namespace, $src);
            }
        }

        // files
        if (! empty($mineInfo['composer']['files'])) {
            foreach ($mineInfo['composer']['files'] as $file) {
                require_once $mine->getPath() . '/' . $file;
            }
        }

        // classMap
        if (! empty($mineInfo['composer']['classMap'])) {
            $loader->addClassMap($mineInfo['composer']['classMap']);
        }

    }
}
