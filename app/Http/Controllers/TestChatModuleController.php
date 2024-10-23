<?php

namespace App\Http\Controllers;

use Exception;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Str;
use App\Models\DetalleFV;
use App\Models\Flete;
use App\Models\Empleado;
use App\Models\Viatico;



use Illuminate\Http\Request;

class TestChatModuleController extends Controller
{

    public function Consultabot()
    {
        return view('chat');
    }

    public function chat(Request $request)
    {
        $prompt = strtolower($request->input('prompt'));
        // Verifica si el usuario está consultando análisis de gastos o ingresos
        if ($this->isAnalysisQuery($prompt)) {
            return $this->handleAnalysisQuery($prompt);
        }
        // Verifica si el usuario está consultando fletes
        if ($this->isFleteQuery($prompt)) {
            return $this->handleFleteQuery();
        }
        // Verifica si el usuario está consultando viáticos
        if ($this->isViaticoQuery($prompt)) {
            return $this->handleViaticoQuery();
        }
                // Verifica si el usuario está consultando registros por fecha, mes o año
        if ($this->isFechaQuery($prompt)) {
            return $this->handleFechaQuery($prompt);
        }
        // Verifica si el usuario hace una pregunta general
        if ($this->isGeneralQuery($prompt)) {
            return $this->handleGeneralQuery($prompt);
        }
        // Verifica si el usuario está saludando
        if ($this->isGreeting($prompt)) {
            return $this->handleGreeting();
        }
        $result = Gemini::geminiPro()->generateContent($request->input('prompt'));
        $result = $result->text();
        $result = Str::markdown($result);
        return response()->json(['result' => $result]);
    }

      // Método para verificar si el prompt es una pregunta general
    private function isGeneralQuery($prompt)
    {
        return Str::contains($prompt, ['qué puedes hacer', 'cuáles son tus funciones', 'qué funciones tienes','sobre que puedo consultar','Que puedo preguntar', 'fecha de hoy']);
    }  

    private function handleGeneralQuery($prompt)
    {
        if (Str::contains($prompt, 'qué puedes hacer')) {
            $result = "Puedo ayudarte con consultas sobre fletes, empleados, viáticos, y más. Solo pregunta.";
        } elseif (Str::contains($prompt, 'cuáles son tus funciones')|| Str::contains($prompt, 'qué funciones tienes')) {
            $result = "Mis funciones incluyen: consultar datos sobre fletes, empleados, viáticos y más.";
        } elseif (Str::contains($prompt, 'fecha de hoy')) {
            $result = "La fecha de hoy es: " . now()->toDateString();
        }
        else {
            $result = "Puedo responder preguntas generales, ayudarte con datos específicos sobre fletes,viaticos,operaciones,vehiculos, y más.";
        }

        return response()->json(['result' => $result]);
    }

    // Método para verificar si el prompt es un saludo
    private function isGreeting($prompt)
    {
        return Str::contains($prompt, ['hola', 'buenos días', 'buenas tardes', 'buenas noches', 'qué tal']);
    }
    // Método para manejar preguntas generales

    // Método para manejar saludos
    private function handleGreeting()
    {
        $greetings = [
            "¡Hola! ¿En qué puedo ayudarte hoy?",
            "¡Buenos días! ¿Cómo te ayudo?",
            "¡Hola! Estoy aquí para asistirte, ¿qué necesitas?"
        ];

        // Elegimos un saludo al azar
        $result = $greetings[array_rand($greetings)];

        return response()->json(['result' => $result]);
    }


    // Método para verificar si el prompt es una consulta de fletes
    private function isFleteQuery($prompt)
    {
        return Str::contains($prompt, ['Lista los fletes','Dame mi lista de fletes','lista de fletes', 'fletes que tengo', 'puedes darme la lista de fletes','fletes']);
    }
    // Método para manejar la consulta de fletes
    private function handleFleteQuery()
    {
        $fletes = Flete::where('estado', 1)->get(['nombre_flete', 'descripcion']);

        if ($fletes->isEmpty()) {
            $result = "No hay fletes disponibles en este momento.";
        } else {
            $result = "Aquí está la lista de fletes disponibles:\n";
            foreach ($fletes as $flete) {
                $result .= "- " . $flete->nombre_flete . ": " . $flete->descripcion . "\n";
            }
        }

        return response()->json(['result' => $result]);
    }


