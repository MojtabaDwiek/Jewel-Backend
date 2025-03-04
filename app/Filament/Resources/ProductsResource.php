<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductsResource\Pages;
use App\Models\Products;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;

class ProductsResource extends Resource
{
    protected static ?string $model = Products::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('sizes')
                    ->nullable()
                    ->json(),
                Forms\Components\Textarea::make('lengths')
                    ->nullable()
                    ->json(),
                Forms\Components\TextInput::make('weight')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('carat')
                    ->options([
                        '18' => '18 Carat',
                        '21' => '21 Carat',
                    ])
                    ->required()
                    ->placeholder('Select Carat'),
                Forms\Components\FileUpload::make('images')
                    ->multiple()
                    ->image()
                    ->directory('products')
                    ->disk('public')
                    ->maxSize(20480)
                    ->rules(['image', 'max:20480']),
                Forms\Components\Select::make('category')
                    ->options([
                        'كسر شفت' => 'كسر شفت',
                        'تعاليق' => 'تعاليق',
                        'غورميت' => 'غورميت',
                        'فرنكات' => 'فرنكات',
                        'تركي' => 'تركي',
                        'ليزر' => 'ليزر',
                        'خواتم' => 'خواتم',
                        'Special' => 'Special',
                    ])
                    ->required()
                    ->placeholder('Select a category'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sizes')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lengths')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('weight')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('carat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('images')
                    ->label('Images')
                    ->formatStateUsing(function ($state) {
                        $images = json_decode($state, true);
                        $html = '';
                        foreach ($images as $image) {
                            $url = Storage::disk('public')->url($image);
                            $html .= "<img src='$url' alt='Image' style='width: 50px; height: 50px; margin-right: 5px;'>";
                        }
                        return $html;
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProducts::route('/create'),
            'edit' => Pages\EditProducts::route('/{record}/edit'),
        ];
    }
}