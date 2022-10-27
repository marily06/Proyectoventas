<?php

use App\Models\Configuration;
use App\Models\Option;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Extenciones\NumeroALetras;
use Illuminate\Support\Facades\File;


/**
 * Crea un array de elmentos en base a un modelo
 * Para agregarlo como parametro de un select html de colective
 * @param $model
 * @param string $label
 * @param string $id
 * @param string $defaultValue
 * @param string $defaultKey
 * @return array
 */
function select($model, $label='nombre', $id='id', $defaultValue='SELECCIONE UNO...', $defaultKey='')
{

    if ($model instanceof Builder) {

        $options = $model->get()->pluck($label, $id)->toArray();
    } else {
        $options = $model::all()->pluck($label, $id)->toArray();
    }


    if (!is_null($defaultValue)) {
        $options = Arr::prepend($options, $defaultValue, $defaultKey);
    }
    return $options;
}


/**
 * Convierte una plantilla .docx a pdf
 * @param $pathTemplate
 * @param $data
 * @param null $fileName
 * @param string $outDir
 * @return string
 * @throws \PhpOffice\PhpWord\Exception\CopyFileException
 * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
 */
function templateToPdf($pathTemplate, $data,$fileName=null,$outDir="/temp"){

    // PROCESA EL TEMPLATE EN DOCX
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($pathTemplate);


    foreach ($data as $index => $dato) {
        $templateProcessor->setValue($index, $dato);
    }

    $ArgOutDir='--outdir '.public_path().$outDir;


    if (is_null($fileName)){
        $fileName = Auth::user()->usuario_dominio."_".Carbon::now()->format('d_m_Y_H_i_s');
    }

    $saveAs = "templateToPdf/".$fileName.".docx";

    // GUARDA EL NUEVO ARCHIVO DOCX
    $templateProcessor->saveAs($saveAs);

    $pathNewDocx = public_path().'/'.$saveAs;

    // :::: LINUX ::::
    $command = 'export HOME=/tmp && soffice --headless --convert-to pdf "'.$pathNewDocx.'" '.$ArgOutDir;

    // :::: WINDOWS ::::
    if (PHP_OS=='WINNT'){
        $command = 'start /wait soffice --headless --convert-to pdf "'.$pathNewDocx.'" '.$ArgOutDir;
    }


    try {

        shell_exec($command);
//        unlink($pathNewDocx);
        $pathNewPdf = $outDir."/".$fileName.".pdf";

    } catch (\Exception $exception) {

        throw new  Exception($exception);
    }


    return $pathNewPdf;
}


/**
 * Devuelve el nombre del mes
 * @param null $mes
 * @return mixed
 */
function mesLetras($mes=null){
    $meses = ["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"];

    return strtoupper($meses[$mes-1]);
}

/**
 * Devuelve el año actual en numeros
 * @return string
 */
function anioActual(){
    return Carbon::now()->format('Y');
}


/**
 * Devuelve el dia actual en numeros
 * @return string
 */
function diaActual(){
    return Carbon::now()->format('d');
}


/**
 * Convierte un numero a letras
 * @param $numero
 * @return string
 */
function numAletras($numero,$moneda=null,$centimos=null){
    return NumeroALetras::convertir($numero,$moneda,$centimos);
}

/**
 * Devuelve la fecha actual en formato ingles o latino
 * @param string $fomato
 * @return string
 */
function fechaActual($fomato='es'){
    if ($fomato=='en'){
        return Carbon::now()->format('Y-m-d');
    }

    return Carbon::now()->format('d/m/Y');
}

function fechaActualLetras(){
    list($dia,$mes,$anio)=explode("/",fechaActual());

    return numAletras($dia)." DE ".mesLetras($mes)." DEL ".numAletras($anio);
}

/**
 * Valida si la ruta actual es la que se envía compo parametro
 * @param $routeName
 * @return bool
 */
function routeIs($routeName){
    return request()->route()->getName() == $routeName ? true : false;
}


/**
 * Return el porcentaje, validando no division cero
 * @param $value1, $valueTotal
 * @return string
 */
function porcentaje($value1, $valueTotal){
    return ($valueTotal>0)? number_format($value1 * 100 / $valueTotal, 2) : 0;
}


/**
 * Convierte una fecha en formato latino
 * @param string $fecha
 * @return string
 */
function fechaLtn(string $fecha=null){

    return $fecha ? Carbon::parse($fecha)->format('d/m/Y') : '';
}


function rutaOpcion($opcion){
    try{
        return route($opcion->ruta.'');
    }catch (\Exception $e){
        return route('admin.home');
    }
}