        // Método para verificar si el prompt es una consulta de viáticos
        private function isViaticoQuery($prompt)
        {
            return Str::contains($prompt, ['lista los viaticos','dame mi lista de viaticos','lista de viaticos', 'viáticos que tengo', 'puedes darme la lista de viaticos','viaticos']);
        }
    

        // Método para manejar la consulta de viáticos
        private function handleViaticoQuery()
        {
            // Obtiene los viáticos con estado activo (1)
            $viaticos = Viatico::where('estado', 1)->get(['nombre_viatico', 'descripcion']);

            if ($viaticos->isEmpty()) {
                $result = "No hay viáticos disponibles en este momento.";
            } else {
                $result = "Aquí está la lista de viáticos disponibles:\n";
                foreach ($viaticos as $viatico) {
                    $result .= "- " . $viatico->nombre_viatico . "    Descripcion: " . $viatico->descripcion .  "\n";
                }
            }
            return response()->json(['result' => $result]);
        }

        // Método para verificar si el prompt es una consulta por fecha, mes o año
        private function isFechaQuery($prompt)
        {
            return Str::contains($prompt, [
               'quiero saber sobre los registros en la fecha', 'registros en la fecha', 'operaciones en la fecha', 'movimientos en la fecha',
                'quiero saber sobre los registros en el mes','registros en el mes', 'operaciones en el mes', 'movimientos en el mes',"dame las operaciones del mes",
                'registros en el año', 'operaciones en el año', 'movimientos en el año'
            ]);
        }

        // Método para extraer la fecha de un prompt en formato YYYY-MM-DD
        private function extractFecha($prompt)
        {
            // Busca un patrón de fecha en el formato YYYY-MM-DD
            preg_match('/(\d{4}-\d{2}-\d{2})/', $prompt, $matches);
            return $matches[1] ?? null;  // Devuelve la fecha si la encuentra, o null si no
        }
        // Método para extraer el mes de un prompt (puede ser en número o nombre del mes)
// Método para extraer dos meses del prompt
        private function extractMes($prompt)
        {
            $meses = [];
            
            // Busca meses en formato numérico (ej. "mes 1" o "mes 2")
            preg_match_all('/mes (\d{1,2})/', $prompt, $matches);
            foreach ($matches[1] as $month) {
                $meses[] = intval($month);
            }

            // Busca meses en formato de texto (ej. "mes de enero")
            $nombresMeses = [
                'enero' => 1, 'febrero' => 2, 'marzo' => 3, 'abril' => 4, 
                'mayo' => 5, 'junio' => 6, 'julio' => 7, 'agosto' => 8, 
                'septiembre' => 9, 'octubre' => 10, 'noviembre' => 11, 'diciembre' => 12
            ];

            foreach ($nombresMeses as $nombreMes => $numeroMes) {
                if (Str::contains($prompt, $nombreMes)) {
                    $meses[] = $numeroMes;
                }
            }

            return array_unique($meses);  // Retorna meses únicos encontrados
        }
        // Método para extraer el año de un prompt
        private function extractAño($prompt)
        {
            // Busca un patrón de año en el formato YYYY
            preg_match('/año (\d{4})/', $prompt, $matches);
            return $matches[1] ?? null;  // Devuelve el año si lo encuentra, o null si no
        }
        // Método para manejar la consulta por fecha, mes o año
        private function handleFechaQuery($prompt)
        {
            // Inicializar variable para los detalles
            $detalleFV = collect(); // Crear una colección vacía para acumular resultados
        
            // Verifica si la consulta es por fecha específica en formato YYYY-MM-DD
            if (Str::contains($prompt, 'fecha')) {
                $fecha = $this->extractFecha($prompt);
                if ($fecha) {
                    $detalleFV = DetalleFV::with(['empleado', 'flete']) // Cargar relaciones necesarias
                        ->whereDate('fecha', $fecha)
                        ->where('estado', 1)
                        ->get();
                } else {
                    return response()->json(['result' => "Por favor, proporciona una fecha válida."]);
                }
            }
            // Verifica si la consulta es por mes específico
            elseif (Str::contains($prompt, 'mes')) {
                $mes = $this->extractMes($prompt);
                if ($mes) {
                    $detalleFV = DetalleFV::with(['empleado', 'flete']) // Cargar relaciones necesarias
                        ->whereMonth('fecha', $mes)
                        ->where('estado', 1)
                        ->get();
                } else {
                    return response()->json(['result' => "Por favor, proporciona un mes válido."]);
                }
            }
            // Verifica si la consulta es por año específico
            elseif (Str::contains($prompt, 'año')) {
                $año = $this->extractAño($prompt);
                if ($año) {
                    $detalleFV = DetalleFV::with(['empleado', 'flete']) // Cargar relaciones necesarias
                        ->whereYear('fecha', $año)
                        ->where('estado', 1)
                        ->get();
                } else {
                    return response()->json(['result' => "Por favor, proporciona un año válido."]);
                }
            } else {
                return response()->json(['result' => "No pude identificar la consulta."]);
            }
        
            // Procesar el resultado
            if ($detalleFV->isEmpty()) {
                return response()->json(['result' => "No se encontraron registros para la consulta."]);
            } else {
                $result = "Aquí están los registros:\n";
                foreach ($detalleFV as $detalle) {
                    $result .= "- Empleado: " . $detalle->empleado->nombres . ", Flete: " . $detalle->flete->nombre_flete . ", Fecha: " . $detalle->fecha . ", Importe: S/ " . $detalle->importe . "\n";
                }
                return response()->json(['result' => $result]);
            }
        }
        


        
    // Método para verificar si el prompt es una consulta de análisis de gastos o ingresos
    private function isAnalysisQuery($prompt)
    {
        return Str::contains($prompt, [
            'análisis de gastos', 
            'resumen de viáticos', 
            'consulta de operaciones', 
            'entre la fecha', 
            'entre el mes de'
        ]);
    }

