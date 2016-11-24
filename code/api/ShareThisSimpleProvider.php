<?php

class ShareThisSimpleProvider extends ViewableData
{
    private static $description_method = "";

    private static $image_methods = array();

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
     * @var SiteTree
     */
    protected $object;

    /**
     * @param SiteTree $objects
     */
    public function __construct(SiteTree $object)
    {
        $this->object = $object;
    }

    protected $linkMethod = '';

    function setLinkMethod($s)
    {
        $this->linkMethod = $s;
    }

    protected $titleMethod = '';

    function setTitleMethod($s)
    {
        $this->titleMethod = $s;
    }

    /**
     * return of ShareThisLinks.
     *
     * @return ArrayList
     */
    public function ShareThisLinks($customDescription= '')
    {
        $arrayList = ArrayList::create();
        $options = array_keys($this->stat('casting'));
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
     *
     * @return string|false
     */
    public function FacebookShareLink($customDescription = '')
    {
        return $this->getFacebookShareLink();
    }

    /**
     * Generate a URL to share this content on Facebook.
     *
     * @return string|false
     */
    public function getFacebookShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return ($pageURL) ? "https://www.facebook.com/sharer/sharer.php?u=$pageURL" : false;
    }

    /**
     * ALIAS
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     *
     * @return string|false
     */
    public function TwitterShareLink($customDescription = '')
    {
        return $this->getTwitterShareLink();
    }

    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     *
     * @return string|false
     */
    public function getTwitterShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return ($pageURL) ? "https://twitter.com/intent/tweet?text=$title&url=$pageURL" : false;
    }

    /**
     * ALIAS
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     *
     * @return string|false
     */
    public function GooglePlusShareLink($customDescription = '')
    {
        return $this->getGooglePlusShareLink();
    }

    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     *
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
     *
     * @return string|false
     */
    public function TumblrShareLink($customDescription = '')
    {
        return $this->getTumblrShareLink();
    }

    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     *
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
     *
     * @return string|false
     */
    public function PinterestShareLink($customDescription = '')
    {
        return $this->getPinterestShareLink();
    }

    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     *
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
     *
     * @return string|false
     */
    public function EmailShareLink($customDescription = '')
    {
        return $this->getEmailShareLink();
    }

    /**
     * Generate a 'mailto' URL to share this content via Email.
     *
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
     *
     * @return string|false
     */
    public function RedditShareLink($customDescription = '')
    {
        return $this->getRedditShareLink();
    }

    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     *
     * @return string|false
     */
    public function getRedditShareLink($customDescription = '')
    {
        extract($this->getShareThisArray($customDescription));

        return ($pageURL) ? "http://reddit.com/submit?url=$pageURL&title=$title" : false;
    }

    /**
     *
     *
     * @return array
     */
    private function getShareThisArray($customDescription = '')
    {
        //1. link
        $linkMethod = $this->linkMethod
        if($this->object->hasMethod($linkMethod)) {
            $link = $this->object->$linkMethod();
        } else {
            $link = $this->object->AbsoluteLink();
        }


        //2. title
        $titleMethod = $this->titleMethod
        if($this->object->hasMethod($titleMethod)) {
            $title = $this->object->$titleMethod();
        } else {
            $title = $this->object->Title;
        }

        //3. media field
        $media = "";
        $imageMethods = Config::inst()->get("ShareThisSimpleProvider", "image_methods");
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
            $descriptionMethod = Config::inst()->get("ShareThisSimpleProvider", "description_method");
            $description = "";
            if ($descriptionMethod) {
                if ($this->object->hasMethod($descriptionMethod)) {
                    $description = $this->object->$descriptionMethod();
                }
            }
        }
        //return ...
        return array(
            "pageURL" => rawurlencode($link),
            "title" => rawurlencode($title),
            "media" => rawurlencode($media),
            "description" => rawurlencode($description)
        );
    }

    /**
     *
     *
     * @param string $imageMethod   e.g. MyImage
     * @param bool $useImageTitle  if set to false, it will use the page title as the image title
     */
    public function PinterestLinkForSpecificImage($imageMethod, $useImageTitle = false)
    {
        return $this->getPinterestLinkForSpecificImage($imageMethod, $useImageTitle);
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
