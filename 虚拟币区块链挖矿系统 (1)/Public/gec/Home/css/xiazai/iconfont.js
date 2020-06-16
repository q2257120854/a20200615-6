;(function(window) {

var svgSprite = '<svg>' +
  ''+
    '<symbol id="icon-android" viewBox="0 0 1024 1024">'+
      ''+
      '<path d="M839.562 344.72c-30.082 0-54.476 24.771-54.476 55.326v216.209c0 30.558 24.393 55.328 54.476 55.328 30.087 0 54.476-24.771 54.476-55.328v-216.209c0.001-30.555-24.387-55.326-54.476-55.326zM182.482 344.72c-30.085 0-54.476 24.771-54.476 55.326v216.209c0 30.558 24.391 55.328 54.476 55.328s54.476-24.771 54.476-55.328v-216.209c0-30.555-24.391-55.326-54.476-55.326z"  ></path>'+
      ''+
      '<path d="M269.74 346.395v395.014c0 23.462 19.020 42.481 42.483 42.481h48.533v120.293c0 30.558 24.391 55.328 54.476 55.328 30.087 0 54.478-24.771 54.478-55.328v-120.294h84.786v120.293c0 30.558 24.393 55.328 54.476 55.328 30.087 0 54.481-24.771 54.481-55.328v-120.293h48.528c23.467 0 42.485-19.018 42.485-42.481v-395.013h-484.725z"  ></path>'+
      ''+
      '<path d="M625.92 141.706l44.777-64.999c2.657-3.861 1.997-8.932-1.478-11.326-3.475-2.392-8.447-1.204-11.104 2.659l-46.512 67.518c-30.65-12.075-64.707-18.805-100.581-18.805-35.874 0-69.929 6.729-100.579 18.805l-46.512-67.518c-2.659-3.863-7.631-5.050-11.106-2.659-3.475 2.395-4.134 7.466-1.476 11.326l44.777 64.999c-71.188 33.117-121.113 96.042-127.467 169.487h484.727c-6.355-73.445-56.28-136.37-127.466-169.487zM408.772 244.144c-14.811 0-26.819-12.005-26.819-26.819 0-14.811 12.007-26.819 26.819-26.819 14.813 0 26.819 12.007 26.819 26.819 0 14.813-12.005 26.819-26.819 26.819zM616.625 244.144c-14.811 0-26.816-12.005-26.816-26.819 0-14.811 12.004-26.819 26.816-26.819 14.816 0 26.821 12.007 26.821 26.819 0 14.813-12.004 26.819-26.821 26.819z"  ></path>'+
      ''+
    '</symbol>'+
  ''+
    '<symbol id="icon-ios" viewBox="0 0 1024 1024">'+
      ''+
      '<path d="M517.392097 360.456569 428.783963 331.810276C428.783963 331.810276 296.493731 280.356061 197.448509 389.075727 96.176766 500.18901 103.92032 637.19364 148.226529 761.237601 192.528454 885.310126 276.884917 1021.919152 369.716158 1023.681517 441.443288 1025.042566 447.060292 984.825216 546.909575 985.522165 546.909575 985.522165 582.770998 990.275124 635.517709 1009.355515 688.265848 1028.467325 733.036214 1031.753551 788.109419 975.949121 866.85459 896.21137 906.240744 775.59788 906.240744 775.59788 906.240744 775.59788 774.748861 727.168536 778.273592 584.713997 781.766903 442.259459 881.610473 408.156117 881.610473 408.156117 881.610473 408.156117 806.391461 280.027582 635.517709 322.270081L517.392097 360.456569ZM512.372069 235.352904C512.372069 235.352904 493.325954 29.14901 748.556169 0 748.556169 0 765.013006 218.900351 512.372069 235.352904L512.372069 235.352904Z"  ></path>'+
      ''+
    '</symbol>'+
  ''+
'</svg>'
var script = function() {
    var scripts = document.getElementsByTagName('script')
    return scripts[scripts.length - 1]
  }()
var shouldInjectCss = script.getAttribute("data-injectcss")

/**
 * document ready
 */
var ready = function(fn){
  if(document.addEventListener){
      document.addEventListener("DOMContentLoaded",function(){
          document.removeEventListener("DOMContentLoaded",arguments.callee,false)
          fn()
      },false)
  }else if(document.attachEvent){
     IEContentLoaded (window, fn)
  }

  function IEContentLoaded (w, fn) {
      var d = w.document, done = false,
      // only fire once
      init = function () {
          if (!done) {
              done = true
              fn()
          }
      }
      // polling for no errors
      ;(function () {
          try {
              // throws errors until after ondocumentready
              d.documentElement.doScroll('left')
          } catch (e) {
              setTimeout(arguments.callee, 50)
              return
          }
          // no errors, fire

          init()
      })()
      // trying to always fire before onload
      d.onreadystatechange = function() {
          if (d.readyState == 'complete') {
              d.onreadystatechange = null
              init()
          }
      }
  }
}

/**
 * Insert el before target
 *
 * @param {Element} el
 * @param {Element} target
 */

var before = function (el, target) {
  target.parentNode.insertBefore(el, target)
}

/**
 * Prepend el to target
 *
 * @param {Element} el
 * @param {Element} target
 */

var prepend = function (el, target) {
  if (target.firstChild) {
    before(el, target.firstChild)
  } else {
    target.appendChild(el)
  }
}

function appendSvg(){
  var div,svg

  div = document.createElement('div')
  div.innerHTML = svgSprite
  svg = div.getElementsByTagName('svg')[0]
  if (svg) {
    svg.setAttribute('aria-hidden', 'true')
    svg.style.position = 'absolute'
    svg.style.width = 0
    svg.style.height = 0
    svg.style.overflow = 'hidden'
    prepend(svg,document.body)
  }
}

if(shouldInjectCss && !window.__iconfont__svg__cssinject__){
  window.__iconfont__svg__cssinject__ = true
  try{
    document.write("<style>.svgfont {display: inline-block;width: 1em;height: 1em;fill: currentColor;vertical-align: -0.1em;font-size:16px;}</style>");
  }catch(e){
    console && console.log(e)
  }
}

ready(appendSvg)


})(window)
