
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
                                <li class="breadcrumb-item active"> الماركات التجارية
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
                                    <h4 class="card-title">جميع الماركات التجارية   </h4>
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
												 <th>الوصف</th>
                                                <th>الحالة</th>
                                                <th>المبيعات</th>
                                                <th>الا عجابات</th>
                                               
                                                <th>الإجراءات</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @isset($offers)
                                                @foreach($offers as $offer)
                                                    <tr>
                                                        <td>{{$offer -> translate (get_default_lang())-> name}}</td>
                                                        <td>{{substr( $offer -> translate (get_default_lang())-> description ,-20)}} ...</td>
                                                         <td id='acive{{$offer->id}}'>{{$offer -> getActive()}}</td>
                                                         <td >{{$offer -> many_selling}}</td>
                                                         <td >{{$offer -> many_likes}}</td>
                                                       
														<td>
                                                            <div class="btn-group" role="group"
                                                                 aria-label="Basic example">
                                                                <a href="{{--route('admin.brands.edit',$offer -> id)--}}"
                                                                   class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>


														  <button class="btn btn-outline-danger  btn-min-width box-shadow-3"  id="close{{$offer->id}}" onclick="closeLang({{$offer->id}});"
															style="display:none;height:41px">ألغا التفعيل</button>
														
                                                            
														   <button onclick="openLang({{$offer->id}});"
															
														  class="btn btn-outline-success  btn-min-width  box-shadow-3" id="open{{$offer->id}}"
															style="display:none;height:41px">تفعيل</button>
														
															 

                                                            </div>
                                                        </td>
										@if ($offer -> active==1)
										<script>
											document.getElementById("close"+{{$offer->id}}).style.display= "block";																								
												</script>
										@else
										<script>	
											document.getElementById("open"+{{$offer ->id}}).style.display= "block";																								
											</script>
									@endif	
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
							xml.open('get' , 'offers/change-active/'+id+"?value=1");
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
							xml.open('get' , 'offers/change-active/'+id);
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
