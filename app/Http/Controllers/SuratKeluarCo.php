<?php
      namespace App\Http\Controllers;
      use Illuminate\Http\Request;
      use App\InstansiModel;
      use DataTables;
      use Session;
      use DB;
      use Intervention\Image\ImageManagerStatic as Image;
      class SuratKeluarCo extends Controller
      {
        public function __construct()
      {

      }

      public function index(Request $req){
        if($req->delete){
          $cek = DB::table('data_surat')->where('id_surat',base64_decode($req->delete));
          if(empty($cek->count())){
            return redirect('surat_keluar')->with('danger','Data Surat Tidak ditemukan');
          }
          $cek->delete();
          return redirect('surat_keluar')->with('success','Data Surat Keluar Terhapus');

        }
        $index = DB::table('data_surat')->where('kode_unitkerja',Session::get('kode_unitkerja'))->get();

        return view('theme.e-surat.keluar.list',compact('index'));
      }

      function create(Request $req){
        $id = base64_decode($req->id);
        $edit = null;
        if(request()->segment(2)=='edit'){
          $edit = DB::table('data_surat')->where('id_surat',$id)->first();
          $id = $edit->jenis_surat;
          $id_surat = $edit->id_surat;
          $edit = json_decode($edit->data);
        }
        $jenis_surat = DB::table('jenis_surat')->where('id',$id);
        if($jenis_surat->count() == 0)
        return redirect('surat_keluar')->with('danger','Jenis Surat Tidak ditemukan');

        $jenis = $jenis_surat->first();
        $listfield = DB::table('field_surat')->where('jenis_surat',$id);
        $field = $listfield->get();
        if($req->buat_surat){
          foreach ($listfield->where('field','!=','pegawai')->pluck('field') as $key => $value) {
            $a[$value] = "required";
          }

            $validasi = $req->validate($a);
            if($req->pegawai){
            $fixfield = array_merge($validasi,['pegawai'=>$req->pegawai]);
          }else {
            $fixfield = $validasi;
          }
          if($req->buat_surat=='add'){
            DB::table('data_surat')->insert([
              'kode_unitkerja'=>session()->get('kode_unitkerja'),
              'jenis_surat'=>$jenis->id,
              'data'=>json_encode($fixfield)
            ]);
            return redirect('surat_keluar')->with('success','Berhasil membuat surat');

          }else {
            DB::table('data_surat')->where('id_surat',$id_surat)->update([
              'data'=>json_encode($fixfield)
            ]);
            return redirect('surat_keluar')->with('success','Berhasil Mengedit Surat');

          }

          // dd($fixfield);

        }
        return view('theme.e-surat.keluar.create',compact('jenis','field','edit'));
      }

      function preview(Request $req){
// dd(json_decode(fgets(fopen(public_path("datapegawai.json"),"r")),true));
        // $fp = fopen(public_path("datapegawai.json"), 'w');
        // fwrite($fp, file_get_contents("https://absensi.bengkaliskab.go.id/API/RASENGAN/datapegawai?kode_unitkerja=".session()->get('kode_unitkerja')));   // here it will print the array pretty
        // fclose($fp);
        $surat = DB::table('data_surat')->where('id_surat',base64_decode($req->id));
        if($surat->count()==0){
          return redirect('surat_keluar')->with('danger','Surat Tidak Ditemukan');
        }
        $surat->update(['file_surat'=>$this->create_surat($surat->first())]);
        $jenis = DB::table('jenis_surat')->where('id',$surat->first()->jenis_surat)->first();
        return view('theme.e-surat.keluar.preview',['jenis'=>$jenis,'surat'=>$surat->first()]);
      }

      function create_surat($data=array(),$cetak=false){
        $template = new \PhpOffice\PhpWord\TemplateProcessor(public_path($this->template_surat($data->jenis_surat)));
        $datanya = json_decode($data->data);
      foreach ($this->field_surat($data->jenis_surat) as $key => $value) {
        $v = $value->field;
        $databiasa[$value->field] = $datanya->$v;

      }
        $template->setValues($databiasa);
        // $template->setValues(datacamat());
        // $template->setValues(array('nama_desa'=>ucwords(mb_strtolower($data->nama_desa))));
        // $template->setValues(['tgl_surat'=>tglindo(date('Y-m-d H:i:s')),'index'=>getindex($data->jenis_surat),'bulan'=>romawimonth(date('n')),'tahun'=>date('Y')]);
        $docname = $data->id_surat.'_'.$data->kode_unitkerja.'.docx';
        // $pdfname = $random.'_'.Str::slug($data->nama_jenis_surat).'_'.$data->nik.'.pdf';
        $docpath = public_path('print_ready/'.$docname);
        // $pdfpath = public_path('file_surat/'.$pdfname);
        // $pdf_path = public_path('file_surat');
        $template->saveAs($docpath);
        // shell_exec("libreoffice --headless --convert-to pdf --outdir $pdf_path $docpath");
        // if(file_exists($pdfpath)){
        //   unlink($docpath);
        // }
        // if(file_exists(public_path('file_surat/'.$data->file_surat)) && !is_dir(public_path('file_surat/'.$data->file_surat))){
        //   unlink(public_path('file_surat/'.$data->file_surat));
        // }
        // DB::table('data_surat')->where('id_surat',$data->id_surat)->update([
        //   'file_surat' => $pdfname
        // ]);

      // $phpWord = \PhpOffice\PhpWord\IOFactory::load($docpath);
      //
      // // Add Password Protection For editing
      // $documentProtection = $phpWord->getSettings()->getDocumentProtection();
      // $documentProtection->setEditing(PhpOffice\PhpWord\SimpleType\DocProtect::READ_ONLY);
      // $documentProtection->setPassword('123456');
      //
      // // Write the output file
      //
      // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
      // $objWriter->save(public_path('hell.docx'));
      return $docname;
      }
      function template_surat($jenis){
        $d = DB::table('jenis_surat')->where('id',$jenis)->first();
        return 'template_surat/'.$d->template;
      }
      function file_surat($id_surat){
        $d = DB::table('data_surat')->where('id_surat',$id_surat)->select('file_surat')->first();
        return 'file_surat/'.$d->file_surat;
      }
      function field_surat($id){
        $d = DB::table('field_surat')->where('field_type','!=','break')->where('jenis_surat',$id)->get();
        return $d;
      }
    }
