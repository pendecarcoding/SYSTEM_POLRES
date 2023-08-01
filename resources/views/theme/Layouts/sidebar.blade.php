<?php
use App\Cmenu;
use App\AplikasiModel;
use App\UserModel;
$level       = Session::get('level');
$iduser      = Session::get('id_user');
$li          = new Cmenu();
$listmenu    = $li->getside($level);

$menu        = AplikasiModel::where('id_app','1')->first();
$user        = UserModel::where('id_user',$iduser)->first();

 ?>
 <aside class="app-sidebar">
   <div class="app-sidebar__user">
     <img style="width:50px;height:50px;" class="app-sidebar__user-avatar" src="{{url('theme/users/'.$user->foto)}}" alt="User Image">
     <div>
       <p class="app-sidebar__user-name">{{$user->nama}}</p>
       <p class="app-sidebar__user-designation">{{$user->level}}</p>
     </div>
   </div>
   <ul class="app-menu">
     <li><a class="app-menu__item {{ Request::is('dashboard')? "active":"" }}" href="{{url('dashboard')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
     @foreach($listmenu as $i=>$v)
              <?php
                $item = $v->dropdown;
                switch ($item) {
                  case 'N':
                    ?>
                    <li>
                      <a class="app-menu__item {{ Request::is($v->is_active)? "active":"" }}" href="{{url($v->url)}}">
                        <i class="app-menu__icon {{$v->icon}}">
                        </i>
                        <span class="app-menu__label">{{$v->name}}</span>
                      </a>
                    </li>


                    <?php
                  break;
                  case 'Y':
                  $submenu     = $li->getsub($v->id_sub,$level);
                    ?>

                         <li class="treeview @foreach($submenu as $index => $vsub) {{ Request::is($vsub->is_active)? "is-expanded":"" }} @endforeach"><a class="app-menu__item @foreach($submenu as $index => $vsub) {{ Request::is($vsub->is_active)? "active":"" }} @endforeach" href="#" data-toggle="treeview"><i class="app-menu__icon fa {{$v->icon}}"></i><span class="app-menu__label">{{$v->name}}</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                           <ul class="treeview-menu">

                              @foreach($submenu as $index => $vsub)
                             <li><a class="treeview-item" href="{{url($vsub->url)}}"><i class="icon fa fa-circle-o"></i> {{$vsub->name}}</a></li>
                              @endforeach
                           </ul>
                         </li>

                    <?php
                  break;

                  default:
                    // code...
                  break;
                }
               ?>

              @endforeach

</ul>
 </aside>
