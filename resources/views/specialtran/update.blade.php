@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">更新</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'update-medias')
                        <a href="{{route('medias.index')}}" class="btn-sm btn-info">返回</a>
                    @endability
                </div>
            </div>
        </div>
        <form action="{{route('medias.update',$media->id)}}" method="post" class="medias-form form-horizontal">
            {{csrf_field()}}
            {{method_field('PUT')}}
            @include('media.form')
        </form>
    </div>
@endsection



