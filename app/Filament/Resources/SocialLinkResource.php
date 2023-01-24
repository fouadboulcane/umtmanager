<?php

namespace App\Filament\Resources;

use App\Models\SocialLink;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use App\Filament\Resources\SocialLinkResource\Pages;

class SocialLinkResource extends Resource
{
    protected static ?string $model = SocialLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'facebook';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('facebook')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Facebook')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('twitter')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Twitter')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('linkedin')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Linkedin')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('google_plus')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Google Plus')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('digg')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Digg')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('youtube')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Youtube')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('pinterest')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Pinterest')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('instagram')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Instagram')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('github')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Github')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('tumblr')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Tumblr')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('tiktok')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Tiktok')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    BelongsToSelect::make('user_id')
                        ->rules(['required', 'exists:users,id'])
                        ->relationship('user', 'name')
                        ->searchable()
                        ->placeholder('User')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('facebook')->limit(50),
                Tables\Columns\TextColumn::make('twitter')->limit(50),
                Tables\Columns\TextColumn::make('linkedin')->limit(50),
                Tables\Columns\TextColumn::make('google_plus')->limit(50),
                Tables\Columns\TextColumn::make('digg')->limit(50),
                Tables\Columns\TextColumn::make('youtube')->limit(50),
                Tables\Columns\TextColumn::make('pinterest')->limit(50),
                Tables\Columns\TextColumn::make('instagram')->limit(50),
                Tables\Columns\TextColumn::make('github')->limit(50),
                Tables\Columns\TextColumn::make('tumblr')->limit(50),
                Tables\Columns\TextColumn::make('tiktok')->limit(50),
                Tables\Columns\TextColumn::make('user.name')->limit(50),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),

                MultiSelectFilter::make('user_id')->relationship(
                    'user',
                    'name'
                ),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSocialLinks::route('/'),
            'create' => Pages\CreateSocialLink::route('/create'),
            'edit' => Pages\EditSocialLink::route('/{record}/edit'),
        ];
    }
}
