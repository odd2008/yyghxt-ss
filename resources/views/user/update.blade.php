@extends('layouts.base')
@section('css')
    <link href="https://cdn.bootcss.com/select2/4.0.4/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">更新</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'update-users')
                        <a href="{{route('users.index')}}" class="btn-sm btn-info">返回</a>
                    @endability
                </div>
            </div>
        </div>
        <form action="{{route('users.update',$user->id)}}" method="post" class="users-form form-horizontal">
            {{csrf_field()}}
            {{method_field('PUT')}}
            @include('user.form')
        </form>
    </div>
@endsection

@section('javascript')
    <script src="https://cdn.bootcss.com/select2/4.0.4/js/select2.full.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#hospital').select2();
            $('#office').select2();
            $('#role').select2();
            //change offices on hospital change
            $("#hospital").on('change',function(){
                var selectedHospitals=$("#hospital").select2('data');
                var hospitals=new Array();
                for (var i=0;i<selectedHospitals.length;i++){
                    hospitals[i]=selectedHospitals[i].id;
                }
                $.ajax({
                    url: '/api/get-offices-from-hospitals',
                    type: "post",
                    data: {'hospitals':hospitals,'_token': $('input[name=_token]').val()},
                    success: function(data){
                        $("#office").empty();
                        if(data.status){
                            var html='';
                            for (var json2 in data.data){
                                html += "<optgroup label=\""+data.data[json2]['hospital']+"\">";
                                for (var j=0;j<data.data[json2]['offices'].length;j++){
                                    html += "<option value=\""+data.data[json2]['offices'][j].id+"\">"+data.data[json2]['offices'][j].display_name+"</option>";
                                }
                                html += "</optgroup>";
                            }
                            $("#office").append(html);
                        }
                    }
                });
            });
        });
    </script>
@endsection



