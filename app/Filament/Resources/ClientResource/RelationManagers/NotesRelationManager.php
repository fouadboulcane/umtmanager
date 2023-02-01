<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\MorphManyRelationManager;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Tables\Columns\SpatieTagsColumn;
use Illuminate\Support\Facades\Auth;

class NotesRelationManager extends MorphManyRelationManager
{
    protected static string $relationship = 'notes';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                Hidden::make('user_id')->dehydrateStateUsing(fn() => Auth::id()),
                TextInput::make('title')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Title')
                    ->columnSpan(2),

                RichEditor::make('description')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Description')
                    ->columnSpan(2),

                SpatieTagsInput::make('tags')->type('notes')
                    ->columnSpan(2),

                FileUpload::make('attachments')->multiple()
                    ->columnSpan(2)
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->date('d-m-Y H:i'),
                Tables\Columns\TextColumn::make('title')->limit(50)->searchable(),
                SpatieTagsColumn::make('tags')->type('notes'),
                // Tables\Columns\TextColumn::make('description')->limit(50),
            ])
            ->filters([
                // Tables\Filters\Filter::make('created_at')
                //     ->form([
                //         Forms\Components\DatePicker::make('created_from'),
                //         Forms\Components\DatePicker::make('created_until'),
                //     ])
                //     ->query(function (Builder $query, array $data): Builder {
                //         return $query
                //             ->when(
                //                 $data['created_from'],
                //                 fn(
                //                     Builder $query,
                //                     $date
                //                 ): Builder => $query->whereDate(
                //                     'created_at',
                //                     '>=',
                //                     $date
                //                 )
                //             )
                //             ->when(
                //                 $data['created_until'],
                //                 fn(
                //                     Builder $query,
                //                     $date
                //                 ): Builder => $query->whereDate(
                //                     'created_at',
                //                     '<=',
                //                     $date
                //                 )
                //             );
                //     }),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->icon('heroicon-o-plus')->modalWidth('xl')
            ]);
    }
}
