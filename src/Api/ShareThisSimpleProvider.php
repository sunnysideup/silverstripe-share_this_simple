<?php

namespace Sunnysideup\ShareThisSimple\Api;





use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\Core\Config\Config;
use Sunnysideup\ShareThisSimple\Api\ShareThisSimpleProvider;
use SilverStripe\View\ViewableData;



class ShareThisSimpleProvider extends ViewableData
{
    private static $description_method = '';

    private static $default_mentions = [];

    private static $default_vias = [];

    private static $default_hash_tags = [];

    private static $image_methods = [];

    private static $casting = array(
        "FacebookShareLink" => "Varchar",
        "TwitterShareLink" => "Varchar",
        "GooglePlusShareLink" => "Varchar",
        "TumblrShareLink" => "Varchar",
        "PinterestShareLink" => "Varchar",
        "EmailShareLink" => "Varchar",
        "RedditShareLink" => "Varchar",
        "PinterestLinkForSpecificImage" => "Varchar"
    );


    /**
     * @var DataObject
     */
    protected $object;

    /**
     * @param DataObject $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }

    protected $linkMethod = 'AbsoluteLink';

    public function setLinkMethod($s)
    {
        $this->linkMethod = $s;
    }

    protected $titleMethod = 'Title';

    public function setTitleMethod($s)
    {
        $this->titleMethod = $s;
    }

    protected $imageMethods = [];

    public function setImageMethods($a)
    {
        $this->imageMethods = $a;
    }

    protected $descriptionMethod = '';

    public function setDescriptionMethod($s)
    {
        $this->descriptionMethod = $s;
    }

    protected $hashTags = [];

    public function setHashTags($a)
    {
        $this->hashTags = $a;
    }

    protected $mentions = '';

    public function setMentions($a)
    {
        $this->mentions = $a;
    }

    protected $vias = [];

    public function setVias($a)
    {
        $this->vias = $a;
    }

    /**
     * return of ShareThisLinks.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return ArrayList
     */
    public function ShareThisLinks($customDescription= '')
    {
        $arrayList = ArrayList::create();
        $options = array_keys($this->stat('casting'));
        foreach ($options as $option) {

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: upgrade to SS4
  * OLD: $className (case sensitive)
  * NEW: $className (COMPLEX)
  * EXP: Check if the class name can still be used as such
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
            $className  = str_replace('ShareLink', '', $option);

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: upgrade to SS4
  * OLD: $className (case sensitive)
  * NEW: $className (COMPLEX)
  * EXP: Check if the class name can still be used as such
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
            $className  = strtolower($className);
            $method = "get".$option;
            $arrayList->push(
                ArrayData::create(
                    array(

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: upgrade to SS4
  * OLD: $className (case sensitive)
  * NEW: $className (COMPLEX)
  * EXP: Check if the class name can still be used as such
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
                        'Class' => $className,
                        'Link' => $this->$method($customDescription)
                    )
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
     * https://www.facebook.com/dialog/feed?&link=URL_HERE&picture=IMAGE_LINK_HERE&name=TITLE_HERE&caption=%20&description=DESCRIPTION_HERE&redirect_uri=http%3A%2F%2Fwww.facebook.com%2F
     * @return string|false
     */
    public function getFacebookShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return ($pageURL) ? "https://www.facebook.com/sharer/sharer.php?u=$pageURL&t=$title" : false;
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
     * example: https://twitter.com/intent/tweet?source=http%3A%2F%2Fsunnysideup.co.nz&text=test:%20http%3A%2F%2Fsunnysideup.co.nz&via=matteo
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function getTwitterShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return ($pageURL) ? "https://twitter.com/intent/tweet?source=$pageURL&text=$titleFull".urlencode(': ').$pageURL : false;
    }

    /**
     * ALIAS
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function GooglePlusShareLink($customDescription = '')
    {
        return $this->getGooglePlusShareLink($customDescription);
    }

    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function getGooglePlusShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return ($pageURL) ? "https://plus.google.com/share?url=$pageURL" : false;
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

        return ($pageURL) ? "http://www.tumblr.com/share/link?url=$pageURL&name=$title&description=$description" : false;
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

        return ($pageURL) ? "http://pinterest.com/pin/create/button/?url=$pageURL&description=$description&media=$media" : false;
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

        return ($pageURL) ? "mailto:?subject=$title&body=$pageURL" : false;
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

        return ($pageURL) ? "http://reddit.com/submit?url=$pageURL&title=$title" : false;
    }

    private static $_cacheGetShareThisArray = [];

    /**
     * @param string $customDescription   e.g. foo bar cool stuff
     *
     * @return array
     */
    private function getShareThisArray($customDescription = '')
    {
        if(! isset(self::$_cacheGetShareThisArray[$this->object->ID])) {
            //1. link
            $linkMethod = $this->linkMethod;
            if ($this->object->hasMethod($linkMethod)) {
                $link = $this->object->$linkMethod();
            }

            //2. title
            $titleMethod = $this->titleMethod;
            if ($this->object->hasMethod($titleMethod)) {
                $title = $this->object->$titleMethod();
            } elseif (isset($this->object->$titleMethod)) {
                $title = $this->object->$titleMethod;
            }

            //3. media field
            $media = "";
            if ($this->imageMethods) {
                $imageMethods = $this->imageMethods;
            } else {
                $imageMethods = Config::inst()->get(ShareThisSimpleProvider::class, "image_methods");
            }
            if (is_array($imageMethods) && count($imageMethods)) {
                foreach ($imageMethods as $imageMethod) {
                    if ($this->object->hasMethod($imageMethod)) {
                        $imageField = $imageMethod."ID";
                        if ($this->$imageField) {
                            $image = $this->object->$imageMethod();
                            if ($image && $image->exists()) {
                                $media = $image->AbsoluteLink();
                                break;
                            }
                        }
                    }
                }
            }

            //description
            if ($customDescription) {
                $description = $customDescription;
            } else {
                $description = "";
                if ($descriptionMethod = $this->descriptionMethod) {
                    //do nothing
                } else {
                    $descriptionMethod = Config::inst()->get(ShareThisSimpleProvider::class, "description_method");
                }
                if ($descriptionMethod) {
                    if ($this->object->hasMethod($descriptionMethod)) {
                        $description = $this->object->$descriptionMethod();
                    } elseif (isset($this->object->$descriptionMethod)) {
                        $description = $this->object->$descriptionMethod;
                    }
                }
            }

            $hashTags = $this->getValuesFromArrayToString('hashTags', 'hash_tags', '#');
            $mentions = $this->getValuesFromArrayToString('mentions', 'mentions', '@');
            $vias = $this->getValuesFromArrayToString('vias', 'vias', '@');

            //return ...
            self::$_cacheGetShareThisArray[$this->object->ID] = array(
                "pageURL" => rawurlencode($link),
                "title" => rawurlencode($title),
                "titleFull" => rawurlencode(trim($mentions.' '.$title.' '.$hashTags.' '.$vias)),
                "media" => rawurlencode($media),
                "description" => rawurlencode($description),
                "descriptionFull" => rawurlencode(trim($mentions.' '.$description.' '.$hashTags.' '.$vias)),
                "hashTags" => rawurlencode($mentions),
                "mentions" => rawurlencode($mentions),
                "vias" => rawurlencode($vias)
            );
        }

        return self::$_cacheGetShareThisArray[$this->object->ID];
    }

    protected function getValuesFromArrayToString($variable, $staticVariable, $prepender = '@')
    {
        if(count($this->$variable)) {
            $a = $this->$variable;
        } else {
            $a = $this->Config()->get($staticVariable);
        }
        $str = '';
        if(is_array($a) && count($a)) {
            $str = $prepender.implode(' '.$prepender, $a);
        }

        return trim($str);
    }

    /**
     *
     *
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
            $image = $this->object->$imageMethod();
            if ($image && $image->exists()) {
                if ($useImageTitle) {
                    $imageTitle = $image->Title;
                } else {
                    $imageTitle = $this->object->Title;
                }
                return 'http://pinterest.com/pin/create/button/'
                    .'?url='.urlencode($this->object->AbsoluteLink()).'&amp;'
                    .'description='.urlencode($imageTitle).'&amp;'
                    .'media='.urlencode($image->AbsoluteLink());
            }
        }
    }
}
