<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateNews extends CreateRecord
{
    protected static string $resource = NewsResource::class;

    protected function beforeValidate(): void
    {
        $data = $this->form->getState();

        $data['slug'] = Str::slug($data['title']);

        $this->form->fill($data);
    }
}
