var dodReviewsSeconds = 3;
var DODRGRRRRR;
var removeIntervalFN = function () {
  if (DODRGRRRRR) {
    clearInterval(DODRGRRRRR);
  }
};
var DoDReviewsIntervalFN = function ($) { 
  DODRGRRRRR = setInterval(function DoDReviewsInterval () {
    DoDSliderCycle($, 'left');
  }, dodReviewsSeconds * 1000);
};

var DoDSliderCycle = function DoDSliderCycle ($, dir) {
  var a;
  removeIntervalFN();
  if(!dir || dir === 'left') {
    a = $('.dodrslider .dodrslide:first').fadeOut(300, function () {
      $('.dodrslider .dodrslide:first').remove();
    }).clone();
    $('.dodrslider').append(a);
  } else {
    a = $('.dodrslider .dodrslide:last').fadeOut(300, function () {
      $('.dodrslider .dodrslide:last').remove();
    }).clone();
    $('.dodrslider .dodrarrow:last').after(a);
  }
  DoDReviewsIntervalFN();
};


var dodReviewsSlider = function dodReviewsSlider ($) {
  DoDReviewsIntervalFN($);
  
  $(document).ready(function () {
    $('.dodrarrow').on('click', function () {
      DoDSliderCycle($, $(this).data('dir'));
    });
  });
};

(function ($) {
  'use strict';
  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note that this assume you're going to use jQuery, so it prepares
   * the $ function reference to be used within the scope of this
   * function.
   *
   * From here, you're able to define handlers for when the DOM is
   * ready:
   *
   * $(function() {
   *
   * });
   *
   * Or when the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and so on.
   *
   * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
   * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
   * be doing this, we should try to minimize doing that in our own work.
   */
  // Only do anything if jQuery isn't defined
  if (typeof jQuery == 'undefined') {
    if (typeof $ == 'function') {
      // warning, global var
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
        dodReviewsSlider(jQuery);
        if (thisPageUsingOtherJSLibrary) {
          // Run your jQuery Code
        } else {
          // Use .noConflict(), then run your jQuery Code
        }
      }
    });
  } else { // jQuery was already loaded
    // Run your jQuery Code
    dodReviewsSlider(jQuery);
  };
})(jQuery);

