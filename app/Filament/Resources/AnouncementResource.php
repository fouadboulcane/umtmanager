<?php

namespace App\Filament\Resources;

use App\Models\Anouncement;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AnouncementResource\Pages;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Auth;

class AnouncementResource extends Resource
{
    protected static ?string $model = Anouncement::class;

    protected static ?string $navigationIcon = 'heroicon-o-speakerphone';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Other';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(12)->schema([
                Hidden::make('user_id')->dehydrateStateUsing(fn() => Auth::id()),
                TextInput::make('title')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Title')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                DatePicker::make('start_date')
                    ->rules(['required', 'date'])
                    ->placeholder('Start Date')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                DatePicker::make('end_date')
                    ->rules(['required', 'date'])
                    ->placeholder('End Date')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                RichEditor::make('content')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Content')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('share_with')
                    ->rules(['required', 'in:all_members,all_clients'])
                    ->searchable()
                    ->options([
                        'all_members' => 'All members',
                        'all_clients' => 'All clients',
                    ])
                    ->placeholder('Share With')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->limit(50)->searchable(),
                // Tables\Columns\TextColumn::make('author.name'),
                Tables\Columns\ViewColumn::make('author')->view('tables.columns.avatar-name'),
                Tables\Columns\TextColumn::make('start_date')->date(),
                Tables\Columns\TextColumn::make('end_date')->date(),
                // Tables\Columns\TextColumn::make('share_with')->enum([
                //     'all_members' => 'All members',
                //     'all_clients' => 'All clients',
                // ]),
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
                Tables\Actions\EditAction::make()->modalWidth('xl'),
                Tables\Actions\DeleteAction::make()
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAnouncements::route('/'),
            // 'index' => Pages\ListAnouncements::route('/'),
            // 'create' => Pages\CreateAnouncement::route('/create'),
            // 'edit' => Pages\EditAnouncement::route('/{record}/edit'),
        ];
    }
}
