
(function () {
    function e(e) {
      var n = {};
      e.split("&").forEach(function (e) {
        if (!e) return;
        e = e.split("+").join(" ");
        var t = e.indexOf("=");
        var i = t > -1 ? e.substr(0, t) : e;
        var r = t > -1 ? decodeURIComponent(e.substr(t + 1)) : "";
        var o = i.indexOf("[");
        if (o == -1) n[decodeURIComponent(i)] = r;
        else {
          var a = i.indexOf("]");
          var f = decodeURIComponent(i.substring(o + 1, a));
          i = decodeURIComponent(i.substring(0, o));
          if (!n[i]) n[i] = [];
          if (!f) n[i].push(r);
          else n[i][f] = r;
        }
      });

      return n;
    }
    function n(e) {
      var n = e.offsetTop;
      var t = e;
      while (t.offsetParent && t.offsetParent != document.body) {
        t = t.offsetParent;
        n += t.offsetTop;
      }
      if (typeof e.getAttribute == "function") {
        var i = parseInt(e.getAttribute("data-offset-top"));
        if (i) n -= i;
      }
      return n;
    }
    function t(e, n) {
      var t = document.documentElement,

        i = document.body;

      var r = (t && t.scrollLeft) || (i && i.scrollLeft) || 0;
      var o = (t && t.scrollTop) || (i && i.scrollTop) || 0;
      var a = Math.max(
        document.documentElement.clientHeight,
        window.innerHeight || 0
      );
      if (n && o < e && e < o + a) {
        return;
      }
      if (window.scrollTo != "undefined") window.scrollTo(r, e < 0 ? 0 : e);
      console.log('e');
    }
    function i(e, n, t) {
      if (e.addEventListener) e.addEventListener(n, t, false);
      else if (e.attachEvent) e.attachEvent("on" + n, t);
      console.log('e');
    }
    function r(e, n) {
      if (
        typeof e != "undefined" &&
        typeof e.contentWindow != "undefined" &&
        typeof e.contentWindow.postMessage == "function"
      ) {
        e.contentWindow.postMessage(n, "*");



      }

      $($('#appointment-form').length);

    }
    function o(e) {
      var n = 0;
      var t = 20;
      var i;
      var o = function () {
        if (n > t - 1) {
          clearInterval(i);
          return;
        }
        n++;
        if (typeof gtag !== "undefined" && s) {
          gtag("get", s, "client_id", function (n) {
            if (n) {
              t = 0;
              r(e, "gacid:" + n);
            }
          });
        } else {
          var o = undefined;
          if (typeof ga != "undefined") {
            o = ga;
          } else if (typeof __gaTracker != "undefined") {
            o = __gaTracker;
          } else {
            return;
          }
          o(function (i) {
            if (n > t - 1) {
              return;
            }
            if (!i) i = o.getAll()[0];
            var a = i.get("clientId");
            if (a) {
              t = 0;
              r(e, "gacid:" + a);
            }
          });
        }
      };
      i = setInterval(o, 250);
      o();
      console.log('e');
    }
    function a(e) {
      var i = +new Date();
      if (!e.hasLoaded || i - e.hasLoaded < 500) {
        e.hasLoaded = i;
        o(e);
      } else if (typeof window.scrollTo != "undefined") {
        t(n(e));
      }
      r(e, "acuity:init");
    }
    function f(e, i) {
        
      if (!e || !i) return;
      if (
        typeof e.contentWindow != "undefined" &&
        typeof i.source != "undefined" &&
        e.contentWindow !== i.source
      ) {
        return;
      }
      if (typeof i.data == "undefined" || typeof i.data.split == "undefined")
        return;
      try {
        var r = i.data.split(":");
        var o = r[0];
        var f = parseInt(r[1]);
        if (o == "sizing" && f > 150) {
          if (typeof e.origCss == "undefined") {
            e.origCss = e.style.cssText;
          }
          e.style.cssText =
            (e.origCss ? e.origCss + ";" : "") +
            "height:" +
            f +
            "px !important;max-height:none;overflow:hidden;";
        } else if (o == "load") {
          a(e);
        } else if (o == "scrollTo" && parseInt(f)) {
          t(n(e) + f, true);
        }
      } catch (e) {
        return;
      }
      console.log(i);
      
      console.log(f);
    }
    function d(n) {
      var t = [
        /first_name/,
        /last_name/,
        /firstName/,
        /lastName/,
        /phone/,
        /email/,
        /certificate/,
        /datetime/,
        /field:[0-9]+?/,
        /appointmentType/,
        /appointmentTypeID/,
        /calendarID/,
      ];
      var i = e(location.search.substr(1));
      var r = (newIfrSrc = n.src);

      for (var o in i) {
        for (var a = 0; a < t.length; a++) {
          var f = t[a];
          if (o.match(f) && r.indexOf(o + "=") === -1) {
            var d = i[o];
            var s = encodeURIComponent(o);
            if (typeof d == "object") {
              s = s + "[]";
              d = d.join("&" + s + "=");
            } else {
              d = encodeURIComponent(d);
            }
            var c = s + "=" + d;
            newIfrSrc += (newIfrSrc.indexOf("?") > -1 ? "&" : "?") + c;
          }
        }
      }
      if (newIfrSrc != r) {
        n.src = newIfrSrc;
      }

      console.log('e');
    }
    var s;
    function c(e) {
      if (!e.data || typeof e.data.split != "function") {
        return;
      }
      var n = e.data.split(":");
      if (n[1] !== "gaMeasurementId") {
        return;
      }
      s = n[2];
      console.log('e');
    }
    function u(e) {
      e.hasLoaded = false;
      d(e);
      i(e, "load", function () {
        a(e);
        console.log(e.html);
      });
      i(window, "message", function (n) {
        c(n);
        f(e, n);
        console.log($('.change-password-btn').length);
      

      });
    }

    var l = document.getElementsByTagName("iframe");
    if (!l) return;
    var p = ["acuityscheduling.com", "squarespacescheduling.com", ".as.me"];
    for (var v = 0; v < l.length; ++v) {
      for (var g = 0; g < p.length; g++) {
        if (!l[v].src) {
          continue;

        }

     
        if (l[v].src.indexOf(p[g]) > -1) {
          console.log(l[v].src);
          console.log(p[g]);
          u(l[v]);
          return;
        }
      }
    }
  })();
  