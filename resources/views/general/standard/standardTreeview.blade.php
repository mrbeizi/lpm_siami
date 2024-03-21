@extends('layouts.backend')
@section('title','Data Standard')
<link href="{{asset('css/treeview.css')}}" rel="stylesheet">
@section('breadcrumbs')
<div class="container">
<nav aria-label="breadcrumb mb-0">
    <ol class="breadcrumb breadcrumb-style2">
      <li class="breadcrumb-item">
        <a href="{{route('dashboard')}}">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{route('data-standard-period.index')}}">@yield('title')</a>
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

                        <div class="row p-3">
                            <div class="col-md-6">
                                <h4 class="text-warning">Standard List</h4>
                                @if($standards->count() > 0)
                                <ul id="tree1">
                                    @foreach($standards as $standard)
                                        <li>
                                            {{ $standard->name }}
                                            @if(count($standard->childs))
                                                @include('general.standard.manageChild',['childs' => $standard->childs])
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                @else
                                <p class="text-mute"><i>Nothing standard available, please add new standard!</i></p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h4 class="text-primary">Add New Standard</h4>
                                <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" id="idStd" name="idStd" value="{{$idStd}}">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Standard Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="" />
                                        <span class="text-danger" id="nameErrorMsg" style="font-size: 10px;"></span>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="parent_id" class="form-label">Standard</label>
                                        <select class="form-select" id="parent_id" name="parent_id" aria-label="Default select example" style="cursor:pointer;">
                                            <option value="" id="choose_standard">- Choose -</option>
                                            {{-- @foreach ($allStandards as $standard => $standardName)
                                                <option value="{{ $standard }}" {{ old('parent_id') == $standard ? 'selected' : '' }}>
                                                    {{ $standardName }}
                                                </option>
                                            @endforeach --}}
                                            @foreach($allStandards as $standard)
                                            <option value="{{$standard->id}}">{{$standard->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="parentIdErrorMsg" style="font-size: 10px;"></span>
                                    </div>        
    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="tombol-simpan" value="create">Add New</button>
                                        <a href="{{route('data-standard-period.index')}}"><button type="button" class="btn btn-secondary ">Back</button></a> 
                                    </div>
                                </form>      
      
                            </div>
                        </div>

                        <div class="divider">
                            <div class="divider-text">Standard's Table:</div>
                        </div>

                        <div class="row p-3">
                            <div class="col-sm-12 mt-3">
                                <table class="table table-hover table-responsive" id="table_std">
                                    <thead>
                                      <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Actions</th>
                                      </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    
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

    if ($("#form-tambah-edit").length > 0) {
        $("#form-tambah-edit").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-simpan').val();
                $('#tombol-simpan').html('Saving..');

                $.ajax({
                    data: $('#form-tambah-edit').serialize(),
                    url: "{{ route('add.standard') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#form-tambah-edit').trigger("reset");
                        $('#tombol-simpan').html('Save');
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
                        location.reload();
                    },
                    error: function(response) {
                        $('#nameErrorMsg').text(response.responseJSON.errors.name);
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

    $(document).ready(function () {
        var table = $('#table_std').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route('index.standard-1') }}",
                "type": "GET",
                "data": function (data) {
                    data.idStd = $('#idStd').val();
                }
            },
            columns: [
                {data: null,sortable:false,
                    render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, 
                {data: 'name',name: 'name'},
                {data: 'action',name: 'action'},
            ]
        });
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
                        url: "{{ route('delete.standard-1') }}",
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
                        $('#table_std').DataTable().ajax.reload(null, true);
                        location.reload();
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

</script>
<script src="{{asset('js/treeview.js')}}"></script>

@endsection