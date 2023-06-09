<?php

namespace App\Filament\Resources;

use App\Models\Game;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\GameResource\Pages;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
            ])
            ->prependActions([
                Tables\Actions\Action::make('Pick winners')
                    ->color('success')
                    ->url(fn(Game $record): string =>  self::getUrl('winners', ['record' => $record]))
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'   => Pages\ListGames::route('/'),
            'create'  => Pages\CreateGame::route('/create'),
            'edit'    => Pages\EditGame::route('/{record}/edit'),
            'winners' => Pages\GameWinners::route('/{record}/winners'),
        ];
    }
}
