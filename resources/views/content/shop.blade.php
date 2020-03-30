@extends('layout')

@section('title','Shop')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Shoping</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">

<!-- Default box -->
<div class="card card-solid">
  <div class="card-body pb-0">
    <div class="row d-flex align-items-stretch">

    <!-- <p>{{$data_shop['option']['path']}}</p> -->

    @for($i =0;$i<$data_shop['size'];$i++) 
      <div class="col-12 col-sm-6 col-md-4 st-d-flex align-items-stretch">
        <div class="card bg-light">
          <div class="card-header text-muted border-bottom-0">
            <!-- <input type="" id="id-produk" name="id_produk" value="{{$data_shop['produk'][$i]->id_produk}}" /> -->
            <a href="/get-detail-produk/{{$data_shop['produk'][$i]->id_produk}}" class="nav-link">
              <h2 class="lead"><b>{{$data_shop['produk'][$i]->nama}}</b></h2>
            </a>
          </div>
          <div class="card-body pt-0">
            <div class="text-center">
              <img src="{{ asset($data_shop['produk'][$i]->gambar) }}" alt="">
            </div>
          </div>
          <div class="info-box">  
            <div class="info-box-content">
              <div class="row">
                <span class="info-box-text">Harga &ensp;: Rp {{number_format($data_shop['produk'][$i]->harga, 0, ".", ".")}}</span>                 
                <!-- <span class="info-box-text"></span> -->
              </div>
              <div class="row">
                <span class="info-box-text">Stok   &emsp;: {{$data_shop['produk'][$i]->jumlah}}</span>                 
                <!-- <span class="info-box-text"></span> -->
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row ">
              <div class="col-auto mr-auto">
                <button href="#" class="btn btn-sm btn-success st-footer-keranjang"> Detail </button>
              </div>
              <div class="col-auto col-md-6">
                  <div class="quantity" >
                    <input id="jumlah" type="number" min="1" step="1" value="1">                  
                  </div>
                  <button id="add-keranjang" class="btn btn-sm btn-primary st-footer-keranjang" style="margin-left:10px;"> Tambah keranjang </Button>
              </div> 
            </div>              
          </div>
        </div>
      </div>
      @endfor      

    </div>
  </div>
  <!-- /.card-body -->
  <div class="card-footer">
    <nav aria-label="Contacts Page Navigation">
      <ul class="pagination justify-content-center m-0">
        <li class="page-item"><a class="page-link" href="{{$data_shop['prev_page']}}">Prev</a></li>

        @for($p=1;$p<=$data_shop['last_page'];$p++)
        
        @if ($data_shop['current_page'] == $p) 
        <li class="page-item active">
        @else
        <li class="page-item">
        @endif

        <a class="page-link " href="{{$data_shop['option']['path']}}?page={{$p}}">{{$p}}</a></li>
        @endfor

        <li class="page-item"><a class="page-link" href="{{$data_shop['next_page']}}">Next</a></li>
      </ul>
    </nav>
  </div>
  <!-- /.card-footer -->
</div>
<!-- /.card -->
</section>
@endsection

@section('foot')

<script>
  $(document).ready( function () {

    @if($message = Session::get('error'))
      toastr.error("Error {{$message}}");
    @endif

    @if($message = Session::get('sukses'))
     toastr.success("{{$message}}");
    @endif

    bsCustomFileInput.init();

    $(document).on('click','#add-keranjang', function(event) {
        var id = $("#id-produk").val();
        var jumlah = $("#jumlah").val();
        console.log("klick");
        console.log(id);
        console.log(jumlah);
        $.ajax({
            type: "POST",
            url: "{{ url('add-keranjang') }}",
            data: {
                id_produk: id,
                jumlah : jumlah
            },
            // serializes the form's elements.
            success: function(data) {
                if(data==0){
                    // $("#modalHapus").modal('hide');
                    var massage = "Berhasil tambah ke keranjang";
                    toastr.success(massage);
                    // tabel.ajax.reload( null, false );
                }
                    // show response from the php script.
            },
            error: function(e){ toastr.warning("Error " + e); }
        });
    });
  });

  
jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function() {
      var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

      btnUp.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

      btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

    });

</script>
@stop
    