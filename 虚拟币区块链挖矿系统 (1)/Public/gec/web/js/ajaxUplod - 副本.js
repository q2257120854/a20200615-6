(function () {
    var d = document,
        w = window;

    function get(element) {
        if (typeof element == "string") element = d.getElementById(element);
        return element;
    }

    function addEvent(el, type, fn) {
        if (w.addEventListener) {
            el.addEventListener(type, fn, false);
        } else if (w.attachEvent) {
            var f = function () {
                fn.call(el, w.event);
            };
            el.attachEvent("on" + type, f);
        }
    }

    var toElement = function () {
        var div = d.createElement("div");
        return function (html) {
            div.innerHTML = html;
            var el = div.childNodes[0];
            div.removeChild(el);
            return el;
        };
    }();

    if (document.documentElement["getBoundingClientRect"]) {
        // Get Offset using getBoundingClientRect
        // http://ejohn.org/blog/getboundingclientrect-is-awesome/
        var getOffset = function (el) {
            var box = el.getBoundingClientRect(),
                doc = el.ownerDocument,
                body = doc.body,
                docElem = doc.documentElement, // for ie 
                clientTop = docElem.clientTop || body.clientTop || 0,
                clientLeft = docElem.clientLeft || body.clientLeft || 0, // In Internet Explorer 7 getBoundingClientRect property is treated as physical,
                // while others are logical. Make all logical, like in IE8.
                zoom = 1;
            if (body.getBoundingClientRect) {
                var bound = body.getBoundingClientRect();
                zoom = (bound.right - bound.left) / body.clientWidth;
            }
            if (zoom > 1) {
                clientTop = 0;
                clientLeft = 0;
            }
            var top = box.top / zoom + (window.pageYOffset || docElem && docElem.scrollTop / zoom || body.scrollTop / zoom) - clientTop,
                left = box.left / zoom + (window.pageXOffset || docElem && docElem.scrollLeft / zoom || body.scrollLeft / zoom) - clientLeft;
            return {
                "top": top,
                "left": left
            };
        };
    } else {
        // Get offset adding all offsets 
        var getOffset = function (el) {
            if (w.jQuery) {
                return jQuery(el).offset();
            }
            var top = 0,
                left = 0;
            do {
                top += el.offsetTop || 0;
                left += el.offsetLeft || 0;
            } while (el = el.offsetParent);
            return {
                "left": left,
                "top": top
            };
        };
    }

    function getBox(el) {
        var left, right, top, bottom;
        var offset = getOffset(el);
        left = offset.left;
        top = offset.top;
        right = left + el.offsetWidth;
        bottom = top + el.offsetHeight;
        return {
            "left": left,
            "right": right,
            "top": top,
            "bottom": bottom
        };
    }

    function getMouseCoords(e) {
        if (!e.pageX && e.clientX) {
            var zoom = 1;
            var body = document.body;
            if (body.getBoundingClientRect) {
                var bound = body.getBoundingClientRect();
                zoom = (bound.right - bound.left) / body.clientWidth;
            }
            return {
                "x": e.clientX / zoom + d.body.scrollLeft + d.documentElement.scrollLeft,
                "y": e.clientY / zoom + d.body.scrollTop + d.documentElement.scrollTop
            };
        }
        return {
            "x": e.pageX,
            "y": e.pageY
        };
    }

    var getUID = function () {
        var id = 0;
        return function () {
            return "ValumsAjaxUpload" + id++;
        };
    }();

    function fileFromPath(file) {
        return file.replace(/.*(\/|\\)/, "");
    }

    function getExt(file) {
        return /[.]/.exec(file) ? /[^.]+$/.exec(file.toLowerCase()) : "";
    }
 
    Ajax_upload = AjaxUpload = function (button, options) {
        if (button.jquery) {
            // jquery object was passed
            button = button[0];
        } else if (typeof button == "string" && /^#.*/.test(button)) {
            button = button.slice(1);
        }
        button = get(button);
        this._button_id = $(button).attr("id") + "_file";
        this._input = null;
        this._button = button;
        this._disabled = false;
        this._submitting = false;
        // Variable changes to true if the button was clicked
        // 3 seconds ago (requred to fix Safari on Mac error)
        this._justClicked = false;
        this._parentDialog = d.body;
        if (window.jQuery && jQuery.ui && jQuery.ui.dialog) {
            var parentDialog = jQuery(this._button).parents(".ui-dialog");
            if (parentDialog.length) {
                this._parentDialog = parentDialog[0];
            }
        }
        this._settings = {
            // Location of the server-side upload script
            "action": "upload.php",
            // File upload name
            "name": "userfile",
            // Additional data to send
            "data": {},
            // Submit file as soon as it's selected
            "autoSubmit": true,
            // The type of data that you're expecting back from the server.
            // Html and xml are detected automatically.
            // Only useful when you are using json data as a response.
            // Set to "json" in that case. 
            "responseType": false,
            // When user selects a file, useful with autoSubmit disabled
            "onChange": function (file, extension, id) {},
                // Callback to fire before file is uploaded
                // You can return false to cancel upload
                "onSubmit": function (file, extension, id) {},
                // Fired when file upload is completed
                // WARNING! DO NOT USE "FALSE" STRING AS A RESPONSE!
                "onComplete": function (file, response, id) {}
        };
        // Merge the users options with our defaults
        for (var i in options) {
            this._settings[i] = options[i];
        }
        this._createInput();
        this._rerouteClicks();
    };
    // assigning methods to our class
    AjaxUpload.prototype = {
        "setData": function (data) {
                this._settings.data = data;
            },
            "disable": function () {
                this._disabled = true;
            },
            "enable": function () {
                this._disabled = false;
            },
            // removes ajaxupload
            "destroy": function () {
                if (this._input) {
                    if (this._input.parentNode) {
                        this._input.parentNode.removeChild(this._input);
                    }
                    this._input = null;
                }
            },
            /**
             * Creates invisible file input above the button
             */
            "_createInput": function () {
                var self = this;
                var input = d.createElement("input");
                input.setAttribute("type", "file");
                //input.setAttribute("multiple", "multiple");
                input.setAttribute("name", this._settings.name);
                input.setAttribute("id", this._button_id);
                var styles = {
                    "position": "absolute",
                    "margin": "-5px 0 0 -175px",
                    "padding": 0,
                    "width": "220px",
                    "height": "30px",
                    "fontSize": "14px",
                    "opacity": 0,
                    "cursor": "pointer",
                    "display": "none",
                    "zIndex": 2147483583
                };
                for (var i in styles) {
                    input.style[i] = styles[i];
                }
                // Make sure that element opacity exists
                // (IE uses filter instead)
                if (!(input.style.opacity === "0")) {
                    input.style.filter = "alpha(opacity=0)";
                }
                this._parentDialog.appendChild(input);
                addEvent(input, "change", function () {
                    // get filename from input
                    var id = getUID();
                    var file = fileFromPath(this.value);
                    if (self._settings.onChange.call(self, file, getExt(file), id) == false) {
                        return;
                    }
                    // Submit form when value is changed
                    if (self._settings.autoSubmit) {
                        self.submit(id);
                    }
                });
                // Fixing problem with Safari
                // The problem is that if you leave input before the file select dialog opens
                // it does not upload the file.
                // As dialog opens slowly (it is a sheet dialog which takes some time to open)
                // there is some time while you can leave the button.
                // So we should not change display to none immediately
                addEvent(input, "click", function () {
                    self.justClicked = true;
                    setTimeout(function () {
                        // we will wait 3 seconds for dialog to open
                        self.justClicked = false;
                    }, 3e3);
                });
                this._input = input;
            },
            "_rerouteClicks": function () {
                var self = this;
                // IE displays 'access denied' error when using this method
                // other browsers just ignore click()
                // addEvent(this._button, 'click', function(e){
                //   self._input.click();
                // });
                var box, dialogOffset = {
                        "top": 0,
                        "left": 0
                    },
                    over = false;
                addEvent(self._button, "mouseover", function (e) {
                    if (!self._input || over) return;
                    over = true;
                    box = getBox(self._button);
                    if (self._parentDialog != d.body) {
                        dialogOffset = getOffset(self._parentDialog);
                    }
                });
                // we can't use mouseout on the button,
                // because invisible input is over it
                addEvent(document, "mousemove", function (e) {
                    var input = self._input;
                    if (!input || !over) return;
                    if (self._disabled) {
                        removeClass(self._button, "hover");
                        input.style.display = "none";
                        return;
                    }
                    var c = getMouseCoords(e);
                    if (c.x >= box.left && c.x <= box.right && c.y >= box.top && c.y <= box.bottom) {
                        input.style.top = c.y - dialogOffset.top + "px";
                        input.style.left = c.x - dialogOffset.left + "px";
                        input.style.display = "block";
                    } else {
                        // mouse left the button
                        over = false;
                        if (!self.justClicked) {
                            input.style.display = "none";
                        }
                    }
                });
            },
            /**
             * Creates iframe with unique name
             */
            "_createIframe": function (id) {
                var iframe = toElement('<iframe src="javascript:false;" name="' + id + '" />');
                iframe.id = id;
                iframe.style.display = "none";
                d.body.appendChild(iframe);
                return iframe;
            },
 
            "submit": function (id) {
                var self = this,
                    settings = this._settings;
                if (this._input.value === "") {
                    // there is no file
                    return;
                }
                // get filename from input
                var file = fileFromPath(this._input.value);
                // execute user event
                if (!(settings.onSubmit.call(this, file, getExt(file), id) == false)) {
                    // Create new iframe for this submission
                    var iframe = this._createIframe(id);
                    // Do not submit if user function returns false
                    var form = this._createForm(iframe);
                    form.appendChild(this._input);
                    form.submit();
                    d.body.removeChild(form);
                    form = null;
                    this._input = null;
                    // create new input
                    this._createInput();
                    var toDeleteFlag = false;
                    addEvent(iframe, "load", function (e) {
                        if ( // For Safari
                            iframe.src == "javascript:'%3Chtml%3E%3C/html%3E';" || // For FF, IE
                            iframe.src == "javascript:'<html></html>';") {
                            // First time around, do not delete.
                            if (toDeleteFlag) {
                                // Fix busy state in FF3
                                setTimeout(function () {
                                    d.body.removeChild(iframe);
                                }, 0);
                            }
                            return;
                        }
                        var doc = iframe.contentDocument ? iframe.contentDocument : frames[iframe.id].document;
                        // fixing Opera 9.26
                        if (doc.readyState && doc.readyState != "complete") {
                            // Opera fires load event multiple times
                            // Even when the DOM is not ready yet
                            // this fix should not affect other browsers
                            return;
                        }
                        // fixing Opera 9.64
                        if (doc.body && doc.body.innerHTML == "false") {
                            // In Opera 9.64 event was fired second time
                            // when body.innerHTML changed from false 
                            // to server response approx. after 1 sec
                            return;
                        }
                        var response;
                        if (doc.XMLDocument) {
                            // response is a xml document IE property
                            response = doc.XMLDocument;
                        } else if (doc.body) {
                            // response is html document or plain text
                            response = doc.body.innerHTML;
                            if (settings.responseType && settings.responseType.toLowerCase() == "json") {
                                // If the document was sent as 'application/javascript' or
                                // 'text/javascript', then the browser wraps the text in a <pre>
                                // tag and performs html encoding on the contents.  In this case,
                                // we need to pull the original text content from the text node's
                                // nodeValue property to retrieve the unmangled content.
                                // Note that IE6 only understands text/html
                                if (doc.body.firstChild && doc.body.firstChild.nodeName.toUpperCase() == "PRE") {
                                    response = doc.body.firstChild.firstChild.nodeValue;
                                }
                                if (response) {
                                    response = window["eval"]("(" + response + ")");
                                } else {
                                    response = {};
                                }
                            }
                        } else {
                            // response is a xml document
                            var response = doc;
                        }
                        settings.onComplete.call(self, file, response, id);
                        // Reload blank page, so that reloading main page
                        // does not re-submit the post. Also, remember to
                        // delete the frame
                        toDeleteFlag = true;
                        // Fix IE mixed content issue
                        iframe.src = "javascript:'<html></html>';";
                    });
                } else {
                    // clear input to allow user to select same file
                    // Doesn't work in IE6
                    // this._input.value = '';
                    d.body.removeChild(this._input);
                    this._input = null;
                    // create new input
                    this._createInput();
                }
            },
            /**
             * Creates form, that will be submitted to iframe
             */
            "_createForm": function (iframe) {
                var settings = this._settings;
                // method, enctype must be specified here
                // because changing this attr on the fly is not allowed in IE 6/7
                var form = toElement('<form method="post" enctype="multipart/form-data"></form>');
                form.style.display = "none";
                form.action = settings.action;
                form.target = iframe.name;
                d.body.appendChild(form);
                // Create hidden input element for each data key
                for (var prop in settings.data) {
                    var el = d.createElement("input");
                    el.type = "hidden";
                    el.name = prop;
                    el.value = settings.data[prop];
                    form.appendChild(el);
                }
                return form;
            }
    };
})();

