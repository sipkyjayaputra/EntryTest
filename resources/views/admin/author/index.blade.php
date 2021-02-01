@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="d-flex justify-content-end">
    <div class="pr-3">
        <a href="/home"><span class="fa fa-sm fa-chart-line"></span> dashboard</a> / <span class="fa fa-sm fa-users"></span> Author
    </div>
</div>
@stop


@section('sidebar_top')
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="{{ asset('image/user.jpg') }}" class="img-circle elevation-2" alt="User Image" min-width="60px" min-height="60px">
    </div>
    <div class="info">
      <a href="#" class="d-block">{{ Auth::user()->name }}</a>
      <span class=""></span>
    </div>
</div>
@endsection

@section('content')
<div class="col">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col align-self-start">
                    <h3>Author</h3>
                </div>
                <div class="col align-self-end">
                    <div class=" d-flex justify-content-end">
                        <a href="{{ route('author.create') }}" class="btn add btn-primary" title="New Data"><i class="fa fa-plus mr-2"></i> New Data</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="table-author" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="modalButtonSave">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script type="text/javascript">
    $(function () {
        //Datatable Load Data
        var table = $('#table-author').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('author.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'address', name: 'address'},
                {data: 'action', name: 'action'}
            ]
        });
    });

    //Add author
    $('body').on('click', '.add', function(event) {
        event.preventDefault();

        var me = $(this),
            url = me.attr('href'),
            title = me.attr('title');

        $('#modalLabel').text(title);
        $('#modalButtonSave').show().text('Create');

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(response){
                $('#modalBody').html(response);
            }
        })

        $('#modal').modal('show');
    });

    //Click Button Modal
    $('body').on('click', '#modalButtonSave', function(event){
        event.preventDefault();

        var form = $('#modalBody form'),
            url = form.attr('action'),
            method = $('input[name=method]').val() == undefined ? 'POST' : 'PUT';

            console.log(url + ' ' + method);

        form.find('.help-block').remove();
        form.find('.form-control').removeClass('is-invalid');

        $.ajax({
            url: url,
            method: method,
            data: form.serializeArray(),
            success: function(response) {
                form.trigger('reset');
                $('#modal').modal('hide');
                $('#table-author').DataTable().ajax.reload();

                swal('Success!', 'Data  has been saved!', 'success');
            },
            error: function(xhr) {
                var res = xhr.responseJSON;
                console.log(res);
                if($.isEmptyObject(res) == false) {
                    $.each(res.errors, function(key, value) {
                        $('#'+key)
                            .closest('.form-group')
                            .addClass('has-error')
                            .append('<span class="help-block text-danger"><strong>' + value + '</strong></span>');
                        $('#'+key)
                            .closest('.form-control')
                            .addClass('is-invalid');
                    })
                }
            }
        })
    });

    //Show Author Detail
    $('body').on('click', '.show-button', function(event) {
        event.preventDefault();

        var me = $(this),
            url = '/author/show/'+ me.data('id'),
            title = me.attr('title');

        $('#modalLabel').text(title);
        $('#modalButtonSave').hide();
        console.log('running');

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(response){
                $('#modalBody').html(response);
            }
        })

        $('#modal').modal('show');
    });

    //Edit Coffee
    $('body').on('click', '.edit', function(event) {
        event.preventDefault();

        var me = $(this),
            url = '/author/edit/' + me.data('id'),
            title = me.attr('title');

        $('#modalLabel').text(title);
        $('#modalButtonSave').show();
        $('#modalButtonSave').text('Update');

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(response){
                $('#modalBody').html(response);
            }
        })

        $('#modal').modal('show');
    });

    //Delete Coffee
    $('body').on('click', '.delete', function(event) {
        event.preventDefault();

        var me = $(this),
            url = '/author/delete/'+ me.data('id'),
            title = me.attr('title'),
            csrf_token = $('meta[name="csrf-token"]').attr('content');

        swal({
            title: 'Are you sure want to delete ' + title + ' ?',
            text: 'You wont\'t be able to revert this!',
            icon: 'warning',
            dangerMode: true,
            buttons: true
        }).then((result) => {
            if(result){
                $.ajax({
                    url : url,
                    type: 'POST',
                    data: {
                        '_method' : 'DELETE',
                        '_token' : csrf_token,
                    },
                    success: function (response) {
                        $('#table-author').DataTable().ajax.reload();
                        swal({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Data has been deleted!'
                        });
                    },
                    error: function (xhr) {
                        swal({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Something went wrong'
                        });
                    }
                })
            }else{

            }
        })
    });
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stop
