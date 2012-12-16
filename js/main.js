/*******************************************************************************

CSS on Sails Framework
Title: Pocketlistings
Author: XHTMLized (http://www.xhtmlized.com/)
Date: December 2010

*******************************************************************************/
$(document).ready(function () {
    PL.init();
});

var PL = {
    init: function () {

        //PL.inlineLogin();
        PL.preview();
        //PL.multiselectDropdown('#pocketlisting_type,#property_type');
        PL.cufon();
        PL.validation();
        PL.placeholders();
        PL.tabs();
        PL.contactInfo();
        PL.flagModal();
        PL.sliders();
        PL.pageLink();
        PL.autocomplete([
			{ id: '#city_state', source: '/_ui/js/city_state.txt' }
        //,{ id: '#locationHeaderField', source: '/_ui/js/city_state.txt' } 
        //{ id: '#neighborhood-comp', source: 'city_state.txt' }
		]);
    },

    /*
    * Cufon text replacement
    */
    cufon: function () {
        Cufon.replace('.site-name .bold, .company-info .bold, .fn .bold', { fontWeight: 'bold' });
        Cufon.replace('.site-name .light, .company-info .light, .fn .light', { fontWeight: 'normal' });
    },

    /*
    * Forms validation
    */
    validation: function () {
        /* Defaults */
        $.validator.setDefaults({
            errorPlacement: function (error, element) {
                error.insertBefore(element);
            }
        });

        /* Signup form */
        $('#form-signup').validate({
            rules: {
                password_confirm: {
                    equalTo: "#password"
                }
            },
            messages: {
                full_name: "Please provide your name."
            },
            submitHandler: function (form) {
                $(form).find('.submit-field .loading').show();
                form.submit();
                //AJAX submit?
                //$(form).find('.submit-field .loading').hide();
            }
        });

        /* Contact form */
        $('#form-contact').validate();

        /* Newsletter form */
        $('#form-newsletter').validate({
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            }
        });

        //        $('#form-login').submit(function () {

        //            $('#form-login').find('.submit-field .loading').show();
        //            alert("Fernandp");
        //            $('#form-login').find('.submit-field .loading').hide();
        //            return false;
        //        }
        //         );

        //        $('#form-login').validate({
        //                alert("Fernandp");
        //                    submitHandler: function (form) {
        //                        
        //                        $('#form-login').find('.submit-field .loading').show();
        //                        form.submit();
        //                        //AJAX submit?
        //                        $('#form-login').find('.submit-field .loading').hide();
        //                    }
        //                });

        /* Flag form */
        $('#form-flag').validate();
    },

    /*
    * Very simple one-time placeholders
    */
    placeholders: function () {
        $('.placeholder').one('focus', function () {
            //$(this).val('');
        });
    },

    /*
    * Tabs
    */
    tabs: function () {
        var t = $(".tabs");
        if (t.size()) {
            t.tabs();
        }
    },

    /*
    * Slide toggle contact info
    */
    contactInfo: function () {
        $('.contact a').each(function () {
            //initialy hide destination element
            $(this).parents('.details, .listing > li').find('.contact-info').hide();
        }).click(function () {
            //alert('fernando');
            $(this).parents('.details, .listing > li').find('.contact-info').slideToggle();
            //$(this).parents('.details, .listing > li').find('.contact-info').toggle();
            return false;
        });
    },

    /*
    * Fancybox used to display flag modal
    */
    flagModal: function () {
        var a = $('.links .flag a');
        if (a.size()) {
            a.fancybox({
                onComplete: function (arr, ind, opt) {
                    $('#flag_object_id').val($(arr[ind]).attr('rel'));
                }
            });
        }
        var saveSearchBox = $('#save-search-link');
        saveSearchBox.fancybox();
    },

    /*
    * jQuery UI Range Sliders
    */
    sliders: function () {
        function parseNum(str) {
            var num = undefined;
            //assuming only dots separate numbers from fractions, so removing all other symbols
            var m = str.match(/[\d\.]+/g);
            if (m != null) {
                num = parseFloat(m.join(""));
            }
            return num;
        }
        function addCommas(nStr) {
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        $(".slider-range").slider({
            range: true,
            slide: function (event, ui) {
                var r = $(this).siblings('.range');
                var min = r.children('.min').val(addCommas(ui.values[0]));
                var max = r.children('.max').val(addCommas(ui.values[1]));
            }
        }).each(function () {
            var s = $(this);

            //get min, max and step values
            var min = s.attr('min');
            if (min != undefined) {
                s.slider("option", "min", parseNum(min));
            }
            var max = s.attr('max');
            if (max != undefined) {
                //s.slider("option", "max", addCommas(parseNum(max)));
                s.slider("option", "max", parseNum(max));
            }
            var step = s.attr('step');
            if (step != undefined) {
                s.slider("option", "step", parseNum(step));
            }

            //bind changing inputs to changing slider
            var r = s.siblings('.range');

            var lv = r.children('.min').change(function () {
                var m = s.slider("option", "min");
                var val = s.slider("option", "values");
                if ($(this).val() < m) {
                    $(this).val(m);

                } else if ($(this).val() > val[1]) {

                    $(this).val(val[1]);
                }
                s.slider("values", 0, parseNum($(this).val()));
            });

            var uv = r.children('.max').change(function () {
                var m = s.slider("option", "max");
                var val = s.slider("option", "values");
                if ($(this).val() > m) {
                    $(this).val(m);

                } else if ($(this).val() < val[0]) {
                    $(this).val(val[0]);
                }
                s.slider("values", 1, parseNum($(this).val()));
            });

            //set initial slider vales to those provided in inputs
            s.slider("option", "values", [parseNum(lv.val()), parseNum(uv.val())]);
        });
    },

    /*
    * Google Maps Link-like functionality
    */
    pageLink: function () {
        var a = $('.page-link > a');
        if (a.size()) {
            a.click(function () {
                var d = $($(this).attr('href'));
                d.addClass('show');
                d.find('.close').click(function () {
                    d.removeClass("show");
                    return false;
                });
                d.find('input').focus(function () {
                    this.select();
                }).val(location.href).focus();
                return false;
            })
        }
    },

    /*
    * FCBKComplete
    * Fields is array of { id: '', source: '' } pairs
    */
    autocomplete: function (fields) {
        $(fields).each(function () {
            $(this.id).fcbkcomplete({
                json_url: this.source,
                cache: true,
                filter_case: false,
                filter_hide: true,
                filter_selected: true,
                newel: false,
                addontab: true
            });
        });
    },

    /*
    * Inline login forms
    */
    inlineLogin: function () {
        $('.details, .listing > li').find('.login-needed').each(function (ind, el) {
            var ln = $('#login-needed').clone();
            var d = $(el);
            d.html(ln);
            d.find('.login-button').click(function () {
                var il = $('#inline-login').clone();
                d.html(il).find('form').validate({
                    errorPlacement: function (error, element) {
                        il.find('.form-field:last').html(error);
                    }
                });
                return false;
            });
        });
    },

    /*
    * Preview of the post
    */
    preview: function () {
        var a = $('.preview');
        if (a.size()) {
            a.fancybox({
                href: "preview.html",
                padding: 30,
                autoScale: false,
                onComplete: function (arr, ind, opt) {
                    var d = $('.preview-form');
                    var p = $('.preview-view');
                    p.after(d);
                },
                onCleanup: function () {
                    var d = $('.preview-form');
                    var p = $('.hidden');
                    p.append(d);
                }
            });
        }
    },

    /*
    * Multiselect dropdown
    */
    multiselectDropdown: function (fields) {
        $(fields).each(function () {

            var t = $(this);
            t.attr('multiple', 'multiple');
            t.children('option:eq(0)').removeAttr('selected');

            //dropdown div
            var d = $('<div class="dropdown"></div>');
            t.children('option:gt(0)').each(function (index, el) {
                var it = $('<div class="dropdown-item"></div>');
                var id = t.attr('id') + '-' + index;

                var c = $('<input type="checkbox" id="' + id + '" value="' + $(this).attr('value') + '" />');

                c.change(function () {
                    if (c.attr('checked')) {
                        c.parent().addClass('checked');
                        t.children('option[value="' + c.val() + '"]').attr('selected', 'selected');
                    } else {
                        c.parent().removeClass('checked');
                        t.children('option[value="' + c.val() + '"]').removeAttr('selected');
                    }
                    t.change();
                });

                it.append(c);
                it.append('<label for="' + id + '">' + $(this).text() + '</label>');
                d.append(it);
            });
            d.children('.dropdown-item:odd').addClass('odd');

            //link
            var a = $('<a href="#" class="dropdown-link">[<span class="dropdown-fold">+</span>] <span class="dropdown-text"></span></a>');

            //hide dropdown when clicking outside it
            $("body").click(function (e) {
                //if target isn't a child of .dropdown and this .dropdown is shown
                if (!$(e.target).parents('.dropdown').size() && d.not(':hidden').size()) {
                    a.click();
                }
            });

            //change text on link
            t.change(function () {
                var s = t.children('option:selected').size();
                if (s) {
                    a.children('.dropdown-text').text('' + s + ' selected');
                } else {
                    a.children('.dropdown-text').text(t.children('option:eq(0)').text());
                }
            });

            //inserting into DOM
            t.hide();
            t.change();
            d.hide();
            t.after(a);
            a.after(d);
        });

        $('.dropdown-item').hover(function () {
            $(this).addClass('hover');
        }, function () {
            $(this).removeClass('hover');
        });

        $('.dropdown-link').toggle(function () {
            $(this).children('.dropdown-fold').text('-');
            $(this).siblings('.dropdown').show();
            return false;
        }, function () {
            $(this).children('.dropdown-fold').text('+');
            $(this).siblings('.dropdown').hide();
            return false;
        });
    }
}