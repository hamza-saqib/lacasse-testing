<?php
    // MyVendor\Contactform\src\Models\ContactForm.php
    namespace KDG\KBuilder\Models;
    use Illuminate\Database\Eloquent\Model;
    class KBuilder extends Model
    {
    	public $timestamps = false;
        protected $guarded = [];
        protected $table = 'gavias_blockbuilder';
    }