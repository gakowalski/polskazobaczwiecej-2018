jQuery(document).ready(function(){
  jQuery('#contrast>a').click(function() {
    var high_contrast_enabled = jQuery('body').hasClass('high-contrast');
    document.cookie = "high_contrast=" + (high_contrast_enabled === true? 0 : 1);
    location.reload(true);
    return false;
  });
  jQuery('#font-resize-small').click(function() {
    jQuery('html').css('font-size', '10px');
    document.cookie = "font_resize=small";
    return false;
  });
  jQuery('#font-resize-medium').click(function() {
    jQuery('html').css('font-size', '13px');
    document.cookie = "font_resize=medium";
    return false;
  });
  jQuery('#font-resize-large').click(function() {
    jQuery('html').css('font-size', '16px');
    document.cookie = "font_resize=large";
    return false;
  });
});
