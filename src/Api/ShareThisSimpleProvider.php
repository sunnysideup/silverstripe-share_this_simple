<?php

namespace  Education\DandI\ViewableData;

use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\ArrayData;
use SilverStripe\View\ViewableData;
use SilverStripe\Core\Config\Config;

class ShareThisProvider extends ViewableData
{
    private static $description_method = '';

    private static $default_mentions = [];

    private static $default_vias = [];

    private static $default_hash_tags = [];

    private static $image_methods = array();

    private static $casting = array(
        "FacebookShareLink" => "Varchar",
        "TwitterShareLink" => "Varchar",
        "LinkedInShareLink" => "Varchar",
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

    protected $imageMethods = array();

    public function setImageMethods($a)
    {
        $this->imageMethods = $a;
    }

    protected $descriptionMethod = 'SocialMediaDescription';

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
    public function ShareThisLinks($customDescription = '')
    {
        $arrayList = ArrayList::create();
        $options = array_keys($this->config()->get('casting'));
        foreach ($options as $option) {
            $className  = str_replace('ShareLink', '', $option);
            $className  = strtolower($className);
            $method = "get".$option;
            $arrayList->push(
                ArrayData::create(
                    array(
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
     * https://www.facebook.com/dialog/feed?
     * &link=URL_HERE&picture=IMAGE_LINK_HERE&name=TITLE_HERE&caption=%20
     * &description=DESCRIPTION_HERE
     * &redirect_uri=http%3A%2F%2Fwww.facebook.com%2F
     * @return string|false
     */
    public function getFacebookShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return ($pageURL) ?
            "https://www.facebook.com/sharer/sharer.php?"
            ."u=$pageURL&t=$title"
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
     * example: https://twitter.com/intent/tweet
     * ?source=http%3A%2F%2Fsunnysideup.co.nz
     * &text=test:%20http%3A%2F%2Fsunnysideup.co.nz&via=matteo
     * @param string $customDescription   e.g. foo bar cool stuff
     * @return string|false
     */
    public function getTwitterShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return ($pageURL) ?
            "https://twitter.com/intent/tweet?source=".
            "$pageURL&text=$titleFull".urlencode(': ').$pageURL
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

        return ($pageURL) ?
            "https://www.linkedin.com/shareArticle".
            "?mini=true&url=$pageURL&summary=$titleFull"
        :
            false;
    }

    private static $cacheGetShareThisArray = [];

    /**
     * @param string $customDescription   e.g. foo bar cool stuff
     *
     * @return array
     */
    private function getShareThisArray($customDescription = '')
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
            $titleFull = trim($mentions.' '.$title.' '.$hashTags.' '.$vias);
            $descriptionFull = trim($mentions.' '.$description.' '.$hashTags.' '.$vias);

            //return ...
            self::$cacheGetShareThisArray[$this->object->ID] = array(
                "pageURL" => rawurlencode($link),
                "title" => rawurlencode($title),
                "titleFull" => rawurlencode($titleFull),
                "media" => rawurlencode($media),
                "description" => rawurlencode($description),
                "descriptionFull" => rawurlencode($descriptionFull),
                "hashTags" => rawurlencode($mentions),
                "mentions" => rawurlencode($mentions),
                "vias" => rawurlencode($vias)
            );
        }

        return self::$cacheGetShareThisArray[$this->object->ID];
    }

    protected function getValuesFromArrayToString($variable, $staticVariable, $prepender = '@')
    {
        if (count((array)$this->$variable)) {
            $a = $this->$variable;
        } else {
            $a = $this->Config()->get($staticVariable);
        }
        $str = '';
        if (is_array($a) && count($a)) {
            $str = $prepender.implode(' '.$prepender, $a);
        }

        return trim($str);
    }

    private function shareThisLinkField()
    {
        $link = '';
        $linkMethod = $this->linkMethod;
        if ($this->object->hasMethod($linkMethod)) {
            $link = $this->object->$linkMethod();
        }

        return $link;
    }

    private function shareThisTitleField() : string
    {
        $title = '';
        $titleMethod = $this->titleMethod;
        if ($this->object->hasMethod($titleMethod)) {
            $title = $this->object->$titleMethod();
        } elseif (isset($this->object->$titleMethod)) {
            $title = $this->object->$titleMethod;
        }

        return $title;
    }

    private function shareThisMediaField() : string
    {
        $media = '';
        $imageMethods = $this->imageMethods;
        if (is_array($imageMethods) && count($imageMethods)) {
            //do nothing
        } else {
            $imageMethods = Config::inst()->get(
                "ShareThisSimpleProvider",
                "image_methods"
            );
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

        return $media;
    }


    private function shareThisDescriptionField(string $customDescription) : string
    {
        $description = '';

        if ($customDescription) {
            $description = $customDescription;
        } else {
            $description = "";
            if ($descriptionMethod = $this->descriptionMethod) {
                //do nothing
            } else {
                $descriptionMethod = Config::inst()->get(
                    "ShareThisSimpleProvider",
                    "description_method"
                );
            }
            if ($descriptionMethod) {
                if ($this->object->hasMethod($descriptionMethod)) {
                    $description = $this->object->$descriptionMethod();
                } elseif (isset($this->object->$descriptionMethod)) {
                    $description = $this->object->$descriptionMethod;
                }
            }
        }
        return (string)$description;
    }
}
