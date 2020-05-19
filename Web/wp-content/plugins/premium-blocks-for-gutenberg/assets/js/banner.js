jQuery(document).ready(function($) {
  setTimeout(() => {
    const $counters = $(".premium-banner__inner");
    $counters.map((index, banner) => {
      let $banner = $(banner);
      $banner.hover(
        function() {
          $(this)
            .find(".premium-banner__img")
            .addClass("premium-banner__active");
        },
        function() {
          $(this)
            .find(".premium-banner__img")
            .removeClass("premium-banner__active");
        }
      );
    });
  }, 2000);
});
