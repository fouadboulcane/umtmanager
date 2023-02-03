<?php

namespace App\Http\Livewire;

use App\Models\User;
use Closure;
use Livewire\Component;
use Filament\Tables;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ChatUsers extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable; 

    protected $listeners = ['refreshUsers' => '$refresh'];

    protected function getTableQuery(): Builder 
    {
        $users = User::getUsers();
        return User::query()->whereIn('id', $users);
    } 

    protected function getTableColumns(): array 
    {
        return [
            Tables\Columns\TextColumn::make('fullname')->searchable()
                ->action(function(User $record) {
                    $this->emit('userSelected', $record);
                }),
            Tables\Columns\TextColumn::make('created_at')->date('d-m-Y H:i')->alignment('right')
                ->action(function(User $record) {
                    $this->emit('userSelected', $record);
                }),
            Tables\Columns\ViewColumn::make('record')->view('tables.columns.avatar-name')
        ];
    }

    protected function getTableRecordUrlUsing()
    {
        return function ($record) {
            dd($record);
            // $this->dispatchBrowserEvent('userSelected', $record);
            return;
        };
        // return fn ($record): string => route('filament.resources.users.view', $record->id);
    }

    public function render(): View
    {
        return view('livewire.chat-users');
    }
}
