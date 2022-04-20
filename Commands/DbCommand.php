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

use Phact\Application\ModulesInterface;
use Phact\Commands\Command;
use Phact\Main\Phact;
use Phact\Orm\Model;
use Phact\Orm\TableManager;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;

class DbCommand extends Command
{
    public $modelsFolder = 'Models';

    public $silent = false;

    public function handle(array $arguments, ModulesInterface $modules)
    {
        $classes = [];
        $tableManager = new TableManager();
        foreach ($modules->getModules() as $moduleName => $module) {
            $path = implode(DIRECTORY_SEPARATOR, [$module->getPath(), $this->modelsFolder]);
            if (is_dir($path)) {
                foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $filename)
                {
                    if ($filename->isDir()) continue;
                    $name = $filename->getBasename('.php');
                    $classes[] = implode('\\', [$module::classNamespace(), $this->modelsFolder, $name]);
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
            if (!$this->silent) {
                echo $this->color($model->className(), 'green', 'black');
                echo ' ';
            }
            $tableManager->createModelTable($model);
            if (!$this->silent) {
                echo $this->color('✓', 'grey', 'black');
                echo PHP_EOL;
            }
        }
        if (!$this->silent) {
            echo $this->color('Handle constraints', 'blue', 'black');
            echo PHP_EOL;
        }
        foreach ($models as $model) {
            if (!$this->silent) {
                echo $this->color($model->className(), 'green', 'black');
                echo ' ';
            }
            $tableManager->createModelTable($model, true);
            if (!$this->silent) {
                echo $this->color('✓', 'grey', 'black');
                echo PHP_EOL;
            }
        }
        if (!$this->silent) {
            echo $this->color('Create ManyToMany tables', 'blue', 'black');
            echo PHP_EOL;
        }
        foreach ($models as $model) {
            if (!$this->silent) {
                echo $this->color($model->className(), 'green', 'black');
                echo ' ';
            }
            $tableManager->createM2MTables($model);
            if (!$this->silent) {
                echo $this->color('✓', 'grey', 'black');
                echo PHP_EOL;
            }
        }
    }

    public function getDescription()
    {
        return 'Sync models with database';
    }
}