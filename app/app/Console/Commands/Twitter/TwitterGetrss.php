<?php

namespace App\Console\Commands\Twitter;

use Illuminate\Console\Command;

class TwitterGetrss extends Command
{
	public $domain = "https://twitter-great-rss.herokuapp.com";
	public $home_tw = "/feed/home?"; // users home timeline
	public $user_tw = "/feed/user?"; // users tweet
	public $fav = "/feed/user/fav?"; //favo
	public $list = "/feed/list?"; // users list
	public $search = "/feed/search?"; // search
	public $url_id_hash = "3d0bcd52ad998ad6ed1b72d816af4d04544cb26b";



	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'twitter:getrss {user}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get tweet from RSS';

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
	 * @return int
	 */
	public function handle()
	{
		
		$tweets = $this->gettweet($this->argument('user'));


		echo $this->argument('user')."'s all Tweets have been acquired.\n";
		return Command::SUCCESS;
	}

	public function gettweet($twitter_user){
		$tweets = [];

		/**
		 * 
		 */
		$rss = $this->domain.$this->user_tw.$twitter_user.'&url_id_hash='.$this->url_id_hash;
		$getrss = file_get_contents($rss);
		$xml = simplexml_load_string($getrss);
		// $xml = json_decode(json_encode(simplexml_load_string($getrss),TRUE));
		$i=0;
		
		foreach ($xml as $objects) {
			foreach ($objects as $key => $lines) {
				
				if ($i < 10) {
					// echo $i."::";
					// var_dump($lines);
					echo $lines->title."\n";
					echo $lines->link."\n";
					echo $lines->description."\n";
					echo $lines->author."\n";
					echo $lines->pubDate."\n";

					/**
					 * 
					 */



					$i++;
				} else {
					$i++;
				}
				

			}
		}
		// var_dump($xml);

		
		return $tweets;
	}
}
