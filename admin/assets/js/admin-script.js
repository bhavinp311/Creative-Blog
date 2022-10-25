jQuery(document).ready(function (e) {
    // Set up some blank variable
    var sticky, copyText, tooltip, thisIndex, layoutType, msLayout, layoutPreview, sliderVal, sliderValColor, radioName, postSwitchArr, queryStr = '';
    var spaceArr = [];

    // Load dropdown with icon
    jQuery("select.f-dropdown").fSelectDropdown();

    // Copy to click shortcode 
    jQuery('#cbdb-click-copy').on('click', function () {
        // Get the text field
        copyText = document.getElementById('cbdb-sc-field');
        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

        tooltip = document.getElementById('cbdb-sp-tooltip');
        tooltip.innerHTML = 'Copied';
    });

    // Add copy to clipboard text inside element on mouseout
    jQuery('#cbdb-click-copy').mouseout(function () {
        tooltip = document.getElementById('cbdb-sp-tooltip');
        tooltip.innerHTML = 'Copy to clipboard';
    });

    // WordPress color picker
    jQuery('.cbdb-color-field').wpColorPicker();

    // Vertical tab menu
    jQuery('.cbdb-tabs nav a').on('click', function () {
        thisIndex = parseInt(jQuery(this).index());
        show_content(thisIndex);
        jQuery('input[name="cbdb_tab_index"]').val(thisIndex);
    });

    // If query string tab is present active particular tab
    queryStr = parseInt(getParamByName('tab'));
    if (queryStr) {
        queryStr = parseInt(queryStr);
        show_content(queryStr);
        jQuery('input[name="cbdb_tab_index"]').val(queryStr);
    } else {
        show_content(0);
        jQuery('input[name="cbdb_tab_index"]').val(0);
    }

    function show_content(index) {
        index = parseInt(index + 1);
        // Make the content visible
        jQuery('.cbdb-tabs .cbdb-content.visible').removeClass('visible');
        jQuery('.cbdb-tabs .cbdb-content:nth-of-type(' + index + ')').addClass('visible');
        // Set the tab to selected
        jQuery('.cbdb-tabs nav a.selected').removeClass('selected');
        jQuery('.cbdb-tabs nav a:nth-of-type(' + index + ')').addClass('selected');
    }

    // Plus Minus click event for input type number
    jQuery('.cbdb-minus').on('click', function () {
        var $input = jQuery(this).parent().parent().find('input');
        var $min = jQuery(this).parent().parent().find('input').attr('min');
        if (parseInt($input.val()) <= $min) {
            return false;
        }
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    jQuery('.cbdb-plus').on('click', function () {
        var $input = jQuery(this).parent().parent().find('input');
        var $max = jQuery(this).parent().parent().find('input').attr('max');
        if (parseInt($input.val()) >= $max) {
            return false;
        }
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });

    // Set min, max values if exeeds
    jQuery('#cbdb-layout-form input[type="number"]').on('keyup', function (e) {
        var $input = jQuery(this);
        var $min = $input.attr('min');
        var $max = $input.attr('max');
        if (parseInt($input.val()) > $max) {
            $input.val(parseInt($max));
            return false;
        }
        if (parseInt($input.val()) < $min) {
            $input.val(parseInt($min));
            return false;
        }
    });

    // Prevent user to special characters and numbers
    jQuery('#cbdb-layout-form input[type="number"]').on('keypress', function (e) {
        var $input = jQuery(this);
        spaceArr = ['margin', 'padding', 'letter-spacing'];
        if (jQuery.inArray($input.attr('id'), spaceArr)) {
            if (e.which != 8 && e.which == 189 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                $input.focus();
                return false;
            }
        } else {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                $input.focus();
                return false;
            }
        }
    });

    // Multiple select2
    jQuery(".cbdb-select2").select2({
        maximumSelectionLength: 4
    });

    // Range slider oninput value
    if (jQuery('.cbdb-slider-output').length) {
        jQuery('.cbdb-slider-output').each(function () {
            sliderVal = jQuery(this).val();
            jQuery(this).css('background', `linear-gradient(to right, #6978F4 0%, #E0B2F9 ${sliderVal}%, rgb(105 120 244 / 10%) ${sliderVal}%, rgb(105 120 244 / 10%) 100%`);
        });
        jQuery('.cbdb-slider-output').on('input', function () {
            sliderVal = jQuery(this).val();
            jQuery(this).next().val(sliderVal);
            jQuery(this).next().next('.cbdb-slider-val').find('.range-slider__value').val(sliderVal);
            jQuery(this).css('background', `linear-gradient(to right, #6978F4 0%, #E0B2F9 ${sliderVal}%, rgb(105 120 244 / 10%) ${sliderVal}%, rgb(105 120 244 / 10%) 100%`);
        });
        // Range slider textbox onblur value
        jQuery('.range-slider__value').on('blur', function () {
            sliderVal = sliderValColor = jQuery(this).val();
            if (sliderVal.trim() == '') {
                sliderVal = 0;
                sliderValColor = '';
                jQuery(this).val(sliderValColor);
            }
            jQuery(this).parent().parent().find('input[type="range"]').val(sliderVal);
            jQuery(this).parent().prev().val(sliderValColor);
            jQuery(this).parent().parent().find('.cbdb-slider-output').css('background', `linear-gradient(to right, #6978F4 0%, #E0B2F9 ${sliderVal}%, rgb(105 120 244 / 10%) ${sliderVal}%, rgb(105 120 244 / 10%) 100%`);
        });
    }

    // Post media custom size
    if (jQuery('#cbdb-post-media-size').length) {
        jQuery('#cbdb-post-media-size').on('change', function () {
            if (jQuery(this).val() == 'custom') {
                jQuery('.cbdb-add-custom-size-wrapper').removeClass('cbdb-d-none');
            } else {
                jQuery('.cbdb-add-custom-size-wrapper').addClass('cbdb-d-none');
            }
        });
    }

    // Hide/show the post content on enable/disable switch
    if (jQuery('.cbdb-post-switch').length) {
        jQuery('.cbdb-post-switch').on('click', function () {
            radioName = jQuery(this).attr('name');
            postSwitchArr = radioName.split('_');
            if (jQuery(this).val() == 0) {
                jQuery('.cbdb-' + postSwitchArr[1] + '-' + postSwitchArr[2] + '-switch').addClass('cbdb-d-none');
            } else {
                jQuery('.cbdb-' + postSwitchArr[1] + '-' + postSwitchArr[2] + '-switch').removeClass('cbdb-d-none');
            }
        });
    }

    // Hide/show post data style options on yes/no button switch
    if (jQuery('.cbdb-post-data-switch').length) {
        var fieldName;
        jQuery('.cbdb-post-data-switch').on('click', function () {
            fieldName = jQuery(this).attr('name');
            fieldName = fieldName.replace('cbdb_', '');
            fieldName = fieldName.replace('_link', '');
            fieldName = fieldName.replace('_btn', '');
            fieldName = fieldName.replace('_', '-');
            if (jQuery(this).val() == 'yes') {
                jQuery('.cbdb-' + fieldName + '-switch').removeClass('cbdb-d-none');
            } else {
                jQuery('.cbdb-' + fieldName + '-switch').addClass('cbdb-d-none');
            }
        });
    }

    // Integrate WP code editor to textarea custom css
    if (jQuery('#cbdb-custom-css').length) {
        if (typeof (wp.codeEditor) != "undefined" && wp.codeEditor !== null) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {};
            editorSettings.codemirror = _.extend(
                    {},
                    editorSettings.codemirror,
                    {
                        indentUnit: 2,
                        tabSize: 2,
                        mode: 'css',
                    }
            );
            var editor = wp.codeEditor.initialize(jQuery('#cbdb-custom-css'), editorSettings);
        }
    }

    // Get relevant layouts list
    if (jQuery('#cbdb-layout-type').length) {
        jQuery('#cbdb-layout-type').on('change', function () {
            layoutType = jQuery(this).val().trim();
            jQuery('#cbdb-layout-type_label').val(layoutType);
            jQuery.ajax({
                type: 'POST',
                url: admin_ajax_object.ajaxurl,
                dataType: 'json',
                data: {
                    layout_type: layoutType,
                    action: 'get_layout_list'
                },
                success: function (response) {
                    jQuery('#cbdb-layout-preview').html('').html(response.optionsHTML);
                    jQuery('.cbdb-section-layout').next('.select-styled').remove();
                    jQuery('.cbdb-section-layout').next().next('.select-options').remove();
                    window.parent.styledSelectBox();
                    layoutPreview = jQuery('select[name^="cbdb_layout_preview"]').find(":selected").val();
                    jQuery('.cbdb-layout-screenshots').html('').html(`<img class="cbdb-blog-image" src="${admin_ajax_object.pluginurl}admin/assets/images/layouts/${layoutType}/${layoutPreview}.jpg" alt="${layoutType}-${layoutPreview}">`);
                }
            });
        });
    }

    function isNumeric(str) {
        if (typeof str != "string")
            return false; // we only process strings!  
        return !isNaN(str) && // use type coercion to parse the _entirety_ of the string (`parseFloat` alone does not do this)...
                !isNaN(parseFloat(str)); // ...and ensure strings of whitespace fail
    }

    // Function to get parameter from URL by name
    function getParamByName(name) {
        var regexS = "[\\?&]" + name + "=([^&#]*)",
                regex = new RegExp(regexS),
                results = regex.exec(window.location.search);
        if (results == null) {
            return "";
        } else {
            return decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    }

    // Function to remove parameter from URL
    function removeParam(parameter) {
        var url = document.location.href;
        var urlparts = url.split('?');
        if (urlparts.length >= 2) {
            var urlBase = urlparts.shift();
            var queryString = urlparts.join("?");
            var prefix = encodeURIComponent(parameter) + '=';
            var pars = queryString.split(/[&;]/g);
            for (var i = pars.length; i-- > 0; )
                if (pars[i].lastIndexOf(prefix, 0) !== -1)
                    pars.splice(i, 1);
            url = urlBase + '?' + pars.join('&');
            window.history.pushState('', document.title, url); // added this line to push the new url directly to url bar .
        }
        return url;
    }

    setTimeout(function () {
        removeParam("layout");
        removeParam("tab");
    }, 500);

    // Remove update notice after 5 seconds
    if (jQuery('.cbdb-notice').length) {
        jQuery('.cbdb-notice').delay(5000).fadeOut();
    }

    // Function to load styles select box
    window.styledSelectBox = function () {
        jQuery(".cbdb-section-layout").each(function () {
            var $this = jQuery(this), numberOfOptions = jQuery(this).children("option").length, selectedOptionText, selectedOptionVal,
                    $layoutPreview, $layoutType, $postType, $postCat, $mediaSize, $paginationType;
            $this.addClass("select-hidden");
            if (!$this.parent().hasClass('select')) {
                $this.wrap('<div class="select"></div>');
            }
            $this.after('<div class="select-styled"></div>');
            var $styledSelect = $this.next("div.select-styled");
            $styledSelect.text($this.children("option").eq(0).text());
            var $list = jQuery("<ul />", {
                class: "select-options " + jQuery(this).attr('id')
            }).insertAfter($styledSelect);
            for (var i = 0; i < numberOfOptions; i++) {
                jQuery("<li />", {
                    text: $this.children("option").eq(i).text(),
                    class: $this.children("option").eq(i).val()
                }).appendTo($list);
            }
            var $listItems = $list.children("li");
            $styledSelect.click(function (e) {
                e.stopPropagation();
                jQuery("div.select-styled.active").not(this).each(function () {
                    jQuery(this).removeClass("active").next("ul.select-options").hide();
                });
                jQuery(this).toggleClass("active").next("ul.select-options").toggle();
            });
            $listItems.on('click', function (e) {
                e.stopPropagation();
                $styledSelect.text(jQuery(this).text()).removeClass("active");
                $this.val(jQuery(this).attr('rel'));
                $list.hide();
                $this.val(jQuery(this).attr("class"));
                var $style_class = jQuery(this).attr("class");
                var selectClass, classStr = '';
                var classArr = [];
                selectClass = jQuery(this).parent().prev().attr('class');
                classArr = selectClass.split(' ');
                if (classArr.length == 1) {
                    jQuery(this).parent().prev().addClass($style_class);
                } else {
                    classArr.pop();
                    classArr.push($style_class);
                    classStr = classArr.join(' ');
                    jQuery(this).parent().prev().removeClass();
                    jQuery(this).parent().prev().addClass(classStr);
                }
                jQuery('select[name^="cbdb_layout_type"] option').removeAttr('selected');
                jQuery('select[name^="cbdb_layout_type"] option[value="' + $style_class + '"]').attr('selected', 'selected');
                // Layout preview screenshots
                if (jQuery(this).parent().hasClass('cbdb-layout-preview')) {
                    $layoutType = jQuery('#cbdb-layout-type_label').val();
                    $layoutPreview = jQuery(this).attr('class');
                    $layoutPreview = $layoutPreview.split(' ');
                    jQuery('#cbdb-layout-preview_label').val($layoutPreview[0]).attr("selected", "selected");
                    jQuery('.cbdb-layout-screenshots').html('').html(`<img class="cbdb-blog-image" src="${admin_ajax_object.pluginurl}admin/assets/images/layouts/${$layoutType}/${$layoutPreview[0]}.jpg" alt="${$layoutType}-${$layoutPreview[0]}">`);
                }

                // Get related terms list from post type
                if (jQuery(this).parent().hasClass('cbdb-post-type')) {
                    $postType = jQuery(this).attr('class');
                    get_tax_list($postType);
                }

                // Hide/show custom size options
                if (jQuery(this).parent().hasClass('cbdb-post-media-size')) {
                    $mediaSize = jQuery(this).attr('class');
                    if ($mediaSize == 'custom') {
                        jQuery('.cbdb-add-custom-size-wrapper').removeClass('cbdb-d-none');
                    } else {
                        jQuery('.cbdb-add-custom-size-wrapper').addClass('cbdb-d-none');
                    }
                }

                // Pagination preview screenshots
                if (jQuery(this).parent().hasClass('cbdb-pagination-preview')) {
                    $paginationType = jQuery(this).attr('class');
                    jQuery('.cbdb-pagination-screenshots').html('').html(`<img class="cbdb-blog-image" src="${admin_ajax_object.pluginurl}admin/assets/images/pagination/pagination-${$paginationType}.jpg" alt="${$paginationType}">`);
                }
            });
            jQuery('#cbdb-layout-type').next('div.select-styled').addClass('choose-layout');
            jQuery(document).click(function () {
                $styledSelect.removeClass("active");
                $list.hide();
            });
            // Get selected option and set it
            selectedOptionText = jQuery(this).find(":selected").text();
            jQuery(this).next('.select-styled').text(selectedOptionText);
            selectedOptionVal = jQuery('select[name^="cbdb_layout_preview"]').find(":selected").val();
            jQuery('select[name^="cbdb_layout_preview"]').next().next().find('li.' + selectedOptionVal).addClass('selected');
        });
    }

    // Function to get relevant terms list from post type
    function get_tax_list(postType = '') {
        if (postType) {
            jQuery.ajax({
                type: 'POST',
                url: admin_ajax_object.ajaxurl,
                dataType: 'json',
                data: {
                    post_type: postType,
                    action: 'get_tax_list'
                },
                success: function (response) {
                    if (response.trim() != '') {
                        jQuery('#cbdb-post-categories').html('').html(response.catHTML);
                        jQuery('#cbdb-post-tags').html('').html(response.tagHTML);
                    }
                }
            });
    }
    }

    /*function isNumberKey(evt) {
     var charCode = (evt.which) ? evt.which : evt.keyCode;
     if (charCode > 31 && charCode > 46 && (charCode < 36 || charCode > 41) && (charCode < 48 || charCode > 57)) {
     return false;
     } else {
     return true;
     }
     }*/

    // Load styled select box
    window.parent.styledSelectBox();
});

// For layout type icon dropdown only
(function ($) {
    $.fn.fSelectDropdown = function (options) {
        return this.each(function () {
            var $this = $(this);

            $this.each(function () {
                var dropdown = $("<div />").addClass("f-dropdown selectDropdown");

                if ($(this).is(":disabled"))
                    dropdown.addClass("disabled");

                $(this).wrap(dropdown);

                var label = $("<span />").append($("<span />").text($(this).attr("placeholder"))).insertAfter($(this));
                var list = $("<ul />");

                $(this).find("option").each(function () {
                    var image = $(this).data("image");
                    if (image) {
                        list.append($("<li />").append($("<a />").attr("data-val", $(this).val()).html($("<span />").append($(this).text())).prepend('<img src="' + image + '">')));
                    } else if ($(this).val() != "") {
                        list.append($("<li />").append($("<a />").attr("data-val", $(this).val()).html($("<span />").append($(this).text()))));
                    }
                });

                list.insertAfter($(this));

                if ($(this).find("option:selected").length > 0 && $(this).find("option:selected").val() != "") {
                    list.find('li a[data-val="' + $(this).find("option:selected").val() + '"]').parent().addClass("active");
                    $(this).parent().addClass("filled");
                    label.html(list.find("li.active a").html());
                }
            });

            if (!$(this).is(":disabled")) {
                $(this).parent().on("click", "ul li", function (e) {
                    e.preventDefault();
                    var dropdown = $(this).parent().parent();
                    var active = $(this).hasClass("active");
                    var label = $(this).children("a").html();
                    dropdown.find("ul li").removeClass("active");
                    dropdown.find("option").prop("selected", false);
                    dropdown.find('option[value="' + $(this).children("a").attr("data-val") + '"]').prop("selected", true);
                    $(this).addClass("active");
                    dropdown.addClass("filled");
                    dropdown.children("span").html(label);
                    dropdown.removeClass("open");

                    // Change layout preview dropdown
                    var layoutType, layoutPreview;
                    layoutType = $(this).children("a").text().toLowerCase().trim();
                    $('#cbdb-layout-type_label').val(layoutType);
                    // Hide/show layout gap field according to relevant layout type
                    if (layoutType == 'list') {
                        $('.cbdb-row-wrapper').removeClass('cbdb-d-none');
                        $('.cbdb-grid-wrapper').addClass('cbdb-d-none');
                    } else if (layoutType == 'masonry') {
                        $('.cbdb-grid-wrapper').removeClass('cbdb-d-none');
                        $('.cbdb-row-wrapper').addClass('cbdb-d-none');
                    } else if (layoutType == 'grid') {
                        $('.cbdb-grid-wrapper, .cbdb-row-wrapper').removeClass('cbdb-d-none');
                    }
                    $.ajax({
                        type: 'POST',
                        url: admin_ajax_object.ajaxurl,
                        dataType: 'json',
                        data: {
                            layout_type: layoutType,
                            action: 'get_layout_list'
                        },
                        success: function (response) {
                            $('#cbdb-layout-preview').html('').html(response.optionsHTML);
                            $('.cbdb-section-layout').next('.select-styled').remove();
                            $('.cbdb-section-layout').next().next('.select-options').remove();
                            window.parent.styledSelectBox();
                            layoutPreview = $('select[name^="cbdb_layout_preview"]').find(":selected").val();
                            $('.cbdb-layout-screenshots').html('').html(`<img class="cbdb-blog-image" src="${admin_ajax_object.pluginurl}admin/assets/images/layouts/${layoutType}/${layoutPreview}.jpg" alt="${layoutType}-${layoutPreview}">`);
                        }
                    });
                });

                $this.parent().on("click", "> span", function (e) {
                    var self = $(this).parent();
                    self.toggleClass("open");
                });

                $(document).on("click touchstart", function (e) {
                    var dropdown = $this.parent();
                    if (dropdown !== e.target && !dropdown.has(e.target).length) {
                        dropdown.removeClass("open");
                    }
                });
            }
        });
    };
})(jQuery);