<?php

namespace App\Filament\Resources;

use App\Models\Note;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\NoteResource\Pages;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;

class NoteResource extends Resource
{
    protected static ?string $model = Note::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-alt';

    protected static ?string $recordTitleAttribute = 'title';
    
    protected static ?string $navigationGroup = 'Other';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                Hidden::make('user_id')->dehydrateStateUsing(fn() => Auth::id()),
                Hidden::make('noteable_id')->dehydrateStateUsing(fn() => Auth::id()),
                Hidden::make('noteable_type')->dehydrateStateUsing(fn() => 'App\Models\User'),
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
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageNotes::route('/'),
            // 'index' => Pages\ListNotes::route('/'),
            // 'create' => Pages\CreateNote::route('/create'),
            // 'edit' => Pages\EditNote::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('noteable_type', 'App\Models\User')->where('user_id', Auth::id());
    }
}
