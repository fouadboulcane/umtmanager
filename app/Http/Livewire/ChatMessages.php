<?php

namespace App\Http\Livewire;

use App\Models\Message;
use Livewire\Component;
use Filament\Tables;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ChatMessages extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected $listeners = ['refreshUsers' => '$refresh'];

    public string $msgtype = 'received';

    protected $queryString = [
        'tableFilters'
    ];

    protected function getTableQuery(): Builder 
    {
        if($this->msgtype == 'received') {
            return Message::query()->with('sender', 'receiver')->where('receiver_id', Auth::id())->latest();
        }elseif($this->msgtype == 'sent') {
            return Message::query()->with('sender', 'receiver')->where('sender_id', Auth::id())->latest();
        }else {
            return Message::query()->with('sender', 'receiver');
        }
    }

    public function setFilter($value)
    {
        $this->tableFilters['msgs']['type']=$value;
    }

    protected function getTableColumns(): array 
    {
        return [
            Tables\Columns\ViewColumn::make('message')->view('tables.columns.chat-message')
                ->action(function(Message $record) {
                    $this->emit('messageSelected', $record);
                    // if(Auth::id() == $record->sender->id){
                    //     $this->emit('userSelected', $record->receiver);
                    // } else {
                    //     $this->emit('userSelected', $record->sender);
                    // }
                })->searchable(['subject', 'body', 'sender.name', 'receiver.name']),
        ];
    }

    // protected function getTableFilters(): array
    // {
    //     return [
    //         Filter::make('msgs')
    //             ->form([
    //                 Select::make('type')
    //                 ->options([
    //                     'sent' =>'Messages Sent',
    //                     'received' => 'Messages Received'
    //                 ])
    //             ])
    //             ->query(function (Builder $query, $data) {
    //                 if(!empty($data["type"])) {
    //                     if($data['type'] == 'sent') $query->where('sender_id', Auth::id());
    //                     if($data['type'] == 'received') $query->where('receiver_id', Auth::id());
    //                 }
    //             })
    //     ];
    // }

    protected function getTableHeader(): View|Htmlable|null
    {
        return view('livewire.chat-tabs');
    }

    protected function getTableRecordUrlUsing()
    {
        // 
    }

    public function render(): View
    {
        return view('livewire.chat-users');
    }
}
