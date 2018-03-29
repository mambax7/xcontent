<?php namespace XoopsModules\Xcontent;

use Xmf\Request;
use XoopsModules\Xcontent;
use XoopsModules\Xcontent\Common;

/**
 * Class Utility
 */
class Utility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits

    use Common\ServerStats; // getServerStats Trait

    use Common\FilesManagement; // Files Management Trait

    //--------------- Custom module methods -----------------------------
}
