<?php

namespace App\Filament\Pages;

use App\Models\Comment;
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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class Messages extends Page
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-mail';

    protected static string $view = 'filament.pages.messages';

    protected $listeners = ['userSelected', 'messageSelected', 'refreshComponent' => '$refresh'];

    public $conversation;

    public $comments;

    public $pageNumber = 1;

    public $hasMorePages;

    public function messageSelected(Message $message) {
        $this->conversation = $message;

        $this->comments = new Collection();
        $this->pageNumber = 1;
        $this->hasMorePages;
        $this->loadComments();
    }

    public function mount(): void 
    {
        $this->form->fill();
    }

    public function sendMessage()
    {
        $message = $this->conversation->comments()->create($this->form->getState());

        $this->form->fill();

        $this->comments->prepend($message);
    }

    public function loadComments()
    {
        $comments = $this->conversation->comments()->latest()->paginate(5, ['*'], 'page', $this->pageNumber);

        $this->pageNumber += 1;

        $this->hasMorePages = $comments->hasMorePages();

        $this->comments->push(...$comments->items());
    }

    protected function getFormSchema(): array
    {
        return [
            Hidden::make('user_id')->dehydrateStateUsing(fn() => Auth::id()),
            RichEditor::make('body')->disableLabel()
        ];
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
                Message::create($data);
            })
            ->after(function($livewire) {
                $livewire->emit('refreshUsers');
            })
            ->modalWidth('xl')->icon('heroicon-o-pencil-alt')
        ];
    }
}
