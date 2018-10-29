@extends('admin_master')

@section('title','Start Work')

@section('content')
    <style>
        .ads_img {
            height: 100%;
            width: 100%;
        }
    </style>
    <div class="row box_containner">
        <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="dash_boxcontainner white_boxlist">
                <div class="upper_basic_heading">
                    <span class="white_dash_head_txt">
                         Enter Given Image Details Below
                      </span>
                    @if(isset($work_data))
                        {!! Form::open(['url' => 'save_work', 'class' => 'form-horizontal', 'id'=>'save_work', 'files'=>true]) !!}
                        <div class="col-sm-5">
                            {{--<div class='form-group'>--}}
                            <img src="{{url('').'/'.$work_data->FILENM}}" alt="" class="ads_img">
                            <input type="hidden" value="{{$work_data->SRID}}" name="data_id" id="data_id">
                            {{--</div>--}}
                        </div>
                        <div class="col-sm-7">
                            <div class='form-group'>
                                {!! Form::label('Name', 'Student Name *', ['class' => 'col-sm-3 control-label']) !!}
                                <div class='col-sm-9'>
                                    <input type="text" value="{{isset($work_value_s_name)?$work_value_s_name->RVAL:''}}"
                                           placeholder="Student Name" maxlength="25" name="s_name"
                                           class="form-control required textWithSpace" id="s_name">
                                </div>
                            </div>
                            <div class='form-group'>
                                {!! Form::label('Username', 'Father Name *', ['class' => 'col-sm-3 control-label']) !!}
                                <div class='col-sm-9'>
                                    <input value="{{isset($work_value_f_name)?$work_value_f_name->RVAL:''}}" type="text"
                                           placeholder="Father Name" maxlength="25" name="f_name"
                                           class="form-control required textWithSpace" id="f_name">
                                </div>
                            </div>

                            {{--<div class='form-group'>--}}
                            {{--<div class='col-sm-offset-2 col-sm-10'>--}}
                            {{--{!! Form::submit('Submit', ['class' => 'btn btn-sm btn-primary']) !!}--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        </div>
                        {!! Form::close() !!}
                    @else
                        <div class="col-sm-12">
                            <span>No Data Available</span>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <br/>
    <script>
        $(document).keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
//                alert('You pressed a "enter" key in somewhere');
                $('#save_work').submit();
            }
        });
        window.onload = function () {
            document.getElementById("s_name").focus();
        };
        //        $('#someTextBox').keypress(function(event){
        //            var keycode = (event.keyCode ? event.keyCode : event.which);
        //            if(keycode == '13'){
        //                alert('You pressed a "enter" key in textbox');
        //            }
        //        });

    </script>
@stop
