<?php

namespace App\Console\Commands;

use App\Models\Collection;
use App\Models\Page;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a sitemap for the website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Create empty sitemap
        $sitemap = Sitemap::create();

        // Get all published pages
        Page::where('status', 'published')
            ->get()
            ->each(fn ($page) => $sitemap->add($page));

        Collection::where('status', 'published')
            ->get()
            ->each(fn ($collection) => $sitemap->add($collection));

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }
}
