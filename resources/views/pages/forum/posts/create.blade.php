<?php

use App\Models\Forum\Post;
use function Laravel\Folio\name;

name('forum.posts.create');
?>

<x-app-layout>
    @volt()
    <section>
        <x-title title="Create a new Forum Post"/>

        @can('create', Post::class)
            <livewire:forum.posts.create/>
        @else
            <div class="text-red-700 text-xl">You don't have access to this page</div>
        @endcan

    </section>
    @endvolt
</x-app-layout>
