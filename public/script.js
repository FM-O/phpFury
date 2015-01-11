SC.initialize({
    client_id: '8ec40d909de5ff0c1b3da51095ed9902',
    redirect_uri: 'http://phpfury.local/callback.html'
});
//92795454
$(document).ready(function() {
    $('a.connect').click(function(e) {
        e.preventDefault();
        SC.connect(function() {
            SC.get('/me', function(me) {
                $('#username').html(me.username);
                $('#avatar').append($('<img src="'+me.avatar_url+'"/>'))
            });
            SC.get('/tracks/81483167', function(tracks) {
                $('#results').append($('<li></li>').html(tracks.user_id));
                SC.get('/users/'+tracks.user_id+'', function(user){
                    $(tracks).each(function(index, track) {
                    $('#results').append($('<li></li>').html(track.title + ' - ' + user.username));
                    });
                });
            });
            SC.get('/users/92795454/favorites', function(playlist){
                for(i=0; i<playlist.length; i++){
                    console.log(playlist[i].title);
                    $('#results').append($('<li></li>').html(playlist[i].title));
                    $('#results').append($('<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'+playlist[i].id+'&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false"></iframe>'));
                }
            });
        });
    });
});

