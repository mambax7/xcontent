<?php

namespace Xmf\Module;

class Helper
{
    protected $dirname;

    public function __construct($dirname)
    {
        $this->dirname = $dirname;
    }

    public static function getInstance(bool $debug = false): Helper
    {
        return new static('xcontent');
    }

    public function getDirname()
    {
        return $this->dirname;
    }
}