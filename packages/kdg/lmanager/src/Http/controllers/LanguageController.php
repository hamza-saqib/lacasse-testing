<?php
namespace KDG\LManager\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use LanguageHelper;
use DB;
use \App;
use App\Http\Requests;
use App\User;
use App\Language;
use App\LanguageToken;
use App\LanguagePage;
use App\Student;
use App\GeneralSettings as Settings;
use Image;
use ImageSettings;
use Yajra\Datatables\Datatables;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Hash;
use App\Shop\Employees\Employee;

class LanguageController extends Controller
{
  protected $breadcumbs;
  protected $admin;
  public function __construct()
  {
    //$currentUser = \Auth::user();
    //$this->middleware('auth');
     $this->breadcumbs = [
        ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
        ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

    ];
    $this->admin = Employee::findOrFail(1);
  }
  /**
   * Plans listing method
   * @return Illuminate\Database\Eloquent\Collection
  */
  public function index()
  {
    $data['active_class']       = 'languages';
    $data['title']              = LanguageHelper::getPhrase('languages');
    $data['layout']             = 'layouts.admin.adminlayout';
    $data['module_helper']      = false;
    $data['admin']              = $this->admin;
    $data['breadcumbs']         = $this->breadcumbs;
    return view('lmanager::languages.list', $data);
  }
  public function getDatatable()
  {
  	$records = Language::select([ 'language', 'code','is_rtl','is_default','id','slug'])->orderBy('updated_at','desc');
    return Datatables::of($records)
      ->addColumn('action', function ($records) {
        $link_data = '<div class="dropdown more">
                      <a id="dLabel" type="button" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-ellipsis-h"></i>
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="dLabel">
                      <li><a href="'.URL_LANGUAGES_UPDATE_STRINGS.'/'.$records->slug.'"><i class="fa fa-wrench"></i>'.LanguageHelper::getPhrase("update_strings").'</a></li>
                          <li><a href="'.URL_LANGUAGES_EDIT.'/'.$records->slug.'"><i class="fa fa-pencil"></i>'.LanguageHelper::getPhrase("edit").'</a></li>';
                          $temp = '';
                     //if(checkRole(getUserGrade(1)))  {
                      if($records->code!='en') {
                          $temp = '<li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. LanguageHelper::getPhrase("delete").'</a></li>';
                        }
                       //}
                      $temp .= '</ul></div>';

                      $link_data = $link_data. $temp;
        return $link_data;
      })
      ->editColumn('language',function ($records)
      {
          return '<a href="'.URL_LANGUAGES_UPDATE_STRINGS.$records->slug.'">'.$records->language.'</a>';
      })
      ->editColumn('code',function ($records)
      {
      	return strtoupper($records->code);
      })
      ->editColumn('is_rtl',function ($records)
      {
      	 if($records->is_rtl)
          return '<i class="fa fa-check text-success" title="'.LanguageHelper::getPhrase('enable').'"></i>';
          return '<i class="fa fa-close text-danger" title="'.LanguageHelper::getPhrase('disable').'"></i>';
      })
       ->editColumn('is_default',function ($records)
      {
      	 if($records->is_default)
          return '<i class="fa fa-check text-success" title="'.LanguageHelper::getPhrase('enable').'"></i>';
          return '<a href="'.URL_LANGUAGES_MAKE_DEFAULT.$records->slug.'" class="btn btn-info btn-xs">'.LanguageHelper::getPhrase('set_default').'</a>';
      })
      ->removeColumn('id')
      ->removeColumn('slug')
      ->rawColumns(['language', 'code','is_rtl','is_default', 'action'])
      ->make(true);
  }
  public function token_list()
  {
    $data['active_class']       = 'languages';
    $data['title']              = LanguageHelper::getPhrase('language_tokens');
    $data['layout']             = 'layouts.admin.adminlayout';
    $data['module_helper']      = false;
    $data['admin']              = $this->admin;
    $data['breadcumbs']         = $this->breadcumbs;
    return view('lmanager::languages.token-list', $data);
  }
  public function getTokenDatatable()
  {
    $records = LanguageToken::select([ 'token_label', 'default_value', 'id'])->orderBy('updated_at','desc');
    return Datatables::of($records)
      ->addColumn('action', function ($records) {
        $link_data = '<div class="dropdown more">
                  <a id="dLabel" type="button" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-ellipsis-h"></i>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="dLabel">
                      <li><a href="'.URL_LANGUAGES_EDIT_TOKEN.'/'.$records->id.'"><i class="fa fa-pencil"></i>'.LanguageHelper::getPhrase("edit").'</a></li>
                      <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->id.'\');"><i class="fa fa-trash"></i>'. LanguageHelper::getPhrase("delete").'</a></li>
                  </ul></div>';
        $link_data = $link_data;
        return $link_data;
      })
      ->removeColumn('id')
      ->rawColumns(['token_label', 'default_value', 'action'])
      ->make(true);
  }
  /**
   * This method loads the create view
   * @return void
  */
  public function create()
  {
    $data['record']         	  = FALSE;
  	$data['active_class']       = 'languages';
    $data['title']              = LanguageHelper::getPhrase('add_language');
    $data['layout']             = 'layouts.admin.adminlayout';
    $data['module_helper']      = false;
    $data['admin']              = $this->admin;
    $data['breadcumbs']         = $this->breadcumbs;
    return view('lmanager::languages.add-edit', $data);
  }
  public function add_token()
  {
    $data['record']             = FALSE;
    $data['active_class']       = 'languages';
    $data['title']              = LanguageHelper::getPhrase('add_language_token');
    $data['layout']             = 'layouts.admin.adminlayout';
    $data['module_helper']      = false;
    $data['admin']              = $this->admin;
    $data['breadcumbs']         = $this->breadcumbs;
    return view('lmanager::languages.add-edit-token', $data);
  }

