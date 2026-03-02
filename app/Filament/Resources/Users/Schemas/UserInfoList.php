<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserInfoList
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nombres'),

                TextEntry::make('email')
                    ->label('Correo electrónico'),

                TextEntry::make('is_active')
                    ->label('Estado')
                    ->badge()
                    ->icon(fn(bool $state) => $state ? Heroicon::CheckCircle : Heroicon::XCircle)
                    ->formatStateUsing(
                        fn(bool $state) => $state ? "Activo" : "Inactivo",
                    )
                    ->color(fn(bool $state) => $state ? "success" : "danger"),

                TextEntry::make('created_at')
                    ->label('Creado el')
                    ->dateTime('d/m/Y H:i:s'),

                TextEntry::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime('d/m/Y H:i:s')
            ]);
    }
}
