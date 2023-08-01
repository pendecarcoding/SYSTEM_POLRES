<div class="modal fade" id="edit{{ $vp->id }}" role="dialog">
            <div class="modal-dialog modal-md">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header" style="border-color:gren ">
                  <h4 class="modal-title">Update Pegawai {{ $bidang->bidang }}</h4>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>


                </div>
                <form action="{{ url('updatepenempatan') }}" method="POST">{{ csrf_field() }}
                <div class="modal-body">
                    
                     <label>Pilih Data Pegawai</label>
                    <select class="form-control" name="pegawai" >
                      @foreach($pegawai as $ip => $vpe)
                      <option value="{{ $vpe->id }}" @if($vpe->id==$vp->no) selected @endif>{{ '('.$vpe->nip.')'.$vpe->gd.' '.$vpe->nama.' '.$vpe->gb }}</option>
                      @endforeach

                    </select>
                    <input type="hidden" name="id_bidang" value="{{ $bidang->id_bidang }}">
                    <input type="hidden" name="id" value="{{ $vp->id }}">
                    <label>Jabatan Pegawai</label>
                    <select class="form-control" name="jabatan" required >
                      @foreach($jabatan as $ij => $vj)
                      <option value="{{ $vj->jabatan }}" @if($vj->jabatan==$vp->jabatan) selected @endif>{{ $vj->jabatan }}</option>
                      @endforeach

                    </select>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-primary"> <i class="fa fa-save"></i> Simpan</button>
                </div>
                </form>
              </div>
            </div>
          </div>