  /**
   * This method adds record to DB
   * @param  Request $request [Request Object]
   * @return void
  */
  public function save_token(Request $request)
  {
    $this->validate($request, [
      'token_label'           => 'bail|required|max:400|unique:language_tokens,token_label',
      //'code'               => 'bail|required|max:4|unique:languages,code',
      //'is_rtl'             => 'bail|required'
    ]);
    $record = new LanguageToken();
    $record->token_label    = $request->token_label;
    $record->default_value  = $request->default_value;
    $record->language_pages_id  = $request->lpage;
    $record->save();
    LanguageHelper::flash('success','record_added_successfully', 'success');
    return redirect(URL_LANGUAGE_TOKEN_LIST);
  }

  /**
   * This method loads the edit view based on unique slug provided by user
   * @param  [string] $slug [unique slug of the record]
   * @return [view with record]       
   */
  public function edit_token($id)
  {
    $record = LanguageToken::where('id', $id)->get()->first();
    if($isValid = $this->isValidRecord($record))
      return redirect($isValid);
    $data['record']             = $record;
    $data['active_class']       = 'languages';
    $data['title']              = LanguageHelper::getPhrase('edit_language_token');
    $data['layout']             = 'layouts.admin.adminlayout';
    $data['admin']              = $this->admin;
    $data['breadcumbs']         = $this->breadcumbs;
    return view('lmanager::languages.add-edit-token', $data);
  }

  /**
   * Update record based on slug and reuqest
   * @param  Request $request [Request Object]
   * @param  [type]  $slug    [Unique Slug]
   * @return void
  */
  public function update_token(Request $request, $id)
  {
    $record                 = LanguageToken::where('id', $id)->get()->first();
    if($isValid = $this->isValidRecord($record))
      return redirect($isValid);

    $this->validate($request, [
      'token_label'           => 'bail|required|max:400|unique:language_tokens,token_label,'.$record->id,
    ]);

    $record->token_label   = $request->token_label;
    $record->default_value = $request->default_value;
    $record->language_pages_id  = $request->lpage;
    $record->save();
    LanguageHelper::flash('success','record_updated_successfully', 'success');
    return redirect(URL_LANGUAGE_TOKEN_LIST);
  }
  /**
   * Delete the language is the language is not set to default
   * @param  [type] $slug [description]
   * @return [type]       [description]
  */
  public function delete_token($id)
  {
    $record                 = LanguageToken::where('id', $id)->get()->first();
    /**
     * Check if the record is set to current default language
     * If so do not delete the record and send the appropriate message
     */

    /*if($record->is_default)
    {
      //Topics exists with the selected, so done delete the subject
      $response['status'] = 0;
      $response['message'] = getPhrase('it_is_set_to_default_language');
      return json_encode($response);
    }
    else*/ {
      if(!env('DEMO_MODE')) {
          $record->delete();
      }
      $response['status'] = 1;
      $response['message'] = LanguageHelper::getPhrase('record_deleted_successfully');
      return json_encode($response);
    }
  }

  /**
   * This method loads the edit view based on unique slug provided by user
   * @param  [string] $slug [unique slug of the record]
   * @return [view with record]       
  */
  public function edit($slug)
  {
    $record = Language::where('slug', $slug)->get()->first();
  	if($isValid = $this->isValidRecord($record))
  		return redirect($isValid);
  			
	  $data['record']       		  = $record;
	  $data['active_class']       = 'languages';
    $data['title']              = LanguageHelper::getPhrase('edit_language');
    $data['layout']             = 'layouts.admin.adminlayout';
    $data['admin']              = $this->admin;
    $data['breadcumbs']         = $this->breadcumbs;
    return view('lmanager::languages.add-edit', $data);
  }

