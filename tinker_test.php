<?php
dump(App\Models\Author::selectSub(function($q) { 
    $q->selectRaw('COUNT(*)')->from('book_author')->whereColumn('author_id', 'authors.id'); 
}, 'authored_books_count')->first()->toArray());