function optionsParentAuthUser($user = null){
    $authUser = $user ?? Auth::user();

//    $allOptions = $authUser->options;
    $allOptions = $authUser->getAllOptions();

    $optionParent = $allOptions->filter(function ($op){
        return is_null($op->option_id);
    });



    $childres = $allOptions->filter(function ($op){
        return !is_null($op->option_id);
    })->pluck('id')->toArray();

    $options = Option::padresDe($childres)->with('children')->get();

    $options = $optionParent->merge($options)->sortBy('orden');

    return $options;

}

function getLogo($conversion='webp'){

    /**
     * @var Configuration $config
     */
    $config = Configuration::find(Configuration::LOGO);

    $media = $config->getMediaLogo();

    return $media ? $media->getUrl($conversion) : asset('img/default.svg');
}

function getFondoLogin($conversion=''){

    /**
     * @var Configuration $config
     */
    $config = Configuration::find(Configuration::FONDO_LOGIN);

    $media = $config->getMediaFondoLogin();

    return $media ? $media->getUrl($conversion) : asset('img/default.svg');
}



function getIcono($conversion=''){

    /**
     * @var Configuration $config
     */
    $config = Configuration::find(Configuration::ICONO);

    $media = $config->getMediaIcono();

    return $media ? $media->getUrl($conversion) : asset('img/default.svg');
}

function appIsDebug(){
    return (boolean) json_decode(strtolower(config('app.debug')));
}


/**
 * Devuelve el símbolo de la moneda que esta guardada en las variables de configuración en la tabla configurations
 * @return \Illuminate\Config\Repository|mixed
 */
function dvs(){
    return config('app.divisa') ?? "$";
}

/**
 * Formatea los números de cantidades con separador de miles, separador decimales y cantidad de decimales mediante llaves de configuración
 */
function nf($numero,$cantidad_decimales=null,$separador_decimal=null,$separador_miles=null){

    $cantidad_decimales = $cantidad_decimales ?? config('app.cantidad_decimales');
    $separador_decimal = $separador_decimal ?? config('app.separador_decimal');
    $separador_miles = $separador_miles ?? config('app.separador_miles');

    return number_format($numero,$cantidad_decimales,$separador_decimal,$separador_miles);
}

/**
 * Formatea los números de precios con separador de miles, separador decimales y cantidad de decimales mediante llaves de configuración
 */
function nfp($numero,$cantidad_decimales=null,$separador_decimal=null,$separador_miles=null){


    $cantidad_decimales = $cantidad_decimales ?? config('app.cantidad_decimales_precio');
    $separador_decimal = $separador_decimal ?? config('app.separador_decimal');
    $separador_miles = $separador_miles ?? config('app.separador_miles');

    return number_format($numero,$cantidad_decimales,$separador_decimal,$separador_miles);
}

/**
 * @param \Illuminate\Database\Eloquent\Collection $items
 * @param $items
 * @param $id
 * @return null
 */
function validaChecked($items,$id){
    if (!$items){
        return null;
    }


    if ($items->contains('id',$id)){
        return 'checked';
    }else{
        return null;
    }

}

function prefijoCeros($numero,$cantidadCeros){
    return str_pad($numero,$cantidadCeros,"0",STR_PAD_LEFT);
}

function generarManifest()
{

    $iconos = collect();

    /**
     * @var Configuration $config
     */
    $config = Configuration::find(Configuration::ICONO);

    $media = $config->getMediaIcono();

    if ($media){

        foreach ($media->getMediaConversionNames() as $index => $conversionName) {

            $pathIcon = "storage/".$media->id."/conversions/".$media->name."-".$conversionName.".".$media->getExtensionAttribute();

            $new = [
                "src" => $pathIcon,
                "type" => "image/png",
                "sizes" => $conversionName
            ];

            $iconos->push($new);
        }
    }


    $json = Collection::make([
        "short_name" => config('app.name'),
        "name" => config('app.name'),
        "background_color" => "#007BFF",
        "orientation" => "portrait",
        "theme_color" => "#007BFF",
        "icons" => $iconos,
        "start_url" => "/",
        "display" => "standalone"
    ])->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    File::put(public_path('manifest.json'),$json);
}

function getLenguajeActualDesc(){

    $idiomas = [
        'es' => 'Spanish',
        'en' => 'English',
    ];

    $actual = app()->getLocale();

    return __($idiomas[$actual]);
}

function autoIncrementFaker()
{
    for ($i = 0; $i < 1000; $i++) {
        yield $i;
    }
}

