@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">对话列表</div>
                    <div class="panel-body">
                        @foreach($messages as $messageGroup)
                            <div class="media">
                                <div class="media-left">
                                    <a href="javascript:viow(0)">
                                        <img width="50" src="{{ $messageGroup->fromUser->avatar }}" >
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="javascript:viow(0)">
                                            {{ $messageGroup->fromUser->name }}
                                        </a>
                                    </h4>
                                    <p>
                                        {{ $messageGroup->body }}
                                        <span class="pull-right">{{ $messageGroup->created_at->format('Y-m-d') }}</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                            <form action="/inbox/{{ $dialogId }}/store" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <textarea name="body" class="form-control"></textarea>
                                </div>
                                <div class="form-group pull-right">
                                    <button class="btn btn-success">发送</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
