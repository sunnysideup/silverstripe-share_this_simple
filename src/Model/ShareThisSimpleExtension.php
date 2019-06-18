<?php

namespace Sunnysideup\ShareThisSimple\Model;



use Sunnysideup\ShareThisSimple\Api\ShareThisSimpleProvider;
use SilverStripe\ORM\DataExtension;




/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: upgrade to SS4
  * OLD:  extends DataExtension (ignore case)
  * NEW:  extends DataExtension (COMPLEX)
  * EXP: Check for use of $this->anyVar and replace with $this->anyVar[$this->owner->ID] or consider turning the class into a trait
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
class ShareThisSimpleExtension extends DataExtension
{
    private static $_share_this_simple_provider = [];
    /**
     * use in your templates like this:
     *     $ShareThisSimpleProvider.FacebookLink
     *
     * @return ShareThisSimpleProvider
     */
    public function ShareThisSimpleProvider()
    {
        if (!isset($_share_this_simple_provider[$this->owner->ID])) {
            $_share_this_simple_provider[$this->owner->ID] = ShareThisSimpleProvider::create($this->owner);
        }

        return $_share_this_simple_provider[$this->owner->ID];
    }
}
