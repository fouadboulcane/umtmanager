<?php

namespace App\Filament\Resources;

use App\Models\Category;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategoryResource\Pages;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Help & Support';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(12)->schema([
                TextInput::make('title')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Title')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                RichEditor::make('description')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Description')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('sort')
                    ->rules(['required', 'numeric'])
                    ->numeric()
                    ->placeholder('Sort')
                    ->columnSpan([
                        'default' => 6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                Select::make('type')
                    ->rules(['required', 'in:help,base_knowledge'])
                    ->searchable()
                    ->options([
                        'help' => 'Help',
                        'base_knowledge' => 'Base knowledge',
                    ])
                    ->placeholder('Type')
                    ->columnSpan([
                        'default' =>6,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                // Select::make('status')
                //     ->rules(['required', 'in:active,inactive'])
                //     ->searchable()
                //     ->options([
                //         'active' => 'Active',
                //         'inactive' => 'Inactive',
                //     ])
                //     ->placeholder('Status')
                //     ->columnSpan([
                //         'default' => 12,
                //         'md' => 12,
                //         'lg' => 12,
                //     ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->limit(50)->searchable(),
                // Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('sort'),
                Tables\Columns\BadgeColumn::make('type')->enum([
                    'help' => 'Help',
                    'base_knowledge' => 'Base knowledge',
                ]),
                Tables\Columns\ToggleColumn::make('status')
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
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [CategoryResource\RelationManagers\PostsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCategories::route('/'),
            // 'index' => Pages\ListCategories::route('/'),
            // 'create' => Pages\CreateCategory::route('/create'),
            // 'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
