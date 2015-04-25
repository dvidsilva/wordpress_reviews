var dodReviewsSeconds = 3;
var DODRGRRRRR;
var removeIntervalFN = function () {
  if (DODRGRRRRR) {
    clearInterval(DODRGRRRRR);
  }
};
var DoDReviewsIntervalFN = function DoDReviewsIntervalFN () {
  DODRGRRRRR = setInterval(function DoDReviewsInterval () {
    DoDSliderCycle($, 'left');
  }, dodReviewsSeconds * 1000);
};

var DoDSliderCycle = function DoDSliderCycle (dir) {
  var a;
  removeIntervalFN();
  if(!dir || dir === 'left') {
    a = $('.dodrslider .dodrslide:first').remove();
    $('.dodrslider').append(a);
  } else {
    a = $('.dodrslider .dodrslide:last').remove();    
    $('.dodrslider .dodrarrow:last').after(a);
  }
  DoDReviewsIntervalFN();
};


var dodReviewsSlider = function dodReviewsSlider () {
  DoDReviewsIntervalFN();
  $(document).ready(function () {
    $('.dodrarrow').on('click', function () {
      DoDSliderCycle($(this).data('dir'));
    });
  });
};

(function () {
  'use strict';
  // Only do anything if jQuery isn't defined
  if (typeof jQuery == 'undefined') {
    if (typeof $ == 'function') {
      var thisPageUsingOtherJSLibrary = true;
    }
    function getScript(url, success) {
      var script = document.createElement('script');
      script.src = url;
      var head = document.getElementsByTagName('head')[0],
        done = false;
      // Attach handlers for all browsers
      script.onload = script.onreadystatechange = function () {
        if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {
          done = true;
          // callback function provided as param
          success();
          script.onload = script.onreadystatechange = null;
          head.removeChild(script);
        };
      };
      head.appendChild(script);
    };
    getScript('https://code.jquery.com/jquery-2.1.3.min.js', function () {
      if (typeof jQuery == 'undefined') {
        // Super failsafe - still somehow failed...
      } else {
        // jQuery loaded! Make sure to use .noConflict just in case
        $ = jQuery;
        dodReviewsSlider();
        if (thisPageUsingOtherJSLibrary) {
          // Run your jQuery Code
        } else {
          // Use .noConflict(), then run your jQuery Code
        }
      }
    });
  } else {
    $ = jQuery;
    dodReviewsSlider();
  };
})();

