@extends('layout')

@section('title','Detail Produk')

@section('content')
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="col-12">
                <img src="{{url($data[0]->gambar)}}" class="product-image" alt="Product Image">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <h3 class="my-3">{{$data[0]->nama}}</h3>
              <p>{{$data[0]->keterangan}}</p>
              <div class="bg-gray py-2 px-3 mt-4">
                <h2 class="mb-0">
                  Rp {{$data[0]->harga}}
                </h2>
                <h4 class="mt-0">
                  <small>Stok : {{$data[0]->jumlah}} </small>
                </h4>
              </div>

              <div class="mt-4">
                <div class="btn btn-default btn-lg btn-flat">
                  <input type="number"></input>
                </div>

                <div class="btn btn-primary btn-lg btn-flat">
                  <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                  Add to Cart
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
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
     
