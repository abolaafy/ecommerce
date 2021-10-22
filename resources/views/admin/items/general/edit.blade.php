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
                                <li class="breadcrumb-item active"> تعديل - {{$item -> name}}
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
                                              action="{{route('admin.items.general.update')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf




                                            <div class="form-body">

                                                <h4 class="form-section"><i class="ft-home"></i> بيانات القسم </h4>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> اسم المنتج
                                                              </label>
                                                            <input type="text" id="name"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{$item -> name}}"
                                                                   name="name">
                                                            @error("name")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name='item_id' value="{{ $item -> id }}">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="projectinput1">
                                                                اسم الرابط
                                                            </label>   <input type="text" id="slug"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{$item -> slug}}"
                                                                   name="slug">
                                                            @error("slug")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="projectinput1">
السعر
                                                            </label>   <input type="text" id="price"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{intval ($item -> price)}}"
                                                                   name="price">
                                                            @error("price")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    @if ($categories && $categories -> count () > 1)


                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="projectinput2">  تغيير القسم من الفروع</label>
                                                            <select name="categories[]" class="select2 form-control" multiple>
                                                                <optgroup label="من فضلك أختر القسم ">
                                                                    @if(isset ($categories) && $categories -> count() > 0)
                                                                        @foreach($categories as $category)
                                                                            <option
                                                                                value="{{ get_default_lang() == 'ar' ?$category -> id :$category ->translation_of  }}">{{$category -> name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </optgroup>
                                                            </select>
                                                            @error('categories.0')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    @endif

                                                    <div class="col-md-4" id="parentSelectSubCategory" style="display:d">
                                                        <div class="form-group">
                                                            <label for="projectinput2"> تغيير لغة الترجمة</label>
                                                            <select id="selectSubCategory" name="language" class="select2 form-control">
                                                                <optgroup id="subCategoryOPtion" label="من فضلك أختر القسم ">
                                                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                                        <option value="{{  $localeCode}}" @if ($localeCode  == get_default_lang())
                                                                            {{ "selected" }}
                                                                        @endif>{{ $properties['native']  }}</option>

                                                                        @endforeach

                                                                </optgroup>
                                                            </select>
                                                            @error('language')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> تغيير ألماركة (اختياري)
                                                            </label>
                                                            <select name="brand_id" class="select2 form-control">
                                                                <optgroup label="من فضلك أختر الماركة ">
                                                                    <option
                                                                                value="">لا اريد الاضافة الان</option>
                                                                    @if(isset ($brands) && $brands -> count() > 0)
                                                                        @foreach($brands as $brand)
                                                                        <option value="{{$brand -> id }}"
                                                                                @if($item -> brand_id ==$brand -> id )
                                                                                {{ 'selected' }}
                                                                            @endif >
                                                                                {{$brand -> name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </optgroup>
                                                            </select>
                                                            @error('brand_id')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1"> وصف المنتج
                                                        </label>
                                                        <textarea  name="description" id="description"
                                                               class="form-control"
                                                               placeholder="  "
                                                        >{{$item -> translate(get_default_lang())['description']}}</textarea>

                                                        @error("description")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1"> الوصف المختصر
                                                        </label>
                                                        <textarea  name="short_description" id="short-description"
                                                                   class="form-control"
                                                                   placeholder=""
                                                        >{{$item -> translate(get_default_lang())['short_description']}}</textarea>

                                                        @error("short_description")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mt-1">
                                                            <input type="checkbox" value="1"
                                                                   name="active"
                                                                   id="switcheryColor4"
                                                                   class="switchery" data-color="success"
                                                                   @if($item -> active == 1)checked @endif/>
                                                            <label for="switcheryColor4"
                                                                   class="card-title ml-1">الحالة </label>

                                                            @error("active")
                                                            <span class="text-danger">{{ $message }} </span>
                                                            @enderror
                                                        </div>
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
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>

@endsection
