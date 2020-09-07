<?php

namespace Sunnysideup\ShareThisSimple\Api;

use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\ArrayData;
use SilverStripe\View\ViewableData;

class ShareThisSimpleProvider extends ViewableData
{
    /**
     * @var DataObject
     */
    protected $object;

    protected $linkMethod = 'AbsoluteLink';

    protected $titleMethod = 'Title';

    protected $imageMethods = [];

    protected $descriptionMethod = 'SocialMediaDescription'; //change to 'SocialMediaDescription'

    protected $hashTags = [];

    protected $mentions = '';

    protected $vias = [];

    protected static $cacheGetShareThisArray = [];

    private static $description_method = '';

    private static $default_mentions = [];

    private static $default_vias = [];

    private static $default_hash_tags = [];

    private static $image_methods = [];

    private static $casting = [
        'FacebookShareLink' => 'Varchar',
        'TwitterShareLink' => 'Varchar',
        'TumblrShareLink' => 'Varchar',
        'PinterestShareLink' => 'Varchar',
        'EmailShareLink' => 'Varchar',
        'RedditShareLink' => 'Varchar',
        'PinterestLinkForSpecificImage' => 'Varchar',
    ];

    /**
     * @param DataObject $object
     */
    public function __construct($object)
    {
        parent::__construct();
        $this->object = $object;
    }

    public function setLinkMethod($s)
    {
        $this->linkMethod = $s;
    }

    public function setTitleMethod($s)
    {
        $this->titleMethod = $s;
    }

    public function setImageMethods($a)
    {
        $this->imageMethods = $a;
    }

    public function setDescriptionMethod($s)
    {
        $this->descriptionMethod = $s;
    }

    public function setHashTags($a)
    {
        $this->hashTags = $a;
    }

    public function setMentions($a)
    {
        $this->mentions = $a;
    }

    public function setVias($a)
    {
        $this->vias = $a;
    }

    /**
     * return of ShareThisLinks.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return ArrayList
     */
    public function ShareThisLinks($customDescription = '')
    {
        $arrayList = ArrayList::create();
        $options = array_keys($this->config()->get('casting')); //$this->config()->get('casting') ???
        foreach ($options as $option) {
            $className = str_replace('ShareLink', '', $option);
            $className = strtolower($className);
            $method = 'get' . $option;
            $arrayList->push(
                ArrayData::create(
                    [
                        'Class' => $className,
                        'Link' => $this->{$method}($customDescription),
                    ]
                )
            );
        }

        return $arrayList;
    }