(function (window, document, $, undefined) {
    var H = $("html"),
        W = $(window),
        D = $(document),
        F = $.fancybox = function () {
            F.open.apply(this, arguments);
        },
        IE = navigator.userAgent.match(/msie/i),
        didUpdate = null,
        isTouch = document.createTouch !== undefined,


        getValue = function (value, dim) {
            return getScalar(value, dim) + 'px';
        };
    $.extend(F, {
        // The current version of fancyBox
        version: '2.1.5',

        defaults: {
            padding: 15,
            margin: 20,

            width: 800,
            height: 600,
            minWidth: 100,
            minHeight: 100,
            maxWidth: 9999,
            maxHeight: 9999,
            pixelRatio: 1, // Set to 2 for retina display support

            autoSize: true,
            autoHeight: false,
            autoWidth: false,

            autoResize: true,
            autoCenter: !isTouch,
            fitToView: true,
            aspectRatio: false,
            topRatio: 0.5,
            leftRatio: 0.5,

            scrolling: 'auto', // 'auto', 'yes' or 'no'
            wrapCSS: '',

            arrows: true,
            closeBtn: true,
            closeClick: false,
            nextClick: false,
            mouseWheel: true,
            autoPlay: false,
            playSpeed: 3000,
            preload: 3,
            modal: false,
            loop: true,

            ajax: {
                dataType: 'html',
                headers: {
                    'X-fancyBox': true
                }
            },
            iframe: {
                scrolling: 'auto',
                preload: true
            },
            swf: {
                wmode: 'transparent',
                allowfullscreen: 'true',
                allowscriptaccess: 'always'
            },

            keys: {
                next: {
                    13: 'left', // enter
                    34: 'up', // page down
                    39: 'left', // right arrow
                    40: 'up' // down arrow
                },
                prev: {
                    8: 'right', // backspace
                    33: 'down', // page up
                    37: 'right', // left arrow
                    38: 'down' // up arrow
                },
                close: [27], // escape key
                play: [32], // space - start/stop slideshow
                toggle: [70] // letter "f" - toggle fullscreen
            },

            direction: {
                next: 'left',
                prev: 'right'
            },

            scrollOutside: true,

            // Override some properties
            index: 0,
            type: null,
            href: null,
            content: null,
            title: null,

            // HTML templates
            tpl: {
                wrap: '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
                image: '<img class="fancybox-image" src="{href}" alt="" /><a href="{href}" target="_blank" class="red">查看原图</a>',
                iframe: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen' + (IE ? ' allowtransparency="true"' : '') + '></iframe>',
                error: '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',
                closeBtn: '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',
                next: '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
                prev: '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
            },

            // Properties for each animation type
            // Opening fancyBox
            openEffect: 'fade', // 'elastic', 'fade' or 'none'
            openSpeed: 250,
            openEasing: 'swing',
            openOpacity: true,
            openMethod: 'zoomIn',

            // Closing fancyBox
            closeEffect: 'fade', // 'elastic', 'fade' or 'none'
            closeSpeed: 250,
            closeEasing: 'swing',
            closeOpacity: true,
            closeMethod: 'zoomOut',

            // Changing next gallery item
            nextEffect: 'elastic', // 'elastic', 'fade' or 'none'
            nextSpeed: 250,
            nextEasing: 'swing',
            nextMethod: 'changeIn',

            // Changing previous gallery item
            prevEffect: 'elastic', // 'elastic', 'fade' or 'none'
            prevSpeed: 250,
            prevEasing: 'swing',
            prevMethod: 'changeOut',

            // Enable default helpers
            helpers: {
                overlay: true,
                title: true
            },

            // Callbacks
            onCancel: $.noop, // If canceling
            beforeLoad: $.noop, // Before loading
            afterLoad: $.noop, // After loading
            beforeShow: $.noop, // Before changing in current item
            afterShow: $.noop, // After opening
            beforeChange: $.noop, // Before changing gallery item
            beforeClose: $.noop, // Before closing
            afterClose: $.noop // After closing
        },

        //Current state
        group: {}, // Selected group
        opts: {}, // Group options
        previous: null, // Previous element
        coming: null, // Element being loaded
        current: null, // Currently loaded element
        isActive: false, // Is activated
        isOpen: false, // Is currently open
        isOpened: false, // Have been fully opened at least once

        wrap: null,
        skin: null,
        outer: null,
        inner: null,

        player: {
            timer: null,
            isActive: false
        },

        // Loaders
        ajaxLoad: null,
        imgPreload: null,

        // Some collections
        transitions: {},
        helpers: {}
    });
    $.fn.fancybox = function (options) {
        var index,
            that = $(this),
            selector = this.selector || '',
            run = function (e) {
                var what = $(this).blur(),
                    idx = index,
                    relType, relVal;

                if (!(e.ctrlKey || e.altKey || e.shiftKey || e.metaKey) && !what.is('.fancybox-wrap')) {
                    relType = options.groupAttr || 'data-fancybox-group';
                    relVal = what.attr(relType);

                    if (!relVal) {
                        relType = 'rel';
                        relVal = what.get(0)[relType];
                    }

                    if (relVal && relVal !== '' && relVal !== 'nofollow') {
                        what = selector.length ? $(selector) : that;
                        what = what.filter('[' + relType + '="' + relVal + '"]');
                        idx = what.index(this);
                    }

                    options.index = idx;

                    // Stop an event from bubbling if everything is fine
                    if (F.open(what, options) !== false) {
                        e.preventDefault();
                    }
                }
            };

        options = options || {};
        index = options.index || 0;

        if (!selector || options.live === false) {
            that.unbind('click.fb-start').bind('click.fb-start', run);

        } else {
            D.undelegate(selector, 'click.fb-start').delegate(selector + ":not('.fancybox-item, .fancybox-nav')", 'click.fb-start', run);
        }

        this.filter('[data-fancybox-start=1]').trigger('click');

        return this;
    };
}(window, document, jQuery));

