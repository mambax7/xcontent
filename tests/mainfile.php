<?php

define('XOOPS_URL', 'http://localhost');

class XoopsDatabaseFactory
{
    public static function getDatabaseConnection()
    {
        return new stdClass();
    }
}

class MyTextSanitizer
{
    public static function getInstance()
    {
        return new self();
    }
}

class XoopsTpl
{
}