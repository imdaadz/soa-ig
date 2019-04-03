<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Lib\Instagram;

class ImportInstagram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:instagram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ig = new Instagram();
        $insert = array();
        $ids = array();
        $user = 'imdaadz';
        foreach($ig->getUserFeed($user) as $row){
            $caption = $ig->checkCaption($row['caption']);          
            if(!empty($caption)){
                $ids[] = $row['id'];
                $insert[$row['id']] = array(
                    'instagram_user' => $user,
                    'media_ig_id' => $row['id'],
                    'shortcode' => $row['shortCode'],
                    'link' => $row['link'],
                    'caption' => $row['caption'],
                    'ig_image' => $row['link'],
                    'product' => $ig->getClean($caption[0])
                );
            }
        }   
        
        $checkmedia = $ig->checkMediaID($ids);
        if (!empty($checkmedia)){
            foreach ($checkmedia as $row) {
                if($insert[$row->media_ig_id]){
                    unset($insert[$row->media_ig_id]);
                }
            }
        }
        if(!empty($insert))
            Instagram::insert($insert);

        echo "Success Import for : ".$user."\n";
    }
}
