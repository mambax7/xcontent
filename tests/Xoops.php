<?php

class Xoops
{
    private static $instance;
    public $user;
    public $config;
    private $handler;

    private function __construct()
    {
        $this->user = new stdClass();
        $this->config = [];
        $this->handler = [
            'groupperm' => new stdClass(),
            'module' => new stdClass(),
            'editor' => new class {
                public function getList()
                {
                    return ['dhtmltextarea' => 'dhtmltextarea'];
                }
            },
        ];
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getHandler($name)
    {
        return $this->handler[$name] ?? null;
    }

    public function getConfig($name)
    {
        return $this->config[$name] ?? null;
    }
}