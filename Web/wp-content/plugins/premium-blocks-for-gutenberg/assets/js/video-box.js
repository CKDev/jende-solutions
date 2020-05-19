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
  const $videoBoxes = $(".premium-video-box");
  $videoBoxes.map((index, videoBox) => {
    let $videoBox = $(videoBox),
      type = $videoBox.data("type");
    let descFont = $videoBox
      .find(".premium-video-box__desc_text")
      .css("font-family");
    if (undefined != descFont) {
      addFontToHead(descFont);
    }

    $videoBox.on("click", () => {
      $videoBox.toggleClass("video-overlay-false");
      let $video = $videoBox.find("iframe, video"),
        src = $video.attr("src");
      setTimeout(() => {
        if ("self" === type) {
          $videoBox.find(".premium-video-box__overlay").remove();
          $($video)
            .get(0)
            .play();
        } else {
          $video.attr("src", src.replace("autoplay=0", "autoplay=1"));
        }
      }, 300);
    });
  });
});
