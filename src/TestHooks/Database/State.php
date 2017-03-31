<?php
namespace dam1r89\TestHooks\Database;

use Carbon\Carbon;

/**
 * Created by PhpStorm.
 * User: dam1r89
 * Date: 3/30/17
 * Time: 2:40 PM
 */
class State
{
    private $name;
    private $time;

    public function __construct($name)
    {
        $name = $name ?: 'base-state';
        $this->name = $name;
    }

    private function getPath()
    {
        return storage_path(sprintf('app/database/%s.sql', str_slug($this->name)));
    }

    public function exists()
    {
        return file_exists($this->getPath());
    }

    public function restore($configPath, $dbName)
    {
        $this->execute("mysql --defaults-extra-file='%s' %s < %s 2>&1", $configPath, $dbName, $this->getPath());
    }

    public function save($configPath, $dbName)
    {
        $this->execute("mysqldump --defaults-extra-file='%s' %s > %s 2>&1", $configPath, $dbName, $this->getPath());
    }

    private function execute()
    {
        $command = call_user_func_array('sprintf', func_get_args());
        exec($command, $output, $status);
        if ($status != 0) {
            throw new \Exception(implode("\n", $output), $status);
        }
        return true;
    }

    public function getTime()
    {
        return Carbon::createFromTimestamp(filemtime($this->getPath()));
    }

    public function getName()
    {
        return $this->name;
    }




}
