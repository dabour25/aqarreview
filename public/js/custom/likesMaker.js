function commentBlog(slug) {
    var request = new XMLHttpRequest();
    var formData=new FormData();
    formData.append("slug",slug);
    formData.append("user_id",current);
    formData.append("comment",$('#comment'+slug).val());
    request.open("POST", "/api/comment-blog");
    request.send(formData);
    request.onreadystatechange = function() {
        if (request.readyState === 4) {
            var response=JSON.parse(request.response);
            if(request.status!==200){
                Swal.fire({
                    icon: 'error',
                    title: 'Error in Comment',
                    text: response.comment,
                });
            }else{
                Swal.fire({
                    icon: 'success',
                    title: 'Comment Added Successfully',
                    text: '',
                });
            }
        }
    }
}
function like_comment(id) {
    var request = new XMLHttpRequest();
    request.open("GET", "/api/like-comment?id="+id+"&user_id="+current);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState === 4) {
            if($('#comment'+id+'dislike').hasClass('fa-thumbs-down')){
                $('#comment'+id+'dislikes').text(parseInt($('#comment'+id+'dislikes').text())-1);
                $('#comment'+id+'dislike').removeClass('fa-thumbs-down');
                $('#comment'+id+'dislike').addClass('fa-thumbs-o-down');
            }

            var response = JSON.parse(request.response);
            if(response.liked==true){
                $('#comment'+id+'likes').text(parseInt($('#comment'+id+'likes').text())+1);
                $('#comment'+id+'like').removeClass('fa-thumbs-o-up');
                $('#comment'+id+'like').addClass('fa-thumbs-up');
            }else{
                $('#comment'+id+'likes').text(parseInt($('#comment'+id+'likes').text())-1);
                $('#comment'+id+'like').removeClass('fa-thumbs-up');
                $('#comment'+id+'like').addClass('fa-thumbs-o-up');
            }
        }
    }
}
function dislike_comment(id) {
    var request = new XMLHttpRequest();
    request.open("GET", "/api/dislike-comment?id="+id+"&user_id="+current);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState === 4) {
            if($('#comment'+id+'like').hasClass('fa-thumbs-up')){
                $('#comment'+id+'likes').text(parseInt($('#comment'+id+'likes').text())-1);
                $('#comment'+id+'like').removeClass('fa-thumbs-up');
                $('#comment'+id+'like').addClass('fa-thumbs-o-up');
            }
            var response = JSON.parse(request.response);
            if(response.liked==true){
                $('#comment'+id+'dislikes').text(parseInt($('#comment'+id+'dislikes').text())+1);
                $('#comment'+id+'dislike').removeClass('fa-thumbs-o-down');
                $('#comment'+id+'dislike').addClass('fa-thumbs-down');
            }else{
                $('#comment'+id+'dislikes').text(parseInt($('#comment'+id+'dislikes').text())-1);
                $('#comment'+id+'dislike').removeClass('fa-thumbs-down');
                $('#comment'+id+'dislike').addClass('fa-thumbs-o-down');
            }
        }
    }
}

function like_reply(id) {
    var request = new XMLHttpRequest();
    request.open("GET", "/api/like-reply?id="+id+"&user_id="+current);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState === 4) {
            if($('#reply'+id+'dislike').hasClass('fa-thumbs-down')){
                $('#reply'+id+'dislikes').text(parseInt($('#reply'+id+'dislikes').text())-1);
                $('#reply'+id+'dislike').removeClass('fa-thumbs-down');
                $('#reply'+id+'dislike').addClass('fa-thumbs-o-down');
            }

            var response = JSON.parse(request.response);
            if(response.liked==true){
                $('#reply'+id+'likes').text(parseInt($('#reply'+id+'likes').text())+1);
                $('#reply'+id+'like').removeClass('fa-thumbs-o-up');
                $('#reply'+id+'like').addClass('fa-thumbs-up');
            }else{
                $('#reply'+id+'likes').text(parseInt($('#reply'+id+'likes').text())-1);
                $('#reply'+id+'like').removeClass('fa-thumbs-up');
                $('#reply'+id+'like').addClass('fa-thumbs-o-up');
            }
        }
    }
}
function dislike_reply(id) {
    var request = new XMLHttpRequest();
    request.open("GET", "/api/dislike-reply?id="+id+"&user_id="+current);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState === 4) {
            if($('#reply'+id+'like').hasClass('fa-thumbs-up')){
                $('#reply'+id+'likes').text(parseInt($('#reply'+id+'likes').text())-1);
                $('#reply'+id+'like').removeClass('fa-thumbs-up');
                $('#reply'+id+'like').addClass('fa-thumbs-o-up');
            }
            var response = JSON.parse(request.response);
            if(response.liked==true){
                $('#reply'+id+'dislikes').text(parseInt($('#reply'+id+'dislikes').text())+1);
                $('#reply'+id+'dislike').removeClass('fa-thumbs-o-down');
                $('#reply'+id+'dislike').addClass('fa-thumbs-down');
            }else{
                $('#reply'+id+'dislikes').text(parseInt($('#reply'+id+'dislikes').text())-1);
                $('#reply'+id+'dislike').removeClass('fa-thumbs-down');
                $('#reply'+id+'dislike').addClass('fa-thumbs-o-down');
            }
        }
    }
}