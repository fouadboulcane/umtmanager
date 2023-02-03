<?php

namespace App\Filament\Pages;

use App\Models\Message;
use App\Models\User;
use Filament\{Tables, Forms};
use Filament\Forms\Components\Hidden;
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Messages extends Page
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-mail';

    protected static string $view = 'filament.pages.messages';

    protected $listeners = ['userSelected'];

    public $messages;

    // public Message $message;

    // public ?int $receiver_id = null;
    // public ?string $subject = '';
    // public ?string $body = ' ?string';

    // public function mount(): void
    // {
    //     $this->form->fill([
    //         'receiver_id' => $this->message->receiver_id,
    //         'subject' => $this->message->subject,
    //         'body' => $this->message->body,
    //     ]);
    // }

    public function userSelected(User $user)
    {
        $this->messages = auth()->user()->getMessages($user->id);
        // dd($this->messages);
    }

    public function getActions(): array 
    {
        return [
            Action::make('compose')
            ->form([
                Hidden::make('sender_id')->dehydrateStateUsing(fn() => Auth::id()),
                Select::make('receiver_id')->label('Receiver')->options(User::pluck('name', 'id'))
                    ->searchable()->required(),
                TextInput::make('subject'),
                RichEditor::make('body')
            ])
            ->action(function($data) {
                // dd($data);
                Message::create($data);
            })
            ->after(function($livewire) {
                $livewire->emit('refreshUsers');
            })
            ->modalWidth('xl')->icon('heroicon-o-pencil-alt')
        ];
    }
}
