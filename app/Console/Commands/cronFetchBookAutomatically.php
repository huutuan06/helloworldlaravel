<?php

namespace App\Console\Commands;

use App\Http\Controllers\Dashboard\BookController;
use Illuminate\Console\Command;

class cronFetchBookAutomatically extends Command
{
    protected $bookController;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cronFetchBookAutomatically';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Using for fetching book';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(BookController $bookController)
    {
        parent::__construct();
        $this->bookController = $bookController;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->bookController->topSellingBook("https://www.amazon.com/gp/bestsellers/2019/books", 0);
//        $this->bookController->topSellingBook("https://www.amazon.com/gp/bestsellers/2019/books/ref=zg_bsar_pg_2?ie=UTF8&pg=2", 50);
    }
}
