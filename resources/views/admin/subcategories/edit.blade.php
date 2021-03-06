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
                                <li class="breadcrumb-item"><a href=""> الاقسام الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item active"> تعديل - {{$category -> name}}
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
                                    <h4 class="card-title" id="basic-layout-form"> تعديل قسم رئيسي </h4>
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
                                        <form class="form"
                                              action="{{route('admin.subcategories.update',$category -> id)}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <input name="updateImg" value="{{$category -> img}}" type="hidden">

                                            <div class="form-group" style="border-raduis:50%;padding:10px;background:#ccc;">
                                                <div class="text-center">
                                                    <img
                                                      	src="{{asset ('site/images/'.$category ->img)}}"
                                                        class="rounded-circle  height-150" alt="صورة القسم  ">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label> صوره القسم </label>
                                                <label id="projectinput7" class="file center-block">
                                                    <input type="file" id="file" name="img">
                                                    <span class="file-custom"></span>
                                                </label>
                                                @error('img')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="form-body">

                                                <h4 class="form-section"><i class="ft-home"></i> بيانات القسم </h4>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> اسم القسم
                                                                - {{__('messages.'.$category -> translation_lang)}} </label>
                                                            <input type="text" id="name"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{$category -> name}}"
                                                                   name="category[0][name]">
                                                            @error("category.0.name")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">
                                                                اسم الرابط
                                                            </label>   <input type="text" id="name"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{$category -> slug}}"
                                                                   name="slug">
                                                            @error("category.0.slug")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                        <div class="form-group" style="width:100%" >
                                                            <label for="projectinput2"> أختر القسم </label>
                                                            <select name="main_category_id" class="select form-control" id="selectCategory">
                                                                <optgroup label="من فضلك أختر القسم ">

                                                                    @if ($category -> parent_id == 0)


                                                                    @if(isset($mainCastegories) && $mainCastegories -> count() > 0)
                                                                      @foreach ($mainCastegories as $mainCastegory)
                                                                        <option value="{{  $mainCastegory -> id}}"}} @if ($mainCastegory -> id ==$category -> category_id)
                                                                                {{ "selected" }}
                                                                        @endif>{{ $mainCastegory -> name }}
                                                                        </option>
                                                                            @endforeach

                                                                    @endif

                                                                    @else
                                                                    <script>
                                                                       // ChangeNameSelect ();
                                                                        document.getElementById('selectCategory').name = "sub_category_id";

                                                                    </script>
                                                                    @foreach (App\Models\SubCategory::where ('status' , 1) ->where ('active' , 1) ->where('id' , '!=' ,$category -> id )->where('translation_lang' , '=' , get_default_lang())->get() as $sub_category)
                                                                    <option value="{{ $sub_category ->id }}"
                                                                                @if ($sub_category -> id ==$category -> parent_id)
                                                                                {{ "selected" }}
                                                                        @endif>
                                                                      {{ $sub_category -> name }}</option>
                                                                    @endforeach
                                                                    @endif
                                                                    <option
                                                                </optgroup>
                                                            </select>
                                                            @error('category_id')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>




                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mt-1">
                                                            <input type="checkbox" value="1"
                                                                   name="category[0][active]"
                                                                   id="switcheryColor4"
                                                                   class="switchery" data-color="success"
                                                                   @if($category -> active == 1)checked @endif/>
                                                            <label for="switcheryColor4"
                                                                   class="card-title ml-1">الحالة {{__('messages.'.$category -> translation_lang)}} </label>

                                                            @error("category.0.active")
                                                            <span class="text-danger"> </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
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
                                        </form>

                                        <ul class="nav nav-tabs">
                                            @isset($category -> categries_translation)
                                                @foreach($category -> categries_translation   as $index =>  $translation)
                                                    <li class="nav-item">
                                                        <a class="nav-link @if($index ==  0) active @endif  " id="homeLable-tab"  data-toggle="tab"
                                                           href="#homeLable{{$index}}" aria-controls="homeLable"
                                                            aria-expanded="{{$index ==  0 ? 'true' : 'false'}}">
                                                            {{$translation -> translation_lang}}</a>
                                                    </li>
                                                @endforeach
                                            @endisset
                                        </ul>
                                        <div class="tab-content px-1 pt-1">

                                            @isset($category -> categryTrans)
                                                @foreach($category -> categryTrans   as $index =>  $translation)

                                                <div role="tabpanel" class="tab-pane  @if($index ==  0) active  @endif  " id="homeLable{{$index}}"
                                                 aria-labelledby="homeLable-tab"
                                                 aria-expanded="{{$index ==  0 ? 'true' : 'false'}}">

                                                <form class="form"
                                                      action="{{route('admin.subcategories.update',$category -> id)}}"
                                                      method="POST"
                                                      enctype="multipart/form-data">
                                                    @csrf
														<input name="updateImg" value="{{$category -> img}}" type="hidden">
                                                    <input name="id" value="{{$translation -> id}}" type="hidden">


                                                    <div class="form-body">

                                                        <h4 class="form-section"><i class="ft-home"></i> بيانات القسم </h4>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> اسم القسم
                                                                        - {{__('messages.'.$translation -> translation_lang)}} </label>
                                                                    <input type="text" id="name"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           value="{{$translation -> name}}"
                                                                           name="category[0][name]">
                                                                    @error("category.0.name")
                                                                    <span class="text-danger"> {{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>





                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group mt-1">
                                                                    <input type="checkbox" value="1"
                                                                           name="category[0][active]"
                                                                           id="switcheryColor4"
                                                                           class="switchery" data-color="success"
                                                                           @if($translation -> active == 1)checked @endif/>
                                                                    <label for="switcheryColor4"
                                                                           class="card-title ml-1">الحالة {{__('messages.'.$translation -> translation_lang)}} </label>

                                                                    @error("category.0.active")
                                                                    <span class="text-danger"> {{$message}}	</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                </form>
                                            </div>

                                                @endforeach
                                            @endisset

                                        </div>

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