  /**
   * Update record based on slug and reuqest
   * @param  Request $request [Request Object]
   * @param  [type]  $slug    [Unique Slug]
   * @return void
  */
  public function update(Request $request, $slug)
  {
    $record                 = Language::where('slug', $slug)->get()->first();
    if($isValid = $this->isValidRecord($record))
		  return redirect($isValid);

    $this->validate($request, [
      'language'          		 => 'bail|required|max:40|unique:languages,language,'.$record->id,
      'code'           		     => 'bail|required|max:20|unique:languages,code,'.$record->id,
      'is_rtl'          	 	   => 'bail|required'
    ]);
    $name 					        = $request->language;
   
    /**
    * Check if the title of the record is changed, 
    * if changed update the slug value based on the new title
    */
    if($name != $record->language)
      $record->slug = $record->makeSlug($name);
	
 	  $record->language 			 = $name;
    $record->slug 			   = $record->makeSlug($name);
    $record->code					 = $request->code;
    $record->is_rtl				 = $request->is_rtl;
    $record->save();
    LanguageHelper::flash('success','record_updated_successfully', 'success');
    return redirect(URL_LANGUAGES_LIST);
  }

  /**
   * This method adds record to DB
   * @param  Request $request [Request Object]
   * @return void
  */
  public function store(Request $request)
  {
    $this->validate($request, [
       'language'          	=> 'bail|required|max:40|unique:languages,language',
       'code'           		=> 'bail|required|max:4|unique:languages,code',
       'is_rtl'          	 	=> 'bail|required'
          ]);
  	$record = new Language();
    $name 					        = $request->language;
    $record->language 		  = $name;
    $record->slug 			    = $record->makeSlug($name);
    $record->code					  = $request->code;
    $record->is_rtl					= $request->is_rtl;
    $record->save();
    LanguageHelper::flash('success','record_added_successfully', 'success');
  	return redirect(URL_LANGUAGES_LIST);
  }

  /**
   * This method will change the default language by
   * Unset all is_default fields to 0
   * Set the is_default to the specified slug by user
   * @param  [type] $slug [description]
   * @return [type]       [description]
  */
  public function changeDefaultLanguage($slug, $return = true)
  {
    $record = Language::where('slug', '=', $slug)->first();
  	$zero = 0;
  	if($isValid = $this->isValidRecord($record))
  		return redirect($isValid);
  	Language::where('id','!=' ,$zero)->update(['is_default'=> $zero]);
  	Language::where('slug', '=', $slug)->update(['is_default'=> 1]);
    Language::resetLanguage();
  	LanguageHelper::flash('success','record_updated_successfully', 'success');
    if($return)
      return redirect(URL_LANGUAGES_LIST);	
  }

  /**
   * Delete the language is the language is not set to default
   * @param  [type] $slug [description]
   * @return [type]       [description]
  */
  public function delete($slug)
  {
   	$record = Language::where('slug', '=', $slug)->first();
    /**
     * Check if the record is set to current default language
     * If so do not delete the record and send the appropriate message
     */

    if($record->is_default)
    {
      //Topics exists with the selected, so done delete the subject
      $response['status'] = 0;
      $response['message'] = LanguageHelper::getPhrase('it_is_set_to_default_language');
      return json_encode($response);
    }
    else {
      if(!env('DEMO_MODE')) {
          $record->delete();
      }
      $response['status'] = 1;
      $response['message'] = LanguageHelper::getPhrase('record_deleted_successfully');
      return json_encode($response);
    }
  }

  public function isValidRecord($record)
  {
    if ($record === null) {
      LanguageHelper::flash('Ooops...!', getPhrase("page_not_found"), 'error');
      return $this->getRedirectUrl();
    }
    return FALSE;
  }
  public function getReturnUrl()
  {
    return URL_LANGUAGES_LIST;
  }

  public function updateLanguageStrings($slug)
  {
    //Get all default tokens and their default values
    $data['defaults'] = LanguageToken::orderBy('token_label', 'ASC')->get()->toArray();
    $record  = Language::where('slug', $slug)->get()->first();
    
    if($isValid = $this->isValidRecord($record))
      return redirect($isValid);

    $data['record']             = $record;
    $data['active_class']       = 'languages';
    $data['title']              = LanguageHelper::getPhrase('update_strings');
    $data['layout']             = 'layouts.admin.adminlayout';
    $data['admin']              = $this->admin;
    $data['breadcumbs']         = $this->breadcumbs;
    return view('lmanager::languages.sub-list', $data);
  }
  public function saveLanguageStrings(Request $request, $slug)
  {
    $record                 = Language::where('slug', $slug)->get()->first();
    if($isValid = $this->isValidRecord($record))
      return redirect($isValid);
    $language_strings = array();
    foreach ($request->all() as $key => $value) {
        if($key=='_method' || $key=='_token')
            continue;
        $language_strings[$key] = $value;
    }
    $record->phrases = json_encode($language_strings);
    $record->save();
    LanguageHelper::flash('success','record_updated_successfully', 'success');
    $this->changeDefaultLanguage($slug, false);
    return redirect(URL_LANGUAGES_LIST);    
  }

