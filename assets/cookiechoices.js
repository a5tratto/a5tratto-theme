!function(e){if(e.cookieChoices)return e.cookieChoices;var t=e.document,n="textContent"in t.body,i=function(){function e(e,n,i,o){var d="position:fixed;width:100%;background-color:#eee;margin:0; left:0; bottom:0;padding:4px;z-index:1000;text-align:center;",l=t.createElement("div");return l.id=C,l.style.cssText=d,l.appendChild(r(e)),i&&o&&l.appendChild(c(i,o)),l.appendChild(a(n)),l}function i(e,n,i,o){var d="position:fixed;width:100%;height:100%;z-index:999;top:0;left:0;opacity:0.5;filter:alpha(opacity=50);background-color:#ccc;",l="z-index:1000;position:fixed;left:50%;top:50%",p="position:relative;left:-50%;margin-top:-25%;background-color:#fff;padding:20px;box-shadow:4px 4px 25px #888;",s=t.createElement("div");s.id=C;var f=t.createElement("div");f.style.cssText=d;var u=t.createElement("div");u.style.cssText=p;var h=t.createElement("div");h.style.cssText=l;var x=a(n);return x.style.display="block",x.style.textAlign="right",x.style.marginTop="8px",u.appendChild(r(e)),i&&o&&u.appendChild(c(i,o)),u.appendChild(x),h.appendChild(u),s.appendChild(f),s.appendChild(h),s}function o(e,t){n?e.textContent=t:e.innerText=t}function r(e){var n=t.createElement("span");return o(n,e),n}function a(e){var n=t.createElement("a");return o(n,e),n.id=g,n.href="#",n.style.marginLeft="24px",n}function c(e,n){var i=t.createElement("a");return o(i,e),i.href=n,i.target="_blank",i.style.marginLeft="8px",i}function d(){return u(),f(),!1}function l(n,o,r,a,c){if(h()){f();var l=c?i(n,o,r,a):e(n,o,r,a),p=t.createDocumentFragment();p.appendChild(l),t.body.appendChild(p.cloneNode(!0)),t.getElementById(g).onclick=d}}function p(e,t,n,i){l(e,t,n,i,!1)}function s(e,t,n,i){l(e,t,n,i,!0)}function f(){var e=t.getElementById(C);null!=e&&e.parentNode.removeChild(e)}function u(){var e=new Date;e.setFullYear(e.getFullYear()+1),t.cookie=x+"=y; expires="+e.toGMTString()}function h(){return!t.cookie.match(new RegExp(x+"=([^;]+)"))}var x="displayCookieConsent",C="cookieChoiceInfo",g="cookieChoiceDismiss",m={};return m.showCookieConsentBar=p,m.showCookieConsentDialog=s,m}();return e.cookieChoices=i,i}(this);