function separaNombreCompleto($nombre_completo){

    $nombres = explode(' ',$nombre_completo,3);

    if(count($nombres)==1){
        return [$nombres[0],''];
    }
    elseif(count($nombres)>2){
        return [$nombres[0]." ".$nombres[1],$nombres[2]];
    }else{
        return $nombres;
    }

}

/**
 * Cambia el formato de una fecha d/m/Y a Y-m-d
 * @param null $fecha
 * @param string $separador el de la fecha introducida
 * @param string $divisor el de la fecha a devolver
 * @return null|string
 */
function fechaDb($fecha=NULL, $separador='/', $divisor="-"){

    if(is_null($fecha))
        return NULL;

    $tmp=explode("$separador",$fecha);

    return $tmp[2].$divisor.$tmp[1].$divisor.$tmp[0];
}

/**
 * Cambia el formato de una fecha Y-m-d a d/m/Y
 * @param null $fecha
 * @param string $separador el de la fecha introducida
 * @param string $divisor el de la fecha a devolver
 * @return null|string
 */
function fecha($fecha=NULL, $separador='-', $divisor="/"){

    if(is_null($fecha))
        return NULL;

    $tmp=explode("$separador",$fecha);

    return $tmp[2].$divisor.$tmp[1].$divisor.$tmp[0];
}

/**
 * Devuelve la fecha de hoy en formato config('app.timezone' 'd/m/Y'
 * @return string
 */
function hoy(){

    return \Carbon\Carbon::now(config('app.timezone'))->format('d/m/Y');
}

/**
 * Devuelve la fecha de hoy en formato config('app.timezone' 'd/m/Y'
 * @return string
 */
function hoyYmas($dias){

    return \Carbon\Carbon::now(config('app.timezone'))->addDays($dias)->format('d/m/Y');
}

/**
 * Devuelve la fecha de hoy en formato config('app.timezone' 'Y-m-d' para guardar en la base de datos
 * @return string
 */
function hoyDb($diasExtras=null){

    $fecha = Carbon::now(config('app.timezone'));

    if(isset($diasExtras)){
        $fecha->addDay($diasExtras);
    }

    return $fecha->format('Y-m-d');
}


function diasMes($anio=0,$mes=0){

    if(!$mes && !$anio)
        return false;

    return cal_days_in_month ( CAL_GREGORIAN , $mes , $anio );

}

function diasMesActual(){

    $fechaActual= hoy();

    list($dia,$mes,$anio)=explode('/',$fechaActual);

    return diasMes($anio,$mes);

}

function arrayDias(){
    $dias=['domingo','lunes','martes','miércoles','jueves','viernes','sábado','domingo',];

    return $dias;
}

function diaLetras($dia=NULL){
    if(is_null($dia))
        return 'día invalido';

    $dias=arrayDias();

    return $dias[$dia];
}


/**
 * Devuelve la fecha y hora actual en el formato necesario para guardar en la base de datos (Y-m-d h:m:s)
 * @return string
 */
function fechaHoraActualDb(){
    return Carbon::now()->toDateTimeString();
}

/**
 * Devuelve la fecha y hora actual en formato 'd/m/Y H:m:s'
 * @return string
 */
function fechaHoraActual(){

    return Carbon::now()->format('d/m/Y H:i:s');
}

/**
 * Elimina los ceros decimales de un numero
 * @return string
 */
function noCerosDecimales($numero){

    list($entero,$decimal)=explode('.',$numero);

    return ($decimal>0) ? $numero : $entero;
}

/**
 * Convierte un archivo a su valor binario
 * @param $file
 * @return mixed
 */
function fileToBinary($file){
    return $file->openFile()->fread($file->getSize());
}

/**
 * Devuelve el src para etiqueta <img> en base a imágenes binarias
 * @param $img
 * @return string
 */
function srcImgBynary($img){
    return "data:".$img->type.";base64,".base64_encode($img->data);
}

/**
 * Format bytes to kb, mb, gb, tb
 *
 * @param  integer $size
 * @param  integer $precision
 * @return integer
 */
function formatBytes($size, $precision = 2)
{
    if ($size > 0) {
        $size = (int) $size;
        $base = log($size) / log(1024);
        $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    } else {
        return $size;
    }
}

function diasEntreFechas($fini,$ffin){
    $datetime1 = new DateTime($fini);
    $datetime2 = new DateTime($ffin);
    $interval = $datetime1->diff($datetime2);

//    return $interval->format('%R%a');
    return $interval->format('%a');
}

function fechaExpiraLicencia(){
    $licencia = \App\Models\Licencia::first();

    return is_null($licencia) ? null : $licencia->fecha_expira;
}

function diasRestanteLicencia(){

    return diasEntreFechas(hoyDb(),fechaExpiraLicencia());
}

