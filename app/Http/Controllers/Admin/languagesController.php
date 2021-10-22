<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Http\Requests\Admin\LanguageRequestValidate as validateLan;
class languagesController extends Controller
{
    public function index() 
	{
		$languages = Language::selects() -> paginate(PAGINATION_COUNT);
		return view('admin.languages.index', compact ('languages'));
	} 
	public function create() 
	{
		 return view('admin.languages.create');
	}
	public function store(validateLan $q) 
	{	
		
            if (!$q->has('active'))
                $q->request->add(['active' => 0]);
			try {

            Language::create($q->except(['_token']));
            return redirect()->route('admin.languages')->with(['success' => 'تم حفظ اللغة بنجاح']);
        } catch (Exception $ex) {
            return redirect()->route('admin.languages')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
        }
	}
	public function edit($id) 
	{
			$language = Language::selects()->find($id) ;
			   if (!$language) 
				  return redirect()->route('admin.languages')->with(['error' => 'هذه اللغة غير موجوده']);
		
			return view('admin.languages.edit' , compact('language'));
	}
	public function update($id , validateLan $q) 
	
	{

            if (!$q->has('active'))
                $q->request->add(['active' => 0]);
		
			$lang = Language::find($id);
			if(!$lang)
				  return redirect()->route('admin.languages')->with(['error' => 'هذه اللغة غير موجوده']);
			 try 
			 {
				$lang -> update ($q->except(['_token']));
				 return redirect()->route('admin.languages')->with(['success' => 'تم تحديث اللغة بنجاح']);
			 }
			catch (Exception $ex)
			{
				  return redirect()->route('admin.languages')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
			}
	}		
	public function delete($id) 
	
	{
		 $lang = Language::find($id);
		 
		 if (!$lang) 
                return redirect()->route('admin.languages', $id)->with(['error' => 'هذه اللغة غير موجوده']);
            try {					
           $lang->delete();

            return redirect()->route('admin.languages')->with(['success' => 'تم حذف اللغة بنجاح']);

        } catch (Exception $ex) {
            return redirect()->route('admin.languages')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
        }
	}	
		// addos to prives 
	public function change_state_lang ($id) 
	{
		$value = $_GET['value'] ?? 0;
		 Language::where('id' , $id) -> update(['active' => $value ] );
		 return "success change Lang";
	}
		
	
}

















