<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\FaqCategory;

class FaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faqcategories = FaqCategory::where('status',1)->get();

        foreach ($faqcategories as $faqcategory) 
        {
        	factory(App\Models\Faq::class,3)->create([
        		'church_id'    		=> 	$faqcategory->church_id,
        		'faq_category_id'	=>	$faqcategory->id,
        		'status'        	=>	1,
        		'created_at'    	=> 	date("Y-m-d H:i:s"),
        		'updated_at'		=> 	date("Y-m-d H:i:s"),    
      		]);
        }
    }
}