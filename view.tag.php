<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

require_once \dirname(__DIR__, 2) . '/mainfile.php';
header('HTTP/1.1 301 Moved Permanently');
header('Location: ' . XOOPS_URL . str_replace('xcontent', 'tag', $_SERVER['SCRIPT_NAME']));
