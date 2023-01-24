<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ArticleResource;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;
}
