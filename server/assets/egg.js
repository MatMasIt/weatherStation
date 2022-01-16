var footerClickCount = 0;
$("footer").click(function () {
    footerClickCount++;
    if (footerClickCount == 42) {
        footerClickCount=0;
        location.href = "https://www.youtube.com/watch?v=rOjHhS5MtvA";
    }
});
