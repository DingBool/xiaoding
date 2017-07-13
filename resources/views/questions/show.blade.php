@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $question->title }}
                        <div class="panel-heading">
                            标签:
                            @foreach($question->topics as $topic)
                                <a class="topics" href="{{ url('/topic/') }}/{{ $topic->id  }}">{{ $topic->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="panel-body">
                        {{--You are logged in!--}}
                        {!! $question->body !!}
                    </div>
                    <div class="panel-heading">
                        <div class="actions">
                            @if(Auth::check() && Auth::user()->owns($question))
                                <span class="edit">
                                <a href="{{ url('/questions/'.$question->id.'/edit') }}">编辑</a>
                            </span>
                                <form action="{{ url('/questions/') }}/{{ $question->id }}" method="post" class="delete-form">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button class="button is-naked delete-button">
                                        删除
                                    </button>
                                </form>
                            @endif
                            <comments type="question" model="{{ $question->id }}" count="{{ $question->comments()->count() }}" ></comments>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h2>{{ $question->followers_count }}</h2>
                        <span>关注者</span>
                    </div>
                    <div class="panel-body text-center">
                        @if(Auth::check())
                            {{--<a href="{{ url('/question').'/'.$question->id.'/follow' }}" class="btn btn-default {{ Auth::user()->followed($question->id) ? 'btn-success' : '' }}">--}}
                                {{--{{ Auth::user()->followed($question->id) ? '已关注' : '关注该问题' }}--}}
                            {{--</a>--}}
                            <question-follow-button question="{{ $question->id }}" ></question-follow-button>
                            <a href="javascript:void (0)" class="btn btn-primary">撰写答案</a>
                        @else
                            <a href="{{ url('login') }}" class="btn btn-default ">请登陆后在来关注该问题</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading">
                            {{ $question->answers_count }}个答案
                        </div>
                    </div>
                    <div class="panel-body">
                        @if($question->answer)
                            @foreach($question->answer as $answers)
                                <div class="media">
                                    <div class="media-left">
                                        <a href="javascript:void(0)">
                                            <img width="36" src="{{ $answers->user['avatar'] }}" alt="{{ $answers->user['name'] }}">
                                        </a>
                                        <user-vote-button answer="{{ $answers->id }}" count="{{ $answers->votes_count }}" ></user-vote-button>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <a href="{{ url('/user/'.$answers->user['id']) }}">
                                                {{ $answers->user['name'] }}
                                            </a>
                                        </h4>
                                        {!! $answers->body !!}
                                    </div>
                                    <comments type="answer" model="{{ $answers->id }}" count="{{ $answers->comments()->count() }}" ></comments>
                                </div>
                            @endforeach
                        @endif
                        @if(Auth::check())
                        <form action="{{ url('question/'.$question->id.'/answer') }}" method="post" >
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('body') ? ' has-error' : '' }}">
                                <script id="container" name="body" type="text/plain">{!! old('body') !!} </script>
                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success pull-right">提交答案</button>
                        </form>
                            @else
                                <a href="{{ url('/login') }}" class="btn btn-success btn-block" >登陆提交答案</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h2>关于作者</h2>
                    </div>
                    <div class="panel-body text-center">
                        <div class="media">
                            <div class="media-left">
                                <a href="javascript:vide(0)">
                                    <img width="36" src="{{ $question->user->avatar }}" alt="{{ $question->user->name }}">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="javascript:vido(0)">
                                        {{ $question->user->name }}
                                    </a>
                                </h4>
                            </div>
                            <div class="user-statics">
                                <div class="statics-item text-center">
                                    <div class="statics-text">问题</div>
                                    <div class="statics-count">{{ $question->user->questions_count }}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">回答</div>
                                    <div class="statics-count">{{ $question->user->arswers_count }}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">关注者</div>
                                    <div class="statics-count">{{ $question->user->followers_count }}</div>
                                </div>
                            </div>
                        </div>
                        @if(Auth::check())
                            {{--<a href="{{ url('/question').'/'.$question->id.'/follow' }}" class="btn btn-default {{ Auth::user()->followed($question->id) ? 'btn-success' : '' }}">--}}
                            {{--{{ Auth::user()->followed($question->id) ? '已关注' : '关注该问题' }}--}}
                            {{--</a>--}}
                            <user-follow-button user="{{ $question->user_id }}" ></user-follow-button>
                            <send-message user="{{ $question->user_id }}"></send-message>
                        @else
                            <a href="{{ url('login') }}" class="btn btn-default ">请登陆后在来关注该问题</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @include('vendor.ueditor.assets')
    <script type="text/javascript">
        $(document).ready(function() {
            var ue = UE.getEditor('container');
            ue.ready(function() {
                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
            });
        });
    </script>
@endsection