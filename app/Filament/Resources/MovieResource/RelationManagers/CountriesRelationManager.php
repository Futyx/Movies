<?php

namespace App\Filament\Resources\MovieResource\RelationManagers;

use App\Models\MovieCountry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountriesRelationManager extends RelationManager
{
    protected static string $relationship = 'countries';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('country')
                    ->options(MovieCountry::get())
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('country')
            ->columns([
                Tables\Columns\TextColumn::make('country'),
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
