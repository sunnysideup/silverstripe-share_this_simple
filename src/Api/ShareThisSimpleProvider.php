<?php

namespace Sunnysideup\ShareThisSimple\Api;

use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Manifest\ModuleResourceLoader;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\ArrayData;
use SilverStripe\View\ViewableData;

class ShareThisSimpleProvider extends ViewableData
{
    /**
     * @var null|DataObject
     */
    protected $object;

    protected $linkMethod = 'AbsoluteLink';

    protected $titleMethod = 'Title';

    protected $imageMethods = [];

    protected $descriptionMethod = 'SocialMediaDescription';

    //change to 'SocialMediaDescription'

    protected $hashTagArray = [];

    protected $mentionsArray = [];

    protected $viasArray = [];

    /**
     * @var string
     */
    protected $pageURL = '';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $titleFull = '';

    /**
     * @var string
     */
    protected $media = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $descriptionFull = '';

    /**
     * @var string
     */
    protected $hashTags = '';

    /**
     * @var string
     */
    protected $mentions = '';

    /**
     * @var string
     */
    protected $vias = '';

    protected static $cacheGetShareThisArray = [];

    private static $pop_up_window_height = 320;

    private static $pop_up_window_width = 320;

    private static $description_method = '';

    private static $default_mentions = [];

    private static $default_vias = [];

    private static $default_hash_tags = [];

    private static $image_methods = [];

    private static $icon_links = [];

