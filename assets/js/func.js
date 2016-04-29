var myMessages = ['info','warning','error','success']; // define the messages types    
function hideAllMessages()
{
    var messagesHeights = new Array(); // this array will store height for each

    for (i=0; i<myMessages.length; i++)
        {
            messagesHeights[i] = $('.message.' + myMessages[i]).outerHeight();
            $('.' + myMessages[i]).remove();
        }
}

function showMessage(type, msg){
    $('.container').prepend('<div class="'+ type +' message"><h3 style="display:inline;">' + msg + '</h3><i class="close icon message-close" style="float:right;"></i></div>');
    $('.message-close').click(function(){
        hideAllMessages();
    });
    setTimeout(function(){
        hideAllMessages();
    },10000);
}

(function() {
    this.Dialog = (function() {
        function Dialog() {}
        Dialog.confirm = function(msg, url){
            var modal = $('<div class="ui basic modal small"><div class="content"><p>' + msg + '</p></div><div class="actions"><div class="ui red basic cancel inverted button"><i class="remove icon"></i>取消</div><div class="ui green ok inverted button"><i class="checkmark icon"></i>确认</div></div></div>');
            modal.appendTo($('body')).modal({
                onHidden: function(){
                    $(this).remove();
                },
                onApprove: function(){
                    $.post(url, function(ret){
                        location.reload();
                    });
                }
            }).modal('show');
        }
        Dialog.modal = function(url){
            var modal;
            $.get(url, function(ret){
                modal = $('<div class="ui modal">' + ret + '<div class="actions"><div class="ui black deny button">取消</div><div class="ui positive right labeled icon button">确定<i class="checkmark icon"></i></div></div></div>');
                modal.appendTo($('body')).modal({
                    onHidden: function(){
                        $(this).remove();
                    },
                    onApprove: function(){
                        console.log('!!!');
                        modal.find('form').ajaxSubmit({
                            success: function(data){
                                // if(data.status){
                                    location.reload();
                                // }else{
                                // }
                            }
                        });
                    }
                }).modal('show');
            });
        }
        return Dialog;
    })();
}).call(this);

