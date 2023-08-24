  <div class="modal fade" id="edit{{ $v->id }}" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Data Anggota</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>

        <div class="modal-body">
          <form action="{{ url('updatepegawai') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
              <label>Foto</label>
              <br>
              <center>
                <image id="preview" src="{{ asset('pegawai/'.Session::get('kode_unitkerja').'/'.$v->image) }}"
                  style="width:200px;height:220px;">
              </center>
              <br>
              <br>
              <input type="hidden"name="id" value="{{ $v->id }}" required>
              <input type="hidden" name="imageold" value="{{ $v->image }}">
              <input type="file" name="file" id="file" onchange="tampilkanPreview(this,'preview')">
              <script>
                function tampilkanPreview(gambar, idpreview) {
                  //membuat objek gambar
                  var gb = gambar.files;
                  //loop untuk merender gambar
                  for (var i = 0; i < gb.length; i++) {
                    //bikin variabel
                    var gbPreview = gb[i];
                    var imageType = /image.*/;
                    var preview = document.getElementById(idpreview);
                    var reader = new FileReader();
                    if (gbPreview.type.match(imageType)) {
                      //jika tipe data sesuai
                      preview.file = gbPreview;
                      reader.onload = (function (element) {
                        return function (e) {
                          element.src = e.target.result;
                        };
                      })(preview);
                      //membaca data URL gambar
                      reader.readAsDataURL(gbPreview);
                    } else {
                      //jika tipe data tidak sesuai
                      alert("Type file tidak sesuai. Khusus image.");
                      document.getElementById("file").value = "";
                    }
                  }
                }
              </script>
              <br>
            </div>

            <div class="form-group">
              <label>NRP</label>
              <input type="text" class="form-control" name="nip" value="{{ $v->nip }}">
            </div>
            <div class="form-group">
              <label>Nama</label>
              <input type="text" class="form-control" name="nama" value="{{ $v->nama }}">
            </div>

            <div class="form-group">
              <label>Pangkat/Gol</label>
              <input type="text" class="form-control" name="pangkatgol" value="{{ $v->nama }}">
            </div>

            <div class="form-group">
              <label>Gelar Depan</label>
              <input type="text" class="form-control" name="gd" value="{{ $v->gd }}">
            </div>
            <div class="form-group">
              <label>Gelar Belakang</label>
              <input type="text" class="form-control" name="gb" value="{{ $v->gb }}">
            </div>
            <div class="form-group">
              <label>Pangkat/Gol</label>
              <input type="text" class="form-control" name="pangkat_gol" value="{{ $v->pangkat_gol }}">
            </div>
            <div class="form-group">
              <label>NO HP</label>
              <input type="text" class="form-control" name="nohp" value="{{ $v->nohp }}">
            </div>

            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" name="email" value="{{ $v->email }}">
            </div>

            <ul class="list-group">
              <button class="btn btn-primary" type="submit">Simpan</button>
            </ul>
          </form>
        </div>
      </div>
    </div>
  </div>