

(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '<ul><li data-name="namespace:Indgy" class="opened"><div style="padding-left:0px" class="hd"><span class="icon icon-play"></span><a href="Indgy.html">Indgy</a></div><div class="bd"><ul><li data-name="class:Indgy_Philter" class="opened"><div style="padding-left:26px" class="hd leaf"><a href="Indgy/Philter.html">Philter</a></div></li></ul></div></li></ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                        {"type":"Namespace","link":"Indgy.html","name":"Indgy","doc":"Namespace Indgy"},                                                        {"type":"Class","fromName":"Indgy","fromLink":"Indgy.html","link":"Indgy/Philter.html","name":"Indgy\\Philter","doc":"A PHP fluent input sanitiser."},
                                {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method___construct","name":"Indgy\\Philter::__construct","doc":"The constructor requires the untrusted input."},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_toBool","name":"Indgy\\Philter::toBool","doc":"Return the variable cast as a Boolean"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_toFloat","name":"Indgy\\Philter::toFloat","doc":"Return the variable cast as a Float"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_toInt","name":"Indgy\\Philter::toInt","doc":"Return the variable cast as an Integer"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_toString","name":"Indgy\\Philter::toString","doc":"Return the variable cast as a String"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_allow","name":"Indgy\\Philter::allow","doc":"Removes any characters that are not in the allow list"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_alpha","name":"Indgy\\Philter::alpha","doc":"Removes any non alphabetical characters"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_alphanum","name":"Indgy\\Philter::alphanum","doc":"Removes any non alpha-numeric characters"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_apply","name":"Indgy\\Philter::apply","doc":"Accepts a user defined closure"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_ascii","name":"Indgy\\Philter::ascii","doc":"Removes any non-ascii characters, transliterating as necessary"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_between","name":"Indgy\\Philter::between","doc":"Filters the variable, ensuring it is between $min and $max"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_contains","name":"Indgy\\Philter::contains","doc":"Checks that the variable contains the string in $match"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_cut","name":"Indgy\\Philter::cut","doc":"Shortens the length to $len characters"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_default","name":"Indgy\\Philter::default","doc":"Sets a default value to be returned if the variable is null"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_digits","name":"Indgy\\Philter::digits","doc":"Removes any non numeric characters"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_email","name":"Indgy\\Philter::email","doc":"Removes any characters that should not be in an email address."},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_in","name":"Indgy\\Philter::in","doc":"Filter to check if the value is in the provided array of values"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_min","name":"Indgy\\Philter::min","doc":"Filters the variable, ensuring it is no less than the value of min"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_max","name":"Indgy\\Philter::max","doc":"Filters the variable, ensuring it is no greater than the value of min"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_numeric","name":"Indgy\\Philter::numeric","doc":"Removes any non numeric characters, allows typical number markup + or - brackets commas and decimals"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_trim","name":"Indgy\\Philter::trim","doc":"Trims the leading and trailing characters from the variable"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_ltrim","name":"Indgy\\Philter::ltrim","doc":"Trims the leftmost character matching $char"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_rtrim","name":"Indgy\\Philter::rtrim","doc":"Trims the rightmost character matching $char"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_stripHtml","name":"Indgy\\Philter::stripHtml","doc":"Removes all HTML"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_stripTags","name":"Indgy\\Philter::stripTags","doc":"Removes the majority of HTML tags leaving only a basic set without attributes"},
        {"type":"Method","fromName":"Indgy\\Philter","fromLink":"Indgy/Philter.html","link":"Indgy/Philter.html#method_stripUnprintable","name":"Indgy\\Philter::stripUnprintable","doc":"Removes any unprintable characters"},
            
                                // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Doctum = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Doctum.injectApiTree($('#api-tree'));
    });

    return root.Doctum;
})(window);

$(function() {

    
    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').on('click', function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Doctum.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


