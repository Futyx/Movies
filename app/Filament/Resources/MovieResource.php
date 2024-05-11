<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovieResource\Pages;
use App\Filament\Resources\MovieResource\RelationManagers;
use App\Filament\Resources\MovieResource\RelationManagers\CountriesRelationManager;
use App\Filament\Resources\MovieResource\RelationManagers\GenresRelationManager;
use App\Filament\Resources\MovieResource\RelationManagers\ImagesRelationManager;
use App\Models\Movie;
use App\Models\MovieImage;
use Filament\Actions\Modal\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovieResource extends Resource
{
    protected static ?string $model = Movie::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()

                    ->schema([

                        TextInput::make('title')->required(),
                        TextInput::make('year')->numeric(),
                        Select::make('country')
                            ->options(Movie::get('country')),
                        TextInput::make('imdb_rating'),
                        FileUpload::make('poster')->image()->nullable(),
                        TextInput::make('images.image')->nullable(),



                    ])->columns(3)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table


            ->columns([
                
                ImageColumn::make('poster')
                    ->circular()
                    ->defaultImageUrl(url('/.png')),

                TextColumn::make('title')
                    ->searchable()
                    ->fontFamily(FontFamily::Mono)
                    ->alignment(Alignment::Center),
                TextColumn::make('year')
                    ->searchable()
                    ->sortable()
                    ->fontFamily(FontFamily::Mono)
                    ->alignment(Alignment::Center),
                TextColumn::make('genres.name')
                    ->searchable()
                    ->wrap()
                    ->fontFamily(FontFamily::Mono)
                    ->alignment(Alignment::Center),
                ColumnGroup::make('More Detail', [
                    TextColumn::make('country')
                        ->searchable()
                        ->grow(false)
                        ->fontFamily(FontFamily::Mono)
                        ->color('primary')
                        ->alignment(Alignment::Center),
                    TextColumn::make('imdb_rating')
                        ->sortable()
                        ->color('rose')
                        ->weight(FontWeight::Bold)
                        ->alignment(Alignment::Center),
                    ImageColumn::make('images.image')
                        ->circular()
                        ->stacked()
                        ->wrap()
                        ->alignment(Alignment::Center),
                ])
            



            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
            GenresRelationManager::class,
            CountriesRelationManager::class

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovies::route('/'),
            'create' => Pages\CreateMovie::route('/create'),
            'edit' => Pages\EditMovie::route('/{record}/edit'),
        ];
    }
}
