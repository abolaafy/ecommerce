<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\Option;
use DB;
use App\Http\Requests\Admin\ItemOptionRequest;
use App\Http\Requests\Admin\ItemOptionUpdateRequest;
use App\Models\Item;
use Exception;

class ItemOptionsController extends Controller
{
	public function index ($item_id)
	{
        $options = Item ::with(['options' , 'attributes' => function ($q)
        {
            $q -> select ('attributes.id');
        }
        ])-> select('id')-> find ($item_id);
        $options ->attributes  -> makeHidden ('pivot');
        $options ->attributes  -> makeHidden ('translations');
        $options ->options  -> makeHidden ('pivot');
        $options ->options  -> makeHidden ('translations' );
        $options   -> makeHidden ('translations' );
       //  return $options ;
      // $option = DB::select ('select COUNT(*) AS count from option_translations INNER JOIN item_attribute_options ON item_attribute_options.option_id = option_translations.id WHERE item_attribute_options.item_id =9 AND option_translations.name ="كبير"' );

       return view('admin.items.options.index' , compact (['options' , 'item_id']));
	}
    public function create ($item_id)
	{

		$attributes = Attribute :: get ();
		return view('admin.items.options.create' , compact (['attributes' , 'item_id']));
	}
	public function store (ItemOptionRequest $q)
	{
        //return $q;
        try
        {

        DB::beginTransaction ();
          # save Img Folder
          if ($q -> has ('img'))
             $img_name =  move_img_by_Hash ('options'  , $q -> img);
        $option = Option :: create (['img' => $img_name , 'price' => $q ->price , 'attribute_id' => $q -> attribute_id]);

            # save transtion
        $option -> name = $q -> name ;
        $option -> save ();

        $option -> items () -> attach (['item_id' => $q -> item_id]);
        if (  DB::table('item_attributes') -> where ('item_id' , '=' ,$q -> item_id) -> where ('attribute_id' , '=' ,$q -> attribute_id ) -> count () == 0 )
              DB::statement('INSERT INTO item_attributes (item_id ,attribute_id ) VALUES ('. $q -> item_id.' , '.$q -> attribute_id.')');//. $q -> item_id.', '.$q -> iteattribute_idm_id.' )' );
        DB::commit ();
        return redirect()->route('admin.items')->with(['success' => 'تم ألاضافة بنجاح']);
        }
        catch (Exception $er)
        {
                return $er;
            DB::rollback();
            return redirect()->route('admin.items')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
	}
    public function edit ($option_id )
    {
        $option = Option::find($option_id);
        $option['attributes'] = Attribute::select('id') -> get ();
        return view('admin.items.options.edit' , compact (['option', ]));
    }
    public function update ($id ,ItemOptionUpdateRequest $q)
    {
        try
        {

            DB::beginTransaction ();
            $option = Option::find ($id);
            $option -> update (['price' => $q -> price , 'attribute_id' => $q -> attribute_id]);
            $option -> name = $q -> name ;
            if (!is_null($q -> oldImg))
        {
            delete_file ('site/images/'.$q -> oldImg );
            $option -> img =  move_img_by_Hash ('options'  , $q -> img);

            }
            $option -> save ();
            DB::commit ();
            return redirect()->route('admin.items')->with(['success' => 'تم ألاضافة بنجاح']);
        }
        catch (Exception $er)
        {
                return $er;
            DB::rollback();
            return redirect()->route('admin.items')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }
    public function destroy   ($option_id)
    {

        if (!$option = Option ::find ($option_id))
              return redirect()->route('admin.items')->with(['error' => 'هذه الخاصية غير موجودة ربما تم حذفها']);

        $option -> delete ();
     //   $option -> items () -> delete ();
        DB::statement('DELETE FROM item_attribute_options WHERE option_id='.$option_id);
        return redirect()->route('admin.items')->with(['error' => 'تم الحذف بنجاح']);

    }
}

