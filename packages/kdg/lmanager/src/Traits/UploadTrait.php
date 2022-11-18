<?php
	namespace KDG\KBuilder\Traits;

	use Illuminate\Http\UploadedFile;
	use Illuminate\Support\Facades\Storage;

	trait UploadTrait
	{
	    public static function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
	    {
	    	//echo $folder;
	        $name = !is_null($filename) ? $filename : str_random(25);
	        $file = $uploadedFile->storeAs($folder, $name, $disk);
	        //$file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);
	        //$file = //$uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);
	        //$file = Storage::disk('public_uploads')->put($folder, $name);
	        return $file;
	    }
	}