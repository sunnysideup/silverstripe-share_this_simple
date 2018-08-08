jQuery(document).ready(

    function()
    {
        jQuery('.share-expanded').hide();
        jQuery('.share-holder').on(
            'click',
            '.share-button > a',
            function(event)
            {
                event.preventDefault();
                jQuery(this)
                    .closest('.share-holder')
                    .find('.share-expanded')
                    .slideToggle();
                return false;
            }
        )
    }

);
