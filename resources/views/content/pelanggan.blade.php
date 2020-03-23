@extends('layout')

@section('title','Pelanggan')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Pelanggan</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
    
<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover" id="pelanggan-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            Footer
        </div>
    <!-- /.card-footer-->
    </div>
    <!-- /.card -->

    <!-- modal detail pelanggan-->
    <div class="modal fade" id="modalDetailPelanggan">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detail Pelanggan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ asset('assets/img/user4-128x128.jpg') }}"
                       alt="User profile picture">
                </div>
                <h3 id="profileNama" class="profile-username text-center">-</h3>
                <p class="text-muted text-center">User</p>
                <div class="card-body">

                <strong><i class="fas fa-book mr-1"></i> Email</strong>
                <p id="profileEmail" class="text-muted">-</p>
                <hr>

                <strong><i class="fas fa-phone mr-1"></i> Telepon</strong>
                <p id="profileTelepon" class="text-muted">-</p>
                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                <p id="profileAlamat" class="text-muted">-</p>
                <hr>

              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default st-btn-profile" data-dismiss="modal">OK</button>
            </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- modal hapus pelanggan-->
    <div class="modal fade" id="modalDeletePelanggan">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="POST" action="{{ url('delete-user') }}" enctype="multipart/form-data">
            <div class="modal-header">
              <h4 class="modal-title">Hapus Pelanggan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id-user-modal-delete" name="id_user" value="" />
              <div class="form-group">
                  <label>Anda yakin ingin hapus user ?</label>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary" >Hapus</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</section>
@stop

@section('foot')

<script>
  $(document).ready( function () {
    $('#pelanggan-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('get-all-user') }}",
        columns: [
        {
          data: 'id_user',
          render: function (data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        { 
          data: 'detail_user', 
          name: 'detail_user' 
        },
        { 
          data: 'email', 
          name: 'email' 
        },
        { 
          data: 'telepon', 
          name: 'telepon' 
        },
        { 
          data: 'action', 
          name: 'action' 
        },
      ]
    });

    @if($message = Session::get('error'))
      toastr.error("Error {{$message}}");
    @endif

    @if($message = Session::get('sukses'))
     toastr.success("{{$message}}");
    @endif

    bsCustomFileInput.init();

    $(document).on('click', '.modal-detail-user', function(event) {
        console.log("klik");
        var id = $(this).attr("data-id");
        $.ajax({
            type: "GET",
            url: "get-detail-user/" + id,
            // serializes the form's elements.
            success: function(data) {
                if (id != "") {
                    var obj = $.parseJSON(data);
                    // console.log(obj);
                    $('#profileNama').text(obj[0].nama);
                    $("#profileEmail").text(obj[0].email);
                    $('#profileTelepon').text(obj[0].telepon);
                    $("#profileAlamat").text(obj[0].alamat);
                    $("#modalDetailPelanggan").modal('show');
                }
                // show response from the php script.
            },
            error: function(e) {
                toastr.warning("Error " + e);
            }
        });
    });

    $(document).on('click', '.modal-delete-user', function(event) {
        var id = $(this).attr("data-id");
        if (id != "") {
            $('#id-user-modal-delete').val(id);
            $("#modalDeletePelanggan").modal('show');
        }
        // show response from the php script.

    });
  });
</script>
@stop
     
