$(document).ready(function(){
    
    var first_id = 0;
    function getData(){
        
        $.getJSON('/twitter_stream/get.php', {from:first_id}, function(data){
            var items = [];
            first_run = true;
            $i = 0;
            $.each(data, function(key, val) {
                items.push('<div class="alert-message block-message info" id="' + val._id.$id + '" style="padding-bottom:23px; min-height:40px" data_tw_id="'+val.id_str+'"><p><img style="float:left; margin-right: 10px; border-radius:5px; display:inline-block;" src="'+ val.user.profile_image_url +' "/><strong>' + val.user.screen_name + ':</strong> '+val.text+'. <span class="label">'+val.created_at+'</span></p></div>');
                if(first_run){
                    first_id = val.id_str;
                    first_run = false;
                }
                $i++;
            });
            //$('#data-display').append(items.join(''));
            $('#data-display').prepend(items.join(''));
            console.log("Last id: "+first_id);
            console.log("Fetched: "+$i);
        })
    }

    getData();
    setInterval( function(){
        getData();
    }, 10000 );
});