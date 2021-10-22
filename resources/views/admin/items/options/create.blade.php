
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
                                <li class="breadcrumb-item"><a href="{{route('admin.attributes.options' ,$item_id)}}"> options </a>
                                </li>
                                <li class="breadcrumb-item active"> add options
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
                                    <h4 class="card-title" id="basic-layout-form"> add options </h4>
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
                                              action="{{route('admin.attributes.options.store')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input name="item_id" type="hiddend" value="{{$item_id}}" >


                                            <div class="form-body">

                                                <img  class="hiddenh" id="imgShow" style="width: 200px; height: 120px;transform:translate(-230px ,-37px)"
                                                src="{{asset ('site/images/maincategories/')}}" alt='يجب اخيار صوره الاضافه' >

                                                <h4 class="form-section"><i class="ft-home"></i> options data </h4>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> اختر نوع الخاصيه
                                                            </label>
                                                           <select name="attribute_id" id="selectAttribute" class="select2 form-control" >
                                                                <optgroup label="من فضلك أختر قيمه">
                                                                    <option><option>
                                                                    @if(isset ($attributes) && $attributes -> count() > 0)
                                                                        @foreach($attributes as $attribute)
                                                                            <option
                                                                                value="{{$attribute -> id }}">{{$attribute ->  translations[0]->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </optgroup>
                                                            </select>
                                                            @error('attribute_id')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>





                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> ألسعر
                                                            </label>
                                                            <input type="text" id="price"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{old('price')}}"
                                                                   name="price">
                                                            @error("price")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="row ">



                                                    <div class="col-md-6 ">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> الاسم
                                                                 </label>
                                                            <input type="text" id="name"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{old('name')}}"
                                                                   name="name">
                                                            @error("name")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                     </div>

                                                     <div class="col-md-6 " style="transform:translate(0px ,30px)">
                                                        <div class="form-group">

                                                        <label id="projectinput7" class="file center-block">
                                                            <input onchange =" readUrl (this)" id='img' type='file' name="img">
                                                            <span class="file-custom"></span>
                                                        </label>
                                                        @error('img')
                                                        <span class="text-danger">{{$message}} </span>
                                                        @enderror


                                                </div>
                                                </div>

                                            </div>

                                            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

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
                                        <script type="text/javascript">
                                            var img = document.getElementById('img');

                                            function readUrl (el)
                                            {

                                               //  document.getElementById('imgShow').src="../../../../../../../../Users/MSK/Downloads/" + img.value.substr(12);
                                               console.clear ();
                                               var reader = new FileReader ();
                                               reader.onload = function (re)
                                               {
                                                document.getElementById('imgShow').src =  re.target.result;
                                                console.log( re.target.result);
                                               }

                                               reader.readAsDataURL(el.files[0]);

                                             //  console.log(el.files[0].file);

                                                //'hgh
                                            }
                                    </script>
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


</Script>
    @stop