        // Método para manejar la consulta de análisis de gastos o ingresos


    // Método para manejar la consulta de análisis de gastos o ingresos
private function handleAnalysisQuery($prompt)
{
    // Inicializar variables para las fechas
    $startDate = null;
    $endDate = null;

    // Verificar si el prompt incluye fechas
    if (Str::contains($prompt, 'entre la fecha')) {
        $dates = $this->extractFecha($prompt);
        $startDate = $dates['start'];
        $endDate = $dates['end'];
    } elseif (Str::contains($prompt, 'entre el mes')) {
        $meses = $this->extractMes($prompt);
        
        if (count($meses) == 2) {  // Asegúrate de que haya dos meses
            $startMonth = $meses[0];
            $endMonth = $meses[1];
            $startDate = now()->startOfYear()->month($startMonth)->format('Y-m-d');
            $endDate = now()->startOfYear()->month($endMonth)->endOfMonth()->format('Y-m-d');
        } else {
            return response()->json(['result' => "Por favor, especifica dos meses válidos."]);
        }
    } else {
        // Manejo por defecto (por ejemplo, valores predeterminados)
        $startDate = '2024-01-01';
        $endDate = '2024-12-31';
    }

    // Obtener los registros de DetalleFV
    $resultados = DetalleFV::with(['empleado', 'flete', 'viatico'])
        ->whereBetween('fecha', [$startDate, $endDate])  // Usar fechas dinámicas
        ->where('estado', 1)
        ->get()
        ->groupBy('idempleado');

    // Formateo de los resultados para ser retornados en el chat
    if ($resultados->isEmpty()) {
        return response()->json(['result' => "No se encontraron registros para el análisis solicitado."]);
    }

    $output = "Aquí está el análisis de gastos/ingresos entre $startDate y $endDate:\n";
    foreach ($resultados as $empleadoId => $detalles) {
        $empleado = Empleado::find($empleadoId);
        
        foreach ($detalles as $detalle) {
            $flete = Flete::find($detalle->idflete);
            $viatico = Viatico::find($detalle->idviatico);
            $tipoOperacion = $detalle->tipoIG == 1 ? 'Gasto' : 'Ingreso';
            
            $output .= "- Empleado: " . $empleado->apellidos . " " . $empleado->nombres . "\n";
            $output .= "  Flete: " . ($flete ? $flete->nombre_flete : 'N/A') . ", Viático: " . ($viatico ? $viatico->nombre_viatico : 'N/A') . "\n";
            $output .= "  Tipo de Operación: " . $tipoOperacion . ", Total Importe: S/ " . $detalle->importe . "\n";
        }
    }

    return response()->json(['result' => $output]);
}

}
