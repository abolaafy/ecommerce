@extends('layouts.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href="">
                                        المنتجات </a>
                                </li>
                                <li class="breadcrumb-item active"> أضافه منتج
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
			
            <div class="content-body" >
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> اضافة عرض للمنج  ( {{$item -> name}} ) </h4>
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
                                                 
										
									 <?php $offersPublic = App\Models\Offer:: offersPublic ()   ?>
									
									</h1>  
									@if ($offersPublic -> count () >= 1)
												 <table
                                            class="table display nowrap table-striped table-bordered scroll-horizontal">
                                            <thead class="">
                                            <tr>
                                                <th>الاسم </th>
                                            
                                                <th>الحالة</th>
                                                <th>السعر قبل الخصم</th>
                                                <th>السعر بعد الخصم</th>
                                                <th>قيمة الخصم</th>
                                                <th>النوع</th>
                                                <th>الإجراءات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @isset($offersPublic)
                                                @foreach($offersPublic as $offer)
												{{$offer -> id}}
												<?php ?>
                                                    <tr id="table{{$offer -> id}}">
                                                        <td>{{$offer -> name}}</td>
                                                       
                                                        <td id="status{{$offer->id}}">{{$item -> offerActive ($item -> id ,$offer -> id )}}</td>
                                                        <td>{{ $item -> price . COIN}}</td>
                                                        <td>{{ $item -> price -trim ($offer -> discount ,'%') *$item -> price /100  . COIN}}</td>
                                                        <td>{{ trim ($offer -> discount ,'%') *$item -> price /100  . COIN}}</td>
                                                        <td>عام</td>
                                                        <td>
                                                            <div class="btn-group" role="group"
                                                                 aria-label="Basic example">
                                                                  <button class="btn btn-outline-danger  btn-sm-width box-shadow-3" 
																  id="close{{$offer->id}}" 	
																  onclick="closeOffer({{$item->id .', '.$offer->id}})"
															style="margin-left:10px;display:none;height:41px">ألغا التفعيل</button>
														   <button 
															onclick="openOffer({{$item->id .', '.$offer->id}});"
														  class="btn btn-outline-success  btn-sm-width  box-shadow-3" id="open{{$offer->id}}"
															style="margin-left:10px;display:none;height:41px">تفعيل</button> 
															
															<a  onclick="deleted({{$item->id .', '.$offer->id}});"
                                                                   class="btn btn-outline-danger btn-sm-width box-shadow-3 mr-1 mb-1">حذف</a>

                                                            </div>
                                                        </td>
														<script>
														var table = document.getElementById("status"+{{$offer->id}}).innerHTML
										console.log(table)
										if (document.getElementById("status"+{{$offer->id}}).innerHTML == 'مفعل')
											{
											document.getElementById("close"+{{$offer->id}}).style.display= "block";																								
											}
										else if (table == "hiddenTable()")
										{
											document.getElementById("table"+{{$offer ->id}}).style.display= "none";		
										}
											else
											{
											document.getElementById("open"+{{$offer ->id}}).style.display= "block";																								
											
											}
									</script>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                         
										 @isset($item -> offers)
											@foreach($item -> offers as $offerPivate)
												<tr id="table{{$offerPivate -> id}}">
												
													<td>{{$offerPivate -> name}}</td>
												   
													<td id="status{{$offerPivate->id}}">{{$item -> offerActive ($item -> id ,$offerPivate -> id  ) }}</td>
													<td>{{ $item -> price . COIN}}</td>
													<td>{{ $item -> price -trim ($offerPivate -> discount ,'%') *$item -> price /100  . COIN}}</td>
													<td>{{ trim ($offerPivate -> discount ,'%') *$item -> price /100  . COIN}}</td>
													<td >{{$offerPivate ->  getType ()}}</td>
													<td>
														<div class="btn-group" role="group"
															 aria-label="Basic example">
															 
													   <button onclick="openOffer({{$item->id .', '.$offerPivate->id}});"
														
													  class="btn btn-outline-success  btn-sm-width  box-shadow-3" id="open{{$offerPivate->id}}"
														style="margin-left:10px;display:none;height:41px">تفعيل</button> 
														
														<button class="btn btn-outline-danger  btn-sm-width box-shadow-3"  id="close{{$offerPivate->id}}"
														onclick="closeOffer({{$item->id .', '.$offerPivate->id}});"
															style="margin-left:10px;display:none;height:41px">ألغا التفعيل</button>
															
														<a onclick="deleted({{$item->id .', '.$offerPivate->id}});"
															   class="btn btn-outline-danger btn-sm-width box-shadow-3 mr-1 mb-1">حذف</a>

														</div>
													</td>
													</tr>
										<script>
										console.log(document.getElementById("status"+{{$offerPivate->id}}).innerHTML)
										if (document.getElementById("status"+{{$offerPivate->id}}).innerHTML == 'مفعل')
											{
											document.getElementById("close"+{{$offerPivate->id}}).style.display= "block";																								
											}
										
											else
											{
											document.getElementById("open"+{{$offerPivate ->id}}).style.display= "block";																								
											
											}
									</script>
												
											@endforeach
										@endisset
                                          


                                            </tbody>
                                        </table>
						@else
								<h1 class="text-center" style="font-size:25px;color:red">
									لا يوجد به عروض ولا خصومات حتي الان				
 									</h1>
								 @endif	
								  <div class="form-body">

                                        
								 
                                @include('admin.includes.alerts.success')
                                @include('admin.includes.alerts.errors')
                                <div  class="card-content collapse show">
                                    <div class="card-body">
									 <form class="form" 
                                              action="{{route('admin.items.offer.save')}}"
                                              method="POST">
                                             <form>
											  
                                            @csrf
                                       
											
                                            <input type="hidden" name="item_id" value="{{$item -> id}}">
                                            <div class="form-body">

                                                <h4 class="form-section"><i class="ft-home"></i> البيانات الاساسية للمنتج   </h4>
												<?php $offers_id_arr =DB::select ('SELECT  offer_id AS id FROM item_offers   WHERe item_id ='.$item -> id);
														//echo "<pre>";
														foreach ($offers_id_arr as $offer_id)
														{
															$offers_id [] = $offer_id -> id;
														}
														//print_r ($offers_id);
												?>
											 
												@if (isset($offers_id)&& App\Models\Offer::wherenotIn('id',$offers_id)-> where ('public' ,'0' )->get() -> count() >0)
											<div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="projectinput1">اختر العرض
                                                            </label>
                                                            <select name="offer_id" class="select2 form-control" multiple>
                                                                <optgroup label="من فضلك أختر العرض المناسب">
																<?php $allOffers = App\Models\Offer::wherenotIn('id',$offers_id)->get() ?>
															
																@foreach ( $allOffers as $offer)

																	<option value="{{ $offer -> id}}">{{ $offer -> name}}</option>
																				
                                                                
                                                                @endforeach
																
                                                                  
                                                                </optgroup>
																</select>
																@error('offer_id')
																 <span class="text-danger">{{$message}}</span>
																@enderror
                                              
                                                </div>
                                                </div>   
												</div>
											  
										
							                          <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group mt-1">
                                                            <input type="checkbox" value="1"
                                                                   name="active"
                                                                   id="switcheryColor4"
                                                                   class="switchery" data-color="success"
                                                                   checked/>
                                                            <label for="switcheryColor4"
                                                                   class="card-title ml-1">الحالة </label>

                                                            @error("active")
                                                            <span class="text-danger">{{$message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div> 
													


                                                </div>
                                            
                                                

</section>
                                            </div>


                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> تراجع
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> تحديث
                                                </button>
                                            </div>
											@endif
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>
<script>
						function openOffer (item_id , offer_id)
						{
							var xml = new XMLHttpRequest();
							xml.open('get' , 'http://localhost/shop7/public/admins/protucts/change-active-offer/'+item_id +'/'+offer_id+"?value=1");
							xml.send();
							xml.onreadystatechange = function () 
							{
								if (xml.readyState === 4 && xml.status === 200)
								{
									console.log(xml.responseTxt);
									
									document.getElementById("status"+offer_id).innerHTML = "مفعلة ";
									
									document.getElementById("open"+offer_id).style.display= "none";
									document.getElementById("close"+offer_id).style.display= "block";																								
									
				
								}
							}
						}
						function closeOffer (item_id , offer_id)
						{
							var xml = new XMLHttpRequest();
							xml.open('get' , 'http://localhost/shop7/public/admins/protucts/change-active-offer/'+ item_id+'/'+ offer_id);
							xml.send();
							xml.onreadystatechange = function () 
							{
								if (xml.readyState === 4 && xml.status === 200)
								{
									console.log(xml.responseTxt);
									document.getElementById("status"+offer_id).innerHTML = "غير مفعل ";
									
									document.getElementById("open"+offer_id).style.display= "block";
									document.getElementById("close"+offer_id).style.display= "none";	
								}
							}
						}
						function deleted (item_id , offer_id)
						{
							var xml = new XMLHttpRequest();
							xml.open('get' , 'http://localhost/shop7/public/admins/protucts/deleted-offer/'+ item_id+'/'+ offer_id);
							xml.send();
							xml.onreadystatechange = function () 
							{
								if (xml.readyState === 4 && xml.status === 200)
								{
									console.log(xml.responseTxt);
									
									document.getElementById("table"+offer_id).style.display= "none";	
								}
							}
						}
						
	</script>
@stop

@section('script')

    <script>
        $('input:radio[name="type"]').change(
            function(){
                if (this.checked && this.value == '2') {  // 1 if main cat - 2 if sub cat
                    $('#cats_list').removeClass('hidden');

                }else{
                    $('#cats_list').addClass('hidden');
                }
            });
    </script>
    @stop
