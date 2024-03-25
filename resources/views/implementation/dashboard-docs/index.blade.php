@extends('layouts.backend')
@section('title','Data AMI Documents')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('ami-implementation.index')}}">@yield('title')</a>
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
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <fieldset class="form-group">
                                    <select class="select2 form-control border border-primary" id="id_faculty" name="id_faculty" aria-label="Default select example" style="cursor:pointer;">
                                        <option value="" id="choose_faculty">- Choose faculty -</option>
                                        @foreach($getFaculty as $faculty)
                                            <option value="{{$faculty->id}}">{{$faculty->faculty_name}}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-sm-3">
                                <fieldset class="form-group">
                                    <select class="select2 form-control border border-primary" id="id_department" name="id_department" aria-label="Default select example" style="cursor:pointer;">
                                        <option value="" class="d-none">- Choose department -</option>
                                    </select>
                                </fieldset>
                            </div>
                        </div>
                        <hr>
                            <table class="table table-hover table-responsive" id="table_amidocs">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Document Name</th>
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
                                                <label for="fdi_name" class="form-label">Document Name</label>
                                                <input type="text" class="form-control" id="fdi_name" name="fdi_name" value="" placeholder="e.g SK Auditor" />
                                                <span class="text-danger" id="fdiNameErrorMsg" style="font-size: 10px;"></span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="id_category" class="form-label">Category</label>
                                                <select class="form-select" id="id_category" name="id_category" aria-label="Default select example" style="cursor:pointer;">
                                                    <option value="" id="choose_category">- Choose -</option>
                                                    <option value="1">SK Auditor</option>
                                                    <option value="2">Form Monitoring</option>
                                                </select>
                                                <span class="text-danger" id="idCategoryErrorMsg" style="font-size: 10px;"></span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="file" class="form-label">Upload Document</label>
                                                <div class="form-group">
                                                    <input id="file" type="file" name="file" data-preview-file-type="any" class="file form-control" required data-upload-url="#">
                                                    <div id="defaultFormControlHelp" class="form-text">*.pdf (max. 2MB)</div>
                                                </div>
                                                <span class="text-danger" id="fileErrorMsg"></span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="link" class="form-label">Link</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="link" name="link" value="" placeholder="e.g https://uvers.ac.id/" />
                                                    <div id="defaultFormControlHelp" class="form-text">*link document (google drive)</div>
                                                </div>
                                                <span class="text-danger" id="linkErrorMsg" style="font-size: 10px;"></span>
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
        fill_datatable();
        function fill_datatable(id_department = ''){
            var table = $('#table_amidocs').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('ami-implementation.index') }}",
                    type: "GET",
                    data: {
                        "id_department": id_department
                    }
                },
                columns: [
                    {data: null,sortable:false,
                        render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, 
                    {data: 'doc_name',name: 'doc_name'},
                    {data: 'action',name: 'action'},
                ]
            });

            $('#id_department').on('change', function(e){
            var optionSelected = $("option:selected", this);
            var idDepartmentSelected = this.value;

            if(idDepartmentSelected != ''){
                $('#table_amidocs').DataTable().destroy();
                fill_datatable(idDepartmentSelected);
            } else {
                $('#table_amidocs').DataTable().destroy();
                fill_datatable();
            }
        });
        }
    });

    //TOMBOL TAMBAH/UPLOAD DATA
    $('body').on('click','.upload', function(){
        var data_id = $(this).data('id');
        var id_docim = $(this).data('data-iddocs');
        alert(data_id);
        $('#form-tambah-edit').trigger("reset");
        $('#modal-judul').html("Add new data");
        $('#tambah-edit-modal').modal('show');

    });

    // TOMBOL TAMBAH
    if ($("#form-tambah-edit").length > 0) {
        $("#form-tambah-edit").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-simpan').val();
                var formData = new FormData($("#form-tambah-edit")[0]);
                $('#tombol-simpan').html('Saving..');

                $.ajax({
                    data: formData,
                    contentType: false,
                    processData: false,
                    url: "{{ route('ami-implementation.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        $('#table_amidocs').DataTable().ajax.reload(null, true);
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
                        $('#docNameErrorMsg').text(response.responseJSON.errors.doc_name);
                        $('#idPeriodErrorMsg').text(response.responseJSON.errors.id_period);
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
        $.get('ami-implementation/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            $('#fdi_name').val(data.fdi_name);
            $('#id_category').val(data.id_category);
            $('#file').val(data.file);
            $('#link').val(data.link);
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
                        url: "ami-implementation/" + dataId,
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
                        $('#table_amidocs').DataTable().ajax.reload(null, true);
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
    $('#choose_faculty').attr('disabled', 'disabled');

    /* Archive */
    function archiveDoc(id,is_archive){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ Route('archiveDoc') }}",
            id: $('.archivedoc'+id+'').val(),
            data:{'is_archive':is_archive,'id':id},
        }).done(function(data, response) {
            $('#table_amidocs').DataTable().ajax.reload(null, true);
            Swal.fire({
                title: 'Success!',
                text: 'Data archived successfully!',
                type: 'success',
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false,
                timer: 2000
            })
        })
    }

    $('select[name="id_faculty"]').on('change', function() {
        $('#id_department').empty();
        var facultyID = $(this).val();
        if(facultyID) {
            $.ajax({
                url: '{{route("list-faculties", ":id")}}'.replace(":id", facultyID),
                type: "GET",
                dataType: "json",
                success:function(data) { 
                    $('select[name="id_department"]').removeClass('d-none');
                    $('select[name="id_department"]').append('<option value="">'+ '- Choose department -' +'</option>');
                    $.each(data, function(key, value) {
                    $('select[name="id_department"]').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        }else{
            $('select[name="id_department"]').removeClass('d-none');
        }
    });

</script>

@endsection