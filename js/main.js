$(document).ready(function(){
    
    var first_id = 0;
    function getData(){
        
        $.getJSON('/twitter_stream/get.php', {from:first_id}, function(data){
            var items = [];
            first_run = true;
            $i = 0;
            $.each(data, function(key, val) {
                items.push('<div class="alert-message block-message info" id="' + val._id.$id + '" data_tw_id="'+val.id_str+'"><p><strong>' + val.user.screen_name + ':</strong> '+val.text+'. <span class="label">'+val.created_at+'</span><p></div>');
                if(first_run){
                    first_id = val._id.$id;
                    first_run = false;
                }
                $i++;
            });
            //$('#data-display').append(items.join(''));
            $('#data-display').html(items.join(''));
            console.log("Last id: "+first_id);
            console.log("Fetched: "+$i);
        })
    }

    getData();
    setInterval( function(){
        getData();
    }, 5000 );
});