<?php
      namespace App\Http\Controllers;
      use Illuminate\Http\Request;
      use App\InstansiModel;
      use DataTables;
      use Session;
      use DB;
      use Str;
      use Intervention\Image\ImageManagerStatic as Image;
      class TemplateCo extends Controller
      {
        public function __construct()
      {

      }
      function _unitkerja(){
        if(Session::get('level')=='adminsurat'):
        return 'ALL';
      else:
        return Session::get('kode_unitkerja');
      endif;
      }

      public function index(Request $req){
        if($req->delete):
          $edit = DB::table('jenis_surat')->where('id',base64_decode($req->delete))->where('kode_unitkerja',$this->_unitkerja());
          if(empty($edit))
          return redirect('template_surat');

          DB::table('field_surat')->where('jenis_surat',$edit->first()->id)->delete();
          $edit->delete();
          return redirect('template_surat')->with('success','berhasil dihapus');

        endif;
          return view('theme.manajemensurat.list');
      }

      function create(Request $req){
        $edit = null;
        if($req->id):
          $edit = DB::table('jenis_surat')->where('id',base64_decode($req->id))->where('kode_unitkerja',$this->_unitkerja())->first();
          if(empty($edit))
          return redirect('template_surat');

        endif;
        if($req->save):
          if($req->save=='add'):
            DB::table('jenis_surat')->insert([
              'nama_jenis_surat'=>$req->nama_jenis_surat ?? NULL,
              'template'=> $req->file('template') ? ($this->upload_template($req->file('template')) ?? NULL) : NULL,
              'kode_unitkerja'=> $this->_unitkerja()
            ]);
            return redirect('template_surat')->with('success','Jenis Surat Berhasil Dibuat');
          else:
            DB::table('jenis_surat')->where('id',$req->save)->where('kode_unitkerja',$this->_unitkerja())->update([
              'nama_jenis_surat'=>$req->nama_jenis_surat ?? NULL,
              'template'=>$this->upload_template($req->file('template')) ?? NULL,
            ]);
            return back()->with('success','Jenis Surat Berhasil Diperbarui');
        endif;
      endif;
        return view('theme.manajemensurat.create',compact('edit'));

      }
      function upload_template($file){
        $path = public_path('template_surat/');
        $namewithextension = $file->getClientOriginalName();
        $fname = explode('.', $namewithextension)[0];
        $name = Str::slug(date('dmYHis')).'_'.Str::slug($fname).'.'.$file->extension();
        $file->move($path, $name);
        return $name;
      }

      function customize(Request $req){
        $jenis = base64_decode($req->id);
        $edit = DB::table('jenis_surat')->where('id',$jenis)->where('kode_unitkerja',$this->_unitkerja());
        if(empty($edit->first()))
        return redirect('template_surat');

        if($req->save){
          DB::table('field_surat')->insert([
            'jenis_surat'=>$edit->first()->id,
            'field'=>$req->field,
            'field_type'=>$req->field_type,
            'desc'=>$req->desc,
          ]);
          $edit->update(['status'=>'Y']);
          return back()->with('success','Berhasil Tersimpan');
        }
        if($req->delete){
          DB::table('field_surat')->where('id',$req->delete)->delete();
          return redirect('template_surat/customize/'.$req->id);
        }
        $edit = $edit->first();
        return view('theme.manajemensurat.'.__FUNCTION__,compact('edit'));
      }
    }
