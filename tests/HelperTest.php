<?php

namespace XoopsModules\Xcontent;

use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function testGetInstance()
    {
        $helper = Helper::getInstance();
        $this->assertInstanceOf(Helper::class, $helper);
    }

    public function testGetDirname()
    {
        $helper = Helper::getInstance();
        $this->assertEquals('app', $helper->getDirname());
    }
}