# Share this Simple

Add Share This links to your Pages...

Options are:
 * ShareThisLinks (list of all links)
 * FacebookShareLink
 * TwitterShareLink
 * TumblrShareLink
 * PinterestShareLink
 * EmailShareLink
 * RedditShareLink


# Install

As per usual - nothing special.

# Usage

in template within context of a page:

```html
    <a href="$ShareThisSimpleProvider.FacebookShareLink" $ShareThisSimpleProvider.WindowPopupHtml>Share on Facebook</a>
```

Note that we you can add a nice old school pop-up as Facebook does not allow iframe.

OR

```html
    <a href="$ShareThisSimpleProvider.TwitterShareLink" >Share on Twitter</a>
```
OR

```html
<% loop $ShareThisSimpleProvider.ShareThisLinks %>
    <a href="$Link" class="$Class">add icon here using class ...</a>
<% end_loop %>
```


# you can also add the following to the config:

```yml

MyModelObject:
  extensions:
    - ShareThisSimpleExtension

```

The object will need to have a `Link` method...
