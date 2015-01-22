
$(document).ready(function(){
  $.get({
    url:'http://istudyante.local/blog/comments/blog_id:1',
    success:function(data){
      $("#comments").html(data);
    }
  })
});