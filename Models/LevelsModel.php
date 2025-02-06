<?php
require_once("Infraestructure/LevelsInfraestructure.php");

class LevelsModel extends LevelsInfraestructure
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRequirementsClasification(int $idJugador)
    {
        return $this->getRequirementsClasificationBD($idJugador);
    }

    public function createRequirementClasification($postData, int $idJugador)
    {
        if (isset($postData['encryptedData'])) {
            $decryptedData = decryptData($postData['encryptedData']);
            $data = json_decode($decryptedData, true);
            // Validar y procesar los datos
            $es_ambiguo = isset($data['isAmbiguous']) && $data['isAmbiguous'] ? 1 : 0;
            $es_funcional = isset($data['isFunctional']) && $data['isFunctional'] ? 'funcional' : 'no_funcional';

            // Llamar a la función de base de datos con los datos procesados
            return $this->createRequirementClasificationBD(
                $idJugador,
                $data['description'] ?? '', // Descripción, se asegura de no ser nula
                $es_ambiguo,
                $data['feedback'] ?? '',    // Feedback, se asegura de no ser nulo
                $es_funcional
            );
        } else {
            return [
                'success' => false,
                'message' => 'Datos no recibidos',
            ];
        }
    }

    public function importRequirementsClasification($data, int $idJugador)
    {
        if (!isset($data['requirements']) || !is_array($data['requirements'])) {
            return [
                'success' => false,
                'message' => 'Datos de requisitos no válidos'
            ];
        }

        // Validar estructura de los requisitos
        foreach ($data['requirements'] as $req) {
            if (!$this->validateRequirementStructure($req)) {
                return [
                    'success' => false,
                    'message' => 'Estructura de requisito inválida'
                ];
            }
        }
        return $this->importRequirementsClasificationBD($idJugador, $data['requirements']);
    }

    private function validateRequirementStructure($requirement)
    {
        $requiredFields = ['descripcion', 'es_ambiguo', 'es_funcional', 'retroalimentacion'];

        foreach ($requiredFields as $field) {
            if (!isset($requirement[$field])) {
                return false;
            }
        }

        // Validar valores booleanos
        if (
            !in_array($requirement['es_ambiguo'], ['0', '1', 0, 1]) ||
            !in_array($requirement['es_funcional'], ['0', '1', 0, 1])
        ) {
            return false;
        }

        return true;
    }

    public function createGameClasification($postData, int $idJugador)
    {
        if (isset($postData['encryptedData'])) {
            $decryptedData = decryptData($postData['encryptedData']);
            $data = json_decode($decryptedData, true);
            $requirements = $data['requirements'];
            return $this->createGameClasificationBD($idJugador, $requirements);
        } else {
            return [
                'success' => false,
                'message' => 'Datos no recibidos',
            ];
        }
    }

    public function getRequirementsConstruction(int $idJugador)
    {
        return $this->getRequirementsConstructionBD($idJugador);
    }

    public function createRequirementConstruction($postData, int $idJugador)
    {
        if (isset($postData['encryptedData'])) {
            $decryptedData = decryptData($postData['encryptedData']);
            $data = json_decode($decryptedData, true);
            // Llamar a la función de base de datos con los datos procesados
            return $this->createRequirementConstructionBD(
                $idJugador,
                $data
            );
        } else {
            return [
                'success' => false,
                'message' => 'Datos no recibidos',
            ];
        }
    }

    public function importRequirementsConstruction($data, int $idJugador)
    {
        if (!isset($data['requirements']) || !is_array($data['requirements'])) {
            return [
                'success' => false,
                'message' => 'Datos de requisitos no válidos'
            ];
        }

        // Validar estructura de los requisitos
        foreach ($data['requirements'] as $req) {
            if (!$this->validateConstructionRequirementStructure($req)) {
                return [
                    'success' => false,
                    'message' => 'Estructura de requisito inválida'
                ];
            }
        }

        // Llamar a la función de infraestructura
        return $this->importRequirementsConstructionBD($idJugador, $data['requirements']);
    }

    private function validateConstructionRequirementStructure($requirement)
    {
        if (
            !isset($requirement['requisito_completo']) ||
            !isset($requirement['fragmentos'])
        ) {
            return false;
        }

        // Validar que haya al menos un fragmento válido
        $fragmentos = explode('¬', $requirement['fragmentos']);
        if (empty($fragmentos)) return false;

        foreach ($fragmentos as $fragmento) {
            $partes = explode('|', $fragmento);
            if (count($partes) !== 3) return false;

            // Validar formato de cada fragmento
            if (
                empty($partes[0]) || // texto
                !is_numeric($partes[1]) || // posición
                !in_array($partes[2], ['0', '1'])
            ) { // es_señuelo
                return false;
            }
        }

        return true;
    }

    public function createGameConstruction($postData, int $idJugador)
    {
        if (isset($postData['encryptedData'])) {
            $decryptedData = decryptData($postData['encryptedData']);
            $data = json_decode($decryptedData, true);
            $requirements = $data['requirements'];
            return $this->createGameConstructionBD($idJugador, $requirements);
        } else {
            return [
                'success' => false,
                'message' => 'Datos no recibidos',
            ];
        }
    }
}
