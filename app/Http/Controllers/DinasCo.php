<?php
      namespace App\Http\Controllers;
      use Illuminate\Http\Request;
      use App\InstansiModel;
      use App\TblDinas;
      use DataTables;
      use Session;
      use App\Cmenu;
      use Intervention\Image\ImageManagerStatic as Image;
      class DinasCo extends Controller
      {
        public function __construct()
      {

      }

      public function index(){
        if(Session::get('level')=='user'){
          $data = TblDinas::where('id_instansi',Session::get('kode_unitkerja'))->get();
          return view('theme.usulan.dinas',compact('data'));
        }
          
      }
      public function pengajuandinas(Request $r){
        $class       = new Cmenu();
        $listintansi = (object) $class->listinstansi();
        $skpd        = $listintansi;
        return view('theme.dinas.index',compact('skpd'));
      }
      public function apiusulandinas(Request $r){
        $class       = new Cmenu();
        $array       = array();
        $datacuti    = TblDinas::where('id_instansi',$r->skpd)->wheredate('created_at',$r->tanggal)->get();
        foreach ($datacuti as $i => $v){
       
            $pegawai = $class->getpegawaifromiduser($v->id_pegawai);
            $diterima = $v->status == 'Y' ? 'Disetujui' : 'Di batalkan';
            $status = $v->status == 'A' ? 'Menunggu Konfirmasi..' : $diterima;
            if ($pegawai != null) {
              $range   = explode('s/d',$v->rentang_absen);
              $data = [
                  'no' => $i + 1,
                  'nama_pegawai' => ((empty($pegawai->gd) || $pegawai->gd == '-') ? '' : $pegawai->gd) . ' ' . $pegawai->nama . ' ' . $pegawai->gb,
                  'no_spt' => $v->nospt,
                  'awal_dinas' => $range[0],
                  'akhir_dinas' => $range[1],
                  'tgl_pengajuan' => date('Y-m-d H:i:s', strtotime($v->created_at)),
                  'status' => $status,
                  'file' => '<a href="' . asset('uploads/' . $v->file) . '" target="popup" 
                              onclick="window.open(\'' . asset('uploads/' . $v->file) . '\',\'popup\',\'width=600,height=600\'); return false;">
                              <span style="color:white" class="me-1 badge bg-primary">' . $v->file . '</span></a>',
                  'aksi'=>'<a data-toggle="modal"
                  data-target="#view'.$v->id.'"class="btn btn-primary btn-sm white"><i
                      class="fa fa-file"></i></a><div id="view'.$v->id.'" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                          <!-- Modal content-->
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h4 class="modal-title">Ringkasan Izin Dinas</h4>
                                  <button type="button" class="close"
                                      data-dismiss="modal">&times;</button>
                              </div>
                              <form action="' . url('updateaksidinas') . '" method="post">
                              <input type="hidden" name="id" value="'.$v->id.'">
                              <div class="modal-body">
                                  <div style="display: flex;flex-direction:column">
                                      <p>Nama : '.$pegawai->nama.'</p>
                                      <p>NIP : '.$pegawai->nip.'</p>
                                      <p>NO SPT : '.$v->nospt.'</p>
                                      <p>HAL : '.$v->alasan.'</p>
                                      <p>Rentang Dinas : '.$v->rentang_absen.'</p>
                                      <p>Tanggal Pengajuan : '.$v->created_at.'</p>
                                      <p>Status Pengajuan : '.$status.'</p>
                                  </div>
                                  
                                  ' . ($status == 'Menunggu Konfirmasi..' ? '
                                 
                                  <select class="form-control" name="aksi">
                                    <option>--PILIH AKSI--</option>
                                    <option value="Y">TERIMA</option>
                                    <option value="N">TOLAK</option>
                                  </select>
                                 ' : '') . '
                              </div>
                              <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">'.($status == 'Menunggu Konfirmasi..' ? 'Update':'Batalkan').'</button>
                              </div>
                              </form>
                          </div>

                      </div>
                  </div>'
              ];
              array_push($array, $data);
          }
          
      }
      $datajson = [
        "draw"=> 1,
        "recordsTotal"=> count($datacuti),
        "recordsFiltered"=> count($datacuti), 
        "data"=>$array
        ];
        print json_encode($datajson);
     }
      public function save(Request $r){
        $data =[

        ];

        $act = "";
        if($act){
          return back()->with();
        }

      }
      public function update(Request $r){
        $data =[

        ];

        $act = "";
        // if($act){
        //   return back()->with("",);
        // }

      }
      public function hapus($id){
        // $act = Jabatan::where(,base64_decode($id))->delete();
        // if($act){
        //   return back()->with(,);
        // }

      }
    }