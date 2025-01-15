<% if $ShareThisSimpleProvider %>
    <% with $ShareThisSimpleProvider %>
        <div class="share-holder">
            <div class="share-expanded">
                <ul class="share-links">
                    <li>
                        <a href="$FacebookShareLink" class="FacebookShareLink" $WindowPopupHtml>
                            <svg class="share-this-icon">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-facebook"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$BlueSkyShareLink" class="BlueSkyShareLink" $WindowPopupHtml>
                            <svg class="share-this-icon">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-bluesky"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$TwitterShareLink" class="TwitterShareLink" $WindowPopupHtml>
                            <svg class="share-this-icon">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-twitter"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$TumblrShareLink" class="TumblrShareLink" $WindowPopupHtml>
                            <svg class="share-this-icon">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-tumblr"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$PinterestShareLink" class="PinterestShareLink" $WindowPopupHtml>
                            <svg class="share-this-icon">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-pinterest"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$RedditShareLink" class="RedditShareLink" $WindowPopupHtml>
                            <svg class="share-this-icon">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-reddit"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$LinkedInShareLink" class="LinkedInShareLink" $WindowPopupHtml>
                            <svg class="share-this-icon">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-linkedin"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$EmailShareLink" class="EmailShareLink" $WindowPopupHtml>
                            <svg class="share-this-icon">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-email"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$SmsShareLink" class="SmsShareLink" $WindowPopupHtml>
                            <svg class="share-this-icon">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-sms"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$WhatsAppShareLink" class="WhatsAppShareLink" $WindowPopupHtml>
                            <svg class="share-this-icon">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-whatsapp"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$SnapchatShareLink" class="SnapchatShareLink" $WindowPopupHtml>
                            <svg class="share-this-icon">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-snapchat"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$SignalShareLink" class="SignalShareLink" $WindowPopupHtml>
                            <svg class="share-this-icon">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-signal"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$PrintPageLink" class="PrintPageLink">
                            <svg class="share-this-icon">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-print"></use>
                            </svg>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    <% end_with %>
<% end_if %>
<style>
.share-this-icon {
    width: 24px;
    height: 24px;
    fill: currentColor;
}
</style>
