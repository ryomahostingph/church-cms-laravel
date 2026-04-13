<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Church;
use App\Models\User;

class EventsTableSeeder extends Seeder
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
            $admin = User::where([['church_id',$church->id],['usergroup_id',3]])->first();
            
            factory(App\Models\Events::class,2)->create([
                'church_id' => $church->id,
            ])->each(function($event) use($admin) {
                factory(App\Models\EventGallery::class, 20)->create([
                    'event_id'      => $event->id , 
                    'church_id'     => $event->church_id,
                    'created_by'    => $admin->id, 
                    'updated_by'    => $admin->id
                ]);
            });
        }
    }
}