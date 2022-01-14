var footerClickCount = 0;
$("footer").click(function () {
    footerClickCount++;
    if (footerClickCount == 42) {
        location.href = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";
    }
});