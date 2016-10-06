<?php

namespace App\Console\Commands;

use App\Apartment;
use App\Helpers\FetchDataFromHtml;
use App\Mail\Report;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ParseApartments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apt:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse apartments';

    /**
     * @var Client
     */
    protected $guzzle;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->guzzle = new Client();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $summary = (object) [
            'sold' => 0, 'booked' => 0, 'freed' => 0, 'broken' => 0, 'free' => 0
        ];

        $apartments = Apartment::all()->map(function (Apartment $apartment) use (&$summary) {
            $diff = $apartment->updateFromArray($this->fetchModelFromUrl($apartment->url));
            $apartment->diff = $diff;

            if($apartment->state === 'свободна') {
                $summary->free += 1;
            }
            if(isset($apartment->diff['state'])) {
                switch($apartment->diff['state']) {
                    case 'Бронь':
                        $summary->booked += 1;
                        break;
                    case 'свободна':
                        $summary->freed += 1;
                        break;
                    case 'Продана':
                        $summary->sold += 1;
                        break;
                    default:
                        $summary->broken += 1;
                }

            }

            return $apartment;
        });

        Mail::to('ikoolik@gmail.com')->cc('mrs.irina.kulikova@gmail.com')
            ->send(new Report(['apartments' => $apartments, 'summary' => $summary]));
    }

    protected function fetchModelFromUrl($url)
    {
        if(!cache()->has($url)) {
            $page = $this->guzzle->get($url);
            cache()->add($url, $page->getBody()->getContents(), 60);
        }
        $html = cache()->get($url);
        return FetchDataFromHtml::handle($html);
    }
}
