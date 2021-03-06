<?php

namespace Sunnysideup\ShareThisSimple\Model;

use SilverStripe\ORM\DataExtension;
use Sunnysideup\ShareThisSimple\Api\ShareThisSimpleProvider;

/**
 * ### @@@@ START REPLACEMENT @@@@ ###
 * WHY: upgrade to SS4
 * OLD:  extends DataExtension (ignore case)
 * NEW:  extends DataExtension (COMPLEX)
 * EXP: Check for use of $this->anyVar and replace with $this->anyVar[$this->owner->ID] or consider turning the class into a trait
 * ### @@@@ STOP REPLACEMENT @@@@ ###.
 */
class ShareThisSimpleExtension extends DataExtension
{
    private static $_share_this_simple_provider = [];

    /**
     * use in your templates like this:
     *     $ShareThisSimpleProvider.FacebookLink.
     *
     * @return ShareThisSimpleProvider
     */
    public function ShareThisSimpleProvider()
    {
        if (! isset(self::$_share_this_simple_provider[$this->owner->ID])) {
            self::$_share_this_simple_provider[$this->owner->ID] = ShareThisSimpleProvider::create($this->owner);
        }

        return self::$_share_this_simple_provider[$this->owner->ID];
    }
}
