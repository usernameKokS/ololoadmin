@extends('layouts.layout')

@section('content')
    <!-- Row -->
    <div class="row">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    @if(sizeof($list) > 0)
                    <table class="table">
                        <tr>
                            <td>Ид</td>
                            <td>Телефон</td>
                            <td>Имя</td>
                            <td>Возраст</td>
                            <td>Заголовок</td>
                            <td></td>
                        </tr>
                        @foreach($list as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->phone }}</td>
                                <td>{{ $post->name }}</td>
                                <td>{{ $post->age }}</td>
                                <td>{{ $post->title }}</td>
                                <td><a class="btn btn-success" href="/to-verify/{{ $post->id }}/">Модерировать</a></td>
                            </tr>
                        @endforeach
                    </table>
                    @else
                        Нет объявлений требующих модерации =)
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
@endsection