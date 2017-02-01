<form id="admin-form" class="form-horizontal" action="{{ action($controller."@index", ["action" => "update", 'id' => $instance->id]) }}" method="POST" enctype="multipart/form-data">
    <div class="box-body">
        @foreach ($instance->getEditableFields() as $field)
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
                        <input name="{{ $field->name }}[{{ $element->id }}]" type="checkbox" @if($instance->inManyRelation($field, $element->id)) checked="checked"@endif>
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
                <img class="preview {{ $field->name }}"  src="{{ $instance->getFieldValue($field) }}" style="width:100%"/>
            </div>
            @else
            <div class="col-sm-10">
            <input class="form-control" name="{{ $field->name }}" placeholder="{{ $field->description }}" type="text" value="{{ $instance->getFieldValue($field) }}">
            </div>
            @endif
        </div>
        @endforeach
    </div>
</form>

