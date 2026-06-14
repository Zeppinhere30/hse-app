<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_kategori')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('jenis_bahaya')
                    ->options([
                        'unsafe_act' => 'Unsafe Act (Tindakan Tidak Aman)',
                        'unsafe_condition' => 'Unsafe Condition (Kondisi Tidak Aman)',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('tingkat_risiko_default')
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kategori')->searchable(),
                Tables\Columns\TextColumn::make('jenis_bahaya')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unsafe_act' => 'warning',
                        'unsafe_condition' => 'danger',
                        default => 'primary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'unsafe_act' => 'Unsafe Act',
                        'unsafe_condition' => 'Unsafe Condition',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('tingkat_risiko_default')->searchable(),
            ])
            ->filters([])
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
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
