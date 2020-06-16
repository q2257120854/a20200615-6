function t(t) {
    for (var e = {}, r = t.split(","), a = 0; a < r.length; a++) e[r[a]] = !0;
    return e;
}

var e = /^<([-A-Za-z0-9_]+)((?:\s+[a-zA-Z_:][-a-zA-Z0-9_:.]*(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/, r = /^<\/([-A-Za-z0-9_]+)[^>]*>/, a = /([a-zA-Z_:][-a-zA-Z0-9_:.]*)(?:\s*=\s*(?:(?:"((?:\\.|[^"])*)")|(?:'((?:\\.|[^'])*)')|([^>\s]+)))?/g, i = t("area,base,basefont,br,col,frame,hr,img,input,link,meta,param,embed,command,keygen,source,track,wbr"), n = t("a,address,article,applet,aside,audio,blockquote,button,canvas,center,dd,del,dir,div,dl,dt,fieldset,figcaption,figure,footer,form,frameset,h1,h2,h3,h4,h5,h6,header,hgroup,hr,iframe,ins,isindex,li,map,menu,noframes,noscript,object,ol,output,p,pre,section,script,table,tbody,td,tfoot,th,thead,tr,ul,video"), s = t("abbr,acronym,applet,b,basefont,bdo,big,br,button,cite,code,del,dfn,em,font,i,iframe,img,input,ins,kbd,label,map,object,q,s,samp,script,select,small,span,strike,strong,sub,sup,textarea,tt,u,var"), o = t("colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr"), l = t("checked,compact,declare,defer,disabled,ismap,multiple,nohref,noresize,noshade,nowrap,readonly,selected"), c = t("script,style"), h = {};

h.html2json = function(t) {
    var h = [], d = {
        node: "root",
        child: []
    };
    return function(t, h) {
        function d(t, e) {
            if (e) for (r = m.length - 1; r >= 0 && m[r] != e; r--) ; else var r = 0;
            if (r >= 0) {
                for (var a = m.length - 1; a >= r; a--) h.end && h.end(m[a]);
                m.length = r;
            }
        }
        var u, f, p, m = [], g = t;
        for (m.last = function() {
            return this[this.length - 1];
        }; t; ) {
            if (f = !0, m.last() && c[m.last()]) t = t.replace(new RegExp("([\\s\\S]*?)</" + m.last() + "[^>]*>"), function(t, e) {
                return e = e.replace(/<!--([\s\S]*?)-->|<!\[CDATA\[([\s\S]*?)]]>/g, "$1$2"), h.chars && h.chars(e), 
                "";
            }), d(0, m.last()); else if (0 == t.indexOf("\x3c!--") ? (u = t.indexOf("--\x3e")) >= 0 && (h.comment && h.comment(t.substring(4, u)), 
            t = t.substring(u + 3), f = !1) : 0 == t.indexOf("</") ? (p = t.match(r)) && (t = t.substring(p[0].length), 
            p[0].replace(r, d), f = !1) : 0 == t.indexOf("<") && (p = t.match(e)) && (t = t.substring(p[0].length), 
            p[0].replace(e, function(t, e, r, c) {
                if (e = e.toLowerCase(), n[e]) for (;m.last() && s[m.last()]; ) d(0, m.last());
                if (o[e] && m.last() == e && d(0, e), (c = i[e] || !!c) || m.push(e), h.start) {
                    var u = [];
                    r.replace(a, function(t, e) {
                        var r = arguments[2] ? arguments[2] : arguments[3] ? arguments[3] : arguments[4] ? arguments[4] : l[e] ? e : "";
                        u.push({
                            name: e,
                            value: r,
                            escaped: r.replace(/(^|[^\\])"/g, '$1\\"')
                        });
                    }), h.start && h.start(e, u, c);
                }
            }), f = !1), f) {
                var v = (u = t.indexOf("<")) < 0 ? t : t.substring(0, u);
                t = u < 0 ? "" : t.substring(u), h.chars && h.chars(v);
            }
            if (t == g) throw "Parse Error: " + t;
            g = t;
        }
        d();
    }(t = t.replace(/<\?xml.*\?>\n/, "").replace(/<!doctype.*\>\n/, "").replace(/<!DOCTYPE.*\>\n/, ""), {
        start: function(t, e, r) {
            var a = {
                node: "element",
                tag: t
            };
            if (0 !== e.length && (a.attr = e.reduce(function(t, e) {
                var r = e.name, a = e.value;
                return a.match(/ /) && (a = a.split(" ")), t[r] ? Array.isArray(t[r]) ? t[r].push(a) : t[r] = [ t[r], a ] : t[r] = a, 
                t;
            }, {})), r) {
                var i = h[0] || d;
                void 0 === i.child && (i.child = []), i.child.push(a);
            } else h.unshift(a);
        },
        end: function(t) {
            var e = h.shift();
            if (e.tag !== t && console.error("invalid state: mismatch end tag"), 0 === h.length) d.child.push(e); else {
                var r = h[0];
                void 0 === r.child && (r.child = []), r.child.push(e);
            }
        },
        chars: function(t) {
            var e = {
                node: "text",
                text: t
            };
            if (0 === h.length) d.child.push(e); else {
                var r = h[0];
                void 0 === r.child && (r.child = []), r.child.push(e);
            }
        },
        comment: function(t) {
            var e = {
                node: "comment",
                text: t
            }, r = h[0];
            void 0 === r.child && (r.child = []), r.child.push(e);
        }
    }), d;
}, h.json2html = function t(e) {
    var r = "";
    e.child && (r = e.child.map(function(e) {
        return t(e);
    }).join(""));
    var a = "";
    if (e.attr && "" !== (a = Object.keys(e.attr).map(function(t) {
        var r = e.attr[t];
        return Array.isArray(r) && (r = r.join(" ")), t + '="' + r + '"';
    }).join(" ")) && (a = " " + a), "element" === e.node) {
        var i = e.tag;
        return [ "area", "base", "basefont", "br", "col", "frame", "hr", "img", "input", "isindex", "link", "meta", "param", "embed" ].indexOf(i) > -1 ? "<" + e.tag + a + "/>" : "<" + e.tag + a + ">" + r + "</" + e.tag + ">";
    }
    return "text" === e.node ? e.text : "comment" === e.node ? "\x3c!--" + e.text + "--\x3e" : "root" === e.node ? r : void 0;
};

var d = function(t) {
    for (var e = [], r = [], a = 0, i = t.length; a < i; a++) if (0 == a) {
        if ("view" == t[a].type) continue;
        e.push(t[a]);
    } else if ("view" == t[a].type) {
        if (e.length > 0) {
            var n = {
                type: "view",
                child: e
            };
            r.push(n);
        }
        e = [];
    } else if ("img" == t[a].type) {
        e.length > 0 && (n = {
            type: "view",
            child: e
        }, r.push(n));
        var s = t[a].attr;
        t[a].attr.width && -1 === t[a].attr.width.indexOf("%") && -1 === t[a].attr.width.indexOf("px") && (t[a].attr.width = t[a].attr.width + "px"), 
        t[a].attr.height && -1 === t[a].attr.height.indexOf("%") && -1 === t[a].attr.height.indexOf("px") && (t[a].attr.height = t[a].attr.height + "px"), 
        n = {
            type: "img",
            attr: s
        }, r.push(n), e = [];
    } else e.push(t[a]), a == i - 1 && (n = {
        type: "view",
        child: e
    }, r.push(n));
    return r;
}, u = function(t) {
    var e = [];
    return function t(r) {
        var a = {};
        if ("root" == r.node) ; else if ("element" == r.node) switch (r.tag) {
          case "a":
            a = {
                type: "a",
                text: r.child[0].text
            };
            break;

          case "img":
            a = {
                type: "img",
                text: r.text
            };
            break;

          case "p":
          case "div":
            a = {
                type: "view",
                text: r.text
            };
        } else "text" == r.node && (a = {
            type: "text",
            text: r.text
        });
        if (r.attr && (a.attr = r.attr), 0 != Object.keys(a).length && e.push(a), "a" != r.tag) {
            var i = r.child;
            if (i) for (var n in i) t(i[n]);
        }
    }(t), e;
};

module.exports = {
    html2json: function(t) {
        var e = h.html2json(t);
        return e = u(e), e = d(e);
    }
};