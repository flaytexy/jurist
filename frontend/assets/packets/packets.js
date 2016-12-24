$(function(){
    var photosBody = $('#photo-table > tbody');

    photosBody.on('input propertychange', '.packet-description, .packet-title, .packet-price, .selectized', function(){

        var saveBtn = $(this).siblings('.save-packet-description');
        if(saveBtn.hasClass('disabled')){
            saveBtn.removeClass('disabled').on('click', function(e){
                e.preventDefault();
                var $this = $(this).unbind('click').addClass('disabled');
                var tr = $this.closest('tr');
                var packetText = $this.siblings('.packet-title').val();
                var packetDesc = $this.siblings('.packet-description').val();
                var packetPrice = $this.siblings('.packet-price').val();
                var packetTag = $this.siblings('input[name^=tag_name]').val();
                $.post(
                    $this.attr('href'),
                    {description: packetDesc, title: packetText, tagNames: packetTag, price: packetPrice},
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

    photosBody.on('click', '.delete-photo', function(){
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
        var table = photosBody.parent();
        if(photosBody.find('tr').length) {
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


});