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

        // Verifica si el usuario está consultando fletes
        if ($this->isFleteQuery($prompt)) {
            return $this->handleFleteQuery();
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
        return Str::contains($prompt, ['lista de fletes', 'fletes que tengo', 'puedes darme la lista de fletes','fletes']);
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
}
