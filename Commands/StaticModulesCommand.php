<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @date 12/12/16 16:08
 */

namespace Modules\Base\Commands;

use FilesystemIterator;
use Phact\Application\ModulesInterface;
use Phact\Commands\Command;
use Phact\Components\PathInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class StaticModulesCommand extends Command
{
    public $staticDirectory = 'static';

    /**
     * @var ModulesInterface
     */
    protected $_modules;

    /**
     * @var PathInterface
     */
    protected $_path;

    public function __construct(ModulesInterface $modules, PathInterface $path)
    {
        $this->_modules = $modules;
        $this->_path = $path;
    }

    public function handle($arguments = [])
    {
        $destination = $this->_path->get('static_modules');
        if (!is_dir($destination) && !mkdir($destination)) {
            throw new \Exception("Destination directory for static files from modules ('{$destination}') does not exists");
        }
        $this->clear($destination);
        $this->copy($destination);
    }

    public function clear($dir)
    {
        foreach ( new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST) as $file ) {
            $file->isDir() ?  rmdir($file) : unlink($file);
        }
    }

    public function copy($destination)
    {
        foreach ($this->_modules->getModules() as $moduleName => $module) {
            $path = implode(DIRECTORY_SEPARATOR, [$module->getPath(), $this->staticDirectory]);
            if (is_dir($path)) {
                $moduleDestination = $destination . DIRECTORY_SEPARATOR . $moduleName;
                if (!mkdir($moduleDestination) && !is_dir($moduleDestination)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $moduleDestination));
                }
                foreach ($iterator = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($path,\RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST) as $file)
                {
                    $target = $moduleDestination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
                    if ($file->isDir()) {
                        if (!mkdir($target) && !is_dir($target)) {
                            throw new \RuntimeException(sprintf('Directory "%s" was not created', $target));
                        }
                    } else {
                        copy($file, $target);
                    }
                }
            }
        }
    }

    public function getDescription()
    {
        return 'Copy static files from Modules to static_modules directory';
    }
}