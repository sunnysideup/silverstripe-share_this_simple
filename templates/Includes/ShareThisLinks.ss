<% if $ShareThisSimpleProvider %><% with $ShareThisSimpleProvider %>
    <div class="share-holder">
        <div class="share-button"><a href="#">Share This</a></div>
        <div class="share-expanded">
            <h2>Choose one of two below by theme-ing this file...</h2>
            <ul>
                <li><a href="$FacebookShareLink" class="FacebookShareLink">FacebookShareLink</a></li>
                <li><a href="$TwitterShareLink" class="TwitterShareLink">TwitterShareLink</a></li>
                <li><a href="$TumblrShareLink" class="TumblrShareLink">TumblrShareLink</a></li>
                <li><a href="$PinterestShareLink" class="PinterestShareLink">PinterestShareLink</a></li>
                <li><a href="$EmailShareLink" class="EmailShareLink">EmailShareLink</a></li>
                <li><a href="$RedditShareLink" class="reddit">RedditShareLink</a></li>
            </ul>
            <hr />
            <ul>
            <% loop $ShareThisLinks %>
                <li><a href="$Link" class="$Class">$Class</a></li>
            <% end_loop %>
            </ul>
        </div>
    </div>
<% end_with %><% end_if %>
