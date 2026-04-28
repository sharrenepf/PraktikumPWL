<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTag extends EditRecord
{
    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Pastikan menggunakan Actions\DeleteAction agar terbaca oleh Filament
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        // Redirect kembali ke halaman index setelah sukses mengedit
        return $this->getResource()::getUrl('index');
    }
}

