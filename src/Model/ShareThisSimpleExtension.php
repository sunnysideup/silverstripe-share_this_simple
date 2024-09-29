<?php

namespace Sunnysideup\ShareThisSimple\Model;

use SilverStripe\ORM\DataExtension;
use Sunnysideup\ShareThisSimple\Api\ShareThisSimpleProvider;

/**
 * Class \Sunnysideup\ShareThisSimple\Model\ShareThisSimpleExtension
 *
 * @property SiteTree|ShareThisSimpleExtension $owner
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
        $owner = $this->getOwner();
        if (! isset(self::$_share_this_simple_provider[$owner->ID])) {
            self::$_share_this_simple_provider[$owner->ID] = ShareThisSimpleProvider::create($this->owner);
        }

        return self::$_share_this_simple_provider[$owner->ID];
    }
}
