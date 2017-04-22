@extends('layouts.app')

@section('content')
<div class="container">
    <example></example>
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
            <passport-clients></passport-clients>
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>
        </div>
    </div>
</div>
@endsection
