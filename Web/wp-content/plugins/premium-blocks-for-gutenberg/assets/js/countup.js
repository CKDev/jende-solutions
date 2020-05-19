jQuery(document).ready(function($) {
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

  const $counters = $(".premium-countup__wrap");
  $counters.map((index, counter) => {
    let $counter = $(counter).find(".premium-countup__increment");
    let counterFont = $counter.css("font-family");
    let time = $counter.data("interval");
    let delay = $counter.data("delay");
    let titleFont = $(counter)
      .find(".premium-countup__title")
      .css("font-family");

    let prefixFont = $(counter)
      .find(".premium-countup__prefix")
      .css("font-family");

    let suffixFont = $(counter)
      .find(".premium-countup__suffix")
      .css("font-family");

    if (undefined != titleFont) {
      addFontToHead(titleFont);
    }

    if (undefined != prefixFont) {
      addFontToHead(prefixFont);
    }

    if (undefined != suffixFont) {
      addFontToHead(suffixFont);
    }

    if (undefined != counterFont) {
      addFontToHead(counterFont);
    }

    $counter.counterUp({
      delay: delay,
      time: time
    });
  });
});