function licenciaEsPrueba(){
    $licencia = \App\Models\Licencia::first();

    return is_null($licencia) ? false : $licencia->prueba;
}

function diaSemana($fecha){
    $f=Carbon::parse($fecha);

    return diaLetras($f->dayOfWeek);
}

function fechaHoraLtn($fecha){

    return date('d/m/Y H:i:s A',strtotime($fecha));
}

function mesActual(){

    $fechaActual= hoy();

    list($dia,$mes,$anio)=explode('/',$fechaActual);

    return $mes;

}

function mesActualLtr(){
    return mesLetras(mesActual());
}

function iniMes(){

    list($dia,$mes,$anio)=explode('/',hoy());

    return '01/'.$mes.'/'.$anio;
}

function iniMesDb(){

    list($dia,$mes,$anio)=explode('/',hoy());

    return $anio.'-'.$mes.'-01';
}

function mesActualBetween(){
    $del = Carbon::createFromFormat('Y-m-d H:i:s', iniMesDb().'00:00:00');
    $al = Carbon::createFromFormat('Y-m-d H:i:s', fechaHoraActualDb());

    return [$del,$al];
}

function delAlBetween($del,$al){
    $del = Carbon::createFromFormat('Y-m-d H:i:s', fechaDb($del).'00:00:00');
    $al = Carbon::createFromFormat('Y-m-d H:i:s', fechaDb($al).Carbon::now()->format('H:i:s'));

    return [$del,$al];
}

function formatVueSelect($collection,$label='name'){

    $collection = $collection->map(function ($item) use ($label){

        $item = $item->toArray();
        return [
            'label' => $item[$label],
            'id' => $item['id']
        ];
    });

    return json_encode($collection);
}

function mailsAdmins(){

    $mails = [];

    //recorrido de todos los usuarios admin
    foreach (User::admins()->get() as $index => $u) {
        if($u->email){
            $mails[]= $u->email;
        }
    }

    return $mails;
}

function ceros($numero,$cantidadCeros){
    return str_pad($numero,$cantidadCeros,"0",STR_PAD_LEFT);
}

function errorException(Exception $exception){

    /**
     * @var User $user
     */
    $user = auth()->user() ?? auth('api')->user();

    if ($user->can('depurar')){
        throw $exception;
    }

    $msg = $user->isSuperAdmin() ? $exception->getMessage() : 'Hubo un error intente de nuevo';

    flash($msg)->error()->important();
}

function existeCredencialesSat(){
    return config('app.sat_avuser')!='' && config('app.sat_avpass')!='' && config('app.sat_dtepass');
}

function colorComaraStocks($valor){


    switch ($valor){
        case 2:
            return 'success';
            break;
        case 1:
            return 'warning';
            break;
        case 0:
            return 'danger';
            break;
    }
}

function textComparaStocks($valor){

    switch ($valor){
        case 2:
            return 'Bueno';
            break;
        case 1:
            return 'Malo';
            break;
        case 0:
            return 'Muy Malo';
            break;
    }
}

function getSloganNegocio(){
    return config('app.slogan_negocio');
}

function getNombreNegocio(){
    return config('app.nombre_negocio');
}

function getPbx(){
    return config('app.telefono_negocio');
}

function getCorreoNegocio(){
    return config('app.correo_negocio');
}

function getDireccionNegocio(){
    return config('app.direccion_negocio');

}


function generaNombreUsuario($nombreCompleto){

    $nombres = separaNombreCompleto($nombreCompleto);

    $primerNombre = explode(" ",$nombres[0])[0];
    $primerApellido = explode(" ",$nombres[1])[0];

    $numeroAleatorio = rand(1,99);
    $nombreUser = $primerNombre[0].$primerApellido.$numeroAleatorio;

    return mb_strtolower(eliminar_acentos($nombreUser));

}

function eliminar_acentos($cadena){

    //Reemplazamos la A y a
    $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
    );

    //Reemplazamos la E y e
    $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena );

    //Reemplazamos la I y i
    $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena );

    //Reemplazamos la O y o
    $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena );

    //Reemplazamos la U y u
    $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena );

    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç'),
        array('N', 'n', 'C', 'c'),
        $cadena
    );

    return $cadena;
}

/**
 * @throws Exception
 */
function manejarExcepcion(Exception $exception){

    /**
     * @var User $user
     */
    $user = auth()->user() ?? auth('api')->user() ?? new User();

    if ($user->can('depurar')){
        throw $exception;
    }

    $msg = $user->isSuperAdmin() ? $exception->getMessage() : 'Hubo un error intente de nuevo';

    flash($msg)->error()->important();
}
