@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    {{--<link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">--}}
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('targets.search')}}"  id="search-form" name="search-form" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="searchDate">年度：</label>
                    <input type="text" class="form-control date-item" name="searchYear" id="searchYear" required value="{{isset($year)?$year:\Carbon\Carbon::now()->year}}">
                </div>
                <button type="submit" class="btn btn-success">搜索</button>
                <hr>

            </form>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 360px;">
                    @ability('superadministrator', 'create-auctions')
                        <a href="{{route('targets.create')}}" class="btn-sm btn-info" style="margin-right: 10px;">添加</a>
                        <a href="{{route('targets.list')}}" class="btn-sm btn-info" style="margin-right: 10px;">列表</a>
                        <a href="javascript:;" data-toggle="modal" data-target="#importModal" class="btn-sm btn-success" style="margin-right: 10px;">导入</a>
                        <a href="/template/targets.xlsx" class="btn-sm btn-danger">导入模板</a>
                    @endability
                </div>
            </div>
        </div>
        <div class="box-body table-responsive">
            <h3 class="text-center">{{isset($year)?$year:\Carbon\Carbon::now()->year}}年度经营计划表</h3>
            @if(isset($targetdata)&&!empty($targetdata))
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @if(!empty($targetdata))
                        @foreach($targetdata as $office_id=>$v)
                            <li class="{{$loop->first?'active':''}}"><a href="#tab_{{$office_id}}" class="tab-switch" data-toggle="tab" aria-expanded="{{$loop->first?'true':'false'}}">{{$offices[$office_id]}}</a></li>
                        @endforeach
                    @endif
                </ul>
                <div class="tab-content">
                    @if(!empty($targetdata))
                    @foreach($targetdata as $office_id=>$v)
                    <div class="tab-pane table-responsive {{$loop->first?'active':''}}" id="tab_{{$office_id}}">
                        <div class="table-item">
                            <table class="table table-bordered" id="table-{{$office_id}}">
                            <thead class="text-center">
                            <tr>
                                <th colspan="3" class="text-center">总目标</th>
                                <th colspan="7" class="text-center">竞价</th>
                            </tr>
                            <tr>
                                <th class="text-center">月份</th>
                                <th class="text-center">广告宣传</th>
                                <th class="text-center">到院量</th>
                                <th class="text-center">展现</th>
                                <th class="text-center">点击</th>
                                <th class="text-center">总对话</th>
                                <th class="text-center">有效对话</th>
                                <th class="text-center">留联量</th>
                                <th class="text-center">总预约</th>
                                <th class="text-center">总到院</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center">
                            @isset($v['targets'])
                            @foreach($v['targets'] as $target)
                            <tr>
                                <td class="text-center">{{$target->month}}</td>
                                <td class="text-center">{{$target->cost}}</td>
                                <td class="text-center">{{$target->arrive}}</td>
                                <td class="text-center">{{$target->show}}</td>
                                <td class="text-center">{{$target->click}}</td>
                                <td class="text-center">{{$target->achat}}</td>
                                <td class="text-center">{{$target->chat}}</td>
                                <td class="text-center">{{$target->contact}}</td>
                                <td class="text-center">{{$target->yuyue}}</td>
                                <td class="text-center">{{$target->arrive}}</td>
                            </tr>
                            @endforeach
                            @endisset
                            @isset($v['total'])
                            <tr>
                                <td class="text-center">合计</td>
                                <td class="text-center">{{$v['total']['cost']}}</td>
                                <td class="text-center">{{$v['total']['arrive']}}</td>
                                <td class="text-center">{{$v['total']['show']}}</td>
                                <td class="text-center">{{$v['total']['click']}}</td>
                                <td class="text-center">{{$v['total']['achat']}}</td>
                                <td class="text-center">{{$v['total']['chat']}}</td>
                                <td class="text-center">{{$v['total']['contact']}}</td>
                                <td class="text-center">{{$v['total']['yuyue']}}</td>
                                <td class="text-center">{{$v['total']['arrive']}}</td>
                            </tr>
                            @endisset
                            </tbody>
                        </table>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                <!-- /.tab-content -->
            </div>
            @endif
        </div>
        <!-- /.box-body -->
    </div>
    <!-- importModal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel">
        <div class="modal-dialog" role="document">
            <form method="post" class="form-horizontal" action="{{route('targets.import')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title text-center" id="importModalLabel">文件选择</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inInputFile" class="col-sm-2 control-label">文件</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="file" id="inInputFile" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">开始导入</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdn.bootcss.com/dom-to-image/2.6.0/dom-to-image.min.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
    <script type="text/javascript">
        //data item
        lay('.date-item').each(function(){
            laydate.render({
                elem: this,
                trigger: 'click',
                type:'year'
                // value: new Date()
            });
        });
        $(document).ready(function() {
            $(".delete-operation").on('click',function(){
                var id=$(this).attr('data-id');
                layer.open({
                    content: '你确定要删除吗？',
                    btn: ['确定', '关闭'],
                    yes: function(index, layero){
                        $('form.auctions-form').attr('action',"{{route('auctions.index')}}/"+id);
                        $('form.auctions-form').submit();
                    },
                    btn2: function(index, layero){
                        //按钮【按钮二】的回调
                        //return false 开启该代码可禁止点击该按钮关闭
                    },
                    cancel: function(){
                        //右上角关闭回调
                        //return false; 开启该代码可禁止点击该按钮关闭
                    }
                });
            });
        });
        //
        $(".box-body li.active a").each(function () {
            var tabId=$(this).attr('href');
            console.log(tabId);
            $(tabId+" .table-item").each(function () {
                var nodeId=$(this).children('table').attr('id');
                if (typeof(nodeId)!='undefined'){
                    var node = document.getElementById(nodeId);
                    var that=this;
                    domtoimage.toSvg(node,{bgcolor: '#fff'},that)
                        .then(function (dataUrl) {
                            var img = new Image();
                            img.src = dataUrl;
                            img.className= 'img-responsive';
                            node.remove();
                            $(that).append(img);
                        });
                }
            });
        });
        $(".box-body li a").click(function () {
            var tabId=$(this).attr('href');
            $(tabId+" .table-item").each(function () {
                var nodeId=$(this).children('table').attr('id');
                if (typeof(nodeId)!='undefined'){
                    var node = document.getElementById(nodeId);
                    var that=this;
                    domtoimage.toSvg(node,{bgcolor: '#fff'},that)
                        .then(function (dataUrl) {
                            var img = new Image();
                            img.src = dataUrl;
                            img.className= 'img-responsive';
                            node.remove();
                            $(that).append(img);
                        });
                }
            });
        });
        $(".month-sub-option").click(function () {
            var monthSub=$(this).data('month');
            $("input:hidden[name=monthSub]").val(monthSub);
            $("form#search-form").submit();
        });
    </script>
@endsection
