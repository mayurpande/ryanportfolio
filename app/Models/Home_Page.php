<?php

namespace App\Models;

//we need to extend models eloquent's class
use Illuminate\Database\Eloquent\Model;



class Home_Page extends Model{
//by doing this we now have the ability to use this class as a direct connection to our db table

	//eloquent takes the singular version of the class name and it will automatically look for a table
	//with the plural version. If your table differs we can explicitly name it like below
	protected $table = 'home_page';

	protected $fillable = [
		'home_img',
		'next_ul',
		'ul_id',
		'ul_update_no',
		'high_res_img',
		'lightbox_text',
		'gallery_text',
	];
}
