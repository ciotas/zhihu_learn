@extends('layouts.app')

@section('content')
<div class="container">
    @include('flash::message')
    {{--<div class="container">--}}
    {{--@if (session()->has('flash_notification.message'))--}}
    {{--<div class="alert alert-{{ session('flash_notification.level') }}">--}}
    {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>--}}

    {{--{!! session('flash_notification.message') !!}--}}
    {{--</div>--}}
    {{--@endif--}}
    {{--</div>--}}
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">控制面板</div>

                <div class="panel-body">
                    你已经登陆!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
