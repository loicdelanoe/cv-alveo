<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Block extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:block {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a basic vue file for a block';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = resource_path("js/Components/Blocks/{$this->argument('name')}.vue");

        $fileContent = <<<'EOT'
        <script setup lang="ts">
        defineProps<{
            content: any
        }>()
        </script>

        <template>
            <section></section>
        </template>

        <style scoped></style>
        EOT;

        if (! File::exists(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }

        $written = File::put($path, $fileContent);

        if ($written) {
            $this->info('Created new Block '.$this->argument('name').' in resources/js/Components/Blocks');
        } else {
            $this->error('Failed to create block.');
        }
    }
}
