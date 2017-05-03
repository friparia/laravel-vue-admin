@extends('admin::layout')
@section('title', $instance->getTitle())
@section('content')
    <div class="row">
        <div class="sixteen wide column">
            <div class="ui segments">
                <div class="ui segment">
                    <h5 class="ui header">
                        Datatable
                    </h5>
                </div>
                <div class="ui segment">
                    <div class="ui grid">
                        <div class="two wide column">
                        </div>
                        <div class="fourteen wide column right aligned">
                            <form id="search" action="">
                                <div class="ui button action blue search">
                                    <i class="search icon"></i>
                                    搜索
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="ui segment">
                    <table class="ui compact selectable striped celled table">
                        <thead>
                            <tr>
                                @foreach($instance->getListFields() as $field)
                                    <th>
                                        {{ $field->name }}
                                    </th>
                                @endforeach
                                @if($instance->hasEachAction())
                                    <th>
                                        操作
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                                <tr>
                                    @foreach($instance->getListFields() as $field)
                                        <td>
                                            {{ $item->getFieldValue($field) }}
                                        </td>
                                    @endforeach
                                    @if($instance->hasEachAction())
                                        <td>
                                            @foreach($instance->getEachActions() as $action)
                                                <button class="ui basic button action {{ $action->name }}" data-id="{{ $item->id }}">
                                                    {{ $action->description }}
                                                </button>
                                            @endforeach
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="99">
                                <div class="ui right floated pagination menu">
                                    @if($data->currentPage() > 2)
                                        <a class="item">{{ $data->url(1) }}</a>
                                    @endif
                                    <a class="icon item" href="{{ $data->previousPageUrl() }}">
                                        <i class="left chevron icon"></i>
                                    </a>
                                    @if($data->currentPage() > 2 && $data->currentPage() != 3)
                                        <a class="item">{{ $data->url($data->currentPage() - 2) }}</a>
                                    @endif
                                    @if($data->currentPage() != 1)
                                        <a class="item">{{ $data->url($data->currentPage() - 1) }}</a>
                                    @endif
                                    <a class="item">{{ $data->currentPage() }}</a>
                                    @if($data->currentPage() + 1 <= $data->total())
                                        <a class="item">{{ $data->url($data->currentPage() + 1) }}</a>
                                    @endif
                                    @if($data->currentPage() + 2 <= $data->total())
                                        <a class="item">{{ $data->url($data->currentPage() + 2) }}</a>
                                    @endif
                                    @if($data->hasMorePages())
                                        <a class="icon item" href="{{ $data->nextPageUrl() }}">
                                            <i class="right chevron icon"></i>
                                        </a>
                                    @endif
                                </div>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
