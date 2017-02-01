<form id="admin-form" class="ui form" action="{{ action("\Friparia\Admin\Controllers\FeedbackController@index", ["action" => "update", "id" => $feedback->id]) }}" method="POST">
    <input type="hidden" name="is_read" value="on"/>
    {{ $feedback->content }}
</form>

