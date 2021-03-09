<?php

function formataDataUtcParaDatetime($dataUtc, $timezone = 'America/Sao_Paulo', $toFormat = 'd/m/Y H:i:s', $fromFormat = 'Y-m-d H:i:s')
{
    if ($dataUtc && is_numeric($dataUtc) && (int)$dataUtc > 0) { //TIMESTAMP
        $data = DateTime::createFromFormat('U', $dataUtc, new DateTimeZone('UTC'));
    } elseif ($dataUtc && is_string($dataUtc) && strlen($dataUtc) > 0) {
        $data = DateTime::createFromFormat($fromFormat, $dataUtc, new DateTimeZone('UTC'));
    } elseif ($dataUtc instanceof DateTime) {
        $data = $dataUtc;
    } else {
        $data = false;
    }
    if ($data) {
        $data->setTimeZone(new DateTimeZone($timezone));
        if ($toFormat) {
            return $data->format($toFormat);
        } else {
            return $data;
        }
    }
    return false;
}

function formataDataParaUtc($data, $timezone = "UTC", $toFormat = 'Y-m-d H:i:s', $fromFormat = 'd/m/Y H:i:s')
{
    $datetime = DateTime::createFromFormat($fromFormat, $data, new DateTimeZone($timezone));
    if ($datetime) {
        $datetime->setTimezone(new DateTimeZone('UTC'));
        if ($toFormat) {
            return $datetime->format($toFormat);
        } else {
            return $datetime;
        }
    }
    return false;
}

function formataDataSQL($colunaData)
{
    return "DATE_FORMAT(CONVERT_TZ($colunaData, '+00:00', '-03:00'), '%d/%m/%Y %H:%i:%s') AS $colunaData";
}

function formataHorarioParaSegundos($horario)
{
    $segundos = 0;
    $horario = explode(':', $horario);

    $segundos += ((int)$horario[0] * 60) * 60;
    $segundos += (int)$horario[1] * 60;
    $segundos += (int)$horario[2];

    return $segundos;
}

function somarHorario($tempo1, $tempo2)
{
    $segundos = 0;

    if (is_numeric($tempo1)) {
        $tempo1 = formataSegundosParaHorario($tempo1);
    }

    if (is_numeric($tempo2)) {
        $tempo2 = formataSegundosParaHorario($tempo2);
    }

    if (!$tempo1) {
        $tempo1 = "00:00:00";
    }

    if (!$tempo2) {
        $tempo2 = "00:00:00";
    }

    $tempo1 = explode(':', $tempo1);
    $tempo2 = explode(':', $tempo2);

    $segundos += ((int)$tempo1[0] * 60) * 60;
    $segundos += ((int)$tempo2[0] * 60) * 60;
    $segundos += (int)$tempo1[1] * 60;
    $segundos += (int)$tempo2[1] * 60;
    $segundos += (int)$tempo1[2];
    $segundos += (int)$tempo2[2];

    $hora = (int)($segundos / 3600);
    $minuto = (int)(($segundos % 3600) / 60);
    $segundo = (int)(($segundos % 3600) % 60);

    return ($hora < 10 ? '0'.$hora : $hora).':'.($minuto < 10 ? '0'.$minuto : $minuto).':'.($segundo < 10 ? '0'.$segundo : $segundo);
}


function formataSegundosParaHorario($segundos = 0)
{
    if (is_numeric($segundos) && (int)$segundos > 0) {
        $hora = (int)($segundos / 3600);
        $minuto = (int)(($segundos % 3600) / 60);
        $segundo = (int)(($segundos % 3600) % 60);
        return ($hora < 10 ? '0'.$hora : $hora).':'.($minuto < 10 ? '0'.$minuto : $minuto).':'.($segundo < 10 ? '0'.$segundo : $segundo);
    } else {
        return '00:00:00';
    }
}



function calculaDiferencaData($data1, $data2)
{
    $data1 = formataDataParaUtc($data1, 'UTC', false);
    $data2 = formataDataParaUtc($data2, 'UTC', false);
    if ($data1 && $data2) {
        $diferenca = $data1->getTimestamp() - $data2->getTimestamp();

        if ($diferenca < 0) {
            $diferenca *= -1;
        }

        return formataSegundosParaHorario($diferenca);
    }
    return '00:00:00';
}

