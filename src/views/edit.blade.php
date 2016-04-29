<i class="close icon"></i>
<div class="header">
    修改
</div>
<div class="content">
    <form id="admin-form" class="ui form" action="{{ action($controller."@admin", ["action" => "update", "id" => $instance->id]) }}" method="POST">
        @foreach ($instance->getEditableColumns() as $column)
        <div class="field">
            <label>{{ $column->description }}</label>
            @if ($column->type == 'boolean')
            <select class="ui dropdown " name="{{ $column->name }}">
                <option selected value="1"></option>
            </select>
            @else 
            <input name="{{ $column->name }}" placeholder="{{ $column->description }}" type="text" value="{{ $instance->getValue($column->name) }}">
            @endif
        </div>
        @endforeach
    </form>
</div>
<script>
$(function(){
    $('#admin-form .ui.checkbox').checkbox();
    $('#admin-form .ui.dropdown').dropdown();
});
</script>

