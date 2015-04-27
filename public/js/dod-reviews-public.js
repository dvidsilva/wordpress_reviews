var $ =  $ || jQuery;

var DoDSliderCycle = function DoDSliderCycle (dir) {
  var a;
  if(!dir || dir === 'left') {
    a = $('.dodrslider .dodrslide:first').remove();
    $('.dodrslider').append(a);
  } else {
    a = $('.dodrslider .dodrslide:last').remove();    
    $('.dodrslider').prepend(a);
  }
};


$(document).ready(function () {
  $('.dodrarrow').on('click', function () {
    DoDSliderCycle($(this).data('dir'));
  });
  $('.dodrreadmore').on('click', function () {
    $(this).hide();
    $(this).parent().siblings('.dodrreview').find('span').hide();
    $(this).parent().siblings('.dodrreview').find('.dodrfullr').show();
  });
});



