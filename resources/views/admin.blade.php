@extends('layout')
@section('content')
    <div class="container mx-auto">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <admin-page :resources="{{$resources}}"></admin-page>
            </div>
        </div>
    </div>

@endsection

