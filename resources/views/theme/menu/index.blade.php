@extends('theme.Layouts.design')
@section('content')

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Menu Setting</h1>
      <p>Untuk mengatur menu Aplikasi</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ul>
  </div>


<div class="row">
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <a data-toggle="modal" data-target="#tambah" style="color:white;float:right;"class="btn waves-effect waves-light btn-primary">Tambah Data</a>

      <h4 class="card-title">Menu Setting</h4>
      <h6 class="card-subtitle">Data Menu digunakan untuk mengatur Menu Side Bar pada laravel</h6>
      <!-- Modal -->
      <div class="modal fade" id="tambah" role="dialog">
        <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form action="{{url('menu/add')}}" method="post">{{csrf_field()}}
            <div class="modal-body">
              <label>Name</label>
              <input type="text" class="form-control" name="name" required>
              <label>url</label>
              <input type="text" class="form-control" name="url" required>
              <label>Is Active</label>
              <input type="text" class="form-control" name="is_active" required>
              <label>Icon</label>
              <input type="text" class="form-control" name="icon" required>
              <label>SortBy</label>
              <input type="number" class="form-control" name="sortby" required>
              <label>Dropdown</label>
              <select class="form-control" name="dropdown" required>
                <option value="">--Pilih Aksi--</option>
                <option value="Y">Aktif</option>
                <option value="N">Non Aktif</option>
              </select>
              <label>Active</label>
              <select class="form-control" name="active" required>
                <option value="">--Pilih Aksi--</option>
                <option value="Y">Aktif</option>
                <option value="N">Non Aktif</option>
              </select>
             <label>Type</label>
             <select class="form-control" name="type" required>
               <option value="">--Pilih Type--</option>
               <option value="header">header</option>
               <option value="side">side</option>
               <option value="navbar">navbar</option>
               <option value="all">all</option>
             </select>

            </div>
            <div class="modal-footer">
              <a style="color:white;" class="btn btn-default" data-dismiss="modal">Close</a>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
          </div>
        </div>
      </div>
      <br>
      <div class="table-responsive">
      <table class="table table-hover table-bordered" id="sampleTable">
        <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Url</th>
          <th>Is Active</th>
          <th>icon</th>
          <th>Dropdown</th>
          <th>Status</th>
          <th>sortby</th>
          <th>Type</th>
          <th>action</th>
        </tr>
        </thead>
        <tbody>
          @foreach($data as $i=>$v)
            <tr>
              <td>{{$i+1}}</td>
              <td>{{$v->name}}</td>
              <td>{{$v->url}}</td>
              <td>{{$v->is_active}}</td>
              <td>{{$v->icon}}</td>
              <td>{{$v->dropdown}}</td>
              <td>{{$v->active}}</td>
              <td>{{$v->sortby}}</td>
              <td>{{$v->type}}</td>
              <td>
                <span data-toggle="tooltip" data-placement="top" title="Aksi Untuk Edit">
                                      <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sub{{$v->id_side}}"><i style="color:white;" class="fa fa-bars"></i> </a>&nbsp;

                                      <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#m{{$v->id_side}}"><i style="color:white;" class="fa fa-edit"></i> </a>&nbsp;
                                    </span>
                                      <a  data-toggle="tooltip" data-placement="top" title="Aksi Untuk Hapus" onclick="return confirm('Hapus?')" href="{{url('menu/hapus/'.base64_encode($v->id_side))}}" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </a>

              </td>
            </tr>
            <div class="modal fade" id="sub{{$v->id_side}}" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Update Sub Menu</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                  </div>
                  <form action="{{url('updatesub')}}" method="post">{{csrf_field()}}
                    <input type="hidden" name="id" value="{{$v->id_side}}">
                  <div class="modal-body">

                    <label>Sub Menu</label>
                    <select style="width:100%" class="form-control select2 " multiple name="sub[]" required>
                      <?php
                         $mn = explode(',',$v->id_sub);
                       ?>
                       @foreach($sub as $index => $vsub)
                       @if($v->id_side != $vsub->id_side)
                          @if($v->id_sub == 0)
                          <option value="{{$vsub->id_side}}" >{{$vsub->name}}</option>
                          @else

                          <option value="{{$vsub->id_side}}" @if(in_array($vsub->id_side,$mn)){{"Selected"}}@endif>{{$vsub->name}}</option>

                          @endif
                        @endif
                       @endforeach

                    </select>

                  </div>
                  <div class="modal-footer">
                    <a style="color:white;" class="btn btn-default" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
            <div class="modal fade" id="m{{$v->id_side}}" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Update Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                  </div>
                  <form action="{{url('menu/update')}}" method="post">{{csrf_field()}}
                  <div class="modal-body">
                    <label>Name</label>
                    <input type="hidden" value="{{$v->id_side}}" class="form-control" name="id" required>
                    <input type="text" value="{{$v->name}}" class="form-control" name="name" required>
                    <label>url</label>
                    <input type="text" value="{{$v->url}}"class="form-control" name="url" required>
                    <label>Is Active</label>
                    <input type="text" value="{{$v->is_active}}" class="form-control" name="is_active" required>
                    <label>Icon</label>
                    <input type="text" value="{{$v->icon}}" class="form-control" name="icon" required>
                    <label>SortBy</label>
                    <input type="number" class="form-control" value="{{$v->sortby}}" name="sortby" required>
                    <label>Dropdown</label>
                    <select class="form-control" name="dropdown" required>
                      <option value="">--Pilih Aksi--</option>
                      <option value="Y" @if($v->dropdown=='Y') selected @endif>Aktif</option>
                      <option value="N" @if($v->dropdown=='N') selected @endif>Non Aktif</option>
                    </select>
                    <label>Active</label>
                    <select class="form-control" name="active" required>
                      <option value="">--Pilih Aksi--</option>
                      <option value="Y" @if($v->active=='Y') selected @endif>Aktif</option>
                      <option value="N" @if($v->active=='N') selected @endif>Non Aktif</option>
                    </select>

                    <label>Type</label>
                    <select class="form-control" name="type" required>
                      <option value="">--Pilih Type--</option>
                      <option value="header" @if($v->type=='header') selected @endif>header</option>
                      <option value="side" @if($v->type=='side') selected @endif>side</option>
                      <option value="navbar" @if($v->type=='navbar') selected @endif>navbar</option>
                      <option value="all" @if($v->type=='all') selected @endif>all</option>
                    </select>
                  </div>
                  <div class="modal-footer">
                    <a style="color:white;" class="btn btn-default" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
