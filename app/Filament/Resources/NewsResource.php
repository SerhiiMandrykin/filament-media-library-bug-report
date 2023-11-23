<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $label = 'Новину';

    protected static ?string $pluralLabel = 'Новини';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                [
                    Forms\Components\TextInput::make('title')
                                              ->required()
                                              ->maxLength(255)
                                              ->columnSpanFull(),
                    Forms\Components\RichEditor::make('text')
                                               ->required()
                                               ->columnSpanFull()
                                               ->fileAttachmentsDisk(config('media-library.disk_name'))
                                               ->fileAttachmentsDirectory('news-attachments')
                                               ->fileAttachmentsVisibility('public'),

                    SpatieMediaLibraryFileUpload::make('images')
                                                ->label('Зображення')
                                                ->collection('default')
                                                ->multiple()
                                                ->image()
                                                ->disk(config('media-library.disk_name'))
                                                ->conversion('thumb')
                                                ->columnSpanFull()
                ]
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                [
                    Tables\Columns\TextColumn::make('id')
                                             ->label('ID')
                                             ->sortable(),
                    Tables\Columns\TextColumn::make('title')
                                             ->label('Назва'),
                    Tables\Columns\TextColumn::make('slug')
                                             ->label('Slug'),
                    Tables\Columns\TextColumn::make('created_at')
                                             ->label('Дата створення')
                                             ->sortable(),
                ]
            )
            ->filters(
                [
                    //
                ]
            )
            ->actions(
                [
                    Tables\Actions\EditAction::make(),
                ]
            )
            ->bulkActions(
                [
                    Tables\Actions\BulkActionGroup::make(
                        [
                            Tables\Actions\DeleteBulkAction::make(),
                        ]
                    ),
                ]
            )
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit'   => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
