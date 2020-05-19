jQuery(document).ready(function($) {
  const $iconBoxes = $(".premium-icon-box");

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

  $iconBoxes.map((index, iconBox) => {
    let $iconBox = $(iconBox),
      titleFont = $iconBox.find(".premium-icon-box__title").css("font-family"),
      descFont = $iconBox.find(".premium-icon-box__desc").css("font-family");

    addFontToHead(titleFont);
    addFontToHead(descFont);
  });
});
