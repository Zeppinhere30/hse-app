<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncidentResource\Pages;
use App\Filament\Resources\IncidentResource\RelationManagers;
use App\Models\Incident;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IncidentResource extends Resource
{
    protected static ?string $model = Incident::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Informasi Utama')->schema([
                        Forms\Components\TextInput::make('kode_laporan')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->default(fn () => 'INC-' . date('YmdHis')), // Auto generate kode
                        Forms\Components\DateTimePicker::make('tanggal_kejadian')
                            ->required()
                            ->default(now()),
                        Forms\Components\Select::make('reporter_id')
                            ->relationship('reporter', 'name')
                            ->label('Nama Pelapor')
                            ->required(),
                        Forms\Components\Select::make('area_id')
                            ->relationship('area', 'nama_area')
                            ->label('Area Kejadian')
                            ->required(),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'nama_kategori')
                            ->label('Kategori Bahaya')
                            ->required(),
                        Forms\Components\TextInput::make('lokasi_spesifik')
                            ->required(),
                        Forms\Components\Textarea::make('deskripsi_temuan')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),
                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Status & Penanganan')->schema([
                        Forms\Components\Select::make('tingkat_keparahan')
                            ->options([
                                'Rendah' => 'Rendah',
                                'Sedang' => 'Sedang',
                                'Tinggi' => 'Tinggi',
                                'Kritis' => 'Kritis',
                            ])
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Baru' => 'Baru',
                                'Dalam Peninjauan' => 'Dalam Peninjauan',
                                'Sedang Diperbaiki' => 'Sedang Diperbaiki',
                                'Menunggu Validasi' => 'Menunggu Validasi',
                                'Selesai' => 'Selesai',
                            ])
                            ->default('Baru')
                            ->required(),
                        Forms\Components\Select::make('penanggung_jawab_id')
                            ->relationship('penanggungJawab', 'name')
                            ->label('Ditugaskan Kepada (Supervisor)'),
                    ]),
                ])->columnSpan(['lg' => 1]),

                Forms\Components\Section::make('Bukti Foto')
                    ->schema([
                        Forms\Components\Repeater::make('photos')
                            ->relationship()
                            ->schema([
                                Forms\Components\FileUpload::make('file_path')
                                    ->label('Upload Gambar')
                                    ->image()
                                    ->directory('incident-photos')
                                    ->required(),
                            ])
                            ->addActionLabel('Tambah Foto Bukti')
                            ->grid(2) // Membuat tampilannya menyamping
                    ])->columnSpanFull(),
            ])->columns(3);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_laporan')->searchable(),
                Tables\Columns\TextColumn::make('tanggal_kejadian')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('area.nama_area')->label('Area')->searchable(),
                Tables\Columns\TextColumn::make('category.nama_kategori')->label('Kategori'),
                Tables\Columns\TextColumn::make('tingkat_keparahan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Rendah' => 'success',
                        'Sedang' => 'warning',
                        'Tinggi' => 'danger',
                        'Kritis' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Baru' => 'gray',
                        'Dalam Peninjauan' => 'warning',
                        'Sedang Diperbaiki' => 'info',
                        'Menunggu Validasi' => 'primary',
                        'Selesai' => 'success',
                        default => 'gray',
                    }),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
           RelationManagers\CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncidents::route('/'),
            'create' => Pages\CreateIncident::route('/create'),
            'edit' => Pages\EditIncident::route('/{record}/edit'),
        ];
    }
}
