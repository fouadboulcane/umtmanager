<?php

namespace App\Filament\Resources;

use App\Models\DeviRequest;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use App\Filament\Resources\DeviRequestResource\Pages;
use App\Filament\Resources\DeviRequestResource\Pages\CreateDeviRequest;
use App\Filament\Resources\DeviRequestResource\Pages\EditDeviRequest;
use App\Models\Manifest;
use Closure;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Pages\Actions\ViewAction;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

class DeviRequestResource extends Resource
{
    protected static ?string $model = DeviRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $navigationGroup = 'Devis';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    // KeyValue::make('content')->columnSpan([
                    //     'default' => 12,
                    //     'md' => 12,
                    //     'lg' => 12,
                    // ]),

                    // BelongsToSelect::make('manifest_id')
                    //     ->rules(['required', 'exists:manifests,id'])
                    //     ->relationship('manifest', 'title')
                    //     ->searchable()
                    //     ->placeholder('Manifest')
                    //     ->columnSpan([
                    //         'default' => 12,
                    //         'md' => 12,
                    //         'lg' => 12,
                    //     ])
                    //     ->preload(),
                    //     ->reactive(),
                    Hidden::make('manifest_id')->default(intval(request()->get('manifest_id'))),

                    BelongsToSelect::make('client_id')
                        ->rules(['required', 'exists:clients,id'])
                        ->relationship('client', 'name')
                        ->searchable()
                        ->placeholder('Client')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    BelongsToSelect::make('user_id')
                        ->rules(['required', 'exists:users,id'])
                        ->relationship('assignedMember', 'name')
                        ->searchable()
                        ->placeholder('Assigned Member')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('status')
                        ->rules([
                            'required',
                            'in:pending,canceled,estimated,draft',
                        ])
                        ->searchable()
                        ->options([
                            'pending' => 'Pending',
                            'canceled' => 'Canceled',
                            'estimated' => 'Estimated',
                            'draft' => 'Draft',
                        ])
                        ->placeholder('Status')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                ])->columns(2),
            ])->columns(2),

            Section::make('Devi Form')
                ->schema([
                    Grid::make(['default' => 0])->schema(function (Closure $get, $record, $livewire) {
                        if (! $livewire instanceof CreateDeviRequest) {
                            Log::info($record);
                            $manifest_id = intval($record->manifest_id);
                        } else {
                            $manifest_id = intval(request()->get('manifest_id'));
                        }
                        if(empty($manifest_id)){
                            return array();
                        }
                        $fields = Manifest::find($manifest_id)->fields;
    
                        return array_map(function (array $field) {
                            if(empty($field['data'])) {
                                return TextInput::make('d')->hidden();
                            }
                            $config = $field['data'];
                            // $config['name'] = 'content.' . $config['name'];
                
                            return match ($field['type']) {
                                'text' => TextInput::make($config['name'])
                                    ->label($config['label'])
                                    ->required($config['is_required'])
                                    ->numeric(fn () => $config['type'] == 'number')
                                    ->email(fn () => $config['type'] == 'email'),
                                'select' => Select::make($config['name'])
                                    ->label($config['label'])
                                    ->options($config['options'])
                                    ->required($config['is_required'])
                                    ->multiple($config['is_multiple']),
                                'checkbox' => Checkbox::make($config['name'])
                                    ->label($config['label'])
                                    ->required($config['is_required']),
                                'file' => FileUpload::make($config['name'])
                                    ->label($config['label'])
                                    ->multiple($config['is_multiple'])
                                    ->required($config['is_required']),
                                'date' => DatePicker::make($config['name'])
                                    ->label($config['label'])
                                    ->required($config['is_required']),
                                // 'default' => false
                                // 'date' => TextInput::make($config['name'])
                                //     ->type('date')
                                //     ->label($config['label'])
                                //     ->required($config['is_required'])
                            };
                        }, $fields);
                        
                    })
                    ->statePath('content'),
                ]),
            
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('manifest.title')->limit(50)
                    ->url(fn (DeviRequest $record): string => route('filament.resources.manifests.index', $record)),
                Tables\Columns\TextColumn::make('client.name')->limit(50),
                Tables\Columns\TextColumn::make('assignedMember.name')->limit(
                    50
                ),
                Tables\Columns\TextColumn::make('status')->enum([
                    'pending' => 'Pending',
                    'canceled' => 'Canceled',
                    'estimated' => 'Estimated',
                    'draft' => 'Draft',
                ]),
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

                MultiSelectFilter::make('manifest_id')->relationship(
                    'manifest',
                    'title'
                ),

                MultiSelectFilter::make('client_id')->relationship(
                    'client',
                    'name'
                ),

                MultiSelectFilter::make('user_id')->relationship(
                    'assignedMember',
                    'name'
                ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeviRequests::route('/'),
            'create' => Pages\CreateDeviRequest::route('/create'),
            // 'view' => Pages\ViewDeviRequest::route('/{record}'),
            'edit' => Pages\EditDeviRequest::route('/{record}/edit'),
        ];
    }

}
