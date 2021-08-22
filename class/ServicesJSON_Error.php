<?php

namespace XoopsModules\Xcontent;

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

/*
* @link        http://pear.php.net/pepr/pepr-proposal-show.php?id=198
*/

/**
 * Marker constant for ServicesJSON::decode(), used to flag stack state
 */
define('SERVICES_JSON_SLICE', 1);

/**
 * Marker constant for ServicesJSON::decode(), used to flag stack state
 */
define('SERVICES_JSON_IN_STR', 2);

/**
 * Marker constant for ServicesJSON::decode(), used to flag stack state
 */
define('SERVICES_JSON_IN_ARR', 3);

/**
 * Marker constant for ServicesJSON::decode(), used to flag stack state
 */
define('SERVICES_JSON_IN_OBJ', 4);

/**
 * Marker constant for ServicesJSON::decode(), used to flag stack state
 */
define('SERVICES_JSON_IN_CMT', 5);

/**
 * Behavior switch for ServicesJSON::decode()
 */
define('SERVICES_JSON_LOOSE_TYPE', 16);

/**
 * Behavior switch for ServicesJSON::decode()
 */
define('SERVICES_JSON_SUPPRESS_ERRORS', 32);


if (class_exists('PEAR_Error')) {
    /**
     * Class ServicesJSON_Error
     */
    class ServicesJSON_Error extends PEAR_Error
    {
        /**
         * ServicesJSON_Error constructor.
         * @param string $message
         * @param null   $code
         * @param null   $mode
         * @param null   $options
         * @param null   $userinfo
         */
        public function __construct(
            $message = 'unknown error',
            $code = null,
            $mode = null,
            $options = null,
            $userinfo = null
        ) {
            parent::__construct($message, $code, $mode, $options, $userinfo);
        }
    }
} else {
    /**
     * @todo Ultimately, this class shall be descended from PEAR_Error
     */
    class ServicesJSON_Error
    {
        /**
         * ServicesJSON_Error constructor.
         * @param string $message
         * @param null   $code
         * @param null   $mode
         * @param null   $options
         * @param null   $userinfo
         */
        public function __construct(
            $message = 'unknown error',
            $code = null,
            $mode = null,
            $options = null,
            $userinfo = null
        ) {
        }
    }
}
