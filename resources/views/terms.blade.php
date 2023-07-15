@extends('layouts.admin')

@section('content')
  
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    <div class="row mb-2 justify-content-between">                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Filter By Date:</label>
                                <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right" id="reservation" readonly autocomplete="off"
                                        placeholder="Please Select Date">
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>                        

                        <div class="col-sm-2">
                        <a href="{{ route($title.'.create') }}" class="btn btn-block btn-outline-primary">Add New</a>
                        </div>
                    </div>
                    <a href="javascript:;" class="clearFilter" style="display:none;" onclick="clearFilter()">Clear Filter</a>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">                    
                    <table id="{{ $title }}-table" class="table table-bordered table-hover" style="width: 100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Slug</th>                                                        
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    </div>
                </div>
                <!-- /.card-body -->
                </div>

                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->  
@endsection


@section('scripts')
    <script>
        $(function() {
            $('#reservation').daterangepicker();
            $("#reservation").val('');

            var dataTable = $('#{{$title}}-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: "{!! route('get.'.$title.'-terms') !!}",
              data: function(d) {
                d.date = $('#reservation').val()
                // d.role_id = $('#role_id').val()
              },
              type: 'post'
            },
            columns: [{
                data: null,
                searchable: false,
                sortable: false,
                "width": "1%"
              },              
              {
                data: 'name',
                name: 'name',                
              },            
              {
                data: 'slug',
                name: 'slug',
              },                            
              {
                data: 'created_at',
                name: 'created_at',
                "width": "10%"
              },
              {
                data: 'actions',
                name: 'actions',
                searchable: false,
                sortable: false,
                "width": "10%"
              }
            ],
            order: [
              [1, "asc"]
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
              $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
              return nRow;
            }
          });
          $('#reservation').change(function() {
            $('.clearFilter').show();
            dataTable.draw();
          });
    
        //   $('#role_id').change(function() {
        //     $('.clearFilter').show();
        //     dataTable.draw();
        //   });
    
        });
    
    
        function clearFilter() {
          $(".js-example-tags").val([' ']).trigger("change");
          $('#reservation').val('');
          $('#{{$title}}-table').DataTable().draw();
          $('.clearFilter').hide();
        }
    
        function deleteRecorded(id) {
          var url = $('.delete_' + id).data('url');
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: url,
                    data: {
                    _method: 'DELETE'
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: "Yours has been deleted.",
                            icon: 'success',
                        }).then((result) => {
                            $('#{{$title}}-table').DataTable().draw();
                        });
                    }
                });
            }
          });
        }    

    </script>
@endsection