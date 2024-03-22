@extends('layouts.backend')
@section('title','Data Schedule')

@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('data-schedule.index')}}">@yield('title')</a>
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
                <div class="card bg-transparent border border-primary mb-3">
                    <div class="card-body">
                        <p><b>PERHATIAN:</b></p>
                        <p>Jadwal Auditor dan Auditee tidak boleh bentrok.<br>Auditor yang dipilih merupakan:<br>1. Auditor yang bukan berasal dari prodi yang sama dengan Auditee<br>2. Auditor tidak boleh merangkap sebagai Auditee pada prodi yang diaudit oleh Auditor tersebut<br>3. Jadwal pelaksanaan AMI oleh Auditor tidak boleh sama dengan jadwal AMI prodinya.</p>
                    </div>
                </div>
                <h5>Please set the schedule and AMI Auditors:</h5>
                <div class="card">
                    <div class="card-body">
                            <table class="table table-hover table-responsive" id="table_schedule">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Auditee</th>
                                  <th>Schedule</th>
                                  <th>Auditor Chief</th>
                                  <th>Auditor Members</th>
                                  <th>Actions</th>
                                </tr>
                              </thead>
                            </table>
                        </div>
                    </div>

                    <!-- MULAI MODAL FORM TAMBAH/EDIT-->
                    <div class="modal fade" id="tambah-edit-modal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-judul"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                                        <div class="row">
                                            <input type="hidden" id="id" name="id">
                                            <input type="hidden" class="form-control" id="idAuditee" name="idAuditee">

                                            <div class="table-responsive-sm" id="table_data_auditee">
                                                
                                            </div>

                                            <div class="divider">
                                                <div class="divider-text">Set the schedule and AMI Auditors</div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="start_date" class="form-label">Starts date</label>
                                                    <input type="date" class="form-control" id="start_date" name="start_date" value="" placeholder="mm/dd/yyyy" />
                                                    <span class="text-danger" id="startDateErrorMsg" style="font-size: 10px;"></span>
                                                </div> 
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="end_date" class="form-label">Ends date</label>
                                                    <input type="date" class="form-control" id="end_date" name="end_date" value="" placeholder="mm/dd/yyyy" />
                                                    <span class="text-danger" id="endDateErrorMsg" style="font-size: 10px;"></span>
                                                </div> 
                                            </div>

                                            <div class="mb-3">
                                                <label for="auditor_chief" class="form-label">Auditor Chief</label>
                                                <select class="select2 form-control" id="auditor_chief" name="auditor_chief" aria-label="Default select example" style="cursor:pointer;">
                                                    <option value="" readonly>- Choose -</option>
                                                    @foreach($getEmployee as $employee)
                                                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger" id="auditorNameErrorMsg"></span>
                                            </div>

                                            <div class="mb-3">
                                                <label for="auditor_member" class="form-label">Auditor Members</label>
                                                <select class="select2 form-control" id="auditor_member" name="auditor_member" aria-label="Default select example" style="cursor:pointer;">
                                                    <option value="" readonly>- Choose -</option>
                                                    @foreach($getEmployee as $employee)
                                                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger" id="auditorNameErrorMsg"></span>
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
        var table = $('#table_schedule').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('data-schedule.index') }}",
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'id',name: 'id',
                    render: function (data, type, row) {
                        return row.faculty_name+' - '+row.department_name
                    }
                },
                {data: 'start_date',name: 'start_date',
                    render: function (data, type, row) {
                        return moment(row.start_date).format("LL")+' - '+ moment(row.end_date).format("LL")+' ('+row.interval+' days)'
                    }
                },
                {data: 'auditor_chief',name: 'auditor_chief'},
                {data: 'auditor_member',name: 'auditor_member'},
                {data: 'action',name: 'action'},
            ]
        });
    });

    //TOMBOL ADJUST SCHEDULE
    $('body').on('click', '.adjust-post', function (data) {
        var data_id = $(this).data('id');
        $('#button-simpan').val("create-post");
        $('#id').val('');
        $('#form-tambah-edit').trigger("reset");
        $('#modal-judul').html("Adjust schedule");
        $('#tambah-edit-modal').modal('show');
        $('#idAuditee').val($(this).data('id'));
        $.ajax({
            url: "{{ route('send-id-auditee') }}",
            type: 'POST',
            data: {id:data_id},
            dataType: 'json',
            success: function (response) {
                $("#table_data_auditee").html(response.data)
            }
        })
    });

    // TOMBOL TAMBAH
    if ($("#form-tambah-edit").length > 0) {
        $("#form-tambah-edit").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-simpan').val();
                $('#tombol-simpan').html('Saving..');

                $.ajax({
                    data: $('#form-tambah-edit').serialize(), 
                    url: "{{ route('data-schedule.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tambah-edit-modal').modal('hide');
                        $('#tombol-simpan').html('Save');
                        $('#table_schedule').DataTable().ajax.reload(null, true);
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
                        $('#titleErrorMsg').text(response.responseJSON.errors.title);
                        $('#titleErrorMsg').text(response.responseJSON.errors.is_active);
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
        var data_id_auditee = $(this).attr('data-auditee');
        $('#idAuditee').val(data_id_auditee);
        $.get('data-schedule/' + data_id + '/edit', function (data) {
            $('#modal-judul').html("Edit data");
            $('#tombol-simpan').val("edit-post");
            $('#tambah-edit-modal').modal('show');
              
            $('#id').val(data.id);
            
            $('#start_date').val(data.start_date);
            $('#end_date').val(data.end_date);
            $('#auditor_chief').val(data.auditor_chief);
            $('#auditor_member').val(data.auditor_member);
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
                        url: "data-schedule/" + dataId,
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
                        $('#table_schedule').DataTable().ajax.reload(null, true);
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

    /* UNTUK TOGGLE STATUS */
    function PeriodeStatus(id,is_active){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ Route('change-period-status') }}",
            id: $('.period-status'+id+'').val(),
            data:{'is_active':is_active,'id':id},
        }).done(function(data, response) {
            Swal.fire({
                title: 'Success!',
                text: 'State changed successfully!',
                type: 'success',
                customClass: { confirmButton: 'btn btn-primary' },
                buttonsStyling: false,
                timer: 2000
            })
            $('#table_schedule').DataTable().ajax.reload(null, true);
        })
    }


</script>

@endsection