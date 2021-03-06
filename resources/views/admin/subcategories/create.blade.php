@extends('layouts.admin')

@section('content')

﻿ <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="http://localhost/shop7/public/admin/dashboard">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href="http://localhost/shop7/public/admin/main_categories"> الاقسام الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item active">إضافة قسم رئيسي
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> إضافة قسم رئيسي </h4>
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
                                    <div class="card-body">
                                        <form class="form" action="{{route('admin.subcategories.store')}}" method="POST"
                                              enctype="multipart/form-data">
												@csrf
                                            <div class="form-group">
                                                <label> صوره القسم </label>
                                                <label id="projectinput7" class="file center-block">
                                                    <input type="file" id="file" name="img">
                                                    <span class="file-custom"></span>
                                                </label>
                                                @error('img')
												<span class="text-danger">{{$message}} </span>
												@enderror
                                             </div>

                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-home"></i> بيانات  القسم </h4>
													   <div class="row">
                                                    <div class="col-md-6" id='parentSelectMainCategory'>
                                                        <div class="form-group">
                                                            <label for="projectinput2"> أختر القسم </label>
                                                            <select id='selectMainCategory' name="main_category_id" class="select2 form-control">
                                                                <optgroup label="من فضلك أختر القسم ">
                                                                    @if(isset($mainCategies) && $mainCategies -> count() > 0)
                                                                        @foreach($mainCategies as $category)
                                                                            <option
                                                                                value="{{$category -> id }}">{{$category -> name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </optgroup>
                                                            </select>
                                                            @error('category_id')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6" id="parentSelectSubCategory" style="display:none">
                                                        <div class="form-group">
                                                            <label for="projectinput2">  أختر القسم من الفروع</label>
                                                            <select id="selectSubCategory" name="" class="select2 form-control">
                                                                <optgroup id="subCategoryOPtion" label="من فضلك أختر القسم ">

                                                                </optgroup>
                                                            </select>
                                                            @error('category_id')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput2">نوع القسم   </label>
                                                            <select onchange="ChangeCategory ()"  class="select2 form-control" id="typeCategory">
                                                                <optgroup label="من فضلك أختر القسم ">

                                                                            <option
                                                                                value="main">قسم رئسي</option>
                                                                                <option
                                                                                value="sub">قسم فرعي</option>

                                                                </optgroup>
                                                            </select>
                                                            @error('category_id')
                                                            <span style="display: block" class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div >
                                                <script>
                                                            function ChangeCategory ()
                                                            {
                                                                var selectTypeCategory = document.getElementById('typeCategory').value;

                                                                var  parentSelectMainCategory =  document.getElementById('parentSelectMainCategory');
                                                                var  selectMainCategory =  document.getElementById('selectMainCategory');
                                                                var  parentSelectSubCategory =  document.getElementById('parentSelectSubCategory');
                                                                var  selectSubCategory =  document.getElementById('selectSubCategory');
                                                                var  subCategoryOPtion =  document.getElementById('subCategoryOPtion');


                                                                var xml = new XMLHttpRequest ();
                                                                if (selectTypeCategory == 'sub')
                                                                {
                                                                    xml.open('get' , "{{ route('admin.subcategories.get.categories') }}");
                                                                    xml.send();
                                                                    xml.onreadystatechange = function ()
                                                                    {

                                                                        if (xml.readyState === 4 && xml.status === 200)
                                                                        {
                                                                            parentSelectMainCategory.style.display ='none';
                                                                            selectMainCategory.name = null;
                                                                            parentSelectSubCategory.style.display ='block';
                                                                            selectSubCategory.name = 'sub_category_id';

                                                                            let categories =JSON.parse( xml.response).categories;
                                                                            subCategoryOPtion.innerHTML ='';
                                                                            console.clear()
                                                                            for (cat in categories)
                                                                            {
                                                                              subCategoryOPtion.innerHTML += '<option value='+categories[cat].id+'>'+categories[cat].name+'</option>';


                                                                            console.log(categories[cat])
                                                                            }
                                                                        }

                                                                    }

                                                                }
                                                                else if (selectTypeCategory == 'main')
                                                                {
                                                                             parentSelectMainCategory.style.display ='block';
                                                                            selectMainCategory.name = 'main_category_id';
                                                                            parentSelectSubCategory.style.display ='none';
                                                                            selectSubCategory.name = null;

                                                                }


                                                            }

                                                    </script>
									@if (get_langs_active() -> count () > 0)
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="projectinput1">
                                                اسم الرابط
                                            </label>   <input type="text" id="name"
                                                   class="form-control"
                                                   placeholder=" ادخل اسم الرابط "
                                                   value=""
                                                   name="slug">
                                            @error("slug")
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div></div>
											@foreach (get_langs_active() as $index => $lang)
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> اسم القسم -  {{__('messages.'.$lang -> abbr)}} </label>
                                                            <input type="text" value="" id="name"
                                                                   class="form-control"
                                                                   placeholder="ادخل اسم القسم  "
                                                                   name="category[{{$index}}][name]">
                                                          @error('category.'.$index.'.name')
														  <span class="text-danger"> {{$message}}	</span>
														  @enderror
                                                         </div>
                                                    </div>

                                                    <div class="col-md-6 hidden">

                                                        <div class="form-group">
                                                            <label for="projectinput1"> أختصار اللغة </label>
                                                            <input type="text" value="{{$lang -> abbr}}" id="name"
                                                                   class="form-control"
                                                                   placeholder="ادخل أختصار اللغة  "
                                                                   name="category[{{$index}}][abbr]">
																    @error("category.".$index.".abbr")
																		<span class="text-danger">Errr9or s {{$message}}</span>
															   @enderror
                                                         </div>
                                                    </div>
                                                </div>






                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mt-1">
                                                            <input type="checkbox"  value="1" name="category[{{$index}}][active]"
                                                                   id="switcheryColor4"
                                                                   class="switchery" data-color="success"
                                                                   checked/>
                                                            <label for="switcheryColor4"
                                                                   class="card-title ml-1">الحالة </label>

                                                              @error('category.$index.active')
																		<span class="text-danger"> {{$message}}</span>
															   @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
											<hr>
									@endforeach
							@else <h2> يجب اضافة لفة علي الاقل
							</h2>
							@endif

                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> تراجع
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> حفظ
                                                </button>
                                            </div>
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


@endsection
