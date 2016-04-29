(function() {
    this.Dialog = (function() {
        function Dialog() {}
        Dialog.confirm = function(msg, url){
            var modal = $('<div class="ui basic modal small"><div class="content"><p>' + msg + '</p></div><div class="actions"><div class="ui red basic cancel inverted button"><i class="remove icon"></i>取消</div><div class="ui green ok inverted button"><i class="checkmark icon"></i>确认</div></div></div>');
            modal.appendTo($('body')).modal('show');
        }
        Dialog.modal = function(url){
            var modal = $('<div class="ui basic modal small"><div class="content"><p>' + msg + '</p></div><div class="actions"><div class="ui red basic inverted button"><i class="remove icon"></i>取消</div><div class="ui green basic inverted button"><i class="checkmark icon"></i>确认</div></div></div>');
            modal.appendTo($('body')).modal('show');
        }
        return Dialog;
    })();
}).call(this);

