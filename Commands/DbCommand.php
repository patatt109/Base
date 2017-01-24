<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company HashStudio
 * @site http://hashstudio.ru
 * @date 12/12/16 16:08
 */

namespace Modules\Base\Commands;

use Phact\Commands\Command;
use Phact\Helpers\Paths;
use Phact\Main\Phact;
use Phact\Orm\Model;
use Phact\Orm\TableManager;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;

class DbCommand extends Command
{
    public $modelsFolder = 'Models';

    public function handle($arguments = [])
    {
        $modulesPath = Paths::get('Modules');
        $activeModules = Phact::app()->getModulesList();
        $classes = [];
        $tableManager = new TableManager();
        foreach ($activeModules as $module) {
            $path = implode(DIRECTORY_SEPARATOR, [$modulesPath, $module, $this->modelsFolder]);
            if (is_dir($path)) {
                foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $filename)
                {
                    if ($filename->isDir()) continue;
                    $name = $filename->getBasename('.php');
                    $classes[] = implode('\\', ['Modules', $module, $this->modelsFolder, $name]);
                }
            }
        }
        $models = [];
        foreach ($classes as $class) {
            if (class_exists($class) && is_a($class, Model::class, true)) {
                $reflection = new ReflectionClass($class);
                if (!$reflection->isAbstract()) {
                    $models[] = new $class();
                }
            }
        }
        foreach ($models as $model) {
            echo $this->color($model->className(), 'green', 'black');
            echo ' ';
            $result = $tableManager->createModelTable($model);
            if ($result->errorCode() == '00000') {
                echo $this->color('✓', 'grey', 'black');
            } else {
                echo $this->color('✓', 'red', 'black');
            }
            echo PHP_EOL;
        }
    }

    public function getDescription()
    {
        return 'Sync models with database';
    }
}