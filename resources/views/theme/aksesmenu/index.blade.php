@extends('theme.Layouts.design')
@section('content')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i>Akses Menu</h1>
      <p>Untuk mengatur Akses Menu Aplikasi</p>
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
      <h4 class="card-title">Setting Akses Menu</h4>
    <hr>
    @foreach($data as $key =>$v)
    <?php
      $check = App\aksesmenuModel::where('level',$v->level)->count();
      if($check > 0){
        $mn      = explode(',',$v->id_menu);
        ?>
        <form action="{{url('hakakses/update')}}" method="post">{{csrf_field()}}
          <div class="form-group">
          <label style="font-weight:bold">{{$v->level}}</label>
          <input type="hidden" name="id" value="{{$v->id_akses}}" class="form-control" required>


          <select class="form-control select2" name="akses[]" id="exampleSelect2" multiple=""
                  style="width: 100%;color:white;">
            @foreach ($menu as $index => $d)
            <option value="{{$d->id_side}}"  @if(in_array($d->id_side,$mn)){{"Selected"}}@endif>{{$d->name}}</option>
            @endforeach
          </select>

          <br>
          <br>
          <button style="float:right;"class="btn btn-primary"><i class="fa fa-save"></i> Simpan Aturan</button>
        </div>
        </form>
        <?php
      }else{
        ?>

    <form action="{{url('hakakses/save')}}" method="post">{{csrf_field()}}
      <div class="form-group">
      <label style="font-weight:bold">{{$v->level}}</label>
      <input type="hidden" name="id" value="{{$v->level}}" class="form-control" required>

      <select class="form-control select2" name="akses[]" multiple="multiple"
              style="width: 100%;color:white;">
        @foreach ($menu as $index => $d)
        <option value="{{$d->id_side}}">{{$d->name}}</option>
        @endforeach
      </select>

      <br>
      <br>
      <button style="float:right;"class="btn btn-primary"><i class="fa fa-save"></i> Simpan Aturan</button>
    </div>
    </form>
    <?php
  }
     ?>
    @endforeach
    </div>

  </div>
</div>

</div>
</main>
<!-- ============================================================== -->
<!-- End Container fluid  -->
@endsection
