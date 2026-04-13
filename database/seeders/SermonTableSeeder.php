<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Church;
use App\Models\User;

class SermonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $churchs = Church::where('status',1)->get();
        foreach ($churchs as $church) 
        {
            $preacher = User::where([['church_id',$church->id],['usergroup_id',6]])->first();

            factory(App\Models\Sermon::class,3)->create([
                'church_id' =>  $church->id,
                'user_id'   =>  "25" 
            ])->each(function($sermon) use($preacher){
                factory(App\Models\SermonLink::class,5)->create([
                    'church_id'     =>  $preacher->church_id,
                    'user_id'       =>  $preacher->id,
                    'sermons_id'    =>  $sermon->id
                ]);
            });
        }
    }
}