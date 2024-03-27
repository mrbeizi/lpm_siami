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
        <a href="{{route('a-ami-implementation.index')}}">@yield('title')</a>
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
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                @foreach($search as $d) @endforeach 
                                <small class="text-muted"> as auditor of: Faculty of {{$d->faculty_name}} - Department of {{$d->department_name}}</small>
                            </div>
                        </div>
                            <table class="table table-hover table-responsive" id="table_amidocs">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Document Name</th>
                                  <th>State</th>
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
                    url: "{{ route('a-ami-implementation.index') }}",
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
                    {data: 'state',name: 'state'},
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

    $('select[name="id_faculty"]').on('change', function() {
        $('#id_department').empty();
        var facultyID = $(this).val();
        if(facultyID) {
            $.ajax({
                url: '{{route("a-list-faculties", ":id")}}'.replace(":id", facultyID),
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

    //TOMBOL TAMBAH/UPLOAD DATA
    $('body').on('click','.upload', function(){
        var data_id = $(this).data('id');
        var id_docim = $(this).data('data-iddocs');
        $('#form-tambah-edit').trigger("reset");
        $('#modal-judul').html("Add new data");
        $('#tambah-edit-modal').modal('show');
        $('#id').val(data_id);

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
                    url: "{{ route('a-ami-implementation.store') }}",
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

</script>

@endsection