$(function(){

    var packetBody = $('#packet-table');
    var uploadButton = $('#photo-upload');
    var uploadingText = $('#uploading-text');

    
    $(document).on('click', '#create-packet', function(){
        var urlTo = $(this).attr('data-url');
        var uploaded = 0;
        var $this = $(this);

        uploadButton.addClass('disabled');
        uploadingText.show();
        uploadingTextInterval = setInterval(dotsAnimation, 300);

        $.ajax({
            url: urlTo,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: {},
            type: 'post',
            success: function(response){

                if(response.result === 'success'){
                    var html = $(packetTemplate
                            .replace(/\{\{packet_id\}\}/g, response.packet.id)
                            .replace(/\{\{packet_description\}\}/g, '')
                            .replace(/\{\{packet_price\}\}/g, '')
                            .replace(/\{\{packet_title\}\}/g, '')
                            .replace(/\{\{packet_tagNames\}\}/g, '')

                        )
                        .hide();

                    var prevId = $('tr[data-id='+( response.packet.id - 1 )+']', packetBody);
                    if(prevId.get(0)){
                        prevId.before(html);
                    } else {
                        packetBody.prepend(html);
                    }
                    html.fadeIn();

                    checkEmpty();
                } else {
                    alert(response.error);
                }

                if(++uploaded >= $this.prop('files').length)
                {
                    uploadButton.removeClass('disabled');
                    uploadingText.hide();
                    clearInterval(uploadingTextInterval);
                }
            }
        });
    });

    packetBody.on('input propertychange', '.packet-description, .packet-title, .packet-price, .selectized', function(){

        var saveBtn = $(this).siblings('.save-packet-description');
        if(saveBtn.hasClass('disabled')){
            saveBtn.removeClass('disabled').on('click', function(e){
                e.preventDefault();
                var $this = $(this).unbind('click').addClass('disabled');
                var tr = $this.closest('tr');
                var packetId = $this.siblings('.packet-id').val();
                var packetText = $this.siblings('.packet-title').val();
                var packetDesc = $this.siblings('.packet-description').val();
                var packetPrice = $this.siblings('.packet-price').val();
                var packetTag = $this.siblings('input[name^=tag_name]').val();
                console.log($this.attr('href'));
                $.post(
                    $this.attr('href'),
                    {id: packetId, description: packetDesc, title: packetText, tagNames: packetTag, price: packetPrice},
                    function(response){
                        if(response.result === 'success'){
                            notify.success(response.message);
                            tr.find('.plugin-box').attr('title', packetText);
                        }
                        else{
                            alert(response.error);
                        }
                    },
                    'json'
                );
                return false;
            });
        }
    });

    packetBody.on('click', '.delete-photo', function(){
        var $this = $(this).addClass('disabled');
        if(confirm($this.attr('title')+'?')){
            $.getJSON($this.attr('href'), function(response){
                $this.removeClass('disabled');
                if(response.result === 'success'){
                    notify.success(response.message);
                    $this.closest('tr').fadeOut(function(){
                        $(this).remove();
                        checkEmpty();
                    });
                } else {
                    alert(response.error);
                }
            });
        }
        return false;
    });

    function checkEmpty(){
        var table = packetBody.parent();
        if(packetBody.find('tr').length) {
            if(!table.is(':visible')) {
                table.show();
                $('.empty').hide();
            }
        }
        else{
            table.hide();
            $('.empty').show();
        }
    }


    var dots = 0;
    function dotsAnimation() {
        dots = ++dots % 4;
        $("span", uploadingText).html(Array(dots+1).join("."));
    }

});