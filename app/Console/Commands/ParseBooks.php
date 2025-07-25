<?php

namespace App\Console\Commands;

use App\Services\BookParserInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ParseBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(BookParserInterface $bookParser): int
    {
        $this->info('Starting book parsing...');

        $url = config('parser.book_parser_resource_url');
        if (empty($url)) {
            $this->error('Book parser resource URL is not set in the configuration.');
            Log::error('Book parser resource URL is not set in the configuration.');
            return Command::FAILURE;
        }
        try {
            $bookParser->parseResource($url);
            $this->info('Book parsing completed successfully.');
        } catch (\Exception $e) {
            Log::error('An error occurred while parsing books', [
                'error' => $e,
                'url'   => $url,
            ]);
            $this->error('An error occurred while parsing books: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
