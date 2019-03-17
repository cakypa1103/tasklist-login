@extends('layouts.app')

@section('content')


    <h1>タスク新規作成ページ</h1>

    <div class="row">
        <div class="col-6">
            {!! Form::model($task, ['route' => 'tasks.store']) !!}
                <div class="form-group">
                    {!! Form::label('content', '内容:') !!}
                    {!! Form::text('content', '', ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('status', 'ステータス:') !!}
                    {!! Form::text('status', '', ['class' => 'form-control']) !!}
                </div>
        
                {!! Form::submit('投稿', ['class' => 'btn btn-primary']) !!}
        
            {!! Form::close() !!}
        </div>
    </div>
@endsection