<?php

namespace App\Filament\Resources;

use App\Models\Post;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Help & Support';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->lazy()
                                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),

                                Forms\Components\TextInput::make('slug')
                                    ->disabled()
                                    ->required()
                                    ->unique(Post::class, 'slug', ignoreRecord: true),

                                Forms\Components\MarkdownEditor::make('content')
                                    ->required()
                                    ->columnSpan('full'),

                                // Forms\Components\Select::make('blog_author_id')
                                //     ->relationship('author', 'name')
                                //     ->searchable()
                                //     ->required(),

                                // Forms\Components\Select::make('blog_category_id')
                                //     ->relationship('category', 'name')
                                //     ->searchable()
                                //     ->required(),

                                // Forms\Components\DatePicker::make('published_at')
                                //     ->label('Published Date'),

                                // SpatieTagsInput::make('tags'),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('Image')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Image')
                                    ->image()
                                    ->disableLabel(),
                            ])
                            ->collapsible(),
                    ])
                    ->columnSpan(['lg' => fn (?Post $record) => $record === null ? 3 : 2]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Post $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Post $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Post $record) => $record === null),
            ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);


        // return $form->schema([
        //     Card::make()->schema([
        //         Grid::make(['default' => 0])->schema([
        //             TextInput::make('title')
        //                 ->rules(['required', 'max:255', 'string'])
        //                 ->placeholder('Title')
        //                 ->columnSpan([
        //                     'default' => 12,
        //                     'md' => 12,
        //                     'lg' => 12,
        //                 ]),

        //             RichEditor::make('content')
        //                 ->rules(['required', 'max:255', 'string'])
        //                 ->placeholder('Content')
        //                 ->columnSpan([
        //                     'default' => 12,
        //                     'md' => 12,
        //                     'lg' => 12,
        //                 ]),

        //             Select::make('type')
        //                 ->rules(['required', 'in:help,base_knowledge'])
        //                 ->searchable()
        //                 ->options([
        //                     'help' => 'Help',
        //                     'base_knowledge' => 'Base knowledge',
        //                 ])
        //                 ->placeholder('Type')
        //                 ->columnSpan([
        //                     'default' => 12,
        //                     'md' => 12,
        //                     'lg' => 12,
        //                 ]),

        //             Select::make('status')
        //                 ->rules(['required', 'in:active,inactive'])
        //                 ->searchable()
        //                 ->options([
        //                     'active' => 'Active',
        //                     'inactive' => 'Inactive',
        //                 ])
        //                 ->placeholder('Status')
        //                 ->columnSpan([
        //                     'default' => 12,
        //                     'md' => 12,
        //                     'lg' => 12,
        //                 ]),

        //             BelongsToSelect::make('category_id')
        //                 ->rules(['required', 'exists:categories,id'])
        //                 ->relationship('category', 'title')
        //                 ->searchable()
        //                 ->placeholder('Category')
        //                 ->columnSpan([
        //                     'default' => 12,
        //                     'md' => 12,
        //                     'lg' => 12,
        //                 ]),
        //         ]),
        //     ]),
        // ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->limit(50)->searchable(),
                // Tables\Columns\TextColumn::make('content')->limit(50),
                Tables\Columns\TextColumn::make('type')->enum([
                    'help' => 'Help',
                    'base_knowledge' => 'Base knowledge',
                ]),
                Tables\Columns\BadgeColumn::make('status')->enum([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ]),
                Tables\Columns\TextColumn::make('category.title')->limit(15),
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

                MultiSelectFilter::make('category_id')->relationship(
                    'category',
                    'title'
                ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
