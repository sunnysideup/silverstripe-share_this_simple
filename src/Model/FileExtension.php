<?php

namespace Sunnysideup\ShareThisSimple\Model;

use SilverStripe\Assets\File;
use SilverStripe\Core\Extension;
use Sunnysideup\ShareThisSimple\Api\ShareThisSimpleProvider;

/**
 * Class \Sunnysideup\ShareThisSimple\Model\ShareThisSimpleExtension
 *
 * @property FileExtension $owner
 */
class FileExtension extends Extension
{

    public function getPinterestLink(?string $imageMethod = '', ?bool $useImageTitle = false): string
    {
        $owner = $this->getOwner();

        return 'https://pinterest.com/pin/create/button/?url=' . ($owner->AbsoluteLink()) . '&amp;'
            . 'description=' . rawurlencode($owner->Title) . '&amp;'
            . 'media=' . rawurlencode($owner->AbsoluteLink());
    }
}
