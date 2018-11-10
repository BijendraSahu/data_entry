<script src="{{ url('assets/js/validation.js') }}"></script>
<style>
    .ads_img {
        height: 100%;
        width: 100%;
    }
</style>
@if($errors->any())
    <div role='alert' id='alert' class='alert alert-danger'>{{$errors->first()}}</div>
@endif
<div class="container-fluid">
    <div class="container-fluid">
        <div class="col-sm-6">
            {{--<img src="{{url('').'/'.$work_data->FILENM}}" alt="" class="ads_img">--}}
            <img src="{{url('').'/'.$work_data->IMAGE_PATH}}" alt="" class="ads_img">
{{--            <img src="data:image/png;base64,{{ chunk_split(base64_encode($work_data->IMG)) }}" alt="" class="ads_img">--}}
        </div>
        <div class="col-sm-6">
            <div class='form-group'>
                {!! Form::label('Name', 'Stu. Name :', ['class' => 'col-sm-4 control-label']) !!}
                <div class='col-sm-8'>
                    {!! Form::label('Name', isset($work_data)?$work_data->f103:'') !!}
                </div>
            </div>
            <div class='form-group'>
                {!! Form::label('Username', "F'Name :", ['class' => 'col-sm-4 control-label']) !!}
                <div class='col-sm-8'>
                    {!! Form::label('Username', isset($work_data)?$work_data->f104:'') !!}
                </div>
            </div>
        </div>
    </div>
</div>
