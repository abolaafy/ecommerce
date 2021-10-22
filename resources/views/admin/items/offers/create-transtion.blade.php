 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
   <link rel="stylesheet" type="text/css" href="http://localhost/shop7/public/admin/css-rtl/vendors.css">
<link href="http://localhost/shop7/public/admin/vendors/css/forms/toggle/bootstrap-switch.min.css">
<head><body>
    <div class="row mr-2 ml-2">
            <button type="text" class="btn btn-lg btn-block btn-outline-success mb-2"
                    id="type-error">تم ألاضافة بنجاح
            </button>
    </div>
	 
	
            <div class='container'>              
                         <form class="form-signin" action="{{route('admin.items.offer.store.translation')}}" method="post">
        <h2 class="form-signin-heading">ادخل ترجمات العرض</h2>	@csrf
		@foreach ($langs as $index => $lang)
        <label for="inputEmail" class="sr-onfly">اسم العرض-  {{__('messages.'.$lang -> abbr)}}</label>
        <input type="text" name="offers[{{$index}}][name]" id="inputEmail" class="form-control">
		<input type="hidden" value="{{$id}}" name="item_id">
		<input type="hidden" value="{{$lang ->abbr }}" name="offers[{{$index}}][locale]">
		  @error('offers.'.$index.'.name')
			<span class="text-danger"> {{$message}}	</span>
		  @enderror
        <label for="inputPassword" class="srي-only">الوصف -  {{__('messages.'.$lang -> abbr)}}</label>
        <input type="text" name="offers[{{$index}}][description]" id="inputPassword" class="form-control" >
         @error('offers.'.$index.'.description')
			<span class="text-danger"> {{$message}}	</span>
		  @enderror
       
	   <hr>
		@endforeach
        <button class="btn btn-lg btn-primary btn-block" type="submit">حفظ</button>
      </form>
                                             

</div>
<style>
.container
{
	width:30%;
}
</style>
  </body>
</html>