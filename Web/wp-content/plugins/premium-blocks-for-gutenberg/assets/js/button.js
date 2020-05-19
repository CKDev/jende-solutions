jQuery(document).ready(function($) {
  const $button = $(".premium-button");

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

  $button.map((index, button) => {
    let $button = $(button),
      textFont = $button.css("font-family");

    addFontToHead(textFont);
  });
});