    /**
     * ALIAS
     * Generate a URL to share this content on Facebook.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function FacebookShareLink($customDescription = '')
    {
        return $this->getFacebookShareLink();
    }

    /**
     * Generate a URL to share this content on Facebook.
     * @param string $customDescription   e.g. foo bar cool stuff
     * https://www.facebook.com/dialog/feed?
     *  &link=URL_HERE
     *  &picture=IMAGE_LINK_HERE
     *  &name=TITLE_HERE
     *  &caption=%20
     *  &description=DESCRIPTION_HERE
     *  &redirect_uri=http%3A%2F%2Fwww.facebook.com%2F
     * @return string|false
     */
    public function getFacebookShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return $pageURL ?
            "https://www.facebook.com/sharer/sharer.php?u=${pageURL}&t=${title}"
            :
            false;
    }

    /**
     * ALIAS
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function TwitterShareLink($customDescription = '')
    {
        return $this->getTwitterShareLink($customDescription);
    }

    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     * example: https://twitter.com/intent/tweet?
     *  &source=http%3A%2F%2Fsunnysideup.co.nz
     *  &text=test:%20http%3A%2F%2Fsunnysideup.co.nz
     *  &via=foobar
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function getTwitterShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return $pageURL ?
            "https://twitter.com/intent/tweet?source=${pageURL}&text=${titleFull}" . urlencode(': ') . $pageURL
            :
            false;
    }

    /**
     * ALIAS
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function LinkedInShareLink($customDescription = '')
    {
        return $this->getLinkedInShareLink($customDescription);
    }

    /**
     * Generate a URL to share this content on Twitter
     * Specs: ???
     * example: https://www.linkedin.com/shareArticle?
     * mini=true&url=http://www.cnn.com&title=&summary=chek this out&source=
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function getLinkedInShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return $pageURL ?
           "https://www.linkedin.com/shareArticle?mini=true&url=${pageURL}&summary=${titleFull}"
           :
           false;
    }

    /**
     * ALIAS
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function TumblrShareLink($customDescription = '')
    {
        return $this->getTumblrShareLink($customDescription);
    }

    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function getTumblrShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return $pageURL ?
            "http://www.tumblr.com/share/link?url=${pageURL}&name=${title}&description=${description}"
            :
            false;
    }

    /**
     * ALIAS
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function PinterestShareLink($customDescription = '')
    {
        return $this->getPinterestShareLink($customDescription);
    }

    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function getPinterestShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return $pageURL ?
            "http://pinterest.com/pin/create/button/?url=${pageURL}&description=${description}&media=${media}"
            :
            false;
    }

    /**
     * ALIAS
     * Generate a 'mailto' URL to share this content via Email.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function EmailShareLink($customDescription = '')
    {
        return $this->getEmailShareLink($customDescription);
    }

    /**
     * Generate a 'mailto' URL to share this content via Email.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function getEmailShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return $pageURL ? "mailto:?subject=${title}&body=${pageURL}" : false;
    }

    /**
     * ALIAS
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function RedditShareLink($customDescription = '')
    {
        return $this->getRedditShareLink($customDescription);
    }

    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function getRedditShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return $pageURL ? "http://reddit.com/submit?url=${pageURL}&title=${title}" : false;
    }

    /**
     * @param string $customDescription   e.g. foo bar cool stuff
     *
     * @return array
     */
    public function getShareThisArray($customDescription = '')
    {
        if (! isset(self::$cacheGetShareThisArray[$this->object->ID])) {
            //1. link
            $link = $this->shareThisLinkField();

            $title = $this->shareThisTitleField();

            $media = $this->shareThisMediaField();

            $description = $this->shareThisDescriptionField($customDescription);

            $hashTags = $this->getValuesFromArrayToString('hashTags', 'hash_tags', '#');
            $mentions = $this->getValuesFromArrayToString('mentions', 'mentions', '@');
            $vias = $this->getValuesFromArrayToString('vias', 'vias', '@');
            $titleFull = trim($mentions . ' ' . $title . ' ' . $hashTags . ' ' . $vias);
            $descriptionFull = trim($mentions . ' ' . $description . ' ' . $hashTags . ' ' . $vias);

            //return ...
            self::$cacheGetShareThisArray[$this->object->ID] = [
                'pageURL' => rawurlencode($link),
                'title' => rawurlencode($title),
                'titleFull' => rawurlencode($titleFull),
                'media' => rawurlencode($media),
                'description' => rawurlencode($description),
                'descriptionFull' => rawurlencode($descriptionFull),
                'hashTags' => rawurlencode($mentions),
                'mentions' => rawurlencode($mentions),
                'vias' => rawurlencode($vias),
            ];
        }

        return self::$cacheGetShareThisArray[$this->object->ID];
    }

    /**
     * @param string $imageMethod   e.g. MyImage
     * @param bool $useImageTitle  if set to false, it will use the page title as the image title
     *
     * @return string
     */
    public function PinterestLinkForSpecificImage($imageMethod, $useImageTitle = false)
    {
        return $this->getPinterestLinkForSpecificImage(
            $imageMethod,
            $useImageTitle
        );
    }

    public function getPinterestLinkForSpecificImage($imageMethod, $useImageTitle = false)
    {
        if ($this->object && $this->object->hasMethod($imageMethod)) {
            $image = $this->object->{$imageMethod}();
            if ($image && $image->exists()) {
                if ($useImageTitle) {
                    $imageTitle = $image->Title;
                } else {
                    $imageTitle = $this->object->Title;
                }
                return 'http://pinterest.com/pin/create/button/'
                    . '?url=' . urlencode($this->object->AbsoluteLink()) . '&amp;'
                    . 'description=' . urlencode($imageTitle) . '&amp;'
                    . 'media=' . urlencode($image->AbsoluteLink());
            }
        }
    }

    protected function getValuesFromArrayToString($variable, $staticVariable, $prepender = '@')
    {
        if (! empty($this->{$variable})) {
            $a = $this->{$variable};
        } else {
            $a = $this->Config()->get($staticVariable);
        }
        $str = '';
        if (is_array($a) && count($a)) {
            $str = $prepender . implode(' ' . $prepender, $a);
        }

        return trim($str);
    }

    private function shareThisLinkField()
    {
        $link = '';
        $linkMethod = $this->linkMethod;
        if ($this->object->hasMethod($linkMethod)) {
            $link = $this->object->{$linkMethod}();
        }

        return $link;
    }

    private function shareThisTitleField(): string
    {
        $title = '';
        $titleMethod = $this->titleMethod;
        if ($this->object->hasMethod($titleMethod)) {
            $title = $this->object->{$titleMethod}();
        } elseif (isset($this->object->{$titleMethod})) {
            $title = $this->object->{$titleMethod};
        }

        return (string) $title;
    }

    private function shareThisMediaField(): string
    {
        $media = '';
        $imageMethods = $this->imageMethods;
        if (is_array($imageMethods) && count($imageMethods)) {
            //do nothing
        } else {
            $imageMethods = Config::inst()->get(
                'ShareThisSimpleProvider',
                'image_methods'
            );
        }
        if (is_array($imageMethods) && count($imageMethods)) {
            foreach ($imageMethods as $imageMethod) {
                if ($this->object->hasMethod($imageMethod)) {
                    $imageField = $imageMethod . 'ID';
                    if ($this->{$imageField}) {
                        $image = $this->object->{$imageMethod}();
                        if ($image && $image->exists()) {
                            $media = $image->AbsoluteLink();
                            break;
                        }
                    }
                }
            }
        }

        return $media;
    }

    private function shareThisDescriptionField(string $customDescription): string
    {
        $description = '';

        if ($customDescription) {
            $description = $customDescription;
        } else {
            $description = '';
            if ($descriptionMethod = $this->descriptionMethod) {
                //do nothing
            } else {
                $descriptionMethod = Config::inst()->get(
                    'ShareThisSimpleProvider',
                    'description_method'
                );
            }
            if ($descriptionMethod) {
                if ($this->object->hasMethod($descriptionMethod)) {
                    $description = $this->object->{$descriptionMethod}();
                } elseif (isset($this->object->{$descriptionMethod})) {
                    $description = $this->object->{$descriptionMethod};
                }
            }
        }

        return (string) $description;
    }
}
