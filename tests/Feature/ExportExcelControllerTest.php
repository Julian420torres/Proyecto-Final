<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Controllers\ExportExcelController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportExcelControllerTest extends TestCase
{
    /** @test */
    public function export_excel_controller_retorna_un_archivo()
    {
        // Instanciar directamente el controlador
        $controller = new ExportExcelController();

        // Ejecutar el método
        $response = $controller->exportExcelVentasAll();

        // Verificar que la respuesta es un archivo para descargar
        $this->assertInstanceOf(BinaryFileResponse::class, $response);

        // Validar que contiene el nombre del archivo
        $this->assertStringContainsString(
            'ventas.xlsx',
            $response->headers->get('content-disposition')
        );

        // No validamos content-type aquí porque Laravel no lo setea en este flujo
    }
}
