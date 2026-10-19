<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeVue extends Command
{
    protected $signature = 'make:vue {name}';

    protected $description = 'Create a Vue component/page';

    public function handle()
    {
        $name = str_replace('\\', '/', $this->argument('name'));

        $path = resource_path("js/{$name}.vue");

        if (File::exists($path)) {
            $this->error("Vue file already exists!");
            return Command::FAILURE;
        }

        File::ensureDirectoryExists(dirname($path));

        File::put($path, $this->stub());

        $this->info("Vue component created:");
        $this->line($path);

        return Command::SUCCESS;
    }

    protected function stub(): string
    {
        return <<<VUE
<script setup>

</script>

<template>

</template>

<style scoped>

</style>

VUE;
    }
}