  /* Language Pages */
  public function page_list()
  {
    $data['active_class']       = 'languages';
    $data['title']              = LanguageHelper::getPhrase('language_pages');
    $data['layout']             = 'layouts.admin.adminlayout';
    $data['module_helper']      = false;
    $data['admin']              = $this->admin;
    $data['breadcumbs']         = $this->breadcumbs;
    return view('lmanager::languages.page-list', $data);
  }
  public function getPageDatatable()
  {
    $records = LanguagePage::select([ 'title', 'is_active', 'id'])->orderBy('updated_at','desc');
    return Datatables::of($records)
      ->addColumn('action', function ($records) {
        $link_data = '<div class="dropdown more">
                  <a id="dLabel" type="button" class="dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-ellipsis-h"></i>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="dLabel">
                      <li><a href="'.URL_LANGUAGES_EDIT_PAGE.'/'.$records->id.'"><i class="fa fa-pencil"></i>'.LanguageHelper::getPhrase("edit").'</a></li>
                      <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->id.'\');"><i class="fa fa-trash"></i>'. LanguageHelper::getPhrase("delete").'</a></li>
                  </ul></div>';
        $link_data = $link_data;
        return $link_data;
      })
      ->editColumn('is_active',function ($records)
      {
         if($records->is_active)
          return '<i class="fa fa-check text-success" title="'.LanguageHelper::getPhrase('active').'"></i>';
          return '<i class="fa fa-close text-danger" title="'.LanguageHelper::getPhrase('in_active').'"></i>';
      })
      ->removeColumn('id')
      ->rawColumns(['title', 'is_active', 'action'])
      ->make(true);
  }
  public function add_page()
  {
    $data['record']             = FALSE;
    $data['active_class']       = 'languages';
    $data['title']              = LanguageHelper::getPhrase('add_language_page');
    $data['layout']             = 'layouts.admin.adminlayout';
    $data['module_helper']      = false;
    $data['admin']              = $this->admin;
    $data['breadcumbs']         = $this->breadcumbs;
    return view('lmanager::languages.add-edit-page', $data);
  }
  /**
   * This method adds record to DB
   * @param  Request $request [Request Object]
   * @return void
  */
  public function save_page(Request $request)
  {
    $this->validate($request, [
      'title'           => 'bail|required|max:400|unique:language_pages,title',
    ]);
    $record = new LanguagePage();
    //dd($request);
    $record->title          = $request->title;
    $record->is_active      = $request->is_active;
    $record->save();
    LanguageHelper::flash('success','record_added_successfully', 'success');
    return redirect(URL_LANGUAGE_PAGE_LIST);
  }

  /**
   * This method loads the edit view based on unique slug provided by user
   * @param  [string] $slug [unique slug of the record]
   * @return [view with record]       
   */
  public function edit_page($id)
  {
    $record = LanguagePage::where('id', $id)->get()->first();
    if($isValid = $this->isValidRecord($record))
      return redirect($isValid);
    $data['record']             = $record;
    $data['active_class']       = 'languages';
    $data['title']              = LanguageHelper::getPhrase('edit_language_page');
    $data['layout']             = 'layouts.admin.adminlayout';
    $data['admin']              = $this->admin;
    $data['breadcumbs']         = $this->breadcumbs;
    return view('lmanager::languages.add-edit-page', $data);
  }

  /**
   * Update record based on slug and reuqest
   * @param  Request $request [Request Object]
   * @param  [type]  $slug    [Unique Slug]
   * @return void
  */
  public function update_page(Request $request, $id)
  {
    $record                 = LanguagePage::where('id', $id)->get()->first();
    if($isValid = $this->isValidRecord($record))
      return redirect($isValid);

    $this->validate($request, [
      'title'           => 'bail|required|max:400|unique:language_pages,title,'.$record->id,
    ]);

    $record->title   = $request->title;
    $record->is_active = $request->is_active;
    $record->save();
    LanguageHelper::flash('success','record_updated_successfully', 'success');
    return redirect(URL_LANGUAGE_PAGE_LIST);
  }
  /**
   * Delete the language is the language is not set to default
   * @param  [type] $slug [description]
   * @return [type]       [description]
  */
  public function delete_page($id)
  {
    $record                 = LanguagePage::where('id', $id)->get()->first();
    if(!env('DEMO_MODE')) {
        $record->delete();
    }
    $response['status'] = 1;
    $response['message'] = LanguageHelper::getPhrase('record_deleted_successfully');
    return json_encode($response);
  }
}