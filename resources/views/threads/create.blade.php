@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @lang('thread.create')</div>
                    <div class="card-body">
                        <form method="post" action="/threads">
                            @csrf
                            <div class="form-group">
                                <label for="title">
                                    @lang('thread.title')</label>
                                    <input type="text" class="form-control" placeholder="@lang('thread.placeholder')" name="title" value="{{old('title')}}" required>
                            </div>
                            <div class="form-group">
                                <label for="channel_id">
                                    @lang('thread.channel_id')</label>
                                    <select class="form-control" name="channel_id" id="channel_id" required>
                                        <option value="">@lang('thread.choose_channel')</option>
                                        @foreach ($channels as $channel)
                                        <option value="{{$channel->id}}" {{old('channel_id')==$channel->id?'selected':''}}>{{$channel->name}}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="form-group">
                                <label for="body">
                                    @lang('thread.body')</label>
                                    <textarea class="form-control" name="body" id="editor" value="{{old('body')}}" rows="10" required></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @lang('thread.submit')</button>
                            </div>
                            @if(count($errors))
                            <ul class="list-group-item">
                                @foreach($errors->all() as $error)
                                    <li class="list-group-item list-group-item-danger">{{$error}}</li>
                                    @endforeach
                            </ul>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
