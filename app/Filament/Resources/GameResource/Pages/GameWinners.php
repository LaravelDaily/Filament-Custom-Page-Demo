<?php

namespace App\Filament\Resources\GameResource\Pages;

use Filament\Forms;
use App\Models\Player;
use App\Models\Result;
use App\Filament\Resources\GameResource;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;

class GameWinners extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string $resource = GameResource::class;

    protected static string $view = 'filament.resources.game-resource.pages.game-winners';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function submit()
    {
        $gameId = explode('/', request()->fingerprint['path'])[2];

        $results = [];
        $players = $this->form->getState()['players'];

        foreach ($players as $key => $item) {
            $results[] = [
                'user_id' => auth()->id(),
                'game_id' => $gameId,
                'position' => $key + 1,
                'player_id' => $item['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Result::insert($results);

        Notification::make()
            ->title('Winners has been set')
            ->success()
            ->send();

        $this->redirect(GameResource::getUrl());
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Repeater::make('players')
                ->schema([
                    Forms\Components\Select::make('name')
                        ->options(function (callable $get) {
                            $players = $get('../../players');
                            $idsAlreadyUsed = [];

                            foreach($players as $repeater) {
                                if(! in_array($repeater['name'], $idsAlreadyUsed)
                                    && $repeater['name'] !== null
                                    && $repeater['name'] != $get('name')) {
                                    $idsAlreadyUsed[] = $repeater['name'];
                                }
                            }

                            return Player::whereNotIn('id', $idsAlreadyUsed)->pluck('name', 'id')->toArray();
                        })
                        ->reactive()
                        ->required()
                ])
                ->disableLabel()
                ->defaultItems(10)
                ->disableItemCreation()
                ->disableItemDeletion()
                ->disableItemMovement()
        ];
    }
}
