<?php

namespace dam1r89\TestHooks\Database;

class Database
{
    private $configPath;
    private $dbName;

    public function __construct()
    {
        $this->workingDir = storage_path('app/database');
        if (!file_exists($this->workingDir)) {
            mkdir($this->workingDir);
        }
        $this->configPath = $this->workingDir . '/.mysql_conf.ini';
        $this->dbName = config('database.connections.' . config('database.default') . '.database');

    }

    public function getStates()
    {
        $states = [];
        $handle = opendir($this->workingDir);
        if (!$handle) {
            return $states;
        }

        while (false !== ($entry = readdir($handle))) {
            if ($entry == "." || $entry == "..") {
                continue;
            }
            $state = new State(substr($entry, 0, -4));
            if (!$state->exists()) {
                continue;
            }
            $states[] = [
                'name' => $state->getName(),
                'time' => $state->getTime()
            ];
        }

        closedir($handle);
        return $states;
    }

    public function saveState($name, $force = false)
    {

        $state = new State($name);

        if (!$force && $state->exists()) {
            throw new \Exception(sprintf('State "%s" already exists, use force flag to override', $state->getName()));
        }

        $this->compileConfig();
        try {
            $state->save($this->configPath, $this->dbName);
        } catch (\Exception $e) {
            throw $e;
        } finally {
            $this->clearConfig();
        }

    }

    public function resetState($name)
    {

        $state = new State($name);

        if (!$state->exists()) {
            throw new \Exception(sprintf('State with name "%s" doesn\'t exist.', $name));
        }

        $this->compileConfig();
        try {
            $state->restore($this->configPath, $this->dbName);
        } catch (\Exception $e) {
            throw $e;
        } finally {
            $this->clearConfig();
        }

    }

    public function clearConfig()
    {
        unlink($this->configPath);
    }

    private function compileConfig()
    {
        $content = file_get_contents(__DIR__ . '/template/.mysql_conf.ini');
        preg_match_all('/%(.*?)%/', $content, $matches);
        foreach ($matches[1] as $placeholder => $env) {
            $content = str_replace($matches[0][$placeholder], env($env), $content);
        }
        file_put_contents($this->configPath, $content);
    }
}
