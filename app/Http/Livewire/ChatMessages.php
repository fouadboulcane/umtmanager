<?php

namespace App\Http\Livewire;

use App\Models\Message;
use App\Models\User;
use Closure;
use Livewire\Component;
use Filament\Tables;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ChatMessages extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable; 

    protected $listeners = ['refreshUsers' => '$refresh'];

    protected function getTableQuery(): Builder 
    {
        // $users = User::getUsers();
        return Message::query()->where('receiver_id', Auth::id())->orWhere('sender_id', Auth::id())->latest();
        // return auth()->user()->messagesReceived()->query();
    } 

    protected function getTableColumns(): array 
    {
        return [
            // Tables\Columns\TextColumn::make('sender.name')->searchable(),
            Tables\Columns\ViewColumn::make('message')->view('tables.columns.chat-message')
                ->action(function(Message $record) {
                    $this->emit('userSelected', $record->sender);
                }),
            // Tables\Columns\TextColumn::make('created_at')->date('d-m-Y H:i')->alignment('right')
                // ->action(function(User $record) {
                //     $this->emit('userSelected', $record);
                // }),
            // Tables\Columns\ViewColumn::make('record')->view('tables.columns.avatar-name')
        ];
    }

    protected function getTableRecordUrlUsing()
    {
        // return function (User $record) {
        //     $this->dispatchBrowserEvent('userSelected', $record);
        //     return;
        // };
    }

    public function render(): View
    {
        return view('livewire.chat-users');
    }
}
