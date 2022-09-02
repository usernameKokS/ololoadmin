@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <escort-trans></escort-trans>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <tariff></tariff>
            <user-stats></user-stats>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <accounts :sites="{{$sites}}"></accounts>
        </div>
    </div>

    <card-stats></card-stats>

    <!-- Row -->
    <div class="row">
        <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
            <ads-table></ads-table>
        </div>
        <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
            <comparision></comparision>
        </div>
    </div>
    <!-- Row -->
@endsection
