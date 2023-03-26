@extends('layouts.app')

@section('content')
    <div class="container pb-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mt-4">Archive {{date("F", mktime(0, 0, 0, request()->route('month'), 1))}} {{request()->route('year')}}</h1>
            </div>
        </div>
        @foreach($years as $year)
        <div class="row mb-5">
            <div class="col-12">
                <a href="{{url('pdf/'.$year->url)}}" role="button" target="_blank" class="card p-3">
                    <h4>
                        {{$year->name}}
                    </h4>
                </a>
                <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#exampleModalCenter" data-file="{{$year->url}}">
                    Download
                </button>
                <br>
            </div>
        </div>
       @endforeach
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Download Ebook Yearbook Sekarang Juga!!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="modal-image d-flex justify-content-center mb-3">
                    <img src="{{url('storage/image/download.png')}}" alt="download" height="150">
                </div>
                <div id="alert"></div>
		        <div class="d-flex justify-content-center align-items-center mt-2">
                  <h5 class="font-14 mr-2 mt-2">Masukan Password : </h5>
                  <form id="modal-form">
                    <input type="text" class="form-control" name="password" id="password" style="font-size: 2em">
                  </form>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="download">Download File</button>
            </div>
          </div>
        </div>
      </div>
@endsection
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script>
    let file = null;
    jQuery(document).ready(function() {
        $('#exampleModalCenter').on('show.bs.modal', function (event) {
            file = $(event.relatedTarget).data('file');
        });
        $('#download').click(function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            var formData = {
                password: $('#password').val(),
                file: file
            };
    
            $.ajax({
                type: "GET",
                url: "/download/pdf",
                data: formData,
                success: function (data){
                    window.open(data, '_blank')
                },
                error: function (data) {
                    console.log(data)
                    $('#alert').append(`
                    <div class="alert alert-danger" role="alert">
                        `+data.responseJSON.message+`   
                    </div>
                    `)
                }
            })
        })
    })
</script>