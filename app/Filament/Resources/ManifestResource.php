<?php

namespace App\Filament\Resources;

use App\Models\Manifest;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ManifestResource\Pages;
use Closure;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Illuminate\Support\Str;

class ManifestResource extends Resource
{
    protected static ?string $model = Manifest::class;

    protected static ?string $navigationIcon = 'heroicon-o-view-list';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Devis';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
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

                    Toggle::make('status')
                        ->rules(['required', 'boolean'])
                        ->default('1')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Toggle::make('is_public')
                        ->rules(['required', 'boolean'])
                        ->default('0')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Toggle::make('has_files')
                        ->rules(['required', 'boolean'])
                        ->default('0')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                    
                ]),
            ]),

            Card::make()->schema([
                \Filament\Forms\Components\Builder::make('fields')
                ->blocks([
                    Block::make('text')
                        ->label('Text input')
                        ->icon('heroicon-o-annotation')
                        ->schema([
                            static::getFieldNameInput(),
                            Grid::make()
                            ->schema([
                                Select::make('type')
                                    ->options([
                                        'text' => 'Text',
                                        // 'date' => 'Date',
                                        'email' => 'Email', 
                                        'number' => 'Number'
                                    ])
                                    ->default('text'),
                                Checkbox::make('is_required'),
                            ]),
                        ]),
                    Block::make('select')
                        ->icon('heroicon-o-selector')
                        ->schema([
                            static::getFieldNameInput(),
                            KeyValue::make('options')
                                ->addButtonLabel('Add option')
                                ->keyLabel('Value')
                                ->valueLabel('Label'),
                            Grid::make()
                            ->schema([
                                Checkbox::make('is_multiple'),
                                Checkbox::make('is_required'),
                            ]),
                        ]),
                    Block::make('checkbox')
                        ->icon('heroicon-o-check-circle')
                        ->schema([
                            static::getFieldNameInput(),
                            Checkbox::make('is_required'),
                        ]),
                    Block::make('date')
                        ->icon('heroicon-o-calendar')
                        ->schema([
                            static::getFieldNameInput(),
                            Checkbox::make('is_required'),
                        ]),
                    Block::make('file')
                        ->icon('heroicon-o-photograph')
                        ->schema([
                            static::getFieldNameInput(),
                            Grid::make()
                                ->schema([
                                    Checkbox::make('is_multiple'),
                                    Checkbox::make('is_required'),
                                ]),
                        ]),
                ])
                ->createItemButtonLabel('Add form input')
                ->disableLabel(),
                // Grid::make(['default' => 0])->schema([
                //     Repeater::make('fields')
                //         ->schema([
                //             TextInput::make('title')->required(),
                //             TextInput::make('placeholder')->required(),
                //             Select::make('type')
                //                 ->options([
                //                     'text' => 'Text',
                //                     'textarea' => 'Textarea',
                //                     'select' => 'Select',
                //                     'multiselect' => 'Multiselect',
                //                     'email' => 'Email',
                //                     'date' => 'Date',
                //                     'number' => 'Number',
                //                     'external_link' => 'External Link',
                //                 ])
                //                 ->required()
                //                 ->reactive(),
                //             // Toggle::make('required')
                //             Checkbox::make('required')
                //                 ->rules(['required', 'boolean'])
                //                 ->default('0')
                //                 ->inline(false),

                //             TagsInput::make('options')
                //                 ->columnSpan([
                //                     'default' => 12,
                //                     'md' => 12,
                //                     'lg' => 12,
                //                 ])
                //                 ->hidden(fn (Closure $get) => !in_array($get('type'), ['select', 'multiselect']))


                //         ])
                //         ->columns(4)
                //         ->columnSpan([
                //             'default' => 12,
                //             'md' => 12,
                //             'lg' => 12,
                //         ]),
                // ])
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->limit(50),
                // Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\BooleanColumn::make('status'),
                Tables\Columns\BooleanColumn::make('is_public'),
                Tables\Columns\BooleanColumn::make('has_files'),
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
        return [
            ManifestResource\RelationManagers\DeviRequestsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListManifests::route('/'),
            'create' => Pages\CreateManifest::route('/create'),
            'edit' => Pages\EditManifest::route('/{record}/edit'),
        ];
    }

    public static function getFieldNameInput(): Grid
    {
        // This is not a Filament-specific method, simply saves on repetition
        // between our builder blocks.

        return Grid::make()
            ->schema([
                TextInput::make('name')
                    ->lazy()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $label = Str::of($state)
                            ->kebab()
                            ->replace(['-', '_'], ' ')
                            ->ucfirst();

                        $set('label', $label);
                    })
                    ->required(),
                TextInput::make('label')
                    ->required(),
            ]);
    }

}
