@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">更新</h3>
            <div class="box-tools">

            </div>
        </div>
        <form action="{{route('reports.update',$report->id)}}" method="post" class="reports-form form-horizontal">
            {{csrf_field()}}
            {{method_field('PUT')}}
            @include('report.form')
        </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        //data item
        lay('.item-date').each(function(){
            laydate.render({
                elem: this,
                trigger: 'click',
                type:'date'
                // value: new Date()
            });
        });

    </script>
@endsection