(function ($) {
    var lqSliding_methods = {
        init: function (options) {
                var defaults = {
                        prevBtn: ".btn_prev",
                        nextBtn: ".btn_next",
                        slidingBox: "div:eq(0)",
                        slidingList: "ul:eq(0)",
                        thumbList: "div:eq(1)",
                        showNumber: $(".show_box").width()/$(".loaded").width(),
                        direction: "h", // Vertical:v, Horizontal:h
                        full: false,
                        sliding: false,
                        speed: 200
                    },
                    options = $.extend(true, defaults, options);
                return this.each(function () {
                    var $this = $(this);
                    $this.lqSliding("defaults", options);
                });
            },
            slidingTo: function (slidingTo) {
                return this.each(function () {
                    var $this = $(this);
                    data = $this.data("lqSliding");
                    data.sliding = true;
                    if (isNaN(Number(slidingTo))) {
                        if (slidingTo == "prev") {
                            slidingTo = data.current - 1;
                        } else {
                            slidingTo = data.current + 1;
                        }
                    }
                    if (slidingTo > (data.slidingSize - data.showNumber)) {
                        slidingTo = data.slidingSize - data.showNumber;
                    }
                    if (slidingTo < 0) {
                        slidingTo = 0;
                    }
                    if (slidingTo == data.current) {
                        data.sliding = false;
                        return false;
                    }
                    var leftNumber = (data.slidingSize - slidingTo);
                    data.current = slidingTo;
                    if (data.direction == 'h') {
                        data.slidingList.stop().animate({
                            marginLeft: 0 - data.slidingItemWidth * (data.slidingSize - leftNumber)
                        }, data.speed, function () {
                            data.sliding = false;
                        });
                    } else {
                        data.slidingList.stop().animate({
                            marginTop: 0 - data.slidingItemHeight * (data.slidingSize - leftNumber)
                        }, data.speed, function () {
                            data.sliding = false;
                        });
                    }
                    if (data.thumbList) {
                        data.thumbItem.removeClass("on");
                        data.thumbItem.eq(data.current).addClass("on");
                    }
                    if (leftNumber <= data.showNumber) {
                        data.nextBtn.attr('disabled', true).parent("span").addClass('disabled');
                    } else {
                        data.nextBtn.attr('disabled', false).parent("span").removeClass('disabled');
                    }
                    if (data.current == 0) {
                        data.prevBtn.attr('disabled', true).parent("span").addClass('disabled');
                    } else {
                        data.prevBtn.attr('disabled', false).parent("span").removeClass('disabled');
                    }
                });
            },
            defaults: function (options) {
                var $this = $(this),
                    data = {};
                data.prevBtn = $this.find(options.prevBtn);
                data.nextBtn = $this.find(options.nextBtn);
                data.slidingList = $this.find(options.slidingList);
                data.thumbList = $this.find(options.thumbList);
                data.thumbItem = data.thumbList.find("li");
                data.slidingBox = $this.find(options.slidingBox).length ? $this.find(options.slidingBox) : data.slidingList.parent("div");
                data.slidingBoxWidth = data.slidingBox.width();
                data.slidingBoxHeight = data.slidingBox.height();
                data.slidingItem = data.slidingList.children("li");
                data.slidingSize = data.slidingItem.size();
                data.slidingItemWidth = data.slidingItem.outerWidth(true);
                data.slidingItemHeight = data.slidingItem.outerHeight(true);
                if (options.showNumber) {
                    data.showNumber = options.showNumber;
                } else {
                    if (options.direction == "h") {
                        data.showNumber = Math.round(data.slidingBoxWidth / data.slidingItemWidth);
                    } else {
                        data.showNumber = Math.round(data.slidingBoxHeight / data.slidingItemHeight);
                    }
                }
                data.current = 0;
                data.perTime = options.full ? data.showNumber : 1;
                if (data.thumbList.length && data.thumbItem.length) {
                    data.thumbList.lqSliding($.extend({}, options, {
                        showNumber: 0,
                        full: true
                    }));
                    data.thumbItem.each(function (i) {
                        $(this).click(function () {
                            data.thumbItem.removeClass("on");
                            $(this).addClass("on");
                            $this.lqSliding("slidingTo", i);
                        });
                    });
                } else {
                    data.thumbList = false;
                }
                $this.data("lqSliding", $.extend({}, options, data));
                data.prevBtn.attr('disabled', true).parent("span").addClass('disabled');
                if (data.slidingSize <= data.showNumber) {
                    data.nextBtn.prop('disabled', true).parent("span").addClass('disabled');
                } else {
                    data.nextBtn.prop('disabled', false).parent("span").removeClass('disabled');
                }
                if (options.direction == "h") {
                    data.slidingList.width(data.slidingItemWidth * data.slidingSize);
                } else {
                    data.slidingList.height(data.slidingItemHeight * data.slidingSize);
                }
                data.prevBtn.click(function () {
                    $this.lqSliding("slidingTo", "prev");
                    if (data.thumbList) data.thumbList.lqSliding("slidingTo", "prev");
                });
                data.nextBtn.click(function () {
                    $this.lqSliding("slidingTo", "next");
                    if (data.thumbList) data.thumbList.lqSliding("slidingTo", "next");
                });
                // $.fn.mousewheel && $this.mousewheel(function (event) {
                //     if (event.deltaY > 0) {
                //         $this.lqSliding("slidingTo", "prev");
                //         if (data.thumbList) data.thumbList.lqSliding("slidingTo", "prev");
                //     } else {
                //         $this.lqSliding("slidingTo", "next");
                //         if (data.thumbList) data.thumbList.lqSliding("slidingTo", "next");
                //     }
                //     return false;
                // });
            },
            reset: function () {
                return this.each(function () {
                    var $this = $(this);
                    data = $this.data("lqSliding");
                    if (typeof data === "undefined") {
                        return false;
                    }
                    data.slidingList.removeAttr('style');
                    data.slidingItem = data.slidingList.children("li");
                    data.slidingSize = data.slidingItem.size();
                    data.current = 0;
                });
            },
            update: function () {
                return this.each(function () {
                    var $this = $(this);
                    data = $this.data("lqSliding");
                    if (typeof data === "undefined") {
                        return false;
                    }
                    data.slidingItem = data.slidingList.children("li");
                    data.slidingSize = data.slidingItem.size();
                    data.slidingItemWidth = data.slidingItem.outerWidth(true);
                    data.slidingItemHeight = data.slidingItem.outerHeight(true);
                    if (data.showNumber !== Infinity) {
                        data.showNumber = data.showNumber;
                    } else {
                        if (data.direction == "h") {
                            data.showNumber = Math.round(data.slidingBoxWidth / data.slidingItemWidth);
                        } else {
                            data.showNumber = Math.round(data.slidingBoxHeight / data.slidingItemHeight);
                        }
                    }
                    if (data.direction == "h") {
                        data.slidingList.width(data.slidingItemWidth * data.slidingSize);
                    } else {
                        data.slidingList.height(data.slidingItemHeight * data.slidingSize);
                    }
                    data.perTime = data.full ? data.showNumber : 1;
                    if (data.slidingSize <= data.showNumber) {
                        data.nextBtn.attr('disabled', true).parent("span").addClass('disabled');
                    } else {
                        data.nextBtn.attr('disabled', false).parent("span").removeClass('disabled');
                    }
                    if (data.slidingSize - data.current > data.showNumber) {
                        $this.lqSliding("slidingTo", data.slidingSize - data.showNumber);
                    } else if (data.slidingSize == data.current) {
                        if (data.current - data.showNumber > 0) {
                            $this.lqSliding("slidingTo", data.current - data.showNumber);
                        } else {
                            $this.lqSliding("slidingTo", 0);
                        }
                    }
                });
            }
    };
    $.fn.lqSliding = function (method) {
        if (lqSliding_methods[method]) {
            return lqSliding_methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === "object" || !method) {
            return lqSliding_methods.init.apply(this, arguments);
        } else {
            $.error("Method " + method + " does not exist");
        }
    };
})(jQuery);


