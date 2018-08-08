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
                var el = jQuery(this)
                    .closest('.share-holder')
                    .find('.share-expanded');
                el.slideToggle();

                //auto-close after xxx-seconds.
                window.setTimeout(
                    function()
                    {
                        el.slideToggle();
                    },
                    7000
                )
                return false;
            }
        )
    }

);
