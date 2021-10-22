
@extends('layouts.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">القوائم الجانبية </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active"> القوائم الجانبية
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
                                    <h4 class="card-title">جميع لقوائم الجانبية   </h4>
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

                                                <th>الصورة </th>
                                                <th>الإجراءات</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @isset($images)
                                                @foreach($images as $image)
                                                    <tr>

                                                        <td><a href="{{asset('site/images/'.$image -> img)}}" ><img style="width: 150px; height: 100px;" src="{{asset('site/images/'.$image -> img)}}"></a></td>
                                                        <td>
                                                            <div class="btn-group" role="group"
                                                                 aria-label="Basic example">


                                                                <a href="{{route('admin.sliders.delete',$image -> id)}}"
                                                                   class="btn btn-outline-danger btn-sm-width box-shadow-3 mr-1 mb-1">حذف</a>




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
						function openLang (id)
						{
							var xml = new XMLHttpRequest();
							xml.open('get' , 'brands/change_active/'+id+"?value=1");
							xml.send();
							xml.onreadystatechange = function ()
							{
								if (xml.readyState === 4 && xml.status === 200)
								{
									console.log(xml.responseTxt);

									document.getElementById("acive"+id).innerHTML = "مفعلة ";

									document.getElementById("open"+id).style.display= "none";
									document.getElementById("close"+id).style.display= "block";


								}
							}
						}
						function closeLang (id)
						{
							var xml = new XMLHttpRequest();
							xml.open('get' , 'brands/change_active/'+id);
							xml.send();
							xml.onreadystatechange = function ()
							{
								if (xml.readyState === 4 && xml.status === 200)
								{
									console.log(xml.responseTxt);
									document.getElementById("acive"+id).innerHTML = "غير مفعلة ";

									document.getElementById("open"+id).style.display= "block";
									document.getElementById("close"+id).style.display= "none";
								}
							}
						}
	</script>
@stop
