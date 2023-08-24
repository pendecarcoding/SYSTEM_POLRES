@extends('theme.Layouts.design')
@section('content')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i>Users</h1>
      <p>Untuk mengatur user Aplikasi</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ul>
  </div>
  @include('theme.Layouts.alert')
<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-header">
     <h4 class="card-title">Data Akun Anggota</h4>
      <h6 class="card-subtitle">Fitur ini digunakan untuk mengelola akun Anggota</h6>
    </div>
    <div class="card-body">

      <!-- Modal -->
  
      <br>
      <div class="table-responsive">
        <table class="table table-hover table-bordered" id="sampleTable">
        <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>Bidang</th>
          <th>Username</th>
          <th>action</th>
        </tr>
        </thead>
        <tbody>
          @foreach($data as $i => $v)
         <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $v->gd.''.$v->nama.' '.$v->gb }}</td>
          <td>{{ $v->bidang }}</td>
          <td>@if(!empty(Helper::getusers($v->nip))){{ Helper::getusers($v->nip)->username }}@endif</td>
          <td>
            @if(empty(Helper::getusers($v->nip)))<a  data-toggle="modal" data-target="#edit{{ $v->id }}" style="color:white" class="btn btn-success btn-sm"><i class="fa fa-key"></i>Buat Akun</a>
            @else
            @if(!empty(Helper::getusers($v->nip)))
            @if(Helper::getusers($v->nip)->blokir=='N')<a onclick="blokir('{{ base64_encode($v->id) }}')" style="color:white" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Blokir</a>@else <a onclick="opblokir('{{ base64_encode($v->id) }}')" style="color:white" class="btn btn-sm btn-success"><i class="fa fa-unlock"></i> Buka Blokir</a> @endif @endif
            <a onclick="resetpassword('{{ base64_encode($v->id) }}')" style="color:white" class="btn btn-sm btn-warning"><i class="fa fa-undo"></i> Reset</a>
            @endif
          </td>
          
         </tr>
         <script>
          function opblokir(id) {

            swal({
                title: "Anda yakin akan membuka blokir akun ini?",
                text: "Akun akan bisa digunakan kembali ",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Buka!",
                closeOnConfirm: false
              },
              function () {
                swal("Akun dibuka!", "", "success")
                window.location = '{{ url("openblokir") }}/' + id;

              }



            );

            }
          function blokir(id) {

            swal({
                title: "Anda yakin akan memblokir akun ini?",
                text: "Akun yang diblokir tidak dapat melakukan Absensi!!!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Blokir!",
                closeOnConfirm: false
              },
              function () {
                swal("data dihapus!", "", "success")
                window.location = '{{ url("blokirakun") }}/' + id;

              }



            );

          }

          function resetpassword(id) {

              swal({
                  title: "Anda yakin akan mereset Password ini?",
                  text: "Password default berupa nip",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Ya, Reset!",
                  closeOnConfirm: false
                },
                function () {
                  swal("data berhasil direset!", "", "success")
                  window.location = '{{ url("resetakun") }}/' + id;

                }



              );

            }
        </script>
        <div class="modal fade" id="edit{{ $v->id }}" role="dialog">
        <div class="modal-dialog modal-md">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Aksess Data</h4>
              <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>

            </div>
            <form action="{{url('users/add')}}" method="post">{{csrf_field()}}
            <div class="modal-body">
              <label>Nama</label>
              <input type="hidden" name="idpg" value="{{$v->id}}">
              <input type="hidden" name="unitkerja" value="{{Session::get('kode_unitkerja')}}">
              <input value="{{ $v->nama }}" type="text" class="form-control"disabled  required placeholder="nama">
              <input type="hidden" name="nama" value="{{ $v->nama }}" required>
              
              <input type="hidden" class="form-control" name="username" required placeholder="username" value="{{ $v->nip }}">
              <input type="hidden" value="{{ $v['id'] }}">
              <label>Password</label>
              <input type="password" class="form-control" name="pass" required placeholder="password" value="{{ $v->nip }}">
              <p style="font-style: italic">untuk pembuatan pertama password akan sama dengan username anda dapat mengubahnya</p>
             </div>
            <div class="modal-footer">
              <a class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Batal</a>
              <button type="submit" class="btn btn-primary"><i class="fa fa-key"></i> Buat akun</button>
            </div>
          </form>
          </div>
        </div>
      </div>
         @endforeach
        </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
</main>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
