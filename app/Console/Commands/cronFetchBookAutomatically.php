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
        $this->bookController->topselling();
    }
}
