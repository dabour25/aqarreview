var page=1;
var canload=false;

$(window).bind('scroll', function() {
    if($(window).scrollTop() >= $('#load_more').offset().top + $('#load_more').outerHeight() - window.innerHeight) {
        load_posts();
        canload=false;
    }
});
function load_posts() {
    if(canload) {
        $.get("/posts-list", {
            page: page,
        },
        function (data, status) {
            canload = true;
            page++;
            alert("Data: " + data);
        });
    }
}
load_posts();