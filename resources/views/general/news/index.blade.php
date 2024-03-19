@extends('layouts.backend')
@section('title','Data News')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('data-faculty.index')}}">@yield('title')</a>
      </li>
      <li class="breadcrumb-item active">Data</li>
    </ol>
</nav>
</div>
@endsection

@section('content')

<div class="container flex-grow-1">
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- MULAI TOMBOL TAMBAH -->
                        <div class="mb-3">
                            <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" id="tombol-tambah"><button type="button" class="btn btn-primary"><i class="bx bx-plus-circle bx-spin-hover"></i> New data</button></a>
                        </div>
                        
                        <!-- AKHIR TOMBOL -->
                            <table class="table table-hover table-responsive" id="table_news">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Title</th>
                                  <th>Published date</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                            </table>
                        </div>
                    </div>

                    <!-- MULAI MODAL FORM TAMBAH/EDIT-->
                    <div class="modal fade" id="tambah-edit-modal" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-judul"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                                        <div class="row">
                                            <input type="hidden" id="id" name="id">
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="title" name="title" value="" placeholder="Type here to input title" />
                                                <span class="text-danger" id="facultyNameErrorMsg" style="font-size: 10px;"></span>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="publish_date" class="form-label">Publish date</label>
                                                            <input type="date" class="form-control" id="publish_date" name="publish_date" value="" placeholder="mm/dd/yyyy" />
                                                            <span class="text-danger" id="publishDateErrorMsg" style="font-size: 10px;"></span>
                                                        </div>                                                        
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="end_date" class="form-label">End date</label>
                                                            <input type="date" class="form-control" id="end_date" name="end_date" value="" placeholder="mm/dd/yyyy" />
                                                            <span class="text-danger" id="endDateErrorMsg" style="font-size: 10px;"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label>Attachment</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="attachment" name="attachment" value="" placeholder="e.g https://uvers.ac.id/" />
                                                    <div id="defaultFormControlHelp" class="form-text">*link berita web LPM UVERS</div>
                                                </div>
                                                <span class="text-danger" id="fileErrorMsg" style="font-size: 10px;"></span>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label for="id_periode" class="form-label">Periode</label>
                                                        <select class="form-select" id="id_periode" name="id_periode" aria-label="Default select example" style="cursor:pointer;">
                                                            <option value="" id="choose_periode">- Choose -</option>
                                                            <option value="1">2024</option>
                                                        </select>
                                                        <span class="text-danger" id="periodeErrorMsg" style="font-size: 10px;"></span>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label>Role:</label>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="col-sm">
                                                            @foreach($getRole as $role)
                                                            <div class="form-check mt-0">
                                                              <input class="form-check-input" type="checkbox" value="{{$role->id}}" id="role_id" name="role_id[]" />
                                                              <label class="form-check-label" for="role_id">{{$role->role_name}}</label>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>                                            
                                            
                                            <div class="col-sm-offset-2 col-sm-12">
                                                <hr class="mt-2">
                                                <div class="float-sm-end">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan" value="create">Save</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- AKHIR MODAL -->
                    
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@section('script')

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    // DATATABLE
    $(document).ready(function () {
        var table = $('#table_news').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('data-news.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'title',name: 'title'},
                {data: 'publish_date',name: 'publish_date'},
                {data: 'action',name: 'action'},
            ]
        });
    });

    //TOMBOL TAMBAH DATA
    $('#tombol-tambah').click(function () {
        $('#button-simpan').val("create-post");
        $('#id').val('');
        $('#form-tambah-edit').trigger("reset");
        $('#modal-judul').html("Add new data");
        $('#tambah-edit-modal').modal('show');
    });

    // TOMBOL TAMBAH
    if ($("#form-tambah-edit").length > 0) {
        $("#form-tambah-edit").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-simpan').val();
                $('#tombol-simpan').html('Saving..');

                $.ajax({
                    data: $('#form-tambah-edit').serialize(),
                    url: "{{ route('data-news.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        $('#table_news').DataTable().ajax.reload(null, true);
                        Swal.fire({
                            title: 'Good job!',
                            text: 'Data saved successfully!',
                            type: 'success',
                            customClass: {
                            confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false,
                            timer: 2000
                        })
                    },
                    error: function(response) {
                        $('#roleNameErrorMsg').text(response.responseJSON.errors.role_name);
                        $('#tombol-simpan').html('Save');
                        Swal.fire({
                            title: 'Error!',
                            text: 'Data failed to save!',
                            type: 'error',
                            customClass: {
                            confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false,
                            timer: 2000
                        })
                    }
                });
            }
        })
    }

    // EDIT DATA
    $('body').on('click', '.edit-post', function () {
        var data_id = $(this).data('id');
        $.get('data-news/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#title').val(data.title);
            $('#publish_date').val(data.publish_date);
            $('#end_date').val(data.end_date);
            $('#role_id').val(data.role_id);
            $('#id_periode').val(data.id_periode);
        })
    });

    // TOMBOL DELETE
    $(document).on('click', '.delete', function () {
        dataId = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "It will be deleted permanently!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url: "data-news/" + dataId,
                        type: 'DELETE',
                        data: {id:dataId},
                        dataType: 'json'
                    }).done(function(response) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Your data has been deleted.',
                            type: 'success',
                            timer: 2000
                        })
                        $('#table_news').DataTable().ajax.reload(null, true);
                    }).fail(function() {
                        Swal.fire({
                            title: 'Oops!',
                            text: 'Something went wrong with ajax!',
                            type: 'error',
                            timer: 2000
                        })
                    });
                });
            },
        });
    });

    $('#choose_role').attr('disabled', 'disabled');

</script>

@endsection