<?php

namespace App\Filament\Resources\MovieResource\RelationManagers;

use App\Models\Genre;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GenresRelationManager extends RelationManager
{
    protected static string $relationship = 'genres';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('genre_id')
                    ->label('genre')
                    ->options(Genre::get()->pluck('name', 'id'))
                    
                    
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('generes')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
