<?php

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Exports\UserExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Mpdf\Mpdf;

use function Illuminate\Support\now;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nombres')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Correo electrónico')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('roles.name')
                    ->label('Rol')
                    ->badge()
                    ->color('warning')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('is_active')
                    ->label("Estado")
                    ->badge()
                    ->icon(fn(bool $state) => $state ? Heroicon::CheckCircle : Heroicon::XCircle)
                    ->formatStateUsing(
                        fn(bool $state) => $state ? "Activo" : "Inactivo",
                    )
                    ->color(fn(bool $state) => $state ? "success" : "danger")
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Rol')
                    ->relationship('roles', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make("is_active")
                    ->label("Estado")
                    ->options([
                        1 => "Activo",
                        0 => "Inactivo",
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(UserExporter::class)
                    ->icon(Heroicon::ArrowDownTray)
                    ->label('Exportar Excel / CSV')
                    ->color('success'),

                Action::make('exportPdf')
                    ->label('Exportar PDF')
                    ->color('danger')
                    ->action(function (Table $table) {
                        try {
                            $query = $table->getLivewire()->getFilteredSortedTableQuery();
                            $users = $query->get();

                            $mpdf = new Mpdf([
                                'mode' => 'utf-8',
                                'format' => 'A4'
                            ]);

                            $mpdf->SetTitle('Reporte de usuarios');
                            $mpdf->SetAuthor('Nombre de la Institución');
                            $mpdf->SetDisplayMode('fullpage');
                            $mpdf->simpleTables = true;
                            $mpdf->packTableData = true;

                            $html = view('exports.pdf.users', compact('users'))->render();

                            $mpdf->WriteHTML($html);

                            $now = now()->format('d_m_Y-H_i_s');

                            return response()->streamDownload(
                                fn () => print($mpdf->Output('', 'S')),
                                'usuarios_' . $now . '.pdf'
                            );
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Error al exportar PDF')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ]);
    }
}
