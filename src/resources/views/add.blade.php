<form id="admin-form" class="form-horizontal" action="{{ action($controller."@index", ["action" => "create"]) }}" method="POST" enctype="multipart/form-data">
    <div class="box-body">
        @foreach ($instance->getCreatableFields() as $field)
        <div class="form-group">
            <label class="col-sm-2 control-label">{{ $field->description }}</label>
            @if ($field->type == 'boolean')
            <div class="ui toggle checkbox">
                <input data-id="{{ $instance->id }}" type="checkbox" name="{{ $field->name }}">
                <label></label>
            </div>
            @elseif($field->type == 'enum')
            <select class="ui dropdown" name="{{ $field->name }}">
                @foreach($field->values as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
            @elseif($field->type == 'many')
            <div class="col-sm-10">
                @foreach($field->elements() as $element)
                <div class="checkbox-inline">
                    <label>
                        <input name="{{ $field->name }}[{{ $element->id }}]" type="checkbox">
                        {{ $element->getValue($field->getDescriptor()) }}
                    </label>
                </div>
                @endforeach
            </div>
            @elseif($field->type == 'belong')
            @elseif($field->isPassword() )
            <div class="col-sm-10">
                <input class="form-control" name="{{ $field->name }}" placeholder="{{ $field->description }}" type="password">
            </div>
            @elseif($field->isImage())
            <div class="col-sm-10">
                <input class="form-control" name="{{ $field->name }}" placeholder="{{ $field->description }}" type="file">
                <img class="preview {{ $field->name }}" style="width:100%"/>
            </div>
            @else
            <div class="col-sm-10">
                <input class="form-control" name="{{ $field->name }}" placeholder="{{ $field->description }}" type="text">
            </div>
            @endif
        </div>
        @endforeach
    </div>
</form>
<script>
$(function(){
    $('#admin-form input[type="file"]').change(function(){
        $that = $(this);
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.preview.'+$that.attr('name')).attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>
