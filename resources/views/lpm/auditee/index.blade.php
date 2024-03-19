@extends('layouts.backend')
@section('title','Data Auditee')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('data-auditee.index')}}">@yield('title')</a>
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
                            <table class="table table-hover table-responsive" id="table_auditee">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Fakultas</th>
                                  <th>Prodi</th>
                                  <th>Auditee</th>
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
                                                <label for="id_periode" class="form-label">Periode</label>
                                                <select class="form-select" id="id_periode" name="id_periode" aria-label="Default select example" style="cursor:pointer;">
                                                    <option value="" id="choose_periode">- Choose -</option>
                                                    <option value="1">2024</option>
                                                </select>
                                                <span class="text-danger" id="periodeErrorMsg"></span>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="id_faculty" class="form-label">Fakultas</label>
                                                <select class="form-select" id="id_faculty" name="id_faculty" aria-label="Default select example" style="cursor:pointer;">
                                                    <option value="">- Choose -</option>
                                                    @foreach($getFaculty as $faculty)
                                                    <option value="{{$faculty->id}}">{{$faculty->faculty_name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger" id="idFacultyErrorMsg" style="font-size: 10px;"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="id_department" class="form-label">Prodi</label>
                                                <select class="select2 form-control" id="id_department" name="id_department" aria-label="Default select example" style="cursor:pointer;">
                                                    <option value="" id="choose_prodi" class="d-none">- Choose -</option>
                                                </select>
                                                <span class="text-danger" id="idDepartmentErrorMsg" style="font-size: 10px;"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="dekan" class="form-label">Dekan</label>
                                                <input type="text" class="form-control" id="dekan" name="dekan" value="" />
                                                <span class="text-danger" id="dekanErrorMsg" style="font-size: 10px;"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="sekretaris_dekan" class="form-label">Sekretaris Dekan</label>
                                                <input type="text" class="form-control" id="sekretaris_dekan" name="sekretaris_dekan" value="" />
                                                <span class="text-danger" id="sekretarisDekanErrorMsg" style="font-size: 10px;"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ko_prodi" class="form-label">Koordinator Prodi</label>
                                                <input type="text" class="form-control" id="ko_prodi" name="ko_prodi" value=""/>
                                                <span class="text-danger" id="koProdiErrorMsg" style="font-size: 10px;"></span>
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
        var table = $('#table_auditee').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('data-auditee.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'faculty_name',name: 'faculty_name'},
                {data: 'department_name',name: 'department_name'},
                {data: 'dekan',name: 'dekan'},
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
                    url: "{{ route('data-auditee.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        $('#table_auditee').DataTable().ajax.reload(null, true);
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
                        $('#periodeErrorMsg').text(response.responseJSON.errors.id_periode);
                        $('#idFacultyErrorMsg').text(response.responseJSON.errors.id_faculty);
                        $('#idDepartmentErrorMsg').text(response.responseJSON.errors.id_department);
                        $('#dekanErrorMsg').text(response.responseJSON.errors.dekan);
                        $('#sekretarisDekanErrorMsg').text(response.responseJSON.errors.sekretaris_dekan);
                        $('#koProdiErrorMsg').text(response.responseJSON.errors.ko_prodi);
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
        $.get('data-auditee/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#id_periode').val(data.id_periode);
            $('#id_faculty').val(data.id_faculty);
            $('#id_department').val(data.id_department);
            $('#dekan').val(data.dekan);
            $('#sekretaris_dekan').val(data.sekretaris_dekan);
            $('#ko_prodi').val(data.ko_prodi);
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
                        url: "data-auditee/" + dataId,
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
                        $('#table_auditee').DataTable().ajax.reload(null, true);
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

    $('#choose_periode').attr('disabled', 'disabled');
    $('#choose_prodi').attr('disabled', 'disabled');

    $('select[name="id_faculty"]').on('change', function() {
        $('#id_department').empty();
        var fakultasID = $(this).val();
        $.ajax({
            url: "{{route('list-prodi')}}",
            type: "POST",
            data: {
                id_faculty: fakultasID,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (data) {
                $('select[name="id_department"]').removeClass('d-none');
                $.each(data.department, function(key, value) {
                $('select[name="id_department"]').append('<option value="'+ value.id +'">'+ value.department_name +'</option>');                
                });
            }
        });
    });


</script>

@endsection