jQuery(document).ready(function($) {
  setTimeout(function() {
    const $accordions = $(".premium-accordion");
    $accordions.map((index, accordion) => {
      let $accordion = $(accordion),
        $title = $accordion.find(".premium-accordion__title_wrap");
      $title.on("click", function() {
        let self = $(this);
        self
          .find(".premium-accordion__icon")
          .toggleClass("premium-accordion__closed");
        self.siblings().toggleClass("premium-accordion__desc_close");

        $title.not($(this)).map((index, otherTitle) => {
          $otherTitle = $(otherTitle);
          $otherTitleIcon = $otherTitle.find(".premium-accordion__icon");
          $otherTitleSiblings = $otherTitle.siblings();

          !$otherTitleIcon.hasClass("premium-accordion__closed") &&
            $otherTitleIcon.toggleClass("premium-accordion__closed");
          !$otherTitleSiblings.hasClass("premium-accordion__desc_close") &&
            $otherTitleSiblings.toggleClass("premium-accordion__desc_close");
        });
      });
    });
  }, 500);
});
