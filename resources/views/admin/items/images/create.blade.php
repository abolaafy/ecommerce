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
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> أضافة منتج جديد </h4>
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
                                <div class="row mr-2 ml-2" >
                                    <button style="display: none" type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                            id="textError">
                                    </button>
                            </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
									 @if (!is_null ($imgs) && $imgs -> count () > 0 )
									 <table
                                            class="table display nowrap table-striped table-bordered scroll-horizontal">
                                            <thead class="">
                                            <tr>
											 @foreach($imgs as $img)
                                                <th id="parent{{$img->id}}">الصورة </th>
											   @endforeach

                                            </tr>
                                            </thead>
                                            <tbody>


                                                    <tr>
													 @foreach($imgs as $img)
                                               <td id="img{{$img -> id}}">
											    <img style="width: 150px; height: 70px;transform:translate(0 , -10px);" src="{{asset('site/images/'.$img -> img)}}">


											      <a onclick='deleteImg ({{ $img -> id }} )'
                                                           class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>
											   </td>
											   @endforeach



                                                        </tr>


                                            </tbody>
                                        </table>
										@endif
                                        <form class="form"
                                              action="{{route('admin.items.images.save.database')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="item_id" value="{{$item_id}}">
                                            <div class="form-body">

                                                <h4 class="form-section"><i class="ft-home"></i> صور المنتج </h4>
                                                <div class="form-group">
                                                    <div id="dpz-multiple-files" class="dropzone dropzone-area">
                                                        <div class="dz-message">يمكنك رفع اكثر من صوره هنا</div>

                                                    </div>
                                                    <br><br>
                                                </div>


                                            </div>


                                            <div class="form-actions">
                                                <button id="btnBack" type="button" class="btn btn-warning mr-1"
                                                        onclick="deleteImgsJustDerection ()">
                                                    <i class="ft-x"></i> تراجع
                                                </button>
                                                <button
												type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> تحديث
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

@stop

@section('script')



    <script>

				window.value =[];
             var uploadedDocumentMap = {}
            Dropzone.options.dpzMultipleFiles = {
                paramName: "img", // The name that will be used to transfer the file
                //autoProcessQueue: false,
                maxFilesize: 5, // MB
                clickable: true,
                addRemoveLinks: true,
                acceptedFiles: 'image/*',
                dictFallbackMessage: " المتصفح الخاص بكم لا يدعم خاصيه تعدد الصوره والسحب والافلات ",
                dictInvalidFileType: "لايمكنك رفع هذا النوع من الملفات ",
                dictCancelUpload: "الغاء الرفع ",
                dictCancelUploadConfirmation: " هل انت متاكد من الغاء رفع الملفات ؟ ",
                dictRemoveFile: "حذف الصوره ",
                dictMaxFilesExceeded: "لايمكنك رفع عدد اكثر من هضا ",
                headers: {
                    'X-CSRF-TOKEN':
                        "{{ csrf_token() }}"
                }

                ,
                url: "{{route('admin.items.images.save.direction') }}", // Set the url
                success:
                    function (file, response) {
						//console.log(response.oldImg);
                        $('form').append('<input type="hidden"  id="'+response.oldImg+'"  value="' + response.newImg + '">')
                        $('form').append('<input type="hidden" name="imgs[]" value="' + response.newImg + '">')
                        uploadedDocumentMap[file.newImg] = response.newImg;


					 window.value.push(uploadedDocumentMap[file.newImg]);

					//console.log(window.value);

                    }

                ,
                removedfile: function (file) {
                    file.previewElement.remove()
                    var img = ''
                    if (typeof file.file_name !== 'undefined') {
                        img = file.file_name
                    } else {
                        //img = uploadedDocumentMap[file.img]
                    }
					console.log(window.value);
					img = document.getElementById(file.name).value;
					console.log(img);
                    $('form').find('input[name="imgs[]"][value="' + img + '"]').remove();

					var xml = new XMLHttpRequest ();
					xml.open('get' , "http://localhost/shop7/public/Dashboard/protucts/images/delete-direction?img="+img);
					xml.send();

					xml.onreadystatechange = function ()
					{
						if (xml.readyState === 4 && xml.status === 200)
						{
							console.log(xml.responseTxt);


						}
					}

                }
                ,
                // previewsContainer: "#dpz-btn-select-files", // Define the container to display the previews
                init: function () {

                        @if(isset($event) && $event->document)
                    var files =
                    {!! json_encode($event->document) !!}
                        for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="imgs[]" value="' + file.file_name + '">')
                    }
                    @endif
                }

            }
			function deleteImg (imgId = 0 )
			{
                if (imgId != 0 && Number(imgId))
               {
                    var xml = new XMLHttpRequest ();
                    xml.open('get' ,"{{route('admin.items.images.delete')}}?img_id=" +imgId);
                    xml.send();
                    xml.onreadystatechange = function ()
                    {
                        if (xml.readyState === 4 && xml.status === 200 )
                        {
                           // console.log(JSON.parse(xml.responseText).status )
                            var el = document.getElementById('textError');
                            el.style.display = 'block';
                            el.innerHTML ="تم حذف بنجاح";
                            document.getElementById("parent"+imgId).style.display= "none";
                            document.getElementById("img"+imgId).style.display= "none";

                        }
                         else
                        {
                            var el = document.getElementById('textError');
                            el.style.display = 'block';
                            el.innerHTML ="!! حدث خطاء اثناء حذف الصوره حاول لاحقا";

                        }

                    }
                }
                else
                {
                    var el = document.getElementById('textError');
                    el.style.display = 'block';
                    el.innerHTML ="حدث خطاء اثناء حذف الصوره حاول لاحقا";

                }
            }

            function deleteImgsJustDerection ()
			{

				 console.log(window.value);
				for (var x =0 ; x < window.value.length ; x++)
				{
					console.log(window.value[x]);
					   var xml = new XMLHttpRequest ();
					xml.open('get' , "http://localhost/shop7/public/Dashboard/protucts/images/delete-direction?img="+window.value[x]);
					xml.send();
                  //  ('admin.items.images.delete.direction')
				}

				window.location.replace('http://localhost/shop7/public/Dashboard/protucts');
			  }


    </script>
    @stop