function calculaDiferencaHorario($horaInicial, $horaFinal, $returnHorario = true)
{
    if (is_numeric($horaInicial)) {
        $horaInicial = formataSegundosParaHorario($horaInicial);
    }

    if (is_numeric($horaFinal)) {
        $horaFinal = formataSegundosParaHorario($horaFinal);
    }

    $horaInicial = explode(':', $horaInicial);
    $horaFinal = explode(':', $horaFinal);

    $segundosInicial = 0;
    $segundosFinal = 0;

    $segundosInicial += ((int)$horaInicial[0] * 60) * 60;
    $segundosInicial += (int)$horaInicial[1] * 60;
    $segundosInicial += (int)$horaInicial[2];

    $segundosFinal +=  ((int)$horaFinal[0] * 60) * 60;
    $segundosFinal += (int)$horaFinal[1] * 60;
    $segundosFinal += (int)$horaFinal[2];


    $diferencaSegundos = (int)$segundosFinal -  (int)$segundosInicial;
    
    if ($diferencaSegundos < 0) {
        $diferencaSegundos = $diferencaSegundos * -1;
    }
    $hora = (int)($diferencaSegundos / 3600);
    $minuto = (int)(($diferencaSegundos % 3600) / 60);
    $segundo = (int)(($diferencaSegundos % 3600) % 60);

    if ($returnHorario) {
        return ($hora < 10 ? '0'.$hora : $hora).':'.($minuto < 10 ? '0'.$minuto : $minuto).':'.($segundo < 10 ? '0'.$segundo : $segundo);
    }
    return $diferencaSegundos;
}



function validarId($idOuArrayAssoc = null, $chave = null)
{
    if (is_array($idOuArrayAssoc)) {
        if (isset($idOuArrayAssoc[$chave]) && $idOuArrayAssoc[$chave] && is_numeric($idOuArrayAssoc[$chave]) && (int)$idOuArrayAssoc[$chave] > 0) {
            return true;
        }
    } elseif ($idOuArrayAssoc && is_numeric($idOuArrayAssoc) && (int)$idOuArrayAssoc > 0) {
        return true;
    }

    return false;
}

function validarString($idOuArrayAssoc = null, $chave = null)
{
    if (is_array($idOuArrayAssoc)) {
        if (isset($idOuArrayAssoc[$chave]) &&
            $idOuArrayAssoc[$chave] &&
            is_string($idOuArrayAssoc[$chave]) &&
            strlen($idOuArrayAssoc[$chave]) > 0) {
            return true;
        }
    } elseif ($idOuArrayAssoc && is_string($idOuArrayAssoc) && strlen($idOuArrayAssoc) > 0) {
        return true;
    }

    return false;
}

function getContents($paramentro = false)
{
    $contents = null;

    switch (strtolower($_SERVER['REQUEST_METHOD'])) {
        case 'delete':
        case 'get':
            $contents = $_GET;
            break;

        case 'post':
        case 'put':
            $contents = $_POST;
            if (!is_array($contents) || count($contents) <= 0) {
                parse_str(file_get_contents("php://input"), $contents);
            }
            break;
    }

    if ($contents && is_array($contents) && count($contents) > 0) {
        if ($paramentro && strlen($paramentro) > 0) {
            if (isset($contents[$paramentro])) {
                return $contents[$paramentro];
            } else {
                return false;
            }
        }
        return $contents;
    }
    return false;
}

function send($statusCode = 200, $data = null, $message = null, $tag = null)
{
    $statusTexts = array(
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    );
    $params = [];
    if (is_array($data)) {
        $params = $data;
    } else {
        $params['status'] = true;
    }
    if ($message) {
        $params["message"] = $message;
    }
    if ($tag) {
        $params["tag"] = $tag;
    }

    header("HTTP/1.1 $statusCode $statusTexts[$statusCode]");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
    header('Access-Control-Allow-Methods: GET,OPTIONS,POST,PUT,DELETE');
    header('Content-Type: application/json');

    if (count($params)) {
        echo json_encode($params);
    }
    die;
}
