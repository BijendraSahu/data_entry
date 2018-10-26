@extends('admin_master')

@section('title','List of Advertisement')

@section('content')
    <style>
        .ads_img {
            height: 100px;
            width: 100px;
        }
    </style>
    <div class="container-fluid">
        <div class="container-fluid">
            <div class="col-sm-6">

                <div class='form-group'>
                    <img src="{{url('')}}" alt="" class="ads_img">
                </div>
            </div>
            <div class="col-sm-6">
                <div class='form-group' id="file_link">
                    {!! Form::label('Name', 'Student Name *', ['class' => 'col-sm-2 control-label']) !!}
                    <div class='col-sm-10'>
                        <input type="text" placeholder="Student Name" maxlength="25" name="s_name"
                               class="form-control required abc textWithSpace" id="s_name">
                    </div>
                </div>
                <div class='form-group'>
                    {!! Form::label('Username', 'Father Name *', ['class' => 'col-sm-2 control-label']) !!}
                    <div class='col-sm-10'>
                        <input type="text" placeholder="Father Name" maxlength="25" name="f_name"
                               class="form-control required abc textWithSpace" id="f_name">
                    </div>
                </div>

                <div class='form-group'>
                    <div class='col-sm-offset-2 col-sm-10'>
                        {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-primary']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <script>
        function inactive_ads(dis) {
            var id = $(dis).attr('id');
            $('#myModal').modal('show');
            $('#mybody').html('<img height="50px" class="center-block" src="{{ url('assets/images/loading.gif') }}"/>');
            $('#modal_title').html('Confirm Inactivation');
            $('#mybody').html('<h5>Are you sure want to Inactivate this Advertisement<h5/>');
            $('#modalBtn').removeClass('hidden');
            $('#modalBtn').html('<a class="btn btn-sm btn-danger" href="{{ url('advertisement') }}/' + id +
                '/inactivate"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirm</a>'
            );
        }

        function active_ads(dis) {
            var id = $(dis).attr('id');
            $('#myModal').modal('show');
            $('#mybody').html('<img height="50px" class="center-block" src="{{ url('assets/img/loading.gif') }}"/>');
            $('#modal_title').html('Confirm Activation');
            $('#mybody').html('<h5>Are you sure want to activate this Advertisement<h5/>');
            $('#modalBtn').removeClass('hidden');
            $('#modalBtn').html('<a class="btn btn-sm btn-success" href="{{ url('advertisement') }}/' + id +
                '/activate"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirm</a>'
            );
        }

        function edit_ads(dis) {
            $('#myModal').modal('show');
            $('#modal_title').html('Edit Advertisement');
            $('#mybody').html('<img height="50px" class="center-block" src="{{url('assets/images/loading.gif')}}"/>');
            var id = $(dis).attr('id');
            var editurl = '{{ url('/') }}' + "/advertisement/" + id + "/edit";
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: editurl,
                data: '{"data":"' + id + '"}',
                success: function (data) {
                    $('#mybody').html(data);
                },
                error: function (xhr, status, error) {
                    $('#mybody').html(xhr.responseText);
                    //$('.modal-body').html("Technical Error Occured!");
                }
            });
        }


        function add_ads() {
            $('#myModal').modal('show');
            $('#modal_title').html('Add New Advertisement');
            $('#mybody').html('<img height="50px" class="center-block" src="{{url('assets/images/loading.gif')}}"/>');
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: "{{ url('advertisement/create') }}",
                success: function (data) {
                    $('#mybody').html(data);
                },
                error: function (xhr, status, error) {
                    $('#mybody').html(xhr.responseText);
                }
            });
        }

    </script>
@stop