function global(obj) {
    if (!obj) obj = $('body');
    $('.pic_show', obj).each(function () {
        $(this).lqSliding();
    });

    var imgName = "images",
        count = $(this).next("input");
    $('.upload_one', obj).each(function(){
        var upload_btn = $(this),
        button_id = $(this).attr('id'),
        name = $(this).attr('name');
        pic_box = $('#lst_' + button_id).parent().parent('.single');
        new AjaxUpload(upload_btn, {
            action: '/index.php/index/Emoney/sctp',
            name: "pic",
            data: {"action":"uploadimg", "name": name},
            onChange: function(file, extension, id) {
                upload_btn.attr('disabled', true).html('上传成功');
            },
            onComplete: function (file, response, id) {
                var data = $.parseJSON(response);
                if(data && !data.reason && data.data) {
                    upload_btn.html('图片已上传');
                    var li = $('<li><span class="del_img"></span><a href="' + data.data.path + '" class="fancybox" data-fancybox-group="'+button_id+'"><img src="' + data.data.path + '" id="' + id + '"></a><input type="hidden" value="' + data.data.path + '" name="' + name + '"></li>');
                    li.find('.del_img').bind('click', function () {
                        li.remove();
                        upload_btn.attr('disabled', false).html('上传图片');
                        return false;
                    });
                    li.find(".fancybox").fancybox();
                    $('#lst_' + button_id).html(li).attr('style', '');
                    pic_box.lqSliding("update");
                    count.attr("value", pic_box.data("lqSliding").slidingSize);
                }  else if (data && data.reason) {
                    upload_btn.attr('disabled', false).html('上传图片');
                }
            }
        });
    });
	$('.upload_img', obj).each(function () {
        var upload_btn = $(this),
            count = $(this).next("input"),
            button_id = $(this).attr('id'),
            button_name = $(this).attr('data-name') || button_id,
            name = $(this).attr('name'),
            pic_box = $('#lst_' + button_id).parent().parent('.pic_show');
        if($('#lst_'+button_id).children("li").length) {
            pic_box.show().lqSliding();
        }
        pic_box.find("img").each(function () {
            $(this).attr("data-src", $(this).attr("src")).attr("src", "").load(function () {
                $(this).parents("li").addClass("loaded");
            }).error(function (e) {
                $(this).parents("li").remove();
                pic_box.lqSliding("update");
                if (pic_box.data("lqSliding").slidingSize == 0) {
                    // pic_box.hide();
                }
            }).attr("src", $(this).attr("data-src"));
        });
        if (pic_box.data("lqSliding").slidingSize > 0) {
            pic_box.show();
            pic_box.find(".fancybox").fancybox();
        }
        count.attr("value", pic_box.data("lqSliding").slidingSize);
        pic_box.find(".del_img").click(function () {
            $(this).parents('li').remove();
            pic_box.lqSliding("update");
            if (!pic_box.data("lqSliding").slidingSize) {
                // pic_box.hide();
            }
            count.attr("value", pic_box.data("lqSliding").slidingSize);
            return false;
        });
        var imgName = "images";
        var imgtype = $(this).attr('imgtype');
        new AjaxUpload(upload_btn, {
            action: './index.php',
            name: "pic",
            data: {
                "action": "uploadimg",
                "name": name
            },
            onChange: function (file, extension, id) {
                var index = $('[name="' + button_name + '\[' + name + '\]\[\]"]:last').index();
                //console.log(index, 'hello');<input type="text" placeholder="图片名称" class="input_txt" name="'+button_name+'[name]['+id+']">
                var li = $('<li><span class="del_img"></span><a href="#" class="fancybox" data-fancybox-group="'+button_id+'"><img src="/images/loading.gif" id="'+id+'"></a><input type="hidden" name="' + name + '[]"><span class="img_loading"></span></li>');
                    li.find('.del_img').bind('click', function () {
                        li.remove();
                        pic_box.lqSliding("update");
                        count.attr("value", pic_box.data("lqSliding").slidingSize);
                        if (!pic_box.data("lqSliding").slidingSize) {
                            // pic_box.hide();
                        }
                        return false;
                    });
                    li.find(".fancybox").fancybox();
                    $('#lst_' + button_id).append(li);
                    pic_box.lqSliding("update");
                    pic_box.show();
            },
            onComplete: function (file, response, id) {
                var data = $.parseJSON(response);
                if (data && !data.reason && data.data) {
					//$(this).$(".defaultImg").remove();
                    $('#' + id).load(function () {
                        $('#' + id).parents("li").addClass("loaded");
                    }).error(function (e) {
                        $(this).parents("li").remove();
                        pic_box.lqSliding("update");
                        if (pic_box.data("lqSliding").slidingSize == 0) {
                            // pic_box.hide();
                        }
                    }).attr('src', data.data.path).parent('.fancybox').attr('href', data.data.path);
                    $('#' + id).parent("a").attr('href', data.data.path);
                    //$('[name="' + name + '\[\]"]:last').val(data.data.path);
                    $('#'+id).parent().next().val(data.data.path);
                    pic_box.lqSliding("update");
                    // 在这里把上传时间和预计办理时间显示出来。
                    var curtd = $('#'+id).parents('td').next('.curdate');
                    // var nexttd = $('#'+id).parents('td').next().next('.afterweekdate');
                    curtd.html(data.data.curdate);
                    // nexttd.html(data.data.afterweekdate);
					$(".defaultImg").remove();
                    count.attr("value", pic_box.data("lqSliding").slidingSize);
                } else if (data && data.reason) {
                    var msg = data.data && data.data.msg ? data.data.msg : (data.reason ? data.reason : "");
                    $.confirm({
                        text: $.confirm.lab[msg] || msg,
                        mode: "alert"
                    });
                    $('#' + id).parents("li").remove();
                    pic_box.lqSliding("update");
                    if (!pic_box.data("lqSliding").slidingSize) {
                        // pic_box.hide();
                    }
                    count.attr("value", pic_box.data("lqSliding").slidingSize);
                }
            }
        });
    });
}
$(function(){
    global();
})
