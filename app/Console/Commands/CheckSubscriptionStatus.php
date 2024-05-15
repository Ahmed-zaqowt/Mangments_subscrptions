<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

use function PHPUnit\Framework\isEmpty;

class CheckSubscriptionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check subscription status';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        $expiredSubscriptions = Subscription::where('status', Subscription::ACCEPTED)
            ->get();

        $expiredSubscriptionsTomorrow = Subscription::where('status', Subscription::ACCEPTED)
            ->whereDate('end',  Carbon::today()->addDays(3) )
            ->get();


        if ($expiredSubscriptionsTomorrow->isNotEmpty()) {
            foreach ($expiredSubscriptionsTomorrow as $subscription) {
                $basic = new \Vonage\Client\Credentials\Basic('ac403f49', '2HbnsHlqYznqPIdg');
                $client = new \Vonage\Client($basic);

                $response = $client->sms()->send(
                    new \Vonage\SMS\Message\SMS($subscription->subscriber->mobile, env('APP_NAME') ,'متبقي على الاشتراك الخاص بك ثلاث ايام ' , 'unicode')
                );

                $message = $response->current();
            }
        }


      

    }
}
