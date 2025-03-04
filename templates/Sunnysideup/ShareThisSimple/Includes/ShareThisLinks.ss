<% if $ShareThisSimpleProvider %>
    <% with $ShareThisSimpleProvider %>
        <script>
            const openPopupWindow = (href) => {
                const width = Math.round(screen.width * 0.8) || 800;
                const height = Math.round(screen.height * 0.8) || 600;
                const left = (screen.width - width) / 2;
                const top = (screen.height - height) / 2;

                window.open(
                    href,
                    'Share',
                    `width=${width},height=${height},top=${top},left=${left},toolbar=no,menubar=no,location=no,status=no,scrollbars=no,resizable,noopener`
                );

                return false;
            };
        </script>
        <style>
            .share-holder {
                .share-links {
                    a {
                        span {
                            display: none;
                        }
                        .share-this-icon {
                            width: 24px;
                            height: 24px;
                            fill: currentColor;
                        }
                    }
                }
            }
        </style>
        <div class="share-holder">
            <div class="share-expanded">
                <ul class="share-links">
                    <li>
                        <a href="$FacebookShareLink" class="FacebookShareLink" $WindowPopupHtml aria-label="Share on Facebook">
                            <span>Share on Facebook</span>
                            <svg class="share-this-icon" width="24" height="24" >
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-facebook"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$BlueSkyShareLink" class="BlueSkyShareLink" $WindowPopupHtml aria-label="Share on BlueSky">
                            <span>Share on BlueSky</span>
                            <svg class="share-this-icon" width="24" height="24">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-bluesky"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$TwitterShareLink" class="TwitterShareLink" $WindowPopupHtml aria-label="Share on X (Twitter)">
                            <span>Share on X (Twitter)</span>
                            <svg class="share-this-icon" width="24" height="24">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-twitter"></use>
                            </svg>
                        </a>
                    </li>
                    <%-- <li>
                        <a href="$TumblrShareLink" class="TumblrShareLink" $WindowPopupHtml aria-label="Share on Thumblr">
                            <span>Share on Tumblr</span>
                            <svg class="share-this-icon" width="24" height="24">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-tumblr"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$PinterestShareLink" class="PinterestShareLink" $WindowPopupHtml aria-label="Share on Pinterest">
                            <span>Share on Pinterest</span>
                            <svg class="share-this-icon" width="24" height="24">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-pinterest"></use>
                            </svg>
                        </a>
                    </li> --%>
                    <li>
                        <a href="$RedditShareLink" class="RedditShareLink" $WindowPopupHtml aria-label="Share on Reddit">
                            <span>Share on Reddit</span>
                            <svg class="share-this-icon" width="24" height="24">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-reddit"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$LinkedInShareLink" class="LinkedInShareLink" $WindowPopupHtml aria-label="Share on LinkedIn">
                            <span>Share on LinkedIn</span>
                            <svg class="share-this-icon" width="24" height="24">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-linkedin"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$EmailShareLink" class="EmailShareLink" $WindowPopupHtml aria-label="Share via Email">
                            <span>Share via Email</span>
                            <svg class="share-this-icon" width="24" height="24">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-email"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$SmsShareLink" class="SmsShareLink" $WindowPopupHtml aria-label="Share via SMS">
                            <span>Share via SMS</span>
                            <svg class="share-this-icon" width="24" height="24">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-sms"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$WhatsAppShareLink" class="WhatsAppShareLink" $WindowPopupHtml aria-label="Share via WhatsApp">
                            <span>Share via WhatsApp</span>
                            <svg class="share-this-icon" width="24" height="24">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-whatsapp"></use>
                            </svg>
                        </a>
                    </li>
                    <%-- <li>
                        <a href="$SnapchatShareLink" class="SnapchatShareLink" $WindowPopupHtml>
                            <span>Share via Snapchat</span>
                            <svg class="share-this-icon" width="24" height="24">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-snapchat"></use>
                            </svg>
                        </a>
                    </li> --%>
                    <li>
                        <a href="$SignalShareLink" class="SignalShareLink" $WindowPopupHtml aria-label="Share via Signal">
                            <span>Share via Signal</span>
                            <svg class="share-this-icon" width="24" height="24">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-signal"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="$PrintPageLink" class="PrintPageLink" aria-label="Print this page">
                            <span>Print this page</span>
                            <svg class="share-this-icon" width="24" height="24">
                                <use xlink:href="{$resourceURL('sunnysideup/share_this_simple:client/images/share-this-sprite.svg')}#icon-print"></use>
                            </svg>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    <% end_with %>
<% end_if %>
