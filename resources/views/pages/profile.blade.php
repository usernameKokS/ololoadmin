@extends('layouts.layout')

@section('content')
    <!-- Row -->
    <div class="row">
        <div class="col-lg-4 col-xs-12">
            <profile :profile="{{$profile}}"></profile>
        </div>
        <div class="col-lg-8 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div  class="panel-body pb-0">
                        <div  class="tab-struct custom-tab-1">
                            <ul role="tablist" class="nav nav-tabs nav-tabs-responsive" id="myTabs">
                                <li class="active" role="presentation"><a data-toggle="tab" id="map_tab" role="tab" href="#map" aria-expanded="false"><span>Mapa</span></a></li>
                                <li role="presentation" class=""><a data-toggle="tab" id="table_tab" role="tab" href="#table" aria-expanded="false"><span>table</span></a></li>
                                <li role="presentation" class=""><a data-toggle="tab" id="parser_table_tab" role="tab" href="#parser_table" aria-expanded="false"><span>Datos de parsers</span></a></li>
                                <li role="presentation" class=""><a data-toggle="tab" id="forums_tab" role="tab" href="#forums" aria-expanded="false"><span>foros</span></a></li>
                                <li role="presentation" class=""><a data-toggle="tab" id="posts_tab" role="tab" href="#posts" aria-expanded="false"><span>anuncios</span></a></li>
                                <li role="presentation" class=""><a data-toggle="tab" id="photos_tab" role="tab" href="#photos" aria-expanded="false"><span>fotos</span></a></li>
                                <li role="presentation" class=""><a data-toggle="tab" id="settings_tab" role="tab" href="#settings" aria-expanded="false"><span>ajustes</span></a></li>
                            </ul>
                            <div class="tab-content" id="tabsContent">
                                <div id="map" class="tab-pane fade active in" role="tabpanel">
                                    <maps :cities="{{$cities}}"/>
                                </div>
                                <div id="table" class="tab-pane fade" role="tabpanel">
                                    <table-data :table="{{$table}}" />
                                </div>
                                <div id="parser_table" class="tab-pane fade" role="tabpanel">
                                    <parser-data :table="{{$table['table']}}" :parser_links="{{$parser_links}}" />
                                </div>
                                <div id="forums" class="tab-pane fade" role="tabpanel">
                                    <forums :forums="{{$forums}}" />
                                </div>
                                <div id="posts" class="tab-pane fade" role="tabpanel">
                                    <posts :posts="{{$posts}}" :places="{{$places}}" :categories="{{$categories}}" />
                                </div>
                                <div id="photos" class="tab-pane fade" role="tabpanel">
                                    <photos :photos="{{$profile['avatars']}}"/>
                                </div>
                                <div id="settings" class="tab-pane fade" role="tabpanel">
                                    <settings :settings="{{$settings}}" :tel="{{$profile['tel']}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- /Row -->
@endsection

