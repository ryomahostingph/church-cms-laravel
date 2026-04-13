<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Church;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $churches = Church::where('status',1)->get();
        foreach ($churches as $church) 
        {
            $admin = User::ByChurch($church->id)->ByRole(3)->first();

            DB::table('subscriptions')->insert([
                'church_id'         => $church->id,
                'user_id'           => $admin->id,
                'plan_id'           => 1,
                'status'            => 'pending',
                'payment_details'   => '{"merchant_key":"","txnid":"","amount":"2000.00","firstname":"","email":"","phone":"","hash":"","productinfo":"Subscription Amount","status":"","mode":"","error_Message":"No Error","addedon":""}',
                'end_date'          => Carbon::now()->addMonth(1)->format('Y-m-d'),
                'created_at'        => date("Y-m-d H:i:s"),
                'updated_at'        => date("Y-m-d H:i:s"), 
            ]);
        }
    }
}