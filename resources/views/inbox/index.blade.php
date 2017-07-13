@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">私信</div>
                    <div class="panel-body">
                        @foreach($messages as $messageGroup)
                            <div class="media {{ $messageGroup->first()->shouldAppUnreadClass() ? 'unread' : '' }}">
                                <div class="media-left">
                                    <a href="javascript:viow(0)">
                                        @if(Auth::id() == $messageGroup->last()->form_user_id)
                                            <img width="50" src="{{ $messageGroup->last()->toUser->avatar }}" >
                                        @else
                                            <img width="50" src="{{ $messageGroup->last()->fromUser->avatar }}" >
                                        @endif
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="javascript:viow(0)">
                                            @if(Auth::id() == $messageGroup->last()->form_user_id)
                                                {{ $messageGroup->last()->toUser->name }}
                                            @else
                                                {{ $messageGroup->last()->fromUser->name }}
                                            @endif
                                        </a>
                                    </h4>
                                    <p>
                                        <a href="/inbox/{{ $messageGroup->first()->dialog_id }}">
                                            {{ $messageGroup->first()->body }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
