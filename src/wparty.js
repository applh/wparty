/*
jQuery(function() {
  jQuery('.flexslider').flexslider({
    itemWidth: 640,
  });
});
*/
// BUGGY ON ANDROID GNOTE2
jQuery(function() {
  jQuery('.flexslider').flexslider({
    animation: "slide",
    animationLoop: false,
    itemMargin: 0,
    controlNav: 'thumbnails'
  });
});

