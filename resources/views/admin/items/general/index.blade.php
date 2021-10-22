
@extends('layouts.admin')
@section('content')


    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title"> الاقسام الرئيسية </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active"> الاقسام الرئيسية
                                </li>
                            </ol>
                        </div>
                    </div>
                    <style>
                        #tbody td
                         {
                             padding: 5px 7px;
                         }
                     </style>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">جميع الاقسام الرئيسية </h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>

                                @include('admin.includes.alerts.success')
                                @include('admin.includes.alerts.errors')

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <table
                                            class="table display nowrap table-striped table-bordered scroll-horizontal">
                                            <thead class="">
                                            <tr>
                                                <th>الاسم </th>
                                                <th>الاقسام </th>
                                                <th> الاسم بالرابط </th>

                                                <th>الحالة</th>
                                                <th>السعر</th>
                                                <th>الإجراءات</th>
                                            </tr>
                                            </thead>
                                            <tbody id='tbody'>

                                            @isset($items)
                                                @foreach($items as $item)
                                                    <tr>
                                                        <td>{{$item ->translate(get_default_lang()) ['name']}}</td>
                                                        <td> @if ($item->categories -> count () > 0)
                                                                @for ($x = 0 ; $x < $item->categories ->count ();  $x++)
                                                                <?php    echo '<span  style="color:#6195ff;hdeight:7px;font-size:13px">'.$item->categories[$x]['name'].'</span>';?>
                                                                    @if ($item->categories -> count () > 1 && $x < $item->categories -> count () -1)
                                                                        <?php    echo '<p style="color:red;font-size:20px;heijght:1px:line-height:0">,</p>'; ?>
                                                                    @endif

                                                                @endfor
                                                                @else  <?php    echo '<span style="color:pink;font-size:13px"> غير مسجل في الاقسام</span>'; ?>

                                                        @endif
                                                            </td>
                                                         <td>{{$item -> slug}}</td>
                                                        <td>{{$item -> getActive()}}</td>
                                                        <td>{{$item -> price . COIN}}</td>
                                                        <td>
                                                            <div class="btn-group" role="group"
                                                                 aria-label="Basic example">
                                                                <a href="{{route('admin.items.offer.add',$item -> id)}}"
                                                                   class="btn btn-outline-primary btn-sm-width box-shadow-3 mr-1 mb-1">العروض</a>

                                                                <a href="{{route('admin.items.images.add',$item -> id)}}"
                                                                   class="btn btn-outline-primary btn-sm-width box-shadow-3 mr-1 mb-1">الصور</a>

                                                                <a href="{{route('admin.items.general.edit',$item -> id)}}"
                                                                    class="btn btn-outline-primary btn-sm-width box-shadow-3 mr-1 mb-1">تعديل</a>

                                                                <a href="{{route('admin.items.stock.create',$item -> id)}}"
                                                                   class="btn btn-outline-primary btn-sm-width box-shadow-3 mr-1 mb-1">المستودع</a>

																  <a href="{{route('admin.attributes.options' ,$item -> id)}}"
                                                                   class="btn btn-outline-success btn-sm-width box-shadow-3 mr-1 mb-1">الخصائص</a>
                                                                   <a href="{{route('admin.items.delete' ,$item -> id)}}"
                                                                    class="btn btn-outline-danger btn-sm-width box-shadow-3 mr-1 mb-1">حذف</a>
                                                                    <a href="{{-- route('admin.attributes.options',$item->id) --}}"
                                                                        class="btn btn-outline-success btn-sm-width box-shadow-3 mr-1 mb-1">التفاصيب</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset


                                            </tbody>
                                        </table>
                                        <div class="justify-content-center d-flex">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--!! $items -> links() !!--}}
                </section>
            </div>
        </div>
    </div>

    @stop
