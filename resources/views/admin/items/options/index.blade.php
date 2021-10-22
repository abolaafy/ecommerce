@extends('layouts.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title"> الماركات التجارية </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active">options
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">جميع الماركات التجارية </h4>
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
                                                <th>اسم الاضافة</th>
                                                <th>السعر</th>
                                                <th>المنتج</th>

                                                <th>اخصائص</th>
                                                  <th>الصورة</th>
                                                <th>الإجراءات</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @isset($options)
                                                @foreach($options -> options as $option)
                                                    <tr>
                                                        <td>{{$option -> name}}</td>
                                                        <td>{{$option ->price}}</td>
                                                        <td>{{$option ->name}}</td>
                                                        <td>
                                                            @foreach ($options ->attributes  as $attribute)
                                                          @if ($attribute['id'] == $option ->attribute_id )
                                                          {{$attribute['name']}}
                                                          @endif

                                                            @endforeach
                                                        </td>
                                                          <td> <img style="width: 150px; height: 100px;"
													src="{{asset ('site/images/'.$option ->img)}}"></td>
                                                        <td>
                                                            <div class="btn-group" role="group"
                                                                 aria-label="Basic example">
                                                                <a href="{{route('admin.attributes.options.edit',$option -> id )}}"
                                                                   class="btn btn-outline-primary btn-sm-width box-shadow-3 mr-1 mb-1">تعديل</a>
                                                                <a href="{{route('admin.attributes.options.delete',$option -> id)}}"
                                                                   class="btn btn-outline-danger btn-sm-width box-shadow-3 mr-1 mb-1">حذف</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset


                                            </tbody>
                                        </table>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="justify-content-center d-flex">
                                <a href="{{route('admin.attributes.options.create' ,$options -> id)}}"

                                class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1"> <b>
                                اضافة خاصيه جديده </b> </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@stop
