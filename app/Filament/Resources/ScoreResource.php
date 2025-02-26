<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScoreResource\Pages;
use App\Models\Score;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class ScoreResource extends Resource
{
    protected static ?string $model = Score::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static function hexToBytes($hex)
    {
        $bytes = '';
        for ($i = 0; $i < strlen($hex); $i += 2) {
            $bytes .= chr(hexdec(substr($hex, $i, 2)));
        }
        return $bytes;
    }

    protected static function crc16($data)
    {
        $crc = 0;
        for ($i = 0; $i < strlen($data); $i++) {
            $crc = $crc ^ (ord($data[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                if ($crc & 0x8000) {
                    $crc = (($crc << 1) ^ 0x1021) & 0xFFFF;
                } else {
                    $crc = ($crc << 1) & 0xFFFF;
                }
            }
        }
        return chr($crc >> 8) . chr($crc & 0xff);
    }

    protected static function convertToFriendly($rawAddress, $bounceable = true)
    {
        // Parse the raw address
        list($workchainStr, $hashHex) = explode(':', $rawAddress);
        $workchain = intval($workchainStr);
        $hash = static::hexToBytes($hashHex);

        // Constants
        $bounceable_tag = 0x11;
        $non_bounceable_tag = 0x51;

        // Create address bytes
        $addr = chr($bounceable ? $bounceable_tag : $non_bounceable_tag) .
            chr($workchain) .
            $hash;

        // Add CRC
        $crc = static::crc16($addr);
        $addressWithChecksum = $addr . $crc;

        // Convert to base64 and make URL safe
        return strtr(base64_encode($addressWithChecksum), '+/', '-_');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Wallet')
                    ->formatStateUsing(fn($state) => static::convertToFriendly($state, false))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('score')
                    ->sortable(),
                Tables\Columns\TextColumn::make('username')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('firstname')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('lastname')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('photo_url')
                    ->circular(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListScores::route('/'),
        ];
    }
}
