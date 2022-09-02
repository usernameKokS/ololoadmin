@extends('layouts.layout')

@section('content')
    <filter-page :sites="{{$sites}}" :_cities="{{$cities}}"></filter-page>
@endsection
