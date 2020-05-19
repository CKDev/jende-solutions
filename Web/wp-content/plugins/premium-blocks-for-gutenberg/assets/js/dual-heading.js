jQuery(document).ready(function($) {
  const $dualHeading = $(".premium-dheading-block__title");

  const addFontToHead = fontFamily => {
    const head = document.head;
    const link = document.createElement("link");
    link.type = "text/css";
    link.rel = "stylesheet";
    link.href =
      "https://fonts.googleapis.com/css?family=" +
      fontFamily.replace(/\s+/g, "+") +
      ":" +
      "regular";
    head.appendChild(link);
  };

  $dualHeading.map((index, dualHeading) => {
    let $dualHeading = $(dualHeading),
      firstHeadingFont = $dualHeading
        .find(".premium-dheading-block__first")
        .css("font-family"),
      secondHeadingFont = $dualHeading
        .find(".premium-dheading-block__second")
        .css("font-family");

    addFontToHead(firstHeadingFont);
    addFontToHead(secondHeadingFont);
  });
});
