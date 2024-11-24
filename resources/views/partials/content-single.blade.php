<article @php(post_class('h-entry'))>
    <header>
        <h1 class="p-name font-bold text-4xl mb-6">
            {!! $title !!}
        </h1>
    </header>

    <div class="e-content mb-8">
        @php(the_content())
    </div>

    @php(comments_template())
</article>
