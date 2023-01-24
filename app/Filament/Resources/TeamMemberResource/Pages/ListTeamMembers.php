<?php

namespace App\Filament\Resources\TeamMemberResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TeamMemberResource;

class ListTeamMembers extends ListRecords
{
    protected static string $resource = TeamMemberResource::class;
}
