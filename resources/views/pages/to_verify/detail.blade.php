@extends('layouts.layout')

@section('content')
    <!-- Row -->
    <div class="row">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <postcreate :user="{{ $user }}" :cats="{{ $cats }}" :post="{{ $post }}"
                        :catspasion="{{ json_encode($catsPasion) }}"
                        :statuses="{{ $statuses }}"
                        :currenttariffs="{{ json_encode($currentTariffs) }}"
                        :oldrates="{{ $rates }}"
                        :oldservices="{{ $services }}"
                        :oldremains="{{ $remains }}"
                        :places="{{ $places }}"
                        :edit="true"
                    ></postcreate>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection