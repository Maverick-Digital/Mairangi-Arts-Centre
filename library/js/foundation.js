/*
 * Foundation Responsive Library
 * http://foundation.zurb.com
 * Copyright 2014, ZURB
 * Free to use under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
*/

!function(t,e,i,n){"use strict";function a(t){return("string"==typeof t||t instanceof String)&&(t=t.replace(/^['\\/"]+|(;\s?})+|['\\/"]+$/g,"")),t}var s=function(e){for(var i=e.length,n=t("head");i--;)0===n.has("."+e[i]).length&&n.append('<meta class="'+e[i]+'" />')};s(["foundation-mq-small","foundation-mq-small-only","foundation-mq-medium","foundation-mq-medium-only","foundation-mq-large","foundation-mq-large-only","foundation-mq-xlarge","foundation-mq-xlarge-only","foundation-mq-xxlarge","foundation-data-attribute-namespace"]),t(function(){"undefined"!=typeof FastClick&&"undefined"!=typeof i.body&&FastClick.attach(i.body)});var r=function(e,n){if("string"==typeof e){if(n){var a;if(n.jquery){if(a=n[0],!a)return n}else a=n;return t(a.querySelectorAll(e))}return t(i.querySelectorAll(e))}return t(e,n)},o=function(t){var e=[];return t||e.push("data"),this.namespace.length>0&&e.push(this.namespace),e.push(this.name),e.join("-")},u=function(t){for(var e=t.split("-"),i=e.length,n=[];i--;)0!==i?n.push(e[i]):this.namespace.length>0?n.push(this.namespace,e[i]):n.push(e[i]);return n.reverse().join("-")},l=function(e,i){var n=this,a=function(){var a=r(this),s=!a.data(n.attr_name(!0)+"-init");a.data(n.attr_name(!0)+"-init",t.extend({},n.settings,i||e,n.data_options(a))),s&&n.events(this)};return r(this.scope).is("["+this.attr_name()+"]")?a.call(this.scope):r("["+this.attr_name()+"]",this.scope).each(a),"string"==typeof e?this[e].call(this,i):void 0},m=function(t,e){function i(){e(t[0])}function n(){if(this.one("load",i),/MSIE (\d+\.\d+);/.test(navigator.userAgent)){var t=this.attr("src"),e=t.match(/\?/)?"&":"?";e+="random="+(new Date).getTime(),this.attr("src",t+e)}}return t.attr("src")?void(t[0].complete||4===t[0].readyState?i():n.call(t)):void i()};e.matchMedia=e.matchMedia||function(t){var e,i=t.documentElement,n=i.firstElementChild||i.firstChild,a=t.createElement("body"),s=t.createElement("div");return s.id="mq-test-1",s.style.cssText="position:absolute;top:-100em",a.style.background="none",a.appendChild(s),function(t){return s.innerHTML='&shy;<style media="'+t+'"> #mq-test-1 { width: 42px; }</style>',i.insertBefore(a,n),e=42===s.offsetWidth,i.removeChild(a),{matches:e,media:t}}}(i),function(t){function i(){n&&(r(i),u&&t.fx.tick())}for(var n,a=0,s=["webkit","moz"],r=e.requestAnimationFrame,o=e.cancelAnimationFrame,u="undefined"!=typeof t.fx;a<s.length&&!r;a++)r=e[s[a]+"RequestAnimationFrame"],o=o||e[s[a]+"CancelAnimationFrame"]||e[s[a]+"CancelRequestAnimationFrame"];r?(e.requestAnimationFrame=r,e.cancelAnimationFrame=o,u&&(t.fx.timer=function(e){e()&&t.timers.push(e)&&!n&&(n=!0,i())},t.fx.stop=function(){n=!1})):(e.requestAnimationFrame=function(t){var i=(new Date).getTime(),n=Math.max(0,16-(i-a)),s=e.setTimeout(function(){t(i+n)},n);return a=i+n,s},e.cancelAnimationFrame=function(t){clearTimeout(t)})}(t),e.Foundation={name:"Foundation",version:"5.5.1",media_queries:{small:r(".foundation-mq-small").css("font-family").replace(/^[\/\\'"]+|(;\s?})+|[\/\\'"]+$/g,""),"small-only":r(".foundation-mq-small-only").css("font-family").replace(/^[\/\\'"]+|(;\s?})+|[\/\\'"]+$/g,""),medium:r(".foundation-mq-medium").css("font-family").replace(/^[\/\\'"]+|(;\s?})+|[\/\\'"]+$/g,""),"medium-only":r(".foundation-mq-medium-only").css("font-family").replace(/^[\/\\'"]+|(;\s?})+|[\/\\'"]+$/g,""),large:r(".foundation-mq-large").css("font-family").replace(/^[\/\\'"]+|(;\s?})+|[\/\\'"]+$/g,""),"large-only":r(".foundation-mq-large-only").css("font-family").replace(/^[\/\\'"]+|(;\s?})+|[\/\\'"]+$/g,""),xlarge:r(".foundation-mq-xlarge").css("font-family").replace(/^[\/\\'"]+|(;\s?})+|[\/\\'"]+$/g,""),"xlarge-only":r(".foundation-mq-xlarge-only").css("font-family").replace(/^[\/\\'"]+|(;\s?})+|[\/\\'"]+$/g,""),xxlarge:r(".foundation-mq-xxlarge").css("font-family").replace(/^[\/\\'"]+|(;\s?})+|[\/\\'"]+$/g,"")},stylesheet:t("<style></style>").appendTo("head")[0].sheet,global:{namespace:n},init:function(t,i,n,a,s){var o=[t,n,a,s],u=[];if(this.rtl=/rtl/i.test(r("html").attr("dir")),this.scope=t||this.scope,this.set_namespace(),i&&"string"==typeof i&&!/reflow/i.test(i))this.libs.hasOwnProperty(i)&&u.push(this.init_lib(i,o));else for(var l in this.libs)u.push(this.init_lib(l,i));return r(e).load(function(){r(e).trigger("resize.fndtn.clearing").trigger("resize.fndtn.dropdown").trigger("resize.fndtn.equalizer").trigger("resize.fndtn.interchange").trigger("resize.fndtn.joyride").trigger("resize.fndtn.magellan").trigger("resize.fndtn.topbar").trigger("resize.fndtn.slider")}),t},init_lib:function(e,i){return this.libs.hasOwnProperty(e)?(this.patch(this.libs[e]),i&&i.hasOwnProperty(e)?("undefined"!=typeof this.libs[e].settings?t.extend(!0,this.libs[e].settings,i[e]):"undefined"!=typeof this.libs[e].defaults&&t.extend(!0,this.libs[e].defaults,i[e]),this.libs[e].init.apply(this.libs[e],[this.scope,i[e]])):(i=i instanceof Array?i:new Array(i),this.libs[e].init.apply(this.libs[e],i))):function(){}},patch:function(t){t.scope=this.scope,t.namespace=this.global.namespace,t.rtl=this.rtl,t.data_options=this.utils.data_options,t.attr_name=o,t.add_namespace=u,t.bindings=l,t.S=this.utils.S},inherit:function(t,e){for(var i=e.split(" "),n=i.length;n--;)this.utils.hasOwnProperty(i[n])&&(t[i[n]]=this.utils[i[n]])},set_namespace:function(){var e=this.global.namespace===n?t(".foundation-data-attribute-namespace").css("font-family"):this.global.namespace;this.global.namespace=e===n||/false/i.test(e)?"":e},libs:{},utils:{S:r,throttle:function(t,e){var i=null;return function(){var n=this,a=arguments;null==i&&(i=setTimeout(function(){t.apply(n,a),i=null},e))}},debounce:function(t,e,i){var n,a;return function(){var s=this,r=arguments,o=function(){n=null,i||(a=t.apply(s,r))},u=i&&!n;return clearTimeout(n),n=setTimeout(o,e),u&&(a=t.apply(s,r)),a}},data_options:function(e,i){function n(t){return!isNaN(t-0)&&null!==t&&""!==t&&t!==!1&&t!==!0}function a(e){return"string"==typeof e?t.trim(e):e}i=i||"options";var s,r,o,u={},l=function(t){var e=Foundation.global.namespace;return t.data(e.length>0?e+"-"+i:i)},m=l(e);if("object"==typeof m)return m;for(o=(m||":").split(";"),s=o.length;s--;)r=o[s].split(":"),r=[r[0],r.slice(1).join(":")],/true/i.test(r[1])&&(r[1]=!0),/false/i.test(r[1])&&(r[1]=!1),n(r[1])&&(r[1]=-1===r[1].indexOf(".")?parseInt(r[1],10):parseFloat(r[1])),2===r.length&&r[0].length>0&&(u[a(r[0])]=a(r[1]));return u},register_media:function(e,i){Foundation.media_queries[e]===n&&(t("head").append('<meta class="'+i+'"/>'),Foundation.media_queries[e]=a(t("."+i).css("font-family")))},add_custom_rule:function(t,e){if(e===n&&Foundation.stylesheet)Foundation.stylesheet.insertRule(t,Foundation.stylesheet.cssRules.length);else{var i=Foundation.media_queries[e];i!==n&&Foundation.stylesheet.insertRule("@media "+Foundation.media_queries[e]+"{ "+t+" }")}},image_loaded:function(t,e){var i=this,n=t.length;0===n&&e(t),t.each(function(){m(i.S(this),function(){n-=1,0===n&&e(t)})})},random_str:function(){return this.fidx||(this.fidx=0),this.prefix=this.prefix||[this.name||"F",(+new Date).toString(36)].join("-"),this.prefix+(this.fidx++).toString(36)},match:function(t){return e.matchMedia(t).matches},is_small_up:function(){return this.match(Foundation.media_queries.small)},is_medium_up:function(){return this.match(Foundation.media_queries.medium)},is_large_up:function(){return this.match(Foundation.media_queries.large)},is_xlarge_up:function(){return this.match(Foundation.media_queries.xlarge)},is_xxlarge_up:function(){return this.match(Foundation.media_queries.xxlarge)},is_small_only:function(){return!(this.is_medium_up()||this.is_large_up()||this.is_xlarge_up()||this.is_xxlarge_up())},is_medium_only:function(){return this.is_medium_up()&&!this.is_large_up()&&!this.is_xlarge_up()&&!this.is_xxlarge_up()},is_large_only:function(){return this.is_medium_up()&&this.is_large_up()&&!this.is_xlarge_up()&&!this.is_xxlarge_up()},is_xlarge_only:function(){return this.is_medium_up()&&this.is_large_up()&&this.is_xlarge_up()&&!this.is_xxlarge_up()},is_xxlarge_only:function(){return this.is_medium_up()&&this.is_large_up()&&this.is_xlarge_up()&&this.is_xxlarge_up()}}},t.fn.foundation=function(){var t=Array.prototype.slice.call(arguments,0);return this.each(function(){return Foundation.init.apply(Foundation,[this].concat(t)),this})}}(jQuery,window,window.document);