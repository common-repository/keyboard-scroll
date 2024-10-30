jQuery(document).ready(function() {

    // get height of admin bar if present
    var adminbar_height = (jQuery('#wpadminbar').height() === undefined) ? 0 : jQuery('#wpadminbar').height();

    var animate = 0;
    var offset = 0;
    var old_offset = -1;
    var theQueue = jQuery({}); // queue keypresses if user types rapidly

    var first_post = jQuery('.post').first();
    var last_post = jQuery('.post').last();

    // scroll to the first article after change next page
    if (jkks.next_page == 1) {
        jQuery(window).scrollTop(first_post.offset().top-adminbar_height, 0);
    }

    // scroll to the last article after change to previous page
    if (jkks.prev_page == 1)
        jQuery(window).scrollTop(last_post.offset().top-adminbar_height, 0);

    jQuery.fn.reverse = [].reverse; // necessary work around

    // -----------------------------------------------------------------------------------------------------------------
    jQuery(document).keyup(function(e) {

        // leave if element is an input element
        if (e.target && e.target.tagName.toLowerCase() == 'textarea'
            || e.target.tagName.toLowerCase() == 'input'
            || e.target.tagName.toLowerCase() == 'button'
            || e.target.tagName.toLowerCase() == 'select'
            ) {
                return true;
        }

        // check for navigation keys
        key_j = (e.keyCode === 74);
        key_k = (e.keyCode === 75);

       // leave if key is not k or j
       if (! key_j && ! key_k)
           return;

        if (key_j) {
            if (animate) {
                jQuery('html, body').stop(true);
                J();
                theQueue.queue('keys', J);
            }
            else
                J();
        }

        if (key_k) {
            if (animate) {
                jQuery('html, body').stop(true);
                K();
                theQueue.queue('keys', K);
            }
            else
                K();
        }
        // -------------------------------------------------------------------------------------------------------------
        function J() {
            jkks.next_page = 0;
            scrollTop = jQuery(window).scrollTop();
            jQuery("." + jkks.css_class).each( function(index, element) {
                offset = Math.floor(jQuery(this).offset().top - adminbar_height);
                if ( scrollTop+1 < offset) {
                    do_scroll(jQuery(this), offset, parseInt(jkks.animationspeed));
                    e.preventDefault();
                    return(false);
                } //if
            });

            if (jkks.pagechange == 1 && (old_offset == offset || jkks.prev_page == 1) )
                next_page();
            old_offset = offset;        }
        // -------------------------------------------------------------------------------------------------------------

        function K() {
            jkks.prev_page = 0;
            scrollTop = jQuery(window).scrollTop();
            jQuery("." + jkks.css_class).reverse().each( function(index, element) {
                offset = jQuery(this).offset().top - adminbar_height;
                if ( scrollTop > Math.ceil(offset)) {
                    do_scroll(jQuery(this), offset, parseInt(jkks.animationspeed));
                    e.preventDefault();
                    return(false);
                } //if
            });

            if ( (jkks.pagechange == 1) && (Math.ceil(old_offset) == Math.ceil(offset) || jkks.next_page == 1) )
                prev_page();

            old_offset = offset;

        }

    });
    // -----------------------------------------------------------------------------------------------------------------
    function do_scroll(element, offset, speed) {
        if (animate && (jkks.dynamic_scroll != 0) ) {
            speed = speed  / jkks.acceleration;
        }
        animate = 1;
        jQuery('html, body').stop(true).animate({scrollTop: offset}, speed, function() {
            if (theQueue.queue('keys').length > 0) {
                theQueue.dequeue('keys');
            }
            else {
                animate = 0;
            }


        });
    }
    // -----------------------------------------------------------------------------------------------------------------
    function prev_page() {
        var page;

        page = parseInt(jkks.paged) - 1;  //paged zero based
        if (page < 1)  // we're on the first page, no need for action
            return;

        var path = window.location.pathname;
        if (jkks.permalink_structure) {// permalinks enabled
            if (1 !== page)
                path = (path.replace(/\/page\/(\d+)\/?$/, '/page/' + page + '/'));
            else
                path = (path.replace(/\/page\/(\d+)\/?$/, '/'));

        }

        else // no permalinks
            path += (1 === page) ? '' : '?paged=' + page;

        // tell the previous page I send you there
        var form = jQuery('<form>',{attr:{method: 'POST', action: path}});
        jQuery('<input>',{attr:{type: 'hidden', name: 'jkks_prev_page', value: 1}}).appendTo(form);
        jQuery('body').append(form);
        form.submit();

    } //prev_page()
    // -----------------------------------------------------------------------------------------------------------------
    function next_page() {
        var page;

        // last page
        if (1 == jkks.last_page) {
            return;
        }

        var path = window.location.pathname;
        page = parseInt(jkks.paged) +1;  //paged zero based


        if (jkks.permalink_structure)  // permalinks enabled
            path = (1 == page) ? path + 'page/2/' : (path.replace(/\/page\/(\d+)\/?$/, '/page/' + page + '/'));
        else // no permalinks
            path += (1 === page) ? '?paged=2' : '?paged=' + page;

        // tell the next page I send you there
        var form = jQuery('<form>',{attr:{method: 'POST', action: path}});
        jQuery('<input>',{attr:{type: 'hidden', name: 'jkks_next_page', value: 1}}).appendTo(form);
        jQuery('body').append(form);
        form.submit();

    } //next_page()

});

