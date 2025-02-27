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

class ProductsResource extends Resource
{
    protected static ?string $model = Products::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Product Name
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                // Sizes (nullable JSON)
                Forms\Components\Textarea::make('sizes')
                    ->nullable() // Allow null
                    ->json(), // Allow JSON input for sizes

                // Lengths (nullable JSON)
                Forms\Components\Textarea::make('lengths')
                    ->nullable() // Allow null
                    ->json(), // Allow JSON input for lengths

                // Weight
                Forms\Components\TextInput::make('weight')
                    ->required()
                    ->maxLength(255),

                // Carat Selection (18 or 21)
                Forms\Components\Select::make('carat')
                    ->options([
                        '18' => '18 Carat',
                        '21' => '21 Carat',
                    ])
                    ->required()
                    ->placeholder('Select Carat'),

                // Multiple Photos Upload
                Forms\Components\FileUpload::make('images') // Use 'images' to store multiple photos
                    ->multiple() // Allow multiple files
                    ->image()
                    ->directory('products')
                    ->disk('public')
                    ->maxSize(20480) // 20MB in KB
                    ->rules(['image', 'max:20480']), // Validate image size

                // Category Selection
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
                Tables\Columns\TextColumn::make('carat') // Display Carat
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('images') // Display multiple images
                    ->disk('public')
                    ->stacked() // Stack images vertically
                    ->limit(3) // Limit the number of images displayed
                    ->circular(), // Optional: Display images in a circular format
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