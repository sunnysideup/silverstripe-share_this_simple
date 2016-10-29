<?php

class ShareThisSimpleExtension extends SiteTreeExtension
{
    private static $_share_this_simple_provider = array();

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
