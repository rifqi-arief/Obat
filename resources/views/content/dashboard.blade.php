@extends('layout')

@section('title','Dashboard')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Produk</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
            <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>

                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

</section>
    
<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-body">
            <div class="clearfix st-btn-add">
                <button type="button" class="btn st-btn-info float-right" data-toggle="modal" data-target="#modalTambahProduk"><i class="fas fa-plus"></i> Tambah produk</button>
            </div>
            <table class="table table-bordered table-hover" id="product-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Kode Produk</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
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

    <!-- modal tambah produk-->
    <div class="modal fade" id="modalTambahProduk">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="POST" action="{{ route('add-produk') }}" enctype="multipart/form-data">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Produk</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                  <label for="kodeProduk">Kode Produk</label>
                  <input name="kode_produk" type="text" class="form-control" placeholder="kode produk">
              </div>
              <div class="form-group">
                  <label for="namaProduk">Nama Produk</label>
                  <input name="nama" type="text" class="form-control" placeholder="nama produk">
              </div>
              <div class="form-group">
                  <label for="harga">Harga</label>
                  <input name="harga" type="number" class="form-control" placeholder="harga">
              </div>
              <div class="form-group">
                  <label for="jumlah">Jumlah</label>
                  <input name="jumlah" type="number" class="form-control" placeholder="jumlah" value = 0>
              </div>
              <div class="form-group">
                <label for="gambar">File input</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input name="gambar" type="file" class="custom-file-input" >
                    <label class="custom-file-label" for="gambar">Choose file</label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                  <label for="keterangan">Keterangan</label>
                  <!-- <input type="comment" class="form-control" id="keterangan" placeholder="keterangan"> -->
                  <textarea name="keterangan" class="form-control" rows="4" cols="50" name="comment" placeholder="tulis keterangan disini..."></textarea>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" >Tambah</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- modal edit produk-->
    <div class="modal fade" id="modalEditProduk">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="POST" action="{{ url('edit-produk') }}" enctype="multipart/form-data">
            <div class="modal-header">
              <h4 class="modal-title">Edit Produk</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id-produk-modal-edit" name="id_produk" value="" />
              <div class="form-group">
                  <label>Nama Produk</label>
                  <input name="nama" id="nama-modal-edit" type="text" class="form-control" placeholder="nama produk">
              </div>
              <div class="form-group">
                  <label>Harga</label>
                  <input name="harga" id="harga-modal-edit" type="number" class="form-control" placeholder="harga">
              </div>
              <div class="form-group">
                  <label>Jumlah</label>
                  <input name="jumlah" id="jumlah-modal-edit" type="number" class="form-control" placeholder="jumlah" value = 0>
              </div>
              <div class="form-group">
                  <label>Keterangan</label>
                  <textarea name="keterangan" id="keterangan-modal-edit" class="form-control" rows="4" cols="50" name="comment" placeholder="tulis keterangan disini..."></textarea>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" >Edit</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- modal hapus produk-->
    <div class="modal fade" id="modalDeleteProduk">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="POST" action="{{ url('delete-produk') }}" enctype="multipart/form-data">
            <div class="modal-header">
              <h4 class="modal-title">Hapus Produk</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id-produk-modal-delete" name="id_produk" value="" />
              <div class="form-group">
                  <label>Anda yakin ingin hapus produk ?</label>
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
    $('#product-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('get-all-produk') }}",
        columns: [
        {
          data: 'id_produk',
          render: function (data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        { 
          data: 'gambar', 
          name: 'gambar' 
        },
        { 
          data: 'kode_produk', 
          name: 'kode_produk' 
        },
        { 
          data: 'nama', 
          name: 'nama' 
        },
        { 
          data: 'harga', 
          name: 'harga' 
        },
        { 
          data: 'jumlah', 
          name: 'jumlah' 
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

    $(document).on('click', '.modal-edit-produk', function(event) {
        console.log("klik");
        var id = $(this).attr("data-id");
        $.ajax({
            type: "GET",
            url: "get-detail-produk/" + id,
            // serializes the form's elements.
            success: function(data) {
                if (id != "") {
                    var obj = $.parseJSON(data);
                    // console.log(obj);
                    $('#id-produk-modal-edit').val(id);
                    $("#nama-modal-edit").val(obj[0].nama);
                    $("#harga-modal-edit").val(obj[0].harga);
                    $("#jumlah-modal-edit").val(obj[0].jumlah);
                    $("#keterangan-modal-edit").val(obj[0].keterangan);
                    $("#modalEditProduk").modal('show');
                }
                // show response from the php script.
            },
            error: function(e) {
                toastr.warning("Error " + e);
            }
        });
    });

    $(document).on('click', '.modal-delete-produk', function(event) {
        var id = $(this).attr("data-id");
        if (id != "") {
            $('#id-produk-modal-delete').val(id);
            $("#modalDeleteProduk").modal('show');
        }
        // show response from the php script.

    });
  });
</script>
@stop
     
