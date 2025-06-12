$(function(){
  $('#searchBtn').click(function(){
    var query = $('input[name="title"]').val();
    if(!query) return;
    $.get('https://www.googleapis.com/youtube/v3/search', {
      part: 'snippet',
      q: query,
      maxResults: 5,
      type: 'video',
      key: 'YOUR_API_KEY'
    }, function(res){
      var results = $('#results').empty();
      res.items.forEach(function(item){
        var url = 'https://www.youtube.com/watch?v=' + item.id.videoId;
        var btn = $('<button>Select</button>').click(function(){
          $('#youtube_link').val(url);
        });
        results.append($('<div>').text(item.snippet.title).append(' ').append(btn));
      });
    });
  });
});
