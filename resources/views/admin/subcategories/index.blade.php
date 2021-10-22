
@extends('layouts.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title"> الاقسام ألفرعية </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active"> الاقسام ألفرعية
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
                                    <h4 class="card-title">جميع الاقسام ألفرعية </h4>
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
                                                <th>القسم الرئيسي  </th>
                                                <th> اسم الرابط</th>
                                                <th>الحالة</th>
                                                <th>صوره القسم</th>
                                                <th>الإجراءات</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @isset($categories)
                                                @foreach($categories as $category)
                                                    <tr>
                                                        <td>{{$category -> name}}</td>
                                                        <td>{{ $category->mainCategories['name'] }}</td>
                                                        <td>{{$category -> slug}}</td>
                                                        <td id="status{{$category->id}}">{{$category -> getActive()}}</td>
                                                        <td> <img style="width: 150px; height: 100px;"
														src=" {{asset('site/images/'.$category -> img)}}"></td>
                                                        <td>
                                                            <div class="btn-group" role="group"
                                                                 aria-label="Basic example">
                                                                <a href="{{route('admin.subcategories.edit',$category -> id)}}"
                                                                   class="btn btn-outline-primary btn-sm-width box-shadow-3 mr-1 mb-1">تعديل</a>


                                                                <a href="{{route('admin.subcategories.delete',$category -> id)}}"
                                                                   class="btn btn-outline-danger btn-sm-width box-shadow-3 mr-1 mb-1">حذف</a>


                                                                   <button   style="display: inline-block" class="btn btn-outline-warning btn-sm-width box-shadow-3 mr-1 mb-1"
                                                                   name=@if($category -> active == 0)"open" @else "close" @endif

                                                              id ="action{{$category->id}}"
                                                              onclick="getTypeAction({{$category -> id}})"

                                                                 >
                                                                 @if($category -> active == 0)
                                                                  تفعيل
                                                                  @else
                                                                  الغاء تفعيل   @endif
                                                          </button>

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
                </section>
            </div>
        </div>
    </div>
    <script>
        function openCat (id)
                    {
                        var xml = new XMLHttpRequest();
                        xml.open('get' , 'sub_categories/change_state_cat/'+id +"?value=1");
                        xml.send();
                        xml.onreadystatechange = function ()
                        {
                            if (xml.readyState === 4 && xml.status === 200)
                            {
                                console.log(xml.responseTxt);
                                document.getElementById("action"+id).name = "close";

                                document.getElementById("status"+id).innerHTML = "مفعل";

                                document.getElementById("action"+id).innerHTML= "الغاء تفعيل";



                            }
                        }
                    }
                    function closeCat(id)
                    {

                        var xml = new XMLHttpRequest();
                        xml.open('get' , 'sub_categories/change_state_cat/'+id);
                        xml.send();
                        xml.onreadystatechange = function ()
                        {
                            if (xml.readyState === 4 && xml.status === 200)
                            {
                                document.getElementById("action"+id).name = "open";

                                document.getElementById("status"+id).innerHTML =  "غير مفعل";


                                document.getElementById("action"+id).innerHTML="تفعيل ";



                            }
                        }
                    }
    function getTypeAction (id )
    {
        var type = document.getElementById("action"+id).getAttribute('name');
        console.log("THis IS => " +type);
            console.log(type);
            if (type == "open" )
            {
                openCat(id);
            }
            else
            {
                closeCat(id);
            }

    }
</script>
    @stop
