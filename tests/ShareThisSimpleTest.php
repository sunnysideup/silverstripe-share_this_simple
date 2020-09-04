<?php

use SilverStripe\Dev\SapphireTest;

class ShareThisSimpleTest extends SapphireTest
{
    protected $usesDatabase = false;

    public function TestDevBuild()
    {
        $exitStatus = shell_exec('php framework/cli-script.php dev/build flush=all  > dev/null; echo $?');
        $exitStatus = intval(trim($exitStatus));
        $this->assertSame(0, $exitStatus);
    }
}