    private static $casting = [
        'FacebookShareLink' => 'Varchar',
        'BlueSkyShareLink' => 'Varchar',
        'TwitterShareLink' => 'Varchar',
        'TumblrShareLink' => 'Varchar',
        'PinterestShareLink' => 'Varchar',
        'RedditShareLink' => 'Varchar',
        'LinkedInShareLink' => 'Varchar',
        'EmailShareLink' => 'Varchar',
        'SmsShareLink' => 'Varchar',
        'WhatsAppShareLink' => 'Varchar',
        'SnapchatShareLink' => 'Varchar',
        'SignalShareLink' => 'Varchar',
        'PrintPageLink' => 'Varchar',
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

    public function setLinkMethod(string $s): self
    {
        $this->linkMethod = $s;

        return $this;
    }

    public function setTitleMethod(string $s): self
    {
        $this->titleMethod = $s;

        return $this;
    }

    public function setImageMethods(string $a): self
    {
        $this->imageMethods = $a;

        return $this;
    }

    public function setDescriptionMethod(string $s): self
    {
        $this->descriptionMethod = $s;

        return $this;
    }

    public function setHashTags(array $a): self
    {
        $this->hashTagsArray = $a;

        return $this;
    }

    public function setMentions(array $a): self
    {
        $this->mentionsArray = $a;

        return $this;
    }

    public function setVias(array $a): self
    {
        $this->viasArray = $a;

        return $this;
    }

    public function getWindowPopupHtml(): DBHTMLText
    {
        $width = $this->Config()->get('pop_up_window_width');
        $height = $this->Config()->get('pop_up_window_height');
        $html = <<<html
                    onclick="
                        window.open(this.href,'Share','width={$width},height={$height},toolbar=no,menubar=no,location=no,status=no,scrollbars=no,resizable');
                        return false;
                    "
html;
        $html = preg_replace('#\s+#', ' ', $html);

        return DBHTMLText::create_field('HTMLText', $html);
    }

    /**
     * return of ShareThisLinks.
     *
     * @param string $customDescription e.g. foo bar cool stuff
     */
    public function ShareThisLinks(?string $customDescription = ''): ArrayList
    {
        $arrayList = ArrayList::create();
        $options = array_keys(Config::inst()->get(ShareThisSimpleProvider::class, 'casting', Config::UNINHERITED));
        $icons = $this->config()->get('icon_links');
        foreach ($options as $option) {
            if ($option === 'PinterestLinkForSpecificImage') {
                continue;
            }
            $className = str_replace('ShareLink', '', (string) $option);
            $className = strtolower($className);
            $icon = '';
            if (! empty($icons[$className])) {
                $urlLink = $icons[$className];
                $url = ModuleResourceLoader::resourceURL($urlLink);
                $icon = DBField::create_field('HTMLText', '<img src="' . $url . '" alt="' . $option . '" />');
            }
            $method = 'get' . $option;
            $arrayList->push(
                ArrayData::create(
                    [
                        'Class' => $className,
                        'Link' => $this->{$method}($customDescription),
                        'Icon' => $icon,
                    ]
                )
            );
        }

        return $arrayList;
    }


    /**
     * Generate a URL to share this content on Facebook.
     *
     * @param string $customDescription e.g. foo bar cool stuff
     *                                  https://www.facebook.com/dialog/feed?
     *                                  &link=URL_HERE
     *                                  &picture=IMAGE_LINK_HERE
     *                                  &name=TITLE_HERE
     *                                  &caption=%20
     *                                  &description=DESCRIPTION_HERE
     *                                  &redirect_uri=http%3A%2F%2Fwww.facebook.com%2F
     */
    public function getFacebookShareLink(?string $customDescription = ''): string
    {
        $this->getShareThisArray($customDescription);

        return '' === $this->pageURL ? '' :
            'https://www.facebook.com/sharer/sharer.php?u=' . $this->pageURL;
    }


    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     * example: https://twitter.com/intent/tweet?
     *  &source=http%3A%2F%2Fsunnysideup.co.nz
     *  &text=test:%20http%3A%2F%2Fsunnysideup.co.nz
     *  &via=foobar.
     *
     * @param string $customDescription e.g. foo bar cool stuff
     */
    public function getBlueSkyShareLink(?string $customDescription = ''): string
    {
        $this->getShareThisArray($customDescription);

        return '' === $this->pageURL ? '' :
            'https://bsky.app/intent/compose?text=' . ($this->titleFull) . '&url=' . $this->pageURL;
    }

    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     * example: https://twitter.com/intent/tweet?
     *  &source=http%3A%2F%2Fsunnysideup.co.nz
     *  &text=test:%20http%3A%2F%2Fsunnysideup.co.nz
     *  &via=foobar.
     *
     * @param string $customDescription e.g. foo bar cool stuff
     */
    public function getTwitterShareLink(?string $customDescription = ''): string
    {
        $this->getShareThisArray($customDescription);

        return '' === $this->pageURL ? '' :
            'https://x.com/intent/tweet?text=' . ($this->titleFull) . '&url=' . $this->pageURL;
    }


    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     *
     * @param string $customDescription e.g. foo bar cool stuff
     *
     * @return string
     */
    public function getTumblrShareLink(?string $customDescription = '')
    {
        $this->getShareThisArray($customDescription);

        return '' === $this->pageURL ? '' :
            'http://www.tumblr.com/share/link?url=' . ($this->pageURL) . '&name=' . ($this->title) . '&description=' . ($this->description);
    }


    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     *
     * @param string $customDescription e.g. foo bar cool stuff
     */
    public function getPinterestShareLink(?string $customDescription = ''): string
    {
        $this->getShareThisArray($customDescription);

        return '' === $this->pageURL ? '' :
            'http://pinterest.com/pin/create/button/?url=' . $this->pageURL . '&description=' . $this->description . '&media=' . $this->media . '';
    }



    /**
     * Generate a URL to share this content on Twitter
     * Specs: https://dev.twitter.com/web/tweet-button/web-intent.
     *
     * @param string $customDescription e.g. foo bar cool stuff
     */
    public function getRedditShareLink(?string $customDescription = ''): string
    {
        $this->getShareThisArray($customDescription);

        return '' === $this->pageURL ? '' :
            'http://reddit.com/submit?url=' . $this->pageURL . '&title=' . $this->title;
    }

    /**
     * Generate a URL to share this content on Twitter
     * Specs: ???
     * example: https://www.linkedin.com/shareArticle?
     * mini=true&url=http://www.cnn.com&title=&summary=chek this out&source=.
     *
     * @param string $customDescription e.g. foo bar cool stuff
     */
    public function getLinkedInShareLink(?string $customDescription = ''): string
    {
        $this->getShareThisArray($customDescription);

        return '' === $this->pageURL ? '' :
            'https://www.linkedin.com/shareArticle?mini=true&url=' . $this->pageURL . '&summary=' . $this->titleFull . '';
    }

    /**
     * Generate a 'mailto' URL to share this content via Email.
     *
     * @param string $customDescription e.g. foo bar cool stuff
     */
    public function getEmailShareLink(?string $customDescription = ''): string
    {
        $this->getShareThisArray($customDescription);

        return '' === $this->pageURL ? '' :
            'mailto:?subject=' . $this->title . '&body=' . $this->pageURL;
    }

    /**
     * Generate a URL to share this content via SMS.
     *
     * @param string $customDescription e.g. foo bar cool stuff
     */
    public function getSmsShareLink(?string $customDescription = ''): string
    {
        $this->getShareThisArray($customDescription);

        return '' === $this->pageURL ? '' :
            'sms:?body=' . ($this->titleFull . ' ' . $this->pageURL);
    }
    /**
     * Generate a URL to share this content on WhatsApp.
     *
     * @param string $customDescription e.g. foo bar cool stuff
     */
    public function getWhatsAppShareLink(?string $customDescription = ''): string
    {
        $this->getShareThisArray($customDescription);

        return '' === $this->pageURL ? '' :
            'https://api.whatsapp.com/send?text=' . ($this->titleFull . ' ' . $this->pageURL);
    }

    /**
     * Generate a URL to share this content on Snapchat.
     *
     * @param string $customDescription e.g. foo bar cool stuff
     */
    public function getSnapchatShareLink(?string $customDescription = ''): string
    {
        $this->getShareThisArray($customDescription);

        return '' === $this->pageURL ? '' :
            'https://www.snapchat.com/share?url=' . $this->pageURL . '&text=' . $this->titleFull;
    }



    /**
     * Generate a URL to share this content on Signal.
     *
     * @param string $customDescription e.g. foo bar cool stuff
     */
    public function getSignalShareLink(?string $customDescription = ''): string
    {
        $this->getShareThisArray($customDescription);

        return '' === $this->pageURL ? '' :
            'https://signal.me/#p/' . ($this->titleFull . ' ' . $this->pageURL);
    }


    public function getPrintPageLink(): string
    {
        return 'javascript:window.print();';
    }

    public function getPinterestLinkForSpecificImage(string $imageMethod, ?bool $useImageTitle = false): string
    {
        if ($this->object && $this->object->exists() && $this->object->hasMethod($imageMethod)) {
            $image = $this->object->{$imageMethod}();
            if ($image && $image->exists()) {
                $imageTitle = $useImageTitle ? $image->Title : $this->object->Title;

                return 'http://pinterest.com/pin/create/button/?url=' . ($this->object->AbsoluteLink()) . '&amp;'
                    . 'description=' . ($imageTitle) . '&amp;'
                    . 'media=' . ($image->AbsoluteLink());
            }
        }

        return '';
    }


    /**
     * @param string $customDescription e.g. foo bar cool stuff
     */
    public function getShareThisArray(?string $customDescription = ''): array
    {
        $cacheKey = $this->object->ID . '_' . preg_replace('#[^A-Za-z0-9]#', '_', $customDescription);
        if (! isset(self::$cacheGetShareThisArray[$cacheKey])) {
            //1. link
            $this->link = $this->shareThisLinkField();

            $this->title = $this->shareThisTitleField();

            $this->media = $this->shareThisMediaField();

            $this->description = $this->shareThisDescriptionField($customDescription);

            $this->hashTags = $this->getValuesFromArrayToString('hashTagsArray', 'hash_tags', '#');
            $this->mentions = $this->getValuesFromArrayToString('mentionsArray', 'mentions');
            $this->vias = $this->getValuesFromArrayToString('viasArray', 'vias');
            $this->titleFull = trim($this->mentions . ' ' . $this->title . ' ' . $this->hashTags . ' ' . $this->vias);
            $this->descriptionFull = trim($this->mentions . ' ' . $this->description . ' ' . $this->hashTags . ' ' . $this->vias);

            //return ...
            self::$cacheGetShareThisArray[$cacheKey] = [
                'pageURL' => rawurlencode($this->link),
                'title' => rawurlencode($this->title),
                'titleFull' => rawurlencode($this->titleFull),
                'media' => rawurlencode($this->media),
                'description' => rawurlencode($this->description),
                'descriptionFull' => rawurlencode($this->descriptionFull),
                'hashTags' => rawurlencode($this->hashTags),
                'mentions' => rawurlencode($this->mentions),
                'vias' => rawurlencode($this->vias),
            ];
        }

        foreach (self::$cacheGetShareThisArray[$cacheKey] as $field => $value) {
            $this->{$field} = $value;
        }

        return self::$cacheGetShareThisArray[$cacheKey];
    }


    protected function getValuesFromArrayToString(string $variable, string $staticVariable, ?string $prepender = '@')
    {
        $a = empty($this->{$variable}) ? $this->Config()->get($staticVariable) : $this->{$variable};
        $str = '';
        if (is_array($a) && count($a)) {
            $str = $prepender . implode(' ' . $prepender, $a);
        }

        return trim($str);
    }

    private function shareThisLinkField(): string
    {
        return $this->shareThisFieldAsString($this->linkMethod);
    }

    private function shareThisTitleField(): string
    {
        return $this->shareThisFieldAsString($this->titleMethod);
    }

    private function shareThisFieldAsString(string $field): string
    {
        $value = '';
        if ($this->object->hasMethod($field)) {
            $value = $this->object->{$field}();
        } elseif (isset($this->object->{$field})) {
            $value = $this->object->{$field};
        }

        return (string) $value;
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

    private function shareThisDescriptionField(?string $customDescription = ''): string
    {
        if ($customDescription) {
            $description = $customDescription;
        } else {
            $description = '';
            $descriptionMethod = $this->descriptionMethod;
            if (! $descriptionMethod) {
                $descriptionMethod = Config::inst()->get(
                    'ShareThisSimpleProvider',
                    'description_method'
                );
            }

            if ($descriptionMethod) {
                $description = $this->shareThisFieldAsString($descriptionMethod);
            }
        }

        return $description;
    }